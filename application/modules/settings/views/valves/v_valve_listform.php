<form method="post" id="FormList" action="<?php echo base_url('settings/valve_type/save_valve'); ?>" class="form-valve form-horizontal form" data-reloadurl='<?php echo base_url('settings/valve_type/form_view_masterlist'); ?>'>

    <input type="hidden" name="vaty_id" value="<?php echo!empty($valve_data[0]->vaty_id)?$valve_data[0]->vaty_id:'';  ?>">

    <div class="form-group">

        <div class="col-md-4">

         <label for="example-text">Valve type<span class="required">*</span> :

            </label>

               <input type="text"  name="vaty_name" class="form-control" placeholder="Valve Name" value="<?php echo !empty($valve_data[0]->vaty_name)?$valve_data[0]->vaty_name:''; ?>" autofocus="true">



        </div>

        <div class="col-md-4">
            <label for="example-text">Is display?</label><br>
                        <?php
                           $vaty_isactive_db=!empty($valve_data[0]->vaty_isactive)?$valve_data[0]->vaty_isactive:'';
                           ?>
                        <select name="vaty_isactive" id="bnr_status" class="form-control">
                           <option value="Y" >Yes</option>
                           <option value="N" <?php if($vaty_isactive_db=='N') echo 'selected=selected' ?>>No</option>
                        </select>

        </div>

    </div>

        <?php
            $save_var=$this->lang->line('save');
            $update_var=$this->lang->line('update');  
        ?>

    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 save" data-operation='<?php echo !empty($valve_data)?'update':'save' ?>'><?php echo !empty($valve_data)?$update_var:$save_var; ?></button>

      

       <div  class="alert-success success"></div>

        <div class="alert-danger error"></div>

</form>