<div class="white-box pad-5">
    <div class="list_c2 label_mw125">
        <div class="form-group row resp_xs">
            <div class="col-md-12 col-xs-12" style="max-height: 200px; overflow-y: auto;">
                <table class="table table-striped dt_alt dataTable" id="reqTable" tabindex="1" >
                    <thead>
                        <tr>
                            <th width="5%">S.n.</th>
                            <th width="10%">Code</th>
                            <th width="10%">Item Name</th>
                            <th width="10%">Rem. Qty</th>
                            <th width="10%">Order Qty</th>
                            <th width="10%">Rate</th>
                            <th width="10%">Amount</th>
                            <th width="10%">Unit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($indi_order): 
                        $i=1;
                        foreach ($indi_order as $key => $iorder):

                            if(ITEM_DISPLAY_TYPE=='NP'){
                    $req_itemname = !empty($iorder->itli_itemnamenp)?$iorder->itli_itemnamenp:$iorder->itli_itemname;
                }else{ 
                    $req_itemname = !empty($iorder->itli_itemname)?$iorder->itli_itemname:'';
                }
                        ?>
                        <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo !empty($iorder->itli_itemcode)?$iorder->itli_itemcode:'';?></td>
                        <td><?php echo $req_itemname;?></td>
                        <td><?php echo !empty($iorder->pude_remqty)?$iorder->pude_remqty:'';?></td>
                        <td><?php echo !empty($iorder->pude_quantity)?$iorder->pude_quantity:'';?></td>
                        <td><?php echo !empty($iorder->pude_rate)?$iorder->pude_rate:'';?></td>
                        <td><?php echo !empty($iorder->pude_amount)?$iorder->pude_amount:'';?></td>
                        <td><?php echo !empty($iorder->pude_unit)?$iorder->pude_unit:'';?></td>
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