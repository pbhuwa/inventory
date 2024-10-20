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
                  
                        <label>Flowmeters ID<span class="required"></span>: </label>
                         <input type="text" class="form-control" name="asen_ncomponentid" value="<?php echo  !empty($assets_data[0]->asen_ncomponentid)?$assets_data[0]->asen_ncomponentid:$ncomponent_code; ?>">
                    </div>
                     <div class="col-md-3">
                    <?php $asen_upstream_ass=!empty($assets_data[0]->asen_upstream_ass)?$assets_data[0]->asen_upstream_ass:''; ?>
                        <label>Upstream Asset<span class="required"></span>: </label>
                        <input type="text" class="form-control" name="asen_upstream_ass" value="<?php echo $asen_upstream_ass; ?>">
                    </div>
                    <div class="col-md-3">
                    <?php $asen_downstream_ass=!empty($assets_data[0]->asen_downstream_ass)?$assets_data[0]->asen_downstream_ass:''; ?>
                        <label>Downstream Asset<span class="required"></span>: </label>
                        <input type="text" class="form-control" name="asen_downstream_ass" value="<?php echo $asen_downstream_ass; ?>" >
                    </div>
                    <div class="col-md-3">
                  <?php $asen_cor_x=!empty($assets_data[0]->asen_cor_x)?$assets_data[0]->asen_cor_x:''; ?>

                        <label>Co-ordinate X<span class="required"></span>: </label>
                        <input type="text" class="form-control" name="asen_cor_x" value="<?php echo $asen_cor_x; ?>">
                    </div>
                    <div class="col-md-3">
                  <?php $asen_cor_y=!empty($assets_data[0]->asen_cor_y)?$assets_data[0]->asen_cor_y:''; ?>
                        <label>Co-ordinate Y<span class="required"></span>: </label>
                        <input type="text" class="form-control" name="asen_cor_y" value="<?php echo $asen_cor_y; ?>">
                    </div>
                    <div class="col-md-3">
                   <?php $asen_invert_level=!empty($assets_data[0]->asen_invert_level)?$assets_data[0]->asen_invert_level:''; ?>
                        <label>Invert Level<span class="required"></span>: </label>
                        <input type="text" class="form-control" name="asen_invert_level" value="<?php echo $asen_invert_level; ?>">
                    </div>
                    
                    <div class="col-md-3">
                   <?php $fmtypeid=!empty($assets_data[0]->asen_flowmetertypeid)?$assets_data[0]->asen_flowmetertypeid:''; ?>

                        <label>Flowmeters Type<span class="required"></span>: </label>
                       <select class="form-control" name="asen_flowmetertypeid">
                           <option value="">---select---</option>
                                <?php 
                                    if($flowmeter_type_list):
                                        foreach ($flowmeter_type_list as $ftl => $ftype):
                                ?>
                                <option value="<?php echo $ftype->flty_id; ?>" <?php if($fmtypeid==$ftype->flty_id) echo "selected=selected"; ?>> <?php echo $ftype->flty_name; ?></option>

                        <?php
                                    endforeach;
                                endif;
                        ?>
                       </select>
                    </div>
                    <div class="col-md-3">
                  
                        <label>Nominal Diameter<span class="required"></span>: </label>
                        <input type="text" class="form-control" name="asen_dia_nom" value="<?php echo  !empty($assets_data[0]->asen_dia_nom)?$assets_data[0]->asen_dia_nom:""; ?>">
                    </div>

                    <div class="col-md-3">
                   <?php $jtypeid=!empty($assets_data[0]->asen_jointypeid)?$assets_data[0]->asen_jointypeid:''; ?>
                        <label>Joint Type<span class="required"></span>: </label>
                         <select class="form-control" name="asen_jointypeid">
                           <option value="">---select---</option>
                                <?php 
                                    if($joint_type_list):
                                        foreach ($joint_type_list as $jtl => $jtype):
                                ?>
                                <option value="<?php echo $jtype->joty_id; ?>" <?php if($jtypeid==$jtype->joty_id) echo "selected=selected"; ?>> <?php echo $jtype->joty_name; ?></option>

                        <?php
                                    endforeach;
                                endif;
                        ?>
                       </select>
                    </div>

                   <div class="col-md-3">
                  
                        <label>Gasket Material<span class="required"></span>: </label>
                        <input type="text" class="form-control" name="asen_gas_material" value="<?php echo  !empty($assets_data[0]->asen_gas_material)?$assets_data[0]->asen_gas_material:""; ?>">
                    </div>
                   <div class="col-md-3">
                  
                        <label>Lining Material(Inside)<span class="required"></span>: </label>
                        <input type="text" class="form-control" name="asen_dia_inside" value="<?php echo  !empty($assets_data[0]->asen_dia_inside)?$assets_data[0]->asen_dia_inside:""; ?>">
                    </div>
                      <div class="col-md-3">
                  
                        <label>Lining Material(Outside)<span class="required"></span>: </label>
                        <input type="text" class="form-control" name="asen_dia_outside" value="<?php echo  !empty($assets_data[0]->asen_dia_outside)?$assets_data[0]->asen_dia_outside:""; ?>">
                    </div>
                     <div class="col-md-3">
                  
                        <label>Surface Level<span class="required"></span>: </label>
                        <input type="text" class="form-control" name="asen_surface_level" value="<?php echo  !empty($assets_data[0]->asen_surface_level)?$assets_data[0]->asen_surface_level:""; ?>">
                    </div>
                      <div class="col-md-3">
                    <?php $db_manu=!empty($assets_data[0]->asen_manufacture)?$assets_data[0]->asen_manufacture:''; ?>
                        <label>Manufacturer<span class="required"></span>: </label>
                       <select class="asen_manufacture form-control select2" name="asen_manufacture" >
                         <?php 
                            if(!empty($manufacturers)): 
                            foreach ($manufacturers as $km => $man):
                          ?>
                          <option value="<?php echo $man->manu_manlistid  ?>" <?php if($db_manu=$man->manu_manlistid) echo "selected=selected"; ?>><?php echo $man->manu_manlst; ?></option>
                         <?php endforeach; endif; ?>
                       </select>
                    </div>

                     <div class="col-md-3">
                     <?php $asen_make=!empty($assets_data[0]->asen_make)?$assets_data[0]->asen_make:''; ?>
                        <label>Make<span class="required"></span>: </label>
                      <input type="text" class="form-control" name="asen_make" value="<?php echo $asen_make; ?>" >
                    </div>
                     <div class="col-md-3">
                    <?php $asen_modelno=!empty($assets_data[0]->asen_modelno)?$assets_data[0]->asen_modelno:''; ?>
                        <label>Model<span class="required"></span>: </label>
                         <input type="text" class="form-control" name="asen_modelno" value="<?php echo $asen_modelno; ?>">
                    </div>
                    <div class="col-md-3">
                   <?php $asen_serialno=!empty($assets_data[0]->asen_serialno)?$assets_data[0]->asen_serialno:''; ?>
                        <label>Serial No.<span class="required"></span>: </label>
                         <input type="text" class="form-control" name="asen_serialno" value="<?php echo $asen_serialno; ?>">
                    </div>
                     <div class="col-md-3">
                        <label>Date of Installation<span class="required"></span>: </label>
                      <input type="text" class="form-control" name="asen_inservicedate" value="<?php echo  $inservicedate; ?>">
                    </div>
                     <div class="col-md-3">
                        <label>Date of Manufacture<span class="required"></span>: </label>
                      <input type="text" class="form-control <?php echo DATEPICKER_CLASS;?>" name="asen_manufacture_date" id="manufacture_date"  value="<?php echo $manufacture_date; ?>">
                    </div>
                    <div class="col-md-3">
                        <label>Standard<span class="required"></span>: </label>
                      <input type="text" class="form-control" name="asen_strandard" value="<?php echo  !empty($assets_data[0]->asen_strandard)?$assets_data[0]->asen_strandard:""; ?>">
                    </div>
                       <div class="col-md-3">
                        <label>Drawings<span class="required"></span>: </label>
                      <input type="text" class="form-control" name="asen_drawing" value="<?php echo  !empty($assets_data[0]->asen_drawing)?$assets_data[0]->asen_drawing:""; ?>">
                    </div>
                    <div class="col-md-3">
                        <label>Contract No.<span class="required"></span>: </label>
                      <input type="text" class="form-control" name="asen_contract_no" value="<?php echo  !empty($assets_data[0]->asen_contract_no)?$assets_data[0]->asen_contract_no:''; ?>">
                    </div>
                       <div class="col-md-3">
                        <?php $patypeid=!empty($assets_data[0]->asen_pavement_typeid)?$assets_data[0]->asen_pavement_typeid:''; ?>
                        <label>Pavement Type<span class="required"></span>: </label>
                    <select class="form-control" name="asen_pavement_typeid">
                           <option value="">---select---</option>
                                <?php 
                                    if($pavement_type_list):
                                        foreach ($pavement_type_list as $pt => $ptl):
                                ?>
                                <option value="<?php echo $ptl->paty_id; ?>" <?php if($patypeid==$ptl->paty_id) echo "selected=selected"; ?>> <?php echo $ptl->paty_name; ?></option>

                        <?php
                                    endforeach;
                                endif;
                        ?>
                       </select>
                    </div>
                     <div class="col-md-3">
                        <label>Node ID<span class="required"></span>: </label>
                      <input type="text" class="form-control" name="asen_nodeid" value="<?php echo  !empty($assets_data[0]->asen_ncomponentid)?$assets_data[0]->asen_ncomponentid:""; ?>">
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