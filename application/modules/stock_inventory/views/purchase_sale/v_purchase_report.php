
<div class="clearfix"></div>

<div class="row">
<div class="col-sm-12">
	<div class="white-box pad-5 mtop_10 pdf-wrapper">
		<div class="jo_form organizationInfo" id="printrpt">
			
			
		    
<?php $this->load->view('common/v_report_header');?>

              <table class="table_jo_header purchaseInfo">
					
					<tr>
						<td class="text-center">
							<h4>
								<u>
									<?php echo $this->lang->line('supplier_wise_purchase'); ?>
								</u>
							</h4>
						</td>
					</tr>
				</table>

			
				
		        <style>
					.alt_table {  border-collapse:collapse; border:1px solid #000; margin: 0 auto;}
					.alt_table thead tr th, .alt_table tbody tr td { border:1px solid #000; padding:2px 5px; font-size:13px; }
					.alt_table tbody tr td { padding:5px; font-size:12px; }
					.alt_table tbody tr.alter td { border:0; text-align:center; }
					.alt_table tbody tr td.noboder { border-right:0; text-align:center; }
					.alt_table tbody tr td.noboder+td{ border-left: 0px; }


				</style>
				<table class="alt_table">
					<thead>
						<tr>
							<th><?php echo $this->lang->line('sn'); ?></th>
							<th><?php echo $this->lang->line('supplier_name'); ?> </th>
							<th><?php echo $this->lang->line('amount'); ?></th>
							<th><?php echo $this->lang->line('return_amount'); ?></th>
							<th><?php echo $this->lang->line('total_amount'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php
					if(!empty($purchase)):
					$totalamount = $returnamount = $amountsum = 0;
					foreach($purchase as $key=>$iue):
					?>
						<tr>
							<td><?php echo $key+1; ?></td>
							<td><?php echo $iue->dist_distributor; ?></td>
							<td align="right"><?php echo number_format($iue->amount,2);?></td>
							<td align="right"><?php echo number_format($iue->ramt,2);?></td>
							<td align="right"><?php echo number_format($iue->totalamnt,2);?></td>
							<?php
							$totalamount += $iue->totalamnt;
							$returnamount += $iue->ramt;
							$amountsum += $iue->amount;
							 ?>
						</tr>
						
					<?php
						endforeach;
						endif;
					?>
						<tr class="alter">
							<td></td>
							<td><b><?php echo $this->lang->line('total'); ?> : </b></td>
							<td align="right"><b><?php echo number_format($amountsum,2);?></b></td>
							<td align="right"><b><?php echo number_format($returnamount,2);?></b></td>
							<td align="right"><b><?php echo number_format($totalamount,2);?></b></td>
						</tr>
				
					</tbody>
				</table>
		    <?php //} ?>
		</div>
	</div>
</div>
</div>
<div class="clearfix"></div>