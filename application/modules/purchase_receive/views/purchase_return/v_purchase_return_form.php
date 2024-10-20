<style>
    .purs_table tbody tr td{
        border: none;
        vertical-align: center;
    }
</style>

<form method="post" id="FormIssueNew" action="<?php echo base_url('purchase_receive/purchase_return/save_purchase_return/direct'); ?>" data-reloadurl="<?php echo base_url('purchase_receive/purchase_return/form_purchase_return/direct');?>" class="form-material
    form-horizontal form">

    <!-- <input type="hidden" name="id" value="<?php echo !empty($new_issue[0]->sama_salemasterid)?$new_issue[0]->sama_salemasterid:'';  ?>"> -->

    <input type = "hidden" name="purchaseordermasterid" id="purchaseordermasterid" />
    <input type = "hidden" name="purchaseorderno" id="purchaseorderno" />
    <input type = "hidden" name="receivedmasterid" id="receivedmasterid" />

    <div id="issueDetails">

        <div class="form-group">
            <?php echo $this->general->location_option(2,'locationid');?>
            <?php
                if($purchase_type == 'direct'):
            ?>
            <div class="col-md-3 col-sm-4">
                <label for="example-text"><?php echo $this->lang->line('invoice_no'); ?> <span class="required">*</span>:</label>
                <input type="text" class="form-control required_field enterinput" name="invoiceno"  value="" placeholder="Enter Receipt No." id="invoiceno" data-targetbtn="btnSearchOrderno">
            </div>
            <?php
                else:
            ?>
            <div class="col-md-3 col-sm-4">
                <label for="example-text"><?php echo $this->lang->line('order_no'); ?> <span class="required">*</span>:</label>
                <input type="text" class="form-control required_field enterinput" name="orderno"  value="" placeholder="Enter Order No." id="orderno" data-targetbtn="btnSearchOrderno">
            </div>
            <?php endif; ?>
            
            <div class="col-md-2 col-sm-4">
                <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?> :</label>
                <select name="fyear" class="form-control" id="fyear">
                <?php
                    if($fiscal_year): 
                        foreach ($fiscal_year as $kf => $fyrs):
                ?>
                    <option value="<?php echo $fyrs->fiye_name; ?>" <?php if($fyrs->fiye_status=='I') echo "selected=selected"; ?> ><?php echo $fyrs->fiye_name; ?></option>
                <?php endforeach; endif; ?>
                </select>
            </div>
            
            <div class="col-md-3 col-sm-4">
                <label for="example-text"><?php echo $this->lang->line('store'); ?> <span class="required">*</span>:</label>
                <select name="storeid" id="storeid" class="form-control required_field select2 enterinput" data-targetbtn="btnSearchOrderno" >
                    <option value="">---All---</option>
                    <?php
                        if(!empty($store_type)):
                            foreach ($store_type as $km => $store):
                    ?>
                     <option value="<?php echo $store->eqty_equipmenttypeid; ?>"  <?php if($default_storeid==$store->eqty_equipmenttypeid) echo "selected=selected"; ?>><?php echo $store->eqty_equipmenttype; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </select>
            </div>
            
            <div class="col-md-2 col-sm-4">
                <label>&nbsp;</label>
                <div class="dis_tab">
                    <a href="javascript:void(0)" class="btn btn-sm btn-success" id="btnSearchOrderno" ><?php echo $this->lang->line('search'); ?></a>
                </div>
            </div>
        </div>
        <div class="clearfix"></div> 

        <div id="returnDetailForm" style="display: none;">
        
            <div class="form-group">
                <div class="col-md-3 col-sm-4">
                    <label for="example-text"><?php echo $this->lang->line('supplier_name'); ?> <span class="required">*</span>:</label>
                    <select name="supplierid" class="form-control required_field" readonly="readonly" id="supplierid" >
                        <option value="">---select---</option>
                        <?php
                            if($supplier_all):
                                foreach ($supplier_all as $km => $sup):
                        ?>
                        <option value="<?php echo $sup->dist_distributorid; ?>" ><?php echo $sup->dist_distributor; ?></option>
                        <?php
                                endforeach;
                            endif;
                        ?>
                    </select>
                </div>

                <div class="col-md-3 col-sm-4">
                    <label for="example-text"><?php echo $this->lang->line('receive_no'); ?>: </label>
                    <input type="text" class="form-control" name="receivedno" id="receivedno" readonly>
                </div>

                <div class="col-md-3 col-sm-4">
                    <label for="example-text"><?php echo $this->lang->line('received_date'); ?>  :</label>
                    <input type="text" class="form-control" name="received_date" value="<?php echo DISPLAY_DATE; ?>" placeholder="Received Date" id="received_date" readonly>
                </div>

                <div class="col-md-3 col-sm-4">
                    <label for="example-text"><?php echo $this->lang->line('received_by'); ?>: </label>
                    <input type="text" class="form-control" id="receivedby" name="receivedby" readonly>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-3 col-sm-4">
                    <label for="example-text"><?php echo $this->lang->line('return_no'); ?>: </label>
                    <input type="text" class="form-control" id="returnno" name="returnno" value="<?php echo $return_no; ?>" readonly>
                </div>

                <div class="col-md-3 col-sm-4">
                    <label for="example-text"><?php echo $this->lang->line('return_date'); ?>  :</label>
                    <input type="text" class="form-control <?php echo DATEPICKER_CLASS ; ?>" name="return_date" value="<?php echo DISPLAY_DATE; ?>" placeholder="Return Date" id="return_date">
                </div>

                <div class="col-md-3 col-sm-4">
                    <label for="example-text"><?php echo $this->lang->line('return_by'); ?>: </label>
                    <input type="text" class="form-control" name="returnby" id="returnby">
                </div>
            </div>    

            <div class="clearfix"></div> 

            <div class="form-group">
                <div class="table-responsive col-sm-12">
                    <table style="width:100%;" class="table purs_table dataTable">
                        <thead>
                            <tr>
                                <th width="2%"><?php echo $this->lang->line('sn'); ?></th>
                                <th width="2%"><?php echo $this->lang->line('item_code'); ?></th>
                                <th width="15%"><?php echo $this->lang->line('item_name'); ?></th>
                                <th width="5%"><?php echo $this->lang->line('unit'); ?></th>
                                <th width="5%"><?php echo $this->lang->line('rec_qty'); ?></th>
                                <th width="5%"><?php echo $this->lang->line('ret_qty'); ?></th>
                                <th width="5%"><?php echo $this->lang->line('rate'); ?></th>
                                <th width="5%"><?php echo $this->lang->line('cc'); ?></th>
                                <th width="5%"><?php echo $this->lang->line('dis'); ?></th>
                                <th width="5%"><?php echo $this->lang->line('vat'); ?></th>
                                <th width="8%"><?php echo $this->lang->line('amount'); ?></th>
                                <!-- <th width="7%">Exp. Date</th> -->
                                <th width="10%"><?php echo $this->lang->line('description'); ?></th>
                                <th width="5%"><?php echo $this->lang->line('action'); ?></th>
                            </tr>
                        </thead>
                        <tbody id="receivedOrderDataBody">
                        
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="roi_footer">
                <div class="row">
                    <div class="col-sm-4">
                        <div>
                            <label for=""><?php echo $this->lang->line('remarks'); ?> : </label>
                            <textarea name="remarks" class="form-control" rows="4" placeholder=""></textarea>
                        </div>
                    </div>
                    <div class="col-sm-6" style="float: right; margin-top: 25px;">
                        <fieldset class="pull-right mtop_10 pad-top-14">
                            <ul>
                                 <li>
                                    <label><?php echo $this->lang->line('sub_total'); ?></label>
                                    <input type="text" class="form-control float" name="subtotalamt" id="subtotalamt" value=""  readonly/>
                                </li>
                                <li>
                                    <label><?php echo $this->lang->line('discount'); ?></label>
                                    <input type="text" class="form-control float" name="discountamt" id="discountamt" value="0" readonly/>
                                </li>
                               
                                <li>
                                <label><?php echo $this->lang->line('tax'); ?></label>
                                <input type="text" class="form-control float" name="taxamt" id="taxamt" value=""  readonly/>

                                </li>
                                 <li>
                                    <label><?php echo $this->lang->line('grand_total'); ?> </label>
                                    <input type="text" class="form-control float" name="totalamount" id="totalamount" readonly/>
                                </li>

                              <!--   <li>
                                <label><?php echo $this->lang->line('extra'); ?></label>
                               <input type="text" class="form-control float extra" name="extra" id="extra" value="0" />
                           </li> -->
                         <!--   <li>
                                <label>RF</label>
                               <input type="text" class="form-control float" name="rf" id="rf" value="" />
                           </li> -->
                            <li>
                                <label><?php echo $this->lang->line('clearance_amt'); ?></label>
                                <input type="text" class="form-control extra" name="clearanceamt" id="clearanceamt" readonly>
                            </li>
                        </ul>
                        </fieldset>
                    </div>
                </div> 
            </div>               
    

            <div class="form-group">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($item_data)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($item_data)?'Update':'Save' ?></button>
                </div>
               
            </div>

        </div>
        <div class="form-group">
             <div class="col-sm-12">
                <div  class="alert-success success"></div>
                <div class="alert-danger error"></div>
            </div>
        </div>
</div>
    <div class="clearfix"></div> 
</form> 

<script type="text/javascript">
    $(document).off('click','#btnSearchOrderno');
    $(document).on('click','#btnSearchOrderno',function(){
    var orderno=$('#orderno').val();
    var invoiceno = $('#invoiceno').val();
    var storeid=$('#storeid').val();
    var fiscal_year=$('#fyear').val();
    var locationid=$('#locationid').val();
    // alert(orderno);
    // ajaxPostSubmit()

    if(invoiceno){
        var submitdata = {invoiceno:invoiceno,fiscal_year:fiscal_year,storeid:storeid,locationid:locationid};
        var submiturl = base_url+'purchase_receive/purchase_return/orderlist/invoiceno';
    }else{
        var submitdata = {orderno:orderno,fiscal_year:fiscal_year,storeid:storeid,locationid:locationid};
        var submiturl = base_url+'purchase_receive/purchase_return/orderlist';
    }
    beforeSend= $('.overlay').modal('show');

    ajaxPostSubmit(submiturl,submitdata,beforeSend='',onSuccess);
  
    function onSuccess(jsons){

        data = jQuery.parseJSON(jsons);
        // console.log(data.order_data);
        var orderdata=data.order_data;
       
        var defaultdatepicker='NP';

        if(orderdata)
        {
        var receiveddatead=orderdata[0].recm_receiveddatead;
        var receiveddatebs=orderdata[0].recm_receiveddatebs;
        var supplierid=orderdata[0].recm_supplierid;
        var receivedno = orderdata[0].recm_receivedno;
        var receivedby = orderdata[0].recm_postusername;

        var purchaseordermasterid = orderdata[0].recm_purchaseordermasterid;
        var purchaseorderno = orderdata[0].recm_purchaseorderno;

        var receivedmasterid = orderdata[0].recm_receivedmasterid;
            if(defaultdatepicker=='NP')
            {
                $('#received_date').val(receiveddatebs);
            }
            else{
                $('#received_date').val(receiveddatead);
            }
            $("#supplierid").val(supplierid).trigger('change.select2');

            $('#purchaseordermasterid').val(purchaseordermasterid);
            $('#purchaseorderno').val(purchaseorderno);

            $('#receivedby').val(receivedby);
            $('#receivedno').val(receivedno);
            $('#receivedmasterid').val(receivedmasterid);

        }
        // console.log(orderdata);
        if(data.status=='success')
        {
            $('#returnDetailForm').show();
            $('#supplierid').attr("style", "pointer-events: none;");
            $('#receivedOrderDataBody').html(data.tempform);
        }
        else
        {   
            alert(data.message); 
            // $('#received_date').val('');
            // $("#supplierid").select2("val", 0);
            $('#returnDetailForm').hide();
            $('#receivedOrderDataBody').html('');
        }
        $('.overlay').modal('hide');
    }

   })
</script>

<script type="text/javascript">
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
        var returnqty = $('#return_qty_'+id).val();
        var receivedqty=$('#received_qty_'+id).val();
        var rate = $('#sales_rate_'+id).val();

        var valid_receivedqty = parseFloat(checkValidValue(receivedqty));
        var valid_returnrqty = parseFloat(checkValidValue(returnqty));
        var valid_rate = parseFloat(checkValidValue(rate));

        if(valid_returnrqty > valid_receivedqty){
            alert('Sorry, you cannot exceed received quantity.');
            $('#return_qty_'+id).val(valid_receivedqty);
        }

        var cc = $('#cc_'+id).val();
        var valid_cc = parseFloat(checkValidValue(cc));

        var discount = $('#discount_'+id).val();
        var valid_discount = parseFloat(checkValidValue(discount));

        var vat =$('#vat_'+id).val();
        var valid_vat = parseFloat(checkValidValue(vat));

        var amount_vq = valid_returnrqty*valid_rate;

        if(amount_vq){
            $('#amt_'+id).val(amount_vq.toFixed(2)); 
        }else{
            $('#amt_'+id).val(0);
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

        $(".eachtotalamt").each(function() {
            stotal += parseFloat($(this).val());
        });

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

        var subtotal = stotal-stotoaldis;

        // var clearanceamt = subtotal+stotalvat+extra;
        var clearanceamt = stotal;

        // $('#amt_'+id).html(with_vat.toFixed(2));
        $('#vatamt_'+id).val(vatamt.toFixed(2));
        $('#disamt_'+id).val(disamt.toFixed(2));

        $('#taxamt').val(stotalvat.toFixed(2));
        $('#discountamt').val(stotoaldis.toFixed(2));
        $('#subtotalamt').val(subtotal.toFixed(2));
        $('#totalamount').val(stotal.toFixed(2));
        $('#clearanceamt').val(clearanceamt.toFixed(2));  
    });
</script>