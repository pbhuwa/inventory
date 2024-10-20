<form method="post" id="FormList" action="<?php echo base_url('settings/joint_type/save_joint'); ?>" class="form-joint form-horizontal form" data-reloadurl='<?php echo base_url('settings/joint_type/form_view_masterlist'); ?>'>

    <input type="hidden" name="joty_id" value="<?php echo!empty($joint_data[0]->joty_id)?$joint_data[0]->joty_id:'';  ?>">

    <div class="form-group">

        <div class="col-md-4">

         <label for="example-text">Joint Name<span class="required">*</span> :

            </label>

               <input type="text"  name="joty_name" class="form-control" placeholder="Joint Name" value="<?php echo !empty($joint_data[0]->joty_name)?$joint_data[0]->joty_name:''; ?>" autofocus="true">



        </div>

        <div class="col-md-4">
            <label for="example-text">Is display?</label><br>
                        <?php
                           $joty_isactive_db=!empty($joint_data[0]->joty_isactive)?$joint_data[0]->joty_isactive:'';
                           ?>
                        <select name="joty_isactive" id="bnr_status" class="form-control">
                           <option value="Y" >Yes</option>
                           <option value="N" <?php if($joty_isactive_db=='N') echo 'selected=selected' ?>>No</option>
                        </select>

        </div>

    </div>

        <?php
            $save_var=$this->lang->line('save');
            $update_var=$this->lang->line('update');  
        ?>

    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 save" data-operation='<?php echo !empty($joint_data)?'update':'save' ?>'><?php echo !empty($joint_data)?$update_var:$save_var; ?></button>

      

       <div  class="alert-success success"></div>

        <div class="alert-danger error"></div>

</form>