 <form method="post" id="FormInsuranceCompany" action="<?php echo base_url('settings/insurance_company/save_insurance_company'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('settings/insurance_company/form_insurance_company'); ?>'>
    <input type="hidden" name="id" value="<?php echo !empty($insurance_company_data[0]->inco_id)?$insurance_company_data[0]->inco_id:'';  ?>">
    <div class="form-group resp_xs">
        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('insurance_company_name'); ?>:
            </label>
            <input type="text" id="example-text" name="inco_name" class="form-control" placeholder="<?php echo $this->lang->line('insurance_company_name'); ?>" value="<?php echo !empty($insurance_company_data[0]->inco_name)?$insurance_company_data[0]->inco_name:''; ?>">
        </div>
        
        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('insurance_company_address1'); ?>:
            </label>
            <input type="text" id="example-text" name="inco_address1" class="form-control" placeholder="<?php echo $this->lang->line('insurance_company_address1'); ?>" value="<?php echo !empty($insurance_company_data[0]->inco_address1)?$insurance_company_data[0]->inco_address1:''; ?>">
        </div>
        
        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('insurance_company_address2'); ?>:
            </label>
            <input type="text" id="example-text" name="inco_address2" class="form-control" placeholder="<?php echo $this->lang->line('insurance_company_address2'); ?>" value="<?php echo !empty($insurance_company_data[0]->inco_address2)?$insurance_company_data[0]->inco_address2:''; ?>">
        </div>
        
        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('website'); ?>:
            </label>
            <input type="text" id="example-text" name="inco_website" class="form-control" placeholder="<?php echo $this->lang->line('website'); ?>" value="<?php echo !empty($insurance_company_data[0]->inco_website)?$insurance_company_data[0]->inco_website:''; ?>">
        </div>
        
        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('phone'); ?>:
            </label>
            <input type="text" id="example-text" name="inco_phone" class="form-control" placeholder="<?php echo $this->lang->line('phone'); ?>" value="<?php echo !empty($insurance_company_data[0]->inco_phone)?$insurance_company_data[0]->inco_phone:''; ?>">
        </div>
        
        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('fax'); ?>:
            </label>
            <input type="text" id="example-text" name="inco_fax" class="form-control" placeholder="<?php echo $this->lang->line('fax'); ?>" value="<?php echo !empty($insurance_company_data[0]->inco_fax)?$insurance_company_data[0]->inco_fax:''; ?>">
        </div>
        
        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('email'); ?>:
            </label>
            <input type="text" id="example-text" name="inco_email" class="form-control" placeholder="<?php echo $this->lang->line('email'); ?>" value="<?php echo !empty($insurance_company_data[0]->inco_email)?$insurance_company_data[0]->inco_email:''; ?>">
        </div>
        
        <div class="clearfix"></div>
        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('insurance_company_contactperson'); ?>:
            </label>
            <input type="text" id="example-text" name="inco_contactperson" class="form-control" placeholder="<?php echo $this->lang->line('insurance_company_contactperson'); ?>" value="<?php echo !empty($insurance_company_data[0]->inco_contactperson)?$insurance_company_data[0]->inco_contactperson:''; ?>">
        </div>
        
        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('designation'); ?>:
            </label>
            <input type="text" id="example-text" name="inco_designation" class="form-control" placeholder="<?php echo $this->lang->line('designation'); ?>" value="<?php echo !empty($insurance_company_data[0]->inco_designation)?$insurance_company_data[0]->inco_designation:''; ?>">
        </div>
        
        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('insurance_company_mobile'); ?>:
            </label>
            <input type="text" id="example-text" name="inco_mobile" class="form-control" placeholder="<?php echo $this->lang->line('insurance_company_mobile'); ?>" value="<?php echo !empty($insurance_company_data[0]->inco_mobile)?$insurance_company_data[0]->inco_mobile:''; ?>">
        </div>
        
        <div class="clearfix"></div>
        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('is_active'); ?>:
            </label>
            <?php $is_active=!empty($insurance_company_data[0]->inco_isactive)?$insurance_company_data[0]->inco_isactive:''; ?>
            <input type="radio" name="inco_isactive" value="Y" <?php if($is_active=='Y') echo "checked='checked'"; ?>>Yes
            <input type="radio" name="inco_isactive" value="N" <?php if($is_active=='N') echo "checked=checked";?>>No
        </div>
    </div>
    <br>  <br>  
    <div class="form-group">
        <div class="col-sm-6">
            <?php 
                $add_edit_status=!empty($edit_status)?$edit_status:0;
                $usergroup=$this->session->userdata(USER_GROUPCODE);
                   // echo $add_edit_status;
                if((empty($insurance_company_data)) || (!empty($insurance_company_data) && ($add_edit_status==1 || $usergroup=='SA') )): ?>
            <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($insurance_company_data)?'update':'save' ?>' id="btnDeptment" ><?php echo !empty($insurance_company_data)?$this->lang->line('update'):$this->lang->line('save') ?></button>
            <?php
                endif; ?>
        </div>
        <div class="col-sm-6">
            <div  class="alert-success success"></div>
            <div class="alert-danger error"></div>
        </div>
    </div>
</form>