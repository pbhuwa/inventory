
	<div class="white-box pad-5 mtop_10 pdf-wrapper">
		<div class="jo_form organizationInfo" id="printrpt">
		<!-- <div class="jo_form organizationInfo" id="">
			<div class="pull-right pad-btm-5">
				<a href="javascript:void(0)" class="btn btn_print"><i class="fa fa-print"></i></a>
				<a href="javascript:void(0)" class="btn btn_excel itemWiseStock"><i class="fa fa-file-excel-o"></i></a>
				<a href="javascript:void(0)" class="btn printissueitems btn_pdf2"><i class="fa fa-file-pdf-o"></i></a>
			</div> -->
			  <?php  $this->load->view('common/v_report_header'); ?>
		      <br><br>
		      <style type="text/css">
		      	.bt-dotted{ style="border-top:1px dotted #212121;padding:4px;"

		      	}
		      </style>
		      <table width="100%" style="font-size:12px;">

		    	<tr>
		    		<td>
		    			<h4 style="padding-top: 20px;"><?php echo $this->lang->line('expandable'); ?></h4>
		    			<table class="cdia_table" style="width: 100%;
					    border-top: 1px solid #000;
					    border-collapse: collapse;">
						<?php if($department_data) { 
						//echo"<pre>"; print_r($department);die;
						$sumissueamount = $sumreturnamount= $sumnetvalue= 0;
						foreach($department_data as $dept):
							$sum3= $sum4 = $sum2 = 0;
							$depid = $dept->dept_depid;

						 ?>
						<?php  
						$srchcol = ("AND dept_depid = '$depid' AND itli_materialtypeid ='1'");
						 //$srchcol = ("AND dept_depid = '2'");
						$reportitemwise = $this->issue_analysis_mdl->issue_item_wise_data($srchcol);
						// echo $this->db->last_query(); 
						// echo"<pre>";print_r($reportitemwise);die;
				if(!empty($reportitemwise)){ //echo"<pre>";print_r($reportitemwise);die;
				 ?>				
				<thead>
					<tr>
						<th width="50px" style="font-weight: bold;"></th>
						<th colspan="10" style="font-weight: bold;"><?php echo $dept->dept_depname; ?></th>
						<th width="50px" style="font-weight: bold;"></th>
					</tr>
				</thead>
				<thead>
					<tr>
						<th width="50px" style="font-weight: bold;"></th>
						<th style="font-weight: bold;"><?php echo $this->lang->line('sn'); ?></th>
						<th style="font-weight: bold;"><?php echo $this->lang->line('code'); ?></th>
						<th style="font-weight: bold;"><?php echo $this->lang->line('items'); ?></th>
						<th style="font-weight: bold;"><?php echo $this->lang->line('unit'); ?></th>
						<th style="font-weight: bold;" class="text-right"><?php echo $this->lang->line('issue_qty'); ?></th>
						<th style="font-weight: bold;" class="text-right"><?php echo $this->lang->line('rate'); ?></th>
						<th style="font-weight: bold;" class="text-right"><?php echo $this->lang->line('issue_value'); ?></th>
						<th style="font-weight: bold;" class="text-right"><?php echo $this->lang->line('ret_qty'); ?></th>
						<th style="font-weight: bold;" class="text-right"><?php echo $this->lang->line('rate'); ?></th>
						<th style="font-weight: bold;" class="text-right"><?php echo $this->lang->line('return_value'); ?></th>
						<th style="font-weight: bold;" class="text-right"><?php echo $this->lang->line('net_qty'); ?></th> 
						<th style="font-weight: bold;" class="text-right"><?php echo $this->lang->line('net_value'); ?></th>
						<th style="font-weight: bold;" width="50px"></th>
					</tr>
				</thead>
				<tbody> 
					<?php $sum2=0;$sum3 =0;$sum4 = 0; 
				
					foreach($reportitemwise as $key => $iue):   //echo"<pre>";print_r($reportitemwise);die;
					?>
					<tr>
						<td></td>
						<td class="text-right bt-dotted" style="border-top:1px dotted #212121;padding:4px;"><?php echo $key+1;?></td>
						<td class="bt-dotted" style="border-top:1px dotted #212121;padding:4px;" style="border-top: 1px dotted #000;"><?php echo !empty($iue->itli_itemcode)?$iue->itli_itemcode:'';?></td>
						<td class="bt-dotted" style="border-top:1px dotted #212121;padding:4px;" style="border-top: 1px dotted #000;"><?php echo !empty($iue->itli_itemname)?$iue->itli_itemname:'';?></td>
						<td class="bt-dotted" style="border-top:1px dotted #212121;padding:4px;" style="border-top: 1px dotted #000;"><?php echo !empty($iue->unit_unitname)?$iue->unit_unitname:'';?></td>
						<td class="text-right bt-dotted" style="border-top:1px dotted #212121;padding:4px;"><?php echo number_format(!empty($iue->issqty)?$iue->issqty:0,2);?></td>
						<td class="text-right bt-dotted" style="border-top:1px dotted #212121;padding:4px;"><?php echo number_format(!empty($iue->unitrate)?$iue->unitrate:0,2);?></td>
						<td class="text-right bt-dotted" style="border-top:1px dotted #212121;padding:4px;"><?php echo number_format(!empty($iue->issamount)?$iue->issamount:0,2); ?></td>
						<td class="text-right bt-dotted" style="border-top:1px dotted #212121;padding:4px;"><?php echo number_format(!empty($iue->returnqty)?$iue->returnqty:0,2);?></td>
						<td class="text-right bt-dotted" style="border-top:1px dotted #212121;padding:4px;"><?php echo number_format(!empty($iue->retrate)?$iue->retrate:0,2);?></td>
						<td class="text-right bt-dotted" style="border-top:1px dotted #212121;padding:4px;"><?php echo number_format(!empty($iue->returnamount)?$iue->returnamount:0,2);?></td>
						<td class="text-right bt-dotted" style="border-top:1px dotted #212121;padding:4px;"><?php echo number_format(($iue->issqty-$iue->returnqty),2); ?></td>
						<td class="text-right bt-dotted" style="border-top:1px dotted #212121;padding:4px;"><?php echo number_format(!empty($iue->netvalue)?$iue->netvalue:0,2);?></td>
						<td></td>
						<?php 
						
						$sum3+= !empty($iue->issamount)?$iue->issamount:0; 
						$sum4 += !empty($iue->returnamount)?$iue->returnamount:0;
						$sum2 += !empty($iue->netvalue)?$iue->netvalue:0;
						
						?>
					</tr>
					<?php endforeach; ?>
					 
				</tbody>
				<tbody class="tfoot">
					<tr>
						<td></td>
						<td colspan="5"></td>
						<td style="font-weight: bold;" class="text-right bt" colspan="2"><?php  echo number_format($sum3,2);?></td>
						<td style="font-weight: bold;" class="text-right bt" ></td>
						<td style="font-weight: bold;" class="text-right bt" colspan="2"><?php  echo number_format($sum4,2);?></td>
						<td tyle="font-weight: bold;" class="text-right bt"></td>
						<td style="font-weight: bold;" class="text-right bt" colspan="1"><?php  echo number_format($sum2,2);?></td>
						<td></td>
					</tr>
				</tbody>
				
				<?php  }  $sumissueamount += $sum3;
							 $sumreturnamount += $sum4; $sumnetvalue += $sum2;
				 ?>
				<?php endforeach; ?>
				<tfoot style="border-bottom: 1px solid #000;">
					<tr>
						<td></td>
						<td></td>
						<td style="font-weight: bold;" colspan="3" class="text-right"><?php echo $this->lang->line('grand_total'); ?>:</td>
						<td style="font-weight: bold;" colspan="3" class="text-right"><?php echo number_format($sumissueamount,2)?></td>
						<td></td>
						<td style="font-weight: bold;" colspan="2" class="text-right"><?php echo number_format($sumreturnamount,2)?></td>
						<td style="font-weight: bold;" colspan="1" class="text-right"> </td>
						<td style="font-weight: bold;" colspan="1" class="text-right"><?php echo number_format($sumnetvalue,2)?> </td>
					</tr>
				</tfoot>
			<?php  } ?>
			</table>
		    		</td>
		    	</tr>
			</table>


			 <table width="100%" style="font-size:12px;">

		    	<tr>
		    		<td>
		    			<h4 style="padding-top: 20px;"><?php echo $this->lang->line('non_expandable'); ?></h4>
		    			<table class="cdia_table" style="width: 100%;
    border-top: 1px solid #000;
    border-collapse: collapse;">
				<?php if($department_data) { 
				//echo"<pre>"; print_r($department);die;
				$sumissueamount = $sumreturnamount= $sumnetvalue= 0;
				foreach($department_data as $dept):
					$sum3= $sum4 = $sum2 = 0;
					$depid = $dept->dept_depid;

						 ?>
						<?php  
						$srchcol = ("AND dept_depid = '$depid'  AND itli_materialtypeid ='2'");
						 //$srchcol = ("AND dept_depid = '2'");
						$reportitemwise = $this->issue_analysis_mdl->issue_item_wise_data($srchcol);
						// echo $this->db->last_query(); 
						// echo"<pre>";print_r($reportitemwise);die;
				if(!empty($reportitemwise)){ //echo"<pre>";print_r($reportitemwise);die;
				 ?>				
				<thead>
					<tr>
						<th style="font-weight: bold;" width="50px"></th>
						<th style="font-weight: bold;" colspan="10"><?php echo $dept->dept_depname; ?></th>
						<th style="font-weight: bold;" width="50px"></th>
					</tr>
				</thead>
				<thead>
					<tr>
						<th style="font-weight: bold;" width="50px"></th>
						<th style="font-weight: bold;"><?php echo $this->lang->line('sn'); ?></th>
						<th style="font-weight: bold;"><?php echo $this->lang->line('code'); ?></th>
						<th style="font-weight: bold;"><?php echo $this->lang->line('items'); ?></th>
						<th style="font-weight: bold;"><?php echo $this->lang->line('unit'); ?></th>
						<th style="font-weight: bold;" class="text-right"><?php echo $this->lang->line('issue_qty'); ?></th>
						<th style="font-weight: bold;" class="text-right"><?php echo $this->lang->line('rate'); ?></th>
						<th style="font-weight: bold;" class="text-right"><?php echo $this->lang->line('issue_value'); ?></th>
						<th style="font-weight: bold;" class="text-right"><?php echo $this->lang->line('ret_qty'); ?></th>
						<th style="font-weight: bold;" class="text-right"><?php echo $this->lang->line('rate'); ?></th>
						<th style="font-weight: bold;" class="text-right"><?php echo $this->lang->line('return_value'); ?></th>
					<th class="text-right"><?php echo $this->lang->line('net_qty'); ?></th> 
						<th style="font-weight: bold;" class="text-right"><?php echo $this->lang->line('net_value'); ?></th>
						<th style="font-weight: bold;" width="50px"></th>
					</tr>
				</thead>
				<tbody> 
					<?php $sum2=0;$sum3 =0;$sum4 = 0; 
				
					foreach($reportitemwise as $key => $iue):   //echo"<pre>";print_r($reportitemwise);die;
					?>
					<tr>
						<td></td>
						<td class="text-right bt-dotted" style="border-top:1px dotted #212121;padding:4px;"><?php echo $key+1;?></td>
						<td class="bt-dotted" style="border-top:1px dotted #212121;padding:4px;" style="border-top: 1px dotted #000;"><?php echo !empty($iue->itli_itemcode)?$iue->itli_itemcode:'';?></td>
						<td class="bt-dotted" style="border-top:1px dotted #212121;padding:4px;" style="border-top: 1px dotted #000;"><?php echo !empty($iue->itli_itemname)?$iue->itli_itemname:'';?></td>
						<td class="bt-dotted" style="border-top:1px dotted #212121;padding:4px;" style="border-top: 1px dotted #000;"><?php echo !empty($iue->unit_unitname)?$iue->unit_unitname:'';?></td>
						<td class="text-right bt-dotted" style="border-top:1px dotted #212121;padding:4px;"><?php echo number_format(!empty($iue->issqty)?$iue->issqty:0,2);?></td>
						<td class="text-right bt-dotted" style="border-top:1px dotted #212121;padding:4px;"><?php echo number_format(!empty($iue->unitrate)?$iue->unitrate:0,2);?></td>
						<td class="text-right bt-dotted" style="border-top:1px dotted #212121;padding:4px;"><?php echo number_format(!empty($iue->issamount)?$iue->issamount:0,2); ?></td>
						<td class="text-right bt-dotted" style="border-top:1px dotted #212121;padding:4px;"><?php echo number_format(!empty($iue->returnqty)?$iue->returnqty:0,2);?></td>
						<td class="text-right bt-dotted" style="border-top:1px dotted #212121;padding:4px;"><?php echo number_format(!empty($iue->retrate)?$iue->retrate:0,2);?></td>
						<td class="text-right bt-dotted" style="border-top:1px dotted #212121;padding:4px;"><?php echo number_format(!empty($iue->returnamount)?$iue->returnamount:0,2);?></td>
						<td class="text-right bt-dotted" style="border-top:1px dotted #212121;padding:4px;"><?php echo number_format(($iue->issqty-$iue->returnqty),2); ?></td>
						<td class="text-right bt-dotted" style="border-top:1px dotted #212121;padding:4px;"><?php echo number_format(!empty($iue->netvalue)?$iue->netvalue:0,2);?></td>
						<td></td>
						<?php 
						
						$sum3+= !empty($iue->issamount)?$iue->issamount:0; 
						$sum4 += !empty($iue->returnamount)?$iue->returnamount:0;
						$sum2 += !empty($iue->netvalue)?$iue->netvalue:0;
						
						?>
					</tr>
					<?php endforeach; ?>
					 
				</tbody>
				<tbody class="tfoot">
					<tr>
						<td></td>
						<td colspan="5"></td>
						<td style="font-weight: bold;" class="text-right bt" colspan="2"><?php  echo number_format($sum3,2);?></td>
						<td style="font-weight: bold;" class="text-right bt" ></td>
						<td style="font-weight: bold;" class="text-right bt" colspan="2"><?php  echo number_format($sum4,2);?></td>
						<td tyle="font-weight: bold;" class="text-right bt"></td>
						<td style="font-weight: bold;" class="text-right bt" colspan="1"><?php  echo number_format($sum2,2);?></td>
						<td></td>
					</tr>
				</tbody>
				
				<?php  }  $sumissueamount += $sum3;
							 $sumreturnamount += $sum4; $sumnetvalue += $sum2;
				 ?>
				<?php endforeach; ?>
				<tfoot style="border-bottom: 1px solid #000;">
					<tr>
						<td></td>
						<td></td>
						<td style="font-weight: bold;" colspan="3" class="text-right"><?php echo $this->lang->line('grand_total'); ?>:</td>
						<td style="font-weight: bold;" colspan="3" class="text-right"><?php echo number_format($sumissueamount,2)?></td>
						<td tyle="font-weight: bold;" class="text-right bt"></td>
						<td style="font-weight: bold;" colspan="2" class="text-right"><?php echo number_format($sumreturnamount,2)?></td>
							<td style="font-weight: bold;" colspan="1" class="text-right"> </td>
						<td  style="font-weight: bold;"colspan="1" class="text-right"><?php echo number_format($sumnetvalue,2)?> </td>
					</tr>
				</tfoot>
			<?php  } ?>
			</table>
		    		</td>
		    	</tr>
			</table>
		</div>
	</div>

<style>
	.cdia_table { width:100%; border-top:1px solid #000; border-collapse:collapse; }
	.cdia_table th { font-weight:bold; }
	.cdia_table th, .cdia_table td { font-size:12px; padding:2px 3px; }
	.cdia_table tr td.bt { border-top:1px solid #000; }
	.cdia_table tr td.text-right, .cdia_table tr th.text-right { text-align:right; }
	.cdia_table tr td.bt-dotted  style="border-top:1px dotted #212121;padding:4px;"{ border-top:1px dotted #000; }
	.cdia_table .tfoot td, .cdia_table tfoot td { font-weight:bold; font-size:13px; }
	.cdia_table .tfoot { border-bottom:1px solid #000; }
	.cdia_table tfoot { border-bottom:2px solid #000; }
	.cdia_table tfoot td { padding:4px 3px; }
</style>


</div>

