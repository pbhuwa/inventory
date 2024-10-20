<style>

    .mcolor{

        background: #FF8C00 !important;

    }

</style>

<?php

$transfertype=$assets_transfer_master[0]->astm_transfertypeid;

// print_r($transfertype);

// die();

if($transfertype=='D'){



    $transfer_type='Department';

} 

else{

     $transfer_type='Branch';

}

?>

<div class="form-group white-box pad-5 bg-gray">

    <div class="row">

        <div class="col-sm-4 col-xs-6">

            <label>Fiscal Year</label>: 

            <span> <?php echo !empty($assets_transfer_master[0]->astm_fiscalyrs)?$assets_transfer_master[0]->astm_fiscalyrs:''; ?></span>

        </div>

        

        <div class="col-sm-4 col-xs-6">

            <label for="example-text">Transfer No:</label> 

            <span><?php echo !empty($assets_transfer_master[0]->astm_transferno)?$assets_transfer_master[0]->astm_transferno:'0'; ?></span>

        </div>

         <div class="col-sm-4 col-xs-6">

            <label for="example-text">Manual No:</label> 

            <span><?php echo !empty($assets_transfer_master[0]->astm_manualno)?$assets_transfer_master[0]->astm_manualno:'0'; ?></span>

        </div>

        <div class="col-sm-4 col-xs-6">

            <label for="example-text">Transfer Type:</label> 

            <span><?php echo $transfer_type?></span>

        </div>

        <?php

        if($transfertype=='D'){

        ?>

        <div class="col-sm-4 col-xs-6">

            <label for="example-text">Department From:</label>

            <span><?php echo !empty($assets_transfer_master[0]->fromdep)?$assets_transfer_master[0]->fromdep:''; ?></span>

        </div>

        <div class="col-sm-4 col-xs-6">

            <label for="example-text">Department To:</label> 

            <span><?php echo !empty($assets_transfer_master[0]->todep)?$assets_transfer_master[0]->todep:''; ?></span>

        </div>

        <?php 

    }

        else{?>



           <div class="col-sm-4 col-xs-6">

            <label for="example-text">Branch  From:</label> 

            <span><?php echo !empty($assets_transfer_master[0]->fromlocation)?$assets_transfer_master[0]->fromlocation:''; ?></span>

        </div>

        <div class="col-sm-4 col-xs-6">

            <label for="example-text">Branch  To:</label> 

            <span><?php echo !empty($assets_transfer_master[0]->tolocation)?$assets_transfer_master[0]->tolocation:''; ?></span>

        </div>

    <?php } ?>

        

        <div class="col-sm-4 col-xs-6">

            <label for="example-text">Date</label>: 

            <span class="inline_block">

            <b><?php echo !empty($assets_transfer_master[0]->astm_transferdatebs)?$assets_transfer_master[0]->astm_transferdatebs:''; ?></b> BS -- <b><?php echo !empty($assets_transfer_master[0]->astm_transferdatead)?$assets_transfer_master[0]->astm_transferdatead:''; ?></b> AD

            </span>

        </div>



         

    </div>

</div> 



<div class="form-group">

    <div class="row">

        <div class="table-responsive col-sm-12">

            <table style="width:100%;" class="table purs_table dataTable con_ttl">

                <thead>

                    <tr>

                        <th width="5%"><?php echo $this->lang->line('sn'); ?> </th>

                        <th width="8%">Assets Code </th>

                        <th width="6%">Description</th>

                        <th width="6%">Original Cost</th>

                        <th width="5%">Current Cost.</th>

                        <th width="5%"><?php echo $this->lang->line('remarks'); ?></th>

                    </tr>

                </thead>

                

                <tbody id="purchaseDataBody">

                    <?php 

                    // echo "<pre>";

                    // print_r($stock_requisition);

                    // die();

                        if(!empty($assets_transfer_detail)) { 

                            // $grandtotal=0;

                            foreach ($assets_transfer_detail as $key => $odr) 

                            { 

                                // $qty = $odr->wode_qty;

                                // $unitprice = $odr->wode_rate;

                                // $sub_total_amt = $qty * $unitprice;

                

                    ?>

                    <tr class="orderrow" id="orderrow_<?php echo $key+1 ?>" data-id='<?php echo $key+1 ?>'>

                        <td><?php echo $key+1; ?></td>

                        <td><?php echo $odr->astd_assetsid ?></td>

                        <td><?php echo $odr->astd_assetsdesc ?></td>

                        <td align="right"><?php echo $odr->astd_originalamt ?></td>

                        <td align="right"><?php echo $odr->astd_currentamt ?></td>

                        <td><?php echo $odr->astd_remark; ?></td>

                    </tr>

                <?php

                    } 

                    } 

                ?>

                </tbody>

                   <!--  <tfoot>

                        <tr>

                    <th  colspan="6">

                        <h5 align="right" colspan="8" style="color: #333; padding-top: 0px; font-size: 12px;"><strong>Estimated Cost:</strong></h5>

                        <td align="right" style="color: #333; padding-top: 22px; font-size: 13px;"><strong>

                            <?php echo number_format($grandtotal,2) ?></strong>

                        </td>

                    </th>

                </tr>

                <?php if($grandtotal >'0.00'): ?>

                <tr>

                    <td colspan="7"><strong><?php echo $this->lang->line('in_words'); ?>: <?php echo $this->general->number_to_word($grandtotal); ?></strong></td>

                </tr>

            <?php endif; ?>

            </tfoot> -->



                

            </table>

        </div>

    </div>

</div>

<div id="FormDiv_Reprint" class="printTable"></div>    