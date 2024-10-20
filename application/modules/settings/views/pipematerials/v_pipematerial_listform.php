<form method="post" id="FormList" action="<?php echo base_url('settings/pipematerial_type/save_pipematerial'); ?>" class="form-pipematerial form-horizontal form" data-reloadurl='<?php echo base_url('settings/pipematerial_type/form_view_masterlist'); ?>'>

    <input type="hidden" name="pimt_id" value="<?php echo!empty($pipematerial_data[0]->pimt_id)?$pipematerial_data[0]->pimt_id:'';  ?>">

    <div class="form-group">

        <div class="col-md-4">

         <label for="example-text">Pipe Material Name<span class="required">*</span> :

            </label>

               <input type="text"  name="pimt_name" class="form-control" placeholder="Pipe Material Name" value="<?php echo !empty($pipematerial_data[0]->pimt_name)?$pipematerial_data[0]->pimt_name:''; ?>" autofocus="true">



        </div>

        <div class="col-md-4">
            <label for="example-text">Is display?</label><br>
                        <?php
                           $pimt_isactive_db=!empty($pipematerial_data[0]->pimt_isactive)?$pipematerial_data[0]->pimt_isactive:'';
                           ?>
                        <select name="pimt_isactive" id="bnr_status" class="form-control">
                           <option value="Y" >Yes</option>
                           <option value="N" <?php if($pimt_isactive_db=='N') echo 'selected=selected' ?>>No</option>
                        </select>

        </div>

    </div>

        <?php
            $save_var=$this->lang->line('save');
            $update_var=$this->lang->line('update');  
        ?>

    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 save" data-operation='<?php echo !empty($pipematerial_data)?'update':'save' ?>'><?php echo !empty($pipematerial_data)?$update_var:$save_var; ?></button>

      

       <div  class="alert-success success"></div>

        <div class="alert-danger error"></div>

</form>