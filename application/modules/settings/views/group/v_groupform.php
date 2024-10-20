<form method="post" id="FormGroup" action="<?php echo base_url('settings/group/save_group'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('settings/group/form_group'); ?>' >
<input type="hidden" name="id" value="<?php echo !empty($group_data[0]->usgr_usergroupid)?$group_data[0]->usgr_usergroupid:''; ?>">
                                
<div class="form-group resp_xs">
<div class="col-sm-12 col-xs-6">
 <label for="example-text"><?php echo $this->lang->line('group_name'); ?> <span class="required">*</span>:
    </label>
   <input type="text" id="example-text" name="usgr_usergroup" class="form-control" placeholder="<?php echo $this->lang->line('group_name'); ?>" value="<?php echo !empty($group_data[0]->usgr_usergroup)?$group_data[0]->usgr_usergroup:''; ?>"  autofocus="true"  >

</div>
<div class="col-sm-12 col-xs-6">
 <label for="example-text"><?php echo $this->lang->line('usgr_usergroupcode'); ?>:
    </label>
   <input type="text" id="example-text" name="usgr_usergroupcode" class="form-control" placeholder="<?php echo $this->lang->line('usgr_usergroupcode'); ?>" value="<?php echo !empty($group_data[0]->usgr_usergroupcode)?$group_data[0]->usgr_usergroupcode:''; ?>"  autofocus="true"  >

</div>
<?php $softwaretype= !empty($group_data[0]->usgr_accesstypes)?$group_data[0]->usgr_accesstypes:''; ?>
<div class="col-sm-12 col-xs-6">
    <label for="example-text"><?php echo $this->lang->line('software_access_type'); ?> <span class="required">*</span>:
    </label>
    <select class="form-control" name="usgr_accesstypes" id='accesstype'>
        <option value="S" <?php if($softwaretype=='S') echo "selected=selected"; ?>>Single</option>
       <!--  <option value="B"  <?php if($softwaretype=='B') echo "selected=selected"; ?>>Both</option> -->
    </select>
</div>

    <div class="col-sm-12 col-xs-6"  id="softwareid">
         <label for="example-text"><?php echo $this->lang->line('software'); ?> <span class="required">*</span>:
        </label>
        <?php $accesssystemid= !empty($group_data[0]->usgr_accesssystemid)?$group_data[0]->usgr_accesssystemid:''; ?>
        <select class="form-control" name="usgr_accesssystemid">
           <?php
           if($org_list):
            foreach ($org_list as $kl => $org):
            ?>
            <option value="<?php echo $org->orga_orgid; ?>" <?php if($accesssystemid==$org->orga_orgid) echo "selected=selected"; ?>><?php echo $org->orga_software; ?></option>

            <?php
        endforeach;
           endif; 
           ?>
        </select>
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
   
    <div class="col-sm-12 col-xs-6 resp_xs no-margin">
        <?php 
            $db_dashboard=!empty($group_data[0]->usgr_dashboard)?$group_data[0]->usgr_dashboard:'';
            $db_dashboardid=explode(',',$db_dashboard );
        ?>
        <label><?php echo $this->lang->line('Dashboard'); ?>:</label><br>
        <div class=" dashboard-form">
            <div class="row">
                <?php 
                    if(!empty($dashboard_all)):
                        foreach ($dashboard_all as $kdas => $das):
                ?>
                <div class="col-sm-4"><input type="checkbox" name="dashboard[]" value="<?php echo $das->dash_id; ?>" <?php if(in_array($das->dash_id,$db_dashboardid) )echo "checked=checked"; ?>>
                    <?php echo $das->dash_name; ?>
                </div>
                <?php 
                        endforeach; 
                    endif; 
                ?>
            </div>
        </div>
    </div>


    <div class="col-sm-12 col-xs-6">
     <label for="example-text"><?php echo $this->lang->line('remarks'); ?> :
        </label>
       <textarea name="usgr_remarks" class="form-control" value="" ><?php echo !empty($group_data[0]->usgr_remarks)?$group_data[0]->usgr_remarks:''; ?></textarea> 
    </div>
    <div class="col-md-4">

    </div>

</div>

        <?php 
        $add_edit_status=!empty($edit_status)?$edit_status:0;
        $usergroup=$this->session->userdata(USER_GROUPCODE);
        // echo $add_edit_status;
        if((empty($group_data)) || (!empty($group_data) && ($add_edit_status==1 || $usergroup=='SA') )): ?>

        <?php
            $save_var=$this->lang->line('save');
            $update_var=$this->lang->line('update');

        ?>
        <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($group_data)?'update':'save' ?>' id="btnDeptment" ><?php echo !empty($group_data)?$update_var:$save_var ; ?></button>
          <?php
           endif; ?>

<div  class="alert-success success"></div>
<div class="alert-danger error"></div>

</form>

        <script type="text/javascript">
            $(document).on('change','#accesstype',function(){
                var accessid=$(this).val();
                // alert(accessid);
                // return false;
                if(accessid=='B')
                {
                    $('#softwareid').hide();
                }
                else
                {
                    $('#softwareid').show();
                }
            })

           
        </script>

    <?php
    if(!empty($group_data)):
        ?>
        <script type="text/javascript">
             var softwaretype='<?php echo !empty($softwaretype)?$softwaretype:''; ?>';
            if(softwaretype=='B')
            {
                $('#accesstype').change();
            }
        </script>
        <?php
    endif;
     ?>