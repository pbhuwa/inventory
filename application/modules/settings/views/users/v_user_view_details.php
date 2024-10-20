<div class="white-box distributordata">
  <div class="pad-5">
    <div class="form-group row resp_xs">
      <div class="col-md-6 col-sm-6 col-xs-6">
        <label for="example-text">User Name</label>:
         <?php echo !empty($user_data[0]->usma_username)?$user_data[0]->usma_username:'' ?>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-6">
        <label for="example-text">User Email</label>:
         <?php echo !empty($user_data[0]->usma_email)?$user_data[0]->usma_email:'' ?>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-6">
        <label for="example-text">Full name</label>:
         <?php echo !empty($user_data[0]->usma_fullname)?$user_data[0]->usma_fullname:'' ?>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-6">
        <label for="example-text">Phone No</label>:
         <?php echo !empty($user_data[0]->usma_phoneno)?$user_data[0]->usma_phoneno:'' ?>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-6">
        <label for="example-text">Post Date(AD)</label>:
         <?php echo !empty($user_data[0]->usma_postdatead)?$user_data[0]->usma_postdatead:'' ?>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-6">
        <label for="example-text">Post Date(BS)</label>:
         <?php echo !empty($user_data[0]->usma_postdatebs)?$user_data[0]->usma_postdatebs:'' ?>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-6">
        <label for="example-text">Department</label>:
         <?php echo !empty($departmentname)?$departmentname:'' ?>
      </div>
     
      <div class="col-md-6 col-sm-6 col-xs-6">
        <label for="example-text">Designation</label>:
        <?php echo !empty($user_data[0]->desi_designationname)?$user_data[0]->desi_designationname:'' ?>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-6">
        <label for="example-text">Uroup</label>:
        <?php echo !empty($user_data[0]->usgr_usergroup)?$user_data[0]->usgr_usergroup:'' ?>
      </div>

    </div>
  </div>
  <div class="clearfix"></div>
</div>


