<table id="Dtable" class="table table-striped">
    <thead>
        <tr>
            <th><?php echo $this->lang->line('department_code'); ?></th>
            <th><?php echo $this->lang->line('department_name'); ?></th>
            <th><?php echo $this->lang->line('location'); ?></th>
            <th><?php echo $this->lang->line('post_date'); ?></th>
            <th><?php echo $this->lang->line('action'); ?></th>
        </tr>
    </thead>
    <tbody>

        <?php
        $module_edit = MODULES_UPDATE;

        $module_delete = MODULES_DELETE;
        $showview = MODULES_VIEW;
        if ($showview == 'N') {
        ?>
            <td></td>
            <td colspan="2" style="text-align:center">Permission Denial</td>
            <td></td>
            <td></td>
            <?php
        } else {
            if ($departments) :

                foreach ($departments as $km => $department) :
            ?>
                    <tr id="listid_<?php echo $department->dept_depid; ?>">

                        <td><?php echo $department->dept_depcode; ?></td>
                        <td><?php echo $department->dept_depname; ?></td>
                        <td><?php echo $department->loca_name; ?></td>
                        <td><?php echo $department->dept_postdatebs; ?></td>
                        
                        <td>
                            <?php if ($module_edit == 'Y') : ?>
                                <a href="javascript:void(0)" data-id='<?php echo $department->dept_depid; ?>' class="btnEdit"><i class="fa fa-edit" aria-hidden="true"></i> Edit </a>
                            <?php endif; ?>
                            <?php if ($module_delete == 'Y') : ?> |
                                <a href="javascript:void(0)" data-id='<?php echo $department->dept_depid; ?>' class="btnDelete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a>
                            <?php endif; ?>
                        </td>
                    </tr>
        <?php
                endforeach;
            endif;
        }
        ?>
    </tbody>
</table>