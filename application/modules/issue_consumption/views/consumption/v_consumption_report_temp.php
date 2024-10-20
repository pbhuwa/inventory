<div class="white-box pad-5 mtop_10 pdf-wrapper">
	<div class="jo_form organizationInfo" id="printrpt">
		
		<?php $this->load->view('common/v_report_header');?>

		<?php if(!empty($consumption)): ?>
			<table class="alt_table">
				<thead>
					<tr>
						<th><?php echo $this->lang->line('sn'); ?></th>
						<th><?php echo $this->lang->line('invoice_no'); ?></th>
						<th><?php echo $this->lang->line('item_name'); ?></th>
						<th><?php echo $this->lang->line('expiry_date'); ?></th>
						<th><?php echo $this->lang->line('date'); ?></th>
						<th><?php echo $this->lang->line('qty'); ?></th>
						<th><?php echo $this->lang->line('amount'); ?></th>
					</tr>
				</thead>
				
				<tbody>
				<?php
					$sum = 0; 
					foreach($consumption as $key=>$iue): // print_r($consumption);die;
				?>
					<tr>
						<td><?php echo $key+1;?></td>
						<td><?php echo $iue->sama_invoiceno;?></td>
						<td><?php echo $iue->itli_itemname;?></td>
						<td><?php echo $iue->sade_expdate; ?></td>
						<td><?php echo $iue->sama_billdatebs; ?></td>
						<td><?php echo $iue->sade_qty;?></td>
						<td align="right">
							<?php
								$amount = !empty($iue->amount)?$iue->amount:0;
								echo number_format($amount,2);
							?>
						</td>
						<?php $sum+= $amount;?>
					</tr>
				<?php
					endforeach;
				?>
					<tr>
						<td colspan="6" class="text-right" align="right">
							<strong>
							<?php echo $this->lang->line('grand_total'); ?> :
							</strong>
						</td>
						<td align="right"><?php echo number_format($sum,2);?></td>
					</tr>
				</tbody>
			</table>
		<?php endif; ?>
	</div>
</div>