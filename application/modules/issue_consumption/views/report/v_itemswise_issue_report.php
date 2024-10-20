<div class="white-box pad-5 mtop_10 pdf-wrapper">
	<div class="jo_form organizationInfo" id="printrpt">
		
		<?php $this->load->view('common/v_report_header');?>
	<?php if(!empty($item_distinct)):
	$i=1; 
			$gtotal=0;
		foreach ($item_distinct as $ki => $item): ?>
		<br>
		<table class="jo_tbl_head">
				<tr>
					<td>
					<strong><?php echo $item->itli_itemname.' - '.$item->itli_itemcode; ?></strong>
					</td>
				</tr>
		</table>

		<?php $issdetail=$this->report_issue_mdl->get_itemwise_detail_issue_report(array('sade_itemsid'=>$item->sade_itemsid),false,false,'sama_billdatebs','ASC',false); 
		// echo $this->db->last_query();
			if(!empty($issdetail)):		
		?>
		<table class="alt_table">
				<thead>
					<tr>
						<th width="5%"><?php echo $this->lang->line('sn'); ?></th>
						<th width="5%"><?php echo $this->lang->line('date_bs'); ?></th>
						<th width="5%"><?php echo $this->lang->line('date_ad'); ?></th>
						<th width="10%"><?php echo $this->lang->line('store'); ?></th>
						<th width="12%"><?php echo $this->lang->line('department'); ?></th>
						<th width="8%"><?php echo $this->lang->line('issue_no'); ?></th>
						<th width="5%"><?php echo $this->lang->line('req_no'); ?></th>
						<th width="15%"><?php echo $this->lang->line('received_by'); ?></th>
						<th width="15%"><?php echo $this->lang->line('remarks'); ?></th>
						<th width="5%" ><?php echo $this->lang->line('qty'); ?></th>
						<th width="6%" ><?php echo $this->lang->line('rate'); ?></th>
						<th width="10%" ><?php echo $this->lang->line('amount'); ?></th>
						
					</tr>
				</thead>
				<tbody>
					<?php 
					$j=1;
					$sum_qty=0;
					$sum_amt=0;
					
					foreach ($issdetail as $kisd => $issd):
					?>
					<tr>
						<td><?php echo $j; ?></td>
						<td><?php echo $issd->sama_billdatebs; ?></td>
						<td><?php echo $issd->sama_billdatead; ?></td>
						<td><?php echo $issd->storename; ?></td>
						<td><?php echo $issd->sama_depname; ?></td>
						<td><?php echo $issd->sama_invoiceno; ?></td>
						<td><?php echo $issd->reqno; ?></td>
						<td><?php echo $issd->sama_receivedby; ?></td>
						<td><?php echo $issd->sade_remarks; ?></td>
						<td align="right"><?php  $qty= $issd->sade_curqty; echo number_format($issd->sade_curqty,2) ?></td>
						<td align="right"><?php echo number_format($issd->unitrate,2); ?></td>
						<td align="right"><?php  $amt=$issd->amount; echo number_format($issd->amount,2)  ?></td>
						
					</tr>
					<?php
					$j++;
					$sum_qty+= $qty;
					$sum_amt+=$amt;
					endforeach;
					$gtotal +=$sum_amt;
					 ?>
				
				
					<tr>
						<td colspan="9" align="right"><strong><?php echo $this->lang->line('total'); ?></strong></td>
						<td align="right"><strong><?php echo number_format($sum_qty,2); ?></strong></td>
						<td></td>
						<td align="right"><strong><?php echo number_format($sum_amt,2); ?></strong></td>
					</tr>
				</tbody>
		</table>
	<?php endif; $i++;endforeach; ?>
	<table class="alt_table">
		<tr>
			<td colspan="12"></td>
		</tr>
		<tr>
			<td colspan="11" align="right"><strong><?php echo $this->lang->line('grand_total');  ?></strong></td>
			<td align="right"><strong><?php echo number_format($gtotal,2); ?></strong></td>
		</tr>
		<tr>
			<td colspan="12" align="center"><strong>
				<?php echo $this->lang->line('in_words'); ?>:<?php echo $this->general->number_to_word($gtotal); ?></strong>
			</td>
			
		</tr>
	</table>
	<?php
	endif; ?>
