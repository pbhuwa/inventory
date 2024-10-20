<form method="post" id="FormList" action="<?php echo base_url('settings/hydrant_type/save_hydrant'); ?>" class="form-hydrant form-horizontal form" data-reloadurl='<?php echo base_url('settings/hydrant_type/form_view_masterlist'); ?>'>

    <input type="hidden" name="hyty_id" value="<?php echo!empty($hydrant_data[0]->hyty_id)?$hydrant_data[0]->hyty_id:'';  ?>">

    <div class="form-group">

        <div class="col-md-4">

         <label for="example-text">Hydrant Type<span class="required">*</span> :

            </label>

               <input type="text"  name="hyty_name" class="form-control" placeholder="Hydrant Name" value="<?php echo !empty($hydrant_data[0]->hyty_name)?$hydrant_data[0]->hyty_name:''; ?>" autofocus="true">



        </div>

        <div class="col-md-4">
            <label for="example-text">Is display?</label><br>
                        <?php
                           $hyty_isactive_db=!empty($hydrant_data[0]->hyty_isactive)?$hydrant_data[0]->hyty_isactive:'';
                           ?>
                        <select name="hyty_isactive" id="bnr_status" class="form-control">
                           <option value="Y" >Yes</option>
                           <option value="N" <?php if($hyty_isactive_db=='N') echo 'selected=selected' ?>>No</option>
                        </select>

        </div>

    </div>

        <?php
            $save_var=$this->lang->line('save');
            $update_var=$this->lang->line('update');  
        ?>

    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 save" data-operation='<?php echo !empty($hydrant_data)?'update':'save' ?>'><?php echo !empty($hydrant_data)?$update_var:$save_var; ?></button>

      

       <div  class="alert-success success"></div>

        <div class="alert-danger error"></div>

</form>