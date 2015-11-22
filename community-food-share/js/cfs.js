flagSubmitForm = true;
$=jQuery;
jQuery(function(){
	
    jQuery(".validate").validate();
    jQuery("#frmRegisterCFS").validate({
			rules: {
				txtUserName: {
					required: true,
					minlength: 2
				},
				txtPassword: {
					required: true,
					minlength: 5
				},
				txtRepeatPassword: {
					required: true,
					minlength: 5,
					equalTo: "#txtPassword"
				},
				txtEmail: {
					required: true,
					email: true
				},
			},
			messages: {
				txtUserName: {
					required: "Please enter a username",
					minlength: "Your username must consist of at least 5 characters"
				},
				txtPassword: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long"
				},
				txtRepeatPassword: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long",
					equalTo: "Please enter the same password as above"
				},
				txtEmail: "Please enter a valid email address",
			},
            submitHandler: function(form) {
            // some other code
            // maybe disabling submit button
            // then:
            if (flagSubmitForm) {
                        jQuery('#frmRegisterCFS').submit(function(){
                                                flagSubmitForm = false;
                              jQuery('.loader').removeClass('hide');      
                              jQuery.ajax({
                                    type: "POST",
                                    url: cfs.ajax,
                                    data: jQuery('#frmRegisterCFS').serialize(),
                                    dataType:'json',
                                    success: function(result){
                                                flagSubmitForm = true;
                                       if(result.error){
                                                
                                                jQuery('.loader').addClass('hide');
                                                alert(result.error);
                                                //console.log(result.error);
                                                }else{
                                                            window.location = result.success;
                                                }
                                                
                                       return false;
                                    }
                                  });
                        });
            }
          }
	});
	/* 22-11-2015 */
    
	jQuery('body').on('click', '.btnMakeDonation', function(){
		jQuery('#frmDonation input[name="team_id"]').val(jQuery('input[name="org_selection"]:checked').val());
		jQuery('#frmDonation .loader').removeClass('hide');
		jQuery.ajax({
				  type: "POST",
				  url: cfs.ajax,
				  data:jQuery('#frmDonation').serialize(),
				  success:function(result){
					jQuery('#frmDonation .loader').addClass('hide');
					 if (result) {
                        jQuery('#frmDonation #inner_container .inner p').html('Thank you for donation!');
						jQuery('#inner_container .field').hide();
						jQuery('#commandButton_3_0').remove();
						window.setTimeout(function(){
							location.reload();
						},1000);
                     }
				  }
		 });
		return false;
	});
	
	jQuery(".add-more-team").click(function(e){
		e.preventDefault();
		cnt=jQuery(".team-section").find(".each-team").length;
		if(cnt<10)
		{
			str="<div class='each-team'><input type='text' name='team[]' /><a href='#' class='remove_team linkcls'>Remove</a></div>";
			jQuery(".team-section").append(str);
		}
		
	});
	
    jQuery(".team-section").on("click",".remove_team",function(e){
		e.preventDefault();
		ans=confirm("Are you sure you want to remove?")
		if(ans)
		{
			jQuery(this).parents(".each-team").remove();
		}
		else
			return false;
	});
    
    
    jQuery("#frmcfsregister").validate({
        rules: {
            noofemployee: {
              required: true,
              number: true
            },
            email: {
                required: true,
                email: true
            },
            logoimg:{
                required: true,
                accept: "image/jpeg,image/png",
            }
        },
        messages: {
            email: "Please enter a valid email address",
        }   
    })
    
    
     jQuery('a.company').click(function(ev){
         ev.preventDefault();
         var cid = jQuery(this).data('companyid');
         
         jQuery.ajax({
            url : cfs.ajax,
            data: "action=cfs_load_company_info&companyid="+cid,
            type  : 'POST',
            async : false,
            success : function(html) {
                jQuery('#modal_donation .modal-body').html(html);
                jQuery('#modal_donation').modal('show');
            }
         });
     });
     
    
});

$(window).load(function(){
    //jQuery time
    var current_fs, next_fs, previous_fs; //fieldsets
    var left, opacity, scale; //fieldset properties which we will animate
    var animating; //flag to prevent quick multi-click glitches
    
    $("#bodycontent").on("click",".next_rs",function(){

    if(animating) return false;
    animating = true;

    current_fs = $(this).parent();
    next_fs = $(this).parent().next();

    //activate next step on progressbar using the index of next_fs
    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

    //show the next fieldset
    next_fs.show();
    //hide the current fieldset with style
    current_fs.animate({opacity: 0}, {
        step: function(now, mx) {
            //as the opacity of current_fs reduces to 0 - stored in "now"
            //1. scale current_fs down to 80%
            scale = 1 - (1 - now) * 0.1;
            //2. bring next_fs from the right(50%)
            left = (now * 50)+"%";
            //3. increase opacity of next_fs to 1 as it moves in
            opacity = 1 - now;
            current_fs.css({'transform': 'scale('+scale+')'});
            next_fs.css({'left': left, 'opacity': opacity});
        },
        duration: 800,
        complete: function(){
            current_fs.hide();
            animating = false;
        },
        //this comes from the custom easing plugin
        easing: 'easeInOutBack'
    });
    });

    $("#bodycontent").on("click",".previous",function(){
    if(animating) return false;
    animating = true;

    current_fs = $(this).parent();
    previous_fs = $(this).parent().prev();

    //de-activate current step on progressbar
    $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

    //show the previous fieldset
    previous_fs.show();
    //hide the current fieldset with style
    current_fs.animate({opacity: 0}, {
        step: function(now, mx) {
            //as the opacity of current_fs reduces to 0 - stored in "now"
            //1. scale previous_fs from 80% to 100%
            scale = 0.99 + (1 - now) * 0.01;
            //2. take current_fs to the right(50%) - from 0%
            left = ((1-now) * 50)+"%";
            //3. increase opacity of previous_fs to 1 as it moves in
            opacity = 1 - now;
            current_fs.css({'left': left});
            previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
        },
        duration: 800,
        complete: function(){
            current_fs.hide();
            animating = false;
        },
        //this comes from the custom easing plugin
        easing: 'easeInOutBack'
    });
    });

    $(".submit").click(function () {
        $('#processing_data').removeClass('hidden');
        $('#donation_form fieldset').fadeOut(300);
        return false;
     });
	
})

            
            
                
            
            
        