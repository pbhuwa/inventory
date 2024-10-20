
<div class="white-box pad-5 mtop_10 pdf-wrapper">
	<div class="jo_form organizationInfo" id="printrpt">
	 <?php  $this->load->view('common/v_report_header',$this->data); ?> 
	<?php if(!empty($assets_report)): 
			$gtotal=0;
		foreach ($assets_report as $ki => $ass): ?>
		<br>
		<table class="jo_tbl_head">
				<tr>
					<td>
					<strong><?php echo $ass->eqca_category; ?></strong>
					</td>
				</tr>
		</table>

		<?php $ass_details=$this->assets_mdl->get_assets_list_data(array('asen_assettype'=>$ass->eqca_equipmentcategoryid),false,false,false,'ASC',false); 
			if(!empty($ass_details)):		
		?>
		<table class="alt_table">
				<thead>
					<tr>
					<th><?php echo $this->lang->line('sn'); ?></th>
					<th><?php echo $this->lang->line('assets_code'); ?></th>
					<th><?php echo $this->lang->line('description'); ?></th>
					<th><?php echo $this->lang->line('model_no'); ?></th>
					<th><?php echo $this->lang->line('serial_no'); ?></th>
					<th><?php echo $this->lang->line('status'); ?></th>
					<th><?php echo $this->lang->line('condition'); ?></th> 
					<th><?php echo $this->lang->line('purchase_date'); ?>(AS)</th>
					<th><?php echo $this->lang->line('purchase_date'); ?>(BS)</th>
					<th><?php echo $this->lang->line('supplier'); ?></th>
					<th>Branch</th> 
					<th><?php echo $this->lang->line('assets_type'); ?></th>
					<th><?php echo $this->lang->line('rate'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i=1;
					$sum_qty=0;
					$sum_rate_amt=0;
					
					foreach ($ass_details as $keys => $iue):
					?>
					<tr>
						<td><?php echo $i;?></td>
						<td><?php echo $iue->asen_assetcode; ?></td>
						<td><?php echo $iue->asen_desc; ?></td>
						<td><?php echo $iue->asen_modelno; ?></td>
						<td><?php echo $iue->asen_serialno; ?></td>
						<td><?php echo $iue->asst_statusname; ?></td>
						<td><?php echo $iue->asco_conditionname; ?></td>
                        <td><?php echo $iue->asen_purchasedatead; ?></td>
						<td><?php echo $iue->asen_purchasedatebs; ?></td>
					
						<td><?php echo $iue->dist_distributor; ?></td>
						<td><?php echo $iue->loca_name; ?></td>
						<td><?php echo $iue->asty_typename; ?></td>
					    <td align="right"><?php  $purchase_rate=$iue->asen_purchaserate; echo number_format($iue->asen_purchaserate,2)  ?></td>
						
					</tr>
					<?php
					$i++;
					
					$sum_rate_amt+=$purchase_rate;
					endforeach;
					$gtotal +=$sum_rate_amt;
					 ?>
				
				
					<tr>
						<td colspan="12" align="right"><strong><?php echo $this->lang->line('total'); ?></strong></td>
						
					
						<td align="right"><strong><?php echo number_format($sum_rate_amt,2); ?></strong></td>
					</tr>
				</tbody>
		</table>
	<?php endif; endforeach; ?>
	<table class="alt_table">
		<tr>
			<td colspan="14"></td>
		</tr>
		<tr>
			<td colspan="12" align="right"><strong><?php echo $this->lang->line('grand_total');  ?></strong></td>
			<td align="right"><strong><?php echo number_format($gtotal,2); ?></strong></td>
		</tr>
		<tr>
			<td colspan="14" align="center"><strong>
				<?php echo $this->lang->line('in_words'); ?>:<?php echo $this->general->number_to_word($gtotal); ?></strong>
			</td>
			
		</tr>
	</table>
	<?php
	endif; ?>