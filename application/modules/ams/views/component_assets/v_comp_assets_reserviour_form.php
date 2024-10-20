  <?php
  if(DEFAULT_DATEPICKER == 'NP'){
      $manufacture_date = !empty($assets_data[0]->asen_manufacture_datebs)?$assets_data[0]->asen_manufacture_datebs:DISPLAY_DATE;
      $inservicedate = !empty($assets_data[0]->asen_inservicedatebs)?$assets_data[0]->asen_inservicedatebs:DISPLAY_DATE;
       $workcompleteddate=!empty($assets_data[0]->asen_workcompletedatebs)?$assets_data[0]->asen_workcompletedatebs:DISPLAY_DATE;

     


  }else{
      $manufacture_date = !empty($assets_data[0]->asen_manufacture_datead)?$assets_data[0]->asen_manufacture_datead:DISPLAY_DATE;
      $inservicedate = !empty($assets_data[0]->asen_inservicedatead)?$assets_data[0]->asen_inservicedatead:DISPLAY_DATE;
        $workcompleteddate=!empty($assets_data[0]->asen_workcompletedatead)?$assets_data[0]->asen_workcompletedatead:DISPLAY_DATE;
     
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
                  
                        <label>Reserviour ID<span class="required"></span>: </label>
                         <input type="text" class="form-control" name="asen_ncomponentid" value="<?php echo  !empty($assets_data[0]->asen_ncomponentid)?$assets_data[0]->asen_ncomponentid:$ncomponent_code; ?>">
                    </div>
                     <div class="col-md-3">
                  
                        <label>Reserviour Type<span class="required"></span>: </label>
                      <select class="form-control">
                        <option>--select--</option>
                         <?php 
                            if(!empty($reserviourtype_list)): 
                            foreach ($reserviourtype_list as $krl => $rtl):
                          ?>
                          <option value="<?php echo $rtl->rety_retyid  ?>"><?php echo $rtl->rety_name; ?></option>
                         <?php endforeach; endif; ?>
                      </select>
                    </div>

                    <div class="col-md-3">
                  
                        <label>Reserviour Shape<span class="required"></span>: </label>
                      <select class="form-control">
                        <option>--select--</option>
                         <?php 
                            if(!empty($reserviourshape_list)): 
                            foreach ($reserviourshape_list as $ksl => $rsl):
                          ?>
                          <option value="<?php echo $rsl->resh_reshid  ?>"><?php echo $rsl->resh_name; ?></option>
                         <?php endforeach; endif; ?>
                      </select>
                    </div>
                     
                     
                     <div class="col-md-3">
                  
                        <label>Manufacturer<span class="required"></span>: </label>
                       <select class="asen_manufacture form-control select2" name="asen_manufacture"> 
                         <option value="">---select---</option>                       
                         <?php 
                            if(!empty($manufacturers)): 
                            foreach ($manufacturers as $km => $man):
                          ?>
                          <option value="<?php echo $man->manu_manlistid  ?>"><?php echo $man->manu_manlst; ?></option>
                         <?php endforeach; endif; ?>
                       </select>
                    </div>


                     <div class="col-md-3">
                        <label>Date of Installation<span class="required"></span>: </label>
                      <input type="text" class="form-control <?php echo DATEPICKER_CLASS;?>" name="asen_inservicedate" value="<?php echo  $inservicedate; ?>">
                    </div>
                     <div class="col-md-3">
                        <label>Work Completed Date<span class="required"></span>: </label>
                      <input type="text" class="form-control <?php echo DATEPICKER_CLASS;?>" name="asen_workcompletedate" id="asen_workcompletedate"  value="<?php echo $workcompleteddate; ?>">
                    </div>
                     
                    <div class="col-md-3">
                        <label>Cost<span class="required"></span>: </label>
                     <input type="text" class="form-control float required_field" name="asen_purchaserate" value="<?php echo !empty($assets_data[0]->asen_purchaserate)?$assets_data[0]->asen_purchaserate:''; ?>">
                    </div>
                     <div class="col-md-3">
                       <label>Maintenance Period<span class="required"></span>: </label>
                  <?php 
                    $asen_maintenance_frequencyid=!empty($assets_data[0]->asen_maintenance_frequencyid)?$assets_data[0]->asen_maintenance_frequencyid:'';
                     ?>
                       <select name="asen_maintenance_frequencyid" id="asen_maintenance_frequencyid" class="form-control required_field ">
                        <option value="">---Select---</option>
                        <?php
                        if(!empty($frequency)):
                            foreach ($frequency as $kf => $fre):
                        ?>
                        <option value="<?php echo $fre->frty_frtyid ?>" <?php if($asen_maintenance_frequencyid==$fre->frty_frtyid) echo "selected=selected"; ?>><?php echo $fre->frty_name; ?></option>
                        <?php
                       endforeach;
                        endif;
                         ?>
                    </select>
                      
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

// $('.select2').select2();



</script>