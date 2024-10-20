<form method="post" id="FormList" action="<?php echo base_url('settings/soil_type/save_soil'); ?>" class="form-soil form-horizontal form" data-reloadurl='<?php echo base_url('settings/soil_type/form_view_masterlist'); ?>'>

    <input type="hidden" name="soty_id" value="<?php echo!empty($soil_data[0]->soty_id)?$soil_data[0]->soty_id:'';  ?>">

    <div class="form-group">

        <div class="col-md-4">

         <label for="example-text"><?php echo $this->lang->line('soil_type'); ?><span class="required">*</span> :

            </label>

               <input type="text"  name="soty_type" class="form-control" placeholder="Soil Name" value="<?php echo !empty($soil_data[0]->soty_type)?$soil_data[0]->soty_type:''; ?>" autofocus="true">



        </div>

        <div class="col-md-4">
            <label for="example-text">Is display?</label><br>
                        <?php
                           $soty_isactive_db=!empty($soil_data[0]->soty_isactive)?$soil_data[0]->soty_isactive:'';
                           ?>
                        <select name="soty_isactive" id="bnr_status" class="input-small">
                           <option value="Y" >Yes</option>
                           <option value="N" <?php if($soty_isactive_db=='N') echo 'selected=selected' ?>>No</option>
                        </select>

        </div>

    </div>

        <?php
            $save_var=$this->lang->line('save');
            $update_var=$this->lang->line('update');  
        ?>

    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 save" data-operation='<?php echo !empty($soil_data)?'update':'save' ?>'><?php echo !empty($soil_data)?$update_var:$save_var; ?></button>

      

       <div  class="alert-success success"></div>

        <div class="alert-danger error"></div>

</form>