<div class="form-group white-box pad-5 bg-gray">
    <div class="row">
        <div class="col-md-2 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('invoice_no'); ?> : </label>
             <span> <?php echo !empty($return_master[0]->rema_receiveno)?$return_master[0]->rema_receiveno:''; ?></span>
        </div>
        <div class="col-md-4 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('issue_date'); ?> : </label>
            <span><b><?php echo !empty($return_master[0]->rema_returndatebs)?$return_master[0]->rema_returndatebs:''; ?></b> <?php echo $this->lang->line('bs'); ?> -- <b><?php echo !empty($return_master[0]->rema_returndatead)?$return_master[0]->rema_returndatead:''; ?> </b><?php echo $this->lang->line('ad'); ?></span>
        </div>
        <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?> : </label>
            <span><?php echo !empty($return_master[0]->rema_fyear)?$return_master[0]->rema_fyear:''; ?></span>
        </div>
        <div class="col-md-3 col-sm-4">
            <?php $time=!empty($return_master[0]->rema_posttime)?$return_master[0]->rema_posttime:''; //print_r($datedb);die;?>
              <label for="example-text">Return Tine : </label>
            <?php echo $time;?>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-3 col-sm-4">
            <label for=""><?php echo $this->lang->line('return_by'); ?> : </label>
             <span><?php echo !empty($return_master[0]->rema_returnby)?$return_master[0]->rema_returnby:''; ?></span>
        </div>
      <!--   <div class="col-md-3 col-sm-4">
            <?php $samareceivedby=!empty($return_master[0]->sama_receivedby)?$return_master[0]->sama_receivedby:''; ?>
            <label for="example-text"><?php echo $this->lang->line('received_by'); ?>  : </label>
            <span><?php echo $samareceivedby; ?></span>
        </div>
        <div class="col-md-3 col-sm-4">
            <?php $samarequisitionno=!empty($return_master[0]->sama_requisitionno)?$return_master[0]->sama_requisitionno:''; ?>
            <label for="example-text"><?php echo $this->lang->line('requisition_no'); ?> :</label>
            <span><?php echo $samarequisitionno; ?></span>
        </div>
        <div class="col-md-3 col-sm-4">
            <?php $samabillno=!empty($return_master[0]->sama_billno)?$return_master[0]->sama_billno:''; ?>
            <label for="example-text"><?php echo $this->lang->line('bill_no'); ?> :</label>
           <span> <?php echo $samabillno; ?></span>
        </div> -->
    </div>
    <button class="btn btn-success PrintThisNow ReprintThis pull-right" id="btnPrintNowBtn" data-print="print" data-id="<?php echo !empty($return_master[0]->rema_returnmasterid)?$return_master[0]->rema_returnmasterid:''; ?>" data-actionurl="<?php  echo base_url('issue_consumption/new_issue/reprint_issue_return') ?>" data-viewdiv="FormDiv_Reprint"><?php echo $this->lang->line('reprint'); ?></button>
    <div class="clearfix"></div>
</div>

<div class="form-group">
    <div class="row">
    <div class="table-responsive col-sm-12">
        <table style="width:100%;" class="table purs_table dataTable con_ttl">
            <thead>
                <tr>
                    <th width="5%"><?php echo $this->lang->line('sn'); ?> </th>
                    <th width="5%"><?php echo $this->lang->line('item_code'); ?></th>
                    <th width="15%"><?php echo $this->lang->line('item_name'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('unit'); ?> </th>
                     <th width="5%">Price</th>
                    <th width="5%"><?php echo $this->lang->line('qty'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('total'); ?></th>
                   
                  </th>
                </tr>
            </thead>
            <tbody id="purchaseDataBody">
                <?php 

                    if(!empty($return_details)) { 
                   
                         $gtotal=0;

                        foreach ($return_details as $key => $odr) 
                            { 
                 if(ITEM_DISPLAY_TYPE=='NP'){
                    $req_itemname = !empty($odr->itli_itemnamenp)?$odr->itli_itemnamenp:$odr->itli_itemname;
                }else{ 
                    $req_itemname = !empty($odr->itli_itemname)?$odr->itli_itemname:'';
                }
                                
                                ?>
                <tr class="orderrow" id="orderrow_1" data-id='1'>
                    <td>
                         <?php echo $key+1; ?>
                    </td> 
                    <td>
                        <?php echo $odr->itli_itemcode;?>
                    </td>
                    <td>
                        <?php echo $req_itemname; ?> 
                    </td>
                    <td>
                        <?php $unit=!empty($odr->unit_unitname)?$odr->unit_unitname:'';?> 
                        <?php echo $unit;?>
                    </td>
                     <td>
                        <?php $qty=!empty($odr->rede_qty)?$odr->rede_qty:'';?> 
                        <?php echo $qty;?>
                    </td>
                  
                     <td>
                        <?php $price=!empty($odr->rede_unitprice)?$odr->rede_unitprice:0;?> 
                        <?php echo $price;?>
                    </td>
                  
                   
                   
                     <td>
                    <?php $total=!empty($odr->rede_total)?$odr->rede_total:0;?> 
                        <?php echo $total;?>
                    </td>
                   
                </tr>
                <?php 
                  $gtotal+=$total;
                        }

                    } 

                ?>
            <tr>
                <th colspan="4" style="text-align: right; border-right: 1px solid">Total</th>
                <th colspan="2" style="border-bottom: 1px solid; border-right: 1px solid"><?php echo !empty($gtotal)?$gtotal:'0'; ?></th>
             </tr>

                
            </tbody>
        </table>
        </div>
    </div>
</div>

<div id="FormDiv_Reprint" class="printTable"></div>
