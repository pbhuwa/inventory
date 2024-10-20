<div class="row">
  <div class="form-group">
    <div class="col-md-3 col-sm-6 col-xs-6">
      <label for="example-text">Department <span class="required">*</span>:</label>

      <?php 
      $bmin_departmentid=!empty($equip_data[0]->bmin_departmentid)?$equip_data[0]->bmin_departmentid:'';
      // echo $deptype;
      // die();
      ?>

      <select name="eqdc_newdepid" class="form-control select2" id="departwithequip">
        <option value="">---select---</option>

        <?php if($dep_information):
        foreach ($dep_information as $kdi => $depin):?>

        <option value="<?php echo $depin->dept_depid; ?>" <?php if($bmin_departmentid==$depin->dept_depid) echo 'selected=selected'; ?>><?php echo $depin->dept_depname; ?></option>

        <?php endforeach; endif; ?>
      </select>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-6">
      <label for="example-text">Room:</label>
      <select name="eqdc_newroomid" class="form-control select2" id="bmin_roomid">
        <option value="">---select---</option>
      </select>
    </div>

    <div class="col-md-2">
    </div>
    <div class="clearfix"></div>
  </div>

</div>
<div class="form-group" id="equipment_list">

</div>
