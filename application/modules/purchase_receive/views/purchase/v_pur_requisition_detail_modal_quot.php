<div class="list_c2 label_mw125">
    <div class="form-group row resp_xs">
        <div class="col-md-12 col-xs-12" style="max-height: 200px; overflow-y: auto;">
            <h4><?php echo $this->lang->line('purchase_requisition_detail'); ?></h4>
            <table class="table table-striped dt_alt dataTable" id="Dttable">
                <thead>
                    <tr>
                    <th width="5%"> <?php echo $this->lang->line('sn'); ?> </th>
                    <th width="12%"> <?php echo $this->lang->line('item_code'); ?>  </th>
                    <th width="25%"> <?php echo $this->lang->line('item_name'); ?> </th>
                     <th width="10%"><?php echo $this->lang->line('qty'); ?></th>
                    <th width="10%"> <?php echo $this->lang->line('rate'); ?> </th>
                    <th width="10%"> <?php echo $this->lang->line('dis'); ?></th>
                    <th width="10%"> <?php echo $this->lang->line('vat'); ?></th>
                    <th width="10%"> <?php echo $this->lang->line('net_rate'); ?></th>
                    <!-- <th width="10%"> <?php echo $this->lang->line('action'); ?></th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(!empty($detail_list)):

                            // echo "<pre>";
                            // print_r($detail_list);
                            // die();
                            foreach($detail_list as $key=>$list):
                                    if(ITEM_DISPLAY_TYPE=='NP'){
                    $req_itemname = !empty($list->itemnamenp)?$list->itemnamenp:$list->itemname;
                }else{ 
                    $req_itemname = !empty($list->itemname)?$list->itemname:'';
                }
                    ?>
                        <tr>
                            <td><?php echo $key+1;?></td>
                            <td><?php echo !empty($list->itemcode)?$list->itemcode:'';?></td>
                            <td><?php echo $req_itemname;?></td>
                            <td><?php echo !empty($list->quantity)?$list->quantity:0;?></td>
                            <td><?php echo !empty($list->itli_purchaserate)?$list->itli_purchaserate:0;?></td>
                            <td><?php echo !empty($list->pude_discount)?$list->pude_discount:0;?></td>
                            <td><?php echo !empty($list->pude_vat)?$list->pude_vat:0;?></td>
                            <td><?php echo !empty($list->amount)?$list->amount:0;?></td>
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