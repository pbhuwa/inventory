<form method="post" id="FormUnits" action="<?php echo base_url('biomedical/units/save_units'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('biomedical/units/form_units'); ?>'>
    <input type="hidden" name="id" value="<?php echo!empty($units_data[0]->unit_unitid)?$units_data[0]->unit_unitid:'';  ?>">
    <div class="form-group">
        <div class="col-md-4">
            <label for="example-text"><?php echo $this->lang->line('unit_name'); ?>:<span class="required">*</span>
        </label>
        <input type="text" id="example-text" name="unit_unitname" class="form-control" placeholder="Unit Name" value="<?php echo !empty($units_data[0]->unit_unitname)?$units_data[0]->unit_unitname:''; ?>">
    </div>
    <div class="col-md-4">
        <label for="example-text"><?php echo $this->lang->line('active'); ?> :</label>
        <?php $is_active=!empty($units_data[0]->unit_isactive)?$units_data[0]->unit_isactive:''; ?>
        <input type="radio" name="unit_isactive" value="Y" checked="checked"><?php echo $this->lang->line('yes'); ?>
        <input type="radio" name="unit_isactive" value="No" <?php if($is_active=='N') echo "checked=checked";?>><?php echo $this->lang->line('no'); ?>
    </div>
</div>
<button type="submit" class="btn btn-info  savelist" data-operation="save" id="btnDeptment">Save</button>

<div id="ResponseSuccess" class="alert-success success"></div>
<div id="ResponseError" class="alert-danger error"></div>
</form>