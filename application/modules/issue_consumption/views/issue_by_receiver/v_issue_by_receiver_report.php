<div class="white-box pad-5 mtop_10 pdf-wrapper ">
	<div class="jo_form organizationInfo" id="printrpt">
		
		<?php $this->load->view('common/v_report_header');?>

		<!-- issue list -->
		
	   <br><br>
		      <style type="text/css">
		      	.bt-dotted{ style="border-top:1px dotted #212121;padding:4px;"

		      	}
		      </style>
		      <table width="100%" style="font-size:12px;">

		    	<tr>
		    		<td>
		    		
						<?php if($search_data_issue) { 
						// $sumissueamount = $sumreturnamount= $sumnetvalue= 0;
							$iss_qty=$sum_total_amt=0;
						foreach($search_data_issue as $received):
							?>
							<table class="cdia_table" style="width: 100%;
					    border-top: 1px solid #000;
					    border-collapse: collapse;">
							<?php
							// $sum3= $sum4 = $sum2 = 0;
							$receivername = $received->sama_receivedby;

						 ?>
						<?php  
						$cond = ("AND sama_receivedby = '$receivername'");
						 //$srchcol = ("AND sama_salemasterid = '2'");
						$reportitemwise = $this->issue_by_receiver_mdl->get_issue_by_receiver($cond,false);
						// echo $this->db->last_query(); 
						// echo"<pre>";print_r($reportitemwise);die;
				if(!empty($reportitemwise)){ 
				// echo"<pre>";print_r($reportitemwise);die;
				 ?>				
				<thead>
					<tr>
						<th width="50px" style="font-weight: bold;"></th>
						<th colspan="10" style="font-weight: bold;"><?php echo $received->sama_receivedby; ?></th>
						<th width="50px" style="font-weight: bold;"></th>
					</tr>
				</thead>
				<thead>
					<tr>
				<th width="2%"><?php echo $this->lang->line('sn'); ?></th>
					<th width="10%"><?php echo $this->lang->line('issue_date').' '.$this->lang->line('bs'); ?></th>
					<!-- <th width="4%"><?php echo $this->lang->line('issue_date').' '.$this->lang->line('ad'); ?></th> -->
					<th width="10%"><?php echo $this->lang->line('issue_no'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('req_no'); ?></th> 
					<th width="8%"><?php echo $this->lang->line('item_code'); ?></th>
					<th width="20%"><?php echo $this->lang->line('item_name'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('unit'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('issue_qty'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('rate'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('total_amount'); ?></th>
					</tr>
				</thead>
				<tbody> 
					<?php 		
					    $sum_issueqty = 0;
						$sum_total_amt=0;
						foreach($reportitemwise as $key => $data):   //echo"<pre>";print_r($reportitemwise);die;
					?>
					<tr>
					<td>
						<?php echo $key+1; ?>
					</td>
					<td>
						<?php echo !empty($data->sama_billdatebs)?$data->sama_billdatebs:''; ?>
					</td>
					<!-- <td>
						<?php echo !empty($data->sama_billdatead)?$data->sama_billdatead:''; ?>
					</td> -->
					<td>
						<?php echo !empty($data->sama_invoiceno)?$data->sama_invoiceno:''; ?>
					</td>
					<td>
						<?php echo !empty($data->sama_requisitionno)?$data->sama_requisitionno:''; ?>
					</td>
					<td>
						<?php echo !empty($data->itli_itemcode)?$data->itli_itemcode:''; ?>
					</td>
					<td>
						<?php echo !empty($data->itli_itemname)?$data->itli_itemname:''; ?>
					</td>
					<td>
						<?php echo !empty($data->unit_unitname)?$data->unit_unitname:''; ?>
					</td>
					<td align="right">
						<?php echo !empty($data->qty)?$data->qty:''; ?>
					</td>
					<td align="right">
						<?php echo !empty($data->rate)?$data->rate:'0.00'; ?>
					</td>
					<td align="right">
						<?php echo !empty($data->tamount)?(round($data->tamount,2)):'0.00'; ?>
					</td>
					</tr>
					<?php endforeach; ?>
					 
				</tbody>
				
				<?php  }  
				 			$iss_qty = !empty($data->qty)?$data->qty:0;
							$total_amt=!empty($data->tamount)?$data->tamount:0;
							$sum_total_amt +=$total_amt;
				 ?>	
				 <tfoot style="border-bottom: 1px solid #000;">
					<tr>
					<td colspan="7" class="text-right" align="right"><strong><?php echo $this->lang->line('total'); ?> </strong></td>
					<td align="right"><strong><?php echo !empty($sum_issueqty)?$sum_issueqty:0;?></strong></td>
					<td></td>
					<td align="right"><strong><?php echo number_format($sum_total_amt,2); ?></strong></td>
					</tr>
				</tfoot>
				</table>
				<?php endforeach; ?>
			
			<?php  } ?>
			
		    		</td>
		    	</tr>
			</table>
		<br/>
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