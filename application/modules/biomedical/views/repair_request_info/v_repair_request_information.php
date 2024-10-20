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
	h3.brr_title{
		font-size: 17px;
		font-weight: bold;
	}
	.med_table, .med_table_add { font-size:12px; width:100%; border-collapse:collapse; border:1px solid #ddd; }
	.med_table_add { border-top:0; }
	.med_table .b_btm { border-bottom:1px solid #ddd; }
	.med_table .b_left { border-left: 1px solid #ddd; }
	.med_table td, .med_table_add { padding:5px; }
	.med_table td {vertical-align: top; }

	.form_fill { margin-top:10px;  }
	.form_fill p { font-size:12px; text-align:right; margin-bottom:2px; }
</style>
<?php if($rere_data[0]->rere_status=='1'): ?>
	<div class="text-right mbtm_10">
	<a href="javascript:void(0)" class="btn btn-sm btn-success btn_printe" data-print_type='english' data-repairid='<?php echo  $rere_data[0]->rere_repairrequestid ;?>' ><i class="fa fa-print" aria-hidden="true"></i> Print</a>
	<a href="javascript:void(0)" class="btn btn-sm btn-success btn_printe" data-repairid='<?php echo  $rere_data[0]->rere_repairrequestid ;?>' data-print_type='nepali'><i class="fa fa-print" aria-hidden="true"></i> Print In Nepali</a>
</div>
<?php endif; ?>

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
		<div class="sm_font"><b>Problem Description:</b></div>
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
						<td><?php echo !empty($part->eqpa_partsname) ? $part->eqpa_partsname : ''; ?></td>
						<td><?php echo !empty($part->eqpa_qty) ? $part->eqpa_qty :''; ?></td>
						<td><?php echo !empty($part->eqpa_rate) ? $part->eqpa_rate :''; ?></td>
						<td><?php echo !empty($part->eqpa_total) ? $part->eqpa_total :''; ?></td>
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
			<p>Outside Technical Cost :<u><?php echo !empty($rere_data[0]->rere_techcost)?$rere_data[0]->rere_techcost:''; ?></u></p>
			<p>Parts/Material Cost :<u><?php echo !empty($rere_data[0]->rere_partcost)?$rere_data[0]->rere_partcost:''; ?></u></p>
			<!-- <p>Explain ____________________________________________________________________  -->
			<p>Other Cost :<u><?php echo !empty($rere_data[0]->rere_othercost)?$rere_data[0]->rere_othercost:''; ?></u></p>
			<p><b>Total Cost: <u><?php echo !empty($rere_data[0]->rere_totalcost)?$rere_data[0]->rere_totalcost:''; ?></u></b></p>
		</div>
<?php if($rere_data[0]->rere_status!='1'): ?>
		<div class="form_fill">
			<p>Date Repair Completed <u><?php echo !empty($rere_data[0]->rere_repairdatead)?$rere_data[0]->rere_repairdatead:''; ?>(AD)<?php echo !empty($rere_data[0]->rere_repairdatebs)?$rere_data[0]->rere_repairdatebs:''; ?>(BS)</u>Technician <u><?php echo !empty($rere_data[0]->sete_name)?$rere_data[0]->sete_name:''; ?>&nbsp;&nbsp;<?php echo !empty($rere_data[0]->sete_workphone)?$rere_data[0]->sete_workphone:''; ?></u></p>
			
		</div>	
	<?php endif; ?>
	</div>

</div>
<?php if($rere_data[0]->rere_status!='1'): ?>
<div class="text-center confirm_box">
    <p>
        <strong>Do you want to approved this repair request?</strong>
    </p>
    <a href="javascript:void(0)" class="btn btn-success confirmation" data-confirm="yes" data-repairid="<?php echo $rere_data[0]->rere_repairrequestid; ?>">Yes</a>
    <a href="javascript:void(0)" class="btn btn-danger confirmation" data-confirm="no" data-repairid="<?php echo $rere_data[0]->rere_repairrequestid; ?>">No</a>
    <div  class="waves-effect waves-light m-r-10 text-success success"></div>
    <div class="waves-effect waves-light m-r-10 text-danger error"></div>
</div>
<?php endif; ?>

<?php
 else:
 if($rere_data[0]->rere_status!=='1'):	
?>

<form method="POST" id="FormPartsdetails" action="<?php echo base_url('home/save_repair_information_comment'); ?>" >
	<?php //print_r($rere_data);die; ?>
	<input type="hidden" name="bmin_equipid" value="<?php echo $rere_data[0]->bmin_equipid; ?>">
	<input type="hidden" name="rere_repairrequestid" value="<?php echo $rere_data[0]->rere_repairrequestid; ?>">
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
			<div class="sm_font"><b>Action Taken:</b> <span class="required">*</span></div>
			<textarea name="rere_action" cols="30" rows="4" class="form-control"></textarea>
		</div>
		<div class="col-sm-7 relative">
			<div class="sm_font"><b>Parts/Material Used:</b> <input type="radio" name="rere_ispartsused" value="N" class="isparts" checked="checked"> No <input type="radio" name="rere_ispartsused" value="Y" class="isparts"> Yes  </div>
			<div id="is_partsused" style="display: none">
				<a href="javascript:void(0)" class="btn btn-sm btn-primary btnAddParts"><i class="fa fa-plus" aria-hidden="true"></i></a>
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
				<tbody id="tbl_parts">
					<tr class="parts_dtl" id="parts_dtl_1">
						<td><input type="text" name="parts_name[]" class="form-control"></td>
						<td><input type="text" name="qty[]" data-tblid='1' class="form-control number cal " id="qty_1"></td>
						<td><input type="text" name="rate[]" data-tblid='1' class="form-control float cal" id="rate_1"></td>
						<td><input type="text" name="total[]" class="form-control total" id="total_1" readonly="true"></td>
						<td></td>
					</tr>
				</tbody>
			</table>

		</div>
			</div>
			
	</div>


	
	<div class="form_fill total_rr">
		<div class="row">

			<div class="col-sm-5 pull-right">
				<div class="row">
					<div class="col-sm-4 text-right"><label>Technical Cost :</label></div>
					<div class="col-sm-8"><u><input type="text" name="rere_techcost" class="form-control float calcost" id="technicalcost"></u></div>
					<div class="clearfix"></div>
					<div class="col-sm-4 text-right"><label>Parts/Material Cost :</label></div>
					<div class="col-sm-8"><u><span id="material_cost"></span></u><input type="hidden" id="matcost" name="rere_partcost" class="calcost"></div>
					<div class="clearfix"></div>
					<div class="col-sm-4 text-right"><label>Other Cost :</label></div>
					<div class="col-sm-8"><u><input type="text" name="rere_othercost" class="form-control float calcost" id="othercost"></u></div>
					<div class="clearfix"></div>
					<div class="col-sm-4 text-right"><label>Total Cost:</label></div>
					<div class="col-sm-8"><b> <u> <input type="hidden" id="rere_totalcost" name="rere_totalcost" class="form-control float" placeholder="Total Cost" readonly="true"><span id="grandtotal"></span></u></b></div>
				</div>
				<!-- <p>Explain ____________________________________________________________________  -->
			</div>
			<div class="col-sm-7">
				<div class="row">
					<div class="col-sm-3"><label>Received by <span class="required">*</span>:</label></div>
					<div class="col-sm-4"><input type="text" name="rere_receivedby" class="form-control"></div>
					<div class="clearfix"></div>
					<div class="col-sm-3"><label>Receiver Contact no :</label></div>
					<div class="col-sm-4"><input type="text" name="rere_receivecontactno" class="form-control"></div>
					<div class="clearfix"></div>
					<div class="col-sm-3"><label>Received Date :</label></div>
					<div class="col-sm-4"><input type="text" name="rere_receivedate" class="form-control <?php echo DATEPICKER_CLASS; ?>" id="rere_receivedate" value="<?php echo DISPLAY_DATE; ?>" ></div>
				</div>
			</div>
		</div>		
	</div>
	<div class="col-sm-12">
		<button class="pull-right btn btn-sm btn-success save">Save</button>
	</div>
	</div>
	</form>

</div>
<div  class="alert-success success"></div>
<div class="alert-danger error"></div>
<?php else:
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
			<div class="sm_font"><b>Parts/Material Used:</b> <input type="radio" name="rere_ispartsused" value="N" class="isparts" checked="checked"> No <input type="radio" name="rere_ispartsused" value="Y" class="isparts"> Yes  </div>
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
	
	</div>

<?php
endif;
endif;
?>
<div id="np_print">
	
</div>
<script>
	$(document).ready(function(){
		$('.modal-dialog').addClass('modal-lg');
		$('.modal-lg').css('max-width','1152px');
	}) 

$('.engdatepicker').datepicker({
format: 'yyyy/mm/dd',
  autoclose: true
});


$(document).ready(function(){
  $('.nepdatepicker').nepaliDatePicker();
});

</script>

<script type="text/javascript">
	
    // $(document).off('click','.btn_printe');
    //  $(document).on('click','.btn_printe',function(){
    //   $('.bio_repair_req').printThis();
    //  })

      $(document).off('click','.btn_printe');
     $(document).on('click','.btn_printe',function(){
      // $('.bio_repair_req').printThis();
      $('#np_print').html('');
      var repairid=$(this).data('repairid');
      var print_type=$(this).data('print_type');
       $.ajax({
        type: "POST",
        url: base_url+'biomedical/repair_request_info/print_repair_info',
        data:{id:repairid,print_type:print_type},
        dataType: 'html',
        success: function(datas) {
          data = jQuery.parseJSON(datas);   
        // alert(data.status);
        if(data.status=='success')
        {
        	// (data.tempform).printThis();
        	$('#np_print').html(data.tempform);

        	$('#np_print').printThis();
			 setTimeout(function(){
			 	$('#np_print').html('');
			 },800);

        

        }
        else
        {
           alert(data.message);
        }
        }
      });
     })
</script>