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

 if($rpt_type=='manual'){
?>
<label>
	<span>Manual</span>
</label>
<br>

<input type="checkbox" name="bmin_isoperation" id="bmin_isoperation" value="Y" class="rptChecked">
<label for="bmin_isoperation">Operation </label>

<input type="checkbox" name="bmin_ismaintenance" id="bmin_ismaintenance" value="Y" class="rptChecked">
<label for="bmin_ismaintenance">Maintenance</label>

<?php
}

 ?>

