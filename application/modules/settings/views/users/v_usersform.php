<form method="post" id="FormUsers" action="<?php echo base_url('settings/users/save_users'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('settings/users/form_users'); ?>'>
    <input type="hidden" name="id" id="id" value="<?php echo !empty($user_data[0]->usma_userid) ? $user_data[0]->usma_userid : '';  ?>">
    <div class="form-group resp_xs">
        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('user_employeeid'); ?> :</label>
            <input type="text" name="usma_employeeid" class="form-control" placeholder="<?php echo $this->lang->line('user_employeeid'); ?>" value="<?php echo !empty($user_data[0]->usma_employeeid) ? $user_data[0]->usma_employeeid : ''; ?>" autofocus="true">
        </div>

        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('username'); ?> <span class="required">*</span>:</label>
            <input type="text" name="usma_username" class="form-control" placeholder="<?php echo $this->lang->line('username'); ?>" value="<?php echo !empty($user_data[0]->usma_username) ? $user_data[0]->usma_username : ''; ?>" autofocus="true">
        </div>
        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('email'); ?>:</label>
            <input type="email" name="usma_email" class="form-control" placeholder="<?php echo $this->lang->line('email'); ?>" value="<?php echo !empty($user_data[0]->usma_email) ? $user_data[0]->usma_email : ''; ?>">
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="form-group resp_xs">
        <?php if (!empty($user_data)) : ?>
            <div class="col-sm-6 col-xs-6">
                <label for="example-text"><?php echo $this->lang->line('password'); ?>Password:</label><br>
                <span id="change_password">******<a href="javascript:void(0);" class="pull-right font_12" id="chang_pass">Change Password</a></span>
                <span id="ChangeResponse"></span>
            </div>
        <?php else : ?>
            <div class="col-sm-6 col-xs-6">
                <label for="example-text"><?php echo $this->lang->line('password'); ?> <span class="required">*</span>:</label>
                <input type="password" name="usma_userpassword" class="form-control" placeholder="<?php echo $this->lang->line('password'); ?> " value="<?php echo !empty($user_data[0]->usma_userpassword) ? $user_data[0]->usma_userpassword : ''; ?>">
            </div>

            <div class="col-sm-6 col-xs-6">
                <label for="example-text"><?php echo $this->lang->line('confirm_password'); ?><span class="required">*</span> :</label>
                <input type="password" name="usma_conformpassword" class="form-control" placeholder="<?php echo $this->lang->line('confirm_password'); ?>" value="<?php echo !empty($user_data[0]->usma_userpassword) ? $user_data[0]->usma_userpassword : ''; ?>">
            </div>
        <?php endif; ?>
    </div>

    <div class="form-group resp_xs">
        <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('full_name'); ?>:</label>
            <input type="text" name="usma_fullname" class="form-control" placeholder="<?php echo $this->lang->line('full_name'); ?>" value="<?php echo !empty($user_data[0]->usma_fullname) ? $user_data[0]->usma_fullname : ''; ?>">
        </div>

        <!--  <div class="col-sm-6 col-xs-6">
            <label for="example-text"><?php //echo $this->lang->line('designation'); 
                                        ?> :</label><br>
            <select name="usma_usertype" class="form-control usertype">
                <option value="Accountant">Accountant</option>
                <option value="Manager">Manager</option>
                <option value="Others" selected="selected">Others</option>
            </select>
        </div> -->

        <div class="col-md-6">
            <?php $desiid = !empty($user_data[0]->usma_desiid) ? $user_data[0]->usma_desiid : ''; ?>
            <label for="example-text"><?php echo $this->lang->line('designation'); ?> <span class="required">*</span>:</label>
            <div class="dis_tab">



                <select name="usma_desiid" class="form-control select2" id="usma_desiid">
                    <option value="">---select---</option>
                    <?php
                    if ($designation) :
                        foreach ($designation as $km => $desi) :
                    ?>
                            <option value="<?php echo $desi->desi_designationid; ?>" <?php if ($desiid == $desi->desi_designationid) echo "selected=selected"; ?>><?php echo $desi->desi_designationname; ?></option>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </select>

                <a href="javascript:void(0)" class="table-cell frm_add_btn width_30 refresh_designation" data-targetid='usma_desiid' data-viewurl='<?php echo base_url('biomedical/equipments/designation_reload/'); ?>'><i class="fa fa-refresh"></i></a>


                <a href="javascript:void(0)" class="table-cell frm_add_btn width_30 view" data-viewurl='<?php echo base_url('settings/designation/designation_popup/'); ?>' data-heading=" Designation Entry"><i class="fa fa-plus"></i></a>
            </div>
        </div>

        <div class="col-sm-6 col-xs-6">
            <div id="doctorDiv" style="display: none">
                <label><?php echo $this->lang->line('doctor'); ?>:</label>
                <select name="usma_doctorid" class="form-control">
                    <?php
                    if ($doctor_list) :
                        foreach ($doctor_list as $kd => $doc) :
                    ?>
                            <option value="<?php echo $doc->dose_docid; ?>"><?php echo $doc->dose_docname; ?></option>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </select>
            </div>

            <div id="nurseDiv" style="display: none">
                <label><?php echo $this->lang->line('nurse'); ?>:</label>
                <select name="usma_doctorid" class="form-control">
                </select>
            </div>

            <div id="otherDiv">
                <?php $phoneno = !empty($user_data[0]->usma_phoneno) ? $user_data[0]->usma_phoneno : ''; ?>
                <label><?php echo $this->lang->line('phone_no'); ?></label>
                <input type="text" name="usma_phoneno" class="form-control number " value="<?php echo $phoneno; ?>">
            </div>
        </div>

        <div class="col-sm-6 col-xs-6">
            <label><?php echo $this->lang->line('user_group'); ?> <span class="required">*</span>:</label>
            <select class="form-control select2 groupbtn" name="usma_usergroupid" id="group_id">
                <?php
                $ugroup = !empty($user_data[0]->usma_usergroupid) ? $user_data[0]->usma_usergroupid : '';
                ?>
                <option value="">---Select---</option>
                <?php
                // echo "<pre>";
                // print_r($group_all);
                // die();
                if (!empty($group_all)) :
                    foreach ($group_all as $kd => $group) :
                        $isallloc = $group->usgr_isalllocation;
                        if ($isallloc == 'Y') {
                            $locnam = '';
                        } else {
                            $locnam = $group->loca_name;
                        }
                ?>
                        <option value="<?php echo $group->usgr_usergroupid; ?>" <?php if ($ugroup == $group->usgr_usergroupid) echo "selected=selected"; ?>><?php echo $group->usgr_usergroup . ' | ' . $locnam; ?></option>
                <?php
                    endforeach;
                endif;
                ?>
            </select>
        </div>
        <?php $accountlvl = !empty($user_data[0]->usma_accountlvl) ? $user_data[0]->usma_accountlvl : '';
        if (!empty($accountlvl)) :
        ?>
            <div id="datediv" class="col-sm-6 col-xs-6">
            <?php else : ?>
                <div id="datediv" class="col-sm-6 col-xs-6" style="display: none">
                <?php endif; ?>

                <label>Account Level</label>
                <input type="text" name="usma_accountlvl" class="form-control number " value="<?php echo $accountlvl; ?>">
                </div>
            </div>
            <?php
            if ($this->location_ismain == 'Y') : ?>
                <div class="form-group resp_xs">
                    <div class="col-sm-12 col-xs-12">
                        <label><?php echo $this->lang->line('location'); ?>:</label>
                        <?php
                        $locationid = !empty($user_data[0]->usma_locationid) ? $user_data[0]->usma_locationid : $this->locationid;
                        ?>
                        <select class="form-control select2" name="usma_locationid">
                            <?php
                            if ($location_all) :
                                foreach ($location_all as $km => $loca) :
                            ?>
                                    <option value="<?php echo $loca->loca_locationid; ?>" <?php if ($locationid == $loca->loca_locationid) echo "selected=selected"; ?>><?php echo $loca->loca_name ?></option>
                            <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>
                </div>
            <?php endif; ?>

            <div class="form-group resp_xs">
                <div class="col-sm-12 col-xs-12">
                    <label for="example-text"><?php echo $this->lang->line('signature'); ?> : </label>
                    <div class="dis_tab">
                        <input type="file" name="usma_signaturepath" class="form-control">
                        <?php if (!empty($user_data[0]->usma_signaturepath)) : ?>
                            <input type="hidden" name="usma_oldsignaturepath" value="<?php echo $user_data[0]->usma_signaturepath ?>">
                            <a href="<?php echo base_url(SIGNATURE_UPLOAD_PATH) . '/' . $user_data[0]->usma_signaturepath; ?>" target="_blank" class="table-cell frm_add_btn width_30" title="Download"><i class="fa fa-download"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="form-group resp_xs">
                <div class="col-sm-12 col-xs-12">
                    <label><?php echo $this->lang->line('department'); ?>
                        <!-- span class="required">*</span> : -->
                    </label>
                    <?php
                    $deptmnt = !empty($user_data[0]->usma_departmentid) ? $user_data[0]->usma_departmentid : '';
                    $depid = explode(',', $deptmnt);
                    ?>
                    <select class="form-control select2 custom_select2" name="usma_departmentid[]" multiple="multiple" style="height: auto;width: 100%;">
                        <?php
                        if ($department_all) :
                            foreach ($department_all as $kd => $dep) :
                        ?>
                                <option value="<?php echo $dep->dept_depid; ?>" <?php if (in_array($dep->dept_depid, $depid)) echo "selected=selected"; ?>><?php echo $dep->dept_depname; ?></option>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>
            </div>
            <?php
            if (ORGANIZATION_NAME == 'KUKL') {
            ?>
                <div class="form-group resp_xs">
                    <div class="col-sm-12 col-xs-12">
                        <label><?php echo $this->lang->line('select_approval'); ?>:</label>
                        <?php
                        $desiid = !empty($user_data[0]->usma_appdesiid) ? $user_data[0]->usma_appdesiid : '';
                        $designationid = explode(',', $desiid);
                        ?>
                        <select class="form-control select2 custom_select2" name="usma_appdesiid[]" multiple="multiple" style="height: auto;width: 100%;" id="usma_appdesiid">
                            <?php
                            if ($designation) :
                                foreach ($designation as $kd => $desi) :
                            ?>
                                    <option value="<?php echo $desi->desi_designationid; ?>" <?php if (in_array($desi->desi_designationid, $designationid)) echo "selected=selected"; ?>><?php echo $desi->desi_designationname; ?></option>
                            <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>
                </div>
            <?php
            }
            ?>

            <div class="clearfix"></div>
            <?php
            $add_edit_status = !empty($edit_status) ? $edit_status : 0;
            $usergroup = $this->session->userdata(USER_GROUPCODE);
            // echo $add_edit_status;
            if ((empty($user_data)) || (!empty($user_data) && ($add_edit_status == 1 || $usergroup == 'SA'))) :
            ?>
                <?php
                $save_var = $this->lang->line('save');
                $update_var = $this->lang->line('update');
                ?>
                <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($user_data) ? 'update' : 'save' ?>' id="btnDeptment"><?php echo !empty($user_data) ? $update_var : $save_var; ?></button>
            <?php
            endif;
            ?>

            <div class="alert-success success"></div>
            <div class="alert-danger error"></div>
</form>

<script type="text/javascript">
    $('.select2').select2();
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#group_id').on('change', function() {
            var accounlvl = $(this).val();
            // alert(groupname);
            if (accounlvl == '16') {

                $('#datediv').show();
            } else {
                $('#datediv').hide();
            }
        });
    });
</script>