<style>

    .mcolor{

        background: #FF8C00 !important;

    }

</style>

<div class="form-group white-box pad-5 bg-gray">

    <div class="row">

        <div class="col-sm-4 col-xs-6">

            <label><?php echo $this->lang->line('requisition_no'); ?></label>: 

            <span> <?php echo !empty($stock_requisition_details[0]->rema_reqno)?$stock_requisition_details[0]->rema_reqno:''; ?></span>

        </div>

        

        <div class="col-sm-4 col-xs-6">

            <label for="example-text"><?php echo $this->lang->line('manual_no'); ?></label> : 

            <span><?php echo !empty($stock_requisition_details[0]->rema_manualno)?$stock_requisition_details[0]->rema_manualno:'0'; ?></span>

        </div>

        

        <div class="col-sm-4 col-xs-6">

            <label for="example-text"><?php echo $this->lang->line('req_date'); ?></label>: 

            <span class="inline_block">

            <b><?php echo !empty($stock_requisition_details[0]->rema_reqdatebs)?$stock_requisition_details[0]->rema_reqdatebs:''; ?></b> BS -- <b><?php echo !empty($stock_requisition_details[0]->rema_reqdatead)?$stock_requisition_details[0]->rema_reqdatead:''; ?></b> AD

            </span>

        </div>

        

        <div class="col-sm-4 col-xs-6">

            <label for="example-text"><?php echo $this->lang->line('department'); ?></label>: 

            <span>

                <?php 

                    $isdep=!empty($stock_requisition_details[0]->rema_isdep)?$stock_requisition_details[0]->rema_isdep:'';

                    if($isdep=='Y')

                    {

                        echo !empty($stock_requisition_details[0]->fromdepname)?$stock_requisition_details[0]->fromdepname:'';

                    }

                    else

                    {

                        echo !empty($stock_requisition_details[0]->fromdep_transfer)?$stock_requisition_details[0]->fromdep_transfer:'';

                    }

                ?>

            </span>

        </div>

        

        <div class="col-sm-4 col-xs-6">

            <label for="example-text">Store </label> : 

            <span> <?php echo !empty($stock_requisition_details[0]->todepname)?$stock_requisition_details[0]->todepname:'';

              ?></span>

        </div>



  <!--       <div class="col-sm-4 col-xs-6">

            <label for="example-text"><?php echo $this->lang->line('is_issue'); ?> </label>: 

            <span><?php echo $isdep=!empty($isdep)?$isdep:''; ?></span>

        </div> -->



        <div class="col-sm-4 col-xs-6">

            <label for="example-text"><?php echo $this->lang->line('requisited_by'); ?> </label>: 

            <span><?php 

              $reqby=!empty($stock_requisition_details[0]->rema_reqby)?$stock_requisition_details[0]->rema_reqby:'';

              echo $reqby;

              ?></span>

        </div>



        <div class="col-sm-4 col-xs-6">

            <label for="example-text"><?php echo $this->lang->line('status'); ?> </label>: 

            <span>

                <?php 

                    $approved_status=!empty($stock_requisition_details[0]->rema_approved)?$stock_requisition_details[0]->rema_approved:'';

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

                        echo "<span class='cancel badge badge-sm badge-info'>Verified</span>";

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

                $remafyear=!empty($stock_requisition_details[0]->rema_fyear)?$stock_requisition_details[0]->rema_fyear:'';

                echo $remafyear;

            ?>

        </div>
        <div class="col-sm-4 col-xs-6">

            <label>Material Type</label>:

            <?php

            $mattypeid = !empty($stock_requisition_details[0]->rema_mattypeid) ? $stock_requisition_details[0]->rema_mattypeid : '';

            if (!empty($mattypeid)) {

                $mat_data = $this->general->get_tbl_data('maty_material', 'maty_materialtype', array('maty_materialtypeid' => $mattypeid));

                if (!empty($mat_data)) {

                    echo !empty($mat_data[0]->maty_material) ? $mat_data[0]->maty_material : '';
                } else {

                    echo "---";
                }
            }



            ?>

        </div>

         <div class="col-sm-4 col-xs-6">

            <label for="example-text"><?php echo $this->lang->line('location'); ?> </label>:

           <?php 

                $loca_name=!empty($stock_requisition_details[0]->locationname)?$stock_requisition_details[0]->locationname:'';

                echo $loca_name;

            ?>

        </div>

        

        <div class="btn-group pull-right">

            <?php   

                if($stock_requisition_details[0]->rema_approved=='1'){ 

            ?>

            <button style="margin-right: 5px;" class="btn btn-success btnredirect" data-print="print" data-viewurl="<?php echo base_url('/issue_consumption/new_issue') ?>"  data-id="<?php echo !empty($stock_requisition_details[0]->rema_reqno)?$stock_requisition_details[0]->rema_reqno:''; ?>">

                <?php echo $this->lang->line('issue'); ?>

            </button>

            <?php } ?>



            <button class="btn btn-success PrintThisNow ReprintThis" id="btnPrintNowBtn" data-print="print" data-actionurl="<?php echo base_url('/issue_consumption/stock_requisition/stock_requisition_reprint') ?>" data-viewdiv="FormDiv_Reprint" data-id="<?php echo !empty($stock_requisition_details[0]->rema_reqmasterid)?$stock_requisition_details[0]->rema_reqmasterid:''; ?>">

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

                        <th width="8%"><?php echo $this->lang->line('item_code'); ?> </th>

                        <th width="20%"><?php echo $this->lang->line('item_name'); ?> </th>

                        <th width="5%"><?php echo $this->lang->line('unit'); ?> </th>

                        <th width="5%"><?php echo $this->lang->line('req_qty'); ?> </th>

                        <th width="5%"><?php echo $this->lang->line('rem_qty'); ?> </th>

                        <th width="10%"><?php echo $this->lang->line('stock_quantity_during_req'); ?></th>

                        <th width="5%"><?php echo $this->lang->line('current_stock'); ?></th>

                        <th width="5%"><?php echo $this->lang->line('rate'); ?></th>

                        <th width="5%"><?php echo $this->lang->line('total_amount'); ?></th>

                        <th width="5%"><?php echo $this->lang->line('remarks'); ?></th>

                    </tr>

                </thead>

                

                <tbody id="purchaseDataBody">

                    <?php 

                    // echo "<pre>";

                    // print_r($stock_requisition);

                    // die();

                        if(!empty($stock_requisition)) { 

                            $grandtotal=0;

                            foreach ($stock_requisition as $key => $odr) 

                            { 

                                if(ITEM_DISPLAY_TYPE=='NP'){

                                    $req_itemname = !empty($odr->itli_itemnamenp)?$odr->itli_itemnamenp:$odr->itli_itemname;

                                }else{ 

                                    $req_itemname = !empty($odr->itli_itemname)?$odr->itli_itemname:'';

                                }



                                $req_qty = $odr->rede_qty;

                                $unitprice = $odr->rede_unitprice;

                                $req_total_amt = $req_qty * $unitprice;

                

                    ?>

                    <tr class="orderrow <?php 

                        if($odr->rede_qtyinstock < $odr->itli_maxlimit)

                        { 

                            if($odr->rede_qtyinstock == 0)

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

                        <td align="right"><?php echo sprintf('%g',$odr->rede_qty); ?></td>

                        <td align="right"><?php echo sprintf('%g',$odr->rede_remqty); ?></td>

                        <td align="right"><?php echo sprintf('%g',$odr->rede_qtyinstock); ?></td>

                        <td align="right"><?php echo sprintf('%g',$odr->cur_stock_qty); ?></td>

                        <td align="right"><?php echo $odr->rede_unitprice ?></td>

                        <td align="right"><?php echo number_format($req_total_amt,2) ?></td>

                        <td><?php echo $odr->rede_remarks; ?></td>

                    </tr>

                <?php

                    $grandtotal +=$req_total_amt; } 

                    } 

                ?>

                </tbody>

                    <tfoot>

                        <tr>

                    <th  colspan="10">

                        <h5 align="right" colspan="8" style="color: #333; padding-top: 0px; font-size: 12px;"><strong>Estimated Cost:</strong></h5>

                        <td align="right" style="color: #333; padding-top: 22px; font-size: 13px;"><strong>

                            <?php echo number_format($grandtotal,2) ?></strong>

                        </td>

                    </th>

                </tr>

                <?php if($grandtotal >'0.00'): ?>

                <tr>

                    <td colspan="11"><strong><?php echo $this->lang->line('in_words'); ?>: <?php echo $this->general->number_to_word($grandtotal); ?></strong></td>

                </tr>

            <?php endif; ?>

            </tfoot>



                

            </table>

        </div>

    </div>

</div>

<div id="FormDiv_Reprint" class="printTable"></div>    