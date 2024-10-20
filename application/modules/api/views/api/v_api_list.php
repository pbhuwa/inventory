<table id="Dtable" class="table table-striped apilist" >
<thead>
    <tr>
       
        <th>S.n.</th>
        <th>API Name</th>
        <th>API Url</th>
        <th>Remarks</th>
        <th>Is Active</th>
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
            if($api_all):
                $i=1;
                foreach ($api_all as $km => $api):
        ?>
            <tr id="listid_<?php echo $api->apta_id; ?>">
            <td><?php echo $i; ?></td>
            <td><?php echo $api->apta_name; ?></td>
            <td><?php echo $api->apta_url; ?></td>
            <td><?php echo $api->apta_remarks; ?></td>
            <td><?php echo $api->apta_isactive; ?></td>
            <td>
                <?php if($module_edit=='Y'): ?>
            <a href="javascript:void(0)" title="Edit" data-id='<?php echo $api->apta_id; ?>' class="btnEdit"><i class="fa fa-edit"></i> </a>
            <?php endif; ?> |
            <?php if($module_delete=='Y'):?>
            <a href="javascript:void(0)"  title="Delete" data-id='<?php echo $api->apta_id; ?>' class="btnDelete"><i class="fa fa-trash"></i></a>
        <?php endif; ?>
            <a href="javascript:void(0)"   title="Generate" data-href='<?php echo base_url($api->apta_url); ?>' class="label label-success btnGenerateApi">Generate </i></a>
            
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

