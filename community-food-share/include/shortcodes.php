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
 
 
/*
*   Devloper Name   : Twisha Patel
*   Date            : 22/11/2015
*   Detail          : Create shortcode for registartion
* 
*/

add_shortcode('cfs_register','_cfs_registartion');

function _cfs_registartion()
{
    save_company();
	$output = '';
    ob_start();	
    require_once(CFS_PLUGIN_URL.'template/shortcode/template-register.php');
	$output = ob_get_contents();
	ob_clean();
	return $output;
}


add_shortcode('cfs_company_list','_cfs_company_list');
function _cfs_company_list()
{
    $output = '';
    ob_start();
    $post_query = new WP_Query(
        array(
            'post_type' => 'company',
            //'showposts' => $atts['total'],
            'orderby' => 'post_date',
            'order' =>'desc'
            
        )
    );
    
    if ( $post_query->have_posts() )
    {
		$top_company = get_latest_donation_company(); 
        ?>
        <ul id="grid">
        <?php
         while ( $post_query->have_posts() ) 
         { 
             $post_query->the_post();
             $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium');
             $url = $thumb[0];
			 $company_no = 0;
			 if(array_key_exists($post_query->post->ID,$top_company))
			 {
				  $company_no = $top_company[$post_query->post->ID];
			 }
    ?>
            <li>
			   <?php
				  if($company_no){
					 echo '<div class="top_rated_company">'.$company_no.'</div>';	 
				  }
			   ?>
			   
                <div class="g_overlay">
                    <a class="inner_md_btn company yellowbtn" data-companyid='<?php the_ID(); ?>' >Make a donation </a>
                </div>    
                <div class="company_rep" style=" background-image: url('<?php echo $url; ?>');"></div>
            </li>
    <?php
         }
         ?>
         </ul>
         <div class="more_explanation"></div>
         <div class="modal" id="modal_donation">
            
            <div class="modal-dialog">
                <div class="modal-content modal_specification">
                    <div class="modal-body" id="bodycontent">
                        <div class="modal_frame_1">
                            <div id="donation_form" class="animated fadeInUp">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
         </div>
         <?php
    }
    $output = ob_get_contents();
    ob_clean();
    return $output;
}

