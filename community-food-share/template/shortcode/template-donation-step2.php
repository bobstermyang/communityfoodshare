<?php
$cfs_settings = get_option('cfs_settings');
$goal = get_post_meta( $_GET['tid'], '_donation_goal', true );
$suggested_goal = $goal ? $goal : $cfs_settings['bussiness_goal'];
?>
<div class="participant">
    <form action="" mathod="get">
		<span>Participant Options</span>
        <div class="text-box-parti">
			<label>Your Fundraising Goal:</label>
			$<input type="text" name="txtPg" placeholder="" value="<?php echo $suggested_goal;?>" />
			<span><small>Suggested Goal: $<?php echo $suggested_goal;?></small></span>
		</div>
        <div class="text-define">
			<span>Do you want to jump start your fundraising by making a personal donation?</span>
		<div class="text-box-parti">
			<label>Donation amount:</label>
			<input type="text" name="txtPd" placeholder="" />
			<div class="chkboxdiv"><input type="checkbox" name="chkGift" value="1" /><span>Yes, make this an anonymous gift.</span></div>
			<div class="chkboxdiv"><input type="checkbox" checked="checked" value="1" name="chkAmound" /><span>Yes, you can display the amount of my donation publicly.</span></div>
        </div>
		</div>
        <div class="nevigation-btn">
            <input type="button" value="Previous Step" />
				<?php get_all_query_fields();?>
			<input type="submit" value="Next Step" class="nevi-right" name="">
            <input type="hidden" name="step" value="3" />
		</div>
    </form>
</div>
	