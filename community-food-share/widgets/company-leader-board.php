<?php
/**
 * Adds Company_Leader_Widget widget.
 */
class Company_Leader_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'company_leader_Widget', // Base ID
			'Company Leader', // Name
			array( 'description' => 'Display Top Donator Company', ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		echo $instance['no'];
		echo $args['after_widget'];
	}
/*
 *	Display company list
 *
 */

	public function display_company(){
		
      $args=array(
        'post_type' => 'company',
        'post_status' => 'publish', 
      );
	  
      $company_list = array();
      $wp_query = new WP_Query($args);
      
      if( $wp_query->have_posts() ) {
            while ($wp_query->have_posts()) : $wp_query->the_post();
                  $user_info = get_userdata($wp_query->post->post_author);
                  $userName = $user_info->display_name;
                  if($user_info->first_name != ''){
                        $userName = $user_info->first_name .' '.$user_info->last_name;
                  }
                  $company_list['data'][] = array(
                        'id'    =>    $wp_query->post->ID,
                        'name'    =>  $wp_query->post->post_title,
                        'owner'   =>  $userName 
                  );        
            endwhile;
            $company_list['found_posts'] = $wp_query->found_posts;
      }
      wp_reset_query();		
	}
	
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title' );
		$no = ! empty( $instance['no'] ) ? $instance['no'] : '';
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'no' ); ?>"><?php _e( 'Total no of display company:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'no' ); ?>" name="<?php echo $this->get_field_name( 'no' ); ?>" type="text" value="<?php echo esc_attr( $no ); ?>">
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['no'] = ( ! empty( $new_instance['no'] ) ) ? strip_tags( $new_instance['no'] ) : '';

		return $instance;
	}

} // class Company_Leader_Widget

// register Company_Leader_Widget widget
function register_company_leader_widget() {
    register_widget( 'Company_Leader_Widget' );
}
add_action( 'widgets_init', 'register_company_leader_widget' );