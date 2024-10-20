<div class="clearfix"></div>
<div class="white-box pad-5 mtop_10 pdf-wrapper">
	<div class="jo_form organizationInfo" id="printrpt">

		<?php $this->load->view('common/v_report_header');?>

		<?php  if($summary_report){ ?>
			<table class="alt_table">
				<tbody>
					<tr>
						<td style="font-weight: bold; width:50%;" class="text-right" align="right">
							<?php echo $this->lang->line('issue_rs'); ?>
						</td>
						<td align="right"><?php echo number_format($summary_report[0]->total_issue,2);?></td>
					</tr>
					<tr>
						<td style="font-weight: bold; width:50%;" class="text-right" align="right">
							<?php echo $this->lang->line('issue_return_rs'); ?>
						</td>
						<td align="right"><?php echo number_format($summary_report[0]->total_return,2);?></td>
					</tr>
					<?php $total = ($summary_report[0]->total_issue - $summary_report[0]->total_return);?>
					<tr>
						<td style="font-weight: bold; width:50%;" class="text-right" align="right">
							<?php echo $this->lang->line('total_issue_rs'); ?>
						</td>
						<td align="right"><?php echo number_format($total,2);?></td>
					</tr>
				</tbody>
			</table>
	   	<?php }else{ ?>
			<table class="alt_table">
				<thead>
					<tr>
						<th>sno</th>
						<th>Issue Date </th>
						<th>Issue No</th>
						<th>Department</th>
						<th>Issue Amount</th>
						<th>Amount</th>
					</tr>
				</thead>
				<tbody>
					<?php
						if(!empty($item_report)): 
							foreach($item_report as $key=>$iue):
					?>
					<tr>
						<td colspan="7">Item Name :   <?php echo $iue->itli_itemname;?></td>
					</tr>
					<tr>
						<td><?php echo $key+1; ?></td>
						<td><?php echo $iue->sama_user_name; ?></td>
						<td><?php echo $iue->rema_returndatebs; ?></td>
						<td> <?php echo $iue->sama_billno;?></td>
						<td><?php echo $iue->sade_qty;?></td>
						<td><?php echo $iue->sade_unitrate;?></td>
						<td><?php echo $iue->sama_totalamount;?></td>
					</tr>
					<tr class="alter">
						<td></td>
						<td><b>Total Sold Quantity :  </b></td>
						<td><?php echo $iue->sade_qty;?></td>
						<td></td>
						<td colspan="2"><b>Total Amount</b></td>
						<td><?php echo $iue->sama_totalamount;?></td>
					</tr>
				<?php
						endforeach;
					endif;
				?>
				</tbody>
			</table>
	    <?php } ?>
	</div>
</div>