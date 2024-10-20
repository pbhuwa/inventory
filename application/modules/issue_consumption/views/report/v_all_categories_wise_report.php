
	<div class="white-box pad-5 mtop_10 pdf-wrapper">
		<div class="jo_form organizationInfo" id="printrpt">
			<?php $this->load->view('common/v_report_header'); ?>
			<table class="alt_table">
				<thead>
					<tr>
						<th><?php echo $this->lang->line('sn'); ?></th>
						<th><?php echo $this->lang->line('category'); ?></th>
						<th><?php echo $this->lang->line('issue_qty'); ?></th>
						<th><?php echo $this->lang->line('return_qty'); ?></th>
						<th><?php echo $this->lang->line('total_issue_qty'); ?></th>
						<th><?php echo $this->lang->line('qty'); ?>(%)</th>
						<th><?php echo $this->lang->line('issue_value'); ?></th>
						<th><?php echo $this->lang->line('return_value'); ?></th>
						<th><?php echo $this->lang->line('total_issue_value'); ?></th>
						<th><?php echo $this->lang->line('value'); ?>(%)</th>
					</tr>
				</thead>
				<tbody>
					<?php
						if(!empty($categorieswise)):
							$issue_qty_total = $issue_value_total = 0;
							foreach($categorieswise as $catkey=>$catval):
								$issue_qty_total += !empty($catval->TotalIssue)?$catval->TotalIssue:0;
								$issue_value_total += !empty($catval->TotalValue)?$catval->TotalValue:0;
							endforeach;
						endif;

						if(!empty($issue_qty_total)){
							$round_qty_total = round(!empty($issue_qty_total)?$issue_qty_total:0, 2);
							$round_value_total = round(!empty($issue_value_total)?$issue_value_total:0, 2);
						}

						if(!empty($categorieswise)):
							$issueqtysum = $returnqtysum = $issuesum = $issuevaluesum = $returnvaluesum = $totalvaluesum = $qtysum = $valuesum = 0;
							foreach($categorieswise as $key=>$iue):
					?>
					<tr>
						<td><?php echo $key+1; ?></td>
						<td><?php echo $iue->maty_material; ?></td>
						<td><?php echo $iue->IssQty;?></td>
						<td><?php echo $iue->RetQty;?></td>
						<td>
							<?php 
								$round_totalissue = $iue->TotalIssue;
								echo $round_totalissue;
							?>
						</td>
						<td class="text-right">
							<?php
								$qty_per = ($round_totalissue/$round_qty_total)*100;
								echo number_format($qty_per,2);
							?>
						</td>
						<td class="text-right"><?php echo number_format($iue->IssueValue,2);?></td>
						<td class="text-right"><?php echo number_format($iue->ReturnValue,2);?></td>
						<td class="text-right">
							<?php 
								$round_totalvalue = round($iue->TotalValue,2);
								echo number_format($round_totalvalue,2);
							?>
						</td>
						<td class="text-right">
							<?php
								$value_per = 0;
								if($round_value_total != 0){
									$value_per = ($round_totalvalue/$round_value_total)*100;
								}
								
								echo number_format($value_per,2);
							?>
						</td>
						<?php
							$issueqtysum += !empty($iue->IssQty)?$iue->IssQty:0;
							$returnqtysum += !empty($iue->RetQty)?$iue->RetQty:0;
							$issuesum += !empty($iue->TotalIssue)?$iue->TotalIssue:0;
							$issuevaluesum += !empty($iue->IssueValue)?$iue->IssueValue:0;
							$returnvaluesum += !empty($iue->ReturnValue)?$iue->ReturnValue:0;
							$totalvaluesum += !empty($iue->TotalValue)?$iue->TotalValue:0;
							$qtysum += !empty($qty_per)?$qty_per:0;
							$valuesum += !empty($value_per)?$value_per:0;
						?>
					</tr>
					<?php
							endforeach;
						endif;
					?>
					<tr>
						<td colspan="2" class="text-right"><b><?php echo $this->lang->line('total'); ?></b></td>
						<td><b><?php echo !empty($issueqtysum)?$issueqtysum:0;?></b></td>
						<td><b><?php echo !empty($returnqtysum)?$returnqtysum:0;?></b></td>
						<td><b><?php echo !empty($issuesum)?$issuesum:0;?></b></td>
						<td class="text-right"><b><?php echo number_format(!empty($qtysum)?$qtysum:0,2);?>%</b></td>
						<td class="text-right"><b><?php echo number_format(!empty($issuevaluesum)?$issuevaluesum:0,2);?></b></td>
						<td class="text-right"><b><?php echo number_format(!empty($returnvaluesum)?$returnvaluesum:0,2);?></b></td>
						<td class="text-right"><b><?php echo number_format(!empty($totalvaluesum)?$totalvaluesum:0,2);?></b></td>
						<td class="text-right"><b><?php echo number_format(!empty($valuesum)?$valuesum:0,2);?>%</b></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>