<form method="post" id="FormImageText" action="<?php echo base_url('settings/text_imagespdf_setup/save_text_imagespdf_setup'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('settings/department/v_textimage_form'); ?>'>
    

    <input type="hidden" name="id" value="<?php echo!empty($usermain_data[0]->usma_userid)?$usermain_data[0]->usma_userid:'';  ?>">
        <div class="form-group resp_xs">
            <div class="col-sm-4 col-xs-6">
                <label for="example-text"><?php echo $this->lang->line('choose_option_to_change'); ?> :
                </label>
                <?php
                $imgtype=!empty($usermain_data[0]->usma_textimage)?$usermain_data[0]->usma_textimage:'';
                ?>
                <select name="impd_id" class="form-control">
                    <option value="">----select---</option>
                    <?php if($imgpdf):
                    foreach ($imgpdf as $key => $depty):
                    ?>
                    <option value="<?php echo $depty->impd_id; ?>" <?php if($imgtype==$depty->impd_id) echo 'selected=selected'; 
                        else {
                    if(empty($imgtype) ) echo "selected=selected"; } ?>><?php echo $depty->impd_name; ?></option>
                    <?php endforeach; endif; ?>
                </select>
            </div>
        <div class="col-sm-4 col-xs-6">   
        <label for="example-text">&nbsp;</label>
    <div>
    <?php
    $add_edit_status=!empty($edit_status)?$edit_status:0;
    $usergroup=$this->session->userdata(USER_GROUPCODE);
    if((empty($dept_data)) || (!empty($dept_data) && ($add_edit_status==1 || $usergroup=='SA') )): ?>

        <?php
            $save_var=$this->lang->line('save');
            $update_var=$this->lang->line('update');  
        ?>

    <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($dept_data)?'update':'Update' ?>' id="btnDeptment" ><?php echo !empty($dept_data)?$update_var:$update_var ; ?></button>
    <?php
    endif; ?>
    </div>
    </div>
 </div>
  <div  class="alert-success success"></div>
    <div class="alert-danger error"></div>
</form>