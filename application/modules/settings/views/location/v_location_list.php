<table id="Dtable" class="table table-striped" >
    <thead>
        <tr>
              <th><?php echo $this->lang->line('location_code'); ?></th>
            <th><?php echo $this->lang->line('location_name'); ?></th>
            <th><?php echo $this->lang->line('address'); ?></th>
            <th><?php echo $this->lang->line('action'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
         $module_edit = MODULES_UPDATE;

         $module_delete = MODULES_DELETE;

       if(MODULES_VIEW=='N')
            {
                ?>
                <tr>
                    <td></td>
                    <td> <p class='text-danger'>Permission Denial</p></td>
                    <td></td>
                </tr>
<?php
            }
        else
        {

        if($location_all):
        foreach ($location_all as $km => $loca):
        ?>
        <tr id="listid_<?php echo $loca->loca_locationid; ?>">
            <td><?php echo $loca->loca_code; ?></td>
            <td><?php echo $loca->loca_name; ?></td>
            <td><?php echo $loca->loca_address; ?></td>
            <td>
                <?php if($module_edit=='Y'): ?>
                <a href="javascript:void(0)" data-id='<?php echo $loca->loca_locationid; ?>' class="btnEdit">Edit </a>
                <?php endif; ?> 
                <?php if($module_delete=='Y'):?> |
                <a href="javascript:void(0)" data-id='<?php echo $loca->loca_locationid; ?>' class="btnDelete">Delete</a>
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