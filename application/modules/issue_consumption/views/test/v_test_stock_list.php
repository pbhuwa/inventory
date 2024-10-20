
<table id="Dtable" class="table purs_table dataTable con_ttl" >
    <thead>
        <tr>
                    <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="20%">Expenses <?php echo $this->lang->line('date'); ?>(AD)</th>
                    <th width="20%">Expenses <?php echo $this->lang->line('date'); ?>(BS)</th>
                    <th width="10%">Expenses <?php echo $this->lang->line('time'); ?></th>

                    <th width="10%"><?php echo $this->lang->line('expenses_qty'); ?></th>
                    <th width="20%"><?php echo $this->lang->line('remarks'); ?></th>
        </tr>
    </thead>
    <tbody>
       
<?php
        if($test_list):
        foreach ($test_list as $km => $row):
        ?>
        <tr>
          <td><?php echo $km+1; ?></td>
          <td><?php echo $row->test_expensesdatead; ?></td>
        <td><?php echo $row->test_expensesdatebs; ?></td>
         <td><?php echo $row->test_posttime; ?></td>
        <td><?php echo $row->test_expensesqty; ?></td>
        <td><?php echo $row->test_remarks; ?></td> 
        </tr>
        <?php
        endforeach;
        endif;
       
        ?>
    </tbody>
</table>


