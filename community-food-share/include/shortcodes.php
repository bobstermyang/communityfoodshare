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

add_shortcode('cfs_donation2', '_cfs_donation');

function _cfs_donation(){
    
      Braintree_Configuration::environment('sandbox');
      Braintree_Configuration::merchantId('4r57w2h7hgyqk52g');
      Braintree_Configuration::publicKey('4y98n9vt93pvqpgj');
      Braintree_Configuration::privateKey('32d966b730def400269d835b030fd109');

   ?>
   <form id="checkout" method="post" action="/checkout">
  <div id="payment-form"></div>
  <input type="submit" value="Pay $10">
</form>

<!--form id="payment-form" action="/your/server/endpoint" method="post">
  <input data-braintree-name="number" value="4111111111111111" />
  <input data-braintree-name="expiration_date" value="10/20" />
  <input type="submit" value="Purchase" />
</form-->

<script src="https://js.braintreegateway.com/v2/braintree.js"></script>
<script>
  braintree.setup(
    // Replace this with a client token from your server
    "eyJ2ZXJzaW9uIjoyLCJhdXRob3JpemF0aW9uRmluZ2VycHJpbnQiOiI2NTQxZTg4MzIyM2U5MDBiODhlMWEwMTJlYzg1MTQ3NTUzYmEyMjZjOGI4OWM5N2RmMDc4NTBkMDQ4MTEwNGE2fGNyZWF0ZWRfYXQ9MjAxNS0xMS0yMlQxMTo0NzozNi43MzI4NDYwMjArMDAwMFx1MDAyNm1lcmNoYW50X2lkPTM0OHBrOWNnZjNiZ3l3MmJcdTAwMjZwdWJsaWNfa2V5PTJuMjQ3ZHY4OWJxOXZtcHIiLCJjb25maWdVcmwiOiJodHRwczovL2FwaS5zYW5kYm94LmJyYWludHJlZWdhdGV3YXkuY29tOjQ0My9tZXJjaGFudHMvMzQ4cGs5Y2dmM2JneXcyYi9jbGllbnRfYXBpL3YxL2NvbmZpZ3VyYXRpb24iLCJjaGFsbGVuZ2VzIjpbXSwiZW52aXJvbm1lbnQiOiJzYW5kYm94IiwiY2xpZW50QXBpVXJsIjoiaHR0cHM6Ly9hcGkuc2FuZGJveC5icmFpbnRyZWVnYXRld2F5LmNvbTo0NDMvbWVyY2hhbnRzLzM0OHBrOWNnZjNiZ3l3MmIvY2xpZW50X2FwaSIsImFzc2V0c1VybCI6Imh0dHBzOi8vYXNzZXRzLmJyYWludHJlZWdhdGV3YXkuY29tIiwiYXV0aFVybCI6Imh0dHBzOi8vYXV0aC52ZW5tby5zYW5kYm94LmJyYWludHJlZWdhdGV3YXkuY29tIiwiYW5hbHl0aWNzIjp7InVybCI6Imh0dHBzOi8vY2xpZW50LWFuYWx5dGljcy5zYW5kYm94LmJyYWludHJlZWdhdGV3YXkuY29tIn0sInRocmVlRFNlY3VyZUVuYWJsZWQiOnRydWUsInRocmVlRFNlY3VyZSI6eyJsb29rdXBVcmwiOiJodHRwczovL2FwaS5zYW5kYm94LmJyYWludHJlZWdhdGV3YXkuY29tOjQ0My9tZXJjaGFudHMvMzQ4cGs5Y2dmM2JneXcyYi90aHJlZV9kX3NlY3VyZS9sb29rdXAifSwicGF5cGFsRW5hYmxlZCI6dHJ1ZSwicGF5cGFsIjp7ImRpc3BsYXlOYW1lIjoiQWNtZSBXaWRnZXRzLCBMdGQuIChTYW5kYm94KSIsImNsaWVudElkIjpudWxsLCJwcml2YWN5VXJsIjoiaHR0cDovL2V4YW1wbGUuY29tL3BwIiwidXNlckFncmVlbWVudFVybCI6Imh0dHA6Ly9leGFtcGxlLmNvbS90b3MiLCJiYXNlVXJsIjoiaHR0cHM6Ly9hc3NldHMuYnJhaW50cmVlZ2F0ZXdheS5jb20iLCJhc3NldHNVcmwiOiJodHRwczovL2NoZWNrb3V0LnBheXBhbC5jb20iLCJkaXJlY3RCYXNlVXJsIjpudWxsLCJhbGxvd0h0dHAiOnRydWUsImVudmlyb25tZW50Tm9OZXR3b3JrIjp0cnVlLCJlbnZpcm9ubWVudCI6Im9mZmxpbmUiLCJ1bnZldHRlZE1lcmNoYW50IjpmYWxzZSwiYnJhaW50cmVlQ2xpZW50SWQiOiJtYXN0ZXJjbGllbnQzIiwiYmlsbGluZ0FncmVlbWVudHNFbmFibGVkIjp0cnVlLCJtZXJjaGFudEFjY291bnRJZCI6ImFjbWV3aWRnZXRzbHRkc2FuZGJveCIsImN1cnJlbmN5SXNvQ29kZSI6IlVTRCJ9LCJjb2luYmFzZUVuYWJsZWQiOmZhbHNlLCJtZXJjaGFudElkIjoiMzQ4cGs5Y2dmM2JneXcyYiIsInZlbm1vIjoib2ZmIn0=",
    "dropin", {
      container: "payment-form",
	  onPaymentMethodReceived:function(method){
		 jQuery.ajax({
				  type: "POST",
				  url: cfs.ajax,
				  data:'action=send_payment_request&ck='+method.nonce,
				  success:function(result){
					 console.log(result);
				  }
		 })
		 console.log(method);
		 return false;
	  }
    });
</script>


   <?php
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
        ?>
        <ul id="grid">
        <?php
         while ( $post_query->have_posts() ) 
         { 
             $post_query->the_post();
             $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium');
             $url = $thumb[0];
    ?>
            <li>
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

