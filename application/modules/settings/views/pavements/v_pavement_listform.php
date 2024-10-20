<form method="post" id="FormList" action="<?php echo base_url('settings/pavement_type/save_pavement'); ?>" class="form-pavement form-horizontal form" data-reloadurl='<?php echo base_url('settings/pavement_type/form_view_masterlist'); ?>'>

    <input type="hidden" name="paty_id" value="<?php echo!empty($pavement_data[0]->paty_id)?$pavement_data[0]->paty_id:'';  ?>">

    <div class="form-group">

        <div class="col-md-4">

         <label for="example-text">Pavement Name<span class="required">*</span> :

            </label>

               <input type="text"  name="paty_name" class="form-control" placeholder="Pavement Name" value="<?php echo !empty($pavement_data[0]->paty_name)?$pavement_data[0]->paty_name:''; ?>" autofocus="true">



        </div>

        <div class="col-md-4">
            <label for="example-text">Is display?</label><br>
                        <?php
                           $paty_isactive_db=!empty($pavement_data[0]->paty_isactive)?$pavement_data[0]->paty_isactive:'';
                           ?>
                        <select name="paty_isactive" id="bnr_status" class="form-control">
                           <option value="Y" >Yes</option>
                           <option value="N" <?php if($paty_isactive_db=='N') echo 'selected=selected' ?>>No</option>
                        </select>

        </div>

    </div>

        <?php
            $save_var=$this->lang->line('save');
            $update_var=$this->lang->line('update');  
        ?>

    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 save" data-operation='<?php echo !empty($pavement_data)?'update':'save' ?>'><?php echo !empty($pavement_data)?$update_var:$save_var; ?></button>

      

       <div  class="alert-success success"></div>

        <div class="alert-danger error"></div>

</form>