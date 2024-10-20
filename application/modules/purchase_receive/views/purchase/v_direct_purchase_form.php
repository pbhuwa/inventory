<style>
    .purs_table tbody tr td {
        border: none;
        vertical-align: center;
    }
</style>
<form method="post" id="FormDirectPurchase" action="<?php echo base_url('purchase_receive/direct_purchase/save_receive_order_item'); ?>" data-reloadurl='<?php echo base_url('purchase_receive/direct_purchase/index/reload'); ?>' class="form-material form-horizontal form">
    <?php
    $receivedmasterid = !empty($purchased_data[0]->recm_receivedmasterid) ? $purchased_data[0]->recm_receivedmasterid : '';
    ?>
    <input type="hidden" name="id" value="<?php echo $receivedmasterid; ?>" />
    <div id="orderData">
        <div class="form-group">
            <div class="col-md-3 col-sm-4">
                <?php
                $puorfyear = !empty($purchased_data[0]->recm_fyear) ? $purchased_data[0]->recm_fyear : '';
                ?>
                <label for="fiscalyear"><?php echo $this->lang->line('fiscal_year'); ?> <span class="required">*</span>:</label>
                <select name="fiscalyearid" class="form-control required_field" id="fiscalyear">
                    <option value="">---select---</option>
                    <?php
                    if ($fiscal) :
                        foreach ($fiscal as $km => $fy) :
                    ?>
                            <?php
                            if (!empty($puorfyear)) :
                            ?>
                                <option value="<?php echo $fy->fiye_name; ?>" <?php if ($puorfyear == $fy->fiye_name) echo "selected=selected"; ?>><?php echo $fy->fiye_name; ?></option>
                            <?php else : ?>
                                <option value="<?php echo $fy->fiye_name; ?>" <?php if ($fy->fiye_status == 'I') echo "selected=selected"; ?>><?php echo $fy->fiye_name; ?></option>
                            <?php endif; ?>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </select>
            </div>
            

            <div class="col-md-3 col-sm-4">
                <label for="example-text"><?php echo $this->lang->line('receipt_no'); ?> <span class="required">*</span>:</label>
                <?php $receivedno = !empty($purchased_data[0]->recm_invoiceno) ? $purchased_data[0]->recm_invoiceno : ''; ?>
                <div class="dis_tab">
                    <input type="text" class="form-control required_field enterinput" name="receipt_no" value="<?php echo !empty($receivedno) ? $receivedno : $received_no; ?>" placeholder="" id="receivedno" readonly>
                </div>
            </div>

            <div class="col-md-3 col-sm-4">
                <?php $supplierid = !empty($purchased_data[0]->recm_supplierid) ? $purchased_data[0]->recm_supplierid : ''; ?>
                <label for="example-text"><?php echo $this->lang->line('supplier_name'); ?>: <span class="required">*</span>:</label>
                <div class="dis_tab">
                    <select name="supplier" id="direct_supplierid" class="form-control required_field select2 ">
                        <option value="">---select---</option>
                        <?php
                        if (!empty($distributor)) :
                            foreach ($distributor as $km => $sup) :
                        ?>
                                <option value="<?php echo $sup->dist_distributorid; ?>" <?php if ($supplierid == $sup->dist_distributorid) echo "selected=selected" ?>><?php echo $sup->dist_distributor; ?></option>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </select>

                    <a href="javascript:void(0)" class="table-cell frm_add_btn width_30 refresh_element" data-targetid="direct_supplierid" data-viewurl="<?php echo base_url('biomedical/distributors/distributor_reload'); ?>"><i class="fa fa-refresh"></i></a>

                    <a href="javascript:void(0)" class="table-cell frm_add_btn width_30 view" data-heading='Supplier Entry' data-viewurl='<?php echo base_url('biomedical/distributors/supplier_entry/modal'); ?>'><i class="fa fa-plus"></i></a>
                </div>
            </div>


            <div class="col-md-3 col-sm-4">
                <label for="example-text"><?php echo $this->lang->line('order_date'); ?>: </label>
                <input type="text" name="order_date" class="form-control <?php echo DATEPICKER_CLASS; ?> date" placeholder="Order Date" id="order_date" value="<?php echo !empty($purchased_data[0]->recm_purchaseorderdatebs) ? $purchased_data[0]->recm_purchaseorderdatebs : DISPLAY_DATE; ?>">
                <span class="errmsg"></span>
            </div>
            <!-- </div>

        <div class="form-group"> -->
            <div class="col-md-3 col-sm-4 rec" style="clear: both;">
                <label for="example-text"><?php echo $this->lang->line('received_date'); ?>: </label>
                <input type="text" name="received_date" class="form-control <?php echo DATEPICKER_CLASS; ?> date" placeholder="Received Date" id="received_date" value="<?php echo !empty($purchased_data[0]->recm_receiveddatebs) ? $purchased_data[0]->recm_receiveddatebs : DISPLAY_DATE; ?>">
                <span class="errmsg"></span>
            </div>

            <div class="col-md-3 col-sm-4">
                <label for="example-text"><?php echo $this->lang->line('supplier_bill_no'); ?>:<span class="required">*</span> </label>
                <input type="text" name="suplier_bill_no" value="<?php echo !empty($purchased_data[0]->recm_supplierbillno) ? $purchased_data[0]->recm_supplierbillno : ''; ?>" class="form-control required_field" placeholder="Supplier Bill No">
                <span class="errmsg"></span>
            </div>
            <div class="col-md-3 col-sm-4">
                <label for="example-text"><?php echo $this->lang->line('supplier_bill_date'); ?><span class="required">*</span>: </label>
                <input type="text" name="suplier_bill_date" class="form-control required_field <?php echo DATEPICKER_CLASS; ?> date " placeholder="Sup.Bill No" id="supplier_bill_date" value="<?php echo !empty($purchased_data[0]->recm_supbilldatebs) ? $purchased_data[0]->recm_supbilldatebs : DISPLAY_DATE; ?>" id="suplier_bill_date">
                <span class="errmsg"></span>
            </div>

        </div>
    </div>

    <div class="form-group">
        <div class="table-responsive col-sm-12">
            <table style="width:100%;" class="table purs_table dataTable">
                <thead>
                    <tr>
                        <th width="2%"><?php echo $this->lang->line('sn'); ?></th>
                        <th width="12%"><?php echo $this->lang->line('item_code'); ?></th>
                        <th width="18%"><?php echo $this->lang->line('item_name'); ?></th>
                        <th width="5%"><?php echo $this->lang->line('unit'); ?> </th>
                        <!-- <th width="8%">Batch No </th> -->
                        <th width="5%"><?php echo $this->lang->line('qty'); ?></th>
                        <th width="8%"><?php echo $this->lang->line('rate'); ?></th>
                        <!--  <th width="5%">Free</th> -->
                        <th width="5%"><?php echo $this->lang->line('cc'); ?></th>
                        <th width="5%"><?php echo $this->lang->line('dis'); ?></th>
                        <th width="5%"><?php echo $this->lang->line('vat'); ?><br><input type="text" class="form-control allvat" style="width:35px;height:20px" value="13"></th>
                        <th width="8%"><?php echo $this->lang->line('amount'); ?></th>
                        <!-- <th width="8%">Exp.Date</th> -->
                        <th width="10%"><?php echo $this->lang->line('description'); ?></th>
                        <th width="5%"><?php echo $this->lang->line('action'); ?></th>

                    </tr>
                </thead>
                <tbody id="purchaseDataBody">
                    <?php if ($purchased_details) {
                        foreach ($purchased_details as $key => $pd) {
                    ?>
                            <tr class="orderrow" id="orderrow_<?php echo $key + 1; ?>" data-id='<?php echo $key + 1; ?>'>
                                <td>
                                    <input type="text" class="form-control sno" id="s_no_<?php echo $key + 1; ?>" value="<?php echo $key + 1; ?>" readonly />

                                    <input type="hidden" class="receiveddetailid" name="receiveddetailid[]" id="receiveddetailid_<?php echo $key + 1; ?>" value="<?php echo !empty($pd->recd_receiveddetailid) ? $pd->recd_receiveddetailid : ''; ?>" />
                                </td>
                                <td>
                                    <div class="dis_tab">
                                        <input type="text" class="form-control itemcode enterinput " id="puit_barcode_<?php echo $key + 1; ?>" name="puit_barcode[]" value="<?php echo $pd->itli_itemcode; ?>" data-id='<?php echo $key + 1; ?>' data-targetbtn='view' placeholder="Item Code" readonly>
                                        <input type="hidden" class="qude_itemsid" name="trde_itemsid[]" data-id='<?php echo $key + 1; ?>' value="<?php echo $pd->recd_itemsid; ?>" id="itemid_<?php echo $key + 1; ?>">
                                        <input type="hidden" class="itemsid" name="itemsid[]" data-id='<?php echo $key + 1; ?>' value="" id="matdetailid_<?php echo $key + 1; ?>">
                                        <input type="hidden" class="controlno" name="controlno[]" data-id='<?php echo $key + 1; ?>' value="" id="controlno_<?php echo $key + 1; ?>">
                                        <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading='Item List' data-viewurl='<?php echo base_url('stock_inventory/item/list_item_normal'); ?>' data-id='<?php echo $key + 1; ?>' id="view_<?php echo $key + 1; ?>" data-type='1'><strong>...</strong></a>
                                        &nbsp
                                        <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading='Item Entry' data-viewurl='<?php echo base_url('stock_inventory/item/item_entry/modal'); ?>'>+</a>
                                </td>
                                <td>
                                    <input type="text" class="form-control itemname" id="itemname_<?php echo $key + 1; ?>" value="<?php echo $pd->itli_itemname; ?>" name="itemname[]" data-id='<?php echo $key + 1; ?>' placeholder="Item name" readonly>
                                    <input type="hidden" class="eachsubtotal" name="eachsubtotal[]" id="eachsubtotal_<?php echo $key + 1; ?>">
                                    <input type="hidden" name="disamt[]" value="" id="disamt_<?php echo $key + 1; ?>" class="disamt calamt">
                                    <input type="hidden" name="vatamt[]" value="" id="vatamt_<?php echo $key + 1; ?>" class="vatamt">
                                </td>
                                <td>
                                    <input type="text" class="form-control unit" id="unit_<?php echo $key + 1; ?>" name="unit[]" data-id='<?php echo $key + 1; ?>' value="<?php echo $pd->unit_unitname; ?>">
                                </td>
                                <td><input type="text" class="form-control float calamt arrow_keypress" name="puit_qty[]" value="<?php echo !empty($pd->recd_purchasedqty) ? $pd->recd_purchasedqty : '0'; ?>" data-fieldid='puit_qty' data-id='<?php echo $key + 1; ?>' id="puit_qty_<?php echo $key + 1; ?>" placeholder="Qty">
                                </td>
                                <td>
                                    <input type="text" class="form-control puit_unitprice float calamt arrow_keypress" name="puit_unitprice[]" data-fieldid="puit_unitprice" id="puit_unitprice_<?php echo $key + 1; ?>" value="<?php echo !empty($pd->recd_unitprice) ? $pd->recd_unitprice : '0'; ?>" data-id='<?php echo $key + 1; ?>' placeholder="Rate">
                                    <input type="hidden" class="form-control unitprice float" name="unitprice[]" id="unitprice_<?php echo $key + 1; ?>" value="0" data-id='1' placeholder="Rate">
                                </td>
                                <td>
                                    <input type="text" class="form-control float calamt eachcc arrow_keypress" name="cc[]" data-fieldid="cc" id="cc_<?php echo $key + 1; ?>" value="<?php echo !empty($pd->recd_cccharge) ? $pd->recd_cccharge : '0'; ?>" data-id='<?php echo $key + 1; ?>' placeholder="CC">
                                </td>
                                <td>
                                    <input type="text" class="form-control discount float calamt arrow_keypress " name="discount[]" data-fieldid="discount" id="discount_<?php echo $key + 1; ?>" value="<?php echo !empty($pd->recd_discountpc) ? $pd->recd_discountpc : '0'; ?>" data-id='<?php echo $key + 1; ?>' placeholder="Dis">

                                </td>
                                <td>
                                    <input type="text" class="form-control vat float calamt idfornot arrow_keypress" data-fieldid="vat" name="vat[]" id="vat_<?php echo $key + 1; ?>" value="<?php echo !empty($pd->recd_vatpc) ? $pd->recd_vatpc : '0'; ?> " data-id='<?php echo $key + 1; ?>' placeholder="Vat">

                                </td>
                                <td>
                                    <?php $subtotal = ($pd->recd_purchasedqty) * ($pd->recd_unitprice); ?>
                                    <input type="text" name="totalamt[]" class="form-control eachtotalamt" value="<?php echo !empty($subtotal) ? $subtotal : '0'; ?>" id="totalamt_<?php echo $key + 1; ?>" readonly="true">
                                </td>
                                <td>
                                    <textarea class="form-control" name="description[]" data-id='<?php echo $key + 1; ?>' placeholder="Description" id="description_<?php echo $key + 1; ?>" style="margin: 0px; width: 261px; height: 76px; line-height: 18px;"><?php echo !empty($pd->recd_description) ? $pd->recd_description : ''; ?></textarea>
                                </td>
                                <td>
                                    <div class="actionDiv acDiv2"></div>
                                </td>
                            </tr>

                        <?php }
                    } else { ?>
                        <tr class="orderrow" id="orderrow_1" data-id='1'>
                            <td>
                                <input type="text" class="form-control sno" id="s_no_1" value="1" readonly />
                                <input type="hidden" class="receiveddetailid" name="receiveddetailid[]" id="receiveddetailid_1" value="" />
                            </td>
                            <td>
                                <div class="dis_tab">
                                    <input type="text" class="form-control itemcode enterinput " id="puit_barcode_1" name="puit_barcode[]" data-id='1' data-targetbtn='view' placeholder="Item Code">
                                    <input type="hidden" class="qude_itemsid" name="trde_itemsid[]" data-id='1' value="" id="itemid_1">
                                    <input type="hidden" class="itemsid" name="itemsid[]" data-id='1' value="" id="matdetailid_1">
                                    <input type="hidden" class="controlno" name="controlno[]" data-id='1' value="" id="controlno_1">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading='Item List' data-viewurl='<?php echo base_url('stock_inventory/item/list_item_normal'); ?>' data-id='1' id="view_1"><strong>...</strong></a>
                                    &nbsp
                                    <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading='Item Entry' data-viewurl='<?php echo base_url('stock_inventory/item/item_entry/modal'); ?>' data-id='1' id="view_1" data-storeid='<?php echo $storeid; ?>'>+</a>
                                </div>
                            </td>
                            <td>
                                <input type="text" class="form-control itemname" id="itemname_1" name="itemname[]" data-id='1' placeholder="Item name" readonly>
                                <input type="hidden" class="eachsubtotal" name="eachsubtotal[]" id="eachsubtotal_1">
                                <input type="hidden" name="disamt[]" value="" id="disamt_1" class="disamt calamt">
                                <input type="hidden" name="vatamt[]" value="" id="vatamt_1" class="vatamt">
                            </td>
                            <td>
                                <input type="text" class="form-control unit" id="unit_1" name="unit[]" data-id='1'>
                            </td>
                            <!--   <td>  
                                <input type="text" class="form-control batch_no" id="batch_no_1" name="batch_no[]"  data-id='1' placeholder="Batch No">
                            </td> -->
                            <td><input type="text" class="form-control float calamt arrow_keypress" name="puit_qty[]" value="1" data-id='1' data-fieldid="puit_qty" id="puit_qty_1" placeholder="Qty">
                            </td>
                            <td>
                                <input type="text" class="form-control puit_unitprice float calamt arrow_keypress" name="puit_unitprice[]" id="puit_unitprice_1" data-fieldid="puit_unitprice" value="0" data-id='1' placeholder="Rate">
                                <input type="hidden" class="form-control unitprice float" name="unitprice[]" id="unitprice_1" value="0" data-id='1' placeholder="Rate">
                            </td>
                            <!--   <td>
                                <input type="text" class="form-control number free" name="free[]" value="0"  data-id='1' placeholder="Free" id="free_1">
                            </td> -->

                            <td>
                                <input type="text" class="form-control float calamt eachcc arrow_keypress" name="cc[]" data-fieldid="cc" id="cc_1" value="0" data-id='1' placeholder="CC">
                            </td>
                            <td>
                                <input type="text" class="form-control discount float calamt arrow_keypress " name="discount[]" data-fieldid="discount" id="discount_1" value="0" data-id='1' placeholder="Dis">

                            </td>
                            <td>
                                <input type="text" class="form-control float calamt vat arrow_keypress" name="vat[]" data-fieldid="vat" id="vat_1" value="13" data-id='1' placeholder="Vat">

                            </td>
                            <td>
                                <input type="text" name="totalamt[]" class="form-control eachtotalamt" value="0" id="totalamt_1" readonly="true">
                            </td>
                            <!--    <td><input type="text" class="form-control <?php //echo DATEPICKER_CLASS; 
                                                                                ?>" name="trde_expdate[]" id="expiry_date_1"  data-id='1' placeholder="Exp Date"> </td> -->
                            <td>
                                <textarea class="form-control" data-id='1' id="description_1" placeholder="Description" name="description[]" style="margin: 0px; width: 261px; height: 76px; line-height: 18px;" ></textarea>
                            </td>
                            <td>
                                <div class="actionDiv acDiv2"></div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tr>
                    <td colspan="15">
                        <a href="javascript:void(0)" class="btn btn-primary btnAdd pull-right" data-id="1" id="addOrder_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-plus" aria-hidden="true"></i></span></a>
                    </td>
                </tr>
            </table>
            <div class="roi_footer">
                <div class="row">
                    <div class="col-sm-4">
                        
                        <!-- <div class="dis_tab mbtm_15">
                                <label class="pr-10 table-cell width_75">Bill Amount : </label>
                                <input type="text" class="form-control float" name="bill_amount" id="bill_amount" />
                            </div> -->
                        <div>
                            <label for=""><?php echo $this->lang->line('remarks'); ?> : </label>
                            <textarea name="remarks" class="form-control" rows="4" placeholder=""></textarea>
                        </div>

                        <!-- <div class="table-responsive">
                                <table style="width: 100%;" class="table purs_table dataTable suppilerTable">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>ch.No</th>
                                            <th>Suppiler</th>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>   
                                        </tr>
                                    </thead>
                                </table>
                            </div> -->
                    </div>
                    <div class="col-sm-6 pull-right">

                        <fieldset class="pull-right mtop_10 pad-top-14">
                            <ul>
                                <li>
                                    <label><?php echo $this->lang->line('sub_total'); ?></label>
                                    <input type="text" class="form-control float" name="subtotalamt" id="subtotalamt" value="" />
                                </li>
                                <li>
                                    <label><?php echo $this->lang->line('discount'); ?></label>
                                    <input type="text" class="form-control float" name="discountamt" id="discountamt" value="0" />
                                </li>
                                <!-- readonly="true" -->

                                <li>
                                    <label><?php echo $this->lang->line('tax'); ?></label>
                                    <input type="text" class="form-control float" name="taxamt" id="taxamt" value="" />

                                </li>
                                <li>
                                    <label><?php echo $this->lang->line('grand_total'); ?> </label>
                                    <input type="text" class="form-control float" name="totalamount" id="totalamount" />
                                </li>

                                <li>
                                    <label><?php echo $this->lang->line('extra'); ?></label>
                                    <input type="text" class="form-control float extra" name="extra" id="extra" value="0" />
                                </li>
                                <li>
                                    <label><?php echo $this->lang->line('rf'); ?></label>
                                    <input type="text" class="form-control float" name="rf" id="rf" value="" />
                                </li>
                                <li>
                                    <label><?php echo $this->lang->line('clearance_amt'); ?></label>
                                    <input type="text" class="form-control extra" name="clearanceamt" id="clearanceamt">
                                    
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
                                        <input type="text" class="form-control float calculateextra" name="insurance" id="insurance" value="0" data-discount="per" />
                                    </li>
                                    <li>
                                        <label><?php echo $this->lang->line('carriage_freight'); ?> :</label>
                                        <input type="text" class="form-control float calculateextra" name="carriage" id="carriage" value="0" data-discount="amt" />
                                    </li>
                                    <li>
                                        <label><?php echo $this->lang->line('packing'); ?> :</label>
                                        <input type="text" class="form-control float calculateextra" name="packing" id="packing" value="0" />
                                    </li>
                                    <li>
                                        <label><?php echo $this->lang->line('transport_courier'); ?> :</label>
                                        <input type="text" class="form-control float calculateextra" name="transportamt" id="transportamt" value="0" />
                                    </li>
                                    <li>
                                        <label><?php echo $this->lang->line('other'); ?> :</label>
                                        <input type="text" class="form-control float calculateextra" id="otheramt" name="otheramt" value="0" />
                                    </li>
                                </ul>
                            </fieldset>
                    </div>
                </div>
           <!--  <p style="font-weight: bold">In word:  <span style="text-decoration: underline; font-weight: 400">One thousand three hundred fifty one only</span></p> -->

            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <?php
            $save_var = $this->lang->line('save');
            $save_n_print = $this->lang->line('save_and_print');
            $update_var = $this->lang->line('update');
            $update_n_print = $this->lang->line('update_and_print'); ?>
            <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($purchased_data) ? 'update' : 'save' ?>' id="btnSubmit"><?php echo !empty($purchased_data) ? $update_var : $save_var ?></button>
            <button type="submit" class="btn btn-info savePrint" data-operation='<?php echo !empty($purchased_data) ? 'update' : 'save ' ?>' id="btnSubmit" data-print="print"><?php echo !empty($purchased_data) ? $update_n_print : $save_n_print ?></button>

        </div>
        <div class="col-sm-12">
            <div class="alert-success success"></div>
            <div class="alert-danger error"></div>
        </div>
    </div>
    <div class="print_report_section printTable"></div>
    <script type="text/javascript">
        $(document).off('click', '.btnAdd');
        $(document).on('click', '.btnAdd', function() {
            var id = $(this).data('id');
            var vatval=$('.allvat').val();
            if(vatval){
                vatval=vatval;
            }else{
                vatval=0;
            }
            var productcontent = $('#puit_barcode_' + id).html();
            var barcode = $('#itemname_' + id).val();
            var product = $('#itemid_' + id).val();
            var unit = $('#puit_unitid_' + id).val();
            var qty = $('#puit_qty_' + id).val();
            var rate = $('#puit_unitprice_' + id).val();
            var tax = $('#puit_taxid_' + id).val();

            if (product == '' || product == null) {
                $('#itemid_' + id).select2('open');
                $('#puit_barcode_' + id).focus();
                return false;
            }
            if (qty == '' || qty == null) {
                $('#puit_qty_' + id).focus();
                return false;
            }
            if (rate == '' || rate == null) {
                $('#puit_unitprice_' + id).focus();
                return false;
            }
            var orderlen = $('.orderrow').length;

            var newitemid = $('#itemid_' + orderlen).val();
            if (newitemid == '') {
                $('#puit_barcode_' + orderlen).focus();
                return false;
            }

            var matType = $("#mattypeid").val();
     setTimeout(function(){
                  $('.btnitem').attr('data-type',matType);
            },500);  

            var trplusOne = orderlen + 1;
            if (trplusOne == 2) {
                $('.actionDiv').html('<a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="1"  id="addRequistion_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>');
            }
            var templat = '';

            templat = '<tr class="orderrow" id="orderrow_' + trplusOne + '" data-id="' + trplusOne + '"> <td> <input type="text" class="form-control sno" id="s_no_' + trplusOne + '" value="' + trplusOne + '" readonly/> <input type="hidden" class="form-control receiveddetailid" id="receiveddetailid_' + trplusOne + '" name="receiveddetailid[]" value="' + trplusOne + '" readonly/> </td><td> <div class="dis_tab"> <input type="text" class="form-control itemcode enterinput " id="puit_barcode_' + trplusOne + '" name="puit_barcode[]" data-id="' + trplusOne + '" data-targetbtn="view" placeholder="Item Code"> <input type="hidden" class="qude_itemsid" name="trde_itemsid[]" data-id="' + trplusOne + '" value="" id="itemid_' + trplusOne + '"> <input type="hidden" class="itemsid" name="itemsid[]" data-id="' + trplusOne + '" value="" id="matdetailid_' + trplusOne + '"> <input type="hidden" class="controlno" name="controlno[]" data-id="' + trplusOne + '" value="" id="controlno_' + trplusOne + '"> <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem " data-heading="Item List" data-viewurl="<?php echo base_url('stock_inventory/item/list_item_normal'); ?>"" data-id="' + trplusOne + '" id="view_' + trplusOne + '"><strong>...</strong></a>&nbsp<a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading="Item Entry" data-viewurl="<?php echo base_url('stock_inventory/item/item_entry/modal'); ?>"data-id="' + trplusOne + '" id="view_' + trplusOne + '">+</a> </div></td><td>  <input type="hidden" class="eachsubtotal" name="eachsubtotal[]" id="eachsubtotal_' + trplusOne + '" ><input type="hidden" name="vatamt[]" value="" id="vatamt_' + trplusOne + '" class="vatamt calamt">  <input type="text" class="form-control itemname" id="itemname_' + trplusOne + '" name="itemname[]" data-id="' + trplusOne + '" placeholder="Item name" readonly> </td><td> <input type="text" class="form-control unit" id="unit_' + trplusOne + '" name="unit[]" data-id="' + trplusOne + '"> </td><td><input type="text" class="form-control float calamt puit_qty arrow_keypress " data-fieldid="puit_qty" name="puit_qty[]" value="1" data-id="' + trplusOne + '" id="puit_qty_' + trplusOne + '" placeholder="Qty">   </td><td> <input type="text" class="form-control float unitprice calamt arrow_keypress " name="puit_unitprice[]" data-fieldid="puit_unitprice" id="puit_unitprice_' + trplusOne + '" value="" data-id="' + trplusOne + '" placeholder=""> </td><td> <input type="text" class="form-control float calamt eachcc arrow_keypress " name="cc[]" data-fieldid="cc" id="cc_' + trplusOne + '" value="0" data-id="' + trplusOne + '" placeholder="CC"> </td><td> <input type="text" class="form-control float calamt discount arrow_keypress " name="discount[]" data-fieldid="discount" id="discount_' + trplusOne + '" value="0" data-id="' + trplusOne + '" placeholder="Dis"> <input type="hidden" name="disamt[]" value="0" id="disamt_' + trplusOne + '" class="disamt calamt"></td><td><input type="text" class="form-control float calamt vat arrow_keypress" name="vat[]" data-fieldid="vat" id="vat_' + trplusOne + '" value="'+vatval+'" data-id="' + trplusOne + '" placeholder="Vat"> </td><td><input type="text" name="totalamt[]" class="form-control eachtotalamt" value="0" readonly="true" id="totalamt_' + trplusOne + '"> </td><td> <textarea type="text" class="form-control description jump_to_add" name="description[]" id="description_' + trplusOne + '" value="" data-id="' + trplusOne + '" placeholder="Description"></textarea> </td><td><a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="' + trplusOne + '"  id="addRequistion_' + trplusOne + '"><span class="btnChange" id="btnChange_' + trplusOne + '"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a></div> <div class="actionDiv"></td></tr>';

            // console.log(templat);
            $('#purchaseDataBody').append(templat);
            $('.btnTemp').hide();
            $('.nepdatepicker').nepaliDatePicker({
                npdMonth: true,
                npdYear: true,
            });
            // getProductsByCategory();
        });
        //remove product rows
        $(document).off('click', '.btnRemove');
        $(document).on('click', '.btnRemove', function() {
            var id = $(this).data('id');
            var whichtr = $(this).closest("tr");

            var conf = confirm('Are Your Want to Sure to remove?');
            if (conf) {
                $('#orderrow_' + id).fadeOut(1000, function() {
                    $('#orderrow_' + id).remove();

                    setTimeout(function() {
                        $(".orderrow").each(function(i, k) {
                            var vali = i + 1;
                            $(this).attr("id", "orderrow_" + vali);
                            $(this).attr("data-id", vali);
                            $(this).find('.sno').attr("id", "s_no_" + vali);
                            $(this).find('.sno').attr("value", vali);
                            //batch_no
                            $(this).find('.itemname').attr("id", "itemname_" + vali);
                            $(this).find('.puit_barcode').attr("data-id", vali);
                            $(this).find('.itemcode').attr("id", "itemcode_" + vali);
                            $(this).find('.puit_productid').attr("data-id", vali);
                            $(this).find('.puit_unitid').attr("id", "puit_unitid_" + vali);
                            $(this).find('.puit_unitid').attr("data-id", vali);

                            $(this).find('.receiveddetailid').attr("id", "receiveddetailid_" + vali);
                            $(this).find('.receiveddetailid').attr("data-id", vali);

                            $(this).find('.itemcode').attr("id", "itemcode_" + vali);
                            $(this).find('.itemcode').attr("data-id", vali);

                            $(this).find('.qude_itemsid').attr("id", "itemid_" + vali);
                            $(this).find('.qude_itemsid').attr("data-id", vali);

                            $(this).find('.controlno').attr("id", "controlno_" + vali);
                            $(this).find('.controlno').attr("data-id", vali);

                            $(this).find('.itemsid').attr("id", "matdetailid_" + vali);
                            $(this).find('.itemsid').attr("data-id", vali);

                            $(this).find('.view').attr("id", "view_" + vali);
                            $(this).find('.view').attr("data-id", vali);

                            $(this).find('.eachsubtotal').attr("id", "eachsubtotal_" + vali);
                            $(this).find('.eachsubtotal').attr("data-id", vali);

                            $(this).find('.vatamt').attr("id", "vatamt_" + vali);
                            $(this).find('.vatamt').attr("data-id", vali);

                            $(this).find('.itemname').attr("id", "itemname_" + vali);
                            $(this).find('.itemname').attr("data-id", vali);

                            $(this).find('.unit').attr("id", "unit_" + vali);
                            $(this).find('.unit').attr("data-id", vali);

                            $(this).find('.eachcc').attr("id", "cc_" + vali);
                            $(this).find('.eachcc').attr("data-id", vali);

                            $(this).find('.discount').attr("id", "discount_" + vali);
                            $(this).find('.discount').attr("data-id", vali);

                            $(this).find('.disamt').attr("id", "disamt_" + vali);
                            $(this).find('.disamt').attr("data-id", vali);

                            $(this).find('.vat').attr("id", "vat_" + vali);
                            $(this).find('.vat').attr("data-id", vali);

                            $(this).find('.eachtotalamt').attr("id", "totalamt_" + vali);
                            $(this).find('.eachtotalamt').attr("data-id", vali);

                            $(this).find('.description').attr("id", "description_" + vali);
                            $(this).find('.description').attr("data-id", vali);

                            $(this).find('.btnRemove').attr("id", "addRequistion_" + vali);
                            $(this).find('.btnRemove').attr("data-id", vali);

                            $(this).find('.puit_qty').attr("id", "puit_qty_" + vali);
                            $(this).find('.puit_qty').attr("data-id", vali);
                            $(this).find('.puit_unitprice').attr("id", "puit_unitprice_" + vali);
                            $(this).find('.puit_unitprice').attr("data-id", vali);
                            $(this).find('.unitprice').attr("id", "unitprice_" + vali);
                            $(this).find('.unitprice').attr("data-id", vali);
                            $(this).find('.puit_taxid').attr("id", "puit_taxid_" + vali);
                            $(this).find('.puit_taxid').attr("data-id", vali);
                            $(this).find('.totalamount').attr("id", "totalamount_" + vali);
                            $(this).find('.totalamount').attr("data-id", vali);
                            $(this).find('.btnAdd').attr("id", "addRequistion_" + vali);
                            $(this).find('.btnAdd').attr("data-id", vali);
                            $(this).find('.btnChange').attr("id", "btnChange_" + vali);
                        });
                    }, 1500);

                });
            }
        });
    </script>
    <script type="text/javascript">
        $(document).on('change keyup', '.extra', function() {
            var totalamt = $('#totalamount').val();
            var extraamt = $('#extra').val();
            if (totalamt == null || totalamt == '') {
                totalamt = 0;
            }
            if (extraamt == null || extraamt == '') {
                extraamt = 0;
            }
            var clearanceamt = parseFloat(totalamt) + parseFloat(extraamt);
            $('#clearanceamt').val(clearanceamt.toFixed(2));
             $('#lblgtotal').html(parseFloat(clearanceamt.toFixed(2)).toLocaleString(window.document.documentElement.lang));
        })
        $(document).off('keyup change', '.calamt');
        $(document).on('keyup change', '.calamt', function() {
            var id = $(this).data('id');
            var qty = $('#puit_qty_' + id).val();
            if (qty == null || qty == '') {
                qty = 0;
            }
            var rate = $('#puit_unitprice_' + id).val();
            if (rate == null || rate == '' ) {
                rate = 0;
            }
            var discount = $('#discount_' + id).val();
            if (discount == null || discount == '') {
                discount = 0;
            }
            var vat = $('#vat_' + id).val();
            if (vat == null || vat == ' ') {
                vat = 0;
            }
            var cc = $('#cc_' + id).val();
            if (cc == null || cc == ' ') {
                cc = 0;
            }
            var totalamt = 0;
            var rate_qty = parseFloat(qty) * parseFloat(rate);
            $('#eachsubtotal_' + id).val(rate_qty);
            if (rate > 0) {
                $('#free_' + id).val(0);
            }

            // alert(rate_qty);
            var disamt = 0;
            var with_dis = 0;
            var with_vat = 0;
            if (discount) {
                disamt = rate_qty * (discount / 100);
                with_dis = rate_qty - disamt;
            } else {
                disamt = 0;
                with_dis = rate_qty;

            }
            if (vat) {
                vatamt = with_dis * vat / 100;
                with_vat = with_dis + vatamt;
            } else {
                vatamt = with_dis * vat / 100;
                with_vat = with_dis + vatamt;

            }
            $('#totalamt_' + id).val(with_vat.toFixed(2));
            // $('#totalamt_1').val(500);
            $('#vatamt_' + id).val(vatamt.toFixed(2));
            $('#disamt_' + id).val(disamt.toFixed(2));
            // $('#cc_'+id).

            // console.log(with_vat);

            // eachtotalamt
            var stotal = 0;
            var stotalvat = 0;
            var stotoaldis = 0;
            var eachsubtotal = 0;
            var eachcctotal = 0;
            $(".eachtotalamt").each(function() {
                stotal += parseFloat($(this).val());
            });

            $(".vatamt").each(function() {
                stotalvat += parseFloat($(this).val());
            });

            $(".disamt").each(function() {
                stotoaldis += parseFloat($(this).val());
            });

            $(".eachsubtotal").each(function() {
                eachsubtotal += parseFloat($(this).val());
            });

            $(".eachcc").each(function() {
                eachcctotal += parseFloat($(this).val());
            });

            // alert(with_vat);
            eachsubtotal = parseFloat(eachsubtotal) + parseFloat(eachcctotal);
            stotoaldis == parseFloat(stotoaldis) + parseFloat(cc);
            stotal = parseFloat(stotal) + parseFloat(eachcctotal);
            with_vat = parseFloat(with_vat) + parseFloat(cc);


            $('#taxamt').val(stotalvat.toFixed(2));
            $('#discountamt').val(stotoaldis.toFixed(2));
            $('#subtotalamt').val(eachsubtotal.toFixed(2));
            $('#totalamount').val(stotal.toFixed(2));
            $('.extra').change();

        })


        $(document).on('click', '.itemDetail', function() {
            var rowno = $(this).data('rowno');
            var rate = $(this).data('rate');
            var itemcode = $(this).data('itemcode');
            var itemname = $(this).data('itemname');
            var itemname_display = $(this).data('itemname_display');
            var itemid = $(this).data('itemid');
            var stockqty = $(this).data('stockqty');
            var matdetailid = $(this).data('mattransdetailid');
            var controlno = $(this).data('controlno');
            var unit = $(this).data('unit');
            var purchaserate = $(this).data('purchaserate');

            $('#puit_unitprice_' + rowno).val(rate);
            $('#unitprice_' + rowno).val(rate);
            $('#unit_' + rowno).val(unit);
            $('#puit_barcode_' + rowno).val(itemcode);
            $('#itemid_' + rowno).val(itemid);
            $('#itemname_' + rowno).val(itemname_display);
            $('#itemstock_' + rowno).val(stockqty);
            $('#matdetailid_' + rowno).val(matdetailid);
            $('#controlno_' + rowno).val(controlno);
            $('#myView').modal('hide');
            $('#puit_qty_' + rowno).select().focus();
            $('.calamt').change();
        })
    </script>

    <script>
        $(document).ready(function() {
            var id = $('.idfornot').data('id');
            calculate();
            $('#puit_qty_' + id).change();
            $('#puit_unitprice_' + id).change();

            var grandtotal = 0;
            var discounttotal = 0;

            var type = '';
            var discount = 0;
            var taxvalue = 0;

            function calculate() {
                var stotal = 0;
                var trid = $('.idfornot').data('id');
                var qty = $('#puit_qty_' + trid).val();
                if (qty == '') {
                    qty = 0;
                } else {
                    qty = parseFloat(qty);
                }
                var price = $('#puit_unitprice_' + trid).val();
                if (price == '') {
                    price = 0;
                } else {
                    price = parseFloat(price);
                }
                var totalamt = qty * price;
                $('#puit_total_' + trid).val(totalamt);
                $(".totalamount").each(function() {
                    stotal += parseFloat($(this).val());
                });
                $('#subtotal').val(stotal);
                $('#grandtotal').val(stotal);
                $('#discountType').change();
            };
        })
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
            var matType = $("#mattypeid").val();
         setTimeout(function(){
                      $('.btnitem').attr('data-type',matType);
                },500);  

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
              var matType = $("#mattypeid").val();
             setTimeout(function(){
                          $('.btnitem').attr('data-type',matType);
                    },500);  

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
                    $('#receivedno').val(data.received_no);
                    $('#receivedno').removeAttr('disabled');              
                }

        });
    </script>

    <script type="text/javascript">
        $(document).off('change', '#locationid');
        $(document).on('change', '#locationid', function(e) {
            var schoolid = $(this).val();
            var submitdata = {
                schoolid: schoolid
            };
            var submiturl = base_url + 'issue_consumption/stock_requisition/get_department_by_schoolid';
            // aletr(schoolid);
            $('#rema_reqfromdepid').html('');


            ajaxPostSubmit(submiturl, submitdata, beforeSend, onSuccess);

            function beforeSend() {


            };

            function onSuccess(jsons) {
                data = jQuery.parseJSON(jsons);
                if (data.status == 'success') {
                    $('#subdepdiv').hide();
                    $('#rema_reqfromdepid').html(data.dept_list);
                } else {
                    $('#rema_reqfromdepid').html();
                    $("#rema_reqfromdepid").select2("val", "");
                    $("#subdepid").select2("val", "");


                }

            }
        });

        $(document).off('change', '#rema_reqfromdepid');
        $(document).on('change', '#rema_reqfromdepid', function(e) {
            var schoolid = $(this).val();
            var submitdata = {
                schoolid: schoolid
            };
            var submiturl = base_url + 'issue_consumption/stock_requisition/get_department_by_schoolid';
            // aletr(schoolid);
            $("#subdepid").select2("val", "");
            $('#subdepid').html('');
            ajaxPostSubmit(submiturl, submitdata, beforeSend, onSuccess);

            function beforeSend() {


            };

            function onSuccess(jsons) {
                data = jQuery.parseJSON(jsons);
                if (data.status == 'success') {
                    $('#subdepdiv').show();
                    $('#subdepid').html(data.dept_list);
                } else {
                    $('#subdepdiv').hide();
                    $('#subdepid').html();
                }


            }
        });


        $(document).off('keyup','.allvat');
        $(document).on('keyup','.allvat',function(e){
            // $('.vat')
            var allvat=$(this).val();
            // alert(allvat);
            // return false;
            $(".vat").each(function() {
                $(this).val(allvat);
            });
            $('.calamt').change();
        })

         $(document).off('keyup','.vat');
        $(document).on('keyup','.vat',function(e){
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

        var extratotal = parseFloat(valid_insurance) + parseFloat(valid_carriage) + parseFloat(valid_packing) + parseFloat(valid_transportamt) + parseFloat(valid_otheramt);

        var valid_extratotal = checkValidValue(extratotal);

        $('#extra').val(valid_extratotal.toFixed(2));

        $('.calamt').change();
    });


    $(document).off('change', '#mattypeid');
    $(document).on('change', '#mattypeid', function(e) {
      var mattypeid = $(this).val();
        var submitdata = {
            mattypeid: mattypeid
        };
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