<form method="post" id="FormList" action="<?php echo base_url('settings/building_type/save_build'); ?>" class="form-valve form-horizontal form" data-reloadurl='<?php echo base_url('settings/buildingtype/form_view_masterlist'); ?>'>

    <input type="hidden" name="buty_butyid" value="<?php echo!empty($build_data[0]->buty_butyid)?$build_data[0]->buty_butyid:'';  ?>">

    <div class="form-group">

        <div class="col-md-4">

         <label for="example-text">Building type<span class="required">*</span> :

            </label>

               <input type="text"  name="buty_name" class="form-control" placeholder="Building Name" value="<?php echo !empty($build_data[0]->buty_name)?$build_data[0]->buty_name:''; ?>" autofocus="true">
        </div>

       <div class="col-sm-6 col-xs-6">
            <label for="example-text">Building Code:</label>
            <input type="text" id="example-text" name="buty_code" class="form-control" placeholder="Building Code" value="<?php echo !empty($build_data[0]->buty_code)?$build_data[0]->buty_code:''; ?>">
        </div>

        <div class="col-md-4">
            <label for="example-text">Is display?</label><br>
                        <?php
                           $buty_isactive_db=!empty($build_data[0]->buty_isactive)?$build_data[0]->buty_isactive:'';
                           ?>
                        <select name="buty_isactive" id="build_list" class="form-control">
                           <option value="Y" >Yes</option>
                           <option value="N" <?php if($buty_isactive_db=='N') echo 'selected=selected' ?>>No</option>
                        </select>

        </div>

    </div>

        <?php
            $save_var=$this->lang->line('save');
            $update_var=$this->lang->line('update');  
        ?>

    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 save" data-operation='<?php echo !empty($build_data)?'update':'save' ?>'><?php echo !empty($build_data)?$update_var:$save_var; ?></button>

      

       <div  class="alert-success success"></div>

        <div class="alert-danger error"></div>

</form>