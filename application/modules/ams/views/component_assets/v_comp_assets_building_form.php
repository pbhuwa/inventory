  <?php
  if(DEFAULT_DATEPICKER == 'NP'){
      $manufacture_date = !empty($assets_data[0]->asen_manufacture_datebs)?$assets_data[0]->asen_manufacture_datebs:DISPLAY_DATE;
      $inservicedate = !empty($assets_data[0]->asen_inservicedatebs)?$assets_data[0]->asen_inservicedatebs:DISPLAY_DATE;
     


  }else{
      $manufacture_date = !empty($assets_data[0]->asen_manufacture_datead)?$assets_data[0]->asen_manufacture_datead:DISPLAY_DATE;
      $inservicedate = !empty($assets_data[0]->asen_inservicedatead)?$assets_data[0]->asen_inservicedatead:DISPLAY_DATE;
     
  }
  ?>

<div class="row">
                  <div class="col-md-3">
                  
                        <label>Asset ID<span class="required"></span>: </label>
                        <input type="text" class="form-control" name="asen_assetcode" value="<?php echo !empty($assets_data[0]->asen_assetcode)?$assets_data[0]->asen_assetcode:$asset_code; ?>">
                    </div>
                     <div class="col-md-3">
                  
                        <label>Location (Facility Code)<span class="required"></span>: </label>
                        <input type="text" class="form-control" name="asen_faccode" value="<?php echo !empty($assets_data[0]->asen_faccode)?$assets_data[0]->asen_faccode:$faccode; ?>">
                    </div>

                   <div class="col-md-3">
                  
                        <label>Building ID<span class="required"></span>: </label>
                         <input type="text" class="form-control" name="asen_ncomponentid" value="<?php echo  !empty($assets_data[0]->asen_ncomponentid)?$assets_data[0]->asen_ncomponentid:$ncomponent_code; ?>">
                    </div>
                     <div class="col-md-3">
                  
                        <label>Buliding Type<span class="required"></span>: </label>
                      <select class="form-control" name="asen_buildingtype" >
                        <option>--select--</option>
                         <?php 
                            if(!empty($buildingtype_list)): 
                            foreach ($buildingtype_list as $kbt => $btype):
                          ?>
                          <option value="<?php echo $btype->buty_butyid  ?>"><?php echo $btype->buty_name; ?></option>
                         <?php endforeach; endif; ?>
                      </select>
                    </div>

                    <div class="col-md-3">
                        <label>No. of Floor<span class="required"></span>: </label>
                      <input type="text" class="form-control float" name="asen_nooffloor" value="<?php echo !empty($assets_data[0]->asen_nooffloor)?$assets_data[0]->asen_nooffloor:'0'; ?>">
                    </div>
                     <div class="col-md-3">
                        <label>No. of Room<span class="required"></span>: </label>
                      <input type="text" class="form-control float" name="asen_noofroom" value="<?php echo !empty($assets_data[0]->asen_noofroom)?$assets_data[0]->asen_noofroom:'0'; ?>">
                    </div>
                     <div class="col-md-3">
                        <label>Area (sq.meter)<span class="required">*</span>: </label>
                         <input type="text" class="form-control float required_field" name="asen_area" value="<?php echo !empty($assets_data[0]->asen_area)?$assets_data[0]->asen_area:'0.00'; ?>">
                    </div>
                     
                   
                     <div class="col-md-3">
                        <label>Date of Start<span class="required"></span>: </label>
                      <input type="text" class="form-control <?php echo DATEPICKER_CLASS;?>" name="asen_inservicedate" value="<?php echo  $inservicedate; ?>">
                    </div>

                     <div class="col-md-3">
                        <label>Work Completed Date<span class="required"></span>: </label>
                      <input type="text" class="form-control <?php echo DATEPICKER_CLASS;?>" name="asen_workcompletedate" id="asen_workcompletedate"  value="<?php echo $workcompleteddate; ?>">
                    </div>
                     
                  <div class="col-md-3">
                  <label>Cost<span class="required">*</span>: </label>
                   <input type="text" class="form-control float required_field" name="asen_purchaserate" value="<?php echo !empty($assets_data[0]->asen_purchaserate)?$assets_data[0]->asen_purchaserate:''; ?>">
                  </div>
                 
                   <div class="col-md-3">
                      <?php $sel_asen_statusid=!empty($assets_data[0]->asen_status)?$assets_data[0]->asen_status:''; ?>
                  <label>Status<span class="required">*</span>: </label>
                       <select class="form-control required_field " name="asen_status">
                       <option value="">---select---</option>
                         <?php 
                            if(!empty($asset_status_list)): 
                            foreach ($asset_status_list as $asl => $aslst):
                          ?>
                          <option value="<?php echo $aslst->asst_asstid  ?>" <?php if($sel_asen_statusid==$aslst->asst_asstid) echo "selected=selected"; ?> ><?php echo $aslst->asst_statusname; ?></option>
                         <?php endforeach; endif; ?>
                       </select>
                    </div>
                   
                  <div class="col-md-3">
                      <label>Images<span class="required"></span>: </label>
                   <input type="file" class="form-control" name="asen_images">
                 </div>
                    <div class="col-md-12">
                     <label>Remarks<span class="required"></span>: </label>
                     <textarea style="width:100%" name="asen_remarks"><?php echo !empty($assets_data[0]->asen_remarks)?$assets_data[0]->asen_remarks:'';?>
                     </textarea>
                   </div>
     </div>
<script type="text/javascript">
   $('.engdatepicker').datepicker({
format: 'yyyy/mm/dd',
  autoclose: true
});

$(document).ready(function(){
  $('.nepdatepicker').nepaliDatePicker({
  npdMonth: true,
  npdYear: true,
  npdYearCount: 10 // Options | Number of years to show
});
})

$('.select2').select2();



</script>