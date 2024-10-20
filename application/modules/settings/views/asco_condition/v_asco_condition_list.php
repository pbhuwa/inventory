<table id="Dtable" class="table table-striped menulist" >
<thead>
    <tr>
        <th width="15%"><?php echo $this->lang->line('sn'); ?></th>
        <th width="25%"><?php echo $this->lang->line('name'); ?></th>
        <th width="25%"><?php echo $this->lang->line('asco_code'); ?></th>
        <th width="15%"><?php echo $this->lang->line('is_active'); ?></th>
        <th><?php echo $this->lang->line('action'); ?></th>
    </tr>
</thead>
<tbody>
     <?php
            if($asco_condition):
                $i=1;
                foreach ($asco_condition as $kpc => $demo):
        ?>
            <tr id="listid_<?php echo $demo->asco_ascoid; ?>">
            <td><?php echo $i; ?></td>
            <td><?php echo $demo->asco_conditionname; ?></td>
            <td><?php echo $demo->asco_code; ?></td> 
            <td><?php echo $demo->asco_isactive; ?></td>  
            <td>
            <a href="javascript:void(0)" data-id='<?php echo $demo->asco_ascoid; ?>' class="btnEdit"><i class="fa fa-edit"></i> </a> |
            <a href="javascript:void(0)" data-id='<?php echo $demo->asco_ascoid; ?>' class="btnDelete"><i class="fa fa-trash"></i></a>
            </td>
            </tr>
        <?php
        $i++;
        endforeach;
    endif;
     ?>
 </tbody>
</table>



