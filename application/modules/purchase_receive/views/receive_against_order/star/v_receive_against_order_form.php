<style>
.purs_table tbody tr td {
    border: none;
    vertical-align: center;
}
</style>

<!-- data-reloadurl="<? php // echo base_url('purchase_receive/receive_against_order/form_received_form'); 
                        ?>" 
-->
<form method="post" id="FormReceiveOrderItem"
    action="<?php echo base_url('purchase_receive/receive_against_order/save_received_items'); ?>"
    class="form-material form-horizontal form"
    data-reloadurl="<?php echo base_url('purchase_receive/receive_against_order/index/reload'); ?>"
    enctype="multipart/form-data" accept-charset="utf-8">
    <div id="orderData">
        <input type="hidden" name="id" value="" />
        <input type="hidden" name="purchaseordermasterid" id="purchaseordermasterid" />
        <div class="form-group">
            <div class="col-md-3 col-sm-3">
                <?php $fiscalyear = !empty($order_details[0]->puor_fyear) ? $order_details[0]->puor_fyear : ''; ?>
                <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?><span
                        class="required">*</span>:</label>
                <select name="fiscalyear" class="form-control" id="fiscalyear">
                    <?php
                    if (!empty($fiscal)) :
                        foreach ($fiscal as $km => $fy) :
                    ?>
                    <option value="<?php echo $fy->fiye_name; ?>"
                        <?php if ($fy->fiye_status == 'I') echo "selected=selected"; ?>><?php echo $fy->fiye_name; ?>
                    </option>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="example-text">Choose Material Type : </label><br>
                <?php
                $rema_mattype = !empty($order_details[0]->recm_mattypeid) ? $order_details[0]->recm_mattypeid : 1;
                ?>
                <select name="recm_mattypeid" id="mattypeid" class="form-control chooseMatType required_field">
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

            <div class="col-md-3 col-sm-3">
                <?php $orderno = !empty($order_details[0]->puor_order_for) ? $order_details[0]->puor_order_for : ''; ?>
                <label for="example-text"><?php echo $this->lang->line('order_no'); ?><span
                        class="required">*</span>:</label>
                <div class="dis_tab">
                    <input type="text" class="form-control required_field enterinput" name="orderno" value=""
                        placeholder="Enter Order Number" id="orderno" data-targetbtn='btnSearchOrderno'>
                    <a href="javascript:void(0)" class="table-cell width_30 btn btn-success" id="btnSearchOrderno"><i
                            class="fa fa-search"></i></a>
                    &nbsp;
                    <a href="javascript:void(0)" data-id="0" data-displaydiv="Issue"
                        data-viewurl="<?php echo base_url('purchase_receive/receive_against_order/load_order_list'); ?>"
                        class="view table-cell width_30 btn btn-success" data-heading="Load Order list"
                        id="orderload"><i class="fa fa-upload"></i></a>
                </div>

            </div>
        </div>
        <div class="form-group">

            <div class="col-md-3 col-sm-3">
                <?php $supid = !empty($order_details[0]->puor_supplierid) ? $order_details[0]->puor_supplierid : ''; ?>
                <label for="example-text"><?php echo $this->lang->line('supplier_name'); ?> <span
                        class="required">*</span>:</label>
                <select name="supplierid" class="form-control required_field select2" readonly="readonly"
                    id="supplierid">
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
                <input type="text" name="order_date" class="form-control  date" placeholder="Order Date" id="OrderDate"
                    value="" readonly>
                <span class="errmsg"></span>
            </div>

            <div class="col-md-3 col-sm-3">
                <label for="example-text"><?php echo $this->lang->line('received_number'); ?></label>
                <input type="text" name="received_no" class="form-control" placeholder="Received No."
                    value="<?php echo !empty($received_no) ? $received_no : ''; ?>" id="receivedno" readonly>
                <span class="errmsg"></span>
            </div>
            <div class="col-md-3 col-sm-3">
                <label for="example-text"><?php echo $this->lang->line('received_date'); ?><span
                        class="required">*</span>:</label>
                <input type="text" name="received_date"
                    class="form-control required_field <?php echo DATEPICKER_CLASS; ?> date"
                    placeholder="<?php echo $this->lang->line('received_date'); ?>" value="<?php echo DISPLAY_DATE; ?>"
                    id="ReceivedDate">
                <span class="errmsg"></span>
            </div>
            <div class="col-md-3 col-sm-3">
                <?php $suplier_bill_nodb = !empty($order_details[0]->suplier_bill_no) ? $order_details[0]->suplier_bill_no : ''; ?>
                <label for="example-text"><?php echo $this->lang->line('supplier_bill_no'); ?> <span
                        class="required">*</span>:</label>
                <input type="text" class="form-control required_field" name="suplier_bill_no"
                    value="<?php echo $suplier_bill_nodb; ?>" placeholder="Supplier Bill No. ">
            </div>
            <div class="col-md-3 col-sm-3">
                <label for="example-text"><?php echo $this->lang->line('supplier_bill_date'); ?><span
                        class="required">*</span>: </label>
                <input type="text" name="suplier_bill_date"
                    class="form-control required_field <?php echo DATEPICKER_CLASS; ?> date"
                    placeholder="<?php echo $this->lang->line('supplier_bill_date'); ?>"
                    value="<?php echo DISPLAY_DATE; ?>" id="SupBillDate">
                <span class="errmsg"></span>
            </div>

           <!--  <div class="col-md-3 col-sm-3">
               
                // echo "<pre>";
                // print_r($budgets_list);
                // die();
                ?>
                <label class="pr-10 table-cell width_75">AC. Head<span class="required">*</span>:</label>
                <select class="table-cell form-control select2" name="bugetid" id="budgetid">

                    <option value="">--- Select ---</option>
                    <?php if (!empty($budgets_list)) :
                        foreach ($budgets_list as $kb => $buget) :
                    ?>
                    <option value="<?php echo $buget->budg_budgetid; ?>"><?php echo $buget->budg_budgetname; ?></option>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </select>
               

            </div> -->
             <!-- <a href="javascript:void(0)" class="table-cell width_30 text-center"><i class="fa fa-plus"></i></a> -->




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
                            <th width="10%"><?php echo $this->lang->line('item_name'); ?></th>
                            <!-- <th width="10%">Batch No </th> -->
                            <th width="6%"><?php echo $this->lang->line('unit'); ?></th>
                            <th width="7%"><?php echo $this->lang->line('odr_qty'); ?></th>
                            <th width="7%">Rec.<?php echo $this->lang->line('qty'); ?></th>
                            <!-- <th width="8%">Free</th> -->
                            <th width="8%"><?php echo $this->lang->line('rate'); ?></th>
                            <th width="8%"><?php echo $this->lang->line('cc'); ?></th>
                            <th width="8%"><?php echo $this->lang->line('dis'); ?></th>
                            <th width="6%"><?php echo $this->lang->line('vat'); ?><input type="text"
                                    class="form-control allvat" style="width:35px;height:20px" value="13"></th>
                            <th width="10%"><?php echo $this->lang->line('amount'); ?></th>
                            <th width="8%">Batch No</th>
                            <th width="12%"><?php echo $this->lang->line('exp_datebs'); ?></th>
                            <th width="20%"><?php echo $this->lang->line('description'); ?></th>
                            <th width="5%"><?php echo $this->lang->line('action'); ?></th>
                        </tr>
                    </thead>
                    <tbody id="purchaseOrderDataBody">
                    </tbody>
                </table>

                <div class="roi_footer">
                    <div class="row">
                        <div class="col-sm-4">
                            <!--  <label>Enter Bill Amount</label>
                            <input type="text" class="form-control float" name="billamount" id="billamount"> -->
                            <!--   <h4>
                                <label>Actual Clear Amount:</label>
                            </h4> -->


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
                                <ul>
                                    <li>
                                        <label><?php echo $this->lang->line('total_amount'); ?></label>
                                        <input type="text" class="form-control float totalamount" name="totalamount"
                                            value="0" id="totalamount" readonly="true" />
                                    </li>
                                    <li>
                                        <label><?php echo $this->lang->line('discount_in_amount'); ?></label>
                                        <input type="text" class="form-control float discountpc" name="discountamt"
                                            id="discountamt" value="0" readonly="true" />
                                    </li>

                                    <li>
                                        <label>
                                            <?php echo !empty($this->lang->line('overall_discount')) ? $this->lang->line('overall_discount') : 'Overall Discount'; ?>
                                        </label>

                                        <input type="text" class="form-control float" name="discountamt"
                                            id="overall_discount" value="0" data-discount="amt" />
                                    </li>

                                    <li>
                                        <label><?php echo $this->lang->line('sub_total'); ?></label>
                                        <input type="text" class="form-control float" name="subtotalamt"
                                            id="subtotalamt" value="0" readonly="true" />
                                    </li>
                                    <li>
                                        <label><?php echo $this->lang->line('total_tax'); ?> </label>
                                        <input type="text" class="form-control float" name="taxamt" id="taxamt"
                                            value="0" readonly="true" />

                                    </li>
                                    <li>
                                        <label><?php echo $this->lang->line('extra_charges'); ?></label>
                                        <input type="text" class="form-control float" name="extra" id="extra" value="0"
                                            readonly="true" />
                                    </li>
                                    <li>
                                        <label><?php echo $this->lang->line('rf'); ?></label>
                                        <input type="text" class="form-control float calculaterefund" name="refund"
                                            id="refund" value="0" placeholder="" />
                                    </li>
                                    <li>
                                        <label><?php echo $this->lang->line('clearance_amt'); ?></label>
                                        <input type="text" class="form-control" name="clearanceamt" id="clearanceamt"
                                            value="0">
                                    </li>
                                    <li>
                                        <span id="lblgtotal" style="font-weight: bold;
    font-size: 24px;
    color: white;
    border: 1px solid black;
    background: black;
    float: right;
    letter-spacing: 1.5px;"></span>
                                    </li>
                                </ul>
                            </fieldset>

                            <fieldset class="pull-right bordered">
                                <legend class="font_12"><?php echo $this->lang->line('other_charges'); ?></legend>
                                <ul>
                                    <li>
                                        <label><?php echo $this->lang->line('insurance'); ?>:</label>
                                        <input type="text" class="form-control float calculateextra" name="insurance"
                                            id="insurance" value="0" data-discount="per" />
                                    </li>
                                    <li>
                                        <label><?php echo $this->lang->line('carriage_freight'); ?> :</label>
                                        <input type="text" class="form-control float calculateextra" name="carriage"
                                            id="carriage" value="0" data-discount="amt" />
                                    </li>
                                    <li>
                                        <label><?php echo $this->lang->line('packing'); ?> :</label>
                                        <input type="text" class="form-control float calculateextra" name="packing"
                                            id="packing" value="0" />
                                    </li>
                                    <li>
                                        <label><?php echo $this->lang->line('transport_courier'); ?> :</label>
                                        <input type="text" class="form-control float calculateextra" name="transportamt"
                                            id="transportamt" value="0" />
                                    </li>
                                    <li>
                                        <label><?php echo $this->lang->line('other'); ?> :</label>
                                        <input type="text" class="form-control float calculateextra" id="otheramt"
                                            name="otheramt" value="0" />
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
                data-operation='<?php echo !empty($order_item_details) ? 'update' : 'save' ?>'
                id="btnSubmit"><?php echo !empty($order_item_details) ? '' : 'Save' ?></button>
            <button type="submit" class="btn btn-info savePrint"
                data-operation='<?php echo !empty($order_item_details) ? 'update' : 'save ' ?>' id="btnSubmit"
                data-print="print"><?php echo !empty($order_item_details) ? 'Update' : 'Save & Print' ?></button>
        </div>
        <div class="col-sm-12">
            <div class="alert-success success"></div>
            <div class="alert-danger error"></div>
        </div>
    </div>
</form>
<script type="text/javascript">
$(document).off('click', '#btnSearchOrderno');
$(document).on('click', '#btnSearchOrderno', function() {
    var orderno = $('#orderno').val();
    var fiscalyear = $('#fiscalyear').val();
    var mattypeid = $('#mattypeid').val();
    // alert(orderno);
    // ajaxPostSubmit()
    var submitdata = {
        orderno: orderno,
        fiscalyear: fiscalyear,
        mattypeid: mattypeid
    };
    var submiturl = base_url + 'purchase_receive/receive_against_order/orderlist_by_order_no';
    beforeSend = $('.overlay').modal('show');

    ajaxPostSubmit(submiturl, submitdata, beforeSend = '', onSuccess);

    function onSuccess(jsons) {
        data = jQuery.parseJSON(jsons);
        // console.log(data.order_data);
        var orderdata = data.order_data;

        var defaultdatepicker = '<?php echo DEFAULT_DATEPICKER ?>';

        if (orderdata) {
            var orderdatead = orderdata[0].puor_orderdatead;
            var orderdatebs = orderdata[0].puor_orderdatebs;
            var supplierid = orderdata[0].puor_supplierid;
            var purchaseordermasterid = orderdata[0].puor_purchaseordermasterid;
            var budgetid = orderdata[0].puor_budgetid;
            if (defaultdatepicker == 'NP') {
                $('#OrderDate').val(orderdatebs);
            } else {
                $('#OrderDate').val(orderdatead);
            }
            $("#supplierid").select2("val", supplierid).trigger('change');
            $('#purchaseordermasterid').val(purchaseordermasterid);
            $("#budgetid").select2("val", budgetid).trigger('change');



        }
        // console.log(orderdata);
        if (data.status == 'success') {
            $('#purchaseOrderDataBody').html(data.tempform);
        } else {
            alert(data.message);
            $('#OrderDate').val('');
            $("#supplierid").select2("val", 0).trigger('change');
            $('#purchaseOrderDataBody').html('');
        }
        $('.overlay').modal('hide');
    }
});
</script>

<script type="text/javascript">
// $(document).off('keyup change','.calamt');
// $(document).on('keyup change','.calamt',function(){
//     var id=$(this).data('id');
//     var qty=$('#recqty_'+id).val();
//     var orderqty=$('#order_qty_'+id).val();
//     // if(qty>orderqty)
//     // {
//     //     alert('Sorry you cannot exceed ordered/remaing Quantity.');
//     //     $('#recqty_'+id).val(0);
//     //     return false;
//     // }
//     var rate=$('#rate_'+id).val();
//     var discount=$('#discount_'+id).val();
//     var vat =$('#vat_'+id).val();
//     var totalamt=0;
//     var rate_qty=parseFloat(qty)*parseFloat(rate);
//     // alert(rate_qty);
//     var disamt=0;
//     var with_dis=0;
//     var with_vat=0;
//     var cc= 0;
//     if(discount)
//     {
//         disamt= rate_qty*(discount/100);
//         with_dis=rate_qty-disamt;
//     }
//     else
//     {
//         disamt=0;
//         with_dis=rate_qty;
//     }

//     if(vat)
//     {
//         vatamt=with_dis*vat/100;
//         with_vat=with_dis+vatamt;
//     }
//     else
//     {
//         vatamt=with_dis*vat/100;
//         with_vat=with_dis+vatamt;
//     }
//     // alert(with_vat);
//     // eachtotalamt
//     var stotal=0;
//     var stotalvat=0;
//     var stotoaldis=0;
//     $(".eachtotalamt").each(function() {
//         stotal += parseFloat($(this).val());
//     });

//     $(".vatamt").each(function() {
//         stotalvat += parseFloat($(this).val());
//     });

//     $(".disamt").each(function() {
//         stotoaldis += parseFloat($(this).val());
//     });

//     var extra = parseFloat($('#extra').val());

//     if(isNaN(extra)){
//         extra = 0;
//     }else{
//         extra = extra;
//     }

//     var subtotal = stotal-stotoaldis;

//     var clearanceamt = subtotal+stotalvat+extra;

//     $('#amt_'+id).html(with_vat.toFixed(2));
//     $('#vatamt_'+id).val(vatamt.toFixed(2));
//     $('#disamt_'+id).val(disamt.toFixed(2));

//     $('#taxamt').val(stotalvat.toFixed(2));
//     $('#discountamt').val(stotoaldis.toFixed(2));
//     $('#subtotalamt').val(subtotal.toFixed(2));
//     $('#totalamount').val(stotal.toFixed(2));
//     $('#clearanceamt').val(clearanceamt.toFixed(2));
// });

//calculate amount
$(document).off('keyup change blur', '.calamt');
$(document).on('keyup change blur', '.calamt', function() {
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
    $('#lblgtotal').html(parseFloat(clearanceamt.toFixed(2)).toLocaleString(window.document.documentElement
        .lang));


});

//overall discount
$(document).off('keyup change', '#overall_discount');
$(document).on('keyup change', '#overall_discount', function() {
    var discount = $('#overall_discount').val();

    $('.calamt').change();
});

//calculate extra


$(document).off('keyup', '.allvat');
$(document).on('keyup', '.allvat', function(e) {
    // $('.vat')
    var allvat = $(this).val();
    // alert(allvat);
    // return false;
    $(".vat").each(function() {
        $(this).val(allvat);
    });
    $('.calamt').change();
})

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

    // console.log('valid total: ' + valid_total);

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
// $(document).off('keyup change', '.vat');
// $(document).on('keyup change', '.vat', function() {
//     var vat = $(this).val();
//     $('[id^="vat_"]').val(vat);

// });
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
    $('#mattypeid').val(matType).change();
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
        // console.log(data.received_no);
        $('#receivedno').removeAttr('disabled');
        $('#receivedno').val(data.received_no);


    }

});
</script>
<script type="text/javascript">
$(document).off('change', '#mattypeid');
$(document).on('change', '#mattypeid', function(e) {
    var mattypeid = $(this).val();
    var submitdata = {
        mattypeid: mattypeid
    };
    return false;
    var submiturl = base_url + 'purchase_receive/receive_against_order/get_account_head_acc_to_material';
    // aletr(schoolid);
    $("#budgetid").select2("val", "");
    $('#budgetid').html('');
    ajaxPostSubmit(submiturl, submitdata, beforeSend, onSuccess);

    function beforeSend() {


    };

    function onSuccess(jsons) {
        data = jQuery.parseJSON(jsons);
        if (data.status == 'success') {
            // console.log(data.budget_option); 
            $('#budgetid').html(data.budget_option);
        } else {
            $('#budgetid').html();
        }


    }
});
</script>