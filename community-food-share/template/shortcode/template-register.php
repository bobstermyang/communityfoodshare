<div class="main-section">
        
        <div class="text-box-parti">            
            <form id="frmcfsregister" method="post" enctype="multipart/form-data">
		        <div class="form-input">
			        <label><sup>*</sup>Company Name</label>
			        <input type="text" name="companyname" id="companyname" placeholder="" class="required" value="<?php echo isset($_POST['companyname']) ? $_POST['companyname'] : ''; ?>" />					
		        </div>
		        <div class="form-input">
			        <label><sup>*</sup>Number of Employee</label>
			        <input type="text" name="noofemployee" id="noofemployee" placeholder="" class="required"  value="<?php echo isset($_POST['noofemployee']) ? $_POST['noofemployee'] : ''; ?>"/>					
		        </div>
		        <div class="form-input">
			        <label><sup>*</sup>Company Goal</label>
			        <input type="text" name="companygoal" id="companygoal" placeholder="" class="required"  value="<?php echo isset($_POST['companygoal']) ? $_POST['companygoal'] : ''; ?>" />					
		        </div>
		        <div class="form-input">
			        <label><sup>*</sup>Conatct Email</label>
			        <input type="email" name="email" id="email" placeholder="" class="required"   value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>"/>					
		        </div>
		        <div class="form-input">
			        <label><sup>*</sup>Contact Number</label>
			        <input type="text" name="contactnumber" id="contactnumber" placeholder="" class="required"  value="<?php echo isset($_POST['contactnumber']) ? $_POST['contactnumber'] : ''; ?>" />					
		        </div>
		        <div class="form-input">
			        <label><sup>*</sup>Logo Image</label>
			        <input type="file" name="logoimg" id="logoimg" placeholder="" class="required" accept="image/x-png, image/png, image/jpg, image/JPG,image/JPEG, image/jpeg"/>						
		        </div>
		        <div class="form-input">
			        <label>Company Teams</label>
                        <div class="btn-join">
                            <a class=" add-more-team">Add More</a>
                        </div>
			        <div class="team-section from-input">                        
                        <?php
                            if(isset($_POST['team']))
                            {
                                for($i=0;$i<sizeof($_POST['team']);$i++)
                                {
                                    ?>
                                    <div class="each-team from-input">
                                        <label><sup>*</sup></label><input type="text" name="team[]" class="<?php if($i==0) { echo "required"; } ?>" value="<?php echo $_POST['team'][$i];?>"/>            
                                    </div>
                                    <?php    
                                }
                            }
                            else
                            {
                        ?>
				        <div class="each-team from-input">
					        <label><sup>*</sup>Team Name: </label><input type="text" name="team[]" class="required"/>			
				        </div>
                        <?php
                            }
                        ?>
			        </div>
		        </div>
                <div class="form-input">
                    <input type="hidden" name="hidden_action_register" value="register_cfs" />
                    <input type="hidden" name="hidden_register_url" value="<?php echo get_permalink(); ?>" />
                    <input type="submit" name="registerme" value="Register" class="yellowbtn"/>
                </div>
            </form>
	    </div>
    </div>
    