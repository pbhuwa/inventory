<style type="text/css">
  table.table-sm thead tr th, table.table-sm tbody tr td{
    font-size: 12px;
    padding: 5px !important
  }
</style>
<div class="assest-form">
   <form id="Project_Bill_Setup" class="form-material form-horizontal form" method="post"  action="<?php echo base_url('ams/project_setup/save_project_bill'); ?>" data-reloadurl='<?php echo base_url('ams/project_setup/project_bill_entry/reload'); ?>' enctype="multipart/form-data"  accept-charset="utf-8" >
      <div class="white-box pad-5 assets-title" style="border-color:silver">
         
         <input type="hidden" name="id" value="<?php echo !empty($project_bill_data[0]->prbl_prblid)?$project_bill_data[0]->prbl_prblid:''; ?>" />
         <input type="hidden" name="prbl_projectid" value="<?php echo !empty($project_id)?$project_id:''; ?>" />
         <div class="row">
            
            
            
            
            <div class="col-md-3">
               <?php
                  if(DEFAULT_DATEPICKER == 'NP'){
                      $prbl_billdate = !empty($project_bill_data[0]->prbl_billdatebs)?$project_bill_data[0]->prbl_billdatebs:DISPLAY_DATE;
                  }else{
                      $prbl_billdate = !empty($project_bill_data[0]->prbl_billdatead)?$project_bill_data[0]->prbl_billdatead:DISPLAY_DATE;
                  }
                  ?>
               <label>Bill Date:</label>
               <input type="text" name="prbl_billdate" class="form-control <?php echo DATEPICKER_CLASS;?> date" placeholder="Bill Date" id="prbl_billdate" value="">
            </div>
            <div class="col-md-8">

           
               <label>Attachement:</label>
               <table>
                  <tbody id="pmAttachment">
                     <tr>
                        <td><input type="file" name="prbl_attachment" class="form-control"></td>
                        <td></td>
                     </tr>
                  </tbody>
                  <tfoot>
                     <tr>
                        <td></td>
                        <td><a href="javascript:void(0)" class="btn btn-sm btn-primary btnattestAttachment"><i class="fa fa-plus" aria-hidden="true"></i></a></td>
                     </tr>
                  </tfoot>
               </table>
            </div>

            <div class="col-md-4">
               <label>Amount: </label>
               <input type="text" name="prbl_amount"  class="form-control required_field" id="prbl_amount" placeholder="Project Bill Amount" value=""  >
            </div>
            <div class="col-md-4">
              <label>Remarks: </label>
               <textarea class="form-control" name="prbl_remarks" value=""></textarea>
                    
            </div>
           
        <div class="clearfix"></div>
         <button type="submit" class="btn btn-info  save" id="btnSubmitEntry" data-operation='save' ><?php echo !empty($project_bill_data)?'Update & New':'Save'; ?></button>
        <button type="submit" class="btn btn-info  savelist"  id="btnSubmitEntryClose" data-operation='save' data-isdismiss='Y'> Save & close</button>
      </div>
      <div class="alert-success success"></div>
      <div class="alert-danger error"></div>
</div>
</form>
<?php
if(!empty($project_bill_data)): ?>

<table class="table table-sm table-bordered w-100">
  <thead>
    <th>S.N</th>
    <th>Bill Date</th>
    <th>Bill Amt</th>
    <th>Remarks</th>
    <th>Attachment</th>
  </thead>
  <tbody>
    <?php 
        if (!empty($project_bill_data)):
          foreach ($project_bill_data as $key => $project_bill): ?>
    <tr>
      <td><?php echo $key+1; ?></td>
      <td><?php echo !empty($project_bill->prbl_billdatebs)?$project_bill->prbl_billdatebs:''; ?></td>
      <td><?php echo !empty($project_bill->prbl_amount)?$project_bill->prbl_amount:''; ?></td>
      <td><?php echo !empty($project_bill->prbl_remarks)?$project_bill->prbl_remarks:''; ?></td>
      <td><img  src="<?php echo base_url(PROJECT_BILL_ATTACHMENT_PATH.'/'.$project_bill->prbl_attachment); ?>"></td>
    </tr>
    <?php 
      endforeach;
    endif; ?>
  </tbody>
  </tbody>
  </table>
<?php endif; ?>
</div>

<script type="text/javascript">
   $('.engdatepicker').datepicker({
       format: 'yyyy/mm/dd',
       autoclose: true
   });
   $('.nepdatepicker').nepaliDatePicker();
</script>