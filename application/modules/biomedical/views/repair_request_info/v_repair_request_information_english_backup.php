<style>
	.border-box { border:1px solid #ddd; padding:5px; margin-bottom:10px; }
	.border-box.x2 { border:2px solid #ddd; }
	.border-box.bg { background-color:#f9f9f9; }
	.title_text, .sm_font { font-size:12px; }
	.mb-10 { margin-bottom:10px; }
	.h_100 { min-height:100px; }
	.h_70 { min-height:70px; }
	.brr_date_time { text-align:right; font-size:10px; }
	.brr_list { font-size:12px; width:100%; border-collapse:collapse; }
	.bio_repair_req .brr_title { text-align:center; margin:0; margin-bottom:15px; }
	.med_table, .med_table_add { font-size:12px; width:100%; border-collapse:collapse; border:1px solid #ddd; }
	.med_table_add { border-top:0; }
	.med_table .b_btm { border-bottom:1px solid #ddd; }
	.med_table .b_left { border-left: 1px solid #ddd; }
	.med_table td, .med_table_add { padding:5px; }
	.med_table td {vertical-align: top; }

	.form_fill { margin-top:10px;  }
	.form_fill p { font-size:12px; text-align:right; margin-bottom:2px; }
</style>
<?php if($problemtype=='In'): ?>
<div class="bio_repair_req">
	<div class="brr_date_time"><?php  if(DEFAULT_DATEPICKER=='NP'): echo  $rere_data[0]->rere_postdatebs; else: echo $rere_data[0]->rere_postdatead; endif  ?>  
	<?php echo $rere_data[0]->rere_posttime; ?></div>
	
	<h3 class="brr_title">Biomedical Equipment Repair Request</h3>
	
	<div class="border-box bg">
		<table class="brr_list" width="100%">
			<tr>
				<td width="13%"><b>Equipment Key</b></td>
				<td>: <?php echo $rere_data[0]->bmin_equipmentkey ; ?></td>
				<td width="13%"><b>Description</b></td>
				<td>: <?php echo $rere_data[0]->eqli_description ; ?> </td>			
				<td width="13%"><b>Model Number</b></td>
				<td>:  <?php echo $rere_data[0]->bmin_modelno ; ?></td>		
			</tr>
			<tr>
				<td><b>Serial Number</b></td>
				<td>: <?php echo $rere_data[0]->bmin_serialno ; ?></td>	
				<td><b>Department</b></td>
				<td>:  <?php echo $rere_data[0]->dein_department ; ?></td>
				<td><b>Room</b></td>
				<td>: <?php echo $rere_data[0]->rode_roomname ; ?> </td>
			</tr>
		</table>
	</div>
	<div class="title_text mb-10"><b>Person Reporting Problem </b><u><?php echo !empty($rere_data[0]->usma_username)?ucfirst($rere_data[0]->usma_username):''; ?></u>
		<div class="pull-right">
			<b>Technician:</b>
		<?php echo $rere_data[0]->sete_name; ?>&nbsp;<i class="fa fa-phone-square" aria-hidden="true"></i>
		<?php echo $rere_data[0]->sete_workphone; ?>
		</div>
		
	</div>

	<div class="border-box x2 h_100">
		<div class="sm_font"><b>Describe Problem:</b></div>
		<p><?php echo $rere_data[0]->rere_problem ; ?></p>
	</div>
	<div class="med_form">
		<table class="med_table">
			<tr>
				<td colspan="2" class="b_btm"><b>The Following to be completed by Biomedical Engineering Staff:</b></td>
			</tr>
			<tr class="md-box">
				<td width="50%">
					<b>Observations:</b>
				</td>
				<td rowspan="6" class="b_left"><div><b>Notes:</b><p><?php echo $rere_data[0]->rere_notes ; ?></p></div></td>
			</tr>
			<tr>
				<?php $under_warrenty=!empty($rere_data[0]->rere_warranty)?'✓':'&nbsp;' ?>
				<td style="padding:3px">
					<span style="display:inline-block; width:20px; border:1px solid #000;"><?php echo $under_warrenty; ?></span> 
					Under Warrenty
				</td>
			</tr>
			<tr>
				<?php $onsite=!empty($rere_data[0]->rere_onsite)?'✓':'&nbsp;' ?>
				<td style="padding:3px">
					<span style="display:inline-block; width:20px; border:1px solid #000;"><?php echo $onsite; ?></span> 
					Can be Repaired on Site
				</td>
			</tr>
			<tr><?php $manufcontacted=!empty($rere_data[0]->rere_manufcontacted)?'✓':'&nbsp;' ?>
				<td style="padding:3px">
					<span style="display:inline-block; width:20px; border:1px solid #000;"><?php echo $manufcontacted; ?></span>
					Distributor/Manufacturer must be contacted
				</td>
			</tr>
			<tr>
				<td style="padding:3px">
					<?php $undermaintance=!empty($rere_data[0]->rere_undermaintance)?'✓':'&nbsp;' ?>
					<span style="display:inline-block; width:20px; border:1px solid #000;"><?php echo $undermaintance; ?></span> 
					Moved to Bio med Eng. workshop
				</td>
			</tr>
			<tr>
				<?php $cannotmove=!empty($rere_data[0]->rere_cannotmove)?'✓':'&nbsp;' ?>
				<td style="padding:3px">
					<span style="display:inline-block; width:20px; border:1px solid #000;"><?php echo $cannotmove; ?></span> 
					Cannot be moved
				</td>
			</tr>
		</table>
		<div class="med_table_add">
			<div><b>Action Taken:</b></div>
			<?php echo !empty($rere_data[0]->rere_action)?$rere_data[0]->rere_action:''; ?>
		</div>
		<div class="med_table_add">
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
			<?php //echo !empty($rere_data[0]->rere_parts)?$rere_data[0]->rere_parts:''; ?>
		</div>

		<div class="form_fill">
			<p>Technical Cost :<u><?php echo !empty($rere_data[0]->rere_techcost)?$rere_data[0]->rere_techcost:''; ?></u></p>
			<p>Parts/Material Cost :<u><?php echo !empty($rere_data[0]->rere_partcost)?$rere_data[0]->rere_partcost:''; ?></u></p>
			<!-- <p>Explain ____________________________________________________________________  -->
			<p>Other Cost :<u><?php echo !empty($rere_data[0]->rere_othercost)?$rere_data[0]->rere_othercost:''; ?></u></p>
			<p><b>Total Cost: <u><?php echo !empty($rere_data[0]->rere_totalcost)?$rere_data[0]->rere_totalcost:''; ?></u></b></p>
		</div>

		<div class="form_fill">
			<p>Date Repair Completed:<u><?php echo !empty($rere_data[0]->rere_repairdatead)?$rere_data[0]->rere_repairdatead:''; ?>(AD)<?php echo !empty($rere_data[0]->rere_repairdatebs)?$rere_data[0]->rere_repairdatebs:''; ?>(BS)</u></p>
			
		</div>	
	</div>

</div>

<?php
 else:
?>
<div class="bio_repair_req">
	<div class="brr_date_time"><?php  if(DEFAULT_DATEPICKER=='NP'): echo  $rere_data[0]->rere_postdatebs; else: echo $rere_data[0]->rere_postdatead; endif  ?>  
	<?php echo $rere_data[0]->rere_posttime; ?></div>
	<!-- <h2 class="brr_title">Biomedical Equipment Repair Request</h2> -->
	
	<div class="border-box bg">
		<table class="brr_list" width="100%">
			<tr>
				<td width="13%"><b>Equipment Key</b></td>
				<td>: <?php echo $rere_data[0]->bmin_equipmentkey ; ?></td>
				<td width="13%"><b>Description</b></td>
				<td>: <?php echo $rere_data[0]->eqli_description ; ?> </td>			
				<td width="13%"><b>Model Number</b></td>
				<td>:  <?php echo $rere_data[0]->bmin_modelno ; ?></td>		
			</tr>
			<tr>
				<td><b>Serial Number</b></td>
				<td>: <?php echo $rere_data[0]->bmin_serialno ; ?></td>	
				<td><b>Department</b></td>
				<td>:  <?php echo $rere_data[0]->dein_department ; ?></td>
				<td><b>Room</b></td>
				<td>: <?php echo $rere_data[0]->rode_roomname ; ?> </td>
			</tr>
		</table>
	</div>
	<div class="title_text mb-10"><b>Person Reporting Problem </b><u><?php echo !empty($rere_data[0]->usma_username)?ucfirst($rere_data[0]->usma_username):''; ?></u></div>

	<div class="border-box x2 h_70">
		<div class="sm_font"><b>Describe Problem:</b></div>
		<p><?php echo $rere_data[0]->rere_problem ; ?></p>
	</div>
	<div class="row">
		<div class="col-sm-5">
			<div class="sm_font"><b>Action Taken:</b> </div>
			<?php echo !empty($rere_data[0]->rere_action)?$rere_data[0]->rere_action:''; ?>
		</div>
		<div class="col-sm-7 relative">
			<div class="sm_font"><b>Parts/Material Used:</b> <?php echo $rere_data[0]->rere_ispartsused; ?></div>
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
			</div>
			
	</div>


	
	<div class="form_fill total_rr">
		<div class="row">

			<!-- <p>Explain ____________________________________________________________________  -->
			
			<div class="col-sm-5 pull-right">
				<div class="row">
					<div class="col-sm-4 text-right"><label>Technical Cost :</label></div>
					<div class="col-sm-8"><u><?php echo !empty($rere_data[0]->rere_techcost)?$rere_data[0]->rere_techcost:''; ?></u></div>
					<div class="clearfix"></div>

					<div class="col-sm-4 text-right"><label>Parts/Material Cost :</label></div>
					<div class="col-sm-8"><u><?php echo !empty($rere_data[0]->rere_partcost)?$rere_data[0]->rere_partcost:''; ?></u></div>
					<div class="clearfix"></div>
					
					<div class="clearfix"></div>
					<div class="col-sm-4 text-right"><label>Other Cost :</label></div>
					<div class="col-sm-8"><u><?php echo !empty($rere_data[0]->rere_othercost)?$rere_data[0]->rere_othercost:''; ?></u></div>
					<div class="clearfix"></div>
					<div class="col-sm-4 text-right"><label>Total Cost:</label></div>
					<div class="col-sm-8"><b> <u><?php echo !empty($rere_data[0]->rere_totalcost)?$rere_data[0]->rere_totalcost:''; ?>
					 </u></b></div>
				</div>
				<!-- <p>Explain ____________________________________________________________________  -->
			</div>
			<div class="col-sm-7">
				<div class="row">
					<div class="col-sm-3"><label>Received by:</label></div>
					<div class="col-sm-4">
						<?php echo !empty($rere_data[0]->rere_receivedby)?$rere_data[0]->rere_receivedby:''; ?>
					</div>
					<div class="clearfix"></div>
					<div class="col-sm-3"><label>Receiver Contact no :</label></div>
					<div class="col-sm-4">
					<?php echo !empty($rere_data[0]->rere_receivecontactno)?$rere_data[0]->rere_receivecontactno:''; ?>
						</div>
					<div class="clearfix"></div>
					<div class="col-sm-3"><label>Received Date :</label></div>
					<div class="col-sm-4">
						<?php echo $rere_data[0]->rere_receivedatead.'(AD)/'.$rere_data[0]->rere_receivedatebs.'(BS)'; ?>
							
						</div>
				</div>
			</div>
	</div>
	
	</div>

<?php endif; ?>