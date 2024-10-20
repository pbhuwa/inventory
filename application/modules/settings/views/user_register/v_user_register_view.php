<div class="white-box distributordata">
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
</div>
<div class="clearfix"></div>
<br><?php
if($check_name==false):
  ?>
  <div class="list_c2 label_mw125">
  <form id="FormChangeStatus" action="<?php echo base_url('settings/user_register/change_status_user');?>" method="POST">
    <input type="hidden" name="userid" value="<?php echo !empty($registr_data[0]->usre_userid)?$registr_data[0]->usre_userid:'';  ?>">
    <div class="form-group">
      <div class="col-ms-12">
        <div class="row">
         <div class="col-sm-12">
          <?php $status= !empty($registr_data[0]->usre_status)?$registr_data[0]->usre_status:'';
          if ($status!=2  ) { ?>
           <div class="col-sm-12">
            <label for="example-text"><?php echo $this->lang->line('canceled'); ?>  : </label>
            <input type="radio" class="mbtm_13 cancel" name="user_status"  value="2" id="cancel">
          </div>
        <?php } ?>
        <?php 
        if ($status!=1 && $status!=2 ) { ?>
         <div class="col-sm-12">
          <label for="example-text"><?php echo $this->lang->line('approved'); ?>  : </label>
          <input type="radio" class="mbtm_13 cancel" name="user_status"  value="1">
        </div>
      <?php  } ?>
      <?php 
      if ($status==2) { ?>
        <div class="col-sm-12">
          <label for="example-text">Uncancel: </label>
          <input type="radio" class="mbtm_13 cancel" name="user_status"  value="0">
        </div>

      <?php  } ?> 
      <div class="col-sm-12 showApproved" id="approvedid">
       <div class="col-md-4" >
         <label><?php echo $this->lang->line('user_group'); ?> <span class="required">*</span>:</label>
         <select class="form-control select2" name="usre_usergroupid">
           <option value="">---Select---</option>
           <?php 
           if(!empty($group_all)):
            foreach ($group_all as $kd => $group):
              ?>
              <option value="<?php echo $group->usgr_usergroupid; ?>" ><?php echo $group->usgr_usergroup; ?></option>
              <?php
            endforeach;
          endif;
          ?>
        </select>
      </div>
      <div class="col-md-8" >
       <label>Select Approval:</label>
       <?php 
       $desiid=!empty($user_data[0]->usma_desiid)?$user_data[0]->usma_desiid:''; 
       $designationid=explode(',',$desiid );
       ?>
       <select class="form-control select2 custom_select2" name="usre_appdesiid[]"   multiple="multiple" style="height: auto;width: 100%;">
        <?php 
        if($designation):
          foreach ($designation as $kd => $desi):
            ?>
            <option value="<?php echo $desi->desi_designationid; ?>" <?php if(in_array($desi->desi_designationid,$designationid) )echo "selected=selected"; ?>><?php echo $desi->desi_designationname; ?></option>
            <?php
          endforeach;
        endif;
        ?>
      </select>
    </div>
  </div>
</div>

</div>
<div class="col-md-12">
  <button type="submit" class="btn btn-info  savelist" data-operation="save" id="btnDeptment" data-isdismiss="Y" data-isrefresh="Y" data-isuserregister="Y"><?php echo $this->lang->line('save'); ?></button>
</div>
<div class="col-sm-12">
  <div  class="alert-success success"></div>
  <div class="alert-danger error"></div>
</div>
</div>
</div>
</form>
</div>
  
<?php endif;?>

<style>
  .showApproved { display: none;}
</style>
<script> 
  $(document).off('click','.cancel');
  $(document).on('click','.cancel',function(){
    var status = $('form input[type=radio]:checked').val();

    if(status == '1')
    {
      $('.showApproved').show();
    }else{
      $('.showApproved').hide();  
    }
  })
</script>
<script type="text/javascript">
  $('.select2').select2();
</script>