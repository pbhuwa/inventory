<form method="post" id="FormEquipment" action="<?php echo base_url('biomedical/equipments/save_equipment_cat'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('biomedical/equipments/form_equipment_category'); ?>'>
    <input type="hidden" name="id" value="<?php echo!empty($eqli_data[0]->eqca_equipmentcategoryid)?$eqli_data[0]->eqca_equipmentcategoryid:'';  ?>">
    <div class="form-group">
         <div class="col-md-4">
            <label for="example-text">Store <span class="required">*</span>:
            </label>
            <?php
            $orgid= $this->session->userdata(ORG_ID);
             ?>
            <?php 
            $eqtypeid= !empty($eqli_data[0]->eqca_equiptypeid)?$eqli_data[0]->eqca_equiptypeid:''; 
            // echo $eqtype;
            // die();
            ?>
            <select class="form-control" name="eqca_equiptypeid" autofocus="true" >
             <?php
             if($equipmnt_type): 
             foreach ($equipmnt_type as $ket => $etypes):
             ?>
            <option value="<?php echo $etypes->eqty_equipmenttypeid; ?>" <?php if($eqtypeid==$etypes->eqty_equipmenttypeid || count($equipmnt_type) == 1) echo "selected=selected"; ?>><?php echo $etypes->eqty_equipmenttype; ?></option>
         <?php endforeach; endif; ?>
         </select>
        </div>
        <div class="clearfix"></div>

         <div class="col-md-6">
            <label for="example-text"><?php echo $this->lang->line('parent_category'); ?> :
            </label>
            <?php $e_cat= !empty($eqli_data[0]->eqca_parentcategoryid)?$eqli_data[0]->eqca_parentcategoryid:''; ?>
            <select class="form-control" name="eqca_parentcategoryid" autofocus="true">
                <option value="">---select----</option>
             <?php
             if($equipmnt_category): 
             foreach ($equipmnt_category as $kc => $cat):
             ?>
            <option value="<?php echo $cat->eqca_equipmentcategoryid; ?>" <?php if($e_cat==$cat->eqca_equipmentcategoryid) echo "selected=selected"; ?>><?php echo $cat->eqca_category; ?></option>
         <?php endforeach; endif; ?>
         </select>
        </div>



         <div class="col-md-6">
         <label for="example-text"><?php echo $this->lang->line('category'); ?><span class="required">*</span>:
            </label>
            <input type="text"  name="eqca_category" class="form-control equdesc" placeholder="Category" value="<?php echo !empty($eqli_data[0]->eqca_category)?$eqli_data[0]->eqca_category:''; ?>" maxlength="250"  >
        </div>

        <div class="col-md-6">
            <label for="example-text"><?php echo $this->lang->line('code'); ?> <span class="required">*</span>:
            </label>
               <input type="text"  name="eqca_code" class="form-control eqcode" placeholder=" Eg: Enter PAS if Printing And Stationery" value="<?php echo !empty($eqli_data[0]->eqca_code)?$eqli_data[0]->eqca_code:''; ?>" maxlength="5"   >
        </div>
        <div class="col-md-6">
            <label for="example-text">Manual Code :
            </label>
               <input type="text"  name="eqca_code_manual" class="form-control" placeholder="Eg. 1,2,3,4" value="<?php echo !empty($eqli_data[0]->eqca_code_manual)?$eqli_data[0]->eqca_code_manual:''; ?>" maxlength="5"   >
        </div>
     <!--   <div class="col-md-4">
            <label for="example-text">Is IT Department? :
            </label>
            <br>
            <?php $isitdep=!empty($eqli_data[0]->eqca_isitdep)?$eqli_data[0]->eqca_isitdep:'N'; ?>

               <input type="checkbox"  name="eqca_isitdep"  value="Y" <?php if($isitdep=='Y') echo 'checked=checked'; else echo "";; ?>  >
        </div>

         <div class="col-md-4">
            <label for="example-text">Is Non Exp? :
            </label>
            <br>
            <?php $isnonexp=!empty($eqli_data[0]->eqca_isnonexp)?$eqli_data[0]->eqca_isnonexp:'N'; ?>

               <input type="checkbox"  name="eqca_isnonexp"  value="Y" <?php if($isnonexp=='Y') echo 'checked=checked'; else echo "";; ?>  >
        </div> -->

        <div class="col-md-2">
             <?php $isactive=!empty($eqli_data[0]->eqca_isactive)?$eqli_data[0]->eqca_isactive:''; ?>
            <label>Is Active ?:</label>
            <select name="eqca_isactive" class="form-control">
                <option value="Y" >Yes</option>
                <option value="N" <?php if($isactive=='N') echo "selected=selected"; ?>>No</option>
            </select>
        </div>
        
    </div>
    <?php 
        $add_edit_status=!empty($edit_status)?$edit_status:0;
        $usergroup=$this->session->userdata(USER_GROUPCODE);
        // echo $add_edit_status;
        if((empty($eqli_data)) || (!empty($eqli_data) && ($add_edit_status==1 || $usergroup=='SA') )): ?>

        <?php
            $save_var=$this->lang->line('save');
            $update_var=$this->lang->line('update');  
        ?>

        <button type="submit" class="btn btn-info  <?php echo !empty($savelist)?$savelist:'save'?>" data-operation='<?php echo !empty($eqli_data)?'update':'save' ?>' id="btnDeptment" ><?php echo !empty($eqli_data)?$update_var:$save_var ; ?></button>
          <?php
           endif; ?>
      <div  class="alert-success success"></div>
        <div class="alert-danger error"></div>

</form>

<script type="text/javascript">
    $(document).on('keyup change paste','.equdesc',function(e){
        var equipment=$(this).val();
      var action=base_url+'biomedical/equipments/get_category_code';
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