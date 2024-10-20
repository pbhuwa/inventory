<form method="post" id="FormList" action="<?php echo base_url('settings/desposal_type/save_desposal'); ?>" class="form-valve form-horizontal form" data-reloadurl='<?php echo base_url('settings/desposal_type/form_view_masterlist'); ?>'>

    <input type="hidden" name="dety_detyid" value="<?php echo!empty($desposal_edit_data[0]->dety_detyid)?$desposal_edit_data[0]->dety_detyid:'';  ?>">

    <div class="form-group">

        <div class="col-md-4">

         <label for="example-text">Desposal Type<span class="required">*</span> :

            </label>

               <input type="text"  name="dety_name" class="form-control" placeholder="Desposal Type" value="<?php echo !empty($desposal_edit_data[0]->dety_name)?$desposal_edit_data[0]->dety_name:''; ?>" autofocus="true">
        </div>
        
        <div class="col-md-4">

         <label for="example-text">Desposal Description<span class="required">*</span> :

            </label>

               <input type="text"  name="dety_description" class="form-control" placeholder="Desposal Description" value="<?php echo !empty($desposal_edit_data[0]->dety_description)?$desposal_edit_data[0]->dety_description:''; ?>" autofocus="true">
        </div>


       <div class="col-sm-6 col-xs-6">
            <label for="example-text">Desposal Code:</label>
            <input type="text" id="example-text" name="dety_code" class="form-control" placeholder="Desposal Code" value="<?php echo !empty($desposal_edit_data[0]->dety_code)?$desposal_edit_data[0]->dety_code:''; ?>">
        </div>


        <div class="col-md-4">
            <label for="example-text">Is Sale?</label><br>
                        <?php
                           $dety_issale_db=!empty($desposal_edit_data[0]->dety_issale)?$desposal_edit_data[0]->dety_issale:'';
                           ?>
                        <select name="dety_issale" id="bnr_status" class="form-control">
                           <option value="Y" >Yes</option>
                           <option value="N" <?php if($dety_issale_db=='N') echo 'selected=selected' ?>>No</option>
                        </select>

        </div>

        <div class="col-md-4">
            <label for="example-text">Is display?</label><br>
                        <?php
                           $dety_isactive_db=!empty($desposal_edit_data[0]->dety_isactive)?$desposal_edit_data[0]->dety_isactive:'';
                           ?>
                        <select name="dety_isactive" id="bnr_status" class="form-control">
                           <option value="Y" >Yes</option>
                           <option value="N" <?php if($dety_isactive_db=='N') echo 'selected=selected' ?>>No</option>
                        </select>

        </div>

    </div>

        <?php
            $save_var=$this->lang->line('save');
            $update_var=$this->lang->line('update');  
        ?>

    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 save" data-operation='<?php echo !empty($desposal_edit_data)?'update':'save' ?>'><?php echo !empty($desposal_edit_data)?$update_var:$save_var; ?></button>

      

       <div  class="alert-success success"></div>

        <div class="alert-danger error"></div>

</form>