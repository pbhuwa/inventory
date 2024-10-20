<style>
    .mcolor{
        background: #FF8C00 !important;
    }
</style>
<div class="form-group white-box pad-5 bg-gray">
    <div class="row">
        <div class="col-sm-4 col-xs-6">
            <label><?php echo $this->lang->line('requisition_no'); ?></label>: 
            <span> <?php echo !empty($handover_requisition_details[0]->harm_handoverreqno)?$handover_requisition_details[0]->harm_handoverreqno:''; ?></span>
        </div>
        
        <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('manual_no'); ?></label> : 
            <span><?php echo !empty($handover_requisition_details[0]->harm_manualno)?$handover_requisition_details[0]->harm_manualno:'0'; ?></span>
        </div>
        
        <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('req_date'); ?></label>: 
            <span class="inline_block">
                <b><?php echo !empty($handover_requisition_details[0]->harm_reqdatebs)?$handover_requisition_details[0]->harm_reqdatebs:''; ?></b> BS -- <b><?php echo !empty($handover_requisition_details[0]->harm_reqdatead)?$handover_requisition_details[0]->harm_reqdatead:''; ?></b> AD
            </span>
        </div>
        
        <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('from_branch'); ?></label>: 
            <span>
                <?php 
                echo !empty($handover_requisition_details[0]->fromloc)?$handover_requisition_details[0]->fromloc:'';
                ?>
            </span>
        </div>
        <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('from_department'); ?></label> : 
            <span> <?php echo !empty($handover_requisition_details[0]->fromdepname)?$handover_requisition_details[0]->fromdepname:'';
            ?></span>
        </div>
        <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('to_branch'); ?></label>: 
            <span>
                <?php 
                echo !empty($handover_requisition_details[0]->toloc)?$handover_requisition_details[0]->toloc:'';
                ?>
            </span>
        </div>

        <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('requisited_by'); ?> </label>: 
            <span><?php 
            $reqby=!empty($handover_requisition_details[0]->harm_requestedby)?$handover_requisition_details[0]->harm_requestedby:'';
            echo $reqby;
            ?></span>
        </div>

        <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('status'); ?> </label>: 
            <span>
                <?php 
                $approved_status=!empty($handover_requisition_details[0]->harm_approved)?$handover_requisition_details[0]->harm_approved:'';
                if($approved_status==1)
                {
                    echo "<span class='approved badge badge-sm badge-success'>Approved</span>"; 
                }
                else if($approved_status==2)
                {
                    echo "<span class='n_approved badge badge-sm badge-info'>Unapproved</span>";
                }
                else if($approved_status==3)
                {
                    echo "<span class='cancel badge badge-sm badge-danger'>Canceled</span>";
                }
                else if($approved_status==4)
                {
                    echo "<span class='cancel badge badge-sm badge-success'>Verified</span>";
                }
                else
                {
                    echo "<span class='pending badge badge-sm badge-warning'>Pending</span>";
                }
                ?>
            </span>
        </div> 
        
        <div class="col-sm-4 col-xs-6">
            <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?> </label>:
            <?php 
            $remafyear=!empty($handover_requisition_details[0]->harm_fyear)?$handover_requisition_details[0]->harm_fyear:'';
            echo $remafyear;
            ?>
        </div>
        
        <div class="btn-group pull-right">
          <?php   
          if($handover_requisition_details[0]->harm_approved=='2'){ 
            ?>
            <button style="margin-right: 5px;" class="btn btn-success btnredirect" data-print="print" data-viewurl="<?php echo base_url('/handover/handover_issue') ?>"  data-id="<?php echo !empty($handover_requisition_details[0]->harm_handoverreqno)?$handover_requisition_details[0]->harm_handoverreqno:''; ?>">
             <?php echo $this->lang->line('handover'); ?>
         </button>
     <?php } ?>
     <button class="btn btn-success PrintThisNow ReprintThis" id="btnPrintNowBtn" data-print="print" data-actionurl="<?php echo base_url('/handover/handover_req/handover_requisition_reprint') ?>" data-viewdiv="FormDiv_Reprint" data-id="<?php echo !empty($handover_requisition_details[0]->harm_handovermasterid)?$handover_requisition_details[0]->harm_handovermasterid:''; ?>">
        <?php echo $this->lang->line('reprint'); ?>
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
                        <th width="10%"><?php echo $this->lang->line('item_code'); ?> </th>
                        <th width="25%"><?php echo $this->lang->line('item_name'); ?> </th>
                        <th width="5%"><?php echo $this->lang->line('unit'); ?> </th>
                        <th width="5%"><?php echo $this->lang->line('req_qty'); ?> </th>
                        <th width="5%"><?php echo $this->lang->line('rem_qty'); ?> </th>
                        <th width="10%"><?php echo $this->lang->line('stock_quantity_during_req'); ?></th>
                        <th width="5%"><?php echo $this->lang->line('current_stock'); ?></th>
                        <th width="5%"><?php echo $this->lang->line('rate'); ?></th>
                        <th width="5%"><?php echo $this->lang->line('total_amt'); ?></th>
                    </tr>
                </thead>
                
                <tbody id="purchaseDataBody">
                    <?php 
                    if(!empty($handover_requisition)) { 
                        $grandtotal=0;
                        foreach ($handover_requisition as $key => $odr) 
                        { 
                            if(ITEM_DISPLAY_TYPE=='NP'){
                                $req_itemname = !empty($odr->itli_itemnamenp)?$odr->itli_itemnamenp:$odr->itli_itemname;
                            }else{ 
                                $req_itemname = !empty($odr->itli_itemname)?$odr->itli_itemname:'';
                            }

                            ?>
                            <tr class="orderrow <?php 
                            if($odr->hard_qtyinstock < $odr->itli_maxlimit)
                            { 
                                if($odr->hard_qtyinstock == 0)
                                {
                                    echo "warning";
                                    }else{
                                        echo "danger"; 
                                    }
                                } ?>" id="orderrow_1" data-id='1'>
                                <td><?php echo $key+1; ?></td>
                                <td><?php echo $odr->itli_itemcode ?></td>
                                <td><?php echo $req_itemname ?></td>
                                <td><?php echo $odr->unit_unitname ?></td>
                                <td align="right"><?php echo $odr->hard_qty ?></td>
                                <td align="right"><?php echo $odr->hard_remqty ?></td>
                                <td align="right"><?php echo $odr->hard_qtyinstock ?></td>
                                <td align="right"><?php echo $odr->cur_stock_qty ?></td>
                                <td align="right"><?php echo $odr->hard_unitprice ?></td>
                                <td align="right"><?php echo $odr->hard_totalamt; ?></td>
                            </tr>
                            <?php
                            $grandtotal +=$odr->hard_totalamt; } 
                        } 
                        ?>
                        <tfoot>
                            <tr>
                              <th  colspan="9">
                                <h5 align="right" colspan="8" style="color: #333; padding-top: 0px; font-size: 12px;">Estimated Cost:</h5>
                                <th align="right" style="color: #333; padding-top: 22px; font-size: 12px;">
                                    <?php echo round($grandtotal,2); ?>
                                </th>
                            </th>  
                        </tr>
                        <tr>
                            <td colspan="10">
                                <?php echo $this->lang->line('in_words'); ?>:
                                <?php echo $this->general->number_to_word($grandtotal); ?>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="FormDiv_Reprint" class="printTable"></div>    