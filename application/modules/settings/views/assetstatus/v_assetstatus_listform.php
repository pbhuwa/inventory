<form method="post" id="FormList" action="<?php echo base_url('settings/asset_status/save_status'); ?>" class="form-valve form-horizontal form" data-reloadurl='<?php echo base_url('settings/asset_status/form_view_masterlist'); ?>'>

    <input type="hidden" name="asst_asstid" value="<?php echo!empty($status_data[0]->asst_asstid)?$status_data[0]->asst_asstid:'';  ?>">

    <div class="form-group">

        <div class="col-md-4">

         <label for="example-text">Status type<span class="required">*</span> :

            </label>

               <input type="text"  name="asst_statusname" class="form-control" placeholder="Status Name" value="<?php echo !empty($status_data[0]->asst_statusname)?$status_data[0]->asst_statusname:''; ?>" autofocus="true">
        </div>

       <div class="col-sm-6 col-xs-6">
            <label for="example-text">Status Code:</label>
            <input type="text" id="example-text" name="asst_code" class="form-control" placeholder="Status Code" value="<?php echo !empty($status_data[0]->asst_code)?$status_data[0]->asst_code:''; ?>">
        </div>

        <div class="col-md-4">
            <label for="example-text">Is display?</label><br>
         <?php
             $asst_isactive_db=!empty($status_data[0]->asst_isactive)?$status_data[0]->asst_isactive:'';
                           ?>
                        <select name="asst_isactive" id="ast_status" class="form-control">
                           <option value="Y" >Yes</option>
                           <option value="N" <?php if($asst_isactive_db=='N') echo 'selected=selected' ?>>No</option>
                        </select>

        </div>

    </div>

        <?php
            $save_var=$this->lang->line('save');
            $update_var=$this->lang->line('update');  
        ?>

    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 save" data-operation='<?php echo !empty($status_data)?'update':'save' ?>'><?php echo !empty($status_data)?$update_var:$save_var; ?></button>

      

       <div  class="alert-success success"></div>

        <div class="alert-danger error"></div>

</form>