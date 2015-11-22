<?php
/*
Plugin Name: Community Food Share
Plugin URI: 
Version: 1.0.0
Description: Community Food Share
Author URI: 
*/

define( 'CFS_PLUGIN_URL', plugin_dir_path(__FILE__) );

require_once("include/functions.php");
require_once("include/metabox-grocery.php");
require_once("include/metabox-company.php");
require_once("include/shortcodes.php");
require_once("data/donator.php");
require_once("payment/Braintree/Braintree.php");
require_once("widgets/company-leader-board.php");

/*
*   Devloper Name   : Mitesh Solanki
*   Date            : 20/11/2015
*   Detail          : Add Table and Add User Roles
*/

register_activation_hook(__FILE__,'cfs_directory_install');

/*
*   Devloper Name   : Mitesh Solanki
*   Date            : 20/11/2015
*   Detail          : Add Script To Front End
*/

add_action("wp_enqueue_scripts","_cfs_script");

/*
*   Devloper Name   : Mitesh Solanki
*   Date            : 20/11/2015
*   Detail          : Add Script To Back End  
*/
    
add_action( 'admin_enqueue_scripts', '_cfs_admin_script' );

/*
*   Devloper Name   : Mitesh Solanki
*   Date            : 20/11/2015
*   Detail          : Add Backend Menu For CFS 
*/

add_action('admin_menu', 'register_cfs_menu');

/*
*   Devloper Name   : Mitesh Solanki
*   Date            : 20/11/2015
*   Detail          : Register CFS post type.
*/

add_action( 'init', 'cfs_post_type', 0 );

/*
*   Devloper Name   : Mitesh Solanki
*   Date            : 20/11/2015
*   Detail          : Add CFS fields in user profile
*/

add_action('show_user_profile', '_cfs_user_profile_callback');
add_action('edit_user_profile', '_cfs_user_profile_callback');

/*
*   Devloper Name   : Mitesh Solanki
*   Date            : 20/11/2015
*   Detail          : Change featured image position for grocery post type
*/

add_action('do_meta_boxes', '_grocery_image_box_callback');

/*
*   Devloper Name   : Mitesh Solanki
*   Date            : 20/11/2015
*   Detail          : Handle columns list of grocery post type
*/

add_filter( 'manage_grocery_posts_columns', '_set_grocery_list_columns_callback' );
add_action( 'manage_grocery_posts_custom_column' , '_set_grocery_data_column_callback', 10, 2 );


/*
*   Devloper Name   : Mitesh Solanki
*   Date            : 20/11/2015
*   Detail          : Handle columns list of company and team post type
*/


add_filter( 'manage_company_posts_columns', '_set_cfs_list_columns_callback' );
add_filter( 'manage_team_posts_columns', '_set_cfs_list_columns_callback' );
add_action( 'manage_company_posts_custom_column' , '_set_cfs_data_column_callback', 10, 2 );
add_action( 'manage_team_posts_custom_column' , '_set_cfs_data_column_callback', 10, 2 );

/*
*   Devloper Name   : Mitesh Solanki
*   Date            : 21/11/2015
*   Detail          : Handle ajax form register user event
*/

add_action('wp_ajax_register_new_user', '_register_new_user_callback');
add_action('wp_ajax_nopriv_register_new_user', '_register_new_user_callback');

/*
*   Devloper Name   : Mitesh Solanki
*   Date            : 22/11/2015
*   Detail          : Handle Payment Request
*/

add_action('wp_ajax_send_payment_request', '_send_payment_request_callback');
add_action('wp_ajax_nopriv_send_payment_request', '_send_payment_request_callback');

