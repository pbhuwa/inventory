<!-- <div class="col-sm-12"> -->
<div class="white-box pad-5 mtop_10 pdf-wrapper">
	<div class="jo_form organizationInfo" id="printrpt">
		
		
		<?php $this->load->view('common/v_report_header');?>


	       
		<?php  if(!empty($detailsissue)){ ?>
		<table class="alt_table">
			<thead>
				<tr>
					<th><?php echo $this->lang->line('sn'); ?></th>
					<th><?php echo $this->lang->line('issue_date'); ?></th>
					<th><?php echo $this->lang->line('issue_no'); ?></th>
					<th><?php echo $this->lang->line('item_name'); ?></th>
					<th><?php echo $this->lang->line('qty'); ?></th>
					<th><?php echo $this->lang->line('return_total'); ?></th>
					<th><?php echo $this->lang->line('amount'); ?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="7"><?php echo $this->lang->line('issue_return'); ?></td>
				</tr>
				<?php 
					$sum1 = ''; 
					if(!empty($return_report)): 
						foreach($return_report as $key=>$rt):
				?>
				<tr>
					<td><?php echo $key+1; ?></td>
					<td><?php echo $rt->rema_returndatebs; ?></td>
					<td><?php echo $rt->rema_invoiceno; ?></td>
					<td><?php echo $rt->itli_itemname;?></td>
					<td><?php echo $rt->rede_qty;?></td>
					<td align="right"><?php echo number_format($rt->returntotal,2);?></td>
					<td align="right"><?php echo number_format($rt->returntotal,2);?></td>
					<?php  $sum1+= $rt->returntotal;?>
				</tr>
			<?php
					endforeach;
				endif;
			?>  
				<tr>
					<td colspan="6" class="text-right" align="right"><b><?php echo $this->lang->line('total_amount'); ?></b></td>
					<td align="right"><b><?php echo number_format($sum1,2);?></b></td>
				</tr>
			</tbody>
		</table>
	    <?php }
	    else{ ?>
	    <table class="alt_table">
			<thead>
				<tr>
					<th colspan="6">
						<strong><?php echo $this->lang->line('issue'); ?></strong>
					</th>
				</tr>
				<tr>
					<th width="5%"><?php echo $this->lang->line('sn'); ?></th>
					<th width="10%"><?php echo $this->lang->line('issue_date').' ('.$this->lang->line('ad').')'; ?></th>
					<th width="10%"><?php echo $this->lang->line('issue_date').' ('.$this->lang->line('bs').')'; ?></th>
					<th width="10%"><?php echo $this->lang->line('issue_no'); ?></th>
					<th width="20%"><?php echo $this->lang->line('department'); ?></th>
					<th width="15%"><?php echo $this->lang->line('issue_amount'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php $sum = ''; 
				if(!empty($item_report)):

				foreach($item_report as $key=>$iue):
				?>
					<tr>
						<td><?php echo $key+1; ?></td>
						<td><?php echo $iue->sama_billdatead; ?></td>
						<td><?php echo $iue->sama_billdatebs; ?></td>
						<td><?php echo $iue->sama_invoiceno; ?></td>
						<td><?php echo $iue->sama_depname;?></td>
						<td align="right"><?php echo number_format($iue->sama_totalamount,2);?></td>

					<?php  $sum+= $iue->sama_totalamount;?>
					</tr>
					
				<?php
					endforeach;
					endif;
				?>  
				<tr class="borderBottom">
					<td colspan="5" align="right"><b><?php echo $this->lang->line('total_amount'); ?> </b></td>
					<td align="right"><b><?php echo number_format($sum,2);?></b></td>
				</tr>
			</tbody>
		</table>
		<br/>
		<table class="alt_table">
			<thead>
				<tr>
					<th colspan="7">
						<strong><?php echo $this->lang->line('issue_return'); ?></strong>
					</th>
				</tr>
				<tr>
					<th width="7%"><?php echo $this->lang->line('sn'); ?></th>
					<th width="13%"><?php echo $this->lang->line('return_date').' ('.$this->lang->line('ad').')'; ?></th>
					<th width="14%"><?php echo $this->lang->line('return_date').' ('.$this->lang->line('bs').')'; ?></th>
					<th width="13%"><?php echo $this->lang->line('issue_no'); ?></th>
					<th width="20%"><?php echo $this->lang->line('department'); ?></th>
					<th width="12%"><?php echo $this->lang->line('return_no'); ?></th>
					<th width="15%"><?php echo $this->lang->line('return_amount'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php $return_sum = 0; 
				if(!empty($return_report)):

				foreach($return_report as $key=>$iue):
				?>
					<tr>
						<td><?php echo $key+1; ?></td>
						<td><?php echo $iue->rema_returndatead; ?></td>
						<td><?php echo $iue->rema_returndatebs; ?></td>
						<td><?php echo $iue->rema_receiveno; ?></td>
						<td> <?php echo $iue->dept_depname;?></td>
						<td><?php echo $iue->rema_invoiceno; ?></td>
						<td align="right"><?php echo number_format($iue->returntotal,2);?></td>

					<?php  $return_sum+= $iue->returntotal;?>
					</tr>
					
				<?php
					endforeach;
					endif;
				?>  
				<tr class="borderBottom">
					<td colspan="6" align="right"><b><?php echo $this->lang->line('total_amount'); ?> </b></td>
					<td align="right"><b><?php echo number_format($return_sum,2);?></b></td>
				</tr>

				<tr class="borderBottom">
					<td colspan="6" align="right"><b><?php echo $this->lang->line('total').' '.$this->lang->line('issue_amount'); ?> </b></td>
					<?php
						$total_sum = $sum-$return_sum;
					?>	
					<td align="right"><b><?php echo number_format($total_sum,2);?></b></td>
				</tr>
				<tr class="borderBottom">
					<td colspan="7" class="text-center" align="center">
						<strong><?php echo $this->general->number_to_word(abs($total_sum)); ?></strong>
					</td>
				</tr>
			</tbody>
		</table>
		<?php } ?>
	</div>
</div>
<div class="clearfix"></div>
<!-- </div> -->