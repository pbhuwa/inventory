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
                  
                        <label>Sewerage ID<span class="required"></span>: </label>
                         <input type="text" class="form-control" name="asen_ncomponentid" value="<?php echo  !empty($assets_data[0]->asen_ncomponentid)?$assets_data[0]->asen_ncomponentid:$ncomponent_code; ?>">
                    </div>

                   <div class="col-md-12">
                   <label>Sewer line material </label>
                   </div>
                   
                   <div class="col-md-12">
                   <label style="border-bottom: 1px solid green;">Sewer line details </label>
                   <div class="row">
                   <div class="col-md-3">
                      <label>Length(meter)<span class="required"></span>: </label>
                        <input type="text" class="form-control float" name="asen_faccode" value="<?php echo !empty($assets_data[0]->asen_faccode)?$assets_data[0]->asen_faccode:''; ?>">
                   </div>
                   <div class="col-md-3">
                      <label>Diameter (mm)<span class="required"></span>: </label>
                        <input type="text" class="form-control float" name="asen_faccode" value="<?php echo !empty($assets_data[0]->asen_faccode)?$assets_data[0]->asen_faccode:''; ?>">
                   </div>
                 </div>
                  </div>
                  <div class="col-md-3">
                     <label>Color: </label>
                      <input type="text" class="form-control " name="asen_color" value="<?php echo !empty($assets_data[0]->asen_color)?$assets_data[0]->asen_color:''; ?>">
                  </div>
                   <div class="col-md-3"> 
                    <?php $sel_projectid=!empty($assets_data[0]->asen_projectid)?$assets_data[0]->asen_projectid:''; ?>
                    <label>Project <span class="required">*</span>:</label>
                     <select name="asen_projectid" id="projectid" class="form-control select2 required_field" >
                      <option value="">--Select--</option>
                      <?php 
                      if(!empty($project_list)): 
                          foreach($project_list as $pl):
                      ?>
                      <option value="<?php echo $pl->prin_prinid ?>" <?php if($sel_projectid==$pl->prin_prinid) echo "selected=selected"; ?>><?php echo $pl->prin_project_title ?></option> 
                      <?php 
                          endforeach; 
                      endif; 
                      ?>
                      </select>
                  </div>

                   <div class="col-md-12">
                   <label style="border-bottom: 1px solid green;">Manhole cover & frame (Cast Iron) </label>
                   <div class="row">
                    <div class="col-md-3"> 
                      <label>Heavy Duty</label>

                      <?php $asen_heavyduty=!empty($assets_data[0]->asen_heavyduty)?$assets_data[0]->asen_heavyduty:''; ?>
                     <input type="text" name="asen_heavyduty" class="form-control" value="<?php echo $asen_heavyduty;  ?>">
                   </div>
                   <div class="col-md-3"> 
                      <?php $asen_mediumduty=!empty($assets_data[0]->asen_mediumduty)?$assets_data[0]->asen_mediumduty:''; ?>
                      <label>Medium Duty</label>
                      <input type="text" name="asen_mediumduty" class="form-control"  value="<?php echo $asen_mediumduty;  ?>">
                   </div>
                    
                    <div class="col-md-3"> 
                        <?php $asen_lightduty=!empty($assets_data[0]->asen_lightduty)?$assets_data[0]->asen_lightduty:''; ?>
                      <label>Light Duty</label>
                     <input type="text" name="asen_lightduty" class="form-control" value="<?php echo $asen_lightduty;  ?>">  
                   </div>
                     <div class="col-md-3"> 
                        <?php $asen_rcc=!empty($assets_data[0]->asen_rcc)?$assets_data[0]->asen_rcc:''; ?>
                      <label>RCC </label>
                     <input type="text" name="asen_rcc" class="form-control" value="<?php echo $asen_rcc;  ?>">  
                   </div>

                 </div>

                   <div class="col-md-3">
                      <?php $sel_asen_status=!empty($assets_data[0]->asen_status)?$assets_data[0]->asen_status:''; ?>
                      <label>Status<span class="required"></span>: </label>
                     <select class="asen_status form-control " name="asen_status">
                     <option value="">---select---</option>
                       <?php 
                          if(!empty($asset_status_list)): 
                          foreach ($asset_status_list as $asl => $aslst):
                        ?>
                        <option value="<?php echo $aslst->asst_asstid  ?>" <?php if($sel_asen_status==$aslst->asst_asstid) echo "selected=selected"; ?>><?php echo $aslst->asst_statusname; ?></option>
                       <?php endforeach; endif; ?>
                     </select>
                  </div>
                 
                  <div class="col-md-6">
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