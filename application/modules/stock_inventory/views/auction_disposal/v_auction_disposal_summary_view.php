<style>
    .mcolor{
        background: #FF8C00 !important;
    }
</style>

<div class="form-group white-box pad-5 bg-gray">
    <div class="row">
    <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?> </label>:

            <?php 
                $fyear=!empty($sales_disposal_master[0]->asde_fiscalyrs)?$sales_disposal_master[0]->asde_fiscalyrs:'';
                echo $fyear; 
            ?> 

        </div>

        <div class="col-sm-4 col-xs-6">
            <label>Disposal No</label>: 
            <span> <?php echo !empty($sales_disposal_master[0]->asde_disposalno)?$sales_disposal_master[0]->asde_disposalno:''; ?></span>
        </div>

        <div class="col-sm-4 col-xs-6">

            <label for="example-text"><?php echo $this->lang->line('manual_no'); ?></label> : 
            <span><?php echo !empty($sales_disposal_master[0]->asde_manualno)?$sales_disposal_master[0]->asde_manualno:'0'; ?></span>

        </div>

        <div class="col-sm-4 col-xs-6">

            <label for="example-text">Disposal Date</label>: 
            <span class="inline_block">
            <b><?php echo !empty($sales_disposal_master[0]->asde_deposaldatebs)?$sales_disposal_master[0]->asde_deposaldatebs:''; ?></b> BS -- <b><?php echo !empty($sales_disposal_master[0]->asde_desposaldatead)?$sales_disposal_master[0]->asde_desposaldatead:''; ?></b> AD

            </span>

        </div> 

         <div class="col-sm-4 col-xs-6">
            <label for="example-text">Disposal Type</label>: 
            <span>
                <?php 

                    echo !empty($sales_disposal_master[0]->dety_name)?$sales_disposal_master[0]->dety_name:'';
                ?>
            </span>
        </div>

        <div class="col-sm-4 col-xs-6">

            <label for="example-text">Customer Name</label>: 
            <span>
                <?php 
                    echo !empty($sales_disposal_master[0]->asde_customer_name)?$sales_disposal_master[0]->asde_customer_name:'';
                ?>
            </span>
        </div>

        <div class="btn-group pull-right">

            <button class="btn btn-success PrintThisNow ReprintThis" id="btnPrintNowBtn" data-print="print" data-actionurl="<?php echo base_url('stock_inventory/auction_disposal/re_print_auction_disposal') ?>" data-viewdiv="FormDiv_Reprint" data-id="<?php echo !empty($sales_disposal_master[0]->asde_assetdesposalmasterid)?$sales_disposal_master[0]->asde_assetdesposalmasterid:''; ?>">

               Reprint

            </button>

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
                        <th width="8%">Asset Code </th>
                        <th width="8%">Description </th>
                        <th width="5%">Auction/Disposal Qty</th>
                        <th width="8%">Sales Cost</th>
                        <th width="5%"><?php echo $this->lang->line('remarks'); ?></th>
                    </tr>
                </thead>

                <tbody id="disposalSummaryBody">

                    <?php 

                    if(!empty($sales_disposal_detail)) { 

                        $salescost_tot = 0;
                        $total_item = 0;
                        foreach ($sales_disposal_detail as $key => $sdd) 
                        { 
                           $total_item += $sdd->asdd_disposalqty; 
                           $salescost_tot +=  $sdd->asdd_sales_amount;

                        ?>

                        <tr class="orderrow" id="orderrow_<?php echo $key+1 ?>" data-id='<?php echo $key+1 ?>'>

                        <td><?php echo $key+1; ?></td>

                        <td><?php echo $sdd->asen_assetcode ?></td>

                        <td><?php echo $sdd->asen_description ?></td>
                        
                        <td align="right"><?php echo $sdd->asdd_disposalqty ?></td>

                        <td align="right"><?php echo number_format($sdd->asdd_sales_totalamt,2) ?></td>

                        <td><?php echo $sdd->asdd_remarks; ?></td>

                    </tr>

                    <?php

                        } 

                    ?>

                </tbody>

                    <tfoot>

                        <tr>

                        <th colspan="3">

                        <h5 align="right" colspan="8" style="color: #333; padding-top: 0px; font-size: 12px;"><strong>Grand Total:</strong></h5>

                        <td align="right" style="color: #333; padding-top: 22px; font-size: 13px;">
                            <?php echo $total_item; ?></strong>
                        </td>

                        <td align="right" style="color: #333; padding-top: 22px; font-size: 13px;"><strong>

                            <?php echo number_format($salescost_tot,2) ?></strong>

                        </td>
                        <td></td>

                    </th>

                </tr> 

            </tfoot>

            </table>

            <?php } ?>

        </div>

        <div class="col-sm-4 col-xs-6">

            <label for="example-text">Full Remarks:</label>:

           <?php 

                echo !empty($sales_disposal_master[0]->asde_remarks)?$sales_disposal_master[0]->asde_remarks:'';

            ?>

        </div>

    </div>

</div>

<div id="FormDiv_Reprint" class="printTable"></div>    