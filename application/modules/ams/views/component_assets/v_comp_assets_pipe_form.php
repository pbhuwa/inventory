<?php
  if(DEFAULT_DATEPICKER == 'NP'){
      $manufacture_date = !empty($assets_data[0]->asen_manufacture_datebs)?$assets_data[0]->asen_manufacture_datebs:DISPLAY_DATE;
      $inservicedate = !empty($assets_data[0]->asen_inservicedatebs)?$assets_data[0]->asen_inservicedatebs:DISPLAY_DATE;
      $asen_relinedate=!empty($assets_data[0]->asen_relinedatebs)?$assets_data[0]->asen_relinedatebs:DISPLAY_DATE;


  }else{
      $manufacture_date = !empty($assets_data[0]->asen_manufacture_datead)?$assets_data[0]->asen_manufacture_datead:DISPLAY_DATE;
      $inservicedate = !empty($assets_data[0]->asen_inservicedatead)?$assets_data[0]->asen_inservicedatead:DISPLAY_DATE;
      $asen_relinedate=!empty($assets_data[0]->asen_relinedatead)?$assets_data[0]->asen_relinedatead:DISPLAY_DATE;

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
                  
                        <label>Pipe ID<span class="required"></span>: </label>
                        <input type="text" class="form-control" name="asen_ncomponentid" value="<?php echo  !empty($assets_data[0]->asen_ncomponentid)?$assets_data[0]->asen_ncomponentid:$ncomponent_code; ?>">
                    </div>
                    <div class="col-md-3">
                  
                        <label>Upstream Asset<span class="required"></span>: </label>
                        <input type="text" class="form-control" name="asen_upstream_ass" value="<?php echo  !empty($assets_data[0]->asen_upstream_ass)?$assets_data[0]->asen_upstream_ass:''; ?>">
                    </div>
                    <div class="col-md-3">
                  
                        <label>Downstream Asset<span class="required"></span>: </label>
                        <input type="text" class="form-control" name="asen_downstream_ass"  value="<?php echo  !empty($assets_data[0]->asen_downstream_ass)?$assets_data[0]->asen_downstream_ass:''; ?>">
                    </div>
                    <div class="col-md-3">
                  
                        <label>Upstream Invert Level<span class="required"></span>: </label>
                        <input type="text" class="form-control" name="asen_upstream_invertlevel" value="<?php echo  !empty($assets_data[0]->asen_upstream_invertlevel)?$assets_data[0]->asen_upstream_invertlevel:''; ?>">
                    </div>
                    <div class="col-md-3">
                  
                        <label>Downstream Invert Level<span class="required"></span>: </label>
                        <input type="text" class="form-control" name="asen_downstream_invertlevel"  value="<?php echo !empty($assets_data[0]->asen_downstream_invertlevel)?$assets_data[0]->asen_downstream_invertlevel:''; ?>">
                    </div>
                    <div class="col-md-3">
                  <?php $sel_mat_typeid= !empty($assets_data[0]->asen_mat_typeid)?$assets_data[0]->asen_mat_typeid:''; ?>
                        <label>Material Type<span class="required"></span>: </label>
                       <select class="form-control" name="asen_mat_typeid" >
                           <option value="">---select---</option>
                                <?php 
                                    if($material_type_list):
                                        foreach ($material_type_list as $mtl => $mtype):
                                ?>
                                <option value="<?php echo $mtype->pimt_id; ?>" <?php if($sel_mat_typeid==$mtype->pimt_id) echo "selected=selected"; ?>> <?php echo $mtype->pimt_name; ?></option>

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
                  
                        <label>Inside Diameter<span class="required"></span>: </label>
                        <input type="text" class="form-control" name="asen_dia_inside" value="<?php echo  !empty($assets_data[0]->asen_dia_inside)?$assets_data[0]->asen_dia_inside:''; ?>">
                    </div>
                    <div class="col-md-3">
                  
                        <label>Outside Diameter<span class="required"></span>: </label>
                        <input type="text" class="form-control" name="asen_dia_outside" value="<?php echo  !empty($assets_data[0]->asen_dia_outside)?$assets_data[0]->asen_dia_outside:''; ?>">
                    </div>
                    <div class="col-md-3">
                  
                        <label>Upstream node<span class="required"></span>: </label>
                        <input type="text" class="form-control" name="asen_node_upstream" value="<?php echo  !empty($assets_data[0]->asen_node_upstream)?$assets_data[0]->asen_node_upstream:''; ?>">
                    </div>
                     <div class="col-md-3">
                  
                        <label>Downstream Node<span class="required"></span>: </label>
                        <input type="text" class="form-control" name="asen_node_downstream" value="<?php echo  !empty($assets_data[0]->asen_node_downstream)?$assets_data[0]->asen_node_downstream:''; ?>">
                    </div>
                    <div class="col-md-3">
                  
                        <label>Pipe Pressure<span class="required"></span>: </label>
                        <input type="text" class="form-control" name="asen_pipe_pr" value="<?php echo  !empty($assets_data[0]->asen_pipe_pr)?$assets_data[0]->asen_pipe_pr:''; ?>">
                    </div>
                    <div class="col-md-3">
                  
                        <label>Joint Type<span class="required"></span>: </label>
                        <?php $jtype=!empty($assets_data[0]->asen_jointypeid)?$assets_data[0]->asen_jointypeid:''; ?>
                         <select class="form-control" name="asen_jointypeid">
                           <option value="">---select---</option>
                                <?php 
                                    if($joint_type_list):
                                        foreach ($joint_type_list as $jtl => $jtype):
                                ?>
                                <option value="<?php echo $jtype->joty_id; ?>" <?php if($jtype==$jtype->joty_id) echo "selected=selected"; ?>> <?php echo $jtype->joty_name; ?></option>

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
                  
                        <label>Length (Individual)<span class="required"></span>: </label>
                        <input type="text" class="form-control" name="asen_length" value="<?php echo  !empty($assets_data[0]->asen_length)?$assets_data[0]->asen_length:''; ?>">
                    </div>
                    <div class="col-md-3">
                  
                        <label>Lining Material<span class="required"></span>: </label>
                        <input type="text" class="form-control" name="asen_mat_lining" value="<?php echo  !empty($assets_data[0]->asen_mat_lining)?$assets_data[0]->asen_mat_lining:''; ?>">
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
                       <select class="asen_manufacture form-control select2" name="asen_manufacture">
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
                      <input type="text" class="form-control <?php echo DATEPICKER_CLASS;?>" name="asen_inservicedate" id="asen_inservicedate" value="<?php echo $inservicedate; ?>">
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
                        <label>Pipe zone<span class="required"></span>: </label>
                         <?php $apzid=!empty($assets_data[0]->asen_pipe_zoneid)?$assets_data[0]->asen_pipe_zoneid:''; ?>
                     <select class="form-control" name="asen_pipe_zoneid">
                           <option value="">---select---</option>
                                <?php 
                                    if($pipe_zone_type_list):
                                        foreach ($pipe_zone_type_list as $pzt => $pztype):
                                ?>
                                <option value="<?php echo $pztype->pizo_id; ?>" <?php if($apzid==$pztype->pizo_id) echo "selected=selected"; ?>> <?php echo $pztype->pizo_name; ?></option>

                        <?php
                                    endforeach;
                                endif;
                        ?>
                       </select>
                    </div>
                       <div class="col-md-3">
                        <label>Pavement Type<span class="required"></span>: </label>
                         <?php $asptypeid=!empty($assets_data[0]->asen_pavement_typeid)?$assets_data[0]->asen_pavement_typeid:''; ?>
                        <select class="form-control" name="asen_pavement_typeid">
                               <option value="">---select---</option>
                                    <?php 
                                        if($pavement_type_list):
                                            foreach ($pavement_type_list as $pt => $ptl):
                                    ?>
                                    <option value="<?php echo $ptl->paty_id; ?>" <?php if($asptypeid==$ptl->paty_id) echo "selected=selected"; ?>> <?php echo $ptl->paty_name; ?></option>

                            <?php
                                        endforeach;
                                    endif;
                            ?>
                           </select>
                    </div>
                      <div class="col-md-3">
                        <label>Solid Type<span class="required"></span>: </label>
                        <?php $asolitypeid=!empty($assets_data[0]->asen_soli_typeid)?$assets_data[0]->asen_soli_typeid:''; ?>
                      <select class="form-control" name="asen_soli_typeid">
                           <option value="">---select---</option>
                                <?php 
                                    if($soil_type_list):
                                        foreach ($soil_type_list as $st => $stype):
                                ?>
                                <option value="<?php echo $stype->soty_type; ?>" <?php if($asolitypeid==$stype->soty_id) echo "selected=selected"; ?>> <?php echo $stype->soty_type; ?></option>

                        <?php
                                    endforeach;
                                endif;
                        ?>
                       </select>
                    </div>
                     <div class="col-md-3">

                        <label>Relining Material<span class="required"></span>: </label>
                     <input type="text" class="form-control" name="asen_relin_mat" value="<?php echo  !empty($assets_data[0]->asen_relin_mat)?$assets_data[0]->asen_relin_mat:''; ?>" >
                    </div>
                      <div class="col-md-3">
                        <label>Relining Date<span class="required"></span>: </label>
                     <input type="text" class="form-control <?php echo DATEPICKER_CLASS;?>" name="asen_reline_date" id="asen_relinedate" value="<?php echo $asen_relinedate; ?>"> 
                    </div>
                    <div class="col-md-3">
                        <label>Fittings Material<span class="required"></span>: </label>
                     <input type="text" class="form-control" name="asen_fit_mat" value="<?php echo  !empty($assets_data[0]->asen_fit_mat)?$assets_data[0]->asen_fit_mat:''; ?>">
                    </div>
                     <div class="col-md-3">
                        <label>Fittings Lining (Internal)<span class="required"></span>: </label>
                     <input type="text" class="form-control" name="asen_fit_lin_internal" value="<?php echo  !empty($assets_data[0]->asen_fit_lin_internal)?$assets_data[0]->asen_fit_lin_internal:''; ?>">
                    </div>
                    <div class="col-md-3">
                        <label>Fittings Lining (External)<span class="required"></span>: </label>
                     <input type="text" class="form-control" name="asen_fit_lin_external"  value="<?php echo  !empty($assets_data[0]->asen_fit_lin_external)?$assets_data[0]->asen_fit_lin_external:''; ?>">
                    </div>
                    <div class="col-md-3">
                        <label>Fittings Class<span class="required"></span>: </label>
                     <input type="text" class="form-control" name="asen_class" value="<?php echo  !empty($assets_data[0]->asen_class)?$assets_data[0]->asen_class:''; ?>">
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

$('.select2').select2();



</script>