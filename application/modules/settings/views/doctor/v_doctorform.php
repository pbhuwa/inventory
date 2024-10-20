
<form method="post" id="FormDoctor" action="<?php echo base_url('settings/doctor/save_doctor'); ?>" class="form-material form-horizontal form">
<input type="hidden" name="id" value="<?php echo!empty($doc_data[0]->dose_docid)?$doc_data[0]->dose_docid:'';  ?>">
<div class="form-group">
<div class="col-md-4">
 <label for="example-text">Doctor Code:</label>
  <input type="text"  name="dose_doccode" class="form-control" placeholder="Doctor Code" value="<?php echo !empty($doc_data[0]->dose_doccode)?$doc_data[0]->dose_doccode:''; ?>">
</div>
<div class="col-md-4">
<div class="col-md-6">
<label>Designation :</label>
     <input type=text""  name="dose_desig" class="form-control" placeholder="Designation " value="<?php echo !empty($doc_data[0]->dose_desig)?$doc_data[0]->dose_desig:''; ?>">
</div>
<div class="col-md-6">
  <label>NMC No :</label>
     <input type="text"  name="dose_nmcno" class="form-control" placeholder="NMC No " value="<?php echo !empty($doc_data[0]->dose_nmcno)?$doc_data[0]->dose_nmcno:''; ?>">
</div>
</div>

<div class="col-md-4">
 <label for="example-text">Doctor Name:
    </label>
     <input type="text"  name="dose_docname" class="form-control" placeholder="Doctor Name" value="<?php echo !empty($doc_data[0]->dose_docname)?$doc_data[0]->dose_docname:''; ?>" >

</div>

</div>

<div class="form-group">
<div class="col-md-4">
 <label for="example-text">Qualification:
    </label>
    
     <input type="text"  name="dose_qualification" class="form-control" placeholder="Qualification" value="<?php echo !empty($doc_data[0]->dose_qualification)?$doc_data[0]->dose_qualification:''; ?>">
  </div>
<div class="col-md-4">
 <label for="example-text">Specilization :
    </label>
  <input type="text"  name="dose_specialization" class="form-control" placeholder="Specialization" value="<?php echo !empty($doc_data[0]->dose_specialization)?$doc_data[0]->dose_specialization:''; ?>">
</div>

<div class="col-md-4">
 <label>Phone No:</label>
<input type="text"  name="dose_phoneno" class="form-control" placeholder="Phone No" value="<?php echo !empty($doc_data[0]->dose_phoneno)?$doc_data[0]->dose_phoneno:''; ?>">
 </div>
 </div>

 <div class="clearfix"></div>
 <div class="form-group">
<div class="col-md-4">
 <label>Mobile No:</label>
<input type="text"  name="dose_mobileno" class="form-control" placeholder="9XXXXXXXXX" value="<?php echo !empty($doc_data[0]->dose_mobileno)?$doc_data[0]->dose_mobileno:''; ?>">
</div>

<div class="col-md-4">
<label>Department:</label>
<select name="" class="form-control">
<?php 
// echo "<pre>";
// print_r($department_all);
// die();
if($department_all):
foreach ($department_all as $kd => $dep) {
?>
<option value="<?php echo $dep->dept_depid; ?>"><?php echo $dep->dept_depname; ?></option>
<?php
}
endif;
 ?>

  
</select>
</div>

<div class="col-md-4">
<label>Display Order:</label>
<input type="text"  name="dose_docorder" class="form-control" placeholder="Display Order" value="<?php echo !empty($doc_data[0]->dose_docorder)?$doc_data[0]->dose_docorder:''; ?>">
</div>
</div>
<div class="clearfix"></div>
 <div class="form-group">
<div class="col-md-4">
<input type="checkbox" name="dose_isactive" value="Y">Is Active
<input type="checkbox" name="dose_isnohospitaldoc" value="Y">None Hospital Doctor

</div>
<div class="col-md-4">
<input type="radio" name="dose_doctortype" value="Consultant">Is Consultant
<input type="radio" name="dose_doctortype" value="Duty">Is Duty 
<input type="radio" name="dose_doctortype" value="None">None 
</div>

<div class="col-md-4">
<input type="checkbox" name="dose_issurgeon" value="Y">Is Surgeon
<input type="checkbox" name="dose_isanesthetist" value="Y">Is Anesthetist
<input type="checkbox" name="dose_isassistant" value="Y">Is Assistant
</div>
</div>
<div class="clearfix"></div>
 <?php 
        $add_edit_status=!empty($edit_status)?$edit_status:0;
        $usergroup=$this->session->userdata(USER_GROUPCODE);
        // echo $add_edit_status;
        if((empty($doc_data)) || (!empty($doc_data) && ($add_edit_status==1 || $usergroup=='SA') )): ?>
        <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($doc_data)?'update':'save' ?>' id="btnDeptment" ><?php echo !empty($doc_data)?'Update':'Save' ?></button>
          <?php
           endif; ?>     
    <div  class="waves-effect waves-light m-r-10 text-success success"></div>
    <div class="waves-effect waves-light m-r-10 text-danger error"></div>

      
</form>

