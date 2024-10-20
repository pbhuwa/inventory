  <?php
  if(DEFAULT_DATEPICKER == 'NP'){
      $manufacture_date = !empty($assets_data[0]->asen_manufacture_datebs)?$assets_data[0]->asen_manufacture_datebs:DISPLAY_DATE;
      $inservicedate = !empty($assets_data[0]->asen_inservicedatebs)?$assets_data[0]->asen_inservicedatebs:DISPLAY_DATE;
  }else{
      $manufacture_date = !empty($assets_data[0]->asen_manufacture_datead)?$assets_data[0]->asen_manufacture_datead:DISPLAY_DATE;
      $inservicedate = !empty($assets_data[0]->asen_inservicedatead)?$assets_data[0]->asen_inservicedatead:DISPLAY_DATE;
}
// echo "<pre>";
// print_r($project_list);
// die();
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
        
              <label>Treatment Plan ID<span class="required"></span>: </label>
               <input type="text" class="form-control" name="asen_ncomponentid" value="<?php echo  !empty($assets_data[0]->asen_ncomponentid)?$assets_data[0]->asen_ncomponentid:$ncomponent_code; ?>">
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
              <label>Date of Construction<span class="required"></span>: </label>
            <input type="text" class="form-control <?php echo DATEPICKER_CLASS;?>" name="asen_manufacture_date" id="asen_manufacture_date"  value="<?php echo $manufacture_date ?>">
          </div>
           <div class="col-md-3">
            <?php $sel_manufacture=!empty($assets_data[0]->asen_manufacture)?$assets_data[0]->asen_manufacture:''; ?>
            <label>Manufacturer<span class="required"></span>: </label>
            <select class="asen_manufacture form-control select2" name="asen_manufacture"> 
               <option value="">---select---</option>                       
               <?php 
                  if(!empty($manufacturers)): 
                  foreach ($manufacturers as $km => $man):
                ?>
                <option value="<?php echo $man->manu_manlistid  ?>"<?php if($sel_manufacture==$man->manu_manlistid) echo "selected=selected"; ?>><?php echo $man->manu_manlst; ?></option>
               <?php endforeach; endif; ?>
             </select>
          </div>


           <div class="col-md-3">
              <label>Date of Installation<span class="required"></span>: </label>
            <input type="text" class="form-control <?php echo DATEPICKER_CLASS;?>" name="asen_inservicedate" id="asen_inservicedate" value="<?php echo $inservicedate; ?>">
          </div>
           <div class="col-md-3">
              <label>Treatment Capacity<span class="required"></span>: </label>
            <input type="text" class="form-control" name="asen_treatmentcapacity" value="<?php echo !empty($assets_data[0]->asen_treatmentcapacity)?$assets_data[0]->asen_treatmentcapacity:''; ?>">
          </div>
           <div class="col-md-3">
            <?php $rawwater_source= !empty($assets_data[0]->asen_rawwater_source)?$assets_data[0]->asen_rawwater_source:''; ?>
              <label>Raw Water Source<span class="required"></span>: </label>
            <input type="text" class="form-control" name="asen_rawwater_source" value="<?php echo $rawwater_source; ?>">
          </div>
          <div class="col-md-3">
             <?php $reserviour_capacity= !empty($assets_data[0]->asen_reserviour_capacity)?$assets_data[0]->asen_reserviour_capacity:''; ?>
              <label>Reserviour Capacity<span class="required"></span>: </label>
            <input type="text" class="form-control" name="asen_reserviour_capacity" value="<?php echo $reserviour_capacity; ?>">
          </div>
          <div class="col-md-3">
             <?php $asen_purchaserate= !empty($assets_data[0]->asen_purchaserate)?$assets_data[0]->asen_purchaserate:''; ?>

              <label>Cost<span class="required"></span>: </label>
            <input type="text" class="form-control float" name="asen_purchaserate" value="<?php echo $asen_purchaserate; ?>">
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
          <!-- <div class="col-md-3">
              <label>Back Wash Pump<span class="required"></span>: </label>
              <?php 
                if(!empty($pump_capacity_list)): 
                  ?>
                  <select class="form-control" name="">
                <option value="">--select--</option>
                <?php
                  foreach ($pump_capacity_list as $kpc => $pcap):
                ?>
                <option value="<?php echo $pcap->puca_pumpcapacityid ?>"><?php echo $pcap->puca_title ?></option>
                <?php 
              endforeach;
              ?>
           </select>
          <?php
          endif; ?>
            
          </div> -->
          <div class="col-md-3">
            <?php $sel_pump_type=!empty($assets_data[0]->asen_pumptypeid)?$assets_data[0]->asen_pumptypeid:''; ?>
            <label>Back Wash Pump<span class="required"></span>: </label>
             <select class="asen_pumptypeid form-control" name="asen_pumptypeid">
             <option value="">---select---</option>
               <?php 
                  if(!empty($pump_capacity_list)): 
                  foreach ($pump_capacity_list as $ktl => $ttl):
                ?>
                <option value="<?php echo $ttl->puca_pumpcapacityid  ?>"<?php if($sel_pump_type==$ttl->puca_pumpcapacityid ) echo "selected=selected"; ?>><?php echo $ttl->puca_title; ?></option>
               <?php endforeach; endif; ?>
             </select>
          </div>

          <div class="col-md-3">
            <?php $sel_treatment_plan_type=!empty($assets_data[0]->asen_treatment_plan_type)?$assets_data[0]->asen_treatment_plan_type:''; ?>
            <label>Tretment Plan Type<span class="required"></span>: </label>
             <select class="asen_treatment_plan_type form-control" name="asen_treatment_plan_type">
             <option value="">---select---</option>
               <?php 
                  if(!empty($treatmentplan_type_list)): 
                  foreach ($treatmentplan_type_list as $ktl => $ttl):
                ?>
                <option value="<?php echo $ttl->tept_trplid  ?>"<?php if($sel_treatment_plan_type==$ttl->tept_trplid ) echo "selected=selected"; ?>><?php echo $ttl->tept_name; ?></option>
               <?php endforeach; endif; ?>
             </select>
          </div>
          
          <div class="col-md-3">
              <?php $sel_treatment_component=!empty($assets_data[0]->asen_treatment_component)?$assets_data[0]->asen_treatment_component:''; ?>
              <label>Treatment Component <span class="required"></span>: </label>
             <select class="asen_treatment_component form-control" name="asen_treatment_component">
             <option value="">---select---</option>
               <?php 
                  if(!empty($treatmentcomponent_list)): 
                  foreach ($treatmentcomponent_list as $ktcl => $tcl):
                ?>
                <option value="<?php echo $tcl->teco_tecoid  ?>" <?php if($sel_treatment_component==$tcl->teco_tecoid) echo "selected=selected"; ?>><?php echo $tcl->teco_name; ?></option>
               <?php endforeach; endif; ?>
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
           <textarea style="width:100%" name="asen_remarks">
              <?php echo !empty($assets_data[0]->asen_remarks)?$assets_data[0]->asen_remarks:'';?>
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