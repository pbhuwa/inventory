    <div class="form-group white-box pad-5 bg-gray" style="padding-bottom: 10px;">
        <div class="row">
        <div class="col-md-3 col-sm-3">
            <label for="example-text"><?php echo $this->lang->line('transfer_number'); ?> : </label>
             <span> <?php echo !empty($transfer_master[0]->tfma_transferinvoice)?$transfer_master[0]->tfma_transferinvoice:''; ?></span>
        </div>

        <div class="col-md-3 col-sm-3">
            <label for=""><?php echo $this->lang->line('fiscal_year'); ?> : </label>
             <span><?php echo !empty($transfer_master[0]->tfma_fiscalyear)?$transfer_master[0]->tfma_fiscalyear:''; ?></span>
        </div>        
       
        <div class="col-md-3 col-sm-3">
            <?php $fromloc=!empty($transfer_master[0]->fromlocation)?$transfer_master[0]->fromlocation:''; ?>
            <label for="example-text"><?php echo $this->lang->line('location_from'); ?> :</label>
            <span><?php echo $fromloc; ?></span>
        </div>
        <div class="col-md-3 col-sm-3">
            <?php $toloc=!empty($transfer_master[0]->tolocation)?$transfer_master[0]->tolocation:''; ?>
            <label for="example-text"><?php echo $this->lang->line('location_to'); ?> :</label>
            <span><?php echo $toloc; ?></span>
        </div>
        <div class="col-md-3 col-sm-3">
            <?php $transfer_by=!empty($transfer_master[0]->tfma_transferby)?$transfer_master[0]->tfma_transferby:''; ?>
            <label for="example-text"><?php echo $this->lang->line('transfer_by'); ?> :</label>
            <span><?php echo $transfer_by; ?></span>
        </div>

        <div class="col-md-3 col-sm-3">
            <label for="example-text"><?php echo $this->lang->line('transfer'); ?> <?php echo $this->lang->line('date_ad'); ?> : </label>
            <span><?php echo !empty($transfer_master[0]->tfma_transferdatead)?$transfer_master[0]->tfma_transferdatead:''; ?></span>
        </div>

        <div class="col-md-3 col-sm-3">
            <label for="example-text"><?php echo $this->lang->line('transfer'); ?> <?php echo $this->lang->line('date_bs'); ?> : </label>
            <span><?php echo !empty($transfer_master[0]->tfma_transferdatebs)?$transfer_master[0]->tfma_transferdatebs:''; ?></span>
        </div>

        <div class="col-md-3 col-sm-3">
            <label for="example-text"><?php echo $this->lang->line('transfer_time'); ?> : </label>
            <span><?php echo !empty($transfer_master[0]->tfma_posttime)?$transfer_master[0]->tfma_posttime:''; ?></span>
        </div>

        <div class="clearfix"></div>

        <?php if($transfer_master[0]->tfma_isapproved == 'Y'): ?>
            <div class="col-md-3 col-sm-3">
                <?php $approved_by=!empty($transfer_master[0]->tfma_approvedusername)?$transfer_master[0]->tfma_approvedusername:''; ?>
                <label for="example-text"><?php echo $this->lang->line('approved_by'); ?>  :</label>
                <span><?php echo $approved_by; ?></span>
            </div>

            <div class="col-md-3 col-sm-3">
                <?php $approved_datebs=!empty($transfer_master[0]->tfma_approveddatebs)?$transfer_master[0]->tfma_approveddatebs:''; ?>
                <label for="example-text"><?php echo $this->lang->line('approved'); ?> <?php echo $this->lang->line('date_bs'); ?> :</label>
                <span><?php echo $approved_datebs; ?></span>
            </div>

            <div class="col-md-3 col-sm-3">
                <?php $approved_datead=!empty($transfer_master[0]->tfma_approveddatead)?$transfer_master[0]->tfma_approveddatead:''; ?>
                <label for="example-text"><?php echo $this->lang->line('approved'); ?> <?php echo $this->lang->line('date_ad'); ?> :</label>
                <span><?php echo $approved_datead; ?></span>
            </div>

            <div class="col-md-3 col-sm-3">
                <?php $approved_time=!empty($transfer_master[0]->tfma_approvedtime)?$transfer_master[0]->tfma_approvedtime:''; ?>
                <label for="example-text"><?php echo $this->lang->line('approved'); ?> <?php echo $this->lang->line('time'); ?> :</label>
                <span><?php echo $approved_time; ?></span>
            </div>
        <?php endif;?>

        <div class="clearfix"></div>

        <?php if($transfer_master[0]->tfma_isreceived == 'Y'): ?>
            <div class="col-md-3 col-sm-3">
                <?php $received_by=!empty($transfer_master[0]->tfma_receivedusername)?$transfer_master[0]->tfma_receivedusername:''; ?>
                <label for="example-text">Received By :</label>
                <span><?php echo $received_by; ?></span>
            </div>

            <div class="col-md-3 col-sm-3">
                <?php $received_datebs=!empty($transfer_master[0]->tfma_receiveddatebs)?$transfer_master[0]->tfma_receiveddatebs:''; ?>
                <label for="example-text">Received Date (BS) :</label>
                <span><?php echo $received_datebs; ?></span>
            </div>

            <div class="col-md-3 col-sm-3">
                <?php $received_datead=!empty($transfer_master[0]->tfma_receiveddatead)?$transfer_master[0]->tfma_receiveddatead:''; ?>
                <label for="example-text">Received Date (AD) :</label>
                <span><?php echo $received_datead; ?></span>
            </div>

            <div class="col-md-3 col-sm-3">
                <?php $received_time=!empty($transfer_master[0]->tfma_receivedtime)?$transfer_master[0]->tfma_receivedtime:''; ?>
                <label for="example-text">Received Time :</label>
                <span><?php echo $received_time; ?></span>
            </div>
        <?php endif;?>
    </div>
    <button class="btn btn-success PrintThisNow ReprintThis pull-right" id="btnPrintNowBtn" data-print="print" data-actionurl="<?php echo base_url('/issue_consumption/stock_transfer/stock_transfer_reprint') ?>" data-viewdiv="FormDiv_Reprint" data-id="<?php echo !empty($transfer_master[0]->tfma_tfmaid)?$transfer_master[0]->tfma_tfmaid:''; ?>"><?php echo $this->lang->line('reprint'); ?></button>
    
    </div>
<div class="form-group">
    <div class="row">
    <div class="table-responsive col-sm-12">
        <table style="width:100%;" class="table purs_table dataTable con_ttl">
            <thead>
                <tr>
                    <th width="5%" style="text-align: center"><?php echo $this->lang->line('sn'); ?> </th>
                    <th width="5%" style="text-align: center"><?php echo $this->lang->line('item_code'); ?></th>
                    <th width="20%" style="text-align: center"><?php echo $this->lang->line('item_name'); ?> </th>
                    <th width="10%" style="text-align: center"><?php echo $this->lang->line('unit'); ?> </th>
                   <th width="10%" style="text-align: center"><?php echo $this->lang->line('stock'); ?> </th>
                    <th width="10%" style="text-align: center"><?php echo $this->lang->line('req_transfer_qty'); ?> </th>
                    <th width="10%" style="text-align: center"><?php echo $this->lang->line('transfer_qty'); ?> </th>
                    <th width="10%" style="text-align: center"><?php echo $this->lang->line('remarks'); ?> </th>
                </tr>
            </thead>
            <tbody id="purchaseDataBody">
                <?php 
                    if(!empty($transfer_details)) { 
                        foreach ($transfer_details as $key => $odr) { 
                ?>
                <tr class="orderrow" id="orderrow_1" data-id='1'>
                    <td style="text-align: center">
                        <?php echo $key+1; ?>
                    </td> 
                    <td style="text-align: center">
                        <?php echo !empty($odr->tfde_itemcode)?$odr->tfde_itemcode:'';?>
                    </td>
                    <td style="text-align: center">
                        <?php echo  !empty($odr->tfde_itemname)?$odr->tfde_itemname:'';?> 
                    </td>
                    <td style="text-align: center">
                        <?php $unit=!empty($odr->unit_unitname)?$odr->unit_unitname:'';?> 
                        <?php echo $unit;?>
                    </td>
                  <!--   <td style="text-align: center">
                        <?php $cur_stock=!empty($cur_stock_qty[$key][0]->cur_stock)?$cur_stock_qty[$key][0]->cur_stock:0;?> 
                        <?php echo (int)$cur_stock;?>
                    </td> -->
                    <td style="text-align: center">
                        <?php $qty=!empty($odr->tfde_stockqty)?$odr->tfde_stockqty:0;?> 
                        <?php echo $qty;?>
                    </td>
                    <td style="text-align: center">
                        <?php $qty=!empty($odr->tfde_reqtransferqty)?$odr->tfde_reqtransferqty:0;?> 
                        <?php echo $qty;?>
                    </td>
                    <td style="text-align: center">
                        <?php $qty=!empty($odr->tfde_curtransferqty)?$odr->tfde_curtransferqty:0;?> 
                        <?php echo $qty;?>
                    </td>
                    <td style="text-align: center">
                        <?php $tfderemarks=!empty($odr->tfde_remarks)?$odr->tfde_remarks:'';?>
                        <?php echo $tfderemarks;?>
                    </td>
                </tr>
                <?php } } ?>
            </tbody>
        </table>
        </div>
    </div>
</div>
<div id="FormDiv_Reprint" class="printTable"></div> 