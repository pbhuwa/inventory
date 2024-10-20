<h5 class="ov_lst_ttl"><b>Depreciation Setting Detail</b></h5>
<ul class="pm_data pm_data_body">

<li>
	<label> Depreciation Method:</label>
	<span>
		<?php 
		echo !empty($assets_rec_data[0]->dety_depreciation)?$assets_rec_data[0]->dety_depreciation:'';
		?>

	</span>
</li>

<li>
	<label> Depreciation Start:</label>
	<span><?php 
	if(DEFAULT_DATEPICKER=='NP'){
		echo !empty($assets_rec_data[0]->asen_depreciationstartdatebs)?$assets_rec_data[0]->asen_depreciationstartdatebs:'' ;
	}else{
		echo !empty($assets_rec_data[0]->asen_depreciationstartdatead)?$assets_rec_data[0]->asen_depreciationstartdatead:'' ;
	}
	?></span>
</li>

<li>
	<label>Purchase Date:</label>
	<span><?php 
	if(DEFAULT_DATEPICKER=='NP'){
		echo !empty($assets_rec_data[0]->asen_purchasedatebs)?$assets_rec_data[0]->asen_purchasedatebs:'' ;
	}else{
		echo !empty($assets_rec_data[0]->asen_purchasedatead)?$assets_rec_data[0]->asen_purchasedatead:'' ;
	}
	?></span>
</li>
<li>
	<label> Purchase Rate:</label>
	<span><?php echo !empty($assets_rec_data[0]->asen_purchaserate)?$assets_rec_data[0]->asen_purchaserate:'' ;?></span>
</li>

<li>
	<label> Service Start Date:</label>
	<span><?php 
	if(DEFAULT_DATEPICKER=='NP'){
		echo !empty($assets_rec_data[0]->asen_inservicedatebs)?$assets_rec_data[0]->asen_inservicedatebs:'' ;
	}else{
		echo !empty($assets_rec_data[0]->asen_inservicedatead)?$assets_rec_data[0]->asen_inservicedatead:'' ;
	}
	?></span>
</li>
<li>
	<label> Warrenty Start Date:</label>
	<span><?php 
	if(DEFAULT_DATEPICKER=='NP'){
		echo !empty($assets_rec_data[0]->asen_warrentystartdatebs)?$assets_rec_data[0]->asen_warrentystartdatebs:'' ;
	}else{
		echo !empty($assets_rec_data[0]->asen_warrentystartdatead)?$assets_rec_data[0]->asen_warrentystartdatead:'' ;
	}
	?></span>
</li>


<li>
	<label> Warrenty End Date:</label>
	<span><?php 
	if(DEFAULT_DATEPICKER=='NP'){
		echo !empty($assets_rec_data[0]->asen_warrentydatebs)?$assets_rec_data[0]->asen_warrentydatebs:'' ;
	}else{
		echo !empty($assets_rec_data[0]->asen_warrentydatead)?$assets_rec_data[0]->asen_warrentydatead:'' ;
	}
	?></span>
</li>

</ul>

<h5 class="ov_lst_ttl"><b>Depreciation Detail</b></h5>
 <?php 

		  $total=0;
          $totaldeptilldateval=0;
          $accmulatdepprevyrs=0;
          $accmulateval=0;
          $opbalance=0;

      $all_cat_tamt=0;
      $all_totaldeptilldateval=0;
      $all_accmulatdepprevyrs=0;
      $all_accmulateval=0;
      $all_opbalance=0;
	
	
		if(!empty($depreciation_report_data)):		
		?>
		<div class="table-wrapper" id="tblwrapper">
		<table id="" class="format_pdf" width="100%" >
    <thead style="background: #cccaca;">
        <tr>
            <th width="2%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="10%"><?php echo $this->lang->line('ass_code'); ?></th>
            <th width="10%"><?php echo $this->lang->line('assets'); ?></th>
            <th width="8%"><?php echo $this->lang->line('pur_date'); ?></th>
            <th width="8%"><?php echo $this->lang->line('s_date'); ?></th>
            <th width="8%"><?php echo $this->lang->line('e_date'); ?></th>
            <th width="8%"><?php echo $this->lang->line('pur_cost'); ?></th>
            <th width="8%"><?php echo $this->lang->line('ope_balance'); ?></th>
            <th width="8%"><?php echo $this->lang->line('deprate'); ?>(%)</th>
            <th width="8%"><?php echo $this->lang->line('f_year'); ?></th>
            <th width="8%"><?php echo $this->lang->line('accm_val'); ?></th>
            <th width="8%"><?php echo $this->lang->line('accmulatdepprevyrs'); ?></th>
            <th width="8%"><?php echo $this->lang->line('totaldeptilldateval'); ?></th>
            <th width="10%"><?php echo $this->lang->line('netvalue'); ?></th>
          </tr>
    </thead>
    <tbody>
        <?php 
          $i=1;
          foreach ($depreciation_report_data as $key => $result): 
          $total=$total+$result->dete_netvalue;
          $totaldeptilldateval=$totaldeptilldateval+$result->dete_totaldeptilldateval;
          $accmulatdepprevyrs=$accmulatdepprevyrs+$result->dete_accmulatdepprevyrs;
          $accmulateval=$accmulateval+$result->dete_accmulateval;
          $opbalance=$opbalance+$result->dete_opbalance;

        ?>
        <tr>
            <td><?php echo $key+1;?></td>
            <td><?php echo $result->asen_assetcode; ?></td>
            <td><?php echo $result->asen_desc; ?></td>
      			<td><?php echo $result->dete_purchasedatebs; ?></td>
      			<td><?php echo $result->dete_startdatebs; ?></td>
      			<td><?php echo $result->dete_enddatebs; ?></td>
      			<td><?php echo number_format($result->dete_orginalcost,2); ?></td>
      			<td><?php echo number_format($result->dete_opbalance,2); ?></td>
      			<td><?php echo $result->dete_deprate; ?></td>
            <td><?php echo $result->dete_fiscalyrs; ?></td>
            <td><?php echo number_format($result->dete_accmulateval,2); ?></td>
            <td><?php echo number_format($result->dete_accmulatdepprevyrs,2); ?></td>
            <td><?php echo number_format($result->dete_totaldeptilldateval,2); ?></td>
            <td><?php $netval_last=$result->dete_netvalue; echo number_format($netval_last,2) ?></td>
        </tr>
        <?php
        $i++;
        endforeach;
        ?>
    </tbody>
    <tr class="table_bold">
      <td colspan="7">Total</td>
      <td><?php echo number_format($opbalance,2); ?></td>
      <td></td>
      <td></td>
      <td><?php echo number_format($accmulateval,2); ?></td>
      <td><?php echo number_format($accmulatdepprevyrs,2); ?></td>
      <td><?php echo number_format($totaldeptilldateval,2); ?></td>
      <td><?php echo number_format($netval_last,2); ?></td>
    </tr>
</table>
</div>

<?php endif; 
?>