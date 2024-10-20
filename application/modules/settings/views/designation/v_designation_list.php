<table id="Dtable" class="table table-striped" >
    <thead>
        <tr>
             <!--  <th><?php //echo $this->lang->line('brand_code'); ?></th> -->
            <th><?php echo $this->lang->line('designation_name'); ?></th>
           <!--  <th><?php //echo $this->lang->line('address'); ?></th> -->
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

        if($designation_all):
        foreach ($designation_all as $km => $desi):
        ?>
        <tr id="listid_<?php echo $desi->desi_designationid; ?>">
           <!--  <td><?php //echo $bran->bran_code; ?></td> -->
            <td><?php echo $desi->desi_designationname; ?></td>
           <!--  <td><?php //echo $bran->bran_address; ?></td> -->
            <td>
                <?php if($module_edit=='Y'): ?>
                <a href="javascript:void(0)" data-id='<?php echo $desi->desi_designationid; ?>' class="btnEdit">Edit </a>
                <?php endif; ?> 
                <?php if($module_delete=='Y'):?> |
                <a href="javascript:void(0)" data-id='<?php echo $desi->desi_designationid; ?>' class="btnDelete">Delete</a>
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