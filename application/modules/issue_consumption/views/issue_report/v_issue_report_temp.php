<div class="white-box pad-5 mtop_10 pdf-wrapper">
	<div class="jo_form organizationInfo" id="printrpt">
		<?php $this->load->view('common/v_report_header');?>

		<?php if(!empty($item)){ ?>
			<table class="alt_table">
				<thead>
					<tr>
						<th width="5%"><?php echo $this->lang->line('sn'); ?></th>
						<th width="10%"><?php echo $this->lang->line('item_code'); ?></th>
						<th width="25%"><?php echo $this->lang->line('category_name'); ?></th>
						<th width="15%"> <?php echo $this->lang->line('qty'); ?></th> 
						<th width="15%"><?php echo $this->lang->line('amount'); ?></th>
						<!-- <th> Qty</th> 
						<th>Amount</th> -->
					</tr>
				</thead>
				<tbody>
					<?php
				  		$sum2 = $sum3 = 0;
						foreach($issue_report as $key=>$iue):  //echo "<pre>";print_r($issue_report);die;
					?>
					<tr>
						<td colspan="3"  style="font-size:14px;" class="text-right"><b><?php echo $this->lang->line('department'); ?> :</b>   </td>
						<td class="text-right"  style="font-size:14px;" ><b><?php echo $iue->dept_depname; ?></b></td>
					</tr>
					<tr>
						<td><?php echo $key+1;?></td>
						<td><?php echo $iue->dept_depcode;?></td>
						<td><?php echo $iue->dept_depname; ?></td>
						<td><?php echo $iue->qty; ?></td>
						<td><?php echo number_format($iue->consumption,2);?></td>
						<td><?php echo number_format($iue->qty,2); ?></td>
						<td><?php echo number_format($iue->assets,2);?></td>
						<?php $sum2+= $iue->assets;?>
						<?php $sum3+= $iue->consumption;?>
					</tr>
					<?php endforeach; ?>
					<tr>
						<td colspan="5"  style="font-size:14px;" class="text-right"><b><?php echo $this->lang->line('grand_total'); ?> :</b>   </td>
						<td class="text-right"  style="font-size:14px;" ><b><?php  echo number_format($sum2,2);?></b></td>
						<td class="text-right"  style="font-size:14px;" ><b><?php  echo number_format($sum3,2);?></b></td>
					</tr>
				</tbody>
			</table>
		    <?php }else{ ?>
		    <?php if(!empty($issue_report)): ?>
				<table class="alt_table" width="100%">
					<thead>
						<tr>
							<th width="5%"><?php echo $this->lang->line('sn'); ?></th>
							<th width="10%"><?php echo $this->lang->line('department_code'); ?></th>
							<th width="25%"><?php echo $this->lang->line('department_name'); ?></th>
							<th width="15%"><?php echo $this->lang->line('consumable'); ?></th>
							<th width="15%"><?php echo $this->lang->line('assets'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php
					  $sum = 0;   $sum1 = 0;
					foreach($issue_report as $key=>$iue):  ///echo "<pre>";print_r($issue_report);die;
					?>
						<tr>
							<td><?php echo $key+1;?></td>
							<td><?php echo $iue->dept_depcode; ?></td>
							<td><?php echo $iue->dept_depname; ?></td>
							<td align="right"><?php echo number_format($iue->consumption,2);?></td>
							<td align="right"><?php echo number_format($iue->assets,2);?></td>
							<?php $sum+= $iue->assets;?>
						<?php $sum1+= $iue->consumption;?>
					</tr>
					<?php
						endforeach;
						
					?>
					<tr>
						<td colspan="3" class="text-right" align="right"><b><?php echo $this->lang->line('grand_total'); ?> </b>   </td>
						<td align="right"><b><?php  echo number_format($sum1,2);?></b></td>
						<td align="right"><b><?php  echo number_format($sum,2);?></b></td>
					</tr>
					</tbody>
				</table>
			<?php endif; ?>
			<?php } ?>
	</div>
</div>