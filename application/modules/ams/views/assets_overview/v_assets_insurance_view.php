<h5 class="ov_lst_ttl"><b>Insurance Detail</b></h5>
<ul class="pm_data pm_data_body">

<li>
	<label> Insurance Company:</label>
	<span>
		<?php 
		echo !empty($insurance_data_rec[0]->inco_name)?$insurance_data_rec[0]->inco_name:'';
		?>
		<?php 
		$comaddr= !empty($insurance_data_rec[0]->inco_address1)?$insurance_data_rec[0]->inco_address1:'' ; 
		if($comaddr){
			echo '('.$comaddr.')';
		}
		?>
	</span>
</li>

<li>
	<label> Insurance Policy Number:</label>
	<span><?php echo !empty($insurance_data_rec[0]->asin_policyno)?$insurance_data_rec[0]->asin_policyno:'' ;?></span>
</li>

<li>
	<label>Policy Start Date:</label>
	<span><?php 
	if(DEFAULT_DATEPICKER=='NP'){
		echo !empty($insurance_data_rec[0]->asin_startdatebs)?$insurance_data_rec[0]->asin_startdatebs:'' ;
	}else{
		echo !empty($insurance_data_rec[0]->asin_startdatead)?$insurance_data_rec[0]->asin_startdatead:'' ;
	}
	?></span>
</li>
<li>
	<label> Policy End Date:</label>
	<span><?php 
	if(DEFAULT_DATEPICKER=='NP'){
		echo !empty($insurance_data_rec[0]->asin_enddatebs)?$insurance_data_rec[0]->asin_enddatebs:'' ;
	}else{
		echo !empty($insurance_data_rec[0]->asin_enddatead)?$insurance_data_rec[0]->asin_enddatead:'' ;
	}
	?></span>
</li>
<li>
	<label> Insurance Value:</label>
	<span><?php echo !empty($insurance_data_rec[0]->asin_insuranceamount)?$insurance_data_rec[0]->asin_insuranceamount:'' ;?></span>
</li>


<li>
	<label> Insurance Frequency:</label>
	<span>
		<?php echo !empty($insurance_data_rec[0]->frty_name)?$insurance_data_rec[0]->frty_name:'' ;?>
	</span>
</li>
<li>
	<label> Payment Amount:</label>
	<span>
		<?php echo !empty($insurance_data_rec[0]->asin_insurancerate)?$insurance_data_rec[0]->asin_insurancerate:'' ;?>
	</span>
</li>

</ul>
