<form method="post" id="FormMenu" action="<?php echo base_url('settings/menu/save_menu'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('settings/menu/form_menu'); ?>'>
    <?php $iscopy=!empty($is_copy)?$is_copy:'';
        if($iscopy!='copy'):
     ?>
<input type="hidden" name="id" value="<?php echo!empty($menu_data[0]->modu_moduleid)?$menu_data[0]->modu_moduleid:'';  ?>">
<?php endif; ?>
                                <div class="form-group resp_xs">
                                <div class="col-sm-12 col-xs-6">
                                 <label for="example-text"><?php echo $this->lang->line('parent_menu'); ?>:
                                    </label>
                                    <?php $pmenu=!empty($menu_data[0]->modu_parentmodule)?$menu_data[0]->modu_parentmodule:0; 
                                        $menu_list=$this->menu_mdl->menu_adjacency(0, $pmenu, 0, 0);
                                    ?>
                                   <select name="modu_parentmodule" class="form-control select2">
                                    <option value=''>---Select---</option>
                                     <?=$menu_list?>
                                    </select> 
                                   
                                </div>
                              <div class="col-sm-12 col-xs-6">
                                 <label for="example-text"><?php echo $this->lang->line('menu_name_unique'); ?><span class="required">*</span>:
                                    </label>
                                     <input type="text"  name="modu_modulekey" class="form-control" placeholder="<?php echo $this->lang->line('menu_name_unique'); ?>" value="<?php echo !empty($menu_data[0]->modu_modulekey)?$menu_data[0]->modu_modulekey:''; ?>" autofocus="true">

                                </div>

                                <div class="col-sm-12 col-xs-6">
                                 <label for="example-text"><?php echo $this->lang->line('display_text'); ?><span class="required">*</span> :
                                    </label>
                                     <input type="text"  name="modu_displaytext" class="form-control" placeholder="<?php echo $this->lang->line('display_text'); ?>" value="<?php echo !empty($menu_data[0]->modu_displaytext)?$menu_data[0]->modu_displaytext:''; ?>" >

                                </div>
                                 <div class="col-sm-12 col-xs-6">
                                 <label for="example-text"><?php echo $this->lang->line('display_text_np'); ?> :
                                    </label>
                                     <input type="text"  name="modu_displaytextnp" class="form-control" placeholder="<?php echo $this->lang->line('display_text_np'); ?>" value="<?php echo !empty($menu_data[0]->modu_displaytextnp)?$menu_data[0]->modu_displaytextnp:''; ?>" >

                                </div>

                                <div class="col-sm-12 col-xs-6">
                                 <label for="example-text"><?php echo $this->lang->line('menu_link'); ?><span class="required">*</span> :
                                    </label>
                                       <input type="text"  name="modu_modulelink" class="form-control" placeholder="<?php echo $this->lang->line('menu_link'); ?>" value="<?php echo !empty($menu_data[0]->modu_modulelink)?$menu_data[0]->modu_modulelink:''; ?>"  >

                                </div>
                              <div class="col-sm-12 col-xs-6">
                                 <label for="example-text"><?php echo $this->lang->line('menu_icon_class'); ?> :
                                    </label>
                                     <input type="text"  name="modu_icon" class="form-control" placeholder="<?php echo $this->lang->line('menu_icon_class'); ?>" value="<?php echo !empty($menu_data[0]->modu_icon)?$menu_data[0]->modu_icon:''; ?>">

                                </div>
                                  <div class="col-sm-12 col-xs-6">
                                 <label for="example-text"><?php echo $this->lang->line('menu_order'); ?> :
                                    </label>
                                     <input type="text"  name="modu_order" class="form-control number" placeholder="<?php echo $this->lang->line('menu_order'); ?>" value="<?php echo !empty($menu_data[0]->modu_order)?$menu_data[0]->modu_order:''; ?>">

                                </div>

                                <div class="col-sm-12 col-xs-6">
                                 <label for="example-text"><?php echo $this->lang->line('remarks'); ?> :
                                    </label>
                                    <textarea name="modu_remarks" class="form-control" value="<?php echo !empty($menu_data[0]->modu_remarks)?$menu_data[0]->modu_remarks:''; ?>" ></textarea>

                                </div>
                                <div class="col-sm-12 col-xs-6">
                                     <label for="example-text"><?php echo $this->lang->line('operation'); ?> :
                                    </label>
                                    <br>
                                    <?php
                                    $isinsert=!empty($menu_data[0]->modu_isinsert)?$menu_data[0]->modu_isinsert:'';
                                    if($isinsert=='N'){
                                        $ckhinsert='';}else{
                                        $ckhinsert='checked=checked';
                                    }

                                    $isview=!empty($menu_data[0]->modu_isview)?$menu_data[0]->modu_isview:'';
                                    if($isview=='N'){
                                    $ckhview='';
                                    }else{
                                    $ckhview='checked=checked';
                                    }

                                    $isupdate=!empty($menu_data[0]->modu_isupdate)?$menu_data[0]->modu_isupdate:'';
                                    if($isupdate=='N'){
                                    $ckhupdate='';}else{
                                    $ckhupdate='checked=checked';}

                                    $isdelete=!empty($menu_data[0]->modu_isdelete)?$menu_data[0]->modu_isdelete:'';
                                    if($isdelete=='N'){
                                    $ckhdelete='';}else{
                                    $ckhdelete='checked=checked';}

                                    $isapproved=!empty($menu_data[0]->modu_isapproved)?$menu_data[0]->modu_isapproved:'';
                                     if($isapproved=='N'){
                                    $ckhapproved='';}else{
                                    $ckhapproved='checked=checked';}

                                     $isverified=!empty($menu_data[0]->modu_isverified)?$menu_data[0]->modu_isverified:'';
                                     if($isverified=='N'){
                                    $ckhverified='';}else{
                                    $ckhverified='checked=checked';}


                                     ?>
                                    <input type="checkbox" name="modu_isinsert" value="Y" <?php echo  $ckhinsert; ?> ><?php echo $this->lang->line('insert'); ?> 
                                    <input type="checkbox" name="modu_isview" value="Y" <?php echo  $ckhview; ?>><?php echo $this->lang->line('view'); ?> 
                                    <input type="checkbox" name="modu_isupdate" value="Y" <?php echo  $ckhupdate; ?>><?php echo $this->lang->line('update'); ?> 
                                    <input type="checkbox" name="modu_isdelete" value="Y" <?php echo  $ckhdelete; ?>><?php echo $this->lang->line('delete'); ?> 
                                    <input type="checkbox" name="modu_isverified" value="Y" <?php echo  $ckhverified; ?>><?php echo $this->lang->line('verified'); ?>
                                    <input type="checkbox" name="modu_isapproved" value="Y" <?php echo  $ckhapproved; ?>><?php echo $this->lang->line('approved'); ?>  
                                    
                                    
                                </div>

                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                      
        <?php 
        $add_edit_status=!empty($edit_status)?$edit_status:0;
        $usergroup=$this->session->userdata(USER_GROUPCODE);
        // echo $add_edit_status;
        if((empty($menu_data)) || (!empty($menu_data) && ($add_edit_status==1 || $usergroup=='SA') )): ?>

        <?php
            $save_var=$this->lang->line('save');
            $update_var=$this->lang->line('update');  
        ?>
        <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($menu_data)?'update':'save' ?>' id="btnDeptment" ><?php echo !empty($menu_data)?$update_var:$save_var ; ?></button>
          <?php
           endif; ?>
                                    </div>
                                    <div class="col-sm-12">
                                        <div  class="alert-success success"></div>
                                        <div class="alert-danger error"></div>
                                    </div>
                                </div>

                                
                                <!-- <button type="reset" class="btn btn-inverse waves-effect waves-light">Reset</button> -->
                                

                            </form>