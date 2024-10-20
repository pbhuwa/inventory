
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

	<form id="FormCoupenEntry" action="<?php echo base_url('fuel/fuel/coupen_assigned');?>" method="POST">
		<input type="hidden" name="assignid" value="<?php echo !empty($fuel_data[0]->fude_fuelcoupendetailsid)?$fuel_data[0]->fude_fuelcoupendetailsid:'';  ?>">
		
			
			    <div class="col-md-2">
					<label for="example-text">Qty:</label>
					
					<input type="text" class="form-control number" name="fuel_noofcoupen"  value="" id="noofcoupen">
				</div>
				<div class="col-md-2">
					<label for="example-text">Bill No:</label>
					
					<input type="text" class="form-control number" name="fuel_noofcoupen"  value="" id="noofcoupen">
				</div>

				<div class="col-md-2">
					<label for="example-text">Vehical No:</label>
					
					<input type="text" class="form-control number" name="fuel_noofcoupen"  value="" id="noofcoupen">
				</div>
			
			<div class="col-md-12">
				<button type="submit" class="btn btn-info  savelist" data-operation="save" id="btnDeptment" data-isdismiss="Y" data-isrefresh="Y">Entry</button>
			</div>
			<div class="col-sm-12">
				<div  class="alert-success success"></div>
				<div class="alert-danger error"></div>
			</div>
			<div class="clear-fix"></div>
			<div class="clear-fix"></div>
			
			
		</div>
	</div>
</form>









