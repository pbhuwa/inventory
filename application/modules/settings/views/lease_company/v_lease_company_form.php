<form method="post" id="FormleaseCompany" action="<?php echo base_url('settings/lease_company/save_lease_company'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('settings/lease_company/form_lease_company'); ?>'>
    <input type="hidden" name="id" value="<?php echo !empty($lease_company_data[0]->leco_leasecompanyid)?$lease_company_data[0]->leco_leasecompanyid:'';  ?>">
    <div class="form-group resp_xs">
        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('lease_company_name'); ?>:
            </label>
            <input type="text" id="example-text" name="leco_companyname" class="form-control" placeholder="<?php echo $this->lang->line('lease_company_name'); ?>" value="<?php echo !empty($lease_company_data[0]->leco_companyname)?$lease_company_data[0]->leco_companyname:''; ?>">
        </div>
        
        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('company_code'); ?>:
            </label>
            <input type="text" id="example-text" name="leco_code" class="form-control" placeholder="<?php echo $this->lang->line('company_code'); ?>" value="<?php echo !empty($lease_company_data[0]->leco_code)?$lease_company_data[0]->leco_code:''; ?>">
        </div>

        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('lease_company_address'); ?>:
            </label>
            <input type="text" id="example-text" name="leco_company_address" class="form-control" placeholder="<?php echo $this->lang->line('lease_company_address'); ?>" value="<?php echo !empty($lease_company_data[0]->leco_company_address)?$lease_company_data[0]->leco_company_address:''; ?>">
        </div>
        
        
        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('phone1'); ?>:
            </label>
            <input type="text" id="example-text" name="leco_phone1" class="form-control" placeholder="<?php echo $this->lang->line('phone1'); ?>" value="<?php echo !empty($lease_company_data[0]->leco_phone1)?$lease_company_data[0]->leco_phone1:''; ?>">
        </div>
        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('phone2'); ?>:
            </label>
            <input type="text" id="example-text" name="leco_phone2" class="form-control" placeholder="<?php echo $this->lang->line('phone2'); ?>" value="<?php echo !empty($lease_company_data[0]->leco_phone2)?$lease_company_data[0]->leco_phone2:''; ?>">
        </div>
        
        
        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('email1'); ?>:
            </label>
            <input type="text" id="example-text" name="leco_email1" class="form-control" placeholder="<?php echo $this->lang->line('email1'); ?>" value="<?php echo !empty($lease_company_data[0]->leco_email1)?$lease_company_data[0]->leco_email1:''; ?>">
        </div>
        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('email2'); ?>:
            </label>
            <input type="text" id="example-text" name="leco_email2" class="form-control" placeholder="<?php echo $this->lang->line('email2'); ?>" value="<?php echo !empty($lease_company_data[0]->leco_email2)?$lease_company_data[0]->leco_email2:''; ?>">
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('contact_person_name'); ?>:
            </label>
            <input type="text" id="example-text" name="leco_contactperson_name" class="form-control" placeholder="<?php echo $this->lang->line('contact_person_name'); ?>" value="<?php echo !empty($lease_company_data[0]->leco_contactperson_name)?$lease_company_data[0]->leco_contactperson_name:''; ?>">
        </div>
        
        
        
        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('Contact_person_number'); ?>:
            </label>
            <input type="text" id="example-text" name="leco_contactperson_no" class="form-control" placeholder="<?php echo $this->lang->line('Contact_person_number'); ?>" value="<?php echo !empty($lease_company_data[0]->leco_contactperson_no)?$lease_company_data[0]->leco_contactperson_no:''; ?>">
        </div>
        
        <div class="clearfix"></div>
        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('is_active'); ?>:
            </label>
            <?php $is_active=!empty($lease_company_data[0]->leco_isactive)?$lease_company_data[0]->leco_isactive:''; ?>
            <input type="radio" name="leco_isactive" value="Y" <?php if($is_active=='Y') echo "checked='checked'"; ?>>Yes
            <input type="radio" name="leco_isactive" value="N" <?php if($is_active=='N') echo "checked=checked";?>>No
        </div>
    </div>
    <br>  <br>  
    <div class="form-group">
        <div class="col-sm-6">
            <?php 
                $add_edit_status=!empty($edit_status)?$edit_status:0;
                $usergroup=$this->session->userdata(USER_GROUPCODE);
                   // echo $add_edit_status;
                if((empty($lease_company_data)) || (!empty($lease_company_data) && ($add_edit_status==1 || $usergroup=='SA') )): ?>
            <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($lease_company_data)?'update':'save' ?>' id="btnDeptment" ><?php echo !empty($lease_company_data)?$this->lang->line('update'):$this->lang->line('save') ?></button>
            <?php
                endif; ?>
        </div>
        <div class="col-sm-6">
            <div  class="alert-success success"></div>
            <div class="alert-danger error"></div>
        </div>
    </div>
</form>