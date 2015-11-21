	<div class="search-result">
		<div class="search-result-title">
			<h3>Search Results</h3>
		</div>
		<div class="btn-join">
			<a href="?step=1&da=new&cid=<?php echo $_GET['cid']?>&tid=0">Create Team</a>
		</div>
        <?php
        if(count($team_list) > 0){
            //echo $team_list['found_posts'];
        ?>
		<div class="search-pagination hide">
			<span>Viewing <strong>1-1</strong> of 1 </span>
			<a href="#">Previous</a>
			<span>|</span>
			<a href="#">Next</a>
		</div>
		<div class="shorting-list">
			<span>Sort By:</span>
			<select>
				<option></option>
				<option>Company Name (A-Z)</option>
				<option>Company Name (Z-A)</option>
			</select>
		</div>
		<?php foreach($team_list['data'] as $team){?>
        <div class="box-detail">
			<a href="#"><?php echo $team['name'];?></a>
			<div class="comp-detail">
				<span class="comp-title">Team Leader:</span>
				<span><?php echo $team['owner'];?></span>
			</div>
			<div class="btn-join">
				<a href="?step=2&tid=<?php echo $team['id'];?>">Join</a>
			</div>
		</div>
        <?php
        }
        ?>
		<div class="search-pagination hide">
			<span>Viewing <strong>1-1</strong> of 1 </span>
			<a href="#">Previous</a>
			<span>|</span>
			<a href="#">Next</a>
		</div>
        <?php
        }else{
			echo 'No Team Exist!';	
		}
        ?>
    </div>
