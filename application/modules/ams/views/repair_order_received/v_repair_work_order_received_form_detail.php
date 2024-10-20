<?php

if(!empty($work_order_details)):
    $i=1;
    foreach ($work_order_details as $key => $detail):
?>
 <tr class="orderrow" id="orderrow_<?=$i?>" data-id="<?=$i?>">
<input type="hidden" name="request_detail_id[]" value="<?php echo !empty($detail->rewd_repairorderdetailid) ? $detail->rewd_repairorderdetailid : ''; ?>">

  <td data-label="S.No.">
     <input type="text" class="form-control sno" id="s_no_<?=$i?>" value="<?=$i?>" readonly/>
  </td>

  <td data-label="Code">
     <div class="dis_tab"> 
        <input type="text" class="form-control assetscode enterinput" id="assetscode_<?=$i?>" name="assets_code[]"  data-id="<?=$i?>" data-targetbtn='view' value="<?php echo !empty($detail->rewd_assetcode)?$detail->rewd_assetcode:''; ?>">
        <input type="hidden" class="assetsid" name="asdd_assetid[]" data-id="<?=$i?>" value="<?php echo !empty($detail->rewd_assetsid)?$detail->rewd_assetsid:''; ?>" id="assetsid_<?=$i?>">
     </div>
  </td>

  <td data-label="Description">  
     <input type="text" class="form-control assets_desc"  id="assets_desc_<?=$i?>" name="assets_desc[]"  data-id="<?=$i?>" value="<?php echo !empty($detail->rewd_assetsdesc)?$detail->rewd_assetsdesc:''; ?>" readonly> 
  </td>

  <td data-label="Problem"> 
     <input type="text" class="form-control required_field  problem jump_to_add " id="problem_<?=$i?>" name="problem[]"  data-id="<?=$i?>" value="<?php echo !empty($detail->rewd_problem)?$detail->rewd_problem:''; ?>"> 
  </td>

  <td data-label="Rate"> 
     <input type="text" class="form-control required_field  estimated_cost float" id="estimated_cost_<?=$i?>" name="estimated_cost[]"  data-id="<?=$i?>" value="<?php echo !empty($detail->rewd_estimated_cost)?$detail->rewd_estimated_cost:''; ?>"> 
  </td>

  <td data-label="Prev Repair Cnt"> 
     <input type="text" class="form-control float" id="prev_cnt_<?=$i?>" name="prev_cnt[]"  data-id="<?=$i?>" value="<?php echo !empty($detail->rewd_prevrepaircount)?$detail->rewd_prevrepaircount:''; ?>"> 
  </td>

  <td data-label="Prev Repair Cost"> 
     <input type="text" class="form-control float" id="prev_cost_<?=$i?>" name="prev_cost[]"  data-id="<?=$i?>" value="<?php echo !empty($detail->rewd_prevrepaircost)?$detail->rewd_prevrepaircost:''; ?>"> 
  </td>
  <td data-label="Prev Repair Date (B.S)"> 
     <input type="text" class="form-control" id="prev_repair_datebs_<?=$i?>" name="prev_repair_datebs[]"  data-id="<?=$i?>" value="<?php echo !empty($detail->rewd_prerepairdatebs)?$detail->rewd_prerepairdatebs:''; ?>"> 
  </td>
  <td data-label="Prev Repair Date (A.D)"> 
     <input type="text" class="form-control" id="prev_repair_datead_<?=$i?>" name="prev_repair_datead[]"  data-id="<?=$i?>" value="<?php echo !empty($detail->rewd_prevrepairdatead)?$detail->rewd_prevrepairdatead:''; ?>"> 
  </td>
  <td data-label="Remarks"> 
     <input type="text" class="form-control remarks" id="remarks_<?=$i?>" name="remarks[]"  data-id="<?=$i?>" value="<?php echo !empty($detail->rewd_remarks)?$detail->rewd_remarks:''; ?>"> 
  </td>
  
</tr>
<?php
    $i++;
    endforeach;
    endif;
?>

<script>
    $('.nepdatepicker').nepaliDatePicker({
          npdMonth: true,
          npdYear: true,
});
</script>

