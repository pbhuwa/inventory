
<form method="post" id="FormDepartmentInformation" action="<?php echo base_url('biomedical/department_information/save_department'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('biomedical/department_information/form_distributor'); ?>'>
	<input type="hidden" name="id" value="<?php echo!empty($doc_data[0]->dein_departmentid)?$doc_data[0]->dein_departmentid:'';  ?>">
	<div class="form-group">
		<div class="col-md-3">
		 	<label for="example-text">Department:</label>
		 	<input type="text"  name="dein_department" class="form-control" placeholder="Department Code" value="<?php echo !empty($doc_data[0]->dein_department)?$doc_data[0]->dein_department:''; ?>">
		</div>
		<div class="col-md-3">
			<label for="example-text">Phone No:</label>
			<input type="text" class="form-control number" name="dein_phone" value="<?php echo !empty($doc_data[0]->dein_phone)?$doc_data[0]->dein_phone:''; ?>" placeholder="Phone No">
		</div>
		<div class="col-md-3">
			<label for="example-text">Dean Department Head:</label>
			<input type="text" class="form-control " name="dein_department_head" value="<?php echo !empty($doc_data[0]->dein_department_head)?$doc_data[0]->dein_department_head:''; ?>" placeholder="Dean Department Head">
		</div>
		<div class="col-md-3">
		    <label for="example-text">Contact No:
		    </label>
		    <input type="text"  name="dein_contact" class="form-control number" placeholder="Contact no" value="<?php echo !empty($doc_data[0]->dein_contact)?$doc_data[0]->dein_contact:''; ?>" >

		</div>

	</div>

	<div class="clearfix"></div>
  	<button type="submit" class="btn btn-info waves-effect waves-light m-r-10 save" data-operation='<?php echo !empty($doc_data)?'update':'save' ?>'><?php echo !empty($doc_data)?'Update':'Save' ?></button>  
    <div  class="waves-effect waves-light m-r-10 text-success success"></div>
   <div class="waves-effect waves-light m-r-10 text-danger error"></div>

      
</form>



