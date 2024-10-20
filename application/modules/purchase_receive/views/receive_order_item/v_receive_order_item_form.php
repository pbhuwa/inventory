 <style>
        .purs_table tbody tr td{
            border: none;
            vertical-align: center;
        }
    </style>
<form method="post" id="FormReceiveOrderItem" action="<?php echo base_url('purchase_receive/receive_order_item/save_receive_order_item'); ?>" class="form-material form-horizontal form" >
    <div id="orderData">
        <?php $this->load->view('receive_order_item/v_receive_order_form');?>
    </div>
        <div class="form-group">
            <div class="table-responsive col-sm-12">
                <table style="width:100%;" class="table purs_table dataTable">
                    <thead>
                        <tr>
                        <th width="5%"> <?php echo $this->lang->line('sn'); ?> </th>
                        <th width="5%"><?php echo $this->lang->line('code'); ?> </th>
                        <th width="10%"> <?php echo $this->lang->line('batch_no'); ?> </th>
                        <th width="10%"> <?php echo $this->lang->line('select_product'); ?></th>
                        <th width="10%"> <?php echo $this->lang->line('unit'); ?> </th>
                        <th width="5%"> <?php echo $this->lang->line('qty'); ?> </th>
                        <th width="10%"> <?php echo $this->lang->line('unit_price'); ?> </th>
                        <th width="10%"> <?php echo $this->lang->line('select_tax'); ?> </th>
                        <th width="10%"> <?php echo $this->lang->line('total_amount'); ?> </th>
                        <th width="5%"> <?php echo $this->lang->line('free'); ?> </th>
                        <th width="10%"><?php echo $this->lang->line('valid_till'); ?></th>
                        <th width="10%"><?php echo $this->lang->line('description'); ?></th>
                        <th width="5%"> <?php echo $this->lang->line('action'); ?> </th>
                        </tr>
                    </thead>
                    <tbody id="purchaseDataBody">
                        <tr class="orderrow" id="orderrow_1" data-id='1'>
                            <td>
                                <input type="text" class="form-control" id="s_no_1" value="1" readonly/>
                            </td>
                            <td>
                                <input type="text" class="form-control multiInsert float puit_barcode" name="puit_barcode[]" id="puit_barcode_1" data-id="1">
                            </td>
                            <td>
                                <input type="text" class="form-control multiInsert float batch_no" name="batch_no[]" id="batch_no_1" data-id="1">
                            </td>
                            <td>
                                <!-- puit_productid -->
                                <select class="form-control multiInsert select2 " name="puit_productid[]" id="puit_productid_1" data-id="1">
                                    <option value="">---select---</option>
                                    <?php
                                    $productid = !empty($purchase_data[0]->puit_productid)?$purchase_data[0]->puit_productid:'';
                                    if(!empty($product_all)):
                                    foreach($product_all as $product):
                                    ?>
                                    <option value="<?php echo $product->prod_productid; ?>" <?php echo ($productid == $product->prod_productid)?'selected':'';?>><?php echo $product->prod_productname; ?></option>
                                    <?php
                                    endforeach;
                                    endif;
                                    ?>
                                </select>
                                <span class="productByCat"></span>
                            </td>
                            <td>
                                <select class="form-control multiInsert puit_unitid" name="puit_unitid[]" id="puit_unitid_1" data-id="1">
                                    <option value="">---select---</option>
                                    <?php
                                    $unitid = !empty($purchase_data[0]->puit_unitid)?$purchase_data[0]->puit_unitid:'';
                                   if(!empty($unit_all)):
                                    foreach($unit_all as $unit): 
                                    ?>
                                    <option value="<?php echo $unit->unit_unitid;?>"><?php echo $unit->unit_unitname; ?></option>
                                    <?php
                                    endforeach;
                                    endif;
                                    ?>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control multiInsert calculateamt puit_qty" name="puit_qty[]" id="puit_qty_1" data-id="1">
                            </td>
                            <td>
                                <input type="text" class="form-control puit_unitprice float multiInsert calculateamt puit_unitprice" name="puit_unitprice[]" id="puit_unitprice_1" data-id="1">
                            </td>
                            <td>
                                <select class="form-control multiInsert puit_taxid" name="puit_taxid[]" id="puit_taxid_1" data-id="1">
                                    <option value="">---select---</option>
                                    <?php
                                    $taxid = !empty($purchase_data[0]->puit_taxid)?$purchase_data[0]->puit_taxid:'';
                                    if(!empty($tax_all)):
                                    foreach($tax_all as $tax): ?>
                                    <option value="<?php echo $tax->tava_taxvalueid; ?>"><?php echo $tax->tava_taxvaluename.' ('.$tax->tava_taxvalue.' '.$tax->tava_taxvalueid.')'; ?></option>
                                    <?php
                                    endforeach;
                                   endif;
                                    ?>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control totalamount float multiInsert puit_total" name="puit_total[]" id="puit_total_1" data-id="1" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control   multiInsert " name="free[]" id="free_1" data-id="1">
                            </td>
                            <td>
                                <input type="text" name="end_date[]" class="form-control nepali <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Expire Date" value="" id="end_date_1" data-id="1">
                            </td>
                            <td>
                                <input type="text" class="form-control   multiInsert " name="description[]" id="description_1" data-id="1">
                            </td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-primary btnAdd1" id="addOrder_1" data-id="1"><span id="btnChange_1"><i class="fa fa-plus" aria-hidden="true"></i></span></a>
                            </td>
                        </tr>
                    </tbody>
                    <tbody>
                        <tr>
                            <td colspan="10">
                                <span style="float: right">
                                    <label><?php echo $this->lang->line('sub_total'); ?></label>
                                </span>
                            </td>
                            <td colspan="2">
                                <input type="text" class="form-control float subtotal" name="subtotal" id="subtotal" readonly="true" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="10">
                                <span style="float: right">
                                    <label><?php echo $this->lang->line('discount'); ?></label>
                                </span>
                            </td>
                            <td colspan="2">
                                <select id="discountType" name="discounttype" class="form-control discounttype">
                                    <option value="">---select---</option>
                                    <option value="per">In percentage</option>
                                    <option value="amt">In Amount</option>
                                </select>
                                <div id="discountTypeField" style="display: none; margin-top: 15px;">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control float discountper" name="discountper" id="discount"/><span id="lblper">%</span>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control float discountamt" name="discountamt" id="disamt" readonly="true" value="0" />
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="10">
                                <span style="float: right">
                                    <label><?php echo $this->lang->line('tax'); ?></label>
                                </span>
                            </td>
                            <td colspan="2">
                                <select class="form-control tax" name="tax" id="tax">
                                    <option value="">--select--</option>
                                    <option value="13">13%</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="10">
                                <span style="float: right">
                                    <label><?php echo $this->lang->line('total_amount'); ?></label>
                                </span>
                            </td>
                            <td colspan="2">
                                <input type="text" class="form-control" id="grandtotal" name="total" readonly="true"  />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($order_item_details)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($order_item_details)?'Update':'Save' ?></button>
            </div>
              <div class="col-sm-12">
                <div  class="alert-success success"></div>
                <div class="alert-danger error"></div>
              </div>
        </div>

<script type="text/javascript">
    $(document).on('keyup','#order_Number',function(){
        var order_no=$(this).val();
        $.ajax({
            type: "POST",
            timeout:3000,
            url: base_url+'purchase_receive/receive_order_item/order_lists',
            data: {order_no:order_no},
            dataType: 'html',
            success: function(jsons) 
            {
              console.log(jsons);
                data = jQuery.parseJSON(jsons);   
                //alert(data.status);
                if(data.status=='success')
                {
                    $('#orderData').html(data.template);
                }
            }
        });
    });
    $(document).off('click','.btnAdd1');
        $(document).on('click','.btnAdd1',function(){
        var productcontent=$('#puit_productid_1').html();
        var id = $(this).data('id');
        var barcode = $('#puit_barcode_'+id).val();
        var product = $('#puit_productid_'+id).val();
        var unit = $('#puit_unitid_'+id).val();
        var qty = $('#puit_qty_'+id).val();
        var rate = $('#puit_unitprice_'+id).val();
        var tax = $('#puit_taxid_'+id).val();


        if(product=='' || product==null )
        {
        $('#puit_productid_'+id).focus();
        return false;
        }
        if(qty=='' || qty==null )
        {
        $('#puit_qty_'+id).focus();
        return false;
        }
        if(rate=='' || rate==null )
        {
        $('#puit_unitprice_'+id).focus();
        return false;
        }
        var trplusOne = $('.orderrow').length+1;
        var templat='';
        templat='<tr class="orderrow" id="orderrow_'+trplusOne+'" data-id="'+trplusOne+'"><td><input type="text" class="form-control sno" id="s_no_'+trplusOne+'" value="'+trplusOne+'" readonly/></td><td><input type="text" class="form-control multiInsert float puit_barcode" name="puit_barcode[]" id="puit_barcode_'+trplusOne+'" data-id="'+trplusOne+'"></td><td><input type="text" class="form-control multiInsert float batch_no" name="batch_no[]" id="batch_no_'+trplusOne+'" data-id="'+trplusOne+'"></td><td><select name="puit_productid[]" class="form-control puit_productid" id="puit_productid_'+trplusOne+'" data-id="'+trplusOne+'>'+productcontent+'"> </select></td><td><select name="puit_unitid[]" class="form-control puit_unitid" id="puit_unitid_'+trplusOne+'" data-id='+trplusOne+'> <option value="">---Select---</option><?php if($unit_all):foreach ($unit_all as $key => $unit):?><option value="<?php echo $unit->unit_unitid; ?>" <?php if($unitid == $unit->unit_unitid) echo 'selected=selected'; ?>><?php echo $unit->unit_unitname; ?></option><?php endforeach; endif; ?></select></td><td><input type="text" class="form-control calculateamt puit_qty" name="puit_qty[]" id="puit_qty_'+trplusOne+'" data-id="'+trplusOne+'""></td><td><input type="text" class="form-control float calculateamt" name="puit_unitprice[]" id="puit_unitprice_'+trplusOne+'" data-id="'+trplusOne+'"></td><td><select name="puit_taxid[]" class="form-control puit_taxid" id="puit_taxid_'+trplusOne+'" > <option value="">---Select---</option><?php if($tax_all):foreach ($tax_all as $key => $tax):?><option value="<?php echo $tax->tava_taxvalueid; ?>"><?php echo $tax->tava_taxvaluename.'('.$tax->tava_taxvalue.' '.$tax->tava_taxunit.')'; ?></option><?php endforeach; endif; ?></select></td><td><input type="text" class="form-control totalamount float" name="puit_total[]" id="puit_total_'+trplusOne+'" data-id="'+trplusOne+'" readonly="true"> </td><td><input type="text" class="form-control   multiInsert " name="free[]" id="free_'+trplusOne+'" data-id="'+trplusOne+'"></td><td><input type="text" name="end_date" id="end_date_'+trplusOne+'" data-id="'+trplusOne+'" class="form-control nepali <?php echo DATEPICKER_CLASS; ?> date"  placeholder=" Expire Date" value="" id="ServiceEnd_'+trplusOne+'" data-id="'+trplusOne+'"></td> <td><input type="text" class="form-control   multiInsert " name="description[]" id="description_'+trplusOne+'" data-id="'+trplusOne+'"></td><td><a href="javascript:void(0)" class="btn btn-primary btnAdd1" data-id="'+trplusOne+'"  id="addOrder_'+trplusOne+'"><span id="btnChange_'+trplusOne+'"><i class="fa fa-plus" aria-hidden="true"></i></span></a></td></tr>';
        // console.log(templat);
        $('#addOrder_'+id).removeClass('btn btn-primary btnAdd1').addClass('btn btn-danger btnRemove');
        $('#btnChange_'+id).html('<i class="fa fa-trash-o" aria-hidden="true"></i>');
        $('#purchaseDataBody').append(templat);
        $('.btnTemp').hide();
        
        // getProductsByCategory();
        });
        //remove product rows
        $(document).off('click','.btnRemove');
        $(document).on('click','.btnRemove',function(){
        var id=$(this).data('id');
        var whichtr = $(this).closest("tr");
        
        var conf = confirm('Are Your Want to Sure to remove?');
        if(conf){
        $('#orderrow_'+id).fadeOut(1000, function(){
        $('#orderrow_'+id).remove();
        
        setTimeout(function(){
        $(".orderrow").each(function(i,k) {
        var vali=i+1;
        $(this).attr("id","orderrow_"+vali);
        $(this).attr("data-id",vali);
        $(this).find('.sno').attr("id","s_no_"+vali);
        $(this).find('.sno').attr("value",vali);
        $(this).find('.puit_barcode').attr("id","puit_barcode_"+vali);
        $(this).find('.puit_barcode').attr("data-id",vali);
        $(this).find('.puit_productid').attr("id","puit_productid_"+vali);
        $(this).find('.puit_productid').attr("data-id",vali);
        $(this).find('.puit_unitid').attr("id","puit_unitid_"+vali);
        $(this).find('.puit_unitid').attr("data-id",vali);
        $(this).find('.puit_qty').attr("id","puit_qty_"+vali);
        $(this).find('.puit_qty').attr("data-id",vali);
        $(this).find('.puit_unitprice').attr("id","puit_unitprice_"+vali);
        $(this).find('.puit_unitprice').attr("data-id",vali);
        $(this).find('.puit_taxid').attr("id","puit_taxid_"+vali);
        $(this).find('.puit_taxid').attr("data-id",vali);
        $(this).find('.totalamount').attr("id","totalamount_"+vali);
        $(this).find('.totalamount').attr("data-id",vali);
        $(this).find('.btnAdd').attr("id","addOrder_"+vali);
        $(this).find('.btnAdd').attr("data-id",vali);
        $(this).find('.btnChange').attr("id","btnChange_"+vali);
        });
        },1500);
        
        });
        }
        });
        </script>
        <script>
        $(document).ready(function(){
        var grandtotal = 0;
        var discounttotal = 0;
        var type = '';
        var discount = 0;
        var taxvalue =  0;
        
        //calculate amount
        $(document).on('keyup','.calculateamt', function(){
        var stotal=0;
        var trid=$(this).data('id');
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
        // $('#taxamt').val(0);
        });
        //discount type
        $(document).off('change', '#discountType');
        $(document).on('change', '#discountType', function(){
        var distype=$(this).val();
        // alert(distype);
        if(distype!='' || distype)
        {
        $('#discountTypeField').show();
        if(distype=='per')
        {
        $('#lblper').show();
        }
        else
        {
        $('#lblper').hide();
        }
        }
        else
        {
        $('#discountTypeField').hide();
        }
        
        // $('#discount').val(0);
        // $('#disamt').val(0);
        $('#discount').change();
        });
        //discount amount
        $(document).on('keyup change','#discount',function(){
        var distype=$('#discountType').val();
        var subtotal=$('#subtotal').val();
        var gtotal=0;
        if(subtotal!='' || subtotal!=NaN)
        {
        subtotal=subtotal;
        }
        else
        {
        subtotal=0;
        }
        var disval=$('#discount').val();
        if(disval!='' || disval!=NaN)
        {
        disval=disval;
        }
        else
        {
        disval=0;
        }
        var disamt=0;
        if(distype=='per')
        {
        disamt=(subtotal)*(disval)/100;
        }
        else
        {
        disamt=disval;
        }
        // alert(disval);
        gtotal=parseFloat(subtotal-disamt);
        
        $('#disamt').val(disamt);
        $('#grandtotal').val(gtotal);
        // $('#tax').val(0);
        $('#tax').change();
        });
        //calculate tax
        $(document).on('keyup change', '#tax', function(){
        var taxvalue    = $('#tax').val();
        var disamt      = $('#disamt').val();
        var subtotal    = $('#subtotal').val();
        var gtotal=0;
        var taxamt=0;
        // var damt=0;
        var taxval=0;
        if(taxvalue!='' && taxvalue!=NaN && taxvalue!=null )
        {
        taxval=taxvalue;
        }
        else
        {
        taxval=0.0;
        }
        // console.log('taxvalue'+taxval);
        // console.log('disamt'+disamt);
        
        // console.log('subtotal:'+subtotal);
        
        if(disamt!='' && disamt!=NaN && disamt!=null)
        {
        damt=parseFloat(disamt);
        }
        else
        {
        damt=0;
        }
        // var taxamt=0;
        
        if(subtotal!='' && subtotal!=NaN && subtotal!=null)
        {
        subtotal=parseFloat(subtotal);
        }
        else
        {
        subtotal=0;
        }
        // var gtotal=0;
        var subtotalwith_dmt=(subtotal)-(damt);
        
        if(subtotalwith_dmt!='' && subtotalwith_dmt!=NaN &&  subtotalwith_dmt!=null )
        {
        subtotalwith_dmt=subtotalwith_dmt;
        }
        else
        {
        subtotalwith_dmt=0;
        }
        // console.log('subtotalwith_dmt:'+subtotalwith_dmt);
        taxamt=parseFloat(subtotalwith_dmt)*(parseFloat(taxval)/100);
        // console.log('taxamt'+taxamt);
        if(taxamt !=NaN && taxamt!='' && taxamt!=null )
        {
        taxamt=taxamt;
        gtotal=parseFloat(taxamt)+parseFloat(subtotalwith_dmt);
        }
        else
        {
        taxamt=0;
        gtotal=subtotalwith_dmt;
        }
        // // console.log('Damt'+damt);
        // // console.log('subtotal'+subtotal);
        
        // console.log('Txt Amt:'+taxamt);
        
        $('#taxamt').val(taxamt.toFixed(2));
        $('#grandtotal').val(gtotal.toFixed(2));
        // // console.log('gtotal'+gtotal);
        });
        });
        </script>
        <script type="text/javascript">
            $(document).on('mouseover click','.nepali', function(){
                $('.nepali').nepaliDatePicker();
            });
        </script>
        <script>
        //get item list from quotation for order section
        // $(document).off('change','.getPurchaseData');
        // $(document).on('change','.getPurchaseData', function(){
        // var purchaseid = $(this).val();
        // var type = $(this).data('type');
        // var submiturl = $(this).data('url');
        // console.log(purchaseid);
        // console.log(type);
        // console.log(submiturl);
        // $.ajax({
        // type: "POST",
        // url: submiturl,
        // data: {purchaseid: purchaseid},
        // success: function(response){
        // var data=jQuery.parseJSON(response);
        // console.log(data);
        // console.log(data.supplierId);
        // $('.purchaseWrapper').find('.suppliername').val(data.supplierId).trigger('change.select2');
        // $('.purchaseWrapper').find('.category').val(data.categoryId).trigger('change.select2');
        // $('.purchaseWrapper').find('.fiscalyear').val(data.fiscalYear);
        // $('.purchaseWrapper').find('.purchase_quotation').val(data.purQuotationId).trigger('change.select2');
        // $('.purchaseWrapper').find('.purchase_order').val(data.purOrderId).trigger('change.select2');
        // $('.purchaseWrapper').find('.purchase_invoice').val(data.purInvoiceId).trigger('change.select2');
        // $('.purchaseWrapper').find('.validity').val(data.validity);
        // $('.purchaseWrapper').find('.deliveryDate').val(data.currentDate);
        // $('.purchaseWrapper').find('.subtotal').val(data.subtotal);
        // $('.purchaseWrapper').find('.discounttype').val(data.discounttype);
        // $('.purchaseWrapper').find('.discountamt').val(data.discountamt);
        // $('.purchaseWrapper').find('.discountper').val(data.discountper);
        // $('.purchaseWrapper').find('.tax').val(data.tax);
        // $('#purchaseDataBody').html(data.tempform);
        // $('.calculateamt').keyup();
        // }
        // });
        // });
//get item list selected category
        // $(document).off('change','.category');
        // $(document).on('change','.category',function(){
        // getProductsByCategory();
        // });
        // //change item list based on category
        // function getProductsByCategory(){
        // var base_url = "<?php echo base_url();?>";
        // var categoryid = $('.purchaseWrapper').find('.category').val();
        // // console.log(rowid);
        // var submiturl = base_url+'purchases/getProductsByCategory';
        // $.ajax({
        // type:"POST",
        // url: submiturl,
        // data: {categoryid:categoryid},
        // success: function(response){
        // var data = jQuery.parseJSON(response);
        // console.log(data.datas);
        // $('.puit_productid').html("");
        // $('.puit_productid').append('<option  value="">---select---</option>'+data.datas);
        // }
        // });
        // }
        // //change attributes of product
        // $(document).off('change','.puit_productid');
        // $(document).on('change','.puit_productid', function(){
        // var productid = $(this).val();
        // var rowid = $(this).data('id');
        // console.log(productid);
        // var submiturl = "<?php echo base_url('purchases/getProductInfo');?>";
        // $.ajax({
        // type:"POST",
        // url: submiturl,
        // data: {productid:productid},
        // success: function(response){
        // var data = jQuery.parseJSON(response);
        // console.log(data.barcode);
        // $('#puit_barcode_'+rowid).val(data.barcode);
        // $('#puit_unitprice_'+rowid).val(data.purchaserate);
        // $('#puit_unitid_'+rowid).val(data.unitid);
        // }
        // });
        // });
</script>