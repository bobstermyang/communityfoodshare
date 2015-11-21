<?php

/*
*   Devloper Name   : Mitesh Solanki
*   Date            : 20/11/2015
*   Detail          : Create Table 
*/
function cfs_directory_install(){
      global $wpdb;
      
      $table_name = $wpdb->prefix."cfs_grocery";
      
      $checkSQL = "show tables like '$table_name'";
      
      
        if($wpdb->get_var($checkSQL) != $table_name)
        {
            $create_table = "CREATE TABLE $table_name (
                            id BIGINT(20) NOT NULL AUTO_INCREMENT,
                            name VARCHAR(100),
                            price VARCHAR(10),
                            image VARCHAR(11),
                              PRIMARY KEY (`id`));
                            ";                             
                            
            require_once(ABSPATH . "wp-admin/includes/upgrade.php");
            dbDelta($create_table);
            
        }
      $table_name = $wpdb->prefix."cfs_donator";
      
      $checkSQL = "show tables like '$table_name'";
      
      
        if($wpdb->get_var($checkSQL) != $table_name)
        {
            $create_table = "CREATE TABLE $table_name (
                            id BIGINT(20) NOT NULL AUTO_INCREMENT,
                            transaction_id VARCHAR(100),
                            user_id BIGINT(20),
                            amount VARCHAR(10),
                            payment_type VARCHAR(10),
                            user_role VARCHAR(15),
                            is_gift INT(1),
                            show_amount INT(1),
                            donar_name VARCHAR(50),
                            donar_address VARCHAR(100),
                            trans_detail text,
                            timestamp TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
                              PRIMARY KEY (`id`));
                            ";                             
                            
            require_once(ABSPATH . "wp-admin/includes/upgrade.php");
            dbDelta($create_table);
            
        }
      
       
      add_role( 'donator', 'Donator', array( 'read' => true, 'level_0' => true ) );
}

/*
*   Devloper Name   : Mitesh Solanki
*   Date            : 20/11/2015
*   Detail          : Add Script To Front End
*/

function _cfs_script(){
    
    wp_register_style( 'cfs-style', plugins_url('css/cfs.css',dirname(__FILE__)));
    wp_enqueue_style( 'cfs-style' );
    
    wp_register_script( 'cfs-validation',  plugins_url('js/validation.js',dirname(__FILE__)),array(),'1.0.0',true );
    wp_enqueue_script( 'cfs-validation' );
    
    wp_register_script( 'cfs-script',  plugins_url('js/cfs.js',dirname(__FILE__)),array(),'1.0.0',true );
    // Localize the script with new data
    $cfs_value = array('ajax' => admin_url('admin-ajax.php'));
    wp_localize_script( 'cfs-script', 'cfs', $cfs_value );
    wp_enqueue_script( 'cfs-script' );   
}  

/*
*   Devloper Name   : Mitesh Solanki
*   Date            : 20/11/2015
*   Detail          : Add Script To Back End
*/

function _cfs_admin_script(){
    
    wp_register_style( 'cfs-style', plugins_url('css/cfs_admin.css',dirname(__FILE__)));
    wp_enqueue_style( 'cfs-style' );
    
    wp_register_script( 'cfs-script',  plugins_url('js/cfs_admin.js',dirname(__FILE__)),array(),'1.0.0',true );
    wp_enqueue_script( 'cfs-script' );   
}  

/*
*   Devloper Name   : Mitesh Solanki
*   Date            : 20/11/2015
*   Detail          : Add Backend Menu For CFS 
*/

function register_cfs_menu(){
//      add_menu_page( 'Food Donator', 'Food Donator', 'manage_options', 'food_donator', '_food_donator_callback', plugins_url( 'cfs/images/icon.png' ), 6 );
      add_menu_page( 'Food Donator', 'Food Donator', 'manage_options', 'cfs_donator');
      add_submenu_page( 'cfs_donator', 'Donation List', 'Donations', 'manage_options', 'cfs_donator', '_donator_list_callback');
      add_submenu_page( 'cfs_donator', 'Companies List', 'Companies', 'manage_options', 'edit.php?post_type=company', NULL );
      add_submenu_page( 'cfs_donator', 'Teams List', 'Teams', 'manage_options', 'edit.php?post_type=team', NULL );
      //add_submenu_page( 'cfs_donator', 'Individual List', 'Individuals', 'manage_options', 'cfs_users', '_cfs_users_callback');
      add_submenu_page( 'cfs_donator', 'Groceries List', 'Groceries', 'manage_options', 'edit.php?post_type=grocery', NULL );
      add_submenu_page( 'cfs_donator', 'General Settings', 'Settings', 'manage_options', 'cfs_settings', '_cfs_settings_callback');
}

function _cfs_users_callback(){      
      require_once('class.listUsers.php');
      $cfsListUsers = new cfsListUsers();
      $cfsListUsers->prepare_items();
      $cfsListUsers->search_box('search', 'cfs_search');
      echo '<div class="wrap"><h2>Individual Users</h2>';
      $cfsListUsers->display();
      echo '</div>';
}

/*
*   Devloper Name   : Mitesh Solanki
*   Date            : 20/11/2015
*   Detail          : Display all donors list
 */

function _donator_list_callback(){      
      if(isset($_GET['sub']) && $_GET['sub'] == 'manual_donation'){
            
      }else{
            require_once('class.listDonators.php');
            $cfsListUsers = new cfsListDonators();
            $cfsListUsers->prepare_items();
            $cfsListUsers->search_box('search', 'cfs_search');
            echo '<div class="wrap"><h2>Donations <a href="admin.php?page=cfs_donator&sub=manual_donation" class="add-new-h2">Add Manual Donation</a></h2>';
            $cfsListUsers->display();
            echo '</div>';
      }
}

/*
*   Devloper Name   : Mitesh Solanki
*   Date            : 20/11/2015
*   Detail          : Handle settings of plugin
 */

function _cfs_settings_callback(){
      if(isset($_POST['btnCFSettings'])){
            update_option('cfs_settings', $_POST['cfs_settings']);
      }
      $cfs_settings = get_option('cfs_settings');
      $braintree_environment = isset($cfs_settings['braintree_environment']) ? $cfs_settings['braintree_environment'] : '';
      $braintree_merchant_id = isset($cfs_settings['braintree_merchant_id']) ? $cfs_settings['braintree_merchant_id'] : '';
      $braintree_private_key = isset($cfs_settings['braintree_private_key']) ? $cfs_settings['braintree_private_key'] : '';
      $braintree_public_key = isset($cfs_settings['braintree_public_key']) ? $cfs_settings['braintree_public_key'] : '';
      
      $bussiness_goal = isset($cfs_settings['bussiness_goal']) ? $cfs_settings['bussiness_goal'] : '';
      $team_goal = isset($cfs_settings['team_goal']) ? $cfs_settings['team_goal'] : '';
      $individual_goal = isset($cfs_settings['individual_goal']) ? $cfs_settings['individual_goal'] : '';
      
      require_once(CFS_PLUGIN_URL.'/template/template-settings.php');
}

/*
*   Devloper Name   : Mitesh Solanki
*   Date            : 20/11/2015
*   Detail          : Register CFS post type.
*/

function cfs_post_type() {

/*
 *    Register Grocery Type
 */
      
	$labels = array(
		'name'                  => 'Groceries',
		'singular_name'         => 'Grocery',
		'menu_name'             => 'Grocery',
		'name_admin_bar'        => 'Grocery',
		'parent_item_colon'     => 'Parent Grocery:',
		'all_items'             => 'All Groceries',
		'add_new_item'          => 'Add New Grocery',
		'add_new'               => 'Add New',
		'new_item'              => 'New Grocery',
		'edit_item'             => 'Edit Grocery',
		'update_item'           => 'Update Grocery',
		'view_item'             => 'View Grocery',
		'search_items'          => 'Search Grocery',
		'not_found'             => 'Not found',
		'not_found_in_trash'    => 'Not found in Trash',
		'items_list'            => 'Groceries list',
		'items_list_navigation' => 'Groceries list navigation',
		'filter_items_list'     => 'Filter groceries list',
	);
	$args = array(
		'label'                 => 'Grocery',
		'description'           => '',
		'labels'                => $labels,
		'supports'              => array( 'title', 'thumbnail'),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => false,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'grocery', $args );

/*
 *    Register Company Type
 */
      
	$labels = array(
		'name'                  => 'Companies',
		'singular_name'         => 'Company',
		'menu_name'             => 'Company',
		'name_admin_bar'        => 'Company',
		'parent_item_colon'     => 'Parent Company:',
		'all_items'             => 'All Companies',
		'add_new_item'          => 'Add New Company',
		'add_new'               => 'Add New',
		'new_item'              => 'New Company',
		'edit_item'             => 'Edit Company',
		'update_item'           => 'Update Company',
		'view_item'             => 'View Company',
		'search_items'          => 'Search Company',
		'not_found'             => 'Not found',
		'not_found_in_trash'    => 'Not found in Trash',
		'items_list'            => 'Companies list',
		'items_list_navigation' => 'Companies list navigation',
		'filter_items_list'     => 'Filter groceries list',
	);
	$args = array(
		'label'                 => 'Company',
		'description'           => '',
		'labels'                => $labels,
		'supports'              => array( 'title', 'thumbnail','editor' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => false,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'company', $args );

/*
 *    Register Team Type
 */
      
	$labels = array(
		'name'                  => 'Teams',
		'singular_name'         => 'Team',
		'menu_name'             => 'Team',
		'name_admin_bar'        => 'Team',
		'parent_item_colon'     => 'Parent Team:',
		'all_items'             => 'All Teams',
		'add_new_item'          => 'Add New Team',
		'add_new'               => 'Add New',
		'new_item'              => 'New Team',
		'edit_item'             => 'Edit Team',
		'update_item'           => 'Update Team',
		'view_item'             => 'View Team',
		'search_items'          => 'Search Team',
		'not_found'             => 'Not found',
		'not_found_in_trash'    => 'Not found in Trash',
		'items_list'            => 'Teams list',
		'items_list_navigation' => 'Teams list navigation',
		'filter_items_list'     => 'Filter groceries list',
	);
	$args = array(
		'label'                 => 'Team',
		'description'           => '',
		'labels'                => $labels,
		'supports'              => array( 'title', 'thumbnail','editor'),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => false,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'team', $args );

 
}

/*
*   Devloper Name   : Mitesh Solanki
*   Date            : 20/11/2015
*   Detail          : Add CFS fields in user profile
*/

function _cfs_user_profile_callback($user){
      if($user->roles[0] == 'donator')
      {
            require_once(CFS_PLUGIN_URL.'/template/metabox/template-user.php');
      }
}

/*
*   Devloper Name   : Mitesh Solanki
*   Date            : 20/11/2015
*   Detail          : Change featured image position for grocery post type
*/

function _grocery_image_box_callback() {

	remove_meta_box( 'postimagediv', 'grocery', 'side' );

	add_meta_box('postimagediv', __('Featured Image'), 'post_thumbnail_meta_box', 'grocery', 'normal', 'high');

}

/*
*   Devloper Name   : Mitesh Solanki
*   Date            : 20/11/2015
*   Detail          : Handle columns list of company and team post type
*/


function _set_cfs_list_columns_callback($columns) {
      global $post;
    unset($columns['date']);
    $columns['donation_goal'] = 'Donation Goal';
    $columns['achieved_goal'] = 'Recevied Donation';
    $columns['owner'] = $post->post_type == 'company' ? 'Company Owner' : 'Team Leader';
    $columns['date'] = 'Registered Date';
    
    return $columns;
}

function _set_cfs_data_column_callback( $column, $post_id ) {
    switch ( $column ) {

        case 'donation_goal' :
            echo intval( get_post_meta($post_id, '_donation_goal', true)).' $';
            break;

        case 'owner' :
            global $post;
            echo the_author_meta( 'display_name' , $post->post_autor );
            //echo get_post_meta( $post_id , 'publisher' , true ); 
            break;
      
      case 'achieved_goal':
            echo '0 $';
            break;

    }
}


/*
*   Devloper Name   : Mitesh Solanki
*   Date            : 20/11/2015
*   Detail          : Handle columns list of grocery post type
*/

function _set_grocery_list_columns_callback($columns) {
      global $post;
    unset($columns['date']);
    $columns['price'] = 'Price';
    $columns['date'] = 'Published Date';
    return $columns;
}

function _set_grocery_data_column_callback( $column, $post_id ) {
    switch ( $column ) {

        case 'price' :
            echo intval( get_post_meta($post_id, '_price', true)).' $';
            break;

    }
}

/*
*   Devloper Name   : Mitesh Solanki
*   Date            : 21/11/2015
*   Detail          : Get Registerd Company List Base On Search
*/

function get_company_list($company_name = ''){
      global $wodb;
      
      $args=array(
        'post_type' => 'company',
        'post_status' => 'publish',
        's'           =>  $company_name      
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
      return $company_list;
}

/*
*   Devloper Name   : Mitesh Solanki
*   Date            : 21/11/2015
*   Detail          : Get Team List Base On Selected Company
*/

function get_team_list($company_id){
      
      global $wodb;
      
      $args=array(
        'post_type' => 'team',
        'post_status' => 'publish',
         'meta_query' =>  array(
                  array(
                      'key'     => 'company_id',
                      'value'   => $company_id,
                  ),
            )
      );
      $team_list = array();
      $wp_query = new WP_Query($args);
      
      if( $wp_query->have_posts() ) {
            while ($wp_query->have_posts()) : $wp_query->the_post();
                  $user_info = get_userdata($wp_query->post->post_author);
                  $userName = $user_info->display_name;
                  if($user_info->first_name != ''){
                        $userName = $user_info->first_name .' '.$user_info->last_name;
                  }
                  $team_list['data'][] = array(
                        'id'    =>    $wp_query->post->ID,
                        'name'    =>  $wp_query->post->post_title,
                        'owner'   =>  $userName 
                  );        
            endwhile;
            $team_list['found_posts'] = $wp_query->found_posts;
      }
      wp_reset_query();
      return $team_list;
}

/*
*   Devloper Name   : Mitesh Solanki
*   Date            : 21/11/2015
*   Detail          : Save company/team and user info
*/

function _register_new_user_callback(){
      global $post;
      
            $post_id = 0;
            $page_url = $_POST['page_url'];
            $userdata = array(
                  'user_login'  =>  $_POST['txtUserName'],
                  'user_pass'   =>  $_POST['txtPassword'],
                  'user_email'  =>  $_POST['txtEmail'],
                  'first_name'  =>  $_POST['txtFirstName'],
                  'last_name'   =>  $_POST['txtLastName'],
                  'role'        =>  'donator'
              );
            $user_id = wp_insert_user($userdata);
            if(is_wp_error($user_id)){
                  echo json_encode(array('error' => $user_id->get_error_message()));
                  die();
                  wp_redirect($page_url.'?step=3&cgoal='.$_REQUEST['cgoal'].'&cname='.$_REQUEST['cname'].'&donator=new&error='.$user_id->get_error_message());
                  exist();
            }
            if($user_id){
                  update_user_meta($user_id, 'address1', $_POST['txtStreet1']);
                  update_user_meta($user_id, 'address2', $_POST['txtStreet2']);
                  update_user_meta($user_id, 'city', $_POST['txtCity']);
                  update_user_meta($user_id, 'state', $_POST['txtState']);
                  update_user_meta($user_id, 'pincode', $_POST['txtZipcode']);
                  update_user_meta($user_id, 'country', $_POST['comboCountry']);
                  update_user_meta($user_id, 'phone', $_POST['txtNumber']);
                  update_user_meta($user_id, 'gift_notification', $_POST['chkGiftNotification']);
                  update_user_meta($user_id, 'subscriber', $_POST['chkSubscriber']);
                  
                  $post_id = wp_insert_post(
                        array(
                              'post_title'      =>    $_POST['cname'],
                              'post_type'       =>    'company',
                              'post_status'     =>    'publish',
                              'post_author'     =>    $user_id
                        )
                  );
                  if($post_id){
                        update_post_meta($post_id, '_donation_goal', $_POST['cgoal']);
                  }
            }
            if($post_id && $user_id){
                  echo json_encode(array('success' => $page_url.'?step=4&cgoal=1'));
                  die();
            }else{
                  echo json_encode(array('error' => 'There is some issue. Please try after sometime!'));
                  die();
            }
      
 }
 
 
 /*  
*   Devloper Name   : Mitesh Solanki
*   Date            : 21/11/2015
*   Detail          : Get all query fields
  */

function get_all_query_fields(){
      foreach($_GET as $key => $value){
            echo '<input type="hidden" name="'.$key.'" value="'.$value.'" />';
      }     
}