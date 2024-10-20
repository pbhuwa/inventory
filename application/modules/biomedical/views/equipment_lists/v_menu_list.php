<table id="Dtable" class="table table-striped menulist" >
<thead>
    <tr>
        <th><?php echo $this->lang->line('parent_menu'); ?></th>
        <th><?php echo $this->lang->line('menu_key'); ?></th>
        <th><?php echo $this->lang->line('display_text'); ?></th>
        <th><?php echo $this->lang->line('menu_link'); ?></th>
        <th><?php echo $this->lang->line('post_date'); ?></th>
        <th><?php echo $this->lang->line('action'); ?></th>
    </tr>
</thead>
<tbody>
     <?php
            if($menu_all):
                foreach ($menu_all as $km => $menu):
        ?>
            <tr id="listid_<?php echo $menu->modu_moduleid; ?>">
            <td><?php echo !empty($menu->parentmenu)?$menu->parentmenu:'----'; ?></td>
            <td><?php echo $menu->modu_modulekey; ?></td>
            <td><?php echo $menu->modu_displaytext; ?></td>
            <td><?php echo $menu->modu_modulelink; ?></td>
            <td><?php echo $menu->modu_postdatebs; ?></td>
            <td>
            <a href="javascript:void(0)" data-id='<?php echo $menu->modu_moduleid; ?>' class="btnEdit"><?php echo $this->lang->line('update'); ?> </a> |
            <a href="javascript:void(0)" data-id='<?php echo $menu->modu_moduleid; ?>' class="btnDelete"><?php echo $this->lang->line('delete'); ?></a>
            </td>
            </tr>
        <?php
        endforeach;
    endif;
     ?>
 </tbody>
</table>

