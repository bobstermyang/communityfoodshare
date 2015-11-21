<div class="search-result">
		<div class="search-result-title">
			<h3>Search Results</h3>
		</div>
        <?php
        if(count($company_list) > 0){
            //echo $company_list['found_posts'];
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
		<?php foreach($company_list['data'] as $company){?>
        <div class="box-detail">
			<a href="#"><?php echo $company['name'];?></a>
			<div class="comp-detail">
				<span class="comp-title">Company Owner:</span>
				<span><?php echo $company['owner'];?></span>
			</div>
			<div class="btn-join">
				<a href="?step=1&cid=<?php echo $company['id'];?>">View Teams</a>
			</div>
		<div class="btn-join">
			<a href="?step=1&da=new&cid=<?php echo $company['id']?>&tid=0">Create Team</a>
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
			echo 'No Company Exist!';	
		}
        ?>
    </div>