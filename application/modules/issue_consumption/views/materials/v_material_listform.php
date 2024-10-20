<form method="post" id="FormList" action="<?php echo base_url('stock_inventory/material_type/save_material'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('stock_inventory/material_type/form_view_masterlist'); ?>'>
    <input type="hidden" name="id" value="<?php echo!empty($maty_data[0]->maty_materialtypeid)?$maty_data[0]->maty_materialtypeid:'';  ?>">
    <div class="form-group">
        <div class="col-md-4">
         <label for="example-text">Material Type <span class="required">*</span> :
            </label>
               <input type="text"  name="maty_material" class="form-control" placeholder="Material Name" value="<?php echo !empty($maty_data[0]->maty_material)?$maty_data[0]->maty_material:''; ?>" autofocus="true">

        </div>
    </div>

    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 save" data-operation='<?php echo !empty($maty_data)?'update':'save' ?>'><?php echo !empty($maty_data)?'Update':'Save' ?></button>
      
       <div  class="alert-success success"></div>
        <div class="alert-danger error"></div>
</form>