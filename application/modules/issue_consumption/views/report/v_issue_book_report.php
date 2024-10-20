<div class="white-box pad-5 mtop_10 pdf-wrapper">
	<div class="jo_form organizationInfo" id="printrpt">
	
		<?php $this->load->view('common/v_report_header');?>
     
	 	<?php
	 	//echo "<pre>"; print_r($compreHensive); die;
				if(!empty($compreHensive)){
				echo "	<table class='alt_table'>"; 
				$sumt = 0; //echo"<pre>";print_r($compreHensive);die; sama_billdate as issue date
				foreach($compreHensive as $key=>$co):
					$details = $this->report_issue_mdl->get_issue_wise_deails(array('s.sade_salemasterid'=>$co->sama_salemasterid)); ?>
				
				<tbody>			
					<tr>
						<td colspan="2"><b><?php echo $this->lang->line('issue_no'); ?>: </b>
							<?php  echo $co->sama_invoiceno ?>   
						</td>
						<td colspan="2"><b><?php echo $this->lang->line('department'); ?>: </b>
							<?php echo $co->dept_depname; ?>
						</td>
						<td colspan="2"><b><?php echo $this->lang->line('issue_date'); ?>: </b>
							<?php echo $co->sama_billdatebs; ?>
						</td>
						<td colspan="2"><b><?php echo $this->lang->line('store'); ?>: </b>
							<?php echo $co->eqty_equipmenttype; ?>
						</td>
					</tr>
				</tbody>

				<tbody>
					<tr class="header">
						<td><?php echo $this->lang->line('sn'); ?></td>
						<td><?php echo $this->lang->line('item_code'); ?></td>
						<td colspan="2"><?php echo $this->lang->line('item_name'); ?></td>
						<td><?php echo $this->lang->line('expiry_date'); ?></td>
						<td><?php echo $this->lang->line('qty'); ?></td>
						<td><?php echo $this->lang->line('rate'); ?></td>
						<td><?php echo $this->lang->line('amount'); ?></td>
					</tr>
				</tbody>
				
				<tbody>
					<?php $sum =0; 
					if(!empty($details)){
					foreach ($details as $key => $det) { ?>
					<tr>
						<td><?php echo $key+1;?></td>
						<td><?php echo $det->itli_itemcode;?></td>
						<td colspan="2"><?php echo $det->itli_itemname;?></td>
						<td><?php echo $det->sade_expdate; ?></td>
						<td><?php echo $det->sade_qty; ?></td>
						<td><?php echo $det->sade_unitrate;?></td>
						<td><?php echo round($det->amount,2);?></td>
						<?php $sum+= $det->amount; ?>
					</tr>
					<?php } } ?>
					<tr class="borderBottom">
						<td colspan="2">
							<b><?php echo $this->lang->line('issue_by');?> :</b>
							<?php echo $co->sama_username;?>
						</td>
						<td colspan="2">
							<b><?php echo $this->lang->line('issue_time');?> :</b>
							<?php echo $co->sama_billtime;?>
						</td>
						<td colspan="3"  style="font-size:14px;" class="text-right" align="right"><b><?php echo $this->lang->line('sub_total'); ?> </b>   </td>
						<td class="text-left" align="left" style="font-size:14px;" ><b><?php echo number_format($sum,2);?></b></td>
					</tr>
				</tbody>
					
			<?php  	
					$sumt+= $sum;
				endforeach;
			?>
				<tbody>
					<tr>
						<td colspan="7" style="font-size:14px;" class="text-right" align="right"><b><?php echo $this->lang->line('total'); ?> </b>   </td>
						<td class="text-left" align="left" style="font-size:14px;" ><b><?php  echo number_format($sumt,2);?></b></td>
					</tr>
					<tr class="borderBottom">
						<td colspan="8" class="text-center" align="center">
							<strong ><?php echo $this->general->number_to_word($sumt); ?></strong>
						</td>
					</tr>
				</tbody>
		</table>
		<?php }else{
			if(!empty($item_report)): 
		?>
			<table class="alt_table">
				<thead>
					<tr>
						<th><?php echo $this->lang->line('sn'); ?></th>
						<th><?php echo $this->lang->line('invoice_no'); ?></th>
						<th><?php echo $this->lang->line('department'); ?></th>
						<th><?php echo $this->lang->line('date'); ?></th>
						<th><?php echo $this->lang->line('bill_no'); ?></th>
						<th><?php echo $this->lang->line('issue_amount'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php
						$sum = ''; 
						foreach($item_report as $key=>$iue):
					?>
						<tr>
							<td><?php echo $key+1;?></td>
							<td><?php echo $iue->sama_invoiceno;?></td>
							<td><?php echo $iue->dept_depname; ?></td>
							<td><?php echo $iue->sama_billdatebs; ?></td>
							<td> <?php echo $iue->sama_billno;?></td>
							<td><?php echo number_format($iue->amount,2);?></td>
							<?php $sum+= $iue->amount;?>
						</tr>
					<?php
						endforeach;
					?>
					<tr>
						<td colspan="5"  style="font-size:14px;" class="text-right" align="right"><b>Grand Total </b>   </td>
						<td class="text-left" align="left" style="font-size:14px;" ><b><?php  echo number_format($sum,2);?></b></td>
					</tr>
				</tbody>
			</table>
		<?php endif; ?>
	<?php } ?>
	</div>
</div>