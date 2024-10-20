<form method="post" id="FormList" action="<?php echo base_url('settings/treatmentplantype/save_treatmentplantype'); ?>" class="form-valve form-horizontal form" data-reloadurl='<?php echo base_url('settings/treatmentplantype/form_view_masterlist'); ?>'>

    <input type="hidden" name="tept_trplid" value="<?php echo!empty($treatment_data[0]->tept_trplid)?$treatment_data[0]->tept_trplid:'';  ?>">

    <div class="form-group">

        <div class="col-md-4">

         <label for="example-text">Treatmentplan type<span class="required">*</span> :

            </label>

               <input type="text"  name="tept_name" class="form-control" placeholder="Treatmentplan Name" value="<?php echo !empty($treatment_data[0]->tept_name)?$treatment_data[0]->tept_name:''; ?>" autofocus="true">
        </div>

       <div class="col-sm-6 col-xs-6">
            <label for="example-text">Treatmentplan Code:</label>
            <input type="text" id="example-text" name="tept_code" class="form-control" placeholder="Treatmentplan Code" value="<?php echo !empty($treatment_data[0]->tept_code)?$treatment_data[0]->tept_code:''; ?>">
        </div>

        <div class="col-md-4">
            <label for="example-text">Is display?</label><br>
                        <?php
                           $tept_isactive_db=!empty($treatment_data[0]->tept_isactive)?$treatment_data[0]->tept_isactive:'';
                           ?>
                        <select name="tept_isactive" id="bnr_status" class="form-control">
                           <option value="Y" >Yes</option>
                           <option value="N" <?php if($tept_isactive_db=='N') echo 'selected=selected' ?>>No</option>
                        </select>

        </div>

    </div>

        <?php
            $save_var=$this->lang->line('save');
            $update_var=$this->lang->line('update');  
        ?>

    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 save" data-operation='<?php echo !empty($treatment_data)?'update':'save' ?>'><?php echo !empty($treatment_data)?$update_var:$save_var; ?></button>

      

       <div  class="alert-success success"></div>

        <div class="alert-danger error"></div>

</form>