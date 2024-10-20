<div class="clearfix"></div>
<div class="row">

<div class="col-sm-12">
	<div class="white-box mtop_10 pdf-wrapper">
	
	
			<?php $this->load->view('common/v_report_header');?>

			

			<table class="jo_tbl_head">
			
				<tr><td>&nbsp;</td></tr>

				<tr>
					<td style="text-align: left;width:20%;" align="left">
						<strong><?php echo $this->lang->line('store'); ?>: </strong>
						<?php
							echo !empty($store_type[0]->eqty_equipmenttype)?$store_type[0]->eqty_equipmenttype:'All';
						?>
					</td>
					<td style="text-align: left;width:20%;" align="left">
						<strong><?php echo $this->lang->line('location'); ?>: </strong>
						<?php
							echo !empty($location[0]->loca_name)?$location[0]->loca_name:'All';
						?>
					</td>
					<td style="text-align: left;width:20%;" align="left">
						<strong><?php echo $this->lang->line('user'); ?>: </strong>
						<?php
							echo !empty($user[0]->usma_username)?$user[0]->usma_username:'All';
						?>
					</td>
				</tr>
			</table> 
		  
		  	<?php if($detail){ ?>
				<table class="alt_table summarytbl">
					<tbody>
						<tr>
							<td class="text-right" align="right" width="50%"><strong> <?php echo $this->lang->line('issue').' ('.$this->lang->line('rs').')'; ?></strong> </td>
							<?php 
								$sum = 0; 
								if(!empty($issue_value)): 
									foreach($issue_value as $key=>$iue):
										$sum+= $iue->sama_totalamount;
									endforeach;
								endif; ?>  
							<td align="right"><?php echo number_format($sum,2);?></td>
						</tr>
						<tr>
							<td class="text-right" align="right" width="50%"><strong> <?php echo $this->lang->line('issue_return').' ('.$this->lang->line('rs').')'; ?></strong> </td>
							<?php $sum1 = 0; 
								if(!empty($return_report)): 
								foreach($return_report as $key=>$rt): ?>
									<?php  $sum1+= $rt->returntotal;?>
								<?php
									endforeach;
									endif;
								?>  
							<td align="right"><?php echo number_format($sum1, 2);?></td>

						</tr>
						<tr>
							<td class="text-right" align="right" width="50%"> <strong><?php echo $this->lang->line('total_issue').' ('.$this->lang->line('rs').')'; ?> </strong> </td>
							<td align="right">
								<?php 
									$total = $sum - $sum1; 
									echo number_format($total,2);
								?>
							</td>
						</tr>

						<tr class="borderBottom">
							<td colspan="2" class="text-center" align="center">
								<strong ><?php echo $this->lang->line('in_words').': '.$this->general->number_to_word($total); ?></strong>
							</td>
						</tr>
					</tbody>
				</table>
			<?php }else{ ?>
			
				<table class="alt_table">
					<thead>
						<tr>
							<td colspan="5" style="padding-left: 5px;"><b> <?php echo $this->lang->line('issue'); ?></b> </td>
						</tr>
					
						<tr>
							<th> <?php echo $this->lang->line('sn'); ?></th>
							<th><?php echo $this->lang->line('issue_date'); ?> </th>
							<th><?php echo $this->lang->line('issue_no'); ?></th>
							<th><?php echo $this->lang->line('department'); ?></th>
							<th><?php echo $this->lang->line('amount'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php $sum = 0; 
					if(!empty($issue_value)): 
					foreach($issue_value as $key=>$iue):
					?>
					<!-- <tr>
						<td colspan="7">Item Name :   <?php echo $iue->itli_itemname;?></td>
					</tr> -->
						<tr>
							<td><?php echo $key+1; ?></td>
							<td><?php echo $iue->sama_duedatebs; ?></td>
							<td><?php echo $iue->sama_invoiceno; ?></td>
							<td><?php echo $iue->sama_depname;?></td>
							<td align="right">
								<?php
									$issue_total = !empty($iue->sama_totalamount)?$iue->sama_totalamount:0;
									echo number_format($issue_total,2);?></td>

						<?php  $sum+= $issue_total;?>
						</tr>
						
					<?php
						endforeach;
						endif;
					?>  
					<tr>
						<td></td>
						<td colspan="3" class="text-right" align="right"><b><?php echo $this->lang->line('total_amount'); ?></b></td>
						<td align="right"><strong><?php echo number_format($sum,2);?></strong></td>
					</tr>
					</tbody>
				</table>
		    <?php //} ?>
		    <br/>
		    <?php  if($return_report){ ?> 
		    <table class="alt_table">
				<thead>
					<tr>
						<td colspan="6" style="padding-left: 5px;"><b><?php echo $this->lang->line('issue_return'); ?></b> </td>
					</tr>
					<tr>
						<th><?php echo $this->lang->line('sn'); ?></th>
						<th><?php echo $this->lang->line('issue_date'); ?></th>
						<th><?php echo $this->lang->line('return_no'); ?></th>
						<th><?php echo $this->lang->line('department'); ?></th>
						<th><?php echo $this->lang->line('issue_no'); ?></th>
						<th><?php echo $this->lang->line('return_total'); ?></th>
					</tr>
				</thead>
				<tbody>
					
				<?php $sum1 = 0; 
				if(!empty($return_report)):  //print_r($return_report);die;
				foreach($return_report as $key=>$rt):
				?>
				<tr>
					<td><?php echo $key+1; ?></td>
					<td><?php echo $rt->rema_returndatebs; ?></td>
					<td><?php echo $rt->issueno; ?></td>
					<td><?php echo $rt->itli_itemname;?></td>
					<td><?php echo $rt->issueno;?></td>
					<td align="right">
						<?php
							$return_total = !empty($rt->returntotal)?$rt->returntotal:0;
							echo number_format($return_total,2);
						?>
					</td>

				<?php  $sum1+= $return_total;?>
				</tr>
				<?php
					endforeach;
					endif;
				?>  
				<tr>
					<td colspan="5" class="text-right" align="right"><b><?php echo $this->lang->line('total_amount'); ?></b></td>
					<td align="right"><strong><?php echo number_format($sum1,2);?></strong></td>
				</tr>
				</tbody>

				<tbody>
					<tr>
						<td colspan="5" class="text-right" align="right"><b><?php echo $this->lang->line('total_issue'); ?></b></td>
						<td align="right">
							<strong>
							<?php
								$iss_total = $sum-$sum1; 
								echo number_format($iss_total,2);
							?>
							</strong>
						</td>
					</tr>
					<tr class="borderBottom">
							<td colspan="6" class="text-center" align="center">
								<strong>
								<?php echo $this->lang->line('in_words').': '.$this->general->number_to_word(abs($iss_total)); ?>
								</strong>
							</td>
						</tr>
				</tbody>
			</table>
			<?php } } ?>
		</div>
	</div>
</div>