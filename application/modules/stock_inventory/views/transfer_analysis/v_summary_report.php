
<div class="clearfix"></div>
<div class="row">
<div class="col-sm-12">
	<div class="white-box mtop_10 pdf-wrapper">
		<div class="jo_form organizationInfo" id="printrpt">
			
<?php $this->load->view('common/v_report_header');?>
	

			<!-- 	<table class="table_jo_header purchaseInfo">
					
					<tr>
						<td class="text-center">
							<h4>
								<u>
									<?php echo $this->lang->line('receive_summary'); ?>
									<?php 
									if(!empty($equipmenttype[0]->eqty_equipmenttype))
									{
										echo $equipmenttype[0]->eqty_equipmenttype;
									}else{
										echo " | ".$this->lang->line('general_store')." | ".$this->lang->line('medical_store');
									}
									?>
								</u>
							</h4>
						</td>
					</tr>
				</table> -->

				
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
							<th><?php echo $this->lang->line('counter_name'); ?></th>
							<th><?php echo $this->lang->line('issue_no'); ?>  </th>
							<th><?php echo $this->lang->line('issue_date'); ?> </th>
							<th><?php echo $this->lang->line('req_no'); ?>  </th>
							<th><?php echo $this->lang->line('bill_amount'); ?> </th>
							<th><?php echo $this->lang->line('issued_by'); ?> </th>
						</tr>
					</thead>
					<tbody>
					<?php
					if(!empty($summary)):
					$totalstockvalue = 0;
					foreach($summary as $key=>$iue):
					?>
						<tr>
							<td><?php echo $key+1; ?></td>
							<td><?php echo $iue->eqty_equipmenttype; ?></td>
							<td><?php echo $iue->trma_issueno; ?></td>
							<td><?php echo $iue->issuedate; ?></td>
							<td><?php echo $iue->trma_reqno; ?></td>
							<td><?php echo round($iue->billamt, 2); ?></td>
							<td><?php echo $iue->trma_receivedby;?></td>
							<?php
							$totalstockvalue += $iue->billamt;
							 ?>
						</tr>
						
					<?php
						endforeach;
						endif;
					?>
						<tr class="alter">
							<td></td>
							<td></td>
							<td colspan="4"><b><?php echo $this->lang->line('total'); ?> : </b></td>
							<td><b><?php echo round($totalstockvalue,2);?></b></td>
						</tr>
					</tbody>
				</table>
		    <?php //} ?>
		</div>
	</div>
</div>
</div>