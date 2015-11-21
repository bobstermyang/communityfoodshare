<div class="text-box-parti">
    <form action="" method="get" class="validate">
        <div class="form-input">
            <label><sup>*</sup> Team Name:</label>
            <input type="text" name="tname" value="<?php echo isset($_GET['tname']) ? $_GET['tname'] : ''; ?>" placeholder="Enter Team Name" class="required" />
        </div>
        <div class="form-input">
            <label><sup>*</sup> Company Fundraising Goal:</label>
            <input type="text" name="tgoal" value="<?php echo isset($_GET['tname']) ? $_GET['tname'] : ''; ?>" placeholder="Enter Team Fundraising Goal" class="required" />
        </div>
        <div class="nevigation-btn">
            
            <input type="hidden" name="cid" value="<?php echo $_GET['cid'];?>" />
            <input type="hidden" name="step" value="2" />
            <input type="submit" name="" value="Next" />
        </div>
    </form>
</div>