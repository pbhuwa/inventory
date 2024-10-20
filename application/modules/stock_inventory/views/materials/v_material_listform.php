<form method="post" id="FormList" action="<?php echo base_url('stock_inventory/material_type/save_material'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('stock_inventory/material_type/form_view_masterlist'); ?>'>

    <input type="hidden" name="id" value="<?php echo!empty($material_data[0]->maty_materialtypeid)?$material_data[0]->maty_materialtypeid:'';  ?>">

    <div class="form-group">

        <div class="col-md-4">
         <label for="example-text"><?php echo $this->lang->line('material_type'); ?> <span class="required">*</span> :
            </label>

               <input type="text"  name="maty_material" class="form-control" placeholder="Material Name" value="<?php echo !empty($material_data[0]->maty_material)?$material_data[0]->maty_material:''; ?>" autofocus="true">
        </div>
        <div class="col-md-2">
             <?php $isactive=!empty($material_data[0]->maty_isactive)?$material_data[0]->maty_isactive:''; ?>
            <label>Is Active :</label>
            <select name="maty_isactive" class="form-control">
                <option value="Y" >Yes</option>
                <option value="N" <?php if($isactive=='N') echo "selected=selected"; ?>>No</option>
            </select>
        </div>


    </div>

        <?php
            $save_var=$this->lang->line('save');
            $update_var=$this->lang->line('update');  
        ?>

    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 save" data-operation='<?php echo !empty($material_data)?'update':'save' ?>'><?php echo !empty($material_data)?$update_var:$save_var; ?></button>

      

       <div  class="alert-success success"></div>

        <div class="alert-danger error"></div>

</form>