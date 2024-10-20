<table id="Dtable" class="table table-striped" >
    <thead>
        <tr>
            <th width="20%"><?php echo $this->lang->line('brand_code'); ?></th>
            <th width="30%"><?php echo $this->lang->line('brand_name'); ?></th>
            <th width="30%"><?php echo $this->lang->line('address'); ?></th>
            <th width="15%"><?php echo $this->lang->line('action'); ?></th>
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

        if($brand_all):
        foreach ($brand_all as $km => $bran):
        ?>
        <tr id="listid_<?php echo $bran->bran_brandid; ?>">
            <td><?php echo $bran->bran_code; ?></td>
            <td><?php echo $bran->bran_name; ?></td>
            <td><?php echo $bran->bran_address; ?></td>
            <td>
                <?php if($module_edit=='Y'): ?>
                <a href="javascript:void(0)" data-id='<?php echo $bran->bran_brandid; ?>' class="btnEdit">Edit </a>
                <?php endif; ?> 
                <?php if($module_delete=='Y'):?> |
                <a href="javascript:void(0)" data-id='<?php echo $bran->bran_brandid; ?>' class="btnDelete">Delete</a>
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