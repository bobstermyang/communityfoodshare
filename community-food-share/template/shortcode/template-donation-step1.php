<?php
    $company_list = array();
	$company_name = '';
    if(isset($_GET['cname'])){
        $company_list = get_company_list($_GET['cname']);
		$company_name = $_GET['cname'];
    }
    if(isset($_GET['cid'])){
        $team_list = get_team_list($_GET['cid']);
		$company_name = get_the_title($_GET['cid']);
    }
?>
	<div class="main-section">
        <?php
        if(!isset($_GET['da'])){
        ?>
		<div class="company-name">
            <form action="" method="get" class="validate">
                <label><sup>*</sup> Company Name:</label>
                <input type="text" name="cname" value="<?php echo $company_name; ?>" placeholder="Enter Company Name" class="required" />
                <input type="submit" name="" value="Search a Company" />
                <a href="?step=1&da=new" >Create a Company</a>
            </form>
		</div>
        <?php
        }else{
			if(isset($_GET['tid'])){
				require_once(CFS_PLUGIN_URL.'/template/shortcode/template-donation-create-team.php');            
			}else{
				require_once(CFS_PLUGIN_URL.'/template/shortcode/template-donation-create-company.php');            
			}
        }
if(isset($_GET['cname']) && !isset($_GET['da'])){
	require_once(CFS_PLUGIN_URL.'/template/shortcode/template-donation-company-list.php');            
}
if(isset($_GET['cid']) && !isset($_GET['da'])){
	require_once(CFS_PLUGIN_URL.'/template/shortcode/template-donation-team-list.php');    
}
?>
</div>