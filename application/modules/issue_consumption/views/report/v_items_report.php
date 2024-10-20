<div class="white-box pad-5 mtop_10 pdf-wrapper">
	<div class="jo_form organizationInfo" id="printrpt">
		
		<?php $this->load->view('common/v_report_header');?>

		<?php if(!$issuefrequent){ ?>
			<table class="jo_tbl_head">
				<tr>
					<td>
						<span style="margin-right: 30px">
							<strong><?php echo $this->lang->line('item_name'); ?> : </strong>    <?php echo !empty($item_report[0]->itli_itemname)?$item_report[0]->itli_itemname:'';?>
						</span>
						
						<?php 
							if(!empty($store)):
								echo !empty($item_report[0]->storename)?"<strong>".$this->lang->line('store').": </strong>".$item_report[0]->storename:'';
							endif;
						?>
					</td>
				</tr>
			</table>

			<table class="alt_table">
				<thead>
					<tr>
						<th><?php echo $this->lang->line('sn'); ?></th>
						<th><?php echo $this->lang->line('department'); ?></th>
						<th><?php echo $this->lang->line('date'); ?></th>
						<th><?php echo $this->lang->line('issue_no'); ?></th>
						<th><?php echo $this->lang->line('qty'); ?></th>
						<th><?php echo $this->lang->line('rate'); ?></th>
						<th><?php echo $this->lang->line('amount'); ?></th>
					</tr>
				</thead>
			
				<tbody>
					<?php
						$total_issue_sum1 = $total_amount_sum1 = 0;
						if(!empty($item_report)):  $sum =0;
							foreach($item_report as $key=>$iue):
								$rate = !empty($iue->unitrate)?$iue->unitrate:0;
								$qty = !empty($iue->sade_qty)?$iue->sade_qty:0;
								$total_amt = $rate*$qty;
					?>
						<tr>
							<td><?php echo $key+1; ?></td>
							<td><?php echo $iue->sama_depname; ?></td>
							<td><?php echo $iue->sama_billdatebs; ?></td>
							<td><?php echo $iue->sama_invoiceno;?></td>
							<td><?php echo $qty;?></td>
							<td><?php echo number_format($rate,2);?></td>
							<td><?php echo number_format($total_amt,2);?></td>
						</tr>
					<?php
						$total_issue_sum1 += $qty;
						$total_amount_sum1 += $total_amt;
						endforeach;
						endif;
					?>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td class="text-right" align="right"><b><?php echo $this->lang->line('total_issue_qty'); ?>   </b></td>
							<td><b><?php echo $total_issue_sum1;?></b></td>
							<td class="text-right" align="right"><b><?php echo $this->lang->line('total_amount'); ?> </b></td>
							<td><b><?php echo number_format($total_amount_sum1,2);?></b></td>
							<?php $sum += $total_amt;?>
						</tr>
				</tbody>
			</table>
		<?php }
			elseif($issuefrequent){ 
				//print_r($item_report); die;  ?>
		    	<table class="alt_table">

					<thead>
						<tr>
							<th><?php echo $this->lang->line('sn'); ?></th>
							<th><?php echo $this->lang->line('item_code'); ?></th>
							<th><?php echo $this->lang->line('item_name'); ?></th>
							
							<th><?php echo $this->lang->line('qty'); ?></th>
							<th><?php echo $this->lang->line('rate'); ?></th>
							<th><?php echo $this->lang->line('amount'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$sum_qty3 = 0;
						if(!empty($item_report)):  $sum3 =0;
							foreach($item_report as $key=>$iue):
						?>
							<tr>
								<td><?php echo $key+1; ?></td>
								<td><?php echo $iue->itli_itemcode;?></td>
								<td><?php echo $iue->itli_itemname;?></td>
								<td><?php echo $iue->sade_qty;?></td>
								<td><?php echo number_format($iue->sade_unitrate,2);?></td>
								<td><?php echo number_format($iue->amount,2);?></td>
								<?php 
									$sum3 += $iue->amount;
									$sum_qty3 += $iue->sade_qty;
								?>
							</tr>
						<?php
							endforeach;
						endif;
						?>
					<tr class="total">
						<td colspan="3" class="text-right" align="right"><b><?php echo $this->lang->line('total_issue_qty');?></b>
						<td><?php echo $sum_qty3; ?></td>
						<td class="text-right" align="right"><b><?php echo $this->lang->line('grand_total'); ?></b></td>
						<td><?php echo number_format($sum3,2);?></td>
					</tr>
					<tr>
						<td colspan="6" class="text-center" align="center">
							<strong ><?php echo $this->general->number_to_word($sum3); ?></strong>
						</td>
					</tr>
					</tbody>
				</table>
				<?php }else{ ?>	
				<table class="alt_table">
					<tbody>
					<?php
					if(!empty($item_report)):  
						$sum2 =0;
						// print_r($item_report);
						// die();
						$listbyitem = array();
						foreach($item_report as $key=>$iue):
							$listbyitem[$iue->itli_itemname]['sno'][]=$key+1;
							$listbyitem[$iue->itli_itemname]['depname'][]=$iue->sama_depname;
							$listbyitem[$iue->itli_itemname]['billdate'][] = $iue->sama_billdatebs;
							$listbyitem[$iue->itli_itemname]['invoiceno'][] = $iue->sama_invoiceno;
							$listbyitem[$iue->itli_itemname]['qty'][] = $iue->sade_qty;
							$listbyitem[$iue->itli_itemname]['unitrate'][] = $iue->sade_unitrate;
							$listbyitem[$iue->itli_itemname]['amount'][] = $iue->amount;
						endforeach;

						// print_r($listbyitem);
						// die();
					?>
					<?php
						$sno = 0;
						$i = 0;
						$sum2 = 0;
						$sum_qty2 = 0;
						foreach($listbyitem as $lkey=>$valuebyitem):
					?>
						<tr>
							<td colspan="7">
								<strong><?php echo $this->lang->line('item_name'); ?>  :</strong><?php echo $lkey;?></td>
						</tr>
						<tr>
							<td class="header"><?php echo $this->lang->line('sn'); ?></td>
							<td class="header"><?php echo $this->lang->line('department'); ?></td>
							<td class="header"><?php echo $this->lang->line('date'); ?></td>
							<td class="header"><?php echo $this->lang->line('issue_no'); ?></td>
							<td class="header"><?php echo $this->lang->line('qty'); ?></td>
							<td class="header"><?php echo $this->lang->line('rate'); ?></td>
							<td class="header"><?php echo $this->lang->line('amount'); ?></td>
						</tr>
						<?php
							// echo "<pre>";
							// print_r($valuebyitem['depname']);
						?>
								
							<?php
								$sum_eachqty = 0;
								$sum_eachrate = 0;
								$sum_eachamount = 0; 
								foreach($valuebyitem['depname'] as $depkey=>$depval): 
									$sno++;
									$eachqty = $valuebyitem['qty'][$depkey];
									$eachrate = $valuebyitem['unitrate'][$depkey];
									$eachamt = $valuebyitem['amount'][$depkey];
							?>
								<tr>
									<td><?php echo $sno; ?></td>
									<td><?php echo $depval;?></td>
									<td><?php echo $valuebyitem['billdate'][$depkey];?></td>
									<td><?php echo $valuebyitem['invoiceno'][$depkey];?></td>
									<td><?php echo $eachqty;?></td>
									<td><?php echo number_format($eachrate,2);?></td>
									<td><?php echo number_format($eachamt,2);?></td>
								</tr>
							<?php
								$sum_eachqty+=$eachqty; 
								$sum_eachrate+=$eachrate;
								$sum_eachamount+=$eachamt;
								endforeach; 
							?>
							
						<tr class="borderBottom">
							<td></td>
							<td></td>
							<td></td>
							<td><b><?php echo $this->lang->line('issue_qty'); ?> :  </b></td>
							<td><b><?php echo $sum_eachqty; ?></b></td>
							<td><b><?php echo $this->lang->line('total_amount'); ?></b></td>
							<td><b><?php echo number_format($sum_eachamount,2); ?></b></td>
						</tr>
						<?php 
							$sum2 += $sum_eachamount;
							$sum_qty2 += $sum_eachqty;
						?>
					<?php
						$i++;
						endforeach;
						endif;
					?>
				    <tr class="total">
				    	<td colspan="4" align="right" class="text-right"><b><?php echo $this->lang->line('total_issue_qty'); ?></b></td>
						<td><b><?php echo $sum_qty2;?></b></td>

						<td align="right" class="text-right"><b><?php echo $this->lang->line('grand_total'); ?></b></td>
						<td><b><?php echo number_format($sum2,2);?></b></td>
					</tr>
					<tr>
						<td colspan="7" class="text-center" align="center">
							<strong ><?php echo $this->general->number_to_word($sum2); ?></strong>
						</td>
					</tr>
					</tbody>

				</table>
					<!-- <table class="alt_table">
					<thead>
						<tr>
							<th>sno</th>
							<th>Department</th>
							<th>Date</th>
							<th>Bill no</th>
							<th>Quantity</th>
							<th>Rate</th>
							<th>Amount</th>
						</tr>
					</thead>
					<tbody>
					<?php
					if(!empty($item_report)):  $sum3 =0;
					foreach($item_report as $key=>$iue):
					?>
					
						<tr>
							<td><?php echo $iue->itli_itemname;?></td>
							<td><?php echo $iue->sama_username; ?></td>
							<td><?php echo $iue->sama_billdatebs; ?></td>
							<td> <?php echo $iue->sama_billno;?></td>
							<td><?php echo $iue->sade_qty;?></td>
							<td><?php echo $iue->sade_unitrate;?></td>
							<td><?php echo round($iue->amount,2);?></td>
							<?php $sum3 += $iue->amount;?>
						</tr>
					<?php
						endforeach;
						endif;
					?>
					<tr class="total">
						<td colspan="6"><b>Grand Total</b></td>
						<td><?php echo round($sum3,2);?></td>
					</tr>
					</tbody>
				</table> -->
				<?php } ?>
		</div>
	</div>
<!-- </div> -->