<?php
        $step = isset($_GET['step']) ? $_GET['step'] : 1;
        $stepNo = 1;
        $payment = true;
        if(isset($_GET['txtPd']) && $_GET['txtPd'] == ''){
                $payment = false;
        }
?>
<div>
    <div class="donation-registration-progress table">
        <div class="table-row">
            <div class="table-cell <?php echo $step == 1 ? 'active' : '' ?>">
                <span><?php echo $stepNo++;?></span> Get Started
            </div>
        <?php if(!isset($_REQUEST['cgoal'])){?>
            <div class="table-cell <?php echo $step == 2 ? 'active' : '' ?>">
                <span><?php echo $stepNo++;?></span> Select Option
            </div>
        <?php }?>
            <div class="table-cell <?php echo $step == 3 ? 'active' : '' ?>">
                <span><?php echo $stepNo++;?></span> Provide Details
            </div>
            <div class="table-cell <?php echo $step == 4 ? 'active' : '' ?>">
                <span><?php echo $stepNo++;?></span> Review
            </div>
        <?php if(!isset($_REQUEST['cgoal']) && $payment){?>
            <div class="table-cell <?php echo $step == 5 ? 'active' : '' ?>">
                <span><?php echo $stepNo++;?></span> Payment
            </div>
        <?php }?>
        </div>
    </div>
    <?php
        require_once(CFS_PLUGIN_URL.'template/shortcode/template-donation-step'.$step.'.php');
    ?>
</div>