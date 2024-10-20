<table class="table flatTable tcTable">
  <thead>
    <tr>
      <<th width="7%"><?php echo $this->lang->line('sn'); ?></th>
      <th width="13%"><?php echo $this->lang->line('item_code'); ?></th>
      <th width="20%"><?php echo $this->lang->line('item_name'); ?></th>
    </tr>
  </thead>
  <tbody>
   <?php
   if(!empty($items_data)):
    foreach ($items_data as $key => $det_log) :
      ?>
      <tr class="trSelectData" data-id="<?php echo $det_log->itli_itemlistid ?>" data-code="<?php echo $det_log->itli_itemcode ?>" style="cursor:pointer;" >
        <td><?php echo $key+1; ?></td>
        <td><?php echo $det_log->itli_itemcode; ?></td>
        <td><?php echo $det_log->itli_itemname; ?></td>

      </tr>
      <?php
    endforeach;
  else:
    echo '<tr><td colspan="3"><span class="text-danger">No Record match</a><td></tr>';
  endif;
  ?>
</tbody>
</table>