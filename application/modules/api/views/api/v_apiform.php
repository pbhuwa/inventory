<form method="post" id="Formapi" action="<?php echo base_url('api/save_api'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('api/form_api'); ?>'>
<input type="hidden" name="id" value="<?php echo!empty($api_data[0]->apta_id)?$api_data[0]->apta_id:'';  ?>">
                                <div class="form-group resp_xs">
                               
                              <div class="col-sm-12 col-xs-6">
                                 <label for="example-text">API Name<span class="required">*</span>:
                                    </label>
                                     <input type="text"  name="apta_name" class="form-control" placeholder="API Name" value="<?php echo !empty($api_data[0]->apta_name)?$api_data[0]->apta_name:''; ?>" autofocus="true">

                                </div>

                               
                              

                                <div class="col-sm-12 col-xs-6">
                                 <label for="example-text">API Link<span class="required">*</span> :
                                    </label>
                                       <input type="text"  name="apta_url" class="form-control" placeholder="API Link" value="<?php echo !empty($api_data[0]->apta_url)?$api_data[0]->apta_url:''; ?>"  >

                                </div>
                             
                                

                                <div class="col-sm-12 col-xs-6">
                                 <label for="example-text">Remarks :
                                    </label>
                                    <textarea name="apta_remarks" class="form-control" ><?php echo !empty($api_data[0]->apta_remarks)?$api_data[0]->apta_remarks:''; ?></textarea>

                                </div>
                                 <div class="col-sm-12 col-xs-6">
                                 <label for="example-text">Is Active
                                    </label>
                                    <input type="checkbox" name="apta_isactive" value="Y" checked="checked">
                                </div>
                              </div>
                              <div class="form-group">
                                    <div class="col-sm-12">
                                      
        <?php 
        $add_edit_status=!empty($edit_status)?$edit_status:0;
        $usergroup=$this->session->userdata(USER_GROUPCODE);
        // echo $add_edit_status;
        if((empty($api_data)) || (!empty($api_data) && ($add_edit_status==1 || $usergroup=='SA') )): ?>

        <?php
            $save_var=$this->lang->line('save');
            $update_var=$this->lang->line('update');  
        ?>
        <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($api_data)?'update':'save' ?>' id="btnDeptment" ><?php echo !empty($api_data)?$update_var:$save_var ; ?></button>
          <?php
           endif; ?>
                                    </div>
                                    <div class="col-sm-12">
                                        <div  class="alert-success success"></div>
                                        <div class="alert-danger error"></div>
                                    </div>
                                </div>    

                            </form>