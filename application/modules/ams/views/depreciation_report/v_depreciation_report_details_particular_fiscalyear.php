<div class="white-box pad-5 mtop_10 pdf-wrapper">
	<div class="jo_form organizationInfo" id="printrpt">
		<?php  $this->load->view('common/v_report_header',$this->data); ?>
		<table class="jo_tbl_head">
			<tr>
				<td>
					<strong>Fiscal Year : <?php echo $fiscal_year; ?></strong>
				</td>
			</tr>
		</table> 
		<?php 

// print_r($depreciation_report_data);die();
		if(!empty($depreciation_report_data)): 
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
			foreach ($depreciation_report_data as $ki => $ass): ?>
				<br>
				<table class="jo_tbl_head">
					<tr>
						<td>
							<strong><?php echo $ass->eqca_category; ?></strong>
						</td>
					</tr>
				</table>

				<?php 
        $asen_asenid=!empty($this->input->post('asen_asenid'))?$this->input->post('asen_asenid'):'';

        if(!empty($asen_asenid)){
           $ass_details=$this->deprecation_report_mdl->get_depreciation_list_data(array('asen_assettype'=>$ass->eqca_equipmentcategoryid,'dete_fiscalyrs'=>$fiscal_year,'dete_assetid'=>$asen_asenid),false,false,false,'ASC',false); 
         }else{
           $ass_details=$this->deprecation_report_mdl->get_depreciation_list_data(array('asen_assettype'=>$ass->eqca_equipmentcategoryid,'dete_fiscalyrs'=>$fiscal_year),false,false,false,'ASC',false);
         }
          // die();
      
		// echo $this->db->last_query();
				if(!empty($ass_details)):		
					?>

				<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
          <th width="2%"><?php echo $this->lang->line('sn'); ?></th>
          <th width="10%"><?php echo $this->lang->line('ass_code'); ?></th>
          <th width="10%"><?php echo $this->lang->line('assets'); ?></th>
          <th width="8%"><?php echo $this->lang->line('pur_date'); ?></th>
          <th width="8%"><?php echo $this->lang->line('s_date'); ?></th>
          <th width="8%"><?php echo $this->lang->line('e_date'); ?></th>
          <th width="8%"><?php echo $this->lang->line('pur_cost'); ?></th>
          <th width="8%"><?php echo $this->lang->line('ope_balance'); ?></th>
          <th width="8%"><?php echo $this->lang->line('deprate'); ?></th>
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
          // $total=0;
          // $totaldeptilldateval=0;
          // $accmulatdepprevyrs=0;
          // $accmulateval=0;
          // $opbalance=0;

          foreach ($ass_details as $key => $result): 
        
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
            <td><?php echo number_format($result->dete_deprate,2); ?></td>
            <td><?php echo $result->dete_fiscalyrs; ?></td>
            <td><?php echo number_format($result->dete_accmulateval,2); ?></td>
            <td><?php echo number_format($result->dete_accmulatdepprevyrs,2); ?></td>
            <td><?php echo number_format($result->dete_totaldeptilldateval,2); ?></td>
            <td><?php echo number_format($result->dete_netvalue,2); ?></td>
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
      <td><?php echo number_format($total,2); ?></td>
    </tr>


<?php endif; 
  $all_cat_tamt +=$total;
  $all_totaldeptilldateval +=$totaldeptilldateval;
  $all_accmulatdepprevyrs +=$accmulatdepprevyrs;
  $all_accmulateval += $accmulateval;
  $all_opbalance += $opbalance;
endforeach; ?>
<tr>
  <td colspan="15"></td>
</tr>
<tr>
  <th width="5%">Grand Total</th>
  <td width="8%"></td>
  <td width="8%"></td>
  <td width="8%"></td>
  <td width="8%"></td>
  <td width="8%"></td>
  <td width="8%"></td>
  <td width="8%"><?php echo number_format($all_opbalance,2);?></td>
  <td width="8%"></td>
  <td width="8%"></td>
  <td width="8%"><?php echo number_format($all_accmulateval,2);?></td>
  <td width="8%"><?php echo number_format($all_accmulatdepprevyrs,2);?></td>
  <td width="8%"><?php echo number_format($all_totaldeptilldateval,2);?></td>
  <td width="8%"><?php echo number_format($all_cat_tamt,2);?></td>      
</tr>
</table>
<?php endif;?>