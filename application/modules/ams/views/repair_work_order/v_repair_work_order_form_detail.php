<?php

if(!empty($repair_details)):
    $i=1;
    foreach ($repair_details as $key => $detail):
?>
 <tr class="orderrow" id="orderrow_<?=$i?>" data-id="<?=$i?>">
<input type="hidden" name="request_detail_id[]" value="<?php echo !empty($detail->rerd_repairrequestdetailid) ? $detail->rerd_repairrequestdetailid : ''; ?>">

  <td data-label="S.No.">
     <input type="text" class="form-control sno" id="s_no_<?=$i?>" value="<?=$i?>" readonly/>
  </td>

  <td data-label="Code">
     <div class="dis_tab"> 
        <input type="text" class="form-control assetscode enterinput" id="assetscode_<?=$i?>" name="assets_code[]"  data-id="<?=$i?>" data-targetbtn='view' value="<?php echo !empty($detail->rerd_assetcode)?$detail->rerd_assetcode:''; ?>">
        <input type="hidden" class="assetsid" name="asdd_assetid[]" data-id="<?=$i?>" value="<?php echo !empty($detail->rerd_assetsid)?$detail->rerd_assetsid:''; ?>" id="assetsid_<?=$i?>">
        <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading='<?php echo $this->lang->line('list_of_items'); ?>' data-viewurl='<?php echo base_url('/ams/assets/list_of_assets_popup'); ?>' data-id="<?=$i?>" id="view_<?=$i?>"><strong>...</strong></a>&nbsp;
     </div>
  </td>

  <td data-label="Description">  
     <input type="text" class="form-control assets_desc"  id="assets_desc_<?=$i?>" name="assets_desc[]"  data-id="<?=$i?>" value="<?php echo !empty($detail->rerd_assetsdesc)?$detail->rerd_assetsdesc:''; ?>" readonly> 
  </td>

  <td data-label="Problem"> 
     <input type="text" class="form-control required_field  problem jump_to_add " id="problem_<?=$i?>" name="problem[]"  data-id="<?=$i?>" value="<?php echo !empty($detail->rerd_problem)?$detail->rerd_problem:''; ?>"> 
  </td>

  <td data-label="Estimate cost"> 
     <input type="text" class="form-control required_field  estimated_cost float" id="estimated_cost_<?=$i?>" name="estimated_cost[]"  data-id="<?=$i?>" value="<?php echo !empty($detail->rerd_estimateamt)?$detail->rerd_estimateamt:''; ?>"> 
  </td>

  <td data-label="Prev Repair Cnt"> 
     <input type="text" class="form-control float" id="prev_cnt_<?=$i?>" name="prev_cnt[]"  data-id="<?=$i?>" value="<?php echo !empty($detail->test)?$detail->test:''; ?>"> 
  </td>

  <td data-label="Prev Repair Cost"> 
     <input type="text" class="form-control float" id="prev_cost_<?=$i?>" name="prev_cost[]"  data-id="<?=$i?>" value="<?php echo !empty($detail->test)?$detail->test:''; ?>"> 
  </td>
  <td data-label="Prev Repair Date (B.S)"> 
     <input type="text" class="form-control" id="prev_repair_datebs_<?=$i?>" name="prev_repair_datebs[]"  data-id="<?=$i?>" value="<?php echo !empty($detail->test)?$detail->test:''; ?>"> 
  </td>
  <td data-label="Prev Repair Date (A.D)"> 
     <input type="text" class="form-control" id="prev_repair_datead_<?=$i?>" name="prev_repair_datead[]"  data-id="<?=$i?>" value="<?php echo !empty($detail->test)?$detail->test:''; ?>"> 
  </td>
  <td data-label="Remarks"> 
     <input type="text" class="form-control remarks" id="remarks_<?=$i?>" name="remarks[]"  data-id="<?=$i?>" value="<?php echo !empty($detail->rerd_remark)?$detail->rerd_remark:''; ?>"> 
  </td>
  <td data-label="Action">
    
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


