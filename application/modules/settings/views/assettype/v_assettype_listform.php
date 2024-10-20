<form method="post" id="FormList" action="<?php echo base_url('settings/asset_type/save_asset'); ?>" class="form-valve form-horizontal form" data-reloadurl='<?php echo base_url('settings/asset_type/form_view_masterlist'); ?>'>

    <input type="hidden" name="asty_astyid" value="<?php echo!empty($asset_data[0]->asty_astyid)?$asset_data[0]->asty_astyid:'';  ?>">

    <div class="form-group">

        <div class="col-md-4">

         <label for="example-text">Asset type<span class="required">*</span> :

            </label>

               <input type="text"  name="asty_typename" class="form-control" placeholder="Asset Type Name" value="<?php echo !empty($asset_data[0]->asty_typename)?$asset_data[0]->asty_typename:''; ?>" autofocus="true">
        </div>

         <div class="col-sm-4 ">
            <label for="example-text">Asset Code:</label>
            <input type="text" id="example-text" name="asty_code" class="form-control" placeholder="Asset Code" value="<?php echo !empty($asset_data[0]->asty_code)?$asset_data[0]->asty_code:''; ?>">
        </div>

        <div class="col-md-4">
            <label for="example-text">Is display?</label><br>
                        <?php
                           $asty_isactive_db=!empty($asset_data[0]->asty_isactive)?$asset_data[0]->asty_isactive:'';
                           ?>
                        <select name="asty_isactive" id="asset_ty" class="form-control">
                           <option value="Y" >Yes</option>
                           <option value="N" <?php if($asty_isactive_db=='N') echo 'selected=selected' ?>>No</option>
                        </select>

        </div>

    </div>

        <?php
            $save_var=$this->lang->line('save');
            $update_var=$this->lang->line('update');  
        ?>

    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 save" data-operation='<?php echo !empty($asset_data)?'update':'save' ?>'><?php echo !empty($asset_data)?$update_var:$save_var; ?></button>

      

       <div  class="alert-success success"></div>

        <div class="alert-danger error"></div>

</form>