<div class="white-box pad-5">
    <div class="list_c2 label_mw125">
       <div class="list_c2 label_mw125">
            <div class="form-group row resp_xs">
                <div class="col-md-12 col-xs-12">
                    <table class="table table-border table-striped table-site-detail dataTable" id="Dttable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo $this->lang->line('item_code'); ?></th>
                                <th><?php echo $this->lang->line('item_name'); ?></th>
                                <th><?php echo $this->lang->line('mobile_no'); ?></th>
                                <th><?php echo $this->lang->line('phone_no'); ?></th>
                                <th><?php echo $this->lang->line('email'); ?></th>
                                <th><?php echo $this->lang->line('department'); ?></th>
                                <th><?php echo $this->lang->line('room'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($same_department_staff_list):
                                foreach ($same_department_staff_list as $sdep => $depstaff):
                                ?>
                            <tr>
                                <td>
                                    <input type="checkbox"  class="check_class" data-depid="<?php echo $depstaff->stin_departmentid ?>" data-romid="<?php echo $depstaff->stin_roomid; ?>" data-staffid="<?php echo $depstaff->stin_staffinfoid; ?>" data-staffcode="<?php echo $depstaff->stin_code; ?>" data-staffname="<?php echo $depstaff->stin_fname.' '.$depstaff->stin_lname; ?>" >
                                </td>
                                <td><?php echo $depstaff->stin_code; ?></td>
                                <td><?php echo $depstaff->stin_fname.' '.$depstaff->stin_lname; ?></td>
                                <td><?php echo $depstaff->stin_mobile; ?></td>
                                <td><?php echo $depstaff->stin_phone; ?></td>
                                <td><?php echo $depstaff->stin_email; ?></td>
                                <td><?php echo $depstaff->dept_depname; ?></td>
                                <td><?php echo $depstaff->rode_roomname; ?></td>
                            </tr>
                            <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="white-box pad-5">
    <div class="list_c2 label_mw125">
       <div class="list_c2 label_mw125">
            <div class="form-group row resp_xs">
                <div class="col-md-12 col-xs-12">
                    <table class="table table-border table-striped table-site-detail dataTable" id="Dttable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo $this->lang->line('item_code'); ?></th>
                                <th><?php echo $this->lang->line('item_name'); ?></th>
                                <th><?php echo $this->lang->line('mobile_no'); ?></th>
                                <th><?php echo $this->lang->line('phone_no'); ?></th>
                                <th><?php echo $this->lang->line('email'); ?></th>
                                <th><?php echo $this->lang->line('department'); ?></th>
                                <th><?php echo $this->lang->line('room'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($same_department_staff_list):
                                foreach ($same_department_staff_list as $sdep => $depstaff):
                                ?>
                            <tr>
                                <td>
                                    <input type="checkbox"  class="check_class" data-depid="<?php echo $depstaff->stin_departmentid ?>" data-romid="<?php echo $depstaff->stin_roomid; ?>" data-staffid="<?php echo $depstaff->stin_staffinfoid; ?>" data-staffcode="<?php echo $depstaff->stin_code; ?>" data-staffname="<?php echo $depstaff->stin_fname.' '.$depstaff->stin_lname; ?>" >
                                </td>
                                <td><?php echo $depstaff->stin_code; ?></td>
                                <td><?php echo $depstaff->stin_fname.' '.$depstaff->stin_lname; ?></td>
                                <td><?php echo $depstaff->stin_mobile; ?></td>
                                <td><?php echo $depstaff->stin_phone; ?></td>
                                <td><?php echo $depstaff->stin_email; ?></td>
                                <td><?php echo $depstaff->dept_depname; ?></td>
                                <td><?php echo $depstaff->rode_roomname; ?></td>
                            </tr>
                            <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>