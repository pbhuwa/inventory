<form method="post" id="FormConstantsetpopup" action="<?php echo base_url('settings/constant_set/save_constant_set'); ?>" class="form-material form-horizontal form" >
	<div class="form-group ">
		<div class="col-md-4">
			<label><?php echo $this->lang->line('display_text'); ?> : </label>
			<input type="text" name="cons_display" value="" class="form-control">
		</div>

		<div class="col-md-4">
			<label><?php echo $this->lang->line('name'); ?> : </label>
			<input type="text" name="cons_name" value="" class="form-control">
		</div>
		<div class="col-md-4">
			<label><?php echo $this->lang->line('value'); ?> : </label>
			<input type="text" name="cons_value" value="" class="form-control">
		</div>
	</div>
	<div class="form-group ">
		

		<div class="col-md-4">
			<label><?php echo $this->lang->line('description'); ?> : </label>
			<input type="text" name="cons_description" value="" class="form-control">
		</div>
		<div class="col-md-4">
			<label>Category : </label>
			<input type="text" name="cons_category" value="" class="form-control">
		</div>

		<div class="col-md-4 m-t-15">
			<label class="d-block"><?php echo $this->lang->line('status'); ?></label>
			<input type="radio" name="cons_isactive" value="Y" >Active
			<input type="radio" name="cons_isactive" value="N" >Inactive
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-12">
		   	<button type="submit" class="btn btn-info  savelist refreshTable" data-operation='<?php echo !empty($constant_list)?'update':'save' ?>' id="btnSubmit" data-isdismiss='Y' ><?php echo !empty($constant_list)?'Update':'Save' ?></button>
		</div>
		 <div class="col-sm-12">
                <div  class="alert-success success"></div>
                <div class="alert-danger error"></div>
		 </div>
	</div>
</form>

