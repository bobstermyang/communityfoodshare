<?php

/**
 * Calls the class on the grocery post edit screen.
 */
function call_groceryMetabox() {
    new groceryMetabox();
}

if ( is_admin() ) {
    add_action( 'load-post.php', 'call_groceryMetabox' );
    add_action( 'load-post-new.php', 'call_groceryMetabox' );
}

/** 
 * The Grocery Metabox Class.
 */
class groceryMetabox {

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
		add_meta_box(
			'_grocery_metabox_callback'
			,'Grocery Price'
			,array( $this, 'render_meta_box_content' )
			,'grocery'
			,'advanced'
			,'high'
		);
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
		if ( ! wp_verify_nonce( $nonce, 'cfs_metabox' ) )
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
		$data = sanitize_text_field( $_POST['grocery_price'] );

		// Update the meta field.
		update_post_meta( $post_id, '_price', $data );
	}


	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_meta_box_content( $post ) {
	
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'cfs_metabox', 'cfs_nonce' );

		// Use get_post_meta to retrieve an existing value from the database.
		$value = get_post_meta( $post->ID, '_price', true );

		// Display the form, using the current value.
				
		echo '<input type="text" id="grocery_price" name="grocery_price"';
                echo ' value="' . esc_attr( $value ) . '" size="25" />$';
	}
}