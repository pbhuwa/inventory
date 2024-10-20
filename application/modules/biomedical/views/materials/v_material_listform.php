<form method="post" id="FormMaterial" action="<?php echo base_url('biomedical/Material_type/save_material'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('biomedical/Material_type/form_equipment'); ?>'>
    <input type="hidden" name="id" value="<?php echo!empty($eqli_data[0]->eqli_equipmentlistid)?$eqli_data[0]->eqli_equipmentlistid:'';  ?>">
    <div class="form-group">
         <div class="col-md-4">
            <label for="example-text">Equipment Type <span class="required">*</span>:
            </label>
            <?php $eqtype= !empty($eqli_data[0]->eqli_equipmenttypeid)?$eqli_data[0]->eqli_equipmenttypeid:''; ?>
            <select class="form-control" name="eqli_equipmenttypeid" autofocus="true">
                <option value="">---select----</option>
             <?php
             if($equipmnt_type): 
             foreach ($equipmnt_type as $ket => $etype):
             ?>
            <option value="<?php echo $etype->eqty_equipmenttypeid; ?>" <?php if($eqtype==$etype->eqty_equipmenttypeid) echo "selected=selected"; ?>><?php echo $etype->eqty_equipmenttype; ?></option>
         <?php endforeach; endif; ?>
         </select>
        </div>
         <div class="col-md-4">
         <label for="example-text">Equipment Description <span class="required">*</span>:
            </label>
            <input type="text"  name="eqli_description" class="form-control equdesc" placeholder="Equipment Description" value="<?php echo !empty($eqli_data[0]->eqli_description)?$eqli_data[0]->eqli_description:''; ?>" maxlength="250"  >
        </div>

        <div class="col-md-4">
            <label for="example-text">Equipment Code <span class="required">*</span>:
            </label>
               <input type="text"  name="eqli_code" class="form-control eqcode" placeholder="Code Eg: Enter BM if Bed Monitor" value="<?php echo !empty($eqli_data[0]->eqli_code)?$eqli_data[0]->eqli_code:''; ?>" maxlength="3"   >
        </div>
       
        <div class="col-md-4">
         <label for="example-text">Equipment Comment :
            </label>
             <input type="text"  name="eqli_comment" class="form-control" placeholder="Equipment Comment" value="<?php echo !empty($eqli_data[0]->eqli_comment)?$eqli_data[0]->eqli_comment:''; ?>" maxlength="250" >

        </div>
    </div>
    <?php 
        $add_edit_status=!empty($edit_status)?$edit_status:0;
        $usergroup=$this->session->userdata(USER_GROUPCODE);
        // echo $add_edit_status;
        if((empty($eqli_data)) || (!empty($eqli_data) && ($add_edit_status==1 || $usergroup=='SA') )): ?>
        <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($eqli_data)?'update':'save' ?>' id="btnDeptment" ><?php echo !empty($eqli_data)?'Update':'Save' ?></button>
          <?php
           endif; ?>
      <div  class="alert-success success"></div>
        <div class="alert-danger error"></div>

</form>

<script type="text/javascript">
    $(document).on('keyup change paste','.equdesc',function(e){
        var equipment=$(this).val();
      var action=base_url+'biomedical/equipments/get_equipments_code';
    // alert(depid);
    $.ajax({
          type: "POST",
          url: action,
          data:{equipment:equipment},
          dataType: 'json',
         success: function(datas) 
          {
            $('.eqcode').val(datas);
          }
      });
    })
</script>