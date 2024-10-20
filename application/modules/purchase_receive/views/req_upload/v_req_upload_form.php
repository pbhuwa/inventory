<style>
    .purs_table tbody tr td{
    border: none;
    vertical-align: center;
    }
</style>
<?php
    if(DEFAULT_DATEPICKER == 'NP'){
        $quotation_date = !empty($upload_data[0]->quma_quotationdatebs)?$upload_data[0]->quma_quotationdatebs:'';
        $supplier_qdate = !empty($upload_data[0]->quma_supplierquotationdatebs)?$upload_data[0]->quma_supplierquotationdatebs:'';  
        $expdate = !empty($upload_data[0]->quma_expdatebs)?$upload_data[0]->quma_expdatebs:''; 
        $curdate = CURDATE_NP; 
    }else{
        $quotation_date = !empty($upload_data[0]->quma_quotationdatead)?$upload_data[0]->quma_quotationdatead:'';
        $supplier_qdate = !empty($upload_data[0]->quma_supplierquotationdatead)?$upload_data[0]->quma_supplierquotationdatead:'';
        $expdate = !empty($upload_data[0]->quma_expdatead)?$upload_data[0]->quma_expdatead:'';
        $curdate = CURDATE_EN;
    }
?>

<form method="post" id="formReqUpload" action="<?php echo base_url('purchase_receive/req_upload/save_req_upload'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('purchase_receive/req_upload/form_req_upload'); ?>' enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo!empty($upload_data[0]->reum_reumid)?$upload_data[0]->reum_reumid:'';  ?>">

    <div class="form-group">
        <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?>
                <span class="required">*</span>:
            </label>
            <select name="fiscalyear" class="form-control select2" id="fiscalyear" >
                <option value="">---select---</option>
                    <?php
                        if($fiscal):
                            foreach ($fiscal as $km => $fy):
                    ?>
                <option value="<?php echo $fy->fiye_name; ?>" <?php if($fy->fiye_status=='I') echo "selected=selected"; ?>><?php echo $fy->fiye_name; ?></option>
                <?php
                        endforeach;
                    endif;
                ?>
            </select>
        </div>

        <div class="col-md-3 col-sm-4">
            <label for="example-text">
                <?php

                    // $upload_num = !empty($upload_no[0]->reqmax)?$upload_no[0]->reqmax+1:1;
                 $upload_num = !empty($upload_no)?$upload_no:1;
                ?>
                <?php echo !empty($this->lang->line('upload_no'))?$this->lang->line('upload_no'):'Upload No.'; ?>
                <span class="required">*</span>: 
            </label>
            <input type="text" name="reum_uploadno" class="form-control number enterinput required_field" placeholder="Enter Upload Number" value="<?php echo $upload_num;?>" id="reum_uploadno" readonly/>
            <span class="errmsg"></span>
        </div>

        <div class="col-md-3 col-sm-4">
            <label for="example-text">
                <?php echo !empty($this->lang->line('manual_no'))?$this->lang->line('manual_no'):'Manual No.'; ?> : 
            </label>
            <input type="text" name="reum_manualno" class="form-control number" placeholder="Enter Manual Number" value="" id="reum_manualno" />
            <span class="errmsg"></span>
        </div>

        <div class="col-md-3 col-sm-4">
            <label for="reum_validdate">
                <?php echo $this->lang->line('valid_till'); ?>
                <span class="required">*</span>:
            </label>
            <input type="text" name="reum_validdate" class="form-control required_field <?php echo DATEPICKER_CLASS; ?> date" placeholder="Valid Upto" id="reum_validdate" value="<?php echo !empty($valid_date)?$valid_date:$curdate; ?>" readonly="true">
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="form-group">
        <div class="col-md-3 col-sm-4">
            <label for="example-text">
                <?php echo $this->lang->line('upload_excel_file'); ?> : 
            </label>
            <div class="dis_tab">
                <input type="file" name="reum_excel" id="reum_excel" class="form-control" required accept=".xls, .xlsx">
            </div>
        </div>

        <div class="col-md-9 col-sm-4">
            <?php
                $remarks = !empty($upload_data[0]->reum_remarks)?$upload_data[0]->reum_remarks:'';
            ?>
            <label for="reum_remarks"><?php echo $this->lang->line('remarks'); ?>:</label>
            <input type="text" name="reum_remarks" class="form-control" placeholder="Remarks" id="reum_remarks" value="<?php echo $remarks;  ?>"  />
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="form-group">
        <div class="col-md-12">
            <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($upload_data)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($upload_data)?'Update':'Save' ?></button>
        </div>
        
        <div class="col-sm-12">
            <div  class="alert-success success"></div>
            <div class="alert-danger error"></div>
        </div>
    </div>
</form>

<div class="form-group">
    <div class="alert alert-danger"><strong>Note: </strong>The columns of excel file should be in following format.<br/>
        Description <strong>|</strong> Manufacturer <strong>|</strong> Qty <strong>|</strong> Size <strong>|</strong> Rate <strong>|</strong> Remarks

    </div>
</div>
<?php
    if($loadselect2=='yes'):
    ?>
<script type="text/javascript">
    $('.select2').select2();
</script>
<?php
    endif;
?>
<script type="text/javascript">
     $(document).off('change', '#fiscalyear');
     $(document).on('change', '#fiscalyear', function() {
         var fiscalyear = $(this).val();
         var submitdata = {
             fyear: fiscalyear
         };
         var submiturl = base_url + 'purchase_receive/req_upload/get_upload_no';

         ajaxPostSubmit(submiturl, submitdata, beforeSend, onSuccess);

         function beforeSend() {
         };

         function onSuccess(jsons) {
             data = jQuery.parseJSON(jsons);

             setTimeout(function() {
                 $('#reum_uploadno').empty().val(data.upload_no);
             }, 1000);

         }
     });
</script>