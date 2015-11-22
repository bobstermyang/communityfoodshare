<?php

/**
 * Calls the class on the company post edit screen.
 */
function call_companyMetabox() {
    new companyMetabox();
}

if ( is_admin() ) {
    add_action( 'load-post.php', 'call_companyMetabox' );
    add_action( 'load-post-new.php', 'call_companyMetabox' );
}

/** 
 * The Grocery Metabox Class.
 */
class companyMetabox {

	/**
	 * Hook into the appropriate actions when the class is constructed.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

	/**
	 * Adds the meta box container.
	 */
	public function add_meta_box( $post_type ) {
		$post_types = array('company', 'team');     //limit meta box to certain post types
		if ( in_array( $post_type, $post_types )) {
			add_meta_box(
				'_company_metabox_callback'
				,'General Info'
				,array( $this, 'render_meta_box_content' )
				,$post_type
				,'advanced'
				,'high'
			);
		}
	}

	/**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public function save( $post_id ) {
	
		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['cfs_nonce'] ) )
			return $post_id;

		$nonce = $_POST['cfs_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'cfs_company_metabox' ) )
			return $post_id;

		// If this is an autosave, our form has not been submitted,
                //     so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		// Check the user's permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ){
				return $post_id;
		}

		/* OK, its safe for us to save the data now. */

		// Sanitize the user input.
		$user_id = sanitize_text_field( $_POST['cfs_users'] );
		$goal = sanitize_text_field( $_POST['donation_goal'] );

		// Update the meta field.
		update_post_meta( $post_id, '_donation_goal', $goal );
		
		remove_action( 'save_post', array( $this, 'save' ) );
		// Update the meta field.
		wp_update_post(array(
			'ID'	=>	$post_id,
			'post_author'	=>	$user_id
		));
		add_action( 'save_post', array( $this, 'save' ) );
	}


	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_meta_box_content( $post ) {
	
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'cfs_company_metabox', 'cfs_nonce' );

		// Use get_post_meta to retrieve an existing value from the database.
		$_no_of_employees = get_post_meta( $post->ID, '_no_of_employees', true );
		$_company_goal = get_post_meta( $post->ID, '_company_goal', true );
		$_contact_email = get_post_meta( $post->ID, '_contact_email', true );
		$_contact_number = get_post_meta( $post->ID, '_contact_number', true );

		// Display the form, using the current value.
		
		echo '<label>No of Employees</label>';
		echo '<input type="text" id="_no_of_employees" name="_no_of_employees"';
                echo ' value="' . esc_attr( $_no_of_employees ) . '" size="25" /><br />';
		
		echo '<label>Donation Goal Amount</label>';
		echo '<input type="text" id="_company_goal" name="_company_goal"';
                echo ' value="' . esc_attr( $_company_goal ) . '" size="25" />$<br />';
		
		echo '<label>Primary Contact Email</label>';
		echo '<input type="text" id="_contact_email" name="_contact_email"';
                echo ' value="' . esc_attr( $_contact_email ) . '" size="25" /><br />';
		
		echo '<label>Primary Phone Number</label>';
		echo '<input type="text" id="_contact_number" name="_contact_number"';
                echo ' value="' . esc_attr( $_contact_number ) . '" size="25" /><br />';
		
	}
}