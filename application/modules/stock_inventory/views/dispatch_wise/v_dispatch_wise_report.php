<div class="clearfix"></div>
<div class="row">
<div class="col-sm-12">
	<div class="white-box mtop_10 pdf-wrapper">
		<div class="jo_form organizationInfo" id="printrpt">
			<?php $this->load->view('common/v_report_header');?>
	        <table class="alt_table">
					<thead>
						<tr>
							<th><?php echo $this->lang->line('sn'); ?></th>
							<th><?php echo $this->lang->line('counter_name'); ?></th>
							<th><?php echo $this->lang->line('issue_no'); ?></th>
							<th><?php echo $this->lang->line('receive_date_bs'); ?></th>
							<th><?php echo $this->lang->line('receive_date_ad'); ?></th>
							<th><?php echo $this->lang->line('req_no'); ?></th>
							<th><?php echo $this->lang->line('receive_amount'); ?></th>
							<th><?php echo $this->lang->line('received_by'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php
					if(!empty($purchase)):
					$totalstockvalue = 0;
					foreach($purchase as $key=>$iue):
					?>
						<tr>
							<td><?php echo $key+1; ?></td>
							<td><?php echo $iue->eqty_equipmenttype; ?></td>
							<td><?php echo $iue->trma_issueno; ?></td>
							<td><?php echo $iue->trma_receiveddatebs; ?></td>
							<td><?php echo $iue->trma_receiveddatead; ?></td>
							<td><?php echo $iue->requisitionno; ?></td>
							<td align="right"><?php echo number_format($iue->amount,2);?></td>
							<td><?php echo $iue->trma_receivedby; ?></td>
							
							<?php
							$totalstockvalue += $iue->amount;
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
							<td align="right"><b><?php echo number_format($totalstockvalue,2);?></b></td>
							<td></td>
						</tr>
					</tbody>
				</table>
		    <?php //} ?>
		</div>
	</div>
</div>
</div>