
<div class="clearfix"></div>
<div class="row">
<div class="col-sm-12">
	<div class="white-box pad-5 mtop_10 pdf-wrapper">
		<div class="jo_form organizationInfo" id="printissue">

			<?php $this->load->view('common/v_report_header');?>
		    
		      <table class="table_jo_header purchaseInfo">
					<!-- <tr>
						<td width="25%" rowspan="5"></td>
						<td class="text-center"><h3><?php //echo ORGNAME; ?></h3></td>
						<td width="25%" rowspan="5" class="text-right">2</td>
					</tr>
					<tr>
						<td class="text-center"><h4><?php //echo ORGNAMEDESC; ?></h4></td>
					</tr>
					<tr>
						<td class="text-center"><?php //echo LOCATION; ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr> -->
					
				</table>
				
		        <style>
					.alt_table {  border-collapse:collapse; border:1px solid #000; margin: 0 auto;}
					.alt_table thead tr th, .alt_table tbody tr td { border:1px solid #000; padding:2px 5px; font-size:13px; }
					.alt_table tbody tr td { padding:5px; font-size:12px; }
					.alt_table tbody tr.alter td { border:0; text-align:center; }
					.alt_table tbody tr td.noboder { border-right:0; text-align:center; }
					.alt_table tbody tr td.noboder+td{ border-left: 0px; }


				</style>
				<table class="alt_table">
					<thead>
						<tr>
							<th><?php echo $this->lang->line('sn'); ?></th>
							<th><?php echo $this->lang->line('department'); ?> </th>
							<th><?php echo $this->lang->line('issue_value'); ?></th>
							<th><?php echo $this->lang->line('return_value'); ?></th>
							<th><?php echo $this->lang->line('total_issue_value'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php
					if(!empty($purchase)):
					$totalamount = $returnamount = $issueamountsum = 0;
					foreach($purchase as $key=>$iue):
					?>
						<tr>
							<td><?php echo $key+1; ?></td>
							<td><?php echo $iue->department; ?></td>
							<td align="right"><?php echo number_format($iue->issueamount,2);?></td>
							<td align="right"><?php echo number_format($iue->returnamt,2);?></td>
							<td align="right"><?php echo number_format($iue->totalissueval,2);?></td>
							<?php
							$totalamount += $iue->totalissueval;
							$returnamount += $iue->returnamt;
							$issueamountsum += $iue->issueamount;
							 ?>
						</tr>
						
					<?php
						endforeach;
						endif;
					?>
						<tr class="alter">
							<td></td>
							<td><b><?php echo $this->lang->line('total'); ?> : </b></td>
							<td align="right"><b><?php echo number_format($issueamountsum,2);?></b></td>
							<td align="right"><b><?php echo number_format($returnamount,2);?></b></td>
							<td align="right"><b><?php echo number_format($totalamount,2);?></b></td>
						</tr>
					</tbody>
				</table>
		    <?php //} ?>
		</div>
	</div>
</div>
</div>