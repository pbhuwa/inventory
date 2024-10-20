<?php
$rpt_type=$this->input->post('rpttype');
if($rpt_type=='desc'){
?>
<label>
	Description Types
</label>
 <select name="bmin_descriptionid" id="bmin_descriptionid" class="form-control select2 rptSelected" >
                                     <option value="">All</option>
                                    <?php if($equipment_list):
                                    foreach ($equipment_list as $eql => $equip):
                                     ?>
                                     <option value="<?php echo $equip->eqli_equipmentlistid; ?>" ><?php echo $equip->eqli_description; ?></option>
                                   <?php endforeach; endif; ?>
</select>
<?php
}

if($rpt_type=='dist'){
?>
<label>
	Distributor Types
</label>
 <select name="bmin_distributorid" id="bmin_distributorid" class="form-control select2 rptSelected" >
                                          <option value="">All</option>
                                        <?php if($distributor_list):
                                        foreach ($distributor_list as $kdl => $distrubutor):?>
                                        <option value="<?php echo $distrubutor->dist_distributorid; ?>" ><?php echo $distrubutor->dist_distributor; ?></option>
                                    <?php endforeach; endif; ?> 
  </select>
<?php
}

if($rpt_type=='dept'){
?>
<label>
	Department
</label>
 <select name="bmin_departmentid" id="bmin_departmentid" class="form-control select2 rptSelected">
                                          <option value="">All</option>
                                        <?php if($dep_information):
                                        foreach ($dep_information as $kdi => $depin):?>
                                        <option value="<?php echo $depin->dept_depid; ?>" ><?php echo $depin->dept_depname; ?></option>
                                    <?php endforeach; endif; ?>
                                    </select>
<?php
}
if($rpt_type=='amc'){
?>
<label>
	AMC Types
</label>
<select name="bmin_amc" id="bmin_amc" class="form-control">
	<option value="">--select--</option>
	<option value="Y">Yes</option>
	<option value="N">No</option>
	
</select>
<?php
}

if($rpt_type=='pur_don'){
?>
<label>
	Purchase/Donate:
</label>
 <select name="bmin_purch_donatedid" id="bmin_purch_donatedid" class="form-control select2 rptSelected">
                  <option value="">All</option>
                <?php if($purchase_donate_all):
                foreach ($purchase_donate_all as $kpd => $purdo):?>
                <option value="<?php echo $purdo->pudo_purdonatedid; ?>" ><?php echo $purdo->pudo_purdonated; ?></option>
                                    <?php endforeach; endif; ?> 
  </select>
<?php
}
if($rpt_type=='assign_to'){
?>
<label>
 Assign To:
</label>
 <select name="stin_staffinfoid" id="stin_staffinfoid" class="form-control select2 rptSelected">
                  <option value="">All</option>
                <?php if($assign_to):
                foreach ($assign_to as $kpd => $assign):?>
                <option value="<?php echo $assign->stin_staffinfoid; ?>" ><?php echo $assign->stin_fname
.' '.$assign->stin_lname; ?></option>
      <?php endforeach; endif; ?> 
  </select>
<?php
}


if($rpt_type=='handover_from'){
?>
<label>
 Handover From:
</label>
 <select name="eqas_staffid" id="eqas_staffid" class="form-control select2 rptSelected">
                  <option value="">All</option>
                <?php if($handover_from):
                foreach ($handover_from as $kpd => $handfrm):?>
                <option value="<?php echo $handfrm->stin_staffinfoid; ?>" ><?php echo $handfrm->stin_fname
.' '.$handfrm->stin_lname; ?></option>
      <?php endforeach; endif; ?> 
  </select>
<?php
}

if($rpt_type=='handover_to'){
?>
<label>
 Handover To:
</label>
 <select name="eqas_handoverstaffid" id="eqas_handoverstaffid" class="form-control select2 rptSelected">
                  <option value="">All</option>
                <?php if($handover_to):
                foreach ($handover_to as $kpd => $handover_to):?>
                <option value="<?php echo $handover_to->stin_staffinfoid; ?>" ><?php echo $handover_to->stin_fname
.' '.$handover_to->stin_lname; ?></option>
      <?php endforeach; endif; ?> 
  </select>
<?php
}
if($rpt_type=='handover_by'){
?>
<label>
 Handover By:
</label>
 <select name="usma_userid" id="usma_userid" class="form-control select2 rptSelected">
                  <option value="">All</option>
                <?php if($handover_by):
                foreach ($handover_by as $khov => $hov):?>
                <option value="<?php echo $hov->usma_userid; ?>" ><?php echo $hov->usma_username; ?></option>
      <?php endforeach; endif; ?> 
  </select>
  <?php 
}
?>


<script type="text/javascript">
  $('.select2').select2();
</script>