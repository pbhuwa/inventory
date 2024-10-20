<div class="white-box pad-5 mtop_10 pdf-wrapper ">
	<div class="jo_form organizationInfo" id="printrpt">
		
		<?php $this->load->view('common/v_report_header');?>

		<!-- issue list -->
		
		<table class="alt_table">
			<thead>
				<tr>
					<th colspan="11" style="text-align: center"><strong><?php echo $this->lang->line('issue');?></strong></th>
				</tr>

                <tr>
                	<th width="2%"><?php echo $this->lang->line('sn'); ?></th>
					<th width="4%"><?php echo $this->lang->line('issue_date').' '.$this->lang->line('bs'); ?></th>
					<th width="4%"><?php echo $this->lang->line('issue_date').' '.$this->lang->line('ad'); ?></th>
					<th width="4%"><?php echo $this->lang->line('issue_no'); ?></th>
                    <th width="4%"><?php echo $this->lang->line('req_no'); ?></th> 
					<th width="3%"><?php echo $this->lang->line('item_code'); ?></th>
					<th width="20%"><?php echo $this->lang->line('item_name'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('unit'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('issue_qty'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('rate'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('total_amount'); ?></th>
                </tr>
            </thead>
			
			<tbody>
				<?php
					if(!empty($search_data_issue)):
						$sum_issueqty = 0;
						$sum_total_amt=0;
						foreach($search_data_issue as $key=>$data):
							$iss_qty = !empty($data->qty)?$data->qty:0;
							$total_amt=!empty($data->tamount)?$data->tamount:0;
							$sum_total_amt +=$total_amt;
				?>
				<tr>
					<td>
						<?php echo $key+1; ?>
					</td>
					<td>
						<?php echo !empty($data->sama_billdatebs)?$data->sama_billdatebs:''; ?>
					</td>
					<td>
						<?php echo !empty($data->sama_billdatead)?$data->sama_billdatead:''; ?>
					</td>
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
						<?php echo $iss_qty; ?>
					</td>
					<td align="right">
						<?php echo !empty($data->rate)?$data->rate:'0.00'; ?>
					</td>
					<td align="right">
						<?php echo !empty($data->tamount)?(round($data->tamount,2)):'0.00'; ?>
					</td>
				</tr>
				<?php
						$sum_issueqty += $iss_qty;
						endforeach;
					endif;
				?>
				<tr>
					<td colspan="8" class="text-right" align="right"><strong><?php echo $this->lang->line('total'); ?> </strong></td>
					<td align="right"><strong><?php echo !empty($sum_issueqty)?$sum_issueqty:0;?></strong></td>
					<td></td>
					<td align="right"><strong><?php echo number_format($sum_total_amt,2); ?></strong></td>
				</tr>
			</tbody>
		</table>
		<br/>
		<!-- return list -->
		<table class="alt_table">
			<thead>
				<tr>
					<th colspan="11" style="text-align: center"><strong><?php echo $this->lang->line('return');?></strong></th>
				</tr>

                <tr>
                	<th width="2%"><?php echo $this->lang->line('sn'); ?></th>
					<th width="4%"><?php echo $this->lang->line('return_date').' '.$this->lang->line('bs'); ?></th>
					<th width="4%"><?php echo $this->lang->line('return_date').' '.$this->lang->line('ad'); ?></th>
					<th width="4%"><?php echo $this->lang->line('issue_no'); ?></th> 
					<th width="4%"><?php echo $this->lang->line('return_no'); ?></th>
					<th width="3%"><?php echo $this->lang->line('item_code'); ?></th>
					<th width="20%"><?php echo $this->lang->line('item_name'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('unit'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('return_qty'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('rate'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('total_amount'); ?></th>
                </tr>
            </thead>
			
			<tbody>
				<?php
				$sum_return_total_amt=0;
					if(!empty($search_data_return)):
						$sum_returnqty = 0;
						
						foreach($search_data_return as $key=>$data):
							$ret_qty = !empty($data->returnqty)?$data->returnqty:0;
							$ret_total_amt= !empty($data->total_amt)?$data->total_amt:'0';
							$sum_return_total_amt +=$ret_total_amt;

				?>
				<tr>
					<td>
						<?php echo $key+1; ?>
					</td>
					<td>
						<?php echo !empty($data->rema_returndatebs)?$data->rema_returndatebs:''; ?>
					</td>
					<td>
						<?php echo !empty($data->rema_returndatead)?$data->rema_returndatead:''; ?>
					</td>
					<td>
						<?php echo !empty($data->rema_receiveno)?$data->rema_receiveno:''; ?>
					</td>
					<td>
						<?php echo !empty($data->rema_invoiceno)?$data->rema_invoiceno:''; ?>
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
						<?php echo $ret_qty; ?>
					</td>
					<td><?php echo !empty($data->rate)?$data->rate:'0'; ?></td>
					<td><?php echo round($ret_total_amt,2); ?></td>
					
				</tr>
				<?php
						$sum_returnqty += $ret_qty;
						endforeach;
					endif;
				?>

				<tr>
					<td colspan="8" class="text-right" align="right"><strong><?php echo $this->lang->line('total'); ?> </strong></td>
					<td align="right"><strong><?php echo !empty($sum_returnqty)?$sum_returnqty:0;?></strong></td>
					<td></td>
					<td align="right"><strong><?php echo $sum_return_total_amt; ?></strong></td>
				</tr>
			</tbody>
		</table>
	</div>
	</div>
</div>