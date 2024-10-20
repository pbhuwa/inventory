<style>	
	.table_jo_header, .jo_tbl_head, .jo_table, .jo_footer { width:100%; font-size:12px; border-collapse:collapse; }
	.table_jo_header { width:100%; vertical-align: top; font-size:12px; }
	.table_jo_header td.text-center { text-align:center; }
	.table_jo_header td.text-right { text-align:right; }
	h4 { font-size:18px; margin:0; }
	.table_jo_header u { text-decoration:underline; padding-top:15px; }

	.jo_table { border-right:1px solid #333; margin-top:5px; }
	.jo_table tr th { border-top:1px solid #333; border-bottom:1px solid #333; border-left:1px solid #333; }

	.jo_table tr th { padding:5px 3px;}
	.jo_table tr td { padding:3px 3px; height:15px; border-left:1px solid #333; }
	
	.jo_footer { border:1px solid #333; vertical-align: top; }
	.jo_footer td { padding:8px 8px;	}
		
</style>

<div class="jo_form">
		<table class="table_jo_header">
			<tr>
				<td width="25%" rowspan="5">1</td>
				<td class="text-center"><h3><?PHP echo ORGNAME;?></h3></td>
				<td width="25%" rowspan="5" class="text-right">2</td>
			</tr>
			<tr>
				<td class="text-center"><h4><?php echo ORGNAMEDESC;?></h4></td>
			</tr>
			<tr>
				<td class="text-center"><?php echo LOCATION;?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class="text-center"><h4><u>कार्य आदेश</u></h4></td>
			</tr>
		</table>

		<table class="jo_tbl_head">
			<tr>
				<td></td>
				<td width="17%" class="text-right">Date : ......................</td>
			</tr>
			<tr>
				<td colspan="2">To ....................................................................................................................................................................................</td>
			</tr>
		</table>

		<table  class="jo_table">
			<thead>
				<tr>
					<th width="5%">S.No.</th>
					<th>Task Description</th>
					<th width="25%">Location</th>
					<th width="20%">Remarks</th>
				</tr>
			</thead>
			<tbody>
				<tr style="min-height: 180px">
					<td></td>
					<td>
						<u>Equipment ID:</u> &nbsp; <?php echo !empty($rere_data[0]->bmin_equipmentkey)?$rere_data[0]->bmin_equipmentkey:''; ?> &nbsp;&nbsp;<u>Equipment Details:</u> &nbsp;&nbsp;<?php echo !empty($rere_data[0]->eqli_description)?$rere_data[0]->eqli_description:''; ?>
						<p></p>
						<u>Describe Problem:</u>
						<p>
						<?php echo !empty($rere_data[0]->rere_problem)?$rere_data[0]->rere_problem:'' ; ?>
						</p>
						<p></p>
						<p></p>
						
						<p>
						<u>Action Taken:</u>
						<?php echo !empty($rere_data[0]->rere_action)?$rere_data[0]->rere_action:''; ?>
						</p>
						<div><b>Parts/Material Used:</b></div>
					<table class="table flatTable tcTable compact_Table">
					<thead>
					<tr>
						<th>Parts Name</th>
						<th>Qty</th>
						<th>Rate</th>
						<th>Total</th>
						<th></th>
					</tr>
					</thead>
				<tbody>
					<?php if($part_list):
					foreach ($part_list as $kp => $part):
					 ?>
					<tr>
						<td><?php echo $part->eqpa_partsname; ?></td>
						<td><?php echo $part->eqpa_qty; ?></td>
						<td><?php echo $part->eqpa_rate; ?></td>
						<td><?php echo $part->eqpa_total; ?></td>
					</tr>
					<?php
				endforeach;
				endif;

					 ?>
				</tbody>
			</table>
			<p></p>
			<p>External Technological Cost :<?php echo $rere_data[0]->rere_techcost; ?></p>
			<p>Parts/ Material Cost :<?php echo $rere_data[0]->rere_partcost; ?></p>
			<p>Other Cost :<?php echo $rere_data[0]->rere_othercost; ?></p>
			<p>Total Cost :<?php echo $rere_data[0]->rere_othercost; ?></p>

			<p></p>
			<p></p>
			<p><u>Notes :</u></p>
			<p><?php echo $rere_data[0]->rere_notes; ?></p>
	

					</td>
					<td>
						<?php echo !empty($rere_data[0]->rode_roomname)?$rere_data[0]->rode_roomname:''; ?>
					</td>
					<td>
						
					</td>
				</tr>
				
			</tbody>
		</table>

		<table class="jo_footer">
			<tr>
				<td width="55%">Approval Date <u><?php echo !empty($rere_data[0]->rere_repairdatead)?$rere_data[0]->rere_repairdatead:''; ?>(AD)<?php echo !empty($rere_data[0]->rere_repairdatebs)?$rere_data[0]->rere_repairdatebs:''; ?>(BS)</u></td>
				<td width="45%"></td>
			</tr>
			<tr>
				<td>Technician <u><?php echo !empty($rere_data[0]->sete_name)?$rere_data[0]->sete_name:''; ?>&nbsp;&nbsp;<?php echo !empty($rere_data[0]->sete_workphone)?$rere_data[0]->sete_workphone:''; ?></u></td>
				<td>Signature: .................................................................</td>
			</tr>
			<tr>
				<td>Date .............................................................................................</td>
				<td>Department: <u><?php echo !empty($rere_data[0]->dein_department)?$rere_data[0]->dein_department:''; ?></u></td>
			</tr>
			<tr>
				<td>सन्तुस्टसित काम गरेको छ भनि प्रमाणित गर्ने सूचना आतुरी परेमा बोलाउनु होला </td>
				<td>Date: .........................................................................</td>
			</tr>
		</table>

</div>