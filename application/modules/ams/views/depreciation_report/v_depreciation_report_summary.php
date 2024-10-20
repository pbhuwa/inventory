<div class="white-box pad-5 mtop_10 pdf-wrapper">
	<div class="jo_form organizationInfo" id="printrpt">
	 <?php  $this->load->view('common/v_report_header',$this->data); ?>
<?php if($rpt_type=='summary'): ?>	
		<br>
		<table class="jo_tbl_head">
				<tr>
					<td>
					<strong>Fiscal Year:<?php echo $fiscal_year; ?></strong>
					</td>
				</tr>
		</table> 
	<?php 

		      $total=0.00;
          $totaldeptilldateval=0.00;
          $accmulatdepprevyrs=0.00;
          $accmulateval=0.00;
          $opbalance=0.00;

          $all_cat_tamt=0.00;
          $all_totaldeptilldateval=0.00;
          $all_accmulatdepprevyrs=0.00;
          $all_accmulateval=0.00;
          $all_opbalance=0.00;
	
	
		if(!empty($list_rpt)):		
		?>
		<table id="" class="format_pdf" width="100%">
    <thead>
        <tr>
            <th width="2%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="8%">Category</th>
            <th width="8%">Opening Balance</th>
            <th width="8%"> Depreciation </th>
            <th width="8%"> Accmulate Dep. Prev. Yrs</th>
            <th width="8%"> Total Dep. Till Date</th>
            <th width="10%">Net Value</th>
          </tr>
    </thead>
    <tbody>
        <?php 
          $i=1;
          foreach ($list_rpt as $key => $result): 
          $total=$total+ round($result->netvalue,2);
          $totaldeptilldateval=$totaldeptilldateval+round($result->totaldeptilldateval,2);
          $accmulatdepprevyrs=$accmulatdepprevyrs+round($result->accmulatdepprevyrs,2);
          $accmulateval=$accmulateval+round($result->accmulateval,2);
          $opbalance=$opbalance+round($result->openbalance,2);

        ?>
        <tr>
            <td><?php echo $i;?></td>
           <td align="left"><?php echo $result->eqca_category; ?></td>
      			<td align="right"><?php echo round($result->openbalance,2) ?></td>
      		  <td align="right"><?php echo  round($result->accmulateval,2); ?></td>
            <td align="right"><?php echo round($result->accmulatdepprevyrs,2); ?></td>
            <td align="right"><?php echo round($result->totaldeptilldateval,2); ?></td>
            <td align="right"><?php echo round($result->netvalue,2); ?></td>
        </tr>
        <?php
        $i++;
        endforeach;
        ?>
    </tbody>
    <tr class="table_bold">
      <td colspan="2">Total</td>
      <td align="right"><strong><?php echo $opbalance; ?><strong></td>
      <td align="right"><strong><?php echo $accmulateval; ?><strong></td>
      <td align="right"><strong><?php echo $accmulatdepprevyrs; ?><strong></td>
      <td align="right"><strong><?php echo $totaldeptilldateval; ?><strong></td>
      <td align="right"><strong><?php echo $total; ?><strong></td>
    </tr>

<?php endif; 
?>
<?php endif; ?>

<?php if($rpt_type=='detail'): ?>
  <br>
    <table class="jo_tbl_head">
        <tr>
          <td colspan="12" align="center">
          <strong>Fiscal Year:<?php echo $fiscal_year; ?></strong>
          </td>
        </tr>
    </table> 

  <?php if(!empty($list_rpt)): ?>
    <table class="alt_table">
      <?php 
          $gsm_orginalcost=0.00;
          $gsm_openbalance=0.00;
          $gsm_accmulateval=0.00;
        
          $gsm_accmulatdepprevyrs=0.00;
          $gsm_totaldeptilldateval=0.00;
          $gsm_netvalue=0.00;
      foreach ($list_rpt as $kr => $rsl):  
 $ass_detail_list=array();
        $ass_typeid=$rsl->asen_assettype;
        if(!empty($ass_typeid) &&  !empty($fiscal_year)){
           $ass_detail_list=$this->deprecation_report_mdl->get_fiscalyrs_ass_cat_with_detail($fiscal_year,$ass_typeid);
           // echo $this->db->last_query();
        }

        // echo "<pre>";
        // print_r($ass_detail_list);
        // die();
       
        ?>
        <?php if(!empty($ass_detail_list)): ?>
     

      <table class="alt_table">
        <thead>
         <tr>
           <tr><td colspan="12">&nbsp;</td></tr>
        <td colspan="12"><strong><?php echo $rsl->eqca_category; ?></strong></td></tr>
         
      
      <tr>
        <th>S.n</th>
        <th>Purchase Date</th>
        <th>Asset Desctiption</th>
        <th>Qty</th>
        <th>Rate</th>
        <th>Original Cost</th>
        <th>Opening Cost</th>
        <th>Dep.(%)</th>
        <th>Acc. Dep</th>
        <th>Acc. Dep Prev. Yrs</th>
        <th>Total Dep</th>
        <th>Net Value</th>
        
      </tr>
    </thead>
      <?php 
    
          $sm_orginalcost=0.00;
          $sm_openbalance=0.00;
          $sm_accmulateval=0.00;
         
          $sm_accmulatdepprevyrs=0.00;
          $sm_totaldeptilldateval=0.00;
          $sm_netvalue=0.00;
      foreach ($ass_detail_list as $kad => $assrslt) {

       ?>
       <tr>
        <td><?php echo $kad+1; ?></td>
        <td><?php echo $assrslt->dete_purchasedatebs; ?></td>
        <td><?php echo $assrslt->asen_desc; ?></td>
        <td align="right"><?php echo $assrslt->qty; ?></td>
        <td align="right"><?php echo round($assrslt->rate,2); ?></td>
        <td align="right"><?php echo round($assrslt->orginalcost,2); ?></td>
        <td align="right"><?php echo round($assrslt->openbalance,2); ?></td>
        <td align="right"><?php echo round($assrslt->dete_deprate,2) ; ?></td>
        <td align="right"><?php echo round($assrslt->accmulateval,2); ?></td>
        <td align="right"><?php echo round($assrslt->accmulatdepprevyrs,2); ?></td>
        <td align="right"><?php echo round($assrslt->totaldeptilldateval,2); ?></td>
        <td align="right"><?php echo round($assrslt->netvalue,2); ?></td>
       </tr>
       <?php
      $sm_orginalcost += $assrslt->orginalcost;
      $sm_openbalance += $assrslt->openbalance;
      $sm_accmulateval += $assrslt->accmulateval;
      $sm_accmulatdepprevyrs += $assrslt->accmulatdepprevyrs;
      $sm_totaldeptilldateval += $assrslt->totaldeptilldateval;
      $sm_netvalue += $assrslt->netvalue;
      } ?>
       <tr><td colspan="12"></td></tr>
       <tr style="
    background: #807e7e;
    color: white;
">
      <td colspan="5">Total</td>
      <td align="right"><?php echo number_format($sm_orginalcost,2); ?></td>
      <td align="right"><?php echo number_format($sm_openbalance,2); ?></td>
      
       <td align="right"></td>
      <td align="right"><?php echo number_format($sm_accmulateval,2); ?></td>
      <td align="right"><?php echo number_format($sm_accmulatdepprevyrs,2); ?></td>
      <td align="right"><?php echo number_format($sm_totaldeptilldateval,2); ?></td>
      <td align="right"><?php echo number_format($sm_netvalue,2); ?></td>
    </tr>
     </table>
    <?php  endif; ?>
    <?php
          $gsm_orginalcost +=$sm_orginalcost;
          $gsm_openbalance +=$sm_openbalance;
          $gsm_accmulateval +=$sm_accmulateval;
          $gsm_accmulatdepprevyrs +=$sm_accmulatdepprevyrs;
          $gsm_totaldeptilldateval +=$sm_totaldeptilldateval;
          $gsm_netvalue +=$sm_netvalue;
    ?>
    <?php endforeach; ?>
   
    </table>
     <!-- <table class="alt_table">
      <tr><td colspan="12"></td></tr>
      <tr style="background: #807e7e;color: white;">
      <td colspan="5">Grand Total</td>
      <td align="right"><?php echo number_format($gsm_orginalcost,2); ?></td>
      <td align="right"><?php echo number_format($gsm_openbalance,2); ?></td>
      <td align="right"></td>
      <td align="right"><?php echo number_format($gsm_accmulateval,2); ?></td>
      <td align="right"><?php echo number_format($gsm_accmulatdepprevyrs,2); ?></td>
      <td align="right"><?php echo number_format($gsm_totaldeptilldateval,2); ?></td>
      <td align="right"><?php echo number_format($gsm_netvalue,2); ?></td>
    </tr>
    </table> -->
  <?php endif; ?>

<?php endif; ?>