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
                            trans_id VARCHAR(100),
                            team_id BIGINT(20),
                            payment_type VARCHAR(10),                            
                            show_amount INT(1),
                            donator_name VARCHAR(50),
                            donator_email VARCHAR(100),
                            amount INT(10),
                            trans_detail text,
                            timestamp TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
                            PRIMARY KEY (`id`));
                            ";                             
                            
            require_once(ABSPATH . "wp-admin/includes/upgrade.php");
            dbDelta($create_table);
            
        }
      
      
      $table_name = $wpdb->prefix."cfs_team";
      
      $checkSQL = "show tables like '$table_name'";
      
      
        if($wpdb->get_var($checkSQL) != $table_name)
        {
            $create_table = "CREATE TABLE $table_name (
                            id BIGINT(20) NOT NULL AUTO_INCREMENT,
                            team_name VARCHAR(100),
                            company_id BIGINT(20),
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
    
    wp_register_style( 'cfs-bootstrap', plugins_url('css/bootstrap.min.css',dirname(__FILE__)));
    wp_enqueue_style( 'cfs-bootstrap' );
    
    wp_register_style( 'cfs-animate', plugins_url('css/animate.css',dirname(__FILE__)));
    wp_enqueue_style( 'cfs-animate' );    
    
    wp_register_style( 'cfs-common', plugins_url('css/common.css',dirname(__FILE__)));
    wp_enqueue_style( 'cfs-common' );

    wp_register_style( 'cfs-style', plugins_url('css/cfs.css',dirname(__FILE__)));
    wp_enqueue_style( 'cfs-style' );
        
    wp_register_script( 'cfs-bootstrap-js',  plugins_url('js/bootstrap.min.js',dirname(__FILE__)),array(),'1.0.0',true );
    wp_enqueue_script( 'cfs-bootstrap-js' );
    
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-effects-core');
    wp_register_script( 'cfs-validation',  plugins_url('js/validation.js',dirname(__FILE__)),array(),'1.0.0',true );
    wp_enqueue_script( 'cfs-validation' );
    wp_register_script( 'cfs-validation-additional',  plugins_url('js/additional-methods.min.js',dirname(__FILE__)),array(),'1.0.0',true );
    wp_enqueue_script( 'cfs-validation-additional' );
    
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
      add_submenu_page( 'cfs_donator', 'Teams List', 'Teams', 'manage_options', 'cfs_teams', '_cfs_teams_callback' );
      //add_submenu_page( 'cfs_donator', 'Individual List', 'Individuals', 'manage_options', 'cfs_users', '_cfs_users_callback');
      add_submenu_page( 'cfs_donator', 'Groceries List', 'Groceries', 'manage_options', 'edit.php?post_type=grocery', NULL );
      add_submenu_page( 'cfs_donator', 'General Settings', 'Settings', 'manage_options', 'cfs_settings', '_cfs_settings_callback');
}

/*
*   Devloper Name   : Mitesh Solanki
*   Date            : 22/11/2015
*   Detail          : Display all donors list
 */

function _cfs_teams_callback(){
      require_once('class.listTeams.php');
      $cfsTeams = new cfsTeams();
      $cfsTeams->prepare_items();
      $cfsTeams->search_box('search', 'cfs_search');
      echo '<div class="wrap"><h2>Teams</h2>';
      $cfsTeams->display();
      echo '</div>';
}

/*
*   Devloper Name   : Mitesh Solanki
*   Date            : 20/11/2015
*   Detail          : Display all donors list
 */

function _donator_list_callback(){      
      if(isset($_GET['sub']) && $_GET['sub'] == 'manual_donation'){            
            require_once(CFS_PLUGIN_URL.'/template/template-new-donator.php');
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
    if($post->post_type == 'team'){
      $columns['company'] = 'Company Name';
    }
    if($post->post_type == 'company'){
      $columns['teams'] = '';
    }
    if($post->post_type == 'team'){
      $columns['individuals'] = '';
    }
    
    $columns['date'] = 'Registered Date';
    return $columns;
}

function _set_cfs_data_column_callback( $column, $post_id ) {
    switch ( $column ) {

        case 'donation_goal' :
            echo intval( get_post_meta($post_id, '_company_goal', true)).' $';
            break;

        case 'owner' :
            global $post;
            echo the_author_meta( 'display_name' , $post->post_autor );
            //echo get_post_meta( $post_id , 'publisher' , true ); 
            break;
      
      case 'achieved_goal':
            $received_amount = get_donation_of_company($post_id);            
            echo ($received_amount?$received_amount:0).' $';
            break;
      case 'company':
            echo get_the_title(get_post_meta($post_id, 'company_id', true));
            break;
      case 'teams':
            echo '<a href="admin.php?page=cfs_teams&cid='.$post_id.'" title="View Teams">View Teams</a>';
            break;
    }
}

/*
*   Devloper Name   : Mitesh Solanki
*   Date            : 20/11/2015
*   Detail          : Get donation by company
*/

function get_donation_of_company($company_id){
      global $wpdb;
      $query = 'SELECT sum(amount) FROM `'.$wpdb->prefix.'cfs_donator` AS cd LEFT JOIN '.$wpdb->prefix.'cfs_team AS ct ON cd.team_id = ct.id WHERE ct.company_id = '.$company_id;
      return $wpdb->get_var($query);
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

function get_team_list($company_id = 0){
      
      global $wpdb;
      
      $query = 'SELECT id, team_name FROM '.$wpdb->prefix.'cfs_team';
      if($company_id){
            $query .= ' WHERE company_id = '.$company_id;
      }
      $team_list = array();
      
      $team_result = $wpdb->get_results($query);
      
      if( $team_result ) {
            foreach($team_result as $team){
                  $team_list[] = array(
                        'id'    =>    $team->id,
                        'name'    =>  $team->team_name
                  );        
            }
      }
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
            }
            if($user_id){
                  update_user_meta($user_id, 'address1', $_POST['txtStreet1']);
                  update_user_meta($user_id, 'address2', $_POST['txtStreet2']);
                  update_user_meta($user_id, 'city', $_POST['txtCity']);
                  update_user_meta($user_id, 'state', $_POST['txtState']);
                  update_user_meta($user_id, 'pincode', $_POST['txtZipcode']);
                  update_user_meta($user_id, 'country', $_POST['comboCountry']);
                  update_user_meta($user_id, 'phone', $_POST['txtNumber']);
                  update_user_meta($user_id, 'gift_verification', $_POST['chkGiftNotification']);
                  update_user_meta($user_id, 'newsletter', $_POST['chkSubscriber']);
                  update_user_meta($user_id, 'donation_goal', isset( $_POST['txtPg']) ? $_POST['txtPg'] : '');                  
                  if(isset($_POST['tid'])){
                        update_post_meta($post_id, 'team_id', $_POST['tid']);
                        $post_id = $_POST['tid'];
                  }
                  
                  $post_param = array();
                  $donation_goal = 0;
                  if(isset($_POST['tname'])){
                        $post_param = array(
                              'post_title'      =>    $_POST['tname'],
                              'post_type'       =>    'team',
                              'post_status'     =>    'publish',
                              'post_author'     =>    $user_id
                        );
                        $donation_goal = $_POST['tgoal'];
                  }
                  if(isset($_POST['cname'])){
                        $post_param = array(
                              'post_title'      =>    $_POST['cname'],
                              'post_type'       =>    'company',
                              'post_status'     =>    'publish',
                              'post_author'     =>    $user_id
                        );
                        $donation_goal = $_POST['cgoal'];
                  }
                  if($donation_goal){
                        $post_id = wp_insert_post($post_param);
                        
                        if($post_id){
                              update_post_meta($post_id, '_donation_goal', $donation_goal);
                              if(isset($_POST['cid'])){
                                    update_post_meta($post_id, 'company_id', $_POST['cid']);
                              }
                        }
                  }
            }
            if($post_id && $user_id){
                  if(isset($_POST['txtPd'])){
                        echo json_encode(array('success' => $page_url.'?step=4&txtPd='.$_POST['txtPd']));
                  }
                  if(isset($_POST['cname'])){
                        echo json_encode(array('success' => $page_url.'?step=4&cgoal=1'));      
                  }
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
 
 /*  
*   Devloper Name   : Mitesh Solanki
*   Date            : 22/11/2015
*   Detail          : Get team name
  */

  function get_team_name($team_id){
      global $wpdb;
      return $wpdb->get_var('SELECT team_name FROM '.$wpdb->prefix.'cfs_team WHERE id ='.$team_id);
  }

/*
*   Devloper Name   : Twisha Patel
*   Date            : 22/11/2015
*   Detail          : Handle registartion process
* 
*/
  
function save_company()
{
    if(!empty( $_POST['hidden_action_register'] ) &&  $_POST['hidden_action_register'] == "register_cfs")
    {
        
        global $wpdb;

        $msg=""; 
        
        if($_POST['companyname']=="")
            $msg .="Enter value for Company name.<br>";
        if($_POST['noofemployee']=="")
            $msg .="Enter value for Number of Employees.<br>";
        if($_POST['companygoal']=="")
            $msg .="Enter value for Company Goal.<br>";
        
            
        if($_POST['email']=="")
            $msg .="Enter value for email.<br>";
        else
        {
            if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
                $msg .="Enter correct value for email.<br>";
        }
      
        if($_POST['contactnumber']=="")
            $msg .="Enter value for Contact Number.<br>";  

        if($_FILES['logoimg']['name']=="")
            $msg .="Upload Logo Image.<br>";          
        
        if($msg=="")
        {
            $pwd='123456';
            $userdata = array(
                  'user_login'  =>  $_POST['email'],
                  'user_pass'   =>  $pwd,
                  'user_email'  =>  $_POST['email'],
                  'role'        =>  'donator'
              );
           
            $user_id = wp_insert_user($userdata);
            
           
            if ( ! is_wp_error( $user_id ) ) 
            {
                $new_post = array(
                    'post_title'   => sanitize_text_field($_POST['companyname']),
                    'post_type'    => 'company',
                    'post_status'  => 'publish',
                    'post_author'  => $user_id 
                );
                
                $pid = wp_insert_post($new_post);
                
                if($_FILES['logoimg']['name'])
                {                        
                    $exts = array("jpeg","jpg","png");
                    $temp1 = explode(".", $_FILES['logoimg']['name']);
                    
                    $file_ext1 = strtolower(end($temp1));
                    if(in_array($file_ext1,$exts ))
                    {
                        $pupload = insert_attachment('logoimg',$pid,true);
                    }    
                                    
                }

                update_post_meta($pid,'_no_of_employees',sanitize_text_field($_POST['noofemployee']));
                update_post_meta($pid,'_company_goal',sanitize_text_field($_POST['companygoal']));
                update_post_meta($pid,'_contact_email',sanitize_text_field($_POST['email']));
                update_post_meta($pid,'_contact_number',sanitize_text_field($_POST['contactnumber']));
                
                if($_POST['team'])
                {
                    for($i=0;$i<sizeof($_POST['team']);$i++)
                    {
                        if($_POST['team'][$i]!="")
                        {
                            $sSQL="insert into ".$wpdb->prefix."cfs_team (team_name,company_id) values('".$_POST['team'][$i]."','".$pid."')";
                            $wpdb->query($sSQL);
                        }
                    }
                }
                
                echo '<div class="msg success">Company is registered successfully</div>';
            }
            else
            {
                
                echo '<div class="msg error">'.$msg=$user_id->get_error_message().'</div>';
            }
        }
        else
        {
            echo '<div class="msg error">'.$msg.'</div>';
        }
    }
}


/*
*   Devloper Name   : Twisha Patel
*   Date            : 22/11/2015
*   Detail          : Add attachment to company
* 
*/
  

function insert_attachment($file_handler,$post_id,$setthumb='false')
{
    // check to make sure its a successful upload
    if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();

    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');
    
    
    $attach_id = media_handle_upload( $file_handler, $post_id );
    
    update_post_meta($post_id,'_thumbnail_id',$attach_id);
 
}


/*
*   Devloper Name   : Mitesh Solanki
*   Date            : 22/11/2015
*   Detail          : Handle Payment Request
*/
//add_shortcode('test', '_send_payment_request_callback');

function _send_payment_request_callback(){
      
      
      Braintree_Configuration::environment('sandbox');
      Braintree_Configuration::merchantId('4r57w2h7hgyqk52g');
      Braintree_Configuration::publicKey('4y98n9vt93pvqpgj');
      Braintree_Configuration::privateKey('32d966b730def400269d835b030fd109');

      
      /*$amount = 10.30;
      $card = '4111111111111111';
      $padDateMonth = '10';
      $expDateYear = '20';
      $cvv = '911';
      */
      
      $card_detail = explode('/',$_POST['expire_card']);
      
      $amount = $_POST['amount'];
      $card = $_POST['credit_card'];
      $padDateMonth = $card_detail[0];
      $expDateYear = $card_detail[1];
      $cvv = $_POST['cvv'];
      
      $result = Braintree_Transaction::sale(array(
            'amount'        => round(floatval($amount)),
            'creditCard'    => array(
            'number' => $card,
            'expirationMonth' => $padDateMonth,
            'expirationYear' => $expDateYear,
            'cvv' => $cvv
            ),
            ));
      
      if ($result->success == 1) {
            $trans_id = $result->transaction->_attributes['id'];
            $donatorData = array(
                        'trans_id'  =>  $trans_id,
                        'team_id'   =>  $_POST['team_id'],
                        'payment_type'   =>  'Online',
                        'amount'   =>  $amount,
                        'trans_detail'=> serialize($result->transaction->_attributes)
                  );
            $objDonator = new tblDonator();
            $objDonator->insert($donatorData);
            echo 1;
      }else{
            echo 0;     
      }
      die();
}


add_action('wp_ajax_nopriv_cfs_load_company_info', 'cfs_load_company_info'); 
add_action('wp_ajax_cfs_load_company_info', 'cfs_load_company_info');
function cfs_load_company_info()
{
    global $wpdb;
    if($_POST['companyid'])
    {
        $title=get_the_title($_POST['companyid']);
        $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($_POST['companyid']), 'large');
        $url = $thumb[0];
        $company_goal = get_post_meta($_POST['companyid'],'_company_goal',true);
        $received_donation = get_donation_of_company($_POST['companyid']);
        $donation_progress =  $received_donation*100/$company_goal;
        $donation_progress = $donation_progress > 100 ? 100 : $donation_progress;
        $team_list = get_team_list($_POST['companyid']);    
    ?>
    <div id="donation_form" class="animated fadeInUp">
        <fieldset class="modal_emb_1">
            <div id="inner_container">
                <div style="background-image: url('<?php echo $url; ?>');" class="inner initial_state">
                    <div class="dramatic_overlay"></div>
                    <div class="user_continer">
                        <div style="background-image: url('<?php echo plugins_url('images/perch_logo.png',dirname(__FILE__));?>');background-size: 80px 80px;background-color: transparent;" class="main_avatar"></div>
                        <div class="main_title_etc">
                            <h1><?php echo $title; ?></h1>
                        </div>
                        
                    </div>
                </div>
                <div class="pic_cont">
                    <div class="inpin_l"></div>
                </div>
                <div class="desc_cont">
                    <h1>Nummber of Employees : <?php echo get_post_meta($_POST['companyid'],'_no_of_employees',true);?></h1>
                    <h1>Contact Email : <?php echo get_post_meta($_POST['companyid'],'_contact_email',true);?></h1>
                    <h1>Contact Number : <?php echo get_post_meta($_POST['companyid'],'_contact_number',true);?></h1>
                    <p></p>
                </div>
                <div ng-controller="progressBars" ng-app="progressApp" class="ng-scope">
                    <!-- ngRepeat: item in progressData --><div ng-repeat="item in progressData" class="fund ng-scope">
                        <div class="progress">
                            <div ng-style="{width:<?php echo $donation_progress;?> + '%'}" class="bar" style="width: <?php echo $donation_progress;?>%;">
                                <span ng-show="((item.raised / item.goal) * 100) &gt; 100" class="percent ng-hide">100%</span>
                            </div>
                        </div>
                        <span class="goal ng-binding">
                        <span ng-show="((item.raised / item.goal) * 100) &lt;= 100" class="percent ng-binding"><?php echo round($donation_progress);?>%</span>
                        &nbsp;&nbsp; Goal: <?php echo $company_goal;?></span>
                    </div><!-- end ngRepeat: item in progressData -->
                </div>
                
            </div>
            <div class="action_cont"></div>
            <input type="submit" value="Donate" class="next_rs action-button first_next yellowbtn" name="next_rs">
        </fieldset>
        <fieldset class="modal_emb_1">
            <div id="inner_container">
                <div class="inner mb_n_25">
                    <!--div class="thank_you_for_proceeding">
                    </div-->
                    <p class="section_hl">Select Team For Donation</p>
                    <!--p class="section_p">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod</p-->
                </div>
                <?php 
                    
                    if($team_list)
                    {
                ?>
                <div class="field">
                    <form action="javascript:void(0);" method="get" class="modal_center">
                        <div class="modal_align_1">
                            <div class="affiliate-grid-container">
                                <?php
                                    foreach($team_list as $team)
                                    {
                                ?>
                                <div class="affiliate-grid">
                                    <input type="radio" name="org_selection" value="<?php echo $team['id']?>" id="input1" class="affiliate-select"/>
                                    <label for="input1">
                                    <img src="<?php echo plugins_url('images/1.jpg',dirname(__FILE__)) ?>" class="img-circle" alt="<?php echo $team['name']; ?>" class="affiliate-prod-img"/>
                                    </label>
                                    <p><?php echo $team['name']; ?></p>
                                </div>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </form>
                </div>
                <?php
                    }
                ?>
            </div>
            <div class="action_cont"></div>
            <input type="button" name="previous" class="previous yellowbtn" value="Previous" style="margin-top:50px;"/>
            <input type="submit" name="next_rs" class="next_rs adj_1 yellowbtn" value="Next" id="commandButton_1_0"/>
        </fieldset>
        <fieldset class="modal_emb_1">
            <form id="frmDonation" action="">
                  <div class="loader hide"></div>
            <div id="inner_container">
                <div class="inner">
                    <p class="section_hl">Make Donation</p>
                    <!--p class="section_p">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod</p-->
                </div>
                <div class="field">
                <input type="text" name="credit_card"  id="credit_card" value="" placeholder="Enter Credit Card Number"  /><br />                <input type="text" name="expire_card"  id="expire_card" placeholder="Month/Year"  />  <br />
                <input type="text" name="cvv"  id="cvv" placeholder="Enter CVV"  />  <br />
                <input type="text" name="amount"  placeholder="Donation Amount"  />  <br />
                </div>
            </div>
            <input type="hidden" name="action" value="send_payment_request" />
            <input type="hidden" name="team_id" value="" />
            <!--input type="button" name="previous" class="previous action-button_2 yellowbtn" value="Previous"/-->
            <input type="submit" name="submit" class="submit btnMakeDonation action-button yellowbtn" value="Done" id="commandButton_3_0" style="width: 180px; display: block; margin-left: auto; margin-right: auto;"/>
            </form>
        </fieldset>
    </div>
    <?php
        exit;
    }
}

