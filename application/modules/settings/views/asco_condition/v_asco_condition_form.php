<form method="post" id="FormleaseCompany" action="<?php echo base_url('settings/asco_condition/save_asco_condition'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('settings/asco_condition/form_asco_condition'); ?>'>
    <input type="hidden" name="id" value="<?php echo !empty($asco_condition_data[0]->asco_ascoid)?$asco_condition_data[0]->asco_ascoid:'';  ?>">
    <div class="form-group resp_xs">
        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('asco_conditionname'); ?>:
            </label>
            <input type="text" id="example-text" name="asco_conditionname" class="form-control" placeholder="<?php echo $this->lang->line('asco_conditionname'); ?>" value="<?php echo !empty($asco_condition_data[0]->asco_conditionname)?$asco_condition_data[0]->asco_conditionname:''; ?>">
        </div>
        
        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('asco_code'); ?>:
            </label>
            <input type="text" id="example-text" name="asco_code" class="form-control" placeholder="<?php echo $this->lang->line('asco_code'); ?>" value="<?php echo !empty($asco_condition_data[0]->asco_code)?$asco_condition_data[0]->asco_code:''; ?>">
        </div>

        
        <div class="clearfix"></div>
        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('is_active'); ?>:
            </label>
                   <?php
                        $is_active=!empty($asco_condition_data[0]->asco_isactive)?$asco_condition_data[0]->asco_isactive:''; ?>
                        <select name="asco_isactive" id="asco_status" class="form-control">
                           <option value="Y" >Yes</option>
                           <option value="N" <?php if($is_active=='N') echo 'selected=selected' ?>>No</option>
                        </select>
           
        </div>
    </div>
    <br>  <br>  
    <div class="form-group">
        <div class="col-sm-6">
            <?php 
                $add_edit_status=!empty($edit_status)?$edit_status:0;
                $usergroup=$this->session->userdata(USER_GROUPCODE);
                   // echo $add_edit_status;
                if((empty($asco_condition_data)) || (!empty($asco_condition_data) && ($add_edit_status==1 || $usergroup=='SA') )): ?>
            <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($asco_condition_data)?'update':'save' ?>' id="btnDeptment" ><?php echo !empty($asco_condition_data)?$this->lang->line('update'):$this->lang->line('save') ?></button>
            <?php
                endif; ?>
        </div>
        <div class="col-sm-6">
            <div  class="alert-success success"></div>
            <div class="alert-danger error"></div>
        </div>
    </div>
</form>