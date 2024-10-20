<div class="table-responsive">
    <table id="Dtable" class="table table-striped" >
        <thead>
            <tr>
                <th><?php echo $this->lang->line('group_id'); ?></th>
                <th><?php echo $this->lang->line('group_name'); ?></th>
                <!-- <th>Work Order</th> -->
                <th><?php echo $this->lang->line('software_access_type'); ?></th>
                <th><?php echo $this->lang->line('location'); ?> </th>
                <th><?php echo $this->lang->line('remarks'); ?></th>
                <th><?php echo $this->lang->line('post_date'); ?></th>
                <th><?php echo $this->lang->line('action'); ?></th>
            </tr>
        </thead>
        <tbody>

            <?php
            $module_edit = MODULES_UPDATE;
            $module_delete = MODULES_DELETE;
            $showview= MODULES_VIEW;
            if($showview=='N')
            {
                ?>
                <td></td>
                <td colspan="2" style="text-align:center">Permission Denial</td>
                <td></td>
                <td></td>
                <?php 
            } 
            else {
                if($group_all):
                    foreach ($group_all as $km => $group):
                        ?>
                        <tr id="listid_<?php echo $group->usgr_usergroupid; ?>">
                            <td><?php echo !empty($group->usgr_usergroupid)?$group->usgr_usergroupid:'----'; ?></td>
                            <td><?php echo $group->usgr_usergroup; ?></td>
                            <!-- <td><?php echo $group->usgr_workorderno; ?></td> -->
                            <td><?php echo $group->usgr_accesstypes; ?></td>
                            <td><?php echo $group->loca_name; ?></td>
                            <td><?php echo $group->usgr_remarks; ?></td>
                            <td><?php echo $group->usgr_postdatebs; ?></td>
                            <td>
                                <?php if($module_edit=='Y'): ?>
                                    <a href="javascript:void(0)" data-id='<?php echo $group->usgr_usergroupid; ?>' class="btnEdit"><i class="fa fa-edit"></i> </a>&nbsp;
                                <?php endif; ?>
                                <?php if($module_delete=='Y'): ?>
                                    <a href="javascript:void(0)" data-id='<?php echo $group->usgr_usergroupid; ?>' class="btnDelete"> <i class="fa fa-trash"></i></a>
                                <?php endif;?>
                            </td>
                        </tr>
                        <?php
                    endforeach;
                endif;
            }
            ?>
        </tbody>
    </table>
</div>