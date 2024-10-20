<form method="post" id="FormDepartment" action="<?php echo base_url('settings/department/save_department'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('settings/department/form_department'); ?>'>
  <input type="hidden" name="id" value="<?php echo !empty($dept_data[0]->dept_depid) ? $dept_data[0]->dept_depid : '';  ?>">
  <div class="form-group resp_xs">
    <?php
    $db_location = !empty($dept_data[0]->dept_locationid) ? $dept_data[0]->dept_locationid : '';
    $sel_locationid = !empty($db_location) ? $db_location : $current_location;

    if ($location_ismain == 'Y') : ?>
      <div class="col-sm-12 col-xs-6">
        <label><?php echo $this->lang->line('location'); ?></label>
        <select class="form-control select2" name="dept_locationid" id="locationid">
          <?php
          if ($location_all) :
            foreach ($location_all as $km => $loca) :
          ?>
              <option value="<?php echo $loca->loca_locationid; ?>" <?php if ($sel_locationid == $loca->loca_locationid) echo "selected=selected"; ?>>
                <?php echo $loca->loca_name ?>
              </option>
          <?php
            endforeach;
          endif;
          ?>
        </select>
      </div>
    <?php endif; ?>
     <div class="col-sm-12 col-xs-6">

      <?php

      $parentdepid = !empty($parent_depid) ? $parent_depid : '';

      if (!empty($parentdepid)) {

        $depid = $parentdepid;
      } else {

        $depid = !empty($dept_data[0]->dept_parentdepid) ? $dept_data[0]->dept_parentdepid : '';
      }

      ?>

      <label for="example-text">Department:</label>

      <div class="dis_tab">

        <select name="dept_parentdepid" id="rema_reqfromdepid" class="form-control ">

          <option value="">--select--</option>

          <?php if (!empty($department_all)) :

            foreach ($department_all as $kd => $dep) :

          ?>

              <option value="<?php echo $dep->dept_depid ?>" <?php if ($depid == $dep->dept_depid) echo "selected=selected"; ?>><?php echo $dep->dept_depname ?></option>



          <?php endforeach;
          endif; ?>

        </select>

      </div>

    </div>

    <?php

    $subdepid = !empty($dept_data[0]->dept_subparentdeptid) ? $dept_data[0]->dept_subparentdeptid : '';

    if (!empty($sub_department)) :

      $displayblock = 'display:block';

    else :

      $displayblock = 'display:none';

    endif;

    ?>

    <div class="col-sm-12 col-xs-6" id="subdepdiv" style="<?php echo $displayblock; ?>">

      <label for="example-text">Sub Department:</label>

      <select name="dept_subparentdepid" id="rema_subdepid" class="form-control">

        <?php if (!empty($sub_department)) : ?>

          <option value="">--select--</option>

          <?php foreach ($sub_department as $ksd => $sdep) :

          ?>

            <option value="<?php echo $sdep->dept_depid; ?>" <?php if ($sdep->dept_depid == $subdepid) echo "selected=selected"; ?>><?php echo $sdep->dept_depname; ?></option>

        <?php endforeach;
        endif; ?>

      </select>

    </div>

  </div>
    <div class="col-sm-12 col-xs-6">
      <label for="example-text"><?php echo $this->lang->line('department_code'); ?><span class="required">*</span>:
      </label>

      <input type="text" id="dept_depcode" name="dept_depcode" class="form-control" placeholder="Department Code" value="<?php echo !empty($dept_data[0]->dept_depcode) ? $dept_data[0]->dept_depcode : ''; ?>" autofocus >

    </div>
    <div class="col-sm-12 col-xs-6">
      <label for="example-text"><?php echo $this->lang->line('department_name'); ?> <span class="required">*</span>:
      </label>
      <input type="text" id="dept_depname" name="dept_depname" class="form-control" placeholder="Department Name" value="<?php echo !empty($dept_data[0]->dept_depname) ? $dept_data[0]->dept_depname : ''; ?>">

    </div>
   
  <?php
  $add_edit_status = !empty($edit_status) ? $edit_status : 0;
  $usergroup = $this->session->userdata(USER_GROUPCODE);
  // echo $add_edit_status;
  if ((empty($dept_data)) || (!empty($dept_data) && ($add_edit_status == 1 || $usergroup == 'SA'))) : ?>

    <?php
    $save_var = $this->lang->line('save');
    $update_var = $this->lang->line('update');
    ?>
    <?php
    if (!empty($modal) && $modal == 'modal') :
      $saveclass = 'savelist';
    else :
      $saveclass = 'save';
    endif;
    ?>
    <button type="submit" class="btn btn-info  <?php echo $saveclass; ?>" data-operation='<?php echo !empty($dept_data) ? 'update' : 'save' ?>' id="btnDeptment"><?php echo !empty($dept_data) ? $update_var : $save_var ?></button>
  <?php
  endif; ?>

  <!-- <button type="reset" class="btn btn-danger" id="resr">Reset</button> -->
  

  <div class="alert-success success"></div>
  <div class="alert-danger error"></div>


</form>
<script type="text/javascript">
  $(document).off('change', '#locationid');

  $(document).on('change', '#locationid', function(e) {

    var schoolid = $(this).val();

    var submitdata = {
      schoolid: schoolid
    };

    var submiturl = base_url + 'issue_consumption/stock_requisition/get_department_by_schoolid';

    // aletr(schoolid);

    $('#rema_reqfromdepid').html('');

    ajaxPostSubmit(submiturl, submitdata, beforeSend, onSuccess);

    function beforeSend() {};

    function onSuccess(jsons) {

      data = jQuery.parseJSON(jsons);

      if (data.status == 'success') {

        $('#subdepdiv').hide();

        $('#rema_reqfromdepid').html(data.dept_list);

      } else {

        $('#rema_reqfromdepid').html();

        $("#rema_reqfromdepid").select2("val", "");

        $("#rema_subdepid").select2("val", "");
      }
    }
  });
 
  //   $("#resr").click(function(){
  //     $("#resr").animate({
  //   left: '250px',
  //   // opacity: '0',
  //   height: '150px',
  //   width: '150px'
  // });
  //   });
  // 
  // $(document).off('change', '#rema_reqfromdepid');

  // $(document).on('change', '#rema_reqfromdepid', function(e) {

  //   var schoolid = $(this).val();

  //   var submitdata = {
  //     schoolid: schoolid
  //   };

  //   var submiturl = base_url + 'issue_consumption/stock_requisition/get_department_by_schoolid';

  //   // aletr(schoolid);

  //   $("#rema_subdepid").select2("val", "");

  //   $('#rema_subdepid').html('');

  //   ajaxPostSubmit(submiturl, submitdata, beforeSend, onSuccess);

  //   function beforeSend() {

  //   };

  //   function onSuccess(jsons) {

  //     data = jQuery.parseJSON(jsons);

  //     if (data.status == 'success') {

  //       $('#subdepdiv').show();

  //       $('#rema_subdepid').html(data.dept_list);

  //     } else {

  //       $('#subdepdiv').hide();

  //       $('#rema_subdepid').html();

  //     }

  //   }
  // });
</script>