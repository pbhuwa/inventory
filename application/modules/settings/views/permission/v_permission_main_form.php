<form method="post" id="Formpermission" action="<?php echo base_url(); ?>/settings/permission/save_permission" class="form-material form-horizontal form" data-reloadurl="<?php echo base_url(); ?>/settings/permission/form_permission">

            <div class="pad-10">
                <div class="width_70">
                    <div class="row">
                        <div class="col-sm-3">
                            <label><?php echo $this->lang->line('groups'); ?><span class="required">*</span> :</label>
                        </div>
                        <div class="col-sm-6">
                            <select class="form-control required_field" name="grp_id" id="grp_id" required="0">
                                <option value="">---select--</option>
                                    <?php
                                    if(!empty($group_all)):
                                    foreach ($group_all as $kg => $grp):
                                    ?>
                                    <option value="<?php echo  $grp->usgr_usergroupid ?>"><?php echo $grp->usgr_usergroup; ?></option>
                                    <?php
                                    endforeach;
                                    endif; 
                                    ?>
                                </option>
                            </select>
                        </div>
                        <div class="col-sm-2" id="clonediv" style="display: none">
                            <a href="javascript:void(0)" class="view btn btn-sm btn-info" title="Clone To" id="btnClone" data-viewurl="<?php echo base_url('settings/permission/copy_permission') ?>" data-heading='Cloning From '><i class="fa fa-clone" aria-hidden="true"></i></a>
                        </div>
                    </div>



                    <div class="white-box pad-10 mtop_15 actual_form">
                    <?php 
                    $this->load->view('permission/v_permission_form_new');


                    ?>
                    </div>
                </div>

              <div class="form-group">
    <div class="col-md-12">
                <button type="submit" class="btn btn-info  save" data-operation="save" id="btnSubmit"><?php echo $this->lang->line('save'); ?></button>
    </div>

    <div class="col-sm-12">
        <div class="alert-success success"></div>
        <div class="alert-danger error"></div>
    </div>
  </div>
</form>