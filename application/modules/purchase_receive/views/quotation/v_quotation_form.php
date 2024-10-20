<style>
    .purs_table tbody tr td{
    border: none;
    vertical-align: center;
    }
</style>
<?php
    if(DEFAULT_DATEPICKER == 'NP'){
        $quotation_date = !empty($quotation_data[0]->quma_quotationdatebs)?$quotation_data[0]->quma_quotationdatebs:'';
        $supplier_qdate = !empty($quotation_data[0]->quma_supplierquotationdatebs)?$quotation_data[0]->quma_supplierquotationdatebs:'';  
        $expdate = !empty($quotation_data[0]->quma_expdatebs)?$quotation_data[0]->quma_expdatebs:''; 
        $curdate = CURDATE_NP; 
    }else{
        $quotation_date = !empty($quotation_data[0]->quma_quotationdatead)?$quotation_data[0]->quma_quotationdatead:'';
        $supplier_qdate = !empty($quotation_data[0]->quma_supplierquotationdatead)?$quotation_data[0]->quma_supplierquotationdatead:'';
        $expdate = !empty($quotation_data[0]->quma_expdatead)?$quotation_data[0]->quma_expdatead:'';
        $curdate = CURDATE_EN;
    }
?>

<form method="post" id="formQuotataion" action="<?php echo base_url('purchase_receive/quotation/save_quotation'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('purchase_receive/quotation/form_quotation/'.$type); ?>' >
<input type="hidden" name="id" value="<?php echo!empty($quotation_data[0]->quma_quotationmasterid)?$quotation_data[0]->quma_quotationmasterid:'';  ?>">
<input type="hidden" name="type" value="<?php echo $type ?>">
<div class="form-group">
    <div class="col-md-3 col-sm-4">

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
          
     <div class="col-md-3 col-sm-4">
        <label for="example-text"><?php echo $this->lang->line('req_no'); ?><span class="required">*</span>: </label>

        <div class="dis_tab">
            <input type="text" name="req_no" class="form-control number enterinput required_field"  placeholder="Enter Requistion Number" value="" id="requisitionNumber" data-targetbtn="btnSearchReqno">
            
            <a href="javascript:void(0)" class="table-cell width_30 btn btn-success" id="btnSearchReqno"><i class="fa fa-search"></i></a>&nbsp;

            <a href="javascript:void(0)"  data-id="0" data-fyear="<?php echo CUR_FISCALYEAR;?>" data-displaydiv="Order" data-viewurl="<?php echo base_url() ?>purchase_receive/purchase_requisition/load_pur_reqisition_for_quotation" class="view table-cell width_30 btn btn-success" data-heading="<?php echo $this->lang->line('purchase_requisition_list')?>" id="orderLoad" ><i class="fa fa-upload"></i></a> 
        </div>
        <span class="errmsg"></span>
    </div>
</div>
<div class="form-group">
    <div class="col-md-3 col-sm-4">
        <label for="Supplier"><?php echo $this->lang->line('supplier_name'); ?> <span class="required">*</span>:</label>
        <div class="dis_tab">
        <?php
            $supplierid = !empty($quotation_data[0]->quma_supplierid)?$quotation_data[0]->quma_supplierid:'';
        ?>
        <select id="quma_supplierid" name="quma_supplierid" class="form-control required_field select2" >
            <option value="">---select---</option>
            <?php
                if($supplier_all):
                    foreach ($supplier_all as $ks => $supp):
                ?>
            <option value="<?php echo $supp->dist_distributorid; ?>" 
                <?php echo ($supplierid == $supp->dist_distributorid)?'selected="selected"':''; ?> 
                <?php echo in_array($supp->dist_distributorid,$quotation_supplier)?'disabled="disabled"':''; ?> >
                <?php echo $supp->dist_distributor; ?> 
            </option>
            <?php
                endforeach;
                endif;
                ?>
        </select>
           <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading='Supplier Entry' data-viewurl='<?php echo base_url('biomedical/distributors/supplier_entry/modal'); ?>'><i class="fa fa-plus"></i></a>
            </div>
    </div>
    <?php 
     if($type=='Q'){
        $date=$this->lang->line('quotation_date');
        $supplier=$this->lang->line('supplier_quotation_date');
        $no=$this->lang->line('quotation_no');
        $num=$this->lang->line('supplier_quotation_no');
    }else
    {
        $date=$this->lang->line('tender_date');
        $supplier=$this->lang->line('supplier_tender_date');
        $no=$this->lang->line('tender_no');
        $num=$this->lang->line('supplier_tender_no');
    }
    ?>
    <div class="col-md-3 col-sm-4">
        <label for="quma_quotationdate">
            <?php echo $date ?><span class="required">*</span>:
        </label>
        <input type="text" name="quma_quotationdate" class="form-control required_field <?php echo DATEPICKER_CLASS; ?> date" placeholder="Quotation Date" id="quma_quotationdate" value="<?php echo !empty($quotation_date)?$quotation_date:$curdate; ?>" readonly="true">
    </div>
    <div class="col-md-3 col-sm-4">
        <label for="quma_supplierquotationdate">
           <?php echo $supplier ?>:</label>
        <input type="text" name="quma_supplierquotationdate" class="form-control <?php echo DATEPICKER_CLASS; ?> date" placeholder="Supplier Quotation Date" id="quma_supplierquotationdate" value="<?php echo !empty($supplier_qdate)?$supplier_qdate:$curdate; ?>">
    </div>
    <div class="col-md-3 col-sm-4">
        <?php
             $quotationnumber = !empty($quotation_data[0]->quma_quotationnumber)?$quotation_data[0]->quma_quotationnumber:$quotationno;
       
        ?>
        <label for="quma_quotationnumber">
            <?php echo $no ?><span class="required">*</span>:</label>
        <input type="text" name="quma_quotationnumber" class="form-control number" placeholder="Quotation Number" id="quma_quotationnumber" value="<?php echo $quotationnumber; ?>" readonly />
    </div>
    <div class="col-md-3 col-sm-4">
        <?php
            $supplierquotationnumber = !empty($quotation_data[0]->quma_supplierquotationnumber)?$quotation_data[0]->quma_supplierquotationnumber:'';
        ?>
        <label for="quma_supplierquotationnumber">
           <?php echo $num ?>:</label>
        <input type="text" name="quma_supplierquotationnumber" class="form-control number" placeholder="Supplier Quotation Number" id="quma_supplierquotationnumber" value="<?php echo $supplierquotationnumber; ?>" />
    </div>
    <div class="col-md-3 col-sm-4">
        <label for="quma_expdate"><?php echo $this->lang->line('valid_till'); ?>:</label>

        <input type="text" name="quma_expdate" class="form-control <?php echo DATEPICKER_CLASS; ?> date" placeholder="Valid Till" id="quma_expdate"  value="<?php echo !empty($expdate)?$expdate:$valid_date; ?>" />
    </div>
     <div class="col-md-3 col-sm-4">
         <?php
            $remarks = !empty($quotation_data[0]->quma_remarks)?$quotation_data[0]->quma_remarks:'';
        ?>
        <label for="quma_remarks"><?php echo $this->lang->line('remarks'); ?>:</label>
        <input type="text" name="quma_remarks" class="form-control" placeholder="Remarks" id="quma_remarks" value="<?php echo $remarks;  ?>"  />
    </div>
    <div class="clearfix"></div>
</div>
<div class="form-group">
         <div class="table-responsive col-sm-12">
             <div class="pad-5" id="displayDetailList">
        <table style="width:100%;" class="table purs_table dataTable">
            <thead>
                <tr>
                    <th width="5%"> <?php echo $this->lang->line('sn'); ?> </th>
                    <th width="12%"> <?php echo $this->lang->line('item_code'); ?>  </th>
                    <th width="25%"> <?php echo $this->lang->line('item_name'); ?> </th>
                     <th width="10%"><?php echo $this->lang->line('qty'); ?></th>
                    <th width="10%"> <?php echo $this->lang->line('rate'); ?> </th>
                    <th width="10%"> <?php echo $this->lang->line('dis'); ?></th>
                    <th width="10%"> <?php echo $this->lang->line('dis_amt'); ?></th>
                    <th width="10%"> <?php echo $this->lang->line('vat'); ?></th>
                    <th width="10%"> <?php echo $this->lang->line('net_rate'); ?></th>
                    <th width="10%"> <?php echo $this->lang->line('action'); ?></th>
                </tr>
            </thead>
            <?php
                $i = 1; 
                if(!empty($quotation_items)){
            ?>
                <tbody id="purchaseBody">
            <?php
                    foreach($quotation_items as $items):  //echo"<pre>";print_r($quotation_items);die;
            ?>
                <tr class="directrow" id="directrow_<?php echo $i; ?>" data-id='<?php echo $i; ?>'>
                    <td>
                        <input type="text" class="form-control sno" id="s_no_<?php echo $i; ?>" value="<?php echo $i; ?>" readonly/>
                        
                         <input type="hidden" class="qude_quotationdetailid" name="qude_quotationdetailid[]" data-id='<?php echo $i; ?>' value="<?php echo $items->qude_quotationdetailid;?>" id="qude_quotationdetailid_<?php echo $i; ?>">
                    </td>
                    <td>
                        <div class="dis_tab"> 
                            <input type="text" class="form-control itemcode enterinput " id="itemcode_<?php echo $i; ?>" name="itemcode[]"  data-id='<?php echo $i; ?>' data-targetbtn='view' value="<?php echo $items->itli_itemcode;?>">
                            <input type="hidden" class="qude_itemsid" name="qude_itemsid[]" data-id='<?php echo $i; ?>' id="itemid_<?php echo $i; ?>"  value="<?php echo !empty($items->qude_itemsid)?$items->qude_itemsid:""?>">
                           <!--  <input type="hidden" class="itemsid" name="itemsid[]" data-id='<?php echo $i; ?>' value="" id="matdetailid_<?php echo $i; ?>"> -->
                              <input type="hidden" class="controlno" name="controlno[]" data-id='<?php echo $i; ?>' value="" id="controlno_<?php echo $i; ?>">
                            <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading='Item List' data-viewurl='<?php echo base_url('stock_inventory/item/list_item_normal'); ?>' data-id='<?php echo $i; ?>' id="view_<?php echo $i; ?>"><strong>...</strong></a>
                              &nbsp
                                 <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading='Item Entry' data-viewurl='<?php echo base_url('stock_inventory/item/item_entry/modal'); ?>'><i class="fa fa-plus"></i></a>
                        </div>
                    </td>
                    <td>  
                        <input type="text" class="form-control itemname" id="itemname_<?php echo $i; ?>" name="itemname[]"  data-id='<?php echo $i; ?>' value="<?php echo $items->itli_itemname;?>" placeholder="Item Name" readonly>
                    </td>
                    <td> 
                    <input type="text" class="form-control qty" id="itemqty_<?php echo $i; ?>" name="qude_qty[]"  data-id='<?php echo $i; ?>' value="<?php echo $items->qude_qty;?>" readonly="true">
                    </td>
                    <td> 
                        <input type="hidden" data-id='<?php echo $i; ?>' value="" id="discount_amt_<?php echo $i; ?>" class="discountamt" >
                            <input type="hidden" data-id='<?php echo $i; ?>' value="" id="tax_amt_<?php echo $i; ?>" class="taxamt" >

                        <input type="text" class="form-control float qude_rate calculateamt" name="qude_rate[]" value="<?php echo $items->qude_rate;?>" id="qude_rate_<?php echo $i; ?>" data-id='<?php echo $i; ?>' > 
                    </td>
                    <td> 
                        <input type="text" class="form-control float qude_discountpc calculateamt" name="qude_discountpc[]" value="<?php echo $items->qude_discountpc;?>"  id="qude_discountpc_<?php echo $i; ?>" data-id='<?php echo $i; ?>' value="0" /> 
                    </td>
                    <td> 
                        <input type="text" class="form-control float qude_discount_amt" name="qude_discount_amt[]" value=""  id="qude_discount_amt_<?php echo $i; ?>" data-id='<?php echo $i; ?>'  /> 
                    </td>
                    <td> 
                        <input type="text" class="form-control float calculateamt qude_vatpc common_vat" name="qude_vatpc[]"   id="qude_vatpc_<?php echo $i; ?>" value="<?php echo $items->qude_vatpc;?>" data-id='<?php echo $i; ?>' value="0" /> 
                    </td>
                    <td> 
                        <input type="text" class="form-control float totalamount qude_netrate" name="qude_netrate[]" value="<?php echo $items->qude_netrate;?>"  id="qude_netrate_<?php echo $i; ?>" data-id='<?php echo $i; ?>' /> 
                    </td>
                    <td>
                        <div class="actionDiv acDiv2"></div>
 
                </tr>
            <?php
                    $i++;
                    endforeach; 
            ?>
            <tbody>
                <tr><td colspan="12"> <a href="javascript:void(0)" class="btn btn-primary pull-right btnAdd" data-id="1"  id="addRequistion_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-plus" aria-hidden="true"></i></span></a></td></tr>
            </tbody> 
                </tbody>
            <?php
                }else{
            ?>
                <tbody id="purchaseBody">
                    <tr class="directrow" id="directrow_1" data-id='1'>
                        <td>
                            <input type="text" class="form-control sno" id="s_no_1" value="1" readonly/>
                        </td>
                        <td>
                            <div class="dis_tab"> 
                                <input type="text" class="form-control itemcode enterinput " id="itemcode_1" name="itemcode[]"  data-id='1' data-targetbtn='view'>
                                <input type="hidden" class="qude_itemsid" name="qude_itemsid[]" data-id='1' value="" id="itemid_1">
                                <input type="hidden" class="itemsid" name="itemsid[]" data-id='1' value="" id="matdetailid_1">
                                  <input type="hidden" class="controlno" name="controlno[]" data-id='1' value="" id="controlno_1">
                                <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading='Item List' data-viewurl='<?php echo base_url('stock_inventory/item/list_item_normal'); ?>' data-id='1' id="view_1"><strong>...</strong></a>
                                 &nbsp
                                <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading='Item Entry' data-viewurl='<?php echo base_url('stock_inventory/item/item_entry/modal'); ?>' data-id='1' id="view_1" data-storeid='<?php echo !empty($storeid)?$storeid:''; ?>' >+</a>
                            </div>
                        </td>
                        <td>  
                            <input type="text" class="form-control itemname" id="itemname_1" name="itemname[]"  data-id='1' placeholder="Item Name" readonly />
                        </td>
                        <td> 
                    <input type="text" class="form-control qty" id="itemqty_1" name="qude_qty[]"  data-id='1' value="1" readonly="true"> 
                    </td>
                        <td> 
                            <input type="hidden" data-id='1' value="" id="discount_amt_1" class="discountamt" >
                            <input type="hidden" data-id='1' value="" id="tax_amt_1" class="taxamt" >
                            <input type="text" class="form-control float qude_rate calculateamt" name="qude_rate[]"   id="qude_rate_1" data-id='1' > 
                        </td>
                        <td> 
                            <input type="text" class="form-control float qude_discountpc calculateamt qude_discountpc" name="qude_discountpc[]"   id="qude_discountpc_1" data-id='1' value="0" /> 

                        </td>
                        <td> 
                        <input type="text" class="form-control float qude_discount_amt qude_discount_amt" name="qude_discount_amt[]" value=""  id="qude_discount_amt_1" data-id='1' value="0" /> 
                    </td>
                        <td> 
                            <input type="text" class="form-control float calculateamt qude_vatpc common_vat" name="qude_vatpc[]"   id="qude_vatpc_1" data-id='1' value="0" /> 
                        </td>
                        <td> 
                            <input type="text" class="form-control float totalamount qude_netrate" name="qude_netrate[]"   id="qude_netrate_1" data-id='1' /> 
                        </td>
                        <td>
                            <div class="actionDiv acDiv2"></div>
                        </td>
                    </tr>
                <tbody>
                    <tr><td colspan="12"> <a href="javascript:void(0)" class="btn btn-primary pull-right btnAdd" data-id="1"  id="addRequistion_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-plus" aria-hidden="true"></i></span></a></td></tr>
                </tbody>  
                </tbody>
            <?php } ?>
        </table>
        </div>
        <table style="width:100%;" class="table purs_table dataTable">
            <tbody>
                 <tr class="table-footer">
                    <td colspan="7" width="80%">
                        <span style="float: right">
                        <label><?php echo $this->lang->line('sub_total'); ?></label>
                        </span>
                    </td>
                     <?php
                        $amount = !empty($quotation_data[0]->quma_amount)?$quotation_data[0]->quma_amount:'';
                    ?>
                    
                    <td colspan="2">
                        <input type="text" class="form-control float subtotal" name="quma_amount" id="subtotal" readonly="true" value="<?php echo $amount; ?>"/>
                    </td>

                </tr>
                 <tr class="table-footer">
                    <td colspan="7">
                        <span style="float: right">
                        <label><?php echo $this->lang->line('discount'); ?></label>
                        </span>
                    </td>
                     <?php
                        $discountamt = !empty($quotation_data[0]->quma_discount)?$quotation_data[0]->quma_discount:'';
                    ?>
                    <td colspan="2">
                        <input type="text" class="form-control float" name="quma_totaldiscount" id="totaldiscount" readonly="true" value="<?php echo $discountamt; ?>"/>
                    </td>

                </tr>

                <tr class="table-footer">
                    <td colspan="7">
                        <span style="float: right">
                        <label><?php echo $this->lang->line('tax'); ?></label>
                        </span>
                    </td>
                     <?php
                        $vatamount = !empty($quotation_data[0]->quma_vat)?$quotation_data[0]->quma_vat:'';
                    ?>
                    <td colspan="2">
                        <input type="text" class="form-control float" name="quma_totaltax" id="totaltax" readonly="true" value="<?php echo $vatamount; ?>"/>
                    </td>

                </tr>
                <tr class="table-footer">
                    <td colspan="7">
                        <span style="float: right">
                        <label><?php echo $this->lang->line('grand_total'); ?></label>
                        </span>
                    </td>
                    <?php
                        $totalamount = !empty($quotation_data[0]->quma_totalamount)?$quotation_data[0]->quma_totalamount:'';
                    ?>
                    <td colspan="2">
                        <input type="text" class="form-control float" name="quma_totalamount" id="grandtotal" readonly="true" value="<?php echo $totalamount; ?>"/>
                    </td>

                </tr>
            </tbody>
        </table>
    

   

    </div>
</div>
<div class="form-group">
    <?php //if(empty($quotation_data)):?>
    <div class="col-md-12">
        <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($quotation_data)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($quotation_data)?'Update':'Save' ?></button>
    </div>
    <?php //endif; ?>
    <div class="col-sm-12">
        <div  class="alert-success success"></div>
        <div class="alert-danger error"></div>
    </div>
</div>
<?php
    if($loadselect2=='yes'):
    ?>
<script type="text/javascript">
    $('.select2').select2();
</script>
<?php
    endif;
    ?>

    <script>
    $(document).ready(function(){
        
        var grandtotal = 0;
        var discounttotal = 0;
        var type = '';
        var discount = 0;
        var taxvalue =  0;
        var disamt = 0;
        var disper = 0;
        var vat = 0;
        var rate = 0;
    
        //calculate amount
        $(document).on('keyup change','.calculateamt',function(){
            // console.log('test');
            var subtotal=0;
            var stotal = 0;
            var stotaldis=0;
            var stotalvat=0;
            var netrate = 0;
            var disamt=0;
            var tax_amt=0;
            var trid=$(this).data('id');
            rate = $('#qude_rate_'+trid).val();
            discount = $('#qude_discountpc_'+trid).val();
            vat = $('#qude_vatpc_'+trid).val();
            var amtAfterDis = 0;    
            if(rate==''){
                rate=0;
            }
            else{
                rate = parseFloat(rate);
            }
    
            if(discount == ''){
                discount = 0;
                disamt=0;
            }else{
                discount = parseFloat(discount);
                disamt= rate*discount/100;

            }
    
            if(vat == ''){
                vat = 0;
                tax_amt=0;
            }else{
                vat = parseFloat(vat);
                tax_amt=rate*vat/100;
            }
    
            amtAfterDis = rate - ((discount / 100)*rate);
    
            if(amtAfterDis == '' || amtAfterDis == NaN){
                amtAfterDis = 0;
            }else{
                amtAfterDis = amtAfterDis;
            }
    
            amtAfterVat = amtAfterDis + ((vat / 100)*amtAfterDis);
    
            if(amtAfterVat == '' || amtAfterVat == NaN){
                amtAfterVat = 0;
            }else{
                amtAfterVat = amtAfterVat;
            }            
    
            netrate = amtAfterVat;
            
            $('#discount_amt_'+trid).val(disamt);
            $('#qude_discount_amt_'+trid).val(disamt);

            $('#tax_amt_'+trid).val(tax_amt);
            

            $('#qude_netrate_'+trid).val(netrate.toFixed(2));
            $(".qude_rate").each(function() {
             subtotal += parseFloat($(this).val());
            });

            $(".totalamount").each(function() {
                stotal += parseFloat($(this).val());
            });
            $(".discountamt").each(function() {
                        stotaldis += parseFloat($(this).val());
                    });
            $(".taxamt").each(function() {
                        stotalvat += parseFloat($(this).val());
                    });
 

            $('#subtotal').val(subtotal.toFixed(2));
            $('#grandtotal').val(stotal.toFixed(2));

            $('#totaldiscount').val(stotaldis);
            $('#totaltax').val(stotalvat);

            // console.log(stotal);
    
            // $('.calculateDiscount').change();
    
        });
    });
    
    // $(document).off('keyup change','.qude_discountpc');
    // $(document).on('keyup change','.qude_discountpc',function(e){
    //     var datid=$(this).data('id');

    //          // alert(datid);
    //     var cur_dis_pc=$(this).val();
    //     var cur_rate_val=$('#qude_rate_'+datid).val();
       
    //     // alert(cur_rate_val);
    //     var cur_dis_amt=cur_rate_val - ((cur_dis_pc/100)*cur_rate_val);
    //     console.log('dis_ami = '+cur_dis_amt);
    //     $('#qude_discount_amt'+datid).val(cur_dis_amt.toFixed(2));

    // });

    $(document).off('keyup change','.qude_discount_amt');
    $(document).on('keyup change','.qude_discount_amt',function(e){
        var datid=$(this).data('id');

             // alert(datid);
        var cur_dis_val=$(this).val();
        var cur_rate_val=$('#qude_rate_'+datid).val();
       
        // alert(cur_rate_val);
        var cur_dis_per=cur_dis_val*100/cur_rate_val;

        var valid_dis_per = checkValidValue(cur_dis_per);
        
        $('#qude_discountpc_'+datid).val(valid_dis_per.toFixed(2));

    });
</script>

<script type="text/javascript">
    $(document).off('click','.btnAdd');
    $(document).on('click','.btnAdd',function(){
        // alert('test');itemname_1
        var id=$(this).data('id');
        var trcount=  $('.directrow').length;
        var trplusOne=trcount+1
        var itemid=$('#itemname_'+trcount).val();
        var itemcode=$('#itemcode_'+trcount).val();
         //var itemname=$(this).data('itemname_display');
        
        var qty=$('#qude_rate_'+id).val();
        var rate=$('#rede_qty_'+id).val();
        if(itemid=='' || itemid==null )
            {
                $('#itemname_'+trcount).select2('open');
                $('#itemcode_'+trcount).focus();
                return false;
            }
      

        if(trplusOne==2)
        {

            $('.actionDiv').html('<a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="1"  id="addRequistion_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>');
        }
        var template='';
        template='<tr class="directrow" id="directrow_'+trplusOne+'" data-id="'+trplusOne+'"><td><input type="text" class="form-control sno" id="s_no_'+trplusOne+'" value="'+trplusOne+'" readonly/></td><td><div class="dis_tab"> <input type="text" class="form-control itemcode enterinput" id="itemcode_'+trplusOne+'" name="itemcode[]" data-id="'+trplusOne+'" data-targetbtn="view"> <input type="hidden" class="itemid" name="itemid[]" data-id="'+trplusOne+'"" value="" id="itemid_'+trplusOne+'"> <input type="hidden" class="qude_itemsid" name="qude_itemsid[]" data-id="'+trplusOne+'" value="" id="matdetailid_'+trplusOne+'"> <input type="hidden" class="controlno" name="controlno[]" data-id="'+trplusOne+'" value="" id="controlno_'+trplusOne+'"> <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading="Item List" data-viewurl="<?php echo base_url('stock_inventory/item/list_item_normal'); ?>" data-id="'+trplusOne+'" id="view_'+trplusOne+'"><strong>...</strong></a>&nbsp<a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading="Item Entry" data-viewurl="<?php echo base_url('stock_inventory/item/item_entry/modal'); ?>" data-id="'+trplusOne+'" id="view_'+trplusOne+'">+</a> </div></td><td> <input type="text" class="form-control itemname" id="itemname_'+trplusOne+'" name="itemname[]" data-id="'+trplusOne+'" placeholder="Item Name" readonly /> </td><td><input type="text" class="form-control qty" id="itemqty_'+trplusOne+'" name="qude_qty[]" readonly="true"  data-id='+trplusOne+' value="1"></td><td>  <input type="hidden" data-id='+trplusOne+' value="" id="discount_amt_'+trplusOne+'" class="discountamt" ><input type="hidden" data-id='+trplusOne+' value="" id="tax_amt_'+trplusOne+'" class="taxamt" ><input type="text" class="form-control float qude_rate calculateamt" name="qude_rate[]" id="qude_rate_'+trplusOne+'" data-id="'+trplusOne+'"></td><td><input type="text" class="form-control float qude_discountpc calculateamt qude_discountpc" name="qude_discountpc[]"  id="qude_discountpc_'+trplusOne+'" data-id="'+trplusOne+'" value="0" /></td> <td> <input type="text" class="form-control float qude_discount_amt " name="qude_discount_amt[]"   id="qude_discount_amt_'+trplusOne+'" data-id="'+trplusOne+'"  /></td><td> <input type="text" class="form-control float qude_vatpc calculateamt qude_vatpc" name="qude_vatpc[]"  id="qude_vatpc_'+trplusOne+'" data-id="'+trplusOne+'" value="0" /></td><td><input type="text" class="form-control float totalamount qude_netrate" name="qude_netrate[]" id="qude_netrate_'+trplusOne+'"></td><td> <div class="actionDiv"><a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="'+trplusOne+'"  id="addRequistion_'+trplusOne+'"><span class="btnChange" id="btnChange_'+trplusOne+'"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a></div></td></tr>';
            $('#purchaseBody').append(template);
        $('select.qude_itemsid').select2();
    });
    $(document).off('click','.btnRemove');
    $(document).on('click','.btnRemove',function(){
        var id=$(this).data('id');
         var whichtr = $(this).closest("tr");
         var conf = confirm('Are Your Want to Sure to remove?');
          if(conf)
          {
             var trplusOne = $('.directrow').length+1;
             // console.log(trplusOne);
             // $('#directrow_'+id).fadeOut(500, function(){ 
             // $('#directrow_'+id).remove();
             //  });
             whichtr.remove(); 
            //  for (var i = 0; i < trplusOne; i++) {
            //   $('#s_no_'+i).val(i);
            // }
            setTimeout(function(){
                  $(".directrow").each(function(i,k) {
                    var vali=i+1;
                    $(this).attr("id","directrow_"+vali);
                    $(this).attr("data-id",vali);    
                    $(this).find('.sno').attr("id","s_no_"+vali);
                    $(this).find('.sno').attr("value",vali);
                    $(this).find('.qude_itemscode').attr("id","qude_itemscode_"+vali);
                    $(this).find('.qude_itemscode').attr("value",vali);
                    $(this).find('.qude_itemsid').attr("id","qude_itemsid_"+vali);
                    $(this).find('.qude_rate').attr("id","qude_rate"+vali);
                    $(this).find('.qude_rate').attr("data-id",vali);
                    $(this).find('.qude_discountpc').attr("id","qude_discountpc_"+vali);
                    $(this).find('.qude_discountpc').attr("data-id",vali);
                    $(this).find('.qude_vatpc').attr("id","qude_vatpc_"+vali);
                    $(this).find('.qude_vatpc').attr("data-id",vali);
                    $(this).find('.qude_netrate').attr("id","qude_netrate_"+vali);
                    $(this).find('.qude_netrate').attr("data-id",vali);
                    $(this).find('.btnAdd').attr("id","addOrder_"+vali);
                    $(this).find('.btnAdd').attr("data-id",vali);
                    $(this).find('.btnRemove').attr("id","addOrder_"+vali);
                    $(this).find('.btnRemove').attr("data-id",vali);
                    $(this).find('.btnChange').attr("id","btnChange_"+vali);
            });
              },600);
          }
     });
    $(document).off('click','.itemDetail');
    $(document).on('click','.itemDetail',function(){
        var rowno=$(this).data('rowno');
        var rate=$(this).data('rate');
        var itemcode=$(this).data('itemcode');
        // var itemname=$(this).data('itemname');
         var itemname=$(this).data('itemname_display');

        var itemid=$(this).data('itemid');
     
        var matdetailid=$(this).data('mattransdetailid');
        var controlno=$(this).data('controlno');
        $('#itemcode_'+rowno).val(itemcode);
        $('#itemid_'+rowno).val(itemid);
        $('#matdetailid_'+rowno).val(itemid);
        $('#itemname_'+rowno).val(itemname);
        $('#qude_rate_'+rowno).val(rate);
        $('#qude_netrate_'+rowno).val(rate);
        $('#controlno_'+rowno).val(controlno);
        $('#myView').modal('hide');
        $('#dis_qty_'+rowno).focus();
        $('.calculateamt').change();
     })
</script>

<script type="text/javascript">
    $(document).on('keydown','.selected',function(){
        alert('test');
    })
</script>


<script type="text/javascript">
    function getDetailList(masterid, main_form=false){
        if(main_form == 'main_form'){
            var submiturl = base_url+'purchase_receive/purchase_requisition/load_detail_list_quot/new_detail_list';
            var displaydiv = '#displayDetailList'; 
        }else{
            var submiturl = base_url+'purchase_receive/purchase_requisition/load_detail_list_quot';
            var displaydiv = '#detailListBox';
        }
        // alert(displaydiv);
        // return false;
        
        $.ajax({
            type: "POST",
            url: submiturl,
            data: {masterid : masterid},
            beforeSend: function (){
                // $('.overlay').modal('show');
            },
            success: function(jsons){
                var data = jQuery.parseJSON(jsons);
                if(main_form == 'main_form'){
                    if(data.status == 'success'){
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
                        $('.calculateamt').change();
                    }
                    load_supplier_list();
                }else{
                    if(data.status == 'success'){
                        // console.log('test detail');
                        // return false;
                        $(displaydiv).empty().html(data.tempform);
                        $('.calculateamt').change();
                        // alert('test');
                        load_supplier_list();
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

    setInterval(blink_text, 3000);
</script>

<script>
    $(document).off('click','#btnSearchReqno');
    $(document).on('click','#btnSearchReqno',function(e){
        var requisitionno = $("#requisitionNumber").val();
        var fiscalyear = $("#fiscalyear").val();
        var action=base_url+'purchase_receive/purchase_requisition/load_detail_list_req';
        $.ajax({
            type: "POST",
            url: action,
            data:{requisitionno:requisitionno,fiscalyear:fiscalyear},
            dataType: 'html',
             beforeSend: function() {
              // $(this).prop('disabled',true);
              // $(this).html('Saving..');
              $('.overlay').modal('show');
            },
            success: function(jsons) 
            {
                data = jQuery.parseJSON(jsons);   
                // alert(data.status);
                // console.log(data);
                // return false;
                $('#displayDetailList').html('');
                if(data.status=='success')
                {
                  $('#displayDetailList').html(data.tempform);
                  var storeid=data.storeid;
                  
                  $('#item_type').select2('val',storeid);

                  load_supplier_list();
                  
                }
                if(data.status=='error')
                {
                    alert('Requisition Number Not Found');
                    $("#requisitionNumber").focus();
                    $('#displayDetailList').html('');

                    load_supplier_list();
                }
                $('.overlay').modal('hide');
            }
        });
    })
</script>

<script type="text/javascript">
    function load_supplier_list(){
        var requisitionno = $("#requisitionNumber").val();
        var fiscalyear = $("#fiscalyear").val();
        var action=base_url+'purchase_receive/quotation/load_supplier_list';
        $.ajax({
            type: "POST",
            url: action,
            data:{requisitionno:requisitionno,fiscalyear:fiscalyear},
            dataType: 'html',
             beforeSend: function() {
              // $(this).prop('disabled',true);
              // $(this).html('Saving..');
              // $('.overlay').modal('show');
            },
            success: function(jsons) 
            {
                data = jQuery.parseJSON(jsons);   
                // alert(data.status);
                // console.log(data);
                // return false;
                $('#quma_supplierid').html('');
                if(data.status=='success')
                {
                  $('#quma_supplierid').html(data.tempform);
                  var storeid=data.storeid;
                  
                  $('#item_type').select2('val',storeid);

                  
                }
                if(data.status=='error')
                {
                    alert('Requisition Number Not Found');
                    $("#requisitionNumber").focus();
                    $('#quma_supplierid').html('');
                }
                // $('.overlay').modal('hide');
            }
        });
    }
</script>

<script type="text/javascript">
    $(document).off('keyup change','.qude_vatpc');
    $(document).on('keyup change','.qude_vatpc',function(){
        var vatpc = $(this).val();
        $('[id^="qude_vatpc_"]').val(vatpc);
    });
</script>