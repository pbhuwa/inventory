<div class="white-box pad-5">
    <div class="list_c2 label_mw125">
        <div class="form-group row resp_xs">
            <div class="col-md-12 col-xs-12" style="max-height: 200px; overflow-y: auto;">
                <table class="table table-striped dt_alt dataTable" id="reqTable" tabindex="1" >
                    <thead>
                        <tr>
                            <th>Items Code</th>
                            <th>Items Name</th>
                            <th>Unit</th>
                            <th>Purchase Rate</th>
                            <th>Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(!empty($stock_received)):
                                foreach($stock_received as $stock):
                                    if(ITEM_DISPLAY_TYPE=='NP'){
                    $req_itemname = !empty($stock->itemnamenp)?$stock->itemnamenp:$stock->itemname;
                }else{ 
                    $req_itemname = !empty($stock->itemname)?$stock->itemname:'';
                }


                        ?>
                        <tr>
                            <td><?php echo !empty($stock->itemcode)?$stock->itemcode:'';?></td>
                            <td><?php echo $req_itemname;?></td>
                            <td><?php echo !empty($stock->unitname)?$stock->unitname:'';?></td>
                            <td><?php echo !empty($stock->unitprice)?$stock->unitprice:'';?></td>
                            <td><?php echo !empty($stock->requiredqty)?$stock->requiredqty:'';?></td>
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
</div>