<div class="white-box pad-5 mtop_10 pdf-wrapper ">
	<div class="jo_form organizationInfo" id="printrpt">
		<?php $this->load->view('common/v_report_header'); ?>
		<table class="alt_table">
			<thead>
				<tr>
					<th><?php echo $this->lang->line('sn'); ?></th>
					<th><?php echo $this->lang->line('item_code'); ?></th>
					<th><?php echo $this->lang->line('item_name'); ?></th>
					<th><?php echo $this->lang->line('unit'); ?></th>
					<th><?php echo $this->lang->line('issue_qty'); ?></th>
					<th><?php echo $this->lang->line('return_qty'); ?></th>
					<th><?php echo $this->lang->line('total_issue_qty'); ?></th>
					<th><?php echo $this->lang->line('issue_value'); ?></th>
					<th><?php echo $this->lang->line('return_value'); ?></th>
					<th><?php echo $this->lang->line('total_issue_value'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php
					if(!empty($categorieswise)):
						$issueqtysum = $returnqtysum = $issuesum = $issuevaluesum = $returnvaluesum = $totalvaluesum = 0;
						foreach($categorieswise as $key=>$iue):
				?>
				<tr>
					<td><?php echo $key+1; ?></td>
					<td><?php echo $iue->itli_itemcode; ?></td>
					<td><?php echo $iue->itli_itemname; ?></td>
					<td><?php echo $iue->unit_unitname;?></td>
					<td><?php echo $iue->IssQty;?></td>
					<td><?php echo $iue->RetQty;?></td>
					<td align="right"><?php echo number_format(!empty($iue->TotalIssue)?$iue->TotalIssue:0,2);?></td>
					<td align="right"><?php echo number_format(!empty($iue->IssueValue)?$iue->IssueValue:0,2);?></td>
					<td align="right"><?php echo number_format(!empty($iue->ReturnValue)?$iue->ReturnValue:0,2);?></td>
					<td align="right"><?php echo number_format(!empty($iue->TotalValue)?$iue->TotalValue:0,2);?></td>
					<?php
						$issueqtysum += !empty($iue->IssQty)?$iue->IssQty:0;
						$returnqtysum += !empty($iue->RetQty)?$iue->RetQty:0;
						$issuesum += !empty($iue->TotalIssue)?$iue->TotalIssue:0;
						$issuevaluesum += !empty($iue->IssueValue)?$iue->IssueValue:0;
						$returnvaluesum += !empty($iue->ReturnValue)?$iue->ReturnValue:0;
						$totalvaluesum += !empty($iue->TotalValue)?$iue->TotalValue:0;

					?>
				</tr>
				<?php
						endforeach;
					endif;
				?>
				<tr>
					<td colspan="4" class="text-right" align="right"><b><?php echo $this->lang->line('total'); ?></b></td>
					<td><b><?php echo number_format($issueqtysum,2);?></b></td>
					<td><b><?php echo number_format($returnqtysum,2);?></b></td>
					<td><b><?php echo number_format($issuesum,2);?></b></td>
					<td align="right"><b><?php echo number_format($issuevaluesum,2);?></b></td>
					<td align="right"><b><?php echo number_format($returnvaluesum,2);?></b></td>
					<td align="right"><b><?php echo number_format($totalvaluesum,2);?></b></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>