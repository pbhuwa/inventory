<table id="Dtable" class="table table-striped menulist" >
<thead>
    <tr>
        <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
        <th width="10%"><?php echo $this->lang->line('name'); ?></th>
        <th width="10%"><?php echo $this->lang->line('address'); ?></th>
        <th><?php echo $this->lang->line('website'); ?></th>
         <th><?php echo $this->lang->line('phone'); ?></th>
         <th><?php echo $this->lang->line('email'); ?></th>
        <th><?php echo $this->lang->line('action'); ?></th>
    </tr>
</thead>
<tbody>
     <?php
            if($insurance_company_all):
                $i=1;
                foreach ($insurance_company_all as $kpc => $demo):
        ?>
            <tr id="listid_<?php echo $demo->inco_id; ?>">
            <td><?php echo $i; ?></td>
            <td><?php echo $demo->inco_name; ?></td>
            <td><?php echo $demo->inco_address1; ?></td>
            <td><?php echo $demo->inco_website; ?></td>
            <td><?php echo $demo->inco_phone; ?></td>
            <td><?php echo $demo->inco_email; ?></td>     
            <td>
            <a href="javascript:void(0)" data-id='<?php echo $demo->inco_id; ?>' class="btnEdit"><i class="fa fa-edit"></i> </a> |
            <a href="javascript:void(0)" data-id='<?php echo $demo->inco_id; ?>' class="btnDelete"><i class="fa fa-trash"></i></a>
            </td>
            </tr>
        <?php
        $i++;
        endforeach;
    endif;
     ?>
 </tbody>
</table>



