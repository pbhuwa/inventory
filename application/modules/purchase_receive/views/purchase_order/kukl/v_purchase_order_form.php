 <style>
    .purs_table tbody tr td{
        border: none;
        vertical-align: center;
    }
</style>
<div id="purchaseorderForm">
<form method="post" id="FormReceiveOrderItem" action="<?php echo base_url('purchase_receive/purchase_order/save_order_item'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('purchase_receive/purchase_order/form_purchase_order'); ?>'>
    <div id="orderData">

         <?php
          // $this->load->view('purchase_order/v_order_form');
            error_reporting(0);
            if(defined('PUR_OR_FORM_TYPE')):
                if(PUR_OR_FORM_TYPE == 'DEFAULT'){
                    $this->load->view('purchase_order/v_order_form');
                }else{
                    $this->load->view('purchase_order/'.REPORT_SUFFIX.'/v_order_form');
                }
            else:
                $this->load->view('purchase_order/v_order_form');
            endif;
           
        ?>
    </div>

    <div class="clearfix"></div> 
    
    <div class="form-group">
        <div class="pad-5" id="displayDetailList">
            <div class="table-responsive">
                <table style="width:100%;" class="table dataTable dt_alt purs_table">
                    <thead>
                        <tr>
                            <th width="2%"> <?php echo $this->lang->line('sn'); ?> </th>
                            <th width="10%"> <?php echo $this->lang->line('item_code'); ?></th>
                            <th width="25%"> <?php echo $this->lang->line('item_name'); ?></th>
                            <th width="5%"> <?php echo $this->lang->line('unit'); ?> </th>
                            <th width="5%"> <?php echo $this->lang->line('stock_quantity'); ?> </th>
                            <th width="5%"> <?php echo $this->lang->line('qty'); ?> </th> 
                            <th width="8%"> <?php echo $this->lang->line('unit_price'); ?> </th>
                            <th width="5%"><?php echo $this->lang->line('dis'); ?></th>
                            <th width="5%"> <?php echo $this->lang->line('select_vat'); ?> (%) </th>
                            <th width="10%"> <?php echo $this->lang->line('total_amount'); ?> </th>
                            <!-- <th width="5%"> Free </th> -->
                            <th width="10%"><?php echo $this->lang->line('tender_no'); ?></th>
                            <!-- <th width="8%">Dis (%)</th> -->
                            <th width="10%"><?php echo $this->lang->line('remarks'); ?></th>
                           <?php if(!empty($orderdetails)) { ?> <th width="5%"> <?php echo $this->lang->line('action'); ?> </th> <?php } ?>
                        </tr>
                    </thead>
                    <tbody id="purchaseDataBody" class="requisitionOrder">
                        <?php if(!empty($orderdetails)) { 
                            foreach ($orderdetails as $key => $ord) { ?>
                            <tr class="orderrow" id="orderrow_<?php echo $key+1; ?>" data-id='<?php echo $key+1; ?>'>
                                <td>
                                    <input type="text" class="form-control s_no" id="s_no_<?php echo $key+1; ?>" value="<?php echo $key+1; ?>" readonly/>
                                </td>
                                <td>
                                    <input type="text" class="form-control itemscode" id="itemscode_<?php echo $key+1; ?>"  data-id='<?php echo $key+1; ?>' value="<?php echo $ord->itli_itemcode; ?>" readonly />
                                </td>
                                <td>
                                    <div class="dis_tab"> 

                                        <input type="text" class="form-control itemname enterinput " id="itemname_<?php echo $key+1; ?>" name="itemname[]"  data-id='<?php echo $key+1; ?>' data-targetbtn='view' value="<?php echo $ord->itli_itemname; ?>" readonly />

                                        <input type="hidden" class="qude_itemsid" name="qude_itemsid[]" data-id='<?php echo $key+1; ?>' id="qude_itemsid_<?php echo $key+1; ?>" value="<?php echo $ord->pude_itemsid; ?>">
                                        
                                        <input type="hidden" class="purd_reqdetid" name="purd_reqdetid[]" data-id='<?php echo $key+1; ?>' value="<?php echo $ord->pude_puordeid; ?>" id="purd_reqdetid_<?php echo $key+1; ?>">

                                       <!--  <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading='Item List' data-viewurl='<?php echo base_url('stock_inventory/item/list_item_with_stock_requisition'); ?>' data-id='<?php echo $key+1; ?>' id="view_<?php echo $key+1; ?>"><strong>...</strong></a> -->
                                    </div>
                                </td>
                                <td>  
                                    <input type="text" class="form-control puit_unitid" id="puit_unitid_<?php echo $key+1; ?>" name="puit_unitid[]"  data-id='<?php echo $key+1; ?>' value="<?php echo $ord->pude_unit; ?>" readonly="readonly" />
                                </td>
                              <!--   <?php// $tot = ($ord->purd_remqty) * ($ord->itli_salesrate); ?> -->
                                <td>
                                    <input type="text" class="form-control multiInsert float stock_qty" name="stock_qty[]" id="stock_qty_<?php echo $key+1; ?>" data-id="<?php echo $key+1; ?>" placeholder="Stock Qty" readonly="true" value="<?php echo sprintf('%g',$ord->pude_stockqty);  ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control multiInsert float calculateamt puit_qty required_field" name="puit_qty[]" id="puit_qty_<?php echo $key+1; ?>" data-id="<?php echo $key+1; ?>" value="<?php echo sprintf('%g',$ord->pude_quantity);  ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control puit_unitprice float multiInsert calculateamt puit_unitprice" name="puit_unitprice[]" id="puit_unitprice_<?php echo $key+1; ?>" data-id="<?php echo $key+1; ?>"  value="<?php echo $ord->pude_rate; ?>">
                                </td>
                                <td>
                                    <input type="text" name="discountpc[]" class="form-control float calculateamt"  placeholder="Discount Pc" id="discountpc_<?php echo $key+1; ?>" data-id="<?php echo $key+1; ?>" value="<?php echo !empty($ord->pude_discount)?$ord->pude_discount:'0' ; ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control float multiInsert calculateamt puit_taxid vatpc arrow_keypress" data-fieldid="puit_taxid"  name="puit_taxid[]" id="puit_taxid_<?php echo $key+1; ?>" value="<?php echo  !empty($ord->pude_vat)? sprintf('%g',$ord->pude_vat):'0' ; ?>" data-id="<?php echo $key+1; ?>" >
                                </td>
                                <td>
                                    <input type="text" class="form-control totalamount float multiInsert puit_total calculateamt" name="puit_total[]" id="puit_total_<?php echo $key+1; ?>" value="<?php echo $ord->pude_amount; ?>" data-id="<?php echo $key+1; ?>" readonly>
                                </td>
                                <!--<td>
                                    <input type="text" class="form-control   multiInsert " name="free[]" id="free_<?php echo $key+1; ?>" data-id="<?php echo $key+1; ?>" value="<?php echo $ord->pude_free; ?>" >
                                </td> -->
                                <td>
                                    <input type="text" name="tender_no[]" class="form-control float"  placeholder="Tender Number"  id="tender_no_<?php echo $key+1; ?>" data-id="<?php echo $key+1; ?>"  value="<?php echo $ord->pude_tenderno; ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control multiInsert jump_to_add" name="description[]" id="description_<?php echo $key+1; ?>" data-id="<?php echo $key+1; ?>" placeholder="Remarks" value="<?php echo $ord->pude_remarks; ?>">
                                </td>
                                 <td>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger btnRemove" id="btnRemove_<?php echo $key+1; ?>" data-id='<?php echo $key+1; ?>'>
                                        <i class="fa fa-remove"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } }else{ ?>
                         <!-- <tr class="orderrow " id="orderrow_1" data-id='1'>
                           <td>
                                <input type="text" class="form-control" id="s_no_1" value="1" readonly/ disabled>
                            </td>
                            <td>
                            <div class="dis_tab"> 
                                <input type="text" class="form-control itemcode enterinput " id="itemcode_1" name="itemcode[]"  data-id='1' data-targetbtn='view'>
                                <input type="hidden" class="qude_itemsid" name="qude_itemsid[]" data-id='1' value="" id="qude_itemsid_1">
                                <input type="hidden" class="itemsid" name="itemsid[]" data-id='1' value="" id="matdetailid_1">
                                  <input type="hidden" class="controlno" name="controlno[]" data-id='1' value="" id="controlno_1">
                                <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading='Item List' data-viewurl='<?php echo base_url('stock_inventory/item/list_item_with_stock_transfer'); ?>' data-id='1' id="view_1"><strong>...</strong></a>
                            </div>
                        </td>
                        <td>  
                            <input type="text" class="form-control puit_unitid" id="puit_unitid_1" name="puit_unitid[]"  data-id='1'>
                        </td>
                            <td>
                                <input type="text" class="form-control multiInsert float stock_qty" name="stock_qty[]" id="stock_qty_1" data-id="1" placeholder="Stock Qty" readonly="true">
                            </td>
                            <td>
                                <input type="text" class="form-control multiInsert float calculateamt puit_qty" name="puit_qty[]" id="puit_qty_1" data-id="1">
                            </td>
                            <td>
                                <input type="text" class="form-control puit_unitprice float multiInsert calculateamt puit_unitprice" name="puit_unitprice[]" id="puit_unitprice_1" data-id="1">
                            </td>
                            <td>
                                <input type="text" class="form-control float multiInsert" name="puit_taxid[]" id="puit_taxid_1" data-id="1">
                            </td>
                            <td>
                                <input type="text" class="form-control totalamount float multiInsert puit_total" name="puit_total[]" id="puit_total_1" data-id="1" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control   multiInsert " name="free[]" id="free_1" data-id="1">
                            </td>
                             <td>
                                <input type="text" name="tender_no[]" class="form-control float"  placeholder="Tender Number" value="" id="tender_no_1" data-id="1">
                            </td>
                            <td>
                                <input type="text" name="discountpc[]" class="form-control float"  placeholder="Discount Pc" value="" id="discountpc_1" data-id="1">
                            </td>
                            <td>
                                <input type="text" class="form-control   multiInsert " name="description[]" id="description_1" data-id="1" placeholder="Remarks">
                            </td>
                            <td>
                                <div class="actionDiv acDiv2"></div>
                            </td></tr> -->
                        
                        <?php } ?>
                    </tbody>
                    <tbody>
                       <tr>
                            <td colspan="12">
                                <?php if (ORGANIZATION_NAME !== 'KUKL'):?>
                                <a href="javascript:void(0)" class="btn btn-primary btn-sm btnAdd pull-right" data-id="1"  id="addOrder_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-plus" aria-hidden="true"></i></span></a>
                            <?php endif; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="roi_footer">
            <div class="row">
                <div class="col-sm-4">
                    <!-- <div class="form-group">
                        <div class="col-sm-12">
                            <div class="dis_tab">
                                <label class="pr-10 table-cell width_100"><?php echo $this->lang->line('bill_amount'); ?> </label>
                                <input type="text" class="form-control" value="" name="billamount" placeholder="Enter Bill Amount">
                            </div>
                        </div>
                    </div> -->

                    <div class="form-group">
                        <div class="col-sm-6">
                            <div class="dis_tab">
                                <label class="pr-10 table-cell width_100"><?php echo $this->lang->line('payment_days'); ?>:</label>
                                <input type="text" class="form-control" value="15" name="paymentdays">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="dis_tab">
                                <label class="pr-10 table-cell width_100"><?php echo $this->lang->line('currency'); ?>:</label>
                                <input type="text" class="form-control" value="NRS" name="currencysymbol">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-sm-6">
                            <div class="dis_tab">
                                <label class="pr-10 table-cell width_100"><?php echo $this->lang->line('delivery_days'); ?>:</label>
                                <input type="text" class="form-control number" value="7" name="delivery_day" id="delivery_day">
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="dis_tab">
                                <label class="pr-10 table-cell width_100">1 <?php echo $this->lang->line('unit'); ?> =  <?php echo $this->lang->line('rs'); ?> :</label>
                                <input type="text" class="form-control" value="1" name="units">
                            </div>
                        </div>
                    </div>
                    
                    <div class="dis_tab">
                        <label class="pr-10 table-cell width_100"><?php echo $this->lang->line('approved_by'); ?>:</label>
                        <!--  <select class="table-cell form-control" name="approvedby">
                            <?php $approvedby=!empty($order_details[0]->puor_approvedby)?$order_details[0]->puor_approvedby:''; ?>
                            <option value="">--- Select ---</option>
                            <option value="director" <?php //if($approvedby == 'director')echo "selected=selected"; ?>>Director</option>
                        </select> -->

                        <select class="table-cell form-control" name="approvedby" id="approvedid">
                            <?php $approvedby=!empty($order_details[0]->puor_approvedby)?$order_details[0]->puor_approvedby:''; ?>
                            <option value="0">----select---</option>
                            <?php 
                                if(!empty($approved_data)):
                                    foreach ($approved_data as $key => $appro):
                                        $approved_id = !empty($appro->appr_approvedid)?$appro->appr_approvedid:'';
                                        $approved_name = !empty($appro->appr_approvedname)?$appro->appr_approvedname:'';
                            ?>
                                <option value="<?php echo $approved_id; ?>" <?php if($approvedby == $approved_id) echo 'selected=selected'; ?>><?php echo $approved_name; ?></option>
                            <?php 
                                    endforeach; 
                                endif; 
                            ?>
                        </select>
                        <!--     <a href="javascript:void(0)" class="table-cell width_30 text-center"><i class="fa fa-plus"></i></a> -->
                        <a href="javascript:void(0)" data-displaydiv="approved" class="btn btn-sm dis_table_cell width_30 btn-default table-cell width_30 view" data-heading='Add Approver' data-viewurl='<?php echo base_url('stock_inventory/approved/form_approved_popup'); ?>' data-id=''><i class="fa fa-plus"></i></a>
                        <a href="javascript:void(0)" class="table-cell btnappprovedref btn btn-sm btn-success dis_table_cell width_30 " ><i class="fa fa-refresh"></i></a>
                    </div>
                    <br>
                    <div class="dis_tab">
                        <label class="table-cell vt width_75"><?php echo $this->lang->line('remarks'); ?></label>
                        <?php $finalremarks=!empty($order_details[0]->puor_remarks)?$order_details[0]->puor_remarks:''; ?>
                        <textarea name="paymentremarks" id="" cols="30" rows="2" class="form-control table-cell vt"><?php echo $finalremarks;  ?></textarea>
                    </div>
                    
                    <div class="clearfix"></div>
                           <!--  <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="dis_tab">
                                        <label class="pr-10 table-cell width_100">View | Add terms and Conditions :</label>
                                        <a href="javascript:void(0)" class="table-cell width_30 text-center addTermsAndConditions"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div> -->
                </div>
                
                <div class="col-sm-6 pull-right">
                    <fieldset class="pull-right bordered mh_init">
                        <ul>
                            <!--       
                                <li>
                                    <label><?php echo $this->lang->line('discount_percentage'); ?></label>
                                    <input type="text" class="form-control float calculateDiscount" name="puin_discountper" id="dis_per" value="0" data-discount="per"/>
                                </li> 
                            -->
                            <li>
                                <label><?php echo $this->lang->line('amount'); ?></label>
                                    
                                  <?php $subtotal=!empty($order_details[0]->puor_amount)?$order_details[0]->puor_amount:'0'; ?>   
                                <input type="text" class="form-control float total_amount_wo_taxdis" name="total_amount_wo_taxdis" id="total_amount_wo_taxdis" readonly="true" / value="<?php echo !empty($subtotal)?$subtotal:'0'; ?>" >
                            </li>
                                   
                            <li>
                                <label><?php echo $this->lang->line('discount_in_amount'); ?></label>

                                <?php $puordiscount=!empty($order_details[0]->puor_discount)?$order_details[0]->puor_discount:'0'; ?>
                                <input type="text" class="form-control float calculateDiscount" name="puin_discountamt" id="dis_amt" value="<?php echo !empty($puordiscount)?$puordiscount:'0'; ?>" data-discount="amt" readonly="true"/ >
                            </li>

                            <li>
                                <label>
                                    <?php echo !empty($this->lang->line('overall_discount'))?$this->lang->line('overall_discount'):'Overall Discount'; ?>
                                </label>

                                <?php $overall_discount=!empty($order_details[0]->puor_discount)?$order_details[0]->puor_discount:'0'; ?>
                                <input type="text" class="form-control float" name="puin_discountamt" id="overall_discount" value="<?php echo !empty($overall_discount)?$overall_discount:'0'; ?>" data-discount="amt" / >
                            </li>

                            <li>
                                <label><?php echo $this->lang->line('sub_total'); ?></label>
                                    
                                  <?php $subtotal=!empty($order_details[0]->puor_amount)?$order_details[0]->puor_amount:'0'; ?>   
                                <input type="text" class="form-control float subtotal" name="subtotal" id="subtotal" readonly="true" / value="<?php echo !empty($subtotal)?$subtotal:'0'; ?>" >
                            </li>

                            <li>
                                <label><?php echo $this->lang->line('tax_amount'); ?></label>

                                <?php $puortaxtamount=!empty($order_details[0]->puor_vatamount)?$order_details[0]->puor_vatamount:'0'; ?>
                                <input type="text" class="form-control float taxtamount" name="taxtamount" id="taxtamount"  value="<?php echo !empty($puortaxtamount)?$puortaxtamount:'0'; ?>" readonly="true"/>
                            </li>

                            <li>
                                <label><?php echo $this->lang->line('extra_charge'); ?></label>

                                <?php $puorextraamount=!empty($order_details[0]->puor_extraamount)?$order_details[0]->puor_extraamount:'0'; ?>
                                <input type="text" class="form-control float extraamount" name="extraamount" id="extraamount" value="<?php echo !empty($puorextraamount)?$puorextraamount:'0'; ?>" readonly="true"/>
                            </li>

                            <li>
                                <label><?php echo $this->lang->line('total_amount'); ?></label>

                                <?php 
                                    $puoramount=!empty($order_details[0]->puor_amount)?$order_details[0]->puor_amount:'0'; ?>
                                <input type="text" class="form-control" id="grandtotal" name="totalamount" readonly="true"  value="<?php echo !empty($puoramount)?$puoramount:'0'; ?>" />
                            </li>
                        </ul>
                    </fieldset>
                    
                    <fieldset class="pull-right bordered mh_init">
                        <ul>        
                            <!--     <li>
                                    <label> <?php echo $this->lang->line('tax_in_percentage'); ?>(%)</label>

                                    <input type="text" class="form-control float taxamount" name="taxamount" id="taxamount" value="0"/>
                                </li> -->
                            <li>
                                <label><?php echo $this->lang->line('carriage_freight'); ?></label>

                                 <?php $pcarriagefreight=!empty($order_details[0]->puor_carriagefreight)?$order_details[0]->puor_carriagefreight:'0'; ?>
                                <input type="text" class="form-control float freight calculateextra" name="freight" id="freight" value="<?php echo !empty($pcarriagefreight)?$pcarriagefreight:'0'; ?>"/>
                            </li>
                                    
                            <li>
                                <label><?php echo $this->lang->line('other'); ?></label>

                                <?php $puorother=!empty($order_details[0]->puor_other)?$order_details[0]->puor_other:'0'; ?>
                                <input type="text" class="form-control float other calculateextra" name="other" id="other"  value="<?php echo !empty($puorother)?$puorother:'0'; ?>"/>
                            </li>

                            <li>
                                <label> <?php echo $this->lang->line('transport_courier'); ?></label>

                                <?php $transportcourier=!empty($order_details[0]->puor_transport_courier)?$order_details[0]->puor_transport_courier:'0'; ?>
                                <input type="text" class="form-control float transport calculateextra" name="transport" id="transport" value="<?php echo !empty($transportcourier)?$transportcourier:'0'; ?>" />
                            </li>
                            <li>
                                <label><?php echo $this->lang->line('packing'); ?></label>

                                <?php $puorpacking=!empty($order_details[0]->puor_packing)?$order_details[0]->puor_packing:'0'; ?>
                                <input type="text" class="form-control float packing calculateextra" name="packing" id="packing" value="<?php echo !empty($puorpacking)?$puorpacking:'0'; ?>" />
                            </li>
                            <li>
                                <label><?php echo $this->lang->line('insurance'); ?></label>

                                <?php $puorinsurance=!empty($order_details[0]->puor_insurance)?$order_details[0]->puor_insurance:'0'; ?>
                                <input type="text" class="form-control float insurance calculateextra" name="insurance" id="insurance" value="<?php echo !empty($puorinsurance)?$puorinsurance:'0'; ?>"/>
                            </li>
                           
                            <!-- <li>
                                <label><?php echo $this->lang->line('net_amount'); ?></label>
                                <?php $puorextraamount=!empty($order_details[0]->puor_extraamount)?$order_details[0]->puor_extraamount:'0'; ?>
                                <input type="text" class="form-control float netamount" name="netamount" id="netamount" value="<?php echo !empty($puorextraamount)?$puorextraamount:'0'; ?>" />
                            </li> -->
                        </ul>
                    </fieldset>
                </div>
            </div> 
        </div>
    </div>
       
    <div class="form-group">
        <div class="col-md-12"> 
            <?php //if($order_details){ //}else{ ?>
            <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($orderdetails)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($orderdetails)?'Update':'Save' ?></button>
             <button type="submit" class="btn btn-info savePrint" data-operation='<?php echo !empty($requisition_approved)?'update':'save ' ?>' id="btnSubmit" data-print="print"><?php echo !empty($orderdetails)?'Update & Print':'Save & Print' ?></button>
            <?php //} ?>
        </div>
        <div class="col-sm-12">
            <div  class="alert-success success"></div>
            <div class="alert-danger error"></div>
          </div>
    </div>
</form>
</div>

<div id="Printable" class="print_report_section printTable"></div>

<script type="text/javascript">
    $(document).off('click','.btnAdd');
    $(document).on('click','.btnAdd',function(){

        var productcontent=$('#puit_productid_1').html();
        var id = $(this).data('id');
        var barcode = $('#puit_barcode_'+id).val();
        var product = $('#qude_itemsid_'+id).val();
        var unit = $('#puit_unitid_'+id).val();
        var qty = $('#puit_qty_'+id).val();
        var rate = $('#puit_unitprice_'+id).val();
        var tax = $('#puit_taxid_'+id).val();
        var trplusOne = $('.orderrow').length+1;
        var trpluOne = $('.orderrow').length;
         var newitemid=$('#qude_itemsid_'+trpluOne).val();
        // console.log('p'+product);

        // if(product=='' || product==null )
        // {
        //     // $('#qude_itemsid_'+id).select2('open');
        //     $('#itemname_'+id).focus();
        //     return false;
        // }
         if(newitemid=='')
        {
            $('#itemname_'+trpluOne).focus();
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
       
       // alert(product);
        var trplusOne = $('.orderrow').length+1;
        if(trplusOne==2)
        {
            $('.actionDiv').html('<a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="1"  id="addRequistion_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>');
        }
        var templat='';
        templat='<tr class="orderrow" id="orderrow_'+trplusOne+'" data-id="'+trplusOne+'"> <input type="hidden" class="purd_reqdetid" name="purd_reqdetid[]" data-id='+trplusOne+' value="" id="purd_reqdetid_'+trplusOne+'"> <td><input type="text" class="form-control s_no" id="s_no_'+trplusOne+'" value="'+trplusOne+'" readonly/ disabled></td><td><input type="text" class="form-control itemscode enterinput " id="itemscode_'+trplusOne+'"  data-id="'+trplusOne+'" ></td><td> <div class="dis_tab"> <input type="text" class="form-control itemname enterinput " id="itemname_'+trplusOne+'" name="itemname[]" data-id="'+trplusOne+'" data-targetbtn="view" readonly /> <input type="hidden" class="qude_itemsid" name="qude_itemsid[]" data-id="'+trplusOne+'" value="" id="qude_itemsid_'+trplusOne+'"> <input type="hidden" class="itemsid" name="itemsid[]" data-id="'+trplusOne+'" value="" id="itemsid_'+trplusOne+'"> <input type="hidden" class="controlno" name="controlno[]" data-id="'+trplusOne+'" value="" id="controlno_'+trplusOne+'"> <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading="Item List" data-viewurl="<?php echo base_url('stock_inventory/item/list_item_with_stock_requisition '); ?>" data-id="'+trplusOne+'" id="view_'+trplusOne+'"><strong>...</strong></a> &nbsp; <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading="Item Entry" data-viewurl="'+base_url+'/stock_inventory/item/item_entry/modal" data-id="'+trplusOne+'" id="view_'+trplusOne+'">+</a> </div></td><td> <input type="text" class="form-control puit_unitid" id="puit_unitid_'+trplusOne+'" name="puit_unitid[]" data-id="'+trplusOne+'"></td><td><input type="text" class="form-control multiInsert float stock_qty" name="stock_qty[]" id="stock_qty_'+trplusOne+'" data-id="'+trplusOne+'" readonly></td><td><input type="text" class="form-control calculateamt puit_qty arrow_keypress required_field"  data-fieldid="puit_qty"  name="puit_qty[]" id="puit_qty_'+trplusOne+'" data-id="'+trplusOne+'""></td><td><input type="text" class="form-control float calculateamt puit_unitprice arrow_keypress" data-fieldid="puit_unitprice" name="puit_unitprice[]" id="puit_unitprice_'+trplusOne+'" data-id="'+trplusOne+'"></td><td><input type="text" class="form-control multiInsert discountpc arrow_keypress" data-fieldid="discountpc" name="discountpc[]" id="discountpc_'+trplusOne+'" data-id="'+trplusOne+'"></td><td><input type="text" class="form-control calculateamt float multiInsert puit_taxid vatpc arrow_keypress" data-fieldid="puit_taxid" name="puit_taxid[]" id="puit_taxid_'+trplusOne+'" data-id="'+trplusOne+'"></td><td><input type="text" class="form-control totalamount float puit_total" name="puit_total[]" id="puit_total_'+trplusOne+'" data-id="'+trplusOne+'" readonly="true"> </td><td><input type="text tender_no" name="tender_no" id="tender_no_'+trplusOne+'" data-id="'+trplusOne+'" class="form-control"  placeholder="Tender Number" value="" id="ServiceEnd_'+trplusOne+'" data-id="'+trplusOne+'"></td> <td><input type="text" class="form-control multiInsert description jump_to_add" name="description[]" id="description_'+trplusOne+'" data-id="'+trplusOne+'" placeholder=" Remarks"></td><td><a href="javascript:void(0)" class="btn btn-sm btn-danger btnRemove" data-id="'+trplusOne+'"  id="addRequistion_'+trplusOne+'"><span class="btnChange" id="btnChange_'+trplusOne+'"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a></div> <div class="actionDiv"></td></tr>';
        // console.log(templat);
        
        // $('#addOrder_'+id).removeClass('btn btn-primary btnAdd').addClass('btn btn-danger btnRemove');
        // $('#btnChange_'+id).html('<i class="fa fa-trash-o" aria-hidden="true"></i>');
        $('#purchaseDataBody').append(templat);
        $('.btnTemp').hide();

        setTimeout(function(){
            var itemcount = $('.itemname').length;
            // console.log('id'+itemcount);
         $('#itemname_'+itemcount).focus();   
     },500);
         
        // getProductsByCategory();
    });
       
    $(document).off('click','.addTermsAndConditions')
    $(document).on('click','.addTermsAndConditions',function(){

    });
</script>
<script>
    //calculate amount
    $(document).off('keyup change','.calculateamt');
    $(document).on('keyup change','.calculateamt', function(){
        var grandtotal = 0;
        var discounttotal = 0;
        var type = '';
        var discount = 0;
        var taxvalue =  0;
        var tax = 0;
        var withvat = 0;
        var withdis = 0;
        var ktotalamt = 0;
        var discount_amount = 0;
        var vat_amount = 0;

        var stotal=0;
        var trid = $(this).data('id');
        var qty = $('#puit_qty_'+trid).val();
        var vtax = $('#puit_taxid_'+trid).val();
        var vdisc = $('#discountpc_'+trid).val();

        var subtotal = 0;
        var total_amount_wo_taxdis = 0;
        // console.log(vdisc); alert(vdisc);
        // console.log(vtax); alert(vtax);
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

         if(vtax == '')
        {
            vtax=0;
        }else
        {
            vtax=parseFloat(vtax);
        }
        if(vdisc == '')
        {
            vdisc=0;
        }else
        {
            vdisc=parseFloat(vdisc);
        }
         
        var withdis = parseFloat((parseFloat(qty*price) * vdisc)/100);
        var ktotalamt=(qty*price)-withdis; //this is for discount
        var withvat= parseFloat(parseFloat(ktotalamt*vtax)/100);
        if(withvat == '')
        {
            withvat = 0;
        }
        else{
             withvat = parseFloat(withvat);
        }
        // console.log();
        totalamt = (ktotalamt + withvat);
        
        parseTotal = parseFloat(totalamt).toFixed(2);
        // alert(totalamt);
        $('#puit_total_'+trid).val(parseTotal);
        $(".totalamount").each(function() {
            stotal += parseFloat($(this).val());
            stotal = checkValidValue(stotal);
        });

        var extra = parseFloat($('#extraamount').val());

        if(isNaN(extra)){
            extra = 0;
        }else{
            extra = checkValidValue(extra);
        }

        var overall_discount = parseFloat($('#overall_discount').val());

        if(isNaN(overall_discount)){
            overall_discount = 0;
        }else{
            overall_discount = overall_discount;
        }

        // calculate total amount without tax and discount 
        var inc = 1;
        $(".totalamount").each(function() {
            $(this).data('id',inc);
            var qty1 = parseFloat($('#puit_qty_'+inc).val());
            var rate1 = parseFloat($('#puit_unitprice_'+inc).val());

            var qty1 = checkValidValue(qty1);
            var rate1 = checkValidValue(rate1);

            // console.log('qty1'+qty1);
            // console.log('rate1'+rate1);

            total_amount_wo_taxdis += parseFloat(qty1*rate1);
            inc++;
        });

        // calculate discount amount
        var inc = 1;
        $(".totalamount").each(function() {
            $(this).data('id',inc);
            var qty1 = parseFloat($('#puit_qty_'+inc).val());
            var rate1 = parseFloat($('#puit_unitprice_'+inc).val());
            var dis1 = parseFloat($('#discountpc_'+inc).val());

            // console.log('discount '+dis1);
            if(dis1){
                // discount_amount += parseFloat(qty1*rate1)-((dis1/100)*(parseFloat(qty1*rate1))); 
                discount_amount += parseFloat((dis1/100)*(parseFloat(qty1*rate1))); 
            }
            
            inc++;
        });

        //calculate total vat amount
        var inc = 1;
        var dis_amount = 0;
        $(".totalamount").each(function() {
            $(this).data('id',inc);
            var qty1 = parseFloat($('#puit_qty_'+inc).val());
            var rate1 = parseFloat($('#puit_unitprice_'+inc).val());
            var dis1 = parseFloat($('#discountpc_'+inc).val());
            var vat1 = parseFloat($('#puit_taxid_'+inc).val());

            if(dis1){
                dis_amount = parseFloat(qty1*rate1)-((dis1/100)*(parseFloat(qty1*rate1)));    
            }else{
                dis_amount = parseFloat(qty1*rate1);
            }
            if(vat1=='')
            {
             vat1=0;   
            }
            if(vat1){
                vat_amount += parseFloat(dis_amount * (vat1/100));
            }
            
            inc++;
        });

        // console.log('total_amount_wo_taxdis '+total_amount_wo_taxdis);

        // console.log('discount_amount '+discount_amount);

        // console.log('vat_amount '+vat_amount);

        if(isNaN(discount_amount)){
            discount_amount = 0;
        }else{
            discount_amount = checkValidValue(discount_amount);
        }

        if(isNaN(vat_amount)){
            vat_amount = 0;
        }else{
            vat_amount = checkValidValue(vat_amount);
        }

        subtotal = total_amount_wo_taxdis - discount_amount-overall_discount;

       //  console.log('stotal'+stotal);

       // console.log('extra'+extra);
       // console.log('overall_discount'+overall_discount);
       // console.log('subtotal'+subtotal);

        stotal = subtotal+vat_amount+extra-overall_discount;

        stotal = checkValidValue(stotal);

        $('#taxtamount').val(vat_amount.toFixed(2));
        $('#dis_amt').val(discount_amount.toFixed(2));
        $('#total_amount_wo_taxdis').val(total_amount_wo_taxdis.toFixed(2));
        $('#subtotal').val(subtotal.toFixed(2));
        $('#grandtotal').val(stotal.toFixed(2));
    });
            
    //overall discount
    $(document).off('keyup change','#overall_discount');
    $(document).on('keyup change','#overall_discount',function(){
        var discount = $('#overall_discount').val();

        $('.calculateamt').change();
    });

    //calculate extra
    $(document).off('keyup change','.calculateextra');
    $(document).on('keyup change','.calculateextra',function(){
        var insurance=$('#insurance').val();        
        var carriage=$('#carriage').val();        
        var packing=$('#packing').val();
       
        var freight=$('#freight').val();
        var other=$('#other').val();
        var transport=$('#transport').val();

        var valid_insurance = checkValidValue(insurance,'insurance');
        var valid_carriage = checkValidValue(carriage,'carriage');
        var valid_packing = checkValidValue(packing,'packing');
        var valid_freight = checkValidValue(freight,'freight');
        var valid_other = checkValidValue(other,'other');
        var valid_transport = checkValidValue(transport,'transport');

        var extratotal=parseFloat(valid_insurance)+parseFloat(valid_carriage)+parseFloat(valid_packing)+parseFloat(valid_freight)+parseFloat(valid_other)+parseFloat(valid_transport);

        var valid_extratotal = checkValidValue(extratotal);

        $('#extraamount').val(valid_extratotal.toFixed(2));
        
        $('.calculateamt').change();
    });
   
</script>
<script type="text/javascript">
    $(document).on('mouseover click','.nepali', function(){
    $('.nepali').nepaliDatePicker();
    });
</script>

<script type="text/javascript">
    $(document).off('keyup','#delivery_day');
    $(document).on('keyup','#delivery_day',function(){
        var days=$(this).val();
        var action=base_url+'/purchase_receive/purchase_order/ajax_delivery_date_calculation';
        $.ajax({
            type: "POST",
            url: action,
            data:{days:days},
             dataType: 'html',
             beforeSend: function() {
              // $('.overlay').modal('show');
            },
         success: function(jsons) //we're calling the response json array 'cities'
            {
                  data = jQuery.parseJSON(jsons);   
        // alert(data.status);
        if(data.status=='success')
            {
            $('#ServiceDelivery').val(data.delivery_date);
            }
         }
    })
})
</script>

<script type="text/javascript">
    $(document).off('click','.btnappprovedref');
    $(document).on('click','.btnappprovedref',function(){
      var action=base_url+'stock_inventory/approved/get_approved';
    // alert(depid);
    $.ajax({
          type: "POST",
          url: action,
          dataType: 'json',
        success: function(datas) 
          {
            // console.log(datas);
             $('#approvedid').html('');
            var opt='';
                opt +='<option value="">---select---</option>';
                $.each(datas,function(i,k)
                {
                  opt += '<option value='+k.appr_approvedid+'>'+k.appr_approvedname+'</option>';
                });
                // alert(opt);
                // return false;
          $('#approvedid').html(opt);
          }
      });
    })
</script>

<script type="text/javascript">
    function getDetailList(masterid, main_form=false){
        var mat_type_id = $('#material_type').val();
        // alert(materialtype);

        if(main_form == 'main_form'){
            var submiturl = base_url+'purchase_receive/purchase_order/load_detail_list/new_detail_list';
            var displaydiv = '#displayDetailList'; 
        }else{
            var submiturl = base_url+'purchase_receive/purchase_order/load_detail_list';
            var displaydiv = '#detailListBox';
        }
        
        $.ajax({
            type: "POST",
            url: submiturl,
            data: {masterid : masterid, mat_type_id:mat_type_id},
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
                            return false;
                        }else{
                            $(displaydiv).empty().html(data.tempform);
                        }
                        $('.calculateamt').change();
                    }
                }else{
                    if(data.status == 'success'){
                        $(displaydiv).empty().html(data.tempform);
                        $('.calculateamt').change();
                        // alert('test');
                    }
                }
                
                // $('.overlay').modal('hide');
            }
        });
        return false;
    }

    function blink_text() {
        $('.blink').fadeOut(100);
        $('.blink').fadeIn(1000);
    }

    setInterval(blink_text, 3000);
</script>

<script>
    $(document).off('change','#fiscalyear');
    $(document).on('change','#fiscalyear',function(){
        var fyear = $('#fiscalyear').val();
        $('#orderLoad').attr('data-fyear',fyear);
    });
</script>

<script type="text/javascript">
    $(document).off('keyup change','.vatpc');
    $(document).on('keyup change','.vatpc',function(){
        var vatpc = $(this).val();
        if(vatpc=='')
        {
            vatpc=0;
        }
        $('[id^="puit_taxid_"]').val(vatpc);
         $('.puit_qty').change();

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

            console.log(valid_total);

        if(valid_total > 0){
            $('#overall_discount').prop("disabled", true);
            $('#dis_amt').prop("disabled", false);
            $('#overall_discount').val('0');
        }else{
            $('#dis_amt').prop("disabled", true);
            $('#overall_discount').prop("disabled", false);
             $('#dis_amt').val('0');
        }
    });
</script>

<script type="text/javascript">
      $(document).off('click','.itemDetail');
      $(document).on('click','.itemDetail',function(){

        var rowno=$(this).data('rowno');
        var rate=$(this).data('rate');
        var itemcode=$(this).data('itemcode');
        var itemname=$(this).data('itemname_display');
        var itemid=$(this).data('itemid');
        var stock_qty=$(this).data('issueqty');
        var quotationmasterid=$(this).data('quotationmasterid');
        var unit=$(this).data('unitname');

        var purrate = $(this).data('purrate');
        
        $('#stock_qty_'+rowno).val(stock_qty); 
        $('#puit_unitid_'+rowno).val(unit); 
        // $('#itemcode_'+rowno).val(itemcode);
        $('#itemscode_'+rowno).val(itemcode);
        $('#qude_itemsid_'+rowno).val(itemid);
        $('#itemname_'+rowno).val(itemname);
        $('#quotationmasterid_'+rowno).val(quotationmasterid);
        $('#puit_unitprice_'+rowno).val(purrate);
       
        $('#myView').modal('hide');
        $('#puit_qty_'+rowno).focus();
    })
</script>

<script type="text/javascript">
    $(document).off('keyup blur','.vatpc');
    $(document).on('keyup blur','.vatpc',function(){
        var id = $(this).data('id');
        var vat = $('#puit_taxid_'+id).val();

        $(".vatpc").each(function() {
            $('.vatpc').val(vat);
            $('.calculateamt').change();
            // }
        });
         
    });
</script>

<script>
    $(document).off('click','.btnRemove');
    $(document).on('click','.btnRemove',function(){
        var id=$(this).data('id');
        var whichtr = $(this).closest("tr");
        var conf = confirm('Are Your Want to Sure to remove?');
        if(conf){
            var trplusOne = $('.orderrow').length+1;
             setTimeout(function(){
            var limstk_cnt=$('.limited_stock').length;
            $('#stock_limit').html(limstk_cnt);
        },1000);
            whichtr.remove(); 
            setTimeout(function(){
                $(".orderrow").each(function(i,k) {
                    var vali=i+1;
                    $(this).attr("id","orderrow_"+vali);
                    $(this).attr("data-id",vali);    
                    $(this).find('.s_no').attr("id","s_no_"+vali);
                    $(this).find('.s_no').attr("value",vali);
                    
                    $(this).find('.itemscode').attr("id","itemscode_"+vali);
                    $(this).find('.itemscode').attr("data-id",vali);

                    $(this).find('.itemcode').attr("id","itemcode_"+vali);
                    $(this).find('.itemcode').attr("data-id",vali);

                    $(this).find('.itemsid').attr("id","itemsid_"+vali);
                    $(this).find('.itemsid').attr("data-id",vali);

                    $(this).find('.itemname').attr("id","itemname_"+vali);
                    $(this).find('.itemname').attr("data-id",vali);

                    $(this).find('.qude_itemsid').attr("id","qude_itemsid_"+vali);
                    $(this).find('.qude_itemsid').attr("data-id",vali);

                    $(this).find('.purd_reqdetid').attr("id","purd_reqdetid_"+vali);
                    $(this).find('.purd_reqdetid').attr("data-id",vali);

                    $(this).find('.controlno').attr("id","controlno_"+vali);
                    $(this).find('.controlno').attr("data-id",vali);

                    $(this).find('.puit_unitid').attr("id","puit_unitid_"+vali);
                    $(this).find('.puit_unitid').attr("data-id",vali);

                    $(this).find('.stock_qty').attr("id","stock_qty_"+vali);
                    $(this).find('.stock_qty').attr("data-id",vali);

                    $(this).find('.puit_qty').attr("id","puit_qty_"+vali);
                    $(this).find('.puit_qty').attr("data-id",vali);

                    $(this).find('.puit_unitprice').attr("id","puit_unitprice_"+vali);
                    $(this).find('.puit_unitprice').attr("data-id",vali);

                    $(this).find('.discountpc').attr("id","discountpc_"+vali);
                    $(this).find('.discountpc').attr("data-id",vali);

                    $(this).find('.puit_taxid').attr("id","puit_taxid_"+vali);
                    $(this).find('.puit_taxid').attr("data-id",vali);

                    $(this).find('.puit_total').attr("id","puit_total_"+vali);
                    $(this).find('.puit_total').attr("data-id",vali);

                    $(this).find('.tender_no').attr("id","tender_no_"+vali);
                    $(this).find('.tender_no').attr("data-id",vali);

                    $(this).find('.description').attr("id","description_"+vali);
                    $(this).find('.description').attr("data-id",vali);

                    $(this).find('.btnAdd').attr("id","addOrder_"+vali);
                    $(this).find('.btnAdd').attr("data-id",vali);
                    $(this).find('.btnRemove').attr("id","addOrder_"+vali);
                    $(this).find('.btnRemove').attr("data-id",vali);
                    $(this).find('.btnChange').attr("id","btnChange_"+vali);
                });
            },600);
        }
    });
</script>