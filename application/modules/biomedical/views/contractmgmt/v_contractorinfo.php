<?php
	if($type == 'manufacturers'){
		$contractorid = !empty($contractorInfo[0]->manu_manlistid)?$contractorInfo[0]->manu_manlistid:'';
		$contractorName = !empty($contractorInfo[0]->manu_manlst)?$contractorInfo[0]->manu_manlst:'';
		$contractorAddress1 = !empty($contractorInfo[0]->manu_address1)?$contractorInfo[0]->manu_address1:'';
		$contractorAddress2 = !empty($contractorInfo[0]->manu_address2)?$contractorInfo[0]->manu_address2:'';
		$contractorCity = !empty($contractorInfo[0]->manu_city)?$contractorInfo[0]->manu_city:'';
		$contractorPhone1 = !empty($contractorInfo[0]->manu_phone1)?$contractorInfo[0]->manu_phone1:'';
		$contractorPhone2 = !empty($contractorInfo[0]->manu_phone2)?$contractorInfo[0]->manu_phone2:'';
		$contractorEmail = !empty($contractorInfo[0]->manu_email)?$contractorInfo[0]->manu_email:'';
		$contractorFax = !empty($contractorInfo[0]->manu_fax)?$contractorInfo[0]->manu_fax:'';
	}else if($type == 'distributors'){
		$contractorid = !empty($contractorInfo[0]->dist_distributorid)?$contractorInfo[0]->dist_distributorid:'';
		$contractorName = !empty($contractorInfo[0]->dist_distributor)?$contractorInfo[0]->dist_distributor:'';
		$contractorAddress1 = !empty($contractorInfo[0]->dist_address1)?$contractorInfo[0]->dist_address1:'';
		$contractorAddress2 = !empty($contractorInfo[0]->dist_address2)?$contractorInfo[0]->dist_address2:'';
		$contractorCity = !empty($contractorInfo[0]->dist_city)?$contractorInfo[0]->dist_city:'';
		$contractorPhone1 = !empty($contractorInfo[0]->dist_phone1)?$contractorInfo[0]->dist_phone1:'';
		$contractorPhone2 = !empty($contractorInfo[0]->dist_phone2)?$contractorInfo[0]->dist_phone2:'';
		$contractorEmail = !empty($contractorInfo[0]->dist_email)?$contractorInfo[0]->dist_email:'';
		$contractorFax = !empty($contractorInfo[0]->dist_fax)?$contractorInfo[0]->dist_fax:'';
	}
?>
<?php if(!empty($contractorid)):?>
<div id="FormDiv_PmData" class="search_pm_data">
	<ul class="pm_data pm_data_body">
		<li>
			<label><?php echo $this->lang->line('contracter_id'); ?></label>
			<?php echo $contractorid;?>
		</li>
		<li>
			<label><?php echo $this->lang->line('name'); ?></label>
			<?php echo $contractorName;?>
		</li>
		<li>
			<label><?php echo $this->lang->line('address'); ?></label>
			<?php echo $contractorAddress1.', '.$contractorAddress2.', '.$contractorCity;?>
		</li>
		<li>
			<label><?php echo $this->lang->line('phone'); ?> </label>
			<?php echo $contractorPhone1;?>
		</li>
		<li>
			<label><?php echo $this->lang->line('phone'); ?></label>
			<?php echo $contractorPhone2;?>
		</li>
		<li>
			<label><?php echo $this->lang->line('email'); ?></label>
			<?php echo $contractorEmail;?>
		</li>
		<li>
			<label><?php echo $this->lang->line('fax'); ?></label>
			<?php echo $contractorFax;?>
		</li>
	</ul>
</div>
<?php endif; ?>

<?php
	if(!empty($contractsInfo)):
?>
	<h3 class="box-title">History</h3>
	<div class="table-responsive">
		<table id="" class="table flatTable tcTable compact_Table" >
			<thead>
				<tr>
					<th width="10%">St. Date(AD)</th>
					<th width="10%">St. Date(BS)</th>
					<th width="10%">End Date(AD)</th>
					<th width="10%">End Date(BS)</th>
					<th width="15%">Name</th>
					<th width="15%">Title</th>
					<th width="10%">Value</th>
					<th width="15%">Description</th>
					<th width="10%">Status</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<?php
						$startdateAD = !empty($contractsInfo[0]->coin_contractstartdatead)?$contractsInfo[0]->coin_contractstartdatead:'';
						$enddateAD = !empty($contractsInfo[0]->coin_contractenddatead)?$contractsInfo[0]->coin_contractenddatead:'';
						
						$startdate = strtotime($startdateAD);
						$enddate = strtotime($enddateAD);

						$dateCalc = $enddate-$startdate;
						if($dateCalc > 0){
							$status = "Active";
							$class='label-success';
						}else{
							$status = "Expire";
							$class='label-danger';
						}
					?>
					<td><?php echo $startdateAD;?></td>
					<td><?php echo !empty($contractsInfo[0]->coin_contractstartdatebs)?$contractsInfo[0]->coin_contractstartdatebs:'';?></td>
					<td><?php echo !empty($contractsInfo[0]->coin_contractenddatead)?$contractsInfo[0]->coin_contractenddatead:'';?></td>
					<td><?php echo !empty($contractsInfo[0]->coin_contractenddatebs)?$contractsInfo[0]->coin_contractenddatebs:'';?></td>
					<td><?php echo !empty($contractsInfo[0]->dist_distributor)?$contractsInfo[0]->dist_distributor:'';?></td>
					<td><?php echo !empty($contractsInfo[0]->coin_contracttitle)?$contractsInfo[0]->coin_contracttitle:'';?></td>
					<td><?php echo !empty($contractsInfo[0]->coin_contractvalue)?$contractsInfo[0]->coin_contractvalue:'';?></td>
					<td><?php echo !empty($contractsInfo[0]->coin_description)?$contractsInfo[0]->coin_description:'';?></td>
					<td><a href="javascript:void(0)" class=" label <?php echo $class; ?> btn-xs"><?php echo $status; ?> </a></td>
				</tr>
			</tbody>
		</table>
	</div>
<?php
	endif;
?>