<form method="post" id="FormBrand" action="<?php echo base_url('settings/brand/save_brand'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('settings/brand/form_brand'); ?>'>

    <input type="hidden" name="id" value="<?php echo !empty($dept_data[0]->bran_brandid) ? $dept_data[0]->bran_brandid : '';  ?>">

    <div class="form-group resp_xs">

        <div class="col-sm-12 col-xs-6">

            <label for="example-text"><?php echo $this->lang->line('brand_code'); ?> <span class="required">*</span>:</label>

            <input type="text" id="bran_code" name="bran_code" class="form-control required_field" placeholder="Brand Code" value="<?php echo !empty($dept_data[0]->bran_code) ? $dept_data[0]->bran_code : ''; ?>">

            <span class="errmsg" id="err_bran_code"></span>

        </div>

        <div class="col-sm-12 col-xs-6">

            <label for="example-text"><?php echo $this->lang->line('brand_name'); ?> <span class="required">*</span>:</label>

            <input type="text" id="bran_name" name="bran_name" class="form-control required_field" placeholder="Brand Name" value="<?php echo !empty($dept_data[0]->bran_name) ? $dept_data[0]->bran_name : ''; ?>">

            <span class="errmsg" id="err_bran_name"></span>

        </div>

        <div class="col-sm-12 col-xs-6">

            <label for="example-text"><?php echo $this->lang->line('address'); ?> :

            </label>

            <input type="text" id="bran_address" name="bran_address" class="form-control" placeholder="Enter Address" value="<?php echo !empty($dept_data[0]->bran_address) ? $dept_data[0]->bran_address : ''; ?>">

        </div>

    </div>

    <?php

    $add_edit_status = !empty($edit_status) ? $edit_status : 0;

    $usergroup = $this->session->userdata(USER_GROUPCODE);

    // echo $add_edit_status;

    if ((empty($dept_data)) || (!empty($dept_data) && ($add_edit_status == 1 || $usergroup == 'SA' || $usergroup == 'SI'))) : ?>



        <?php

        $save_var = $this->lang->line('save');

        $update_var = $this->lang->line('update');

        ?>

        <button type="submit" class="btn btn-info  
        <?php $savelist = !empty($is_savelist) ? 'Y' : 'N';
        if ($savelist == 'Y') echo 'savelist';
        else echo 'save'; ?>" data-operation='<?php echo !empty($dept_data) ? 'update' : 'save' ?>' id="btnDeptment" data-isdismiss="Y"><?php echo !empty($dept_data) ? $update_var : $save_var; ?></button>

    <?php

    endif; ?>

    <div class="alert-success success"></div>

    <div class="alert-danger error"></div>

</form>