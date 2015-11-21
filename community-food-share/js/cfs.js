
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
            
                        jQuery('#frmRegisterCFS').submit(function(){
                              jQuery('.loader').removeClass('hide');      
                              jQuery.ajax({
                                    type: "POST",
                                    url: cfs.ajax,
                                    data: jQuery('#frmRegisterCFS').serialize(),
                                    dataType:'json',
                                    success: function(result){
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
		});