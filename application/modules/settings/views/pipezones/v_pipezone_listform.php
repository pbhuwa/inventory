 <form method="post" id="FormList" action="<?php echo base_url('settings/pipezone_type/save_pipezone'); ?>" class="form-pipezone form-horizontal form" data-reloadurl='<?php echo base_url('settings/pipezone_type/form_view_masterlist'); ?>'>

    <input type="hidden" name="pizo_id" value="<?php echo!empty($pipezone_data[0]->pizo_id)?$pipezone_data[0]->pizo_id:'';  ?>">

    <div class="form-group">

        <div class="col-md-4">

         <label for="example-text">Pipezone Name<span class="required">*</span> :

            </label>

               <input type="text"  name="pizo_name" class="form-control" placeholder="Pipezone Name" value="<?php echo !empty($pipezone_data[0]->pizo_name)?$pipezone_data[0]->pizo_name:''; ?>" autofocus="true">



        </div>

        <div class="col-md-4">
          <label >Pipezone Category</label>
          <?php
              $pizo_parentid_db=!empty($pipezone_data[0]->pizo_parentid)?$pipezone_data[0]->pizo_parentid:'';
                           ?>

                     
                        <select name="pizo_parentid" class="form-control">
                        <option value="">---select---</option>
                            <?php 
                            foreach ($pipezone_cat as $value) {
                            ?>
                            <option value="<?php echo $value->pizo_id ?>" <?php if($pizo_parentid_db==$value->pizo_id) echo "selected=selected"; ?> ><?php echo $value->pizo_name; ?></option>
                            <?php
                            }
                            ?>
                        </select>
        </div>

        <div class="col-md-4">
            <label for="example-text">Is display?</label><br>
                        <?php
                           $pizo_isactive_db=!empty($pipezone_data[0]->pizo_isactive)?$pipezone_data[0]->pizo_isactive:'';
                           ?>
                        <select name="pizo_isactive" id="bnr_status" class="form-control">
                           <option value="Y" >Yes</option>
                           <option value="N" <?php if($pizo_isactive_db=='N') echo 'selected=selected' ?>>No</option>
                        </select>

        </div>

    </div>

        <?php
            $save_var=$this->lang->line('save');
            $update_var=$this->lang->line('update');  
        ?>

    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 save" data-operation='<?php echo !empty($pipezone_data)?'update':'save' ?>'><?php echo !empty($pipezone_data)?$update_var:$save_var; ?></button>

      

       <div  class="alert-success success"></div>

        <div class="alert-danger error"></div>

</form>