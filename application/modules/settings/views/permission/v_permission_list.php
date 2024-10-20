<table class="table table-responsive">
  <thead>
  <tr>
    <?php $c=count($group_all); 

    ?>
    <td colspan="<?=$c+3?>">
      <h4>Manage Permission</h4>
      <select  id="parent_module_id" class="form-control" style="width: 150px">
        <option value="">---select---</option>
        <?php foreach($menu_list_all as $menu): ?>
        <option value="<?php echo $menu->modu_moduleid; ?>"><?php echo $menu->modu_displaytext; ?></option>
      <?php endforeach; ?>
      </select>
    </td>
  </tr>

  
  <tr><th>SNo</td><th>Module Name</th>
    <?php foreach($group_all as $g): ?>
        <th><?php echo humanize($g->usgr_usergroup); ?></th>
    <?php endforeach; ?>
  </tr>
  </thead>
  <tbody>
    <?php $i=1; 
    // echo "<pre>";
    // print_r($p);
    // die();
    foreach($menu_list as $m)
    { 
      repeatmod($this,$m,$i,$group_all,$p); 
    } 
      ?>  
  </tbody>
</table>