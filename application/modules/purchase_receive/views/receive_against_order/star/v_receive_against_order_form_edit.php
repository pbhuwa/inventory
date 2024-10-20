<style>
.purs_table tbody tr td {
    border: none;
    vertical-align: center;
}
</style>

<form method="post" id="FormReceiveOrderItem"
    action="<?php echo base_url('purchase_receive/receive_against_order/update_received_items'); ?>"
    class="form-material form-horizontal form" enctype="multipart/form-data" accept-charset="utf-8"
    data-reloadurl="<?php echo base_url('purchase_receive/receive_against_order/received_order_item_list'); ?>"
    data-isredirect="true">
    <div id="orderData">
        <input type="hidden" name="id" value="" />
        <input type="hidden" name="receivedmasterid" id="receivedmasterid"
            value="<?php echo !empty($receive_data_master[0]->recm_receivedmasterid) ? $receive_data_master[0]->recm_receivedmasterid : ''; ?>" />
        <div class="form-group row">
            <div class="col-md-2 col-sm-2">
                <?php $fiscalyear = !empty($receive_data_master[0]->recm_fyear) ? $receive_data_master[0]->recm_fyear : ''; ?>
                <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?><span
                        class="required">*</span>:</label>
                <select name="fiscalyear" class="form-control select2" id="fiscalyear" disabled="disabled">
                    <option value="">---select---</option>
                    <?php
                    if ($fiscal) :
                        foreach ($fiscal as $km => $fy) :
                    ?>
                    <option value="<?php echo $fy->fiye_name; ?>"
                        <?php if ($fiscalyear == $fy->fiye_name) echo "selected=selected"; ?>>
                        <?php echo $fy->fiye_name; ?></option>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </select>
            </div>
            <div class="col-md-3 col-sm-3">
                <label for="mattypeid">Choose Material Type : </label><br>
                <?php
                $rema_mattype = !empty($receive_data_master[0]->recm_mattypeid) ? $receive_data_master[0]->recm_mattypeid : 1;
                ?>
                <select name="recm_mattypeid" id="mattypeid" class="form-control chooseMatType required_field"
                    disabled="disabled">
                    <?php
                    if (!empty($material_type)) :
                        foreach ($material_type as $mat) :
                    ?>
                    <option value="<?php echo $mat->maty_materialtypeid; ?>"
                        <?php if ($rema_mattype == $mat->maty_materialtypeid) echo "selected=selected"; ?>>
                        <?php echo $mat->maty_material; ?></option>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </select>
            </div>

            <div class="col-md-1 col-sm-1">
                <?php $orderno = !empty($receive_data_master[0]->recm_purchaseorderno) ? $receive_data_master[0]->recm_purchaseorderno : ''; ?>
                <label for="example-text"><?php echo $this->lang->line('order_no'); ?><span
                        class="required">*</span>:</label>
                <div class="dis_tab">
                    <a href="javascript:void(0)" title="View"
                        data-id="<?php echo !empty($receive_data_master[0]->recm_purchaseordermasterid) ? $receive_data_master[0]->recm_purchaseordermasterid : ''; ?>"
                        data-displaydiv="orderDetails"
                        data-viewurl="<?php echo base_url('purchase_receive/purchase_order/details_order_views'); ?>"
                        class="view btn-primary btn-xxs"
                        data-heading="Order Detail"><span><?php echo $orderno  ?></span> </a>
                </div>
            </div>

            <div class="col-md-3 col-sm-3">
                <?php $supid = !empty($receive_data_master[0]->recm_supplierid) ? $receive_data_master[0]->recm_supplierid : ''; ?>
                <label for="example-text"><?php echo $this->lang->line('supplier_name'); ?> <span
                        class="required">*</span>:</label>
                <select name="supplierid" class="form-control required_field select2" id="supplierid">
                    <option value="">---select---</option>
                    <?php
                    if ($supplier_all) :
                        foreach ($supplier_all as $km => $sup) :
                    ?>
                    <option value="<?php echo $sup->dist_distributorid; ?>"
                        <?php if ($supid == $sup->dist_distributorid) echo "selected=selected"; ?>>
                        <?php echo $sup->dist_distributor; ?></option>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </select>
            </div>
            <div class="col-md-3 col-sm-3">
                <label for="example-text"><?php echo $this->lang->line('order_date'); ?> </label>
                <?php
                $recm_orderdatebs_db = !empty($receive_data_master[0]->recm_purchaseorderdatebs) ? $receive_data_master[0]->recm_purchaseorderdatebs : '';
                $recm_orderdatead_db = !empty($receive_data_master[0]->recm_purchaseorderdatead) ? $receive_data_master[0]->recm_purchaseorderdatead : '';
                if (DEFAULT_DATEPICKER == 'NP') :
                    $orderdate = $recm_orderdatebs_db;
                else :
                    $orderdate = $recm_orderdatead_db;
                endif;
                ?>
                <br>
                <span><?php echo $orderdate; ?></span>

                <span class="errmsg"></span>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3 col-sm-3">
                <label for="example-text"><?php echo $this->lang->line('received_number'); ?></label>
                <?php $recm_invoiceno_db = !empty($receive_data_master[0]->recm_invoiceno) ? $receive_data_master[0]->recm_invoiceno : ''; ?>
                <br>
                <span><?php echo !empty($recm_invoiceno_db) ? $recm_invoiceno_db : ''; ?></span>

            </div>
            <div class="col-md-3 col-sm-3">
                <label for="example-text"><?php echo $this->lang->line('received_date'); ?><span
                        class="required">*</span>:</label>
                <?php
                if (DEFAULT_DATEPICKER == 'NP') {
                    $received_date = !empty($receive_data_master[0]->recm_receiveddatebs) ? $receive_data_master[0]->recm_receiveddatebs : DISPLAY_DATE;
                } else {
                    $received_date = !empty($receive_data_master[0]->recm_receiveddatead) ? $receive_data_master[0]->recm_receiveddatead : DISPLAY_DATE;
                }

                ?>
                <input type="text" name="received_date"
                    class="form-control required_field <?php echo DATEPICKER_CLASS; ?> date"
                    placeholder="<?php echo $this->lang->line('received_date'); ?>"
                    value="<?php echo $received_date; ?>" id="ReceivedDate">
                <span class="errmsg"></span>
            </div>
            <div class="col-md-3 col-sm-3">
                <?php $suplier_bill_nodb = !empty($receive_data_master[0]->recm_supplierbillno) ? $receive_data_master[0]->recm_supplierbillno : ''; ?>
                <label for="example-text"><?php echo $this->lang->line('supplier_bill_no'); ?> <span
                        class="required">*</span>:</label>
                <input type="text" class="form-control required_field" name="suplier_bill_no"
                    value="<?php echo $suplier_bill_nodb; ?>" placeholder="Supplier Bill No. ">
            </div>
            <div class="col-md-3 col-sm-3">
                <?php
                if (DEFAULT_DATEPICKER == 'NP') {
                    $sup_bill_date = !empty($receive_data_master[0]->recm_supbilldatebs) ? $receive_data_master[0]->recm_supbilldatebs : DISPLAY_DATE;
                } else {
                    $sup_bill_date = !empty($receive_data_master[0]->recm_supbilldatead) ? $receive_data_master[0]->recm_supbilldatead : DISPLAY_DATE;
                }

                ?>
                <label for="example-text"><?php echo $this->lang->line('supplier_bill_date'); ?><span
                        class="required">*</span>: </label>

                <input type="text" name="suplier_bill_date"
                    class="form-control required_field <?php echo DATEPICKER_CLASS; ?> date"
                    placeholder="<?php echo $this->lang->line('supplier_bill_date'); ?>"
                    value="<?php echo $sup_bill_date; ?>" id="SupBillDate">
                <span class="errmsg"></span>
            </div>

            <div class="col-md-3 col-sm-3">

                <label class="pr-10 table-cell width_75">AC. Head<span class="required">*</span>:</label>
                <?php $bugetid = !empty($receive_data_master[0]->recm_budgetid) ? $receive_data_master[0]->recm_budgetid : ''; ?>
                <select class="table-cell form-control select2 required_field" name="bugetid">
                    <option value="">--- Select ---</option>
                    <?php if (!empty($budgets_list)) :
                        foreach ($budgets_list as $kb => $buget) :
                    ?>
                    <option value="<?php echo $buget->budg_budgetid; ?>"
                        <?php if ($bugetid == $buget->budg_budgetid) echo "selected=selected"; ?>>
                        <?php echo $buget->budg_budgetname; ?></option>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </select>
                <!-- <a href="javascript:void(0)" class="table-cell width_30 text-center"><i class="fa fa-plus"></i></a> -->

            </div>
            <div class="col-md-3 col-sm-3" style="display: none" id="received_by_div">
                <label>Received By</label>
                <select class="form-control select2" name="recm_receivedby">
                    <?php
                    $staff_id = !empty($receive_data_master[0]->recm_receivedstaffid) ? $receive_data_master[0]->recm_receivedstaffid : '';

                    $staff_info = $this->general->get_tbl_data('*', 'stin_staffinfo');
                    if (!empty($staff_info)) :
                        foreach ($staff_info as $ks => $sta) {
                    ?>
                    <option
                        value="<?php echo $sta->stin_staffinfoid . ',' . $sta->stin_fname . ' ' . $sta->stin_mname . ' ' . $sta->stin_lname ?>"
                        <?php if ($staff_id == $sta->stin_staffinfoid) echo "selected=selected"; ?>>
                        <?php echo $sta->stin_fname . ' ' . $sta->stin_mname . ' ' . $sta->stin_lname ?></option>
                    <?php
                        }
                    endif
                    ?>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="pad-5" id="displayDetailList">
            <div class="table-responsive col-sm-12">
                <table style="width:100%;" class="table purs_table dataTable">
                    <thead>
                        <tr>
                            <th width="2%"><?php echo $this->lang->line('sn'); ?></th>
                            <th width="8%"><?php echo $this->lang->line('item_code'); ?></th>
                            <th width="15%"><?php echo $this->lang->line('item_name'); ?></th>
                            <!-- <th width="10%">Batch No </th> -->
                            <th width="8%"><?php echo $this->lang->line('unit'); ?></th>
                            <th width="8%"><?php echo $this->lang->line('odr_qty'); ?></th>
                            <th width="8%"><?php echo $this->lang->line('qty'); ?></th>
                            <!-- <th width="8%">Free</th> -->
                            <th width="8%"><?php echo $this->lang->line('rate'); ?></th>
                            <th width="8%"><?php echo $this->lang->line('cc'); ?></th>
                            <th width="8%"><?php echo $this->lang->line('dis'); ?></th>
                            <th width="8%"><?php echo $this->lang->line('vat'); ?></th>
                            <th width="10%"><?php echo $this->lang->line('amount'); ?></th>
                            <th width="8%">Batch No</th>
                            <th width="12%"><?php echo $this->lang->line('exp_datebs'); ?></th>
                            <th width="10%"><?php echo $this->lang->line('description'); ?></th>
                            <th width="5%"><?php echo $this->lang->line('action'); ?></th>
                        </tr>
                    </thead>

                    <tbody id="purchaseOrderDataBody">
                        <?php
                        if (!empty($receive_data_detail)) :
                            $i = 1;
                            foreach ($receive_data_detail as $rdd) :
                        ?>
                        <tr id="row_<?php echo $i; ?> receivedOrderItem_<?php echo $i; ?>" class="receivedItems">
                            <input type="hidden" name="recd_receiveddetailid[]"
                                value="<?php echo $rdd->recd_receiveddetailid; ?>">
                            <input type="hidden" class="itemsid" name="itemsid[]"
                                value="<?php echo $rdd->recd_itemsid; ?>" id="itemsid_<?php echo $i; ?>" />
                            <input type="hidden" class="order_qty" name="order_qty[]"
                                value="<?php echo $rdd->orderqty; ?>" id="order_qty_<?php echo $i; ?>">

                            <td><?php echo $i ?></td>
                            <td><?php echo $rdd->itli_itemcode; ?></td>
                            <td><?php echo $rdd->itli_itemname ?></td>
                            <td><?php echo $rdd->unit_unitname ?></td>
                            <td><?php echo sprintf('%g', $rdd->recd_purchasedqty) ?></td>
                            <td>
                                <?php $rdd->recd_purchasedqty; ?>
                                <input type="text" class="form-control float calamt recqty arrow_keypress"
                                    name="received_qty[]" data-fieldid="recqty"
                                    value="<?php echo sprintf('%g', $rdd->recd_purchasedqty); ?>"
                                    data-id="<?php echo $i; ?>" id="recqty_<?php echo $i; ?>">
                            </td>
                            <td>
                                <input type="text" class="form-control float calamt rate" name="rate[]"
                                    id="rate_<?php echo $i; ?>" value="<?php echo $rdd->recd_unitprice ?>"
                                    data-id="<?php echo $i; ?>">
                                <input type="hidden" class="form-control float calamt purchase_rate[]"
                                    name="purchase_rate[]" id="purchase_rate_<?php echo $i; ?>"
                                    value="<?php echo $rdd->recd_unitprice ?>" data-id="<?php echo $i; ?>">
                            </td>
                            <td>
                                <input type="text" class="form-control number calamt cc" name="cc[]"
                                    id="cc_<?php echo $i; ?>" value="0" data-id="<?php echo $i; ?>">
                            </td>
                            <td>
                                <input type="text" class="form-control float calamt discount discountpc arrow_keypress"
                                    name="discount[]" data-fieldid="discount" id="discount_<?php echo $i; ?>"
                                    value="<?php echo sprintf('%g', $rdd->recd_discountpc); ?>"
                                    data-id="<?php echo $i; ?>">
                                <input type="hidden" name="disamt[]" value="<?php echo $rdd->recd_discountamt; ?>"
                                    id="disamt_<?php echo $i; ?>" class="disamt calamt">
                            </td>
                            <td>
                                <input type="text" class="form-control float calamt vat arrow_keypress" name="vat[]"
                                    id="vat_<?php echo $i; ?>" data-fieldid="vat"
                                    value="<?php echo sprintf('%g', $rdd->recd_vatpc); ?>" data-id="<?php echo $i; ?>">
                                <input type="hidden" name="vatamt[]" value="<?php echo $rdd->recd_vatamt; ?>"
                                    id="vatamt_<?php echo $i; ?>" class="vatamt calamt">
                            </td>
                            <td>
                                <input type="text" class="form-control eachtotalamt amt" name="amount[]"
                                    value="<?php echo $rdd->recd_amount; ?>" readonly="readonly"
                                    id="amt_<?php echo $i; ?>">
                                <input type="hidden" class="form-control eachratexqty ratexqty" name="ratexqty[]"
                                    value="<?php echo $rdd->recd_purchasedqty * $rdd->recd_unitprice; ?>"
                                    id="ratexqty_<?php echo $i; ?>">
                            </td>
                            <td>
                                <input type="text" class="form-control batchno" name="batchno[]"
                                    value="<?php echo $rdd->recd_batchno; ?>" id="batch_no_<?php echo $i; ?>">
                            </td>
                            <td>
                                <?php
                                        if (DEFAULT_DATEPICKER == 'NP') {
                                            $expiry_date = $rdd->recd_expdatebs ?: DISPLAY_DATE;
                                        } else {
                                            $expiry_date = $rdd->recd_expdatead ?: DISPLAY_DATE;
                                        }

                                        ?>
                                <input type="text" class="form-control <?php echo DATEPICKER_CLASS; ?> expiry_date "
                                    name="expiry_date[]" id="expiry_date_<?php echo $i; ?>"
                                    data-id='expiry_date_<?php echo $i; ?>' value="<?php echo $expiry_date ?>">
                            </td>

                            <td>
                                <?php $recd_descriptiondb = !empty($rdd->recd_description) ? $rdd->recd_description : ''; ?>


                                <textarea class="form-control description" name="description[]"
                                    style="margin: 0px; width: 261px; height: 76px; line-height: 18px;"
                                    id="description_<?php echo $i; ?>"
                                    data-id="<?php echo $i; ?>"><?php echo $recd_descriptiondb; ?></textarea>

                            </td>


                            <td>
                                <a href="javascript:void(0)" class="btn btn-sm btn-danger btnRemove"
                                    id="btnRemove_<?php echo $i; ?>" data-id="<?php echo $i; ?>">
                                    <i class="fa fa-remove"></i>
                                </a>
                            </td>
                        </tr>
                        <?php $i++;
                            endforeach;
                        endif; ?>
                    </tbody>
                </table>

                <div class="roi_footer">
                    <div class="row">
                        <div class="col-sm-4">

                            <div class="dis_tab">
                                <label class="vt d-block"><?php echo $this->lang->line('remarks'); ?></label>
                                <textarea name="remarks" id="" cols="40" rows="5"
                                    class="form-control table-cell vt"></textarea>
                            </div>

                            <div class="mtop_15">
                                <label>Attachments</label>
                                <div class="dis_tab">
                                    <input type="file" id="recm_attachments" name="recm_attachments[]" />
                                    <input type="hidden" name="recm_attach[]">
                                    <a href="javascript:void(0)" class="btn btn-info table-cell width_30"
                                        id="addAttachments">+</a>
                                </div>
                                <div class="addAttachmentRow">
                                    <?php

                                    $contractAttachments = !empty($contract_data[0]->recm_attachments) ? $contract_data[0]->recm_attachments : '';
                                    if ($contractAttachments) :
                                        $attach = explode(', ', $contractAttachments);
                                        $download = "";
                                        if ($attach) :
                                            foreach ($attach as $key => $value) {
                                                $download .= "<a href='" . base_url() . RECEIVED_BILL_ATTACHMENT_PATH . '/' . $value . "' target='_blank'>Download<a>&nbsp;&nbsp;&nbsp;";
                                            }
                                        endif;
                                        echo $download;
                                    endif;
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 pull-right">
                            <fieldset class="pull-right mtop_10 pad-top-14">
                                <?php
                                $recm_amount = !empty($receive_data_master[0]->recm_amount) ? $receive_data_master[0]->recm_amount : '';
                                $recm_discount = !empty($receive_data_master[0]->recm_discount) ? $receive_data_master[0]->recm_discount : '';
                                $recm_taxamount = !empty($receive_data_master[0]->recm_taxamount) ? $receive_data_master[0]->recm_taxamount : '';
                                $recm_refund = !empty($receive_data_master[0]->recm_refund) ? $receive_data_master[0]->recm_refund : '';
                                $recm_clearanceamount = !empty($receive_data_master[0]->recm_clearanceamount) ? $receive_data_master[0]->recm_clearanceamount : '';
                                $recm_challanno = !empty($receive_data_master[0]->recm_challanno) ? $receive_data_master[0]->recm_challanno : '';

                                $recm_insurance = !empty($receive_data_master[0]->recm_insurance) ? $receive_data_master[0]->recm_insurance : '';
                                $recm_carriagefreight = !empty($receive_data_master[0]->recm_carriagefreight) ? $receive_data_master[0]->recm_carriagefreight : '';
                                $recm_packing = !empty($receive_data_master[0]->recm_packing) ? $receive_data_master[0]->recm_packing : '';
                                $recm_transportcourier = !empty($receive_data_master[0]->recm_transportcourier) ? $receive_data_master[0]->recm_transportcourier : '';
                                $recm_others = !empty($receive_data_master[0]->recm_others) ? $receive_data_master[0]->recm_others : '';

                                $recm_othersdescription = !empty($receive_data_master[0]->recm_othersdescription) ? $receive_data_master[0]->recm_othersdescription : '';

                                $recm_remarks = !empty($receive_data_master[0]->recm_remarks) ? $receive_data_master[0]->recm_remarks : '';
                                $recm_attachments = !empty($receive_data_master[0]->recm_attachments) ? $receive_data_master[0]->recm_attachments : '';
                                $recm_billupload = !empty($receive_data_master[0]->recm_billupload) ? $receive_data_master[0]->recm_billupload : '';
                                $recm_currencysymbol = !empty($receive_data_master[0]->recm_currencysymbol) ? $receive_data_master[0]->recm_currencysymbol : '';
                                $recm_currencyrate = !empty($receive_data_master[0]->recm_currencyrate) ? $receive_data_master[0]->recm_currencyrate : '';
                                $recm_actualclearanceamount = !empty($receive_data_master[0]->recm_actualclearanceamount) ? $receive_data_master[0]->recm_actualclearanceamount : '';
                                ?>
                                <ul>
                                    <li>
                                        <label><?php echo $this->lang->line('total_amount'); ?></label>
                                        <input type="text" class="form-control float totalamount" name="totalamount"
                                            value="<?php echo $recm_amount; ?>" id="totalamount" readonly="true" />
                                    </li>
                                    <li>
                                        <label><?php echo $this->lang->line('discount_in_amount'); ?></label>
                                        <input type="text" class="form-control float discountpc" name="discountamt"
                                            id="discountamt" value="<?php echo $recm_discount; ?>" readonly="true" />
                                    </li>

                                    <li>
                                        <label>
                                            <?php echo !empty($this->lang->line('overall_discount')) ? $this->lang->line('overall_discount') : 'Overall Discount'; ?>
                                        </label>

                                        <input type="text" class="form-control float" name="discountamt_overall"
                                            id="overall_discount" value="<?php echo $recm_discount; ?>"
                                            data-discount="amt" />
                                    </li>

                                    <li>
                                        <label><?php echo $this->lang->line('sub_total'); ?></label>
                                        <input type="text" class="form-control float" name="subtotalamt"
                                            id="subtotalamt" value="<?php echo $recm_amount; ?>" readonly="true" />
                                    </li>
                                    <li>
                                        <label><?php echo $this->lang->line('total_tax'); ?> </label>
                                        <input type="text" class="form-control float" name="taxamt" id="taxamt"
                                            value="<?php echo $recm_taxamount; ?>" readonly="true" />

                                    </li>
                                    <li>
                                        <label><?php echo $this->lang->line('extra_charges'); ?></label>
                                        <input type="text" class="form-control float" name="extra" id="extra" value="0"
                                            readonly="true" />
                                    </li>
                                    <li>
                                        <label><?php echo $this->lang->line('rf'); ?></label>
                                        <input type="text" class="form-control float calculaterefund" name="refund"
                                            id="refund" value="<?php echo $recm_refund; ?>" placeholder="" />
                                    </li>
                                    <li>
                                        <label><?php echo $this->lang->line('clearance_amt'); ?></label>
                                        <input type="text" class="form-control" name="clearanceamt" id="clearanceamt"
                                            value="<?php echo $recm_clearanceamount; ?>">
                                    </li>
                                </ul>
                            </fieldset>

                            <fieldset class="pull-right bordered">
                                <legend class="font_12"><?php echo $this->lang->line('other_charges'); ?></legend>
                                <ul>
                                    <li>
                                        <label><?php echo $this->lang->line('insurance'); ?>:</label>
                                        <input type="text" class="form-control float calculateextra" name="insurance"
                                            id="insurance" value="<?php echo $recm_insurance; ?>" data-discount="per" />
                                    </li>
                                    <li>
                                        <label><?php echo $this->lang->line('carriage_freight'); ?> :</label>
                                        <input type="text" class="form-control float calculateextra" name="carriage"
                                            id="carriage" value="<?php echo $recm_carriagefreight; ?>"
                                            data-discount="amt" />
                                    </li>
                                    <li>
                                        <label><?php echo $this->lang->line('packing'); ?> :</label>
                                        <input type="text" class="form-control float calculateextra" name="packing"
                                            id="packing" value="<?php echo $recm_packing; ?>" />
                                    </li>
                                    <li>
                                        <label><?php echo $this->lang->line('transport_courier'); ?> :</label>
                                        <input type="text" class="form-control float calculateextra" name="transportamt"
                                            id="transportamt" value="<?php echo $recm_transportcourier; ?>" />
                                    </li>
                                    <li>
                                        <label><?php echo $this->lang->line('other'); ?> :</label>
                                        <input type="text" class="form-control float calculateextra" id="otheramt"
                                            name="otheramt" value="<?php echo $recm_others; ?>" />

                                    </li>
                                    <li>
                                        <label>&nbsp;</label><input type="text" name="other_description"
                                            class="form-control" placeholder="Other Description"
                                            value="<?php echo  $recm_othersdescription; ?>">
                                    </li>
                                </ul>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div id="Printable" class="print_report_section printTable"></div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-12">
            <button type="submit" class="btn btn-info  save"
                data-operation='<?php echo !empty($receive_data_master) ? 'update' : 'save' ?>'
                id="btnSubmit"><?php echo !empty($receive_data_master) ? 'Update' : 'Save' ?></button>
            <button type="submit" class="btn btn-info savePrint"
                data-operation='<?php echo !empty($receive_data_master) ? 'update' : 'save ' ?>' id="btnSubmit"
                data-print="print"><?php echo !empty($receive_data_master) ? 'Update & Print' : 'Save & Print' ?></button>
        </div>
        <div class="col-sm-12">
            <div class="alert-success success"></div>
            <div class="alert-danger error"></div>
        </div>
    </div>
</form>
<script type="text/javascript">
$(document).off('keyup change', '.calamt');
$(document).on('keyup change', '.calamt', function() {
    var amount = 0;
    var disamt = 0;
    var with_dis = 0;
    var with_vat = 0;
    var cc = 0;
    var totalamt = 0;
    var free = 0;

    var id = $(this).data('id');
    var qty = $('#recqty_' + id).val();
    var orderqty = $('#order_qty_' + id).val();
    var rate = $('#rate_' + id).val();
    // var free = $('#free_'+id).val();

    var valid_qty = parseFloat(checkValidValue(qty));
    var valid_orderqty = parseFloat(checkValidValue(orderqty));
    var valid_rate = parseFloat(checkValidValue(rate));

    // var valid_free = parseFloat(checkValidValue(free));


    // if(valid_qty > valid_orderqty){
    //     alert('Sorry, you cannot exceed ordered/remaining quantity.');
    //     // $('#recqty_'+id).val(0);

    //     // $('#amt_'+id).val(0);

    // }

    var cc = $('#cc_' + id).val();
    var valid_cc = parseFloat(checkValidValue(cc));

    var discount = $('#discount_' + id).val();
    var valid_discount = parseFloat(checkValidValue(discount));

    var vat = $('#vat_' + id).val();
    var valid_vat = parseFloat(checkValidValue(vat));

    // if(valid_free){
    //     var amount_vq = 0;
    //     $('#recqty_'+id).val(0);
    //     $('#recqty_'+id).val(0);
    // }else{
    //     var amount_vq = valid_qty*valid_rate;
    // }

    // console.log('qty' +valid_qty);
    // console.log('rate'+ valid_rate);


    var amount_vq = valid_qty * valid_rate;

    // console.log('amount' + amount_vq);

    if (amount_vq) {
        $('#amt_' + id).val(amount_vq.toFixed(2));
        $('#ratexqty_' + id).val(amount_vq.toFixed(2));
    } else {
        $('#amt_' + id).val(0);
        $('#ratexqty_' + id).val(0);
    }

    //check cc
    if (valid_cc && amount_vq != 0) {
        amount_cc = amount_vq + valid_cc;
    } else {
        amount_cc = amount_vq;
    }

    if (amount_cc) {
        $('#amt_' + id).val(amount_cc.toFixed(2));
    }

    //check discount
    if (valid_discount && amount_vq != 0) {
        disamt = amount_cc * (valid_discount / 100);
        amount_disamt = amount_cc - disamt;
    } else {
        disamt = 0;
        amount_disamt = amount_cc;
    }

    if (amount_disamt) {
        $('#amt_' + id).val(amount_disamt.toFixed(2));
    }

    //check vat
    if (valid_vat && amount_vq != 0) {
        vatamt = amount_disamt * (valid_vat / 100);
        amount_vatamt = amount_disamt + vatamt;
    } else {
        vatamt = 0;
        amount_vatamt = amount_disamt;
    }
    if (amount_vatamt) {
        $('#amt_' + id).val(amount_vatamt.toFixed(2));
    }

    //calculate for total, total discount, total tax
    var stotal = 0;
    var stotalvat = 0;
    var stotoaldis = 0;
    var sratexqty = 0;

    $(".eachtotalamt").each(function() {
        stotal += parseFloat($(this).val());
    });

    $(".eachratexqty").each(function() {
        sratexqty += parseFloat($(this).val());
    });

    $(".vatamt").each(function() {
        stotalvat += parseFloat($(this).val());
    });

    $(".disamt").each(function() {
        stotoaldis += parseFloat($(this).val());
    });

    var extra = parseFloat($('#extra').val());

    if (isNaN(extra)) {
        extra = 0;
    } else {
        extra = extra;
    }

    var refund = parseFloat($('#refund').val());

    if (isNaN(refund)) {
        refund = 0;
    } else {
        refund = refund;
    }

    var overall_discount = parseFloat($('#overall_discount').val());

    if (isNaN(overall_discount)) {
        overall_discount = 0;
    } else {
        overall_discount = overall_discount;
    }

    // var subtotal = stotal-stotoaldis;
    var subtotal = sratexqty - stotoaldis - overall_discount;

    var clearanceamt = subtotal + stotalvat + extra + refund - overall_discount;



    // $('#amt_'+id).html(with_vat.toFixed(2));
    $('#vatamt_' + id).val(vatamt.toFixed(2));
    $('#disamt_' + id).val(disamt.toFixed(2));

    $('#taxamt').val(stotalvat.toFixed(2));
    $('#discountamt').val(stotoaldis.toFixed(2));
    $('#subtotalamt').val(subtotal.toFixed(2));
    // $('#totalamount').val(stotal.toFixed(2));
    $('#totalamount').val(sratexqty.toFixed(2));
    $('#clearanceamt').val(clearanceamt.toFixed(2));


});

//overall discount
$(document).off('keyup change', '#overall_discount');
$(document).on('keyup change', '#overall_discount', function() {
    var discount = $('#overall_discount').val();

    $('.calamt').change();
});

//calculate extra
$(document).off('keyup change', '.calculateextra');
$(document).on('keyup change', '.calculateextra', function() {
    var insurance = $('#insurance').val();
    var carriage = $('#carriage').val();
    var packing = $('#packing').val();
    var transportamt = $('#transportamt').val();
    var otheramt = $('#otheramt').val();

    var valid_insurance = checkValidValue(insurance, 'insurance');
    var valid_carriage = checkValidValue(carriage, 'carriage');
    var valid_packing = checkValidValue(packing, 'packing');
    var valid_transportamt = checkValidValue(transportamt, 'transportamt');
    var valid_otheramt = checkValidValue(otheramt, 'otheramt');

    var extratotal = parseFloat(valid_insurance) + parseFloat(valid_carriage) + parseFloat(valid_packing) +
        parseFloat(valid_transportamt) + parseFloat(valid_otheramt);

    var valid_extratotal = checkValidValue(extratotal);

    $('#extra').val(valid_extratotal.toFixed(2));

    $('.calamt').change();
});
</script>

<script>
$(document).off('keyup change', '.calculaterefund');
$(document).on('keyup change', '.calculaterefund', function() {
    var refund = $('#refund').val();

    var valid_refund = checkValidValue(refund, 'refund');

    $('.calamt').change();

});
</script>


<?php
if ($loadselect2 == 'yes') :
?>
<script type="text/javascript">
$('.select2').select2();
</script>
<?php
endif;
?>

<script type="text/javascript">
function getDetailList(masterid, main_form = false) {
    if (main_form == 'main_form') {
        var submiturl = base_url + 'purchase_receive/receive_against_order/load_detail_list/new_detail_list';
        var displaydiv = '#displayDetailList';
    } else {
        var submiturl = base_url + 'purchase_receive/receive_against_order/load_detail_list';
        var displaydiv = '#detailListBox';
    }

    $.ajax({
        type: "POST",
        url: submiturl,
        data: {
            masterid: masterid
        },
        beforeSend: function() {
            // $('.overlay').modal('show');
        },
        success: function(jsons) {
            var data = jQuery.parseJSON(jsons);
            // console.log(data);
            if (main_form == 'main_form') {
                if (data.status == 'success') {
                    if (data.isempty == 'empty') {
                        alert('Pending list is empty. Please try again.');
                        $('#requisition_date').val('');
                        $('#receive_by').val('');
                        $('#depnme').select2("val", '');
                        $('#pendinglist').html('');
                        $('#stock_limit').html(0);
                        $('.loadedItems').empty();
                        return false;
                    } else {
                        $(displaydiv).empty().html(data.tempform);
                    }
                }
            } else {
                if (data.status == 'success') {
                    $(displaydiv).empty().html(data.tempform);
                }
            }

            // $('.overlay').modal('hide');
        }
    });

    // return false;
}

function blink_text() {
    $('.blink').fadeOut(100);
    $('.blink').fadeIn(1000);
}

$(document).off('change', '#fiscalyear');
$(document).on('change', '#fiscalyear', function() {
    var fyear = $('#fiscalyear').val();
    $('#cancelLoad').attr('data-fyear', fyear);
});
</script>

<script type="text/javascript">
$(document).off('change keyup', '.discountpc');
$(document).on('change keyup', '.discountpc', function() {

    var disArray = [];
    i = 0;
    total = 0;
    $('.discountpc').each(function(i) {
        field_discount = this.value;

        valid_field_discount = checkValidValue(field_discount);

        disArray[i++] = valid_field_discount;
        total += parseFloat(valid_field_discount);
    });

    valid_total = checkValidValue(total);

    console.log('valid total: ' + valid_total);

    if (valid_total > 0) {
        $('#overall_discount').prop("disabled", true);
        $('#discountamt').prop("disabled", false);
        $('#overall_discount').val('0');
    } else {
        $('#discountamt').prop("disabled", true);
        $('#overall_discount').prop("disabled", false);
        $('#discountamt').val('0');
    }
});
</script>

<script type="text/javascript">
$(document).off('keyup change', '.vat');
$(document).on('keyup change', '.vat', function() {
    var vat = $(this).val();
    $('[id^="vat_"]').val(vat);

});
</script>

<script type="text/javascript">
$(document).ready(function() {

    $(document).off('click', '#addAttachments');
    $(document).on('click', '#addAttachments', function() {
        $(".addAttachmentRow").append(
            '<div class="dis_tab mtop_5"><input type="file" name="recm_attachments[]" "/><input type="hidden" name="recm_attach[]"><a class="btn btn-danger table-cell width_30 btnminus"><span class="fa fa-trash"></span></a></div>'
        );
    });

    $(document).off('click', '.btnminus');
    $(document).on('click', '.btnminus', function() {
        $(this).closest('div').remove();
    });
});
</script>


<script type="text/javascript">
$(document).ready(function(e) {
    var matType = $("#mattypeid").val();
    var materialtypeid = parseInt(matType);
    if (materialtypeid == '2') {
        $('#received_by_div').show();
    } else {
        $('#received_by_div').hide();
    }
    $('#orderload').attr('data-id', matType);
    $('#orderload').data('id', matType);

})

$(document).off('change', '.chooseMatType,#fiscalyear');
$(document).on('change', '.chooseMatType,#fiscalyear', function() {
    var matType = $('.chooseMatType').val();
    var materialtypeid = parseInt(matType);
    if (matType == '2') {
        $('#received_by_div').show();
    } else {
        $('#received_by_div').hide();
    }
    var fyear = $('#fiscalyear').val();
    var purreqid = $('#purchaseordermasterid').val();

    $('#orderload').attr('data-id', matType);
    $('#orderload').data('id', matType);
    if (purreqid) {
        $('#purchaseordermasterid').val('');
        $('.orderrow').remove();
        $('#requisitionNumber').val('');
        $('#requisitionNumber').focus().select();
    }

    var submitdata = {
        mattype: matType,
        fyrs: fyear
    };
    var submiturl = base_url + '/purchase_receive/receive_against_order/gen_receive_invoice';
    ajaxPostSubmit(submiturl, submitdata, beforeSend, onSuccess);

    function beforeSend() {
        // $('.overlay').modal('show');
        $('#receivedno').attr('disabled', 'disabled');
        $('#receivedno').val('Loading...');
    };

    function onSuccess(jsons) {
        data = jQuery.parseJSON(jsons);
        setTimeout(function() {
            $('#receivedno').empty().val(data.received_no);
            $('#receivedno').removeAttr('disabled');
        }, 500);
    }

});
</script>