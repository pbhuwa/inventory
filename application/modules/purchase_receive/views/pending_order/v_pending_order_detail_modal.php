<div class="white-box pad-5">
    <div class="list_c2 label_mw125">
        <div class="form-group row resp_xs">
            <div class="col-md-12 col-xs-12" style="max-height: 200px; overflow-y: auto;">
                <table class="table table-striped dt_alt dataTable" id="reqTable" tabindex="1" >
                    <thead>
                        <tr>
                            <th width="5%">S.No.</th>
                            <th width="10%">Code</th>
                            <th width="10%">Name</th>
                            <th width="10%">Order Qty</th>
                            <th width="10%">Rem. Qty</th>
                            <th width="10%">Free</th>
                            <th width="10%">Rate</th>
                            <th width="10%">Discount</th>
                            <th width="10%">VAT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($pending_order_detail): 
                        $i=1;
                        foreach ($pending_order_detail as $key => $pending):

                            if(ITEM_DISPLAY_TYPE=='NP'){
                    $req_itemname = !empty($pending->itemnamenp)?$pending->itemnamenp:$pending->itemname;
                }else{ 
                    $req_itemname = !empty($pending->itemname)?$pending->itemname:'';
                }


                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo !empty($pending->itemcode)?$pending->itemcode:'';?></td>
                            <td>
                                <?php echo $req_itemname;?>
                            </td>
                            <td>
                                <?php echo !empty($pending->quantity)?$pending->quantity:'';?>
                            </td>
                            <td><?php echo !empty($pending->remquantity)?$pending->remquantity:'';?></td>
                            <td><?php echo !empty($pending->free)?intval($pending->free):0;?></td>
                            <td><?php echo !empty($pending->rate)?$pending->rate:'';?></td>
                            <td><?php echo !empty($pending->discount)?$pending->discount:0;?></td>
                            <td><?php echo !empty($pending->vat)?$pending->vat:'';?></td>
                        </tr>
                        <?php
                        $i++;
                        endforeach;
                        endif;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>