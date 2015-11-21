<?php

/*
*   Devloper Name   : Mitesh Solanki
*   Date            : 21/11/2015
*   Detail          : Create shortcode for donation
 */

 add_shortcode('cfs_donation', '_cfs_donation_callback');
 
 function _cfs_donation_callback($attr){
    $ooutput = '';
    ob_start();
    require_once(CFS_PLUGIN_URL.'template/shortcode/template-donation.php');
    $output = ob_get_contents();
    ob_clean();
    return $output;
 }