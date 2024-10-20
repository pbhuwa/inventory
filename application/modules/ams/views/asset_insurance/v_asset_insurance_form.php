<form method="post" id="FormAssetinsurance" action="<?php echo base_url('ams/asset_insurance/save_asset_insurance'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('ams/asset_insurance/form_insurance_data'); ?>'>
    <input type="hidden" name="id" value="<?php echo !empty($asset_insurance_data[0]->asin_asinid)?$asset_insurance_data[0]->asin_asinid:'';  ?>">
    <div class="form-group resp_xs">
        
        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('asset_name'); ?>:
            </label>
            <?php $asinid=!empty($asset_insurance_data[0]->asin_asinid)?$asset_insurance_data[0]->asin_asinid:''; ?>
                        <select name="asin_assetid" class="form-control" autofocus="true">
                            <option value="">----select---</option>
                            <?php if($asset_all):
                                foreach ($asset_all as $kd => $kasset):?>
                            <option value="<?php echo $kasset->asen_asenid; ?>" <?php if($asinid==$kasset->asen_asenid) echo 'selected=selected'; ?> >
                                <?php echo $kasset->asen_assetcode; ?>
                            </option>
                            <?php endforeach; endif; ?>
                        </select>
                        <?=form_error('asin_asinid')?>
        </div>

    <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('asset_insurance_name'); ?>:
            </label>
            <?php $asinid=!empty($asset_insurance_data[0]->asin_asinid)?$asset_insurance_data[0]->asin_asinid:''; ?>
                        <select name="asin_companyid" class="form-control" autofocus="true">
                            <option value="">----select---</option>
                            <?php if($insurance_company_all):
                                foreach ($insurance_company_all as $kd => $kinsurance):?>
                            <option value="<?php echo $kinsurance->inco_id; ?>" <?php if($asinid==$kinsurance->inco_id) echo 'selected=selected'; ?> >
                                <?php echo $kinsurance->inco_name; ?>
                            </option>
                            <?php endforeach; endif; ?>
                        </select>
                        <?=form_error('asin_asinid')?>
        </div>

        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('asset_insurance_type'); ?>:
                        </label>
                        <?php $asinid=!empty($asset_insurance_data[0]->asin_asinid)?$asset_insurance_data[0]->asin_asinid:''; ?>
                        <select name="asin_typeid" class="form-control" autofocus="true">
                            <option value="">----select---</option>
                            <?php if($insurance_type_all):
                                foreach ($insurance_type_all as $kd => $kinsurance):?>
                            <option value="<?php echo $kinsurance->inty_intyid; ?>" <?php if($asinid==$kinsurance->inty_intyid) echo 'selected=selected'; ?> >
                                <?php echo $kinsurance->inty_name; ?>
                            </option>
                            <?php endforeach; endif; ?>
                        </select>
                        <?=form_error('asin_asinid')?>
        </div>
        
        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('asset_insurance_code'); ?>:
            </label>
            <input type="text" id="example-text" name="asin_code" class="form-control" placeholder="<?php echo $this->lang->line('asset_insurance_code'); ?>" value="<?php echo !empty($asset_insurance_data[0]->asin_code)?$asset_insurance_data[0]->asin_code:''; ?>">
        </div>
        
        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('asset_insurance_policy_no'); ?>:
            </label>
            <input type="text" id="example-text" name="asin_policyno" class="form-control" placeholder="<?php echo $this->lang->line('asset_insurance_policy_no'); ?>" value="<?php echo !empty($asset_insurance_data[0]->asin_policyno)?$asset_insurance_data[0]->asin_policyno:''; ?>">
        </div>
        
          <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('asset_insurance_amount'); ?>:
            </label>
            <input type="text" id="example-text" name="asin_insuranceamount" class="form-control" placeholder="<?php echo $this->lang->line('asset_insurance_amount'); ?>" value="<?php echo !empty($asset_insurance_data[0]->asin_insuranceamount)?$asset_insurance_data[0]->asin_insuranceamount:''; ?>">
        </div>
        
        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('asset_insurance_rate'); ?>:
            </label>
            <input type="text" id="example-text" name="asin_insurancerate" class="form-control" placeholder="<?php echo $this->lang->line('asset_insurance_rate'); ?>" value="<?php echo !empty($asset_insurance_data[0]->asin_insurancerate)?$asset_insurance_data[0]->asin_insurancerate:''; ?>">
        </div>
           
        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('start_date'); ?>: </label>
            <input type="text" id="asin_startdatead" name="asin_startdatead" class="form-control <?php echo DATEPICKER_CLASS; ?>" placeholder="" value="<?php echo !empty($asset_insurance_data[0]->asin_startdatead)?$asset_insurance_data[0]->asin_startdatead:DISPLAY_DATE; ?>">
        </div>

           <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('end_date'); ?>: </label>
            <input type="text" id="asin_enddatead" name="asin_enddatead" class="form-control <?php echo DATEPICKER_CLASS; ?>" placeholder="" value="<?php echo !empty($asset_insurance_data[0]->asin_enddatead)?$asset_insurance_data[0]->asin_enddatead:DISPLAY_DATE; ?>">
        </div>
        
        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('renewal_date'); ?>: </label>
            <input type="text" id="asin_renewaldatead" name="asin_renewaldatead" class="form-control <?php echo DATEPICKER_CLASS; ?>" placeholder="" value="<?php echo !empty($asset_insurance_data[0]->asin_renewaldatead)?$asset_insurance_data[0]->asin_renewaldatead:DISPLAY_DATE; ?>">
        </div>
        
        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('renewal_period'); ?>:
                        </label>
                        <?php $asinid=!empty($asset_insurance_data[0]->asin_asinid)?$asset_insurance_data[0]->asin_asinid:''; ?>
                        <select name="asin_renewalperiod" class="form-control" autofocus="true">
                            <option value="">----select---</option>
                            <?php if($renewalperiod_all):
                                foreach ($renewalperiod_all as $kd => $kperiod):?>
                            <option value="<?php echo $kperiod->peri_periid; ?>" <?php if($asinid==$kperiod->peri_periid) echo 'selected=selected'; ?> >
                                <?php echo $kperiod->peri_name; ?>
                            </option>
                            <?php endforeach; endif; ?>
                        </select>
                        <?=form_error('asin_asinid')?>
        </div>

        
        <div class="clearfix"></div>
        
    </div>
    <br>  <br>  
    <div class="form-group">
        <div class="col-sm-6">
            <?php 
                $add_edit_status=!empty($edit_status)?$edit_status:0;
                $usergroup=$this->session->userdata(USER_GROUPCODE);
                   // echo $add_edit_status;
                if((empty($asset_insurance_data)) || (!empty($asset_insurance_data) && ($add_edit_status==1 || $usergroup=='SA') )): ?>
            <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($asset_insurance_data)?'update':'save' ?>' id="btnDeptment" ><?php echo !empty($asset_insurance_data)?$this->lang->line('update'):$this->lang->line('save') ?></button>
            <?php
                endif; ?>
        </div>
        <div>
            <div  class="alert-success success"></div>
            <div class="alert-danger error"></div>
        </div>
    </div>
</form>