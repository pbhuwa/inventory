<div class="list_c2 label_mw125">
    <div class="form-group row resp_xs">
        <div class="col-md-12 col-xs-12" style="max-height: 200px; overflow-y: auto;">
            <h4><?php echo $this->lang->line('order_detail'); ?></h4>
            <table class="table table-striped dt_alt dataTable" id="Dttable">
                <thead>
                    <tr>
                        <th><?php echo $this->lang->line('item_code'); ?></th>
                        <th><?php echo $this->lang->line('item_name'); ?></th>
                        <th><?php echo $this->lang->line('unit'); ?></th>
                        <th><?php echo $this->lang->line('qty'); ?></th>
                        <th><?php echo $this->lang->line('rate'); ?></th>
                        <th><?php echo $this->lang->line('discount'); ?>(%)</th>
                        <th><?php echo $this->lang->line('vat'); ?></th>
                        <th><?php echo $this->lang->line('amount'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(!empty($detail_list)):
                            foreach($detail_list as $list):
                                if(ITEM_DISPLAY_TYPE=='NP'){
                    $req_itemname = !empty($list->itemnamenp)?$list->itemnamenp:$list->itemname;
                }else{ 
                    $req_itemname = !empty($list->itemname)?$list->itemname:'';
                }
                    ?>
                        <tr>
                            <td><?php echo !empty($list->itemcode)?$list->itemcode:'';?></td>
                            <td><?php echo $req_itemname;?></td>
                            <td><?php echo !empty($list->unit_unitname)?$list->unit_unitname:'';?></td>
                            <td><?php echo !empty($list->quantity)?$list->quantity:0;?></td>
                            <td><?php echo !empty($list->rate)?$list->rate:0;?></td>
                            <td><?php echo !empty($list->pude_discount)?$list->pude_discount:0;?></td>
                            <td><?php echo !empty($list->pude_vat)?$list->pude_vat:0;?></td>
                            <td><?php echo !empty($list->pude_amount)?$list->pude_amount:0;?></td>
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