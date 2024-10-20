<h5 class="ov_lst_ttl"><b>Lease Detail</b></h5>
<ul class="pm_data pm_data_body">

<li>
	<label> Lease Company:</label>
	<span>
		<?php 
		echo !empty($lease_data_rec[0]->leco_companyname)?$lease_data_rec[0]->leco_companyname:'';
		?>
		<?php 
		$comaddr= !empty($leco_company_address[0]->leco_company_address)?$leco_company_address[0]->leco_company_address:'' ; 
		if($comaddr){
			echo '('.$comaddr.')';
		}
		?>
	</span>
</li>

<li>
	<label> Lease Contract No:</label>
	<span><?php echo !empty($lease_data_rec[0]->lema_contractno)?$lease_data_rec[0]->lema_contractno:'' ;?></span>
</li>

<li>
	<label>Lease Start Date:</label>
	<span><?php 
	if(DEFAULT_DATEPICKER=='NP'){
		echo !empty($lease_data_rec[0]->lema_startdatebs)?$lease_data_rec[0]->lema_startdatebs:'' ;
	}else{
		echo !empty($lease_data_rec[0]->lema_startdatead)?$lease_data_rec[0]->lema_startdatead:'' ;
	}
	?></span>
</li>
<li>
	<label> Lease End Date:</label>
	<span><?php 
	if(DEFAULT_DATEPICKER=='NP'){
		echo !empty($lease_data_rec[0]->lema_enddatebs)?$lease_data_rec[0]->lema_enddatebs:'' ;
	}else{
		echo !empty($lease_data_rec[0]->lema_enddatead)?$lease_data_rec[0]->lema_enddatead:'' ;
	}
	?></span>
</li>
<li>
	<label> Initial Cost:</label>
	<span><?php echo !empty($lease_data_rec[0]->lede_initcost)?$lease_data_rec[0]->lede_initcost:'' ;?></span>
</li>


<li>
	<label> Rental Amount:</label>
	<span>
		<?php echo !empty($lease_data_rec[0]->lede_rental_amt)?$lease_data_rec[0]->lede_rental_amt:'' ;?>
	</span>
</li>
<li>
	<label> Frequency:</label>
	<span>
		<?php echo !empty($lease_data_rec[0]->frty_name)?$lease_data_rec[0]->frty_name:'' ;?>
	</span>
</li>

</ul>

<!-- <h5 class="ov_lst_ttl"><b>Lease Payment Detail</b></h5> -->