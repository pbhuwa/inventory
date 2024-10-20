<form method="post" id="FormDirectPurchase" action="<?php echo base_url('issue_consumption/challan/save_challan_bill_entry'); ?>" data-reloadurl='<?php echo base_url('issue_consumption/challan/form_challan_bill_entry'); ?>' class="form-material form-horizontal form" >
    <?php
        $receivedmasterid = !empty($purchased_data[0]->chma_challanmasterid)?$purchased_data[0]->chma_challanmasterid:'';
    ?>
    <input type="hidden" name="id" value="<?php echo $receivedmasterid; ?>" />
    <input type="hidden" name="purchaseordermasterid" id="purchaseordermasterid"/>

    <div class="form-group">
        <div class="col-md-3 col-sm-3">
            <?php 
                $fiscalyear=!empty($order_details[0]->puor_fyear)?$order_details[0]->puor_fyear:''; 
            ?>
            <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?><span class="required">*</span>:</label>
            <select name="fiscalyear" class="form-control select2" id="fiscalyear" >
                <option value="">---select---</option>
                    <?php
                        if($fiscal):
                            foreach ($fiscal as $km => $fy):
                    ?>
                <option value="<?php echo $fy->fiye_name; ?>" <?php if($fy->fiye_status=='I') echo "selected=selected"; ?>><?php echo $fy->fiye_name; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
            </select>
        </div>

        <div class="col-md-3 col-sm-3">
            <?php 
                $orderno=!empty($order_details[0]->puor_order_for)?$order_details[0]->puor_order_for:''; 
            ?>
            <label for="example-text"><?php echo $this->lang->line('order_no'); ?>
            <span class="required">*</span>:</label>
            <div class="dis_tab">
                <input type="text" class="form-control required_field enterinput"  name="orderno"  value="" placeholder="Enter Order Number" id="orderno" data-targetbtn='btnSearchOrderno'>
           
                <a href="javascript:void(0)" class="table-cell width_30 btn btn-success" id="btnSearchOrderno" ><i class="fa fa-search"></i></a>
                &nbsp;
      
                <a href="javascript:void(0)" data-id="0" data-displaydiv="Issue" data-viewurl="<?php echo base_url('issue_consumption/challan/load_order_list/challan'); ?>" class="view table-cell width_30 btn btn-success" data-heading="Load Order list" id="orderload"><i class="fa fa-upload"></i></a>
            </div>
        </div>
    </div>

    <div id="orderData">
        <div class="form-group">
            <div class="col-md-3 col-sm-3">
                <label for="example-text"><?php echo $this->lang->line('received_number'); ?></label>
                <input type="text" name="received_no" class="form-control"  placeholder="Received No." value="<?php echo !empty($received_no)?$received_no:''; ?>" id="receivedno" readonly>
                <span class="errmsg"></span>
            </div>

            <div class="col-md-3 col-sm-4">
                <?php $supplierid=!empty($purchased_data[0]->chma_supplierid)?$purchased_data[0]->chma_supplierid:''; ?>
                <label for="example-text"><?php echo $this->lang->line('supplier_name'); ?> <span class="required">*</span>:</label>
                <select name="supplierid" class="form-control required_field select2" id="suppliername">
                    <option value="">---select---</option>
                    <?php
                        if(!empty($distributor)):
                            foreach ($distributor as $km => $sup):
                    ?>
                    <option value="<?php echo $sup->dist_distributorid; ?>"  <?php if($supplierid == $sup->dist_distributorid) echo "selected=selected" ?>><?php echo $sup->dist_distributor; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </select>
            </div>

            <div class="col-md-3 col-sm-4">
                <label for="example-text"><?php echo $this->lang->line('order_date'); ?> </label>
                <input type="text" name="order_date" class="form-control"  placeholder="Order Date" id="OrderDate" value="" readonly>
                <span class="errmsg"></span>
            </div>

            <div class="col-md-3 col-sm-4">
                <label for="example-text"><?php echo $this->lang->line('received_date'); ?>: </label>
                <input type="text" name="received_date" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Received Date" id="received_date"  value="<?php echo !empty($purchased_data[0]->recm_receiveddatebs)?$purchased_data[0]->recm_receiveddatebs:DISPLAY_DATE; ?>">
                <span class="errmsg"></span>
            </div>
            
            <div class="col-md-3 col-sm-4">
                <label for="example-text"><?php echo $this->lang->line('supplier_bill_no'); ?>:<span class="required">*</span> </label>
                <input type="text" name="suplier_bill_no" value="<?php echo !empty($purchased_data[0]->recm_supplierbillno)?$purchased_data[0]->recm_supplierbillno:''; ?>" class="form-control required_field"  placeholder="Supplier Bill No" >
                <span class="errmsg"></span>
            </div>
            
            <div class="col-md-3 col-sm-4">
                <label for="example-text"><?php echo $this->lang->line('supplier_bill_date'); ?><span class="required">*</span>: </label>
                <input type="text" name="suplier_bill_date" class="form-control required_field <?php echo DATEPICKER_CLASS; ?> date"  placeholder="<?php echo $this->lang->line('supplier_bill_date'); ?>" value="<?php echo DISPLAY_DATE; ?>" id="SupBillDate">
                <span class="errmsg"></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="pad-5" id="displayDetailList">
            <div class="table-responsive">
                <table style="width:100%;" class="table purs_table dataTable">
                    <thead>
                        <tr>
                            <th width="2%"><?php echo $this->lang->line('sn'); ?></th>
                            <th width="12%"><?php echo $this->lang->line('item_code'); ?></th>
                            <th width="18%"><?php echo $this->lang->line('item_name'); ?></th>
                            <th width="5%"><?php echo $this->lang->line('unit'); ?> </th>
                            <!-- <th width="8%">Batch No </th> -->
                            <th width="5%"><?php echo $this->lang->line('qty'); ?></th>
                            <th width="5%"><?php echo $this->lang->line('rate'); ?></th>
                            <!--  <th width="5%">Free</th> -->
                            <th width="5%"><?php echo $this->lang->line('cc'); ?></th>
                            <th width="5%"><?php echo $this->lang->line('dis'); ?></th>
                            <th width="5%"><?php echo $this->lang->line('vat'); ?></th>
                            <th width="8%"><?php echo $this->lang->line('amount'); ?></th>
                            <!-- <th width="8%">Exp.Date</th> -->
                            <th width="10%"><?php echo $this->lang->line('description'); ?></th>
                            <th width="5%"><?php echo $this->lang->line('action'); ?></th>
                        </tr>
                    </thead>
                    <tbody id="purchaseDataBody">
                        <?php 
                            if($challan_details){
                                foreach ($challan_details as $key => $pd) { //echo "<pre>";print_r($challan_details);die;
                        ?>
                        <tr class="orderrow" id="orderrow_<?php echo $key+1; ?>" data-id='<?php echo $key+1; ?>'>
                            <input type="hidden" name="tmraid" value="<?php echo $pd->chma_mattransmasterid; ?>">
                            <input type="hidden" name="challandetailid[]" value="<?php echo $pd->chde_challandetailid; ?>">

                            <td>
                                <input type="text" class="form-control sno" id="s_no_<?php echo $key+1; ?>" value="<?php echo $key+1; ?>" readonly/>
                                <input type="hidden" class="receiveddetailid" name="receiveddetailid[]" id="receiveddetailid_<?php echo $key+1;?>" value="<?php echo !empty($pd->recd_receiveddetailid)?$pd->recd_receiveddetailid:'';?>"/>
                            </td>
                            
                            <td>
                                <div class="dis_tab"> 
                                    <input type="text" class="form-control itemcode enterinput " id="puit_barcode_<?php echo $key+1; ?>" name="puit_barcode[]" value="<?php echo $pd->itli_itemcode; ?>" data-id='<?php echo $key+1; ?>' data-targetbtn='view' placeholder="Item Code" readonly>
                                    <input type="hidden" class="qude_itemsid" name="trde_itemsid[]" data-id='<?php echo $key+1; ?>' value="<?php echo $pd->chde_itemsid; ?>" id="itemid_<?php echo $key+1; ?>">
                                    <input type="hidden" class="itemsid" name="itemsid[]" data-id='<?php echo $key+1; ?>' value="" id="matdetailid_<?php echo $key+1; ?>">
                                    <input type="hidden" class="controlno" name="controlno[]" data-id='<?php echo $key+1; ?>' value="" id="controlno_<?php echo $key+1; ?>">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading='Item List' data-viewurl='<?php echo base_url('stock_inventory/item/list_item_normal'); ?>' data-id='<?php echo $key+1; ?>' id="view_<?php echo $key+1; ?>"><strong>...</strong></a>
                                </div>
                            </td>
                                
                            <td>  
                                <input type="text" class="form-control itemname" id="itemname_<?php echo $key+1; ?>" value="<?php echo $pd->itli_itemname; ?>"  name="itemname[]"  data-id='<?php echo $key+1; ?>' placeholder="Item name" readonly>
                                <input type="hidden" class="eachsubtotal" name="eachsubtotal[]" id="eachsubtotal_<?php echo $key+1; ?>" >
                                <input type="hidden" name="disamt[]" value="" id="disamt_<?php echo $key+1; ?>" class="disamt calamt"> 
                                <input type="hidden" name="vatamt[]" value="" id="vatamt_<?php echo $key+1; ?>" class="vatamt">
                            </td>
                            
                            <td>  
                                <input type="text" class="form-control unit" id="unit_<?php echo $key+1; ?>" name="unit[]"  data-id='<?php echo $key+1; ?>' value="<?php echo $pd->unit_unitname; ?>">
                            </td>
                            
                            <td>
                                <input type="text" class="form-control number calamt" name="puit_qty[]" value="<?php echo !empty($pd->chde_qty)?$pd->chde_qty:'0'; ?>" data-id='<?php echo $key+1; ?>' id="puit_qty_<?php echo $key+1; ?>" placeholder="Qty">
                            </td>
                            
                            <td>
                                <input type="text" class="form-control puit_unitprice float calamt" name="puit_unitprice[]" id="puit_unitprice_<?php echo $key+1; ?>" value="<?php echo !empty($pd->recd_unitprice)?$pd->recd_unitprice:'0'; ?>"  data-id='<?php echo $key+1; ?>' placeholder="Rate">
                                    <input type="hidden" class="form-control unitprice float" name="unitprice[]" id="unitprice_1" value="0"  data-id='1' placeholder="Rate">
                            </td>
                            
                            <td>
                                <input type="text" class="form-control number calamt eachcc" name="cc[]" id="cc_<?php echo $key+1; ?>" value="<?php echo !empty($pd->recd_cccharge)?$pd->recd_cccharge:'0'; ?>"  data-id='<?php echo $key+1; ?>' placeholder="CC">
                            </td>
                            
                            <td>
                                <input type="text" class="form-control discount float calamt " name="discount[]" id="discount_<?php echo $key+1; ?>"  value="<?php echo !empty($pd->recd_discountpc)?$pd->recd_discountpc:'0'; ?>"  data-id='<?php echo $key+1; ?>' placeholder="Dis">
                            </td>
                            
                            <td>
                                <input type="text" class="form-control vat float calamt idfornot" name="vat[]" id="vat_<?php echo $key+1; ?>" value="<?php echo !empty($pd->recd_vatpc)?$pd->recd_vatpc:'0'; ?> "  data-id='<?php echo $key+1; ?>' placeholder="Vat">
                            </td>
                            
                            <td>
                                <?php //$subtotal = ($pd->recd_purchasedqty)*($pd->recd_unitprice); ?>
                                <input type="text" name="totalamt[]" class="form-control eachtotalamt" value="<?php //echo !empty($subtotal)?$subtotal:'0'; ?>"  id="totalamt_<?php echo $key+1; ?>" readonly="true"> 
                            </td>
                                
                            <td>
                                <input type="text" class="form-control description" name="description[]" value="<?php echo !empty($pd->chde_remarks)?$pd->chde_remarks:''; ?>" data-id='<?php echo $key+1; ?>' placeholder="Description" id="description_<?php echo $key+1; ?>"> 
                            </td>
                            
                            <td>
                                <div class="actionDiv acDiv2"></div>
                            </td>
                        </tr>
                        
                        <script>
                            $(document).ready(function () {
                                var id=$('.idfornot').data('id');
                                calculate();
                                $('#puit_qty_'+id).change();
                                $('#puit_unitprice_'+id).change();
                           
                                var grandtotal = 0;
                                var discounttotal = 0;
                                
                                var type = '';
                                var discount = 0;
                                var taxvalue =  0;
                               
                                function calculate(){
                                    var stotal=0;
                                    var trid=$('.idfornot').data('id');
                                    var qty=$('#puit_qty_'+trid).val();
                                    if(qty=='')
                                    {
                                        qty=0;
                                    }
                                    else
                                    {
                                        qty=parseFloat(qty);
                                    }
                                    var price=$('#puit_unitprice_'+trid).val();
                                    if(price=='')
                                    {
                                        price=0;
                                    }
                                    else
                                    {
                                        price=parseFloat(price);
                                    }
                                    var totalamt=qty*price;
                                    $('#puit_total_'+trid).val(totalamt);
                                    $(".totalamount").each(function() {
                                        stotal += parseFloat($(this).val());
                                    });
                                    $('#subtotal').val(stotal);
                                    $('#grandtotal').val(stotal);
                                    $('#discountType').change();
                                };
                            })
                        </script>
                        <?php } }
                        ?>
                        </tbody>
                      
                    </table>
                    <div class="roi_footer">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="dis_tab">
                                <label class="vt d-block"><?php echo $this->lang->line('remarks'); ?></label>
                                <textarea name="remarks" id="" cols="40" rows="5" class="form-control table-cell vt"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6 pull-right">
                            <fieldset class="pull-right mtop_10 pad-top-14">
                                <ul>
                                    <li>
                                        <label><?php echo $this->lang->line('total_amount'); ?></label>
                                        <input type="text" class="form-control float totalamount" name="totalamount" value="0" id="totalamount" readonly="true" />
                                    </li>
                                    <li>
                                        <label><?php echo $this->lang->line('discount_in_amount'); ?></label>
                                        <input type="text" class="form-control float discountpc" name="discountamt" id="discountamt" value="0" readonly="true"/>
                                    </li>

                                    <li>
                                        <label>
                                            <?php echo !empty($this->lang->line('overall_discount'))?$this->lang->line('overall_discount'):'Overall Discount'; ?>
                                        </label>

                                        <input type="text" class="form-control float" name="discountamt" id="overall_discount" value="0" data-discount="amt" / >
                                    </li>

                                    <li>
                                        <label><?php echo $this->lang->line('sub_total'); ?></label>
                                        <input type="text" class="form-control float" name="subtotalamt" id="subtotalamt" value="0" readonly="true" />
                                    </li>
                                    <li>
                                        <label><?php echo $this->lang->line('total_tax'); ?> </label>
                                        <input type="text" class="form-control float" name="taxamt" id="taxamt" value="0" readonly="true" />

                                    </li>
                                    <li>
                                        <label><?php echo $this->lang->line('extra_charges'); ?></label>
                                        <input type="text" class="form-control float" name="extra" id="extra" value="0" readonly="true"/>
                                   </li>
                                   <li>
                                       <label><?php echo $this->lang->line('rf'); ?></label>
                                       <input type="text" class="form-control float calculaterefund" name="refund" id="refund" value="0" placeholder="" />
                                    </li>
                                    <li>
                                        <label><?php echo $this->lang->line('clearance_amt'); ?></label>
                                        <input type="text" class="form-control" name="clearanceamt" id="clearanceamt" value="0" >
                                    </li>
                                </ul>
                            </fieldset>
                            
                            <fieldset class="pull-right bordered">
                                <legend class="font_12"><?php echo $this->lang->line('other_charges'); ?></legend>
                                <ul>
                                    <li>
                                        <label><?php echo $this->lang->line('insurance'); ?>:</label>
                                        <input type="text" class="form-control float calculateextra" name="insurance" id="insurance" value="0" data-discount="per"/>
                                    </li>
                                    <li>
                                        <label><?php echo $this->lang->line('carriage_freight'); ?> :</label>
                                        <input type="text" class="form-control float calculateextra" name="carriage" id="carriage" value="0" data-discount="amt" / >
                                    </li>
                                    <li>
                                        <label><?php echo $this->lang->line('packing'); ?> :</label>
                                        <input type="text" class="form-control float calculateextra" name="packing" id="packing" value="0"/>
                                    </li>
                                    <li>
                                        <label><?php echo $this->lang->line('transport_courier'); ?> :</label>
                                        <input type="text" class="form-control float calculateextra" name="transportamt" id="transportamt"  value="0"/>
                                    </li>
                                    <li>
                                        <label><?php echo $this->lang->line('other'); ?> :</label> 
                                        <input type="text" class="form-control float calculateextra" id="otheramt" name="otheramt" value="0" />
                                    </li>
                                </ul>
                            </fieldset>
                        </div>
                    </div> 
                </div>             
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12"> 
               
                <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($purchased_data)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($purchased_data)?'Update':'Save' ?></button>
                <button type="submit" class="btn btn-info savePrint" data-operation='<?php echo !empty($purchased_data)?'update':'save ' ?>' id="btnSubmit" data-print="print"><?php echo !empty($purchased_data)?'Update & Print':'Save & Print' ?></button>
              
            </div>
              <div class="col-sm-12">
                <div  class="alert-success success"></div>
                <div class="alert-danger error"></div>
              </div>
        </div>
<div class="print_report_section printTable"></div>


<script type="text/javascript">
    $(document).off('click','#btnSearchOrderno');
    $(document).on('click','#btnSearchOrderno',function(){
        var orderno=$('#orderno').val();
        var fiscalyear=$('#fiscalyear').val();
        // alert(orderno);
        // ajaxPostSubmit()
        var submitdata = {orderno:orderno,fiscalyear:fiscalyear};
        var submiturl = base_url+'issue_consumption/challan/orderlist_bill_entry_by_order_no';
        beforeSend= $('.overlay').modal('show');

        ajaxPostSubmit(submiturl,submitdata,beforeSend='',onSuccess);
      
        function onSuccess(jsons){
            data = jQuery.parseJSON(jsons);
            var orderdata=data.order_data;
           
            var defaultdatepicker='<?php echo DEFAULT_DATEPICKER ?>';

            if(orderdata)
            {
                var orderdatead=orderdata['puor_orderdatead'];
                var orderdatebs=orderdata['puor_orderdatebs'];
                var supplierid=orderdata['puor_supplierid'];
                var purchaseordermasterid = orderdata['puor_purchaseordermasterid'];
                
                if(defaultdatepicker=='NP')
                {
                    $('#OrderDate').val(orderdatebs);
                }
                else{
                    $('#OrderDate').val(orderdatead);
                }
                $("#suppliername").select2("val", supplierid).trigger('change');
                $('#purchaseordermasterid').val(purchaseordermasterid);
            }
            // console.log(supplierid);

            // alert('tset');
            // console.log('testing');
            // console.log(data.tempform);
            if(data.status=='success')
            {
                $('#displayDetailList').html(data.tempform);
            }
            else
            {   
                alert(data.message); 
                $('#OrderDate').val('');
                $("#suppliername").select2("val", 0).trigger('change');
                // $('#displayDetailList').html('');
            }
            $('.overlay').modal('hide');
        }
   });
</script>

<script type="text/javascript">
   

    //calculate amount
    $(document).off('keyup change','.calamt');
    $(document).on('keyup change','.calamt',function(){
        var amount = 0;
        var disamt=0;
        var with_dis=0;
        var with_vat=0;
        var cc= 0;
        var totalamt=0;
        var free = 0;

        var id = $(this).data('id');
        var qty = $('#recqty_'+id).val();
        var orderqty=$('#order_qty_'+id).val();
        var rate = $('#rate_'+id).val();
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

        var cc = $('#cc_'+id).val();
        var valid_cc = parseFloat(checkValidValue(cc));

        var discount = $('#discount_'+id).val();
        var valid_discount = parseFloat(checkValidValue(discount));

        var vat =$('#vat_'+id).val();
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


        var amount_vq = valid_qty*valid_rate;

        // console.log('amount' + amount_vq);

        if(amount_vq){
            $('#amt_'+id).val(amount_vq.toFixed(2));
            $('#ratexqty_'+id).val(amount_vq.toFixed(2));
        }else{
            $('#amt_'+id).val(0);
            $('#ratexqty_'+id).val(0);
        }

        //check cc
        if(valid_cc && amount_vq != 0){
            amount_cc = amount_vq + valid_cc;
        }else{
            amount_cc = amount_vq;
        }

        if(amount_cc){
            $('#amt_'+id).val(amount_cc.toFixed(2)); 
        }

        //check discount
        if(valid_discount && amount_vq != 0){
            disamt = amount_cc * (valid_discount/100);
            amount_disamt = amount_cc - disamt;
        }else{
            disamt = 0;
            amount_disamt = amount_cc;
        }

        if(amount_disamt){
            $('#amt_'+id).val(amount_disamt.toFixed(2));    
        }

        //check vat
        if(valid_vat && amount_vq != 0){
            vatamt = amount_disamt * (valid_vat/100);
            amount_vatamt = amount_disamt + vatamt;
        }else{
            vatamt = 0;
            amount_vatamt = amount_disamt;
        }
        if(amount_vatamt){
            $('#amt_'+id).val(amount_vatamt.toFixed(2));    
        }

        //calculate for total, total discount, total tax
        var stotal=0;
        var stotalvat=0;
        var stotoaldis=0;
        var sratexqty = 0;

        $(".eachtotalamt").each(function() {
            stotal += parseFloat($(this).val());
        });

        $(".eachratexqty").each(function() {
            sratexqty += parseFloat($(this).val());
        });

        console.log('ratexqty: '+sratexqty);

        $(".vatamt").each(function() {
            stotalvat += parseFloat($(this).val());
        });

        $(".disamt").each(function() {
            stotoaldis += parseFloat($(this).val());
        });

        var extra = parseFloat($('#extra').val());

        if(isNaN(extra)){
            extra = 0;
        }else{
            extra = extra;
        }

        var refund = parseFloat($('#refund').val());

        if(isNaN(refund)){
            refund = 0;
        }else{
            refund = refund;
        }

        var overall_discount = parseFloat($('#overall_discount').val());

        if(isNaN(overall_discount)){
            overall_discount = 0;
        }else{
            overall_discount = overall_discount;
        }

        // var subtotal = stotal-stotoaldis;
        var subtotal = sratexqty-stotoaldis-overall_discount;

        var clearanceamt = subtotal+stotalvat+extra+refund-overall_discount;



        // $('#amt_'+id).html(with_vat.toFixed(2));
        $('#vatamt_'+id).val(vatamt.toFixed(2));
        $('#disamt_'+id).val(disamt.toFixed(2));

        $('#taxamt').val(stotalvat.toFixed(2));
        $('#discountamt').val(stotoaldis.toFixed(2));
        $('#subtotalamt').val(subtotal.toFixed(2));
        // $('#totalamount').val(stotal.toFixed(2));
        $('#totalamount').val(sratexqty.toFixed(2));
        $('#clearanceamt').val(clearanceamt.toFixed(2));    
    
        
    });

    //overall discount
    $(document).off('keyup change','#overall_discount');
    $(document).on('keyup change','#overall_discount',function(){
        var discount = $('#overall_discount').val();

        $('.calamt').change();
    });

    //calculate extra
    $(document).off('keyup change','.calculateextra');
    $(document).on('keyup change','.calculateextra',function(){
        var insurance=$('#insurance').val();        
        var carriage=$('#carriage').val();        
        var packing=$('#packing').val();
        var transportamt=$('#transportamt').val();
        var otheramt=$('#otheramt').val();

        var valid_insurance = checkValidValue(insurance,'insurance');
        var valid_carriage = checkValidValue(carriage,'carriage');
        var valid_packing = checkValidValue(packing,'packing');
        var valid_transportamt = checkValidValue(transportamt,'transportamt');
        var valid_otheramt = checkValidValue(otheramt,'otheramt');

        var extratotal=parseFloat(valid_insurance)+parseFloat(valid_carriage)+parseFloat(valid_packing)+parseFloat(valid_transportamt)+parseFloat(valid_otheramt);

        var valid_extratotal = checkValidValue(extratotal);

        $('#extra').val(valid_extratotal.toFixed(2));
        
        $('.calamt').change();
    });
</script>

<script>
    $(document).off('keyup change','.calculaterefund');
    $(document).on('keyup change','.calculaterefund',function(){
        var refund = $('#refund').val();

        var valid_refund = checkValidValue(refund,'refund');

        $('.calamt').change();

    });
</script>


<?php
    if($loadselect2=='yes'):
?>
    <script type="text/javascript">
        $('.select2').select2();
    </script>
<?php
    endif;
?>

<script type="text/javascript">

    function getDetailList(masterid, main_form=false){
        if(main_form == 'main_form'){
            var submiturl = base_url+'issue_consumption/challan/load_detail_list/new_detail_list_for_bill_entry';
            var displaydiv = '#displayDetailList'; 
        }else{
            var submiturl = base_url+'issue_consumption/challan/load_detail_list';
            var displaydiv = '#detailListBox';
        }
        
        $.ajax({
            type: "POST",
            url: submiturl,
            data: {masterid : masterid},
            beforeSend: function (){
                // $('.overlay').modal('show');
            },
            success: function(jsons){
                var data = jQuery.parseJSON(jsons);
                // console.log(data);
                if(main_form == 'main_form'){
                    if(data.status == 'success'){
                        console.log(data.tempform);
                        if(data.isempty == 'empty'){
                            alert('Pending list is empty. Please try again.');
                               $('#requisition_date').val('');
                               $('#receive_by').val(''); 
                               $('#depnme').select2("val",'');
                               $('#pendinglist').html('');
                               $('#stock_limit').html(0);
                               $('.loadedItems').empty();
                            return false;
                        }else{
                            $(displaydiv).empty().html(data.tempform);
                        }
                    }
                    }else{
                        if(data.status == 'success'){
                        $(displaydiv).empty().html(data.tempform);
                    }
                }
                
                // $('.overlay').modal('hide');
            }
        });
    }

    function blink_text() {
        $('.blink').fadeOut(100);
        $('.blink').fadeIn(1000);
    }

    $(document).off('change','#fiscalyear');
    $(document).on('change','#fiscalyear',function(){
        var fyear = $('#fiscalyear').val();
        $('#cancelLoad').attr('data-fyear',fyear);
    });
</script>

<script type="text/javascript">
    $(document).off('change keyup','.discountpc');
    $(document).on('change keyup','.discountpc',function(){
        
        var disArray = [];
        i = 0;
        total = 0;
        $('.discountpc').each(function(i){  
            field_discount = this.value;

            valid_field_discount = checkValidValue(field_discount);

            disArray[i++]=valid_field_discount;
            total+=parseFloat(valid_field_discount);
        });

        valid_total = checkValidValue(total);

            console.log('valid total: ' +valid_total);

        if(valid_total > 0){
            $('#overall_discount').prop("disabled", true);
            $('#discountamt').prop("disabled", false);
            $('#overall_discount').val('0');
        }else{
            $('#discountamt').prop("disabled", true);
            $('#overall_discount').prop("disabled", false);
             $('#discountamt').val('0');
        }
    });
</script>

<script type="text/javascript">
    $(document).off('keyup change','.vat');
    $(document).on('keyup change','.vat',function(){
        var vat = $(this).val();
        $('[id^="vat_"]').val(vat);

    });
</script>