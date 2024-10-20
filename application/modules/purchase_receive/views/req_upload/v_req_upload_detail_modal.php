<div class="list_c2 label_mw125">
    <div class="form-group row resp_xs">
        <div class="col-md-12 col-xs-12" style="max-height: 200px; overflow-y: auto;">
            <h4><?php echo $this->lang->line('requisition_detail'); ?></h4>
            <table class="table table-striped dt_alt dataTable" id="Dttable">
                <thead>
                    <tr>
                    <th width="5%"> <?php echo $this->lang->line('sn'); ?> </th>
                    <th width="12%"> <?php echo $this->lang->line('item_name'); ?>  </th>
                    <th width="25%"> <?php echo $this->lang->line('manufacturer'); ?> </th>
                    <th width="10%"><?php echo $this->lang->line('qty'); ?></th>
                    <th width="10%"> <?php echo $this->lang->line('size'); ?> </th>
                    <th width="10%"> <?php echo $this->lang->line('rate'); ?></th>
                    <th width="10%"> <?php echo $this->lang->line('remarks'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(!empty($detail_list)):
                            foreach($detail_list as $key=>$list):
                    ?>
                        <tr>
                            <td><?php echo $key+1;?></td>
                            <td><?php echo !empty($list->reud_itemname)?$list->reud_itemname:'';?></td>
                            <td><?php echo !empty($list->reud_manufacturer)?$list->reud_manufacturer:0;?></td>
                            <td><?php echo !empty($list->reud_qty)?$list->reud_qty:0;?></td>
                            <td><?php echo !empty($list->reud_size)?$list->reud_size:0;?></td>
                            <td><?php echo !empty($list->reud_rate)?$list->reud_rate:0;?></td>
                            <td><?php echo !empty($list->reud_remarks)?$list->reud_remarks:0;?></td>
                        </tr>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>