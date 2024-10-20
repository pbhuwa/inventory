<div class="table-responsive">
    <table id="Dtable" class="table table-striped menulist"  >
        <thead>
            <tr>
                <th><?php echo $this->lang->line('sn'); ?></th>
                <th><?php echo $this->lang->line('username'); ?></th>
                <th><?php echo $this->lang->line('full_name'); ?></th>
                <th><?php echo $this->lang->line('department'); ?></th>
                <th><?php echo $this->lang->line('user_group'); ?></th>
                <th><?php echo $this->lang->line('post_date'); ?></th>
                <th><?php echo $this->lang->line('action'); ?></th>
            </tr>
        </thead>
        <tbody>

        <?php
         $module_edit = MODULES_UPDATE;
        
         $module_delete = MODULES_DELETE;
        $i=1;
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
        if($users_all):
            foreach ($users_all as $km => $user):
                $deparray=explode(',', $user->usma_departmentid);
            ?>
            <tr id="listid_<?php echo $user->usma_userid; ?>">
            <td><?php echo $i; ?></td>
            <td><?php echo $user->usma_username; ?></td>
            <td><?php echo $user->usma_fullname; ?></td>
            <td><?php echo $this->users_mdl->get_userwise_dep($user->usma_userid,$deparray);?></td>
            <td><?php echo $user->usgr_usergroup; ?></td>
            <td><?php echo $user->usma_postdatebs; ?></td>
            <td>
            <?php if($module_edit=='Y'): ?>
            <a href="javascript:void(0)" data-id='<?php echo $user->usma_userid; ?>' class="btnEdit"><i class="fa fa-edit"></i> </a>&nbsp;
        <?php endif; ?>
        <?php if($module_delete=='Y'): ?>
            <a href="javascript:void(0)" data-id='<?php echo $user->usma_userid; ?>' class="btnDelete"> <i class="fa fa-trash"></i></a>
        <?php endif; ?>
            </td>
            </tr>
            <?php
            $i++;
            endforeach;
        endif;
    }
         ?>
        </tbody>
    </table>
</div>
