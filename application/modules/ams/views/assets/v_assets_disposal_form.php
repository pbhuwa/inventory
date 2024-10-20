 <div class="assest-form">
     <form method="post" id="FormsalesDesposal" action="<?php echo base_url('ams/assets_sales_desposal/save_sales_desposal'); ?>" class="form-material form-horizontal form" data-reloadurl="<?php echo base_url('ams/assets_sales_desposal/entry/reload'); ?>">
    <div class="white-box pad-5 assets-title" style="border-color:silver">
        <h4>Disposal Information</h4>
            <input type="hidden" name="id" value="<?php echo !empty($assets_data[0]->asen_asenid)?$assets_data[0]->asen_asenid:''; ?>" />

            <div class="row">
                   <div class="col-md-3">
                <?php $disposalno=!empty($sales_desposal_data_rec[0]->asde_disposalno)?$sales_desposal_data_rec[0]->asde_disposalno:$disposal_code; ?>
                <label for="example-text">Disposal No. <span class="required">*</span>:</label>
                <input type="text" class="form-control required_field" name="asde_disposalno" id="asde_disposalno" value="<?php echo $disposalno; ?>" readonly />
            </div>

            <div class="col-md-3">
                <?php $asde_manualno=!empty($sales_desposal_data_rec[0]->asde_manualno)?$sales_desposal_data_rec[0]->asde_manualno:0; ?>
                <label for="example-text"><?php echo $this->lang->line('manual_no'); ?>  :</label>
                <input type="text" class="form-control" name="asde_manualno" value="<?php echo $asde_manualno; ?>" placeholder="Enter Manual Number">
            </div>

            
            <div class="col-md-3">
                 <?php
                    if(DEFAULT_DATEPICKER == 'NP'){
                        $disposal_date = !empty($sales_desposal_data_rec[0]->asde_desposaldatebs)?$sales_desposal_data_rec[0]->asde_desposaldatebs:DISPLAY_DATE;
                    }else{
                        $disposal_date = !empty($sales_desposal_data_rec[0]->asde_desposaldatead)?$sales_desposal_data_rec[0]->asde_desposaldatead:DISPLAY_DATE;
                    }
                ?>
               
                <label for="example-text">Disposal Date :</label>
                <input type="text" class="form-control" name="asde_desposaldate" value="<?php echo $disposal_date; ?>" placeholder="YYYY/MM/DD">
            </div>
            <div class="col-md-3 col-sm-4">
                 <label for="example-text">Disposal Type <span class="required">*</span>:</label>
                 <?php $detyid=!empty($sales_desposal_data_rec[0]->asde_desposaltypeid)?$sales_desposal_data_rec[0]->asde_desposaltypeid:''; ?>
                  <select name="asde_desposaltypeid" class="form-control required_field" id="disposaltypeid">
                      <option value="0">---Select---</option>
           <?php
             if(!empty($desposaltype)): 
             foreach ($desposaltype as $kdt => $dtype):
             ?>
           
            <option value="<?php echo $dtype->dety_detyid; ?>" <?php if($dtype->dety_detyid==$detyid) echo "selected=selected"; ?> data-issales="<?php echo $dtype->dety_issale; ?>" ><?php echo $dtype->dety_name; ?></option>
         <?php endforeach; endif; ?>
       </select>
            </div>
    <div class="col-md-3 col-sm-4">
           
            <label for="example-text">Customer Name :</label>
            <input type="text" name="asde_customer_name" class="form-control" value="<?php echo $cust_name; ?>">
    </div>
      <div class="col-md-3 col-sm-4">
            
            <label for="example-text">Sales Tax (%) :</label>
            <input type="text" name="asde_sale_taxper" class="form-control float" value="<?php echo $sale_tax; ?>">
    </div>
    <div class="col-md-3 col-sm-4">
            
            <label for="example-text">Original Cost:</label>
            <input type="text" name="asdd_originalvalue" class="form-control float" value="">
    </div>

     <div class="col-md-3 col-sm-4">
           
            <label for="example-text">Current Cost:</label>
            <input type="text" name="asdd_currentvalue" class="form-control float" value="">
    </div>
     <div class="col-md-3 col-sm-4">
            
            <label for="example-text">  Last Dep. Date:</label>
            <input type="text" name="asdd_lastdepriciationdatebs" class="form-control float" value="">
    </div>
     <div class="col-md-3 col-sm-4">
            
            <label for="example-text">Sales Cost:</label>
            <input type="text" name="asdd_sales_amount" class="form-control float" value="">
    </div>
   

                <div class="col-md-12">
                   
                        <label><?php echo $this->lang->line('remarks'); ?></label>
                        <textarea class="form-control" name="asde_remarks" ></textarea>
                    
                </div>
               

            
            </div>

 
     </div>
      <div class="form-group">
            <div class="col-md-12">
                <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($sales_desposal_data_rec)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($sales_desposal_data_rec)?'Update':$this->lang->line('save');  ?></button>
              
            </div>
            <div class="col-sm-12">
                <div  class="alert-success success"></div>
                <div class="alert-danger error"></div>
            </div>
        </div>
 </form>
</div>

<script type="text/javascript">
    $('#locationid').addClass('required_field');
</script>