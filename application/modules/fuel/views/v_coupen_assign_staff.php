
<?php
if($fuel_data[0]->fude_isassigned=='N'){?>
	<div class="form-group white-box pad-5 bg-gray">
		<div class="row">
			<div class="col-sm-4 col-xs-6">
				<label>Fuel Type</label>: 
				<span> <?php echo !empty($fuel_data[0]->futy_name)?$fuel_data[0]->futy_name:''; ?></span>
			</div>
			<div class="col-sm-4 col-xs-6">
				<label>Coupen No</label>: 
				<span> <?php echo !empty($fuel_data[0]->fude_coupenno)?$fuel_data[0]->fude_coupenno:''; ?></span>
			</div>
			<div class="col-sm-4 col-xs-6">
				<label>Month</label>: 
				<span> <?php echo !empty($fuel_data[0]->mona_namenp)?$fuel_data[0]->mona_namenp:''; ?></span>
			</div>
			<div class="col-sm-4 col-xs-6">
				<label>Fiscal Year</label>: 
				<span> <?php echo !empty($fuel_data[0]->fuel_fyear)?$fuel_data[0]->fuel_fyear:''; ?></span>
			</div>
			<div class="col-sm-4 col-xs-6">
				<label>Valid Date</label>: 
				<span> <?php echo !empty($fuel_data[0]->fuel_expdatebs)?$fuel_data[0]->fuel_expdatebs:''; ?></span>
			</div>
			<div class="col-sm-4 col-xs-6">
				<label>Is Assigned</label>: 
				<span> <?php echo !empty($fuel_data[0]->fude_isassigned)?$fuel_data[0]->fude_isassigned:''; ?></span>
			</div>
			
		</div>
	</div>
	<div class="clear-fix"></div>

	<form id="FormAssign" action="<?php echo base_url('fuel/fuel/coupen_assigned');?>" method="POST">
		<input type="hidden" name="assignid" value="<?php echo !empty($fuel_data[0]->fude_fuelcoupendetailsid)?$fuel_data[0]->fude_fuelcoupendetailsid:'';  ?>">
		<div class="col-md-3">
			<label>Assign Staff</label>
			<select name="fude_staffid" class="form-control select2 staffDetails" id="staffid">
				<option value="">---select---</option>

				<?php if($staff_all):
					foreach ($staff_all as $key => $staf):?>

						<option value="<?php echo $staf->stin_staffinfoid; ?>"><?php echo $staf->stin_fname.' '. $staf->stin_lname; ?></option>

					<?php endforeach; endif; ?>
				</select>
			</div>
			<div class="clear-fix"></div>
			<div class="clear-fix"></div>
			
			<div class="col-md-12">
				<button type="submit" class="btn btn-info  savelist" data-operation="save" id="btnDeptment" data-isdismiss="Y" data-isrefresh="Y">Assigned</button>
			</div>
			<div class="col-sm-12">
				<div  class="alert-success success"></div>
				<div class="alert-danger error"></div>
			</div>
			<div class="clear-fix"></div>
			<div class="clear-fix"></div>
			
			<div class="col-sm-12" id="detailsStaff">
			</div>
		</div>
	</div>
</form>


<?php }else{?>
	

	<button class="btn btn-success PrintThisNow ReprintThis" id="btnPrintNowBtn" data-print="print" data-actionurl="<?php echo base_url('/fuel/fuel/coupen_print') ?>" data-viewdiv="FormDiv_Reprint" data-id="<?php echo !empty($fuel_data[0]->fude_fuelcoupendetailsid)?$fuel_data[0]->fude_fuelcoupendetailsid:''; ?>">
		Print
	</button>
	<div class="form-group white-box pad-5 bg-gray">
		<div class="row">
			<div class="col-sm-4 col-xs-6">
				<label>Fuel Type</label>: 
				<span> <?php echo !empty($fuel_data[0]->futy_name)?$fuel_data[0]->futy_name:''; ?></span>
			</div>
			<div class="col-sm-4 col-xs-6">
				<label>Coupen No</label>: 
				<span> <?php echo !empty($fuel_data[0]->fude_coupenno)?$fuel_data[0]->fude_coupenno:''; ?></span>
			</div>
			<div class="col-sm-4 col-xs-6">
				<label>Month</label>: 
				<span> <?php echo !empty($fuel_data[0]->mona_namenp)?$fuel_data[0]->mona_namenp:''; ?></span>
			</div>
			<div class="col-sm-4 col-xs-6">
				<label>Fiscal Year</label>: 
				<span> <?php echo !empty($fuel_data[0]->fuel_fyear)?$fuel_data[0]->fuel_fyear:''; ?></span>
			</div>
			<div class="col-sm-4 col-xs-6">
				<label>Valid Date</label>: 
				<span> <?php echo !empty($fuel_data[0]->fuel_expdatebs)?$fuel_data[0]->fuel_expdatebs:''; ?></span>
			</div>
			<div class="col-sm-4 col-xs-6">
				<label>Is Assigned</label>: 
				<span> <?php echo !empty($fuel_data[0]->fude_isassigned)?$fuel_data[0]->fude_isassigned:''; ?></span>
			</div>
			
			<div class="col-sm-4 col-xs-6">
				<label> Assigned To</label>: 
				<span> <?php echo !empty($fuel_data[0]->stin_fname.' '.$fuel_data[0]->stin_lname)?$fuel_data[0]->stin_fname.' '.$fuel_data[0]->stin_lname:''; ?></span>
			</div>
			<div class="col-sm-4 col-xs-6">
				<label> Assigned By</label>: 
				<span> <?php echo !empty($fuel_data[0]->fude_assignedby)?$fuel_data[0]->fude_assignedby:''; ?></span>
			</div>
			<div class="col-sm-4 col-xs-6">
				<label> Assigned Date</label>: 
				<span> <?php echo !empty($fuel_data[0]->fude_assigneddatebs)?$fuel_data[0]->fude_assigneddatebs:''; ?></span>
			</div>
			<div class="col-sm-4 col-xs-6">
				<label> Assigned Time</label>: 
				<span> <?php echo !empty($fuel_data[0]->fude_assignedtime)?$fuel_data[0]->fude_assignedtime:''; ?></span>
			</div>
		</div>
	</div>
	<?php echo $this->load->view('v_staff_history'); ?>
	
<?php   } ?>
<div id="FormDiv_Reprint" class="printTable"></div> 







