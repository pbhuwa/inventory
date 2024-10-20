<div class="list_c2 label_mw125">
    <div class="form-group row resp_xs">
        <div class="col-md-12 col-xs-12" style="max-height: 200px; overflow-y: auto;">
            <h4><?php echo $this->lang->line('pending_list'); ?></h4>
            <table class="table table-striped dt_alt dataTable" id="Dttable">
                <thead>
                    <tr>
                        <th><?php echo $this->lang->line('item_code'); ?></th>
                        <th><?php echo $this->lang->line('item_name'); ?></th>
                        <th><?php echo $this->lang->line('unit'); ?></th>
                        <th><?php echo $this->lang->line('rem_qty'); ?></th>
                        <th><?php echo $this->lang->line('stock_quantity'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(!empty($pending_list)):
                            foreach($pending_list as $list):
                                // echo "<pre>";
                                // print_r($pending_list);
                                // die();

                                if(ITEM_DISPLAY_TYPE=='NP'){
                    $req_itemname = !empty($list->itli_itemnamenp)?$list->itli_itemnamenp:$list->itli_itemname;
                }else{ 
                    $req_itemname = !empty($list->itli_itemname)?$list->itli_itemname:'';
                }
                                
                                // if($list->rede_remqty != 0  && $list->rede_qtyinstock != 0):
                    ?>
                        <tr>
                            <td><?php echo !empty($list->itli_itemcode)?$list->itli_itemcode:'';?></td>
                            <td><?php echo $req_itemname;?></td>
                            <td><?php echo !empty($list->unit_unitname)?$list->unit_unitname:'';?></td>
                            <td><?php echo !empty($list->rede_remqty)?$list->rede_remqty:0;?></td>
                            <td><?php echo !empty($list->stockqty)?$list->stockqty:0;?></td>
                        </tr>
                    <?php
                                // endif;
                            endforeach;
                        endif;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>