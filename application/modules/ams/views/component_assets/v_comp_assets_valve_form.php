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
                  
                        <label>Valve ID<span class="required"></span>: </label>
                       <input type="text" class="form-control" name="asen_ncomponentid" value="<?php echo  !empty($assets_data[0]->asen_ncomponentid)?$assets_data[0]->asen_ncomponentid:$ncomponent_code; ?>">
                    </div>
                    <div class="col-md-3">
                  
                        <label>Co-ordinate X<span class="required"></span>: </label>
                        <input type="text" class="form-control" name="asen_cor_x" value="<?php echo  !empty($assets_data[0]->asen_cor_x)?$assets_data[0]->asen_cor_x:''; ?>">
                    </div>
                    <div class="col-md-3">
                  
                        <label>Co-ordinate Y<span class="required"></span>: </label>
                        <input type="text" class="form-control" name="asen_cor_y" value="<?php echo  !empty($assets_data[0]->asen_cor_x)?$assets_data[0]->asen_cor_x:''; ?>">
                    </div>
                    <div class="col-md-3">
                  
                        <label>Invert Level<span class="required"></span>: </label>
                        <input type="text" class="form-control" name="asen_invert_level" value="<?php echo  !empty($assets_data[0]->asen_invert_level)?$assets_data[0]->asen_invert_level:''; ?>">
                    </div>
                    
                    <div class="col-md-3">
                  <?php $vtypeid=!empty($assets_data[0]->asen_valve_typeid)?$assets_data[0]->asen_valve_typeid:''; ?>
                        <label>Valve Type<span class="required"></span>: </label>
                       <select class="form-control" name="asen_valve_typeid">
                           <option value="">---select---</option>
                                <?php 
                                    if($valve_type_list):
                                        foreach ($valve_type_list as $vtl => $vtype):
                                ?>
                                <option value="<?php echo $vtype->vaty_id; ?>" <?php if($vtypeid==$vtype->vaty_id) echo "selected=selected"; ?>> <?php echo $vtype->vaty_name; ?></option>

                        <?php
                                    endforeach;
                                endif;
                        ?>
                       </select>
                    </div>
                    <div class="col-md-3">
                     <?php $mtypeid=!empty($assets_data[0]->asen_mat_typeid)?$assets_data[0]->asen_mat_typeid:''; ?>
                        <label>Material Type<span class="required"></span>: </label>
                       <select class="form-control" name="asen_mat_typeid">
                           <option value="">---select---</option>
                                <?php 
                                    if($material_type_list):
                                        foreach ($material_type_list as $mtl => $mtype):
                                ?>
                                <option value="<?php echo $mtype->pimt_id; ?>" <?php if($mtypeid==$mtype->pimt_id) echo "selected=selected"; ?>> <?php echo $mtype->pimt_name; ?></option>

                        <?php
                                    endforeach;
                                endif;
                        ?>
                       </select>
                    </div>

                    <div class="col-md-3">
                  
                        <label>Class<span class="required"></span>: </label>
                        <input type="text" class="form-control" name="asen_class" value="<?php echo  !empty($assets_data[0]->asen_class)?$assets_data[0]->asen_class:''; ?>">
                    </div>
                    <div class="col-md-3">
                  
                        <label>Nominal Diameter<span class="required"></span>: </label>
                        <input type="text" class="form-control" name="asen_dia_nom" value="<?php echo  !empty($assets_data[0]->asen_dia_nom)?$assets_data[0]->asen_dia_nom:''; ?>">
                    </div>
                    <div class="col-md-3">
                  
                        <label>Seal Materialr<span class="required"></span>: </label>
                        <input type="text" class="form-control" name="asen_seal_mat" value="<?php echo  !empty($assets_data[0]->asen_seal_mat)?$assets_data[0]->asen_seal_mat:''; ?>">
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
                        <input type="text" class="form-control" name="asen_gas_material" value="<?php echo  !empty($assets_data[0]->asen_gas_material)?$assets_data[0]->asen_gas_material:''; ?>">
                    </div>
                    <div class="col-md-3">
                  
                        <label>Lining Material(Inside)<span class="required"></span>: </label>
                        <input type="text" class="form-control" name="asen_lining_inside" value="<?php echo  !empty($assets_data[0]->asen_lining_inside)?$assets_data[0]->asen_lining_inside:''; ?>">
                    </div>
                      <div class="col-md-3">
                  
                        <label>Lining Material(Outside)<span class="required"></span>: </label>
                        <input type="text" class="form-control" name="asen_lining_outside" value="<?php echo  !empty($assets_data[0]->asen_lining_outside)?$assets_data[0]->asen_lining_outside:''; ?>">
                    </div>
                    <div class="col-md-3">
                  
                        <label>Surface Level<span class="required"></span>: </label>
                        <input type="text" class="form-control" name="asen_surface_level" value="<?php echo  !empty($assets_data[0]->asen_surface_level)?$assets_data[0]->asen_surface_level:''; ?>">
                    </div>
                    <div class="col-md-3">
                  
                        <label>Depth of Cover<span class="required"></span>: </label>
                        <input type="text" class="form-control" name="asen_dep_cover" value="<?php echo  !empty($assets_data[0]->asen_dep_cover)?$assets_data[0]->asen_dep_cover:''; ?>">
                    </div>
                   <div class="col-md-3">
                  
                        <label>Manufacturer<span class="required"></span>: </label>
                       <select class="asen_manufacture form-control select2" name="asen_manufacture" >
                         <?php 
                            if(!empty($manufacturers)): 
                            foreach ($manufacturers as $km => $man):
                          ?>
                          <option value="<?php echo $man->manu_manlistid  ?>"><?php echo $man->manu_manlst; ?></option>
                         <?php endforeach; endif; ?>
                       </select>
                    </div>

                        <div class="col-md-3">
                  
                        <label>Make<span class="required"></span>: </label>
                      <input type="text" class="form-control" name="asen_make" value="<?php echo  !empty($assets_data[0]->asen_make)?$assets_data[0]->asen_make:''; ?>">
                    </div>
                     <div class="col-md-3">
                  
                        <label>Model<span class="required"></span>: </label>
                         <input type="text" class="form-control" name="asen_modelno" value="<?php echo  !empty($assets_data[0]->asen_modelno)?$assets_data[0]->asen_modelno:''; ?>">
                    </div>
                    <div class="col-md-3">
                  
                        <label>Serial No.<span class="required"></span>: </label>
                         <input type="text" class="form-control" name="asen_serialno" value="<?php echo  !empty($assets_data[0]->asen_serialno)?$assets_data[0]->asen_serialno:''; ?>">
                    </div>
                      <div class="col-md-3">
                        <label>Date of Installation<span class="required"></span>: </label>
                      <input type="text" class="form-control" name="asen_inservicedate" value="<?php echo  !empty($assets_data[0]->asen_inservicedate)?$assets_data[0]->asen_inservicedate:''; ?>">
                    </div>
                     <div class="col-md-3">
                        <label>Date of Manufacture<span class="required"></span>: </label>
                      <input type="text" class="form-control <?php echo DATEPICKER_CLASS;?>" name="asen_manufacture_date" id="manufacture_date"  value="<?php echo $manufacture_date; ?>">
                    </div>
                    <div class="col-md-3">
                        <label>Standard<span class="required"></span>: </label>
                      <input type="text" class="form-control" name="asen_strandard" value="<?php echo  !empty($assets_data[0]->asen_strandard)?$assets_data[0]->asen_strandard:''; ?>">
                    </div>
                       <div class="col-md-3">
                        <label>Drawings<span class="required"></span>: </label>
                      <input type="text" class="form-control" name="asen_drawing" value="<?php echo  !empty($assets_data[0]->asen_drawing)?$assets_data[0]->asen_drawing:''; ?>">
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
                         <label>Valve settings<span class="required"></span>: </label>
                          <?php $valve_settingid=!empty($assets_data[0]->asen_valve_settingid)?$assets_data[0]->asen_valve_settingid:''; ?>
                      <select name="asen_valve_settingid" class="form-control">
                        <option value="">---select---</option>
                                <?php 
                                    if($valvesetting_list):
                                        foreach ($valvesetting_list as $kvl => $vsl):
                                ?>
                                <option value="<?php echo $vsl->vase_id; ?>" <?php if($valve_settingid==$vsl->vase_id) echo "selected=selected"; ?>> <?php echo $vsl->vase_name; ?></option>

                        <?php
                                    endforeach;
                                endif;
                        ?>
                      </select>
                    </div>

                     <div class="col-md-3">
                      <?php $chtypeid=!empty($assets_data[0]->asen_chamber_typeid)?$assets_data[0]->asen_chamber_typeid:''; ?>
                        <label>Valve Chamber type<span class="required"></span>: </label>
                      <select name="asen_chamber_typeid" class="form-control">
                      <option value="">---select---</option>
                                <?php 
                                    if($chambertype_list):
                                        foreach ($chambertype_list as $kcl => $chl):
                                ?>
                                <option value="<?php echo $chl->chty_id; ?>" <?php if($chtypeid==$chl->chty_id) echo "selected=selected"; ?>> <?php echo $chl->chty_name; ?></option>

                        <?php
                                    endforeach;
                                endif;
                        ?>
                      </select>
                    </div>
                     <div class="col-md-3">
                        <label>Node ID<span class="required"></span>: </label>
                      <input type="text" class="form-control" name="asen_nodeid" value="<?php echo  !empty($assets_data[0]->asen_nodeid)?$assets_data[0]->asen_nodeid:''; ?>">
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