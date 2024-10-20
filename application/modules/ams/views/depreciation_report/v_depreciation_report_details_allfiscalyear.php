<div class="white-box pad-5 mtop_10 pdf-wrapper">
	<div class="jo_form organizationInfo" id="printrpt">
	 <?php  $this->load->view('common/v_report_header',$this->data); ?>
	 <?php 
   if(!empty($depreciation_report_data)): 
    foreach ($depreciation_report_data as $ki => $fiscal): ?>
		<br>
		<table class="jo_tbl_head">
				<tr>
					<td>
					<strong>Fiscal Year:<?php echo $fiscal->dete_fiscalyrs; ?></strong>
					</td>
				</tr>
		</table> 
	<?php 

	$categorydata=$this->deprecation_report_mdl->distinct_category_list(array('dete_fiscalyrs'=>$fiscal->dete_fiscalyrs),false,false,false,'ASC',false,false);
  // echo $this->db->last_query();
  // die();
	 // print_r($categorydata);die();
	if(!empty($categorydata)): 
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
		foreach ($categorydata as $ki => $cat): ?>
		<br>
		<table class="jo_tbl_head">
				<tr>
					<td>
					<strong><?php echo $cat->eqca_category; ?></strong>
					</td>
				</tr>
		</table>

	<?php 
		$ass_details=$this->deprecation_report_mdl->get_depreciation_list_data(array('asen_assettype'=>$cat->eqca_equipmentcategoryid,'dete_fiscalyrs'=>$fiscal->dete_fiscalyrs),false,false,false,'ASC',false,false); 
		// print_r($ass_details);die();
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
<!-- </table>
 -->
<?php endif; 
$all_cat_tamt +=$total;
$all_totaldeptilldateval +=$totaldeptilldateval;
$all_accmulatdepprevyrs +=$accmulatdepprevyrs;
$all_accmulateval += $accmulateval;
$all_opbalance += $opbalance;


endforeach; ?>
<tr><td colspan="14" style="border:0"></td></tr>
<!-- <br>
<table id="" class="format_pdf" width="100%"> -->
      <tr>
        <td  colspan="7" >Grand Total</td>
        <td ><?php echo number_format($all_opbalance,2);?></td>
        <td ></td>
        <td ></td>
        <td ><?php echo number_format($all_accmulateval,2);?></td>
        <td ><?php echo number_format($all_accmulatdepprevyrs,2);?></td>
        <td ><?php echo number_format($all_totaldeptilldateval,2);?></td>
        <td ><?php echo number_format($all_cat_tamt,2);?></td>      
      </tr>
</table>
<?php endif; endforeach; ?>
<?php endif;?>