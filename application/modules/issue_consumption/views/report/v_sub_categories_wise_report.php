<div class="white-box pad-5 mtop_10 pdf-wrapper ">
	<div class="jo_form organizationInfo" id="printrpt">
			
			<?php $this->load->view('common/v_report_header'); ?>
			
			<?php if($category){ ?> 
				<table class="alt_table">
					<thead>
						<tr>
							<th><?php echo $this->lang->line('sn'); ?></th>
							<th><?php echo $this->lang->line('item_name'); ?></th>
							<th><?php echo $this->lang->line('item_code'); ?></th>
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
					 		$i = $issueqtysum = $returnqtysum = $issuesum  = $issuevaluesum = $returnvaluesum = $percentagetotal= $totalissuevalue = $valtotal = 0;
					 		foreach($categorieswise as $key=>$iue):
					 			$iss_qty = !empty($iue->issueqty)?$iue->issueqty:0;
					 			if($iss_qty != 0):
					 				$valtotal += ($iue->issuevalue - $iue->returnvalue);
					?>
					
						<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $iue->itli_itemname; ?></td>
							<td><?php echo $iue->itli_itemcode; ?></td>
							<td><?php echo $iue->issueqty;?></td>
							<td><?php echo $iue->retqty;?></td>
							<td align="right"><?php echo number_format($iue->totalissue,2);?></td>
							<td align="right"><?php echo number_format($iue->issuevalue,2);?></td>
							<td align="right"><?php echo number_format($iue->returnvalue,2);?></td>
							<td align="right"><?php echo number_format($iue->issuevalue - $iue->returnvalue,2);?></td>
							<?php
								$issueqtysum += $iue->issueqty;
								$returnqtysum += $iue->retqty;
								$issuesum += $iue->totalissue;
								$issuevaluesum += $iue->issuevalue;
								$returnvaluesum += $iue->returnvalue;
								//$totalissuevalue += number_format($valtotal,2);
							?>
						</tr>
						
					<?php
								endif;
								$i++;
							endforeach;
						endif;
					?>
					
						<tr>
							<td></td>
							<td></td>
							<td align="right"><b><?php echo $this->lang->line('total'); ?></b></td>
							<td align="right"><b><?php echo number_format($issueqtysum,2);?></b></td>
							<td align="right"><b><?php echo number_format($returnqtysum,2);?></b></td>
							<td align="right"><b><?php echo number_format($issuesum,2);?></b></td>
							<td align="right"><b><?php echo number_format($issuevaluesum,2);?></b></td>
							<td align="right"><b><?php echo number_format($returnvaluesum,2);?></b></td>
							<td align="right"><b><?php echo number_format($valtotal,2);?></b></td>
						</tr>
						<tr>
							<td colspan="8" class="text-right" align="right"><strong><?php echo $this->lang->line('total_issue_value'); ?>: </strong></td>
							<td align="right" ><strong><?php echo number_format($valtotal,2);?></strong></td>
						</tr>
					</tbody>
				</table>
				<?php }else{ ?>
				<table class="alt_table">
					<thead>
						<tr>
							<th><?php echo $this->lang->line('sn'); ?></th>
							<th><?php echo $this->lang->line('category_name'); ?></th>
							<th><?php echo $this->lang->line('issue_qty'); ?></th>
							<th><?php echo $this->lang->line('return_qty'); ?></th>
							<th><?php echo $this->lang->line('total_issue_qty'); ?></th>
							<th><?php echo $this->lang->line('qty'); ?> (%)</th>
							<th><?php echo $this->lang->line('issue_value'); ?></th>
							<th><?php echo $this->lang->line('return_value'); ?></th>
							<th><?php echo $this->lang->line('total_issue_value'); ?></th>
							<th><?php echo $this->lang->line('value'); ?> (%)</th>
						</tr>
					</thead>
					<tbody> 
					<?php
						if(!empty($categorieswise)):
							$valpertot = $vgtotal = $issuesum1 = $totalissuevalue = $valtotal = $gtotal = 0;
							foreach($categorieswise as $key=>$ie):	
								$issuesum1 += $ie->totalissue;
								$valpertot += ($ie->issuevalue - $ie->returnvalue);
					 		endforeach; 
					 		//print_r($valpertot); die;
					 	endif; 

					 	$gtotal =$issuesum1;
						$vgtotal =$valpertot;
					 	
					 	if(!empty($categorieswise)):
					 		$issueqtysum = $returnqtysum = $issuesum  = $issuevaluesum = $returnvaluesum = $percentagetotal= $totalissuevalue = $valtotal = 0;
					 		foreach($categorieswise as $key=>$iue):
					?>
						<tr>
							
							<td><?php echo $key+1; ?></td>
							<td><?php echo $iue->eqca_category; ?></td>
							<td><?php echo $iue->issueqty;?></td>
							<td><?php echo $iue->retqty;?></td>
							<td align="right"><?php echo number_format($iue->totalissue,2);?></td>
							<td align="right"><?php echo number_format(($iue->totalissue * 100)/ $gtotal , 3);?></td>
							<td align="right"><?php echo number_format($iue->issuevalue,2);?></td>
							<td align="right"><?php echo number_format($iue->returnvalue,2);?></td>
							<td align="right"><?php $totissue = $iue->issuevalue - $iue->returnvalue; echo number_format($totissue,2); ?></td>
							<td align="right"><?php $valper = $iue->issuevalue - $iue->returnvalue;
							if($vgtotal>0)
							{
								echo number_format(($valper / $vgtotal) * 100 ,2);
							}
							else
							{
								echo '0.00%';
							}

								
							 ?></td>
							<?php
								if($vgtotal>0)
							{
								$valtotal += number_format(($valper * 100)/$vgtotal , 3);
							}
							
							$percentagetotal += number_format(($iue->totalissue / $gtotal) * 100 , 3);
							$issueqtysum += $iue->issueqty;
							$returnqtysum += $iue->retqty;
							$issuesum += $iue->totalissue;
							$issuevaluesum += $iue->issuevalue;
							$returnvaluesum += $iue->returnvalue;
							//$totalissuevalue += number_format($valpertot,2);
							//echo "<pre>"; print_r($totissue); die;
							//echo $totalissuevalue; die;
							 ?>
						</tr>
						
					<?php
							endforeach;
						endif;
					?>
					
						<tr>
							<td></td>
							<td><b><?php echo $this->lang->line('total'); ?></b></td>
							<td align="right"><b><?php echo number_format($issueqtysum,2);?></b></td>
							<td align="right"><b><?php echo number_format($returnqtysum,2);?></b></td>
							<td align="right"><b><?php echo number_format($issuesum,2);?></b></td>
							<td align="right"><b><?php echo number_format($percentagetotal,2);?> %</b></td>
							<td align="right"><b><?php echo number_format($issuevaluesum,2);?></b></td>
							<td align="right"><b><?php echo number_format($returnvaluesum,2);?></b></td>
							<td align="right"><b><?php echo number_format($valpertot,2);?></b></td>
							<td align="right"><b><?php echo number_format($valtotal,2);?> %</b></td>
						</tr>
					</tbody>
				</table>
		    <?php } ?>
		</div>
	</div>
