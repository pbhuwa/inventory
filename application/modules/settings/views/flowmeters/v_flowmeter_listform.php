<form method="post" id="FormList" action="<?php echo base_url('settings/flowmeter_type/save_flowmeter'); ?>" class="form-flowmeter form-horizontal form" data-reloadurl='<?php echo base_url('settings/flowmeter_type/form_view_masterlist'); ?>'>

    <input type="hidden" name="flty_id" value="<?php echo!empty($flowmeter_data[0]->flty_id)?$flowmeter_data[0]->flty_id:'';  ?>">

    <div class="form-group">

        <div class="col-md-4">

         <label for="example-text">Flowmeter Type<span class="required">*</span> :

            </label>

               <input type="text"  name="flty_name" class="form-control" placeholder="Flowmeter Name" value="<?php echo !empty($flowmeter_data[0]->flty_name)?$flowmeter_data[0]->flty_name:''; ?>" autofocus="true">



        </div>

        <div class="col-md-4">
            <label for="example-text">Is display?</label><br>
                        <?php
                           $flty_isactive_db=!empty($flowmeter_data[0]->flty_isactive)?$flowmeter_data[0]->flty_isactive:'';
                           ?>
                        <select name="flty_isactive" id="bnr_status" class="form-control">
                           <option value="Y" >Yes</option>
                           <option value="N" <?php if($flty_isactive_db=='N') echo 'selected=selected' ?>>No</option>
                        </select>

        </div>

    </div>

        <?php
            $save_var=$this->lang->line('save');
            $update_var=$this->lang->line('update');  
        ?>

    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 save" data-operation='<?php echo !empty($flowmeter_data)?'update':'save' ?>'><?php echo !empty($flowmeter_data)?$update_var:$save_var; ?></button>

      

       <div  class="alert-success success"></div>

        <div class="alert-danger error"></div>

</form>