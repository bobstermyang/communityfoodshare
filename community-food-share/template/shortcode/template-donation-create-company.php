
		<div class="text-box-parti">
            <form action="" method="get" class="validate">
				<div class="form-input">
					<label><sup>*</sup> Company Name:</label>
					<input type="text" name="cname" value="<?php echo isset($_GET['cname']) ? $_GET['cname'] : ''; ?>" placeholder="Enter Company Name" class="required" />
				</div>
				<div class="form-input">
					<label><sup>*</sup> Company Fundraising Goal:</label>
					<input type="text" name="cgoal" value="<?php echo isset($_GET['cgoal']) ? $_GET['cgoal'] : ''; ?>" placeholder="Enter Company Fundraising Goal" class="required" />
				</div>
				<div class="nevigation-btn">
					<input type="hidden" name="step" value="3" />
					<input type="submit" name="" value="Next" />
				</div>
            </form>
		</div>