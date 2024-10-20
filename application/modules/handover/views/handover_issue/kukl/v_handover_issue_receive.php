<!-- <div class="white-box distributordata">
  <div class="pad-5">
    <div class="form-group row resp_xs">
      <div class="col-md-6 col-sm-6 col-xs-6">
        <label for="example-text">User Name</label>:
         <?php echo !empty($registr_data[0]->usre_username)?$registr_data[0]->usre_username:'' ?>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-6">
        <label for="example-text">User Email</label>:
         <?php echo !empty($registr_data[0]->usre_email)?$registr_data[0]->usre_email:'' ?>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-6">
        <label for="example-text">Full name</label>:
         <?php echo !empty($registr_data[0]->usre_fullname)?$registr_data[0]->usre_fullname:'' ?>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-6">
        <label for="example-text">Phone No</label>:
         <?php echo !empty($registr_data[0]->usre_phoneno)?$registr_data[0]->usre_phoneno:'' ?>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-6">
        <label for="example-text">Post Date(AD)</label>:
         <?php echo !empty($registr_data[0]->usre_postdatead)?$registr_data[0]->usre_postdatead:'' ?>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-6">
        <label for="example-text">Post Date(BS)</label>:
         <?php echo !empty($registr_data[0]->usre_postdatebs)?$registr_data[0]->usre_postdatebs:'' ?>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-6">
        <label for="example-text">Department</label>:
         <?php echo !empty($registr_data[0]->desi_designationname)?$registr_data[0]->desi_designationname:'' ?>
      </div>
     
      <div class="col-md-6 col-sm-6 col-xs-6">
        <label for="example-text">Designation</label>:
        <?php echo !empty($registr_data[0]->desi_designationname)?$registr_data[0]->desi_designationname:'' ?>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-6">
        <label for="example-text">Approved Designation</label>:
        <?php echo !empty($registr_data[0]->desi_designationname)?$registr_data[0]->desi_designationname:'' ?>
      </div>

    </div>
  </div>
  <div class="clearfix"></div>
</div> -->
<div class="clearfix"></div>
<br>
  <div class="list_c2 label_mw125">
  <form id="Formhandoverreceived" action="<?php echo base_url('handover/handover_issue/handover_received_save');?>" method="POST">
    <input type="hidden" name="handoverid" value="<?php echo !empty($handover_issue_details[0]->haov_handovermasterid)?$handover_issue_details[0]->haov_handovermasterid:'';  ?>">
    <div class="form-group">
      <div class="col-ms-12">
        <div class="row">
        
      <?php echo $this->general->location_option(2,'locationid'); ?>    
    
    <div class="col-sm-2">
          <label for="example-text">Receiver Name: </label>
          <input type="text"  name="haov_receivedby"  value="">
      </div>
     
  </div>
</div>

</div>
<div class="col-md-12">
  <button type="submit" class="btn btn-info  savelist" data-operation="save" id="btnDeptment" data-isdismiss="Y" data-isrefresh="Y" data-isuserregister="Y">Received</button>
</div>
<div class="col-sm-12">
  <div  class="alert-success success"></div>
  <div class="alert-danger error"></div>
</div>
</div>
</div>
</form>
</div>
