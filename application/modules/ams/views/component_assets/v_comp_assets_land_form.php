  <?php
  if(DEFAULT_DATEPICKER == 'NP'){
      $inservicedate = !empty($assets_data[0]->asen_inservicedatebs)?$assets_data[0]->asen_inservicedatebs:DISPLAY_DATE;
     
  }else{
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
                  
                        <label>Land ID<span class="required"></span>: </label>
                         <input type="text" class="form-control" name="asen_ncomponentid" value="<?php echo  !empty($assets_data[0]->asen_ncomponentid)?$assets_data[0]->asen_ncomponentid:$ncomponent_code; ?>">
                    </div>
                    <div class="col-md-3">
                        <label>Area (sq.meter)<span class="required">*</span>: </label>
                         <input type="text" class="form-control float required_field" name="asen_area" value="<?php echo !empty($assets_data[0]->asen_area)?$assets_data[0]->asen_area:$asset_code; ?>">
                    </div>
                    <div class="col-md-3">
                      <?php $iscompoundwall=!empty($assets_data[0]->asen_iscompoundwall)?$assets_data[0]->asen_iscompoundwall:''; ?>
                        <label>Compound Wall<span class="required">*</span>: </label>
                        <select class="form-control" name="asen_iscompoundwall"> <option value="NO" <?php if($iscompoundwall=='NO') echo "selected=selected"; ?>>No</option>
                          <option value="YES" <?php if($iscompoundwall=='YES') echo "selected=selected"; ?>>Yes</option>
                         
                        </select>
                    </div>
                    
                      <div class="col-md-3">
                        <label>Date of Used<span class="required"></span>: </label>
                      <input type="text" class="form-control <?php echo DATEPICKER_CLASS;?>" name="asen_inservicedate" value="<?php echo  $inservicedate; ?>" id="inservicedate">
                    </div>

                    <div class="col-md-3">
                        <label>Cost<span class="required">*</span>: </label>
                         <input type="text" class="form-control float required_field" name="asen_purchaserate" value="<?php echo !empty($assets_data[0]->asen_purchaserate)?$assets_data[0]->asen_purchaserate:''; ?>">
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
                     <textarea style="width:100%" name="asen_remarks"><?php echo !empty($assets_data[0]->asen_remarks)?$assets_data[0]->asen_remarks:'';?></textarea>
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