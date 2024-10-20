<form method="post" id="Formfuellist" action="<?php echo base_url('fuel/save_Coupen'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('fuel/form_coupen_entry'); ?>' >
	<div>
		<div class="form-group">
			<div class="col-md-4">
				<label for="example-text">Coupen No:</label>
				<input type="text" class="form-control number" name="fuel_noofcoupen"  value="" id="noofcoupen">
			</div>
			<div class="col-md-4">
				<label for="example-text">Fuel Type:</label>
				<select class="form-control" name="fuel_typeid">
					<option value="">---select---</option>
					<?php
					foreach ($fuel_list as $value) { ?>
						<option value="<?php echo $value->futy_typeid ?>" ><?php echo $value->futy_name ?></option>
						<?php
					}
					?>
				</select>
			</div>
			<div class="col-md-2">
				<label for="example-text">Qty:</label>
				<input type="text" class="form-control number" name="fuel_noofcoupen"  value="" id="noofcoupen" placeholder="Quantity used fuel">
			</div>
			<div class="col-md-2">
				<label for="example-text">Bill No:</label>

				<input type="text" class="form-control number" name="fuel_noofcoupen"  value="" id="noofcoupen" placeholder="Bill No">
			</div>
			<div class="col-md-4">
				<label for="example-text">Month:</label>
				<select class="form-control" name="fuel_month">
					<option value="">---select---</option>
					<?php
					foreach ($month as $value) { ?>
						<option value="<?php echo $value->mona_monthid ?>" ><?php echo $value->mona_namenp ?></option>
						<?php
					}
					?>
				</select>
			</div>
			<div class="col-md-4 ">
				<?php $fuel_fyear = !empty($fuel_data[0]->fuel_fyear)?$fuel_data[0]->fuel_fyear:CUR_FISCALYEAR; ?>
				<label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?> :</label>
				
				<select name="fuel_fyear" class="form-control required_field" id="fyear">
					<?php
					if($fiscal_year): 
						foreach ($fiscal_year as $kf => $fyrs):
							?>
							<option value="<?php echo $fyrs->fiye_name; ?>" <?php if($fyrs->fiye_status=='I') echo "selected=selected"; ?> ><?php echo $fyrs->fiye_name; ?></option>
						<?php endforeach; endif; ?>
					</select>
				</div>
				<div class="col-md-4">
					<label>Fuel Used By</label>
					<select name="fude_staffid" class="form-control select2 " id="staffid">
						<option value="">---select---</option>

						<?php if($staff_all):
							foreach ($staff_all as $key => $staf):?>

								<option value="<?php echo $staf->stin_staffinfoid; ?>"><?php echo $staf->stin_fname.' '. $staf->stin_lname; ?></option>
							<?php endforeach; endif; ?>
						</select>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="form-group" style="margin-top: 2%">
					<div class="col-md-4">
						<button type="submit" id="genCoupen" class="btn btn-info  save"  data-hasck="Y" data-operation='save'>Save</button>
					</div>
					<div class="col-sm-12">
						<div  class="alert-success success"></div>
						<div class="alert-danger error"></div>
					</div>
				</div>
			</div>
		</form>




