<?php 
$userwise_dep=!empty($user_dep)?$user_dep:array();
$userwise_group=!empty($user_group)?$user_group:array();
$udepArray=array();
$ugroupArray=array();
if(!empty($userwise_dep))
{
    foreach ($userwise_dep as $rs => $val) {
          $udepArray[]=$val->uwde_depid;
        }
} 

if(!empty($userwise_group))
{
    foreach ($userwise_group as $rs => $val) {
          $ugroupArray[]=$val->uwgr_groupid;
        }
}


?>
<form method="post" id="FormUsers" action="<?php echo base_url('settings/users/save_users'); ?>" class="form-material form-horizontal form">
<input type="hidden" name="id" value="<?php echo!empty($user_data[0]->usma_userid)?$user_data[0]->usma_userid:'';  ?>">
<div class="form-group">
<div class="col-md-4">
 <label for="example-text">Username:
    </label>
    
       <input type="text" id="example-text" name="usma_username" class="form-control" placeholder="Username" value="<?php echo !empty($user_data[0]->usma_username)?$user_data[0]->usma_username:''; ?>">

</div>
<div class="col-md-4">
 <label for="example-text">Password :
    </label>
     <input type="password" id="example-text" name="usma_userpassword" class="form-control" placeholder="Password " value="<?php echo !empty($user_data[0]->usma_userpassword)?$user_data[0]->usma_userpassword:''; ?>">

</div>

<div class="col-md-4">
 <label for="example-text">Conform Password :
    </label>
     <input type="password" id="example-text" name="usma_conformpassword" class="form-control" placeholder="Conform Password" value="<?php echo !empty($user_data[0]->usma_userpassword)?$user_data[0]->usma_userpassword:''; ?>" >

</div>

</div>

<div class="form-group">
<div class="col-md-4">
 <label for="example-text">Full Name:
    </label>
    
     <input type="text" id="example-text" name="usma_fullname" class="form-control" placeholder="Full Name" value="<?php echo !empty($user_data[0]->usma_fullname)?$user_data[0]->usma_fullname:''; ?>">
  </div>
<div class="col-md-4">
 <label for="example-text">Users :
    </label><br>
   <input type="radio" name="usma_usertype" value="Doctor" class="usertype">Doctor
   <input type="radio" name="usma_usertype" value="Nurse" class="usertype">Nurse
   <input type="radio" name="usma_usertype" value="Others" checked="checked" class="usertype">Others
   
</div>

<div class="col-md-4">
<div id="doctorDiv" style="display: none">
 <label>Doctor:</label>
 <select name="usma_doctorid" class="form-control">
    
 </select>
 </div>
 
 <div id="nurseDiv" style="display: none">
 <label>Nurse:</label>
 <select name="usma_doctorid" class="form-control">
    
 </select>

 </div>

</div>
</div>

<div class="form-group">
<div class="col-md-12">
    <label>Department</label><br>
<?php if($department_all):
foreach ($department_all as $kd => $dep):
?>
<div class="col-md-3">
<input type="checkbox" name="usma_staffdepartmentid[] " value="<?php echo $dep->dept_depid; ?>" <?php if(in_array($dep->dept_depid, $udepArray)) echo "checked=checked"; ?> ><?php echo $dep->dept_depname; ?>
</div>
<?php
endforeach;
endif;
 ?>
</div>

</div>

   <div class="form-group">
<div class="col-md-12">
    <label>User Group</label><br>
     <?php if($group_all):
foreach ($group_all as $kd => $group):
?>
<div class="col-md-3">
<input type="checkbox" name="usma_usergroupid[] " value="<?php echo $group->usgr_usergroupid; ?>" <?php if(in_array($group->usgr_usergroupid, $ugroupArray)) echo "checked=checked"; ?>><?php echo $group->usgr_usergroup; ?>
</div>
<?php
endforeach;
endif;
 ?>

    </div>
</div>
 <div class="form-group">
  <div class="col-md-4">
  <label>Is Active</label><br>
   <input type="checkbox" name="usma_isactive" value="1">
  </div>

   <div class="col-md-4">
   <label>Exp-Date</label>
   <?php 
   if(DEFAULT_DATEPICKER=='NP'){
      $curDate=CURDATE_NP;
     $db_expdate=!empty($user_data[0]->usma_expdatebs)?$user_data[0]->usma_expdatebs:'';
   } 
   else{
    $curDate=CURDATE_EN;
    $db_expdate=!empty($user_data[0]->usma_expdatead)?$user_data[0]->usma_expdatead:'';
   }
  ?>
   <input type="text" id="example-text" name="usma_expdatead" class="form-control" placeholder="Expiry Date" value="<?php echo !empty($db_expdate)?$db_expdate:$curDate; ?>">
   </div>

 </div>

        <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 save"><?php echo !empty($user_data)?'Update':'Save' ?></button>
                             
        <div  class="waves-effect waves-light m-r-10 text-success success"></div>
        <div class="waves-effect waves-light m-r-10 text-danger error"></div>

</form>

