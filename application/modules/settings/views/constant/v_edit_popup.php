
<form method="post" id="formconstant" action="<?php echo base_url('settings/constant/edit_constant'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('settings/constant'); ?>' >
<input type="hidden" name="id" value="<?php echo!empty($constant_list[0]->cons_id)?$constant_list[0]->cons_id:'';  ?>">
	<div class="form-group ">
		<div class="col-md-6">
			<label><?php echo $this->lang->line('display_text'); ?> : </label>
			<input type="text" name="cons_display" value="<?php echo!empty($constant_list[0]->cons_display)?$constant_list[0]->cons_display:'';  ?>" class="form-control">
		</div>

		<div class="col-md-6">
			<label><?php echo $this->lang->line('name'); ?> : </label>
			<input type="text" name="cons_name" value="<?php echo!empty($constant_list[0]->cons_name)?$constant_list[0]->cons_name:'';  ?>" class="form-control">
		</div>
	</div>
	<div class="form-group ">
		<div class="col-md-4">
			<label><?php echo $this->lang->line('value'); ?> : </label>
			<input type="text" name="cons_value" value="<?php echo!empty($constant_list[0]->cons_value)?$constant_list[0]->cons_value:'';  ?>" class="form-control">
		</div>

		<div class="col-md-4">
			<label><?php echo $this->lang->line('description'); ?> : </label>
			<input type="text" name="cons_description" value="<?php echo!empty($constant_list[0]->cons_description)?$constant_list[0]->cons_description:'';  ?>" class="form-control">
		</div>

		<div class="col-md-4 m-t-15">
			<label class="d-block"><?php echo $this->lang->line('status'); ?></label>
			<input type="radio" name="cons_isactive" value="Y" <?php if($constant_list[0]->cons_isactive=='Y'){echo "checked"; } ?>>Active
			<input type="radio" name="cons_isactive" value="N" <?php if($constant_list[0]->cons_isactive=='N'){echo "checked"; } ?>>Inactive
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

<script>
    $(document).on('click','.refreshTable',function(){
        setTimeout(function(){
            $('.btnRefresh').click();
        },100);
    });
</script>