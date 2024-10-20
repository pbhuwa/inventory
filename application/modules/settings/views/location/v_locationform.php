<form method="post" id="FormLocation" action="<?php echo base_url('settings/location/save_location'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('settings/location/form_location'); ?>'>
    <input type="hidden" name="id" value="<?php echo!empty($dept_data[0]->loca_locationid)?$dept_data[0]->loca_locationid:'';  ?>">
    <div class="form-group resp_xs">
         <div class="col-sm-12 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('location_code'); ?> <span class="required">*</span>:</label>
            <input type="text" id="loca_code" name="loca_code" class="form-control required_field" placeholder="Branch Code" value="<?php echo !empty($dept_data[0]->loca_code)?$dept_data[0]->loca_code:''; ?>" data-errmsg="">
            <span class="errmsg" id="err_loca_code"></span>
        </div>
        <div class="col-sm-12 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('location_name'); ?> <span class="required">*</span>:</label>
            <input type="text" id="loca_name" name="loca_name" class="form-control required_field" placeholder="Branch Name" value="<?php echo !empty($dept_data[0]->loca_name)?$dept_data[0]->loca_name:''; ?>" data-errmsg="">
             <span class="errmsg" id="err_loca_name"></span>
        </div>
        <div class="col-sm-12 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('address'); ?> :
            </label>
            <input type="text" id="loca_address" name="loca_address" class="form-control" placeholder="Enter Address" value="<?php echo !empty($dept_data[0]->loca_address)?$dept_data[0]->loca_address:''; ?>" >
        </div>
    </div>
    <?php
    $add_edit_status=!empty($edit_status)?$edit_status:0;
    $usergroup=$this->session->userdata(USER_GROUPCODE);
    // echo $add_edit_status;
    if((empty($dept_data)) || (!empty($dept_data) && ($add_edit_status==1 || $usergroup=='SA') )): ?>

    <?php
            $save_var=$this->lang->line('save');
            $update_var=$this->lang->line('update');  
        ?>
    <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($dept_data)?'update':'save' ?>' id="btnlocation" ><?php echo !empty($dept_data)?$update_var:$save_var ; ?></button>
    <?php
    endif; ?>
    <div  class="alert-success success"></div>
    <div class="alert-danger error"></div>
</form>
