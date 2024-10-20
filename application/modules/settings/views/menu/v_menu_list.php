<table id="Dtable" class="table table-striped menulist" >
<thead>
    <tr>
        <th><?php echo $this->lang->line('parent_menu'); ?></th>
        <!-- <th>Menu Key</th> -->
        <th><?php echo $this->lang->line('display_text'); ?></th>
        <th><?php echo $this->lang->line('display_text_np'); ?></th>
        <th><?php echo $this->lang->line('menu_link'); ?></th>
        <th><?php echo $this->lang->line('post_date'); ?></th>
        <th><?php echo $this->lang->line('action'); ?></th>
    </tr>
</thead>
<tbody>
     <?php
        $module_edit = MODULES_UPDATE;
        // echo $module_edit;
        // die();
        $module_delete = MODULES_DELETE;

        $showview= MODULES_VIEW;
                        if($showview=='N')
                        {
                            ?>
                            <td colspan="6" style="text-align:center">Permission Denial</td>
                           
                        <?php 
                        } 
                        else {
            if($menu_all):
                foreach ($menu_all as $km => $menu):
        ?>
            <tr id="listid_<?php echo $menu->modu_moduleid; ?>">
            <td><?php echo !empty($menu->parentmenu)?$menu->parentmenu:'----'; ?></td>
            <!--<td><?php echo $menu->modu_modulekey; ?></td>!-->
            <td><?php echo $menu->modu_displaytext; ?></td>
            <td><?php echo $menu->modu_displaytextnp; ?></td>
            <td><?php echo $menu->modu_modulelink; ?></td>
            <td><?php echo $menu->modu_postdatebs; ?></td>
            <td>
            <?php if($module_edit=='Y'): ?>
            <a href="javascript:void(0)" title="Edit" data-id='<?php echo $menu->modu_moduleid; ?>' class="btnEdit"><i class="fa fa-edit"></i> </a>&nbsp;
            <?php endif; ?>
              <?php if($module_delete=='Y'): ?>
            <a href="javascript:void(0)"  title="Delete" data-id='<?php echo $menu->modu_moduleid; ?>' class="btnDelete"><i class="fa fa-trash"></i></a>
        <?php endif;?>
         <?php if($module_edit=='Y'): ?>
            <a href="javascript:void(0)" title="Copy" data-id='<?php echo $menu->modu_moduleid.',copy'; ?>' class="btnEdit"><i class="fa fa-copy"></i> </a>&nbsp;
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

