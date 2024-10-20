<form method="post" id="FormGroup" action="<?php echo base_url('settings/group/save_group_clone'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('settings/group/form_group'); ?>' >
<input type="hidden" name="groupid" value="<?php echo !empty($group_id)?$group_id:'';  ?>">
                                
<div class="form-group resp_xs">
<div class="col-sm-12 col-xs-6">
 <label for="example-text"><?php echo $this->lang->line('group_name'); ?> <span class="required">*</span>:
    </label>
   <input type="text" id="example-text" name="usgr_usergroup" class="form-control required_field" placeholder="Group Name" value=""  autofocus="true"  >

</div>
<div class="col-sm-12 col-xs-6">
 <label for="example-text"><?php echo $this->lang->line('usgr_usergroupcode'); ?>:
    </label>
   <input type="text" id="example-text" name="usgr_usergroupcode" class="form-control" placeholder="User Group Code" value=""  autofocus="true"  >

</div>
        <?php 
            $db_location=!empty($group_data[0]->usgr_locationid)?$group_data[0]->usgr_locationid:'';
            $sel_locationid=!empty($db_location)?$db_location:$current_location;
            if($location_ismain=='Y'): ?>
            <div class="col-sm-12 col-xs-6">
                <label><?php echo $this->lang->line('location'); ?>:</label>
            <select class="form-control select2" name="usgr_locationid">
            <?php   
            if($location_all):
                foreach ($location_all as $km => $loca):
                ?>
                <option value="<?php echo $loca->loca_locationid; ?>" <?php if($sel_locationid==$loca->loca_locationid) echo "selected=selected"; ?>><?php echo $loca->loca_name ?></option>
                <?php
                endforeach;
                endif;
            ?>
           </select>
        </div>
<?php endif; ?>
   

    <div class="col-sm-12 col-xs-6">
     <label for="example-text"><?php echo $this->lang->line('remarks'); ?> :
        </label>
       <textarea name="usgr_remarks" class="form-control" value="" ></textarea> 
    </div>
</div>

    
        <?php
            $save_var=$this->lang->line('save');
            $update_var=$this->lang->line('update');

        ?>
        <button type="submit" class="btn btn-info  savelist" data-operation='save' data-isdismiss='Y' id="btnSaveClone" ><?php echo $save_var ; ?></button>

<div  class="alert-success success"></div>
<div class="alert-danger error"></div>

</form>

  

  