<style type="text/css">
    .stock-limit{
        width: 240px;
        float: right;
    }
    .index_chart li div.stock_limit{
        background-color: #fbbe4e;
    }
</style>

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
                <!-- <th width="8%">Exp. Date</th> -->
                <th width="10%"><?php echo $this->lang->line('description'); ?></th>
                <th width="5%"><?php echo $this->lang->line('action'); ?></th>
            </tr>
        </thead>
        <tbody id="purchaseOrderDataBody">
            <?php
                if(!empty($detail_list)):
                    $i=1;
                    foreach ($detail_list as $ko => $ord_det):
                        $order_qty = !empty($ord_det->pude_remqty)?$ord_det->pude_remqty:'';

                        if($order_qty > 0):
            ?>
            <tr id="row_<?php echo $i; ?> receivedOrderItem_<?php echo $i;?>" class="receivedItems">
                <td>
                    <input type="text" class="form-control sno noBorderInput" id="sno_<?php echo $ko+1; ?>" value="<?php echo $ko+1; ?>" readonly/>
                </td>
                <td>
                    <?php echo $ord_det->itemcode; ?>
                    <input type="hidden" class="itemsid" name="itemsid[]" value="<?php echo $ord_det->itli_itemlistid; ?>" id="itemsid_<?php echo $i; ?>" />
                    <input type="hidden" class="pudeid" name="pudeid[]" value="<?php echo $ord_det->pude_puordeid; ?>" id="pudeid_<?php echo $i; ?>" />
                </td>
                <td>
                    <?php 
                        if(ITEM_DISPLAY_TYPE=='NP'){
                            echo !empty($ord_det->itemnamenp)?$ord_det->itemnamenp:$ord_det->itemname;
                        }else{ 
                            echo !empty($ord_det->itemname)?$ord_det->itemname:'';
                        }
                    ?>
                </td>
                <td>
                    <?php echo $ord_det->unit_unitname; ?>
                    <input type="hidden" class="form-control unit" name="unit[]" value="<?php echo $ord_det->unit_unitname; ?>" data-id="<?php echo $i; ?>" id="unit_<?php echo $i; ?>" readonly />
                </td>
                <td>
                    <?php echo $ord_det->pude_remqty; ?>
                   <input type="hidden" class="order_qty" name="order_qty[]" value="<?php echo $ord_det->pude_remqty; ?>" id="order_qty_<?php echo $i; ?>" >
                </td>
                <td>
                    <input type="text" class="form-control number calamt recqty arrow_keypress" data-fieldid="recqty" name="received_qty[]" value="0"  data-id='<?php echo $i; ?>' id="recqty_<?php echo $i; ?>">
                </td>
               <!--  <td>
                    <input type="text" class="form-control number calamt free" name="free[]" value="<?php echo $ord_det->pude_free; ?>" id="free_<?php echo $i;?>" data-id='<?php echo $i; ?>' >
                </td> -->
                <td>
                    <input type="text" class="form-control float calamt rate" name="rate[]" id="rate_<?php echo $i; ?>"   value="<?php echo $ord_det->rate; ?>"  data-id='<?php echo $i; ?>'>
                    <input type="hidden" class="form-control float calamt purchase_rate[]" name="purchase_rate[]" id="purchase_rate_<?php echo $i; ?>"   value="<?php echo $ord_det->itli_purchaserate; ?>"  data-id='<?php echo $i; ?>'>
                </td>
                <td>
                    <input type="text" class="form-control number calamt cc" name="cc[]" id="cc_<?php echo $i; ?>" value="<?php echo '0'; ?>"  data-id='<?php echo $i; ?>'>
                </td>
                <td>
                    <input type="text" class="form-control float calamt discount discountpc arrow_keypress" data-fieldid="discount" name="discount[]" id="discount_<?php echo $i; ?>"  value="<?php echo $ord_det->pude_discount; ?>"  data-id='<?php echo $i; ?>'>
                    <input type="hidden" name="disamt[]" value="" id="disamt_<?php echo $i; ?>" class="disamt calamt">
                </td>
                <td>
                    <input type="text" class="form-control float calamt vat arrow_keypress" name="vat[]" data-fieldid="vat" id="vat_<?php echo $i; ?>" value="<?php echo $ord_det->pude_vat; ?>"  data-id='<?php echo $i; ?>'>
                    <input type="hidden" name="vatamt[]" value="" id="vatamt_<?php echo $i; ?>" class="vatamt calamt">
                </td>
                <td>
                    <input type="text" class="form-control eachtotalamt amt" name="amount[]" value="" readonly="readonly" id="amt_<?php echo $i; ?>">
                    <input type="hidden" class="form-control eachratexqty ratexqty" name="ratexqty[]" value="" id="ratexqty_<?php echo $i; ?>"/>
                </td>
                <!-- <td>
                    <input type="text" class="form-control <?php echo DATEPICKER_CLASS; ?> expiry_date" name="expiry_date[]" id="expiry_date_<?php echo $i; ?>"  data-id='<?php echo $i; ?>' >
                </td> -->
                <td>
                    <input type="text" class="form-control description" name="description[]" value="<?php echo $ord_det->pude_remarks; ?>" id="description_<?php echo $i; ?>" data-id='<?php echo $i; ?>'>
                </td>
                <td>
                    <a href="javascript:void(0)" class="btn btn-sm btn-danger btnRemove" id="btnRemove_<?php echo $i; ?>" data-id='<?php echo $i; ?>'>
                        <i class="fa fa-remove"></i>
                    </a>
                </td>
            </tr>
            <?php
                    $i++;
                    endif;
                    endforeach;
                endif;
            ?>
        </tbody>
    </table>

    <div class="roi_footer">
        <div class="row">
            <div class="col-sm-4">
               <!--  <label>Enter Bill Amount</label>
                <input type="text" class="form-control float" name="billamount" id="billamount"> -->
                <!--  <h4>
                    <label>Actual Clear Amount:</label>
                </h4>
                <div class="dis_tab">
                    <label class="pr-10 table-cell width_75">Budget:</label>
                    <select class="table-cell form-control" name="bugetid">
                        <option value="0">--- Select ---</option>
                        <?php if(!empty($budgets_list)): 
                        foreach ($budgets_list as $kb => $buget):
                            ?>
                        <option value="<?php echo $buget->budg_budgetid; ?>"><?php echo $buget->budg_budgetname; ?></option>
                        <?php
                        endforeach;
                        endif;
                        ?>
                    </select>
                    <a href="javascript:void(0)" class="table-cell width_30 text-center"><i class="fa fa-plus"></i></a>
                </div> -->
                <div class="dis_tab">
                    <label class="vt d-block"><?php echo $this->lang->line('remarks'); ?></label>
                    <textarea name="remarks" id="" cols="40" rows="5" class="form-control table-cell vt"></textarea>
                </div>

                 <div class="mtop_15">
                                <label>Attachments</label>
                                <div class="dis_tab">
                                    <input type="file" id="recm_attachments" name="recm_attachments[]"/>
                                    <input type="hidden" name="recm_attach[]">
                                    <a href="javascript:void(0)" class="btn btn-info table-cell width_30" id="addAttachments">+</a>
                                </div>
                                <div class="addAttachmentRow">
                                    <?php 

                                    $contractAttachments = !empty($contract_data[0]->recm_attachments)?$contract_data[0]->recm_attachments:'';
                                    if($contractAttachments):
                                    $attach = explode(', ',$contractAttachments);
                                    $download = "";
                                    if($attach):
                                        foreach($attach as $key=>$value){
                                            $download .= "<a href='".base_url().RECEIVED_BILL_ATTACHMENT_PATH.'/'.$value."' target='_blank'>Download<a>&nbsp;&nbsp;&nbsp;";
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
                            <input type="text" class="form-control float totalamount" name="totalamount" id="totalamount" readonly="true" />
                        </li>
                        <li>
                            <label><?php echo $this->lang->line('discount_in_amount'); ?></label>
                            <input type="text" class="form-control float" name="discountamt" id="discountamt" value="0" readonly="true"/>
                        </li>

                        <li>
                            <label>
                                <?php echo !empty($this->lang->line('overall_discount'))?$this->lang->line('overall_discount'):'Overall Discount'; ?>
                            </label>

                            <input type="text" class="form-control float" name="discountamt" id="overall_discount" value="0" data-discount="amt" / >
                        </li>

                        <li>
                            <label><?php echo $this->lang->line('sub_total'); ?></label>
                            <input type="text" class="form-control float" name="subtotalamt" id="subtotalamt" value="" readonly="true" />
                        </li>
                        <li>
                            <label><?php echo $this->lang->line('total_tax'); ?> </label>
                            <input type="text" class="form-control float" name="taxamt" id="taxamt" value="" readonly="true" />

                        </li>
                        <li>
                            <label><?php echo $this->lang->line('extra_charges'); ?></label>
                            <input type="text" class="form-control float" name="extra" id="extra" value="" readonly="true"/>
                       </li>
                       <li>
                           <label><?php echo $this->lang->line('rf'); ?></label>
                           <input type="text" class="form-control float calculaterefund" name="refund" id="refund" value="" placeholder="" />
                        </li>
                        <li>
                            <label><?php echo $this->lang->line('clearance_amt'); ?></label>
                            <input type="text" class="form-control" name="clearanceamt" id="clearanceamt">
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
    <div id="Printable" class="print_report_section printTable"></div>             
</div>



<script type="text/javascript">
    $('.calamt').change();
</script>
<script>
    $(document).off('click','.btnRemove');
    $(document).on('click','.btnRemove',function(){
        var id=$(this).data('id');
        var whichtr = $(this).closest("tr");
        var conf = confirm('Are Your Want to Sure to remove?');
          if(conf)
          {
            var trplusOne = $('.receivedItems').length+1;
            whichtr.remove();
            // setTimeout(function(){
            //         $(".receivedItems").each(function(i,k) {
            //         var vali=i+1;
            //         $(this).attr("id","receivedOrderItem_"+vali);
            //         $(this).attr("data-id",vali);    
            //         $(this).find('.sno').attr("id","s_no_"+vali);
            //         $(this).find('.sno').attr("value",vali);
            //         $(this).find('.itemsid').attr("id","itemsid_"+vali);
            //         $(this).find('.itemsid').attr("value",vali);
            //         $(this).find('.pudeid').attr("id","pudeid_"+vali);
            //         $(this).find('.pudeid').attr("value",vali);
            //         $(this).find('.batchno').attr("id","batchno_"+vali);
            //         $(this).find('.batchno').attr("value",vali);

            //         $(this).find('.unit').attr("id","unit_"+vali);
            //         $(this).find('.unit').attr("value",vali);
            //         $(this).find('.order_qty').attr("id","order_qty_"+vali);
            //         $(this).find('.order_qty').attr("value",vali);
            //         $(this).find('.recqty').attr("id","recqty_"+vali);
            //         $(this).find('.recqty').attr("value",vali);
            //         $(this).find('.free').attr("id","free_"+vali);
            //         $(this).find('.free').attr("value",vali);
            //         $(this).find('.rate').attr("id","rate_"+vali);
            //         $(this).find('.rate').attr("value",vali);

            //         $(this).find('.cc').attr("id","cc_"+vali);
            //         $(this).find('.cc').attr("value",vali);
            //         $(this).find('.discount').attr("id","discount_"+vali);
            //         $(this).find('.discount').attr("value",vali);
            //         $(this).find('.disamt').attr("id","disamt_"+vali);
            //         $(this).find('.disamt').attr("value",vali);

            //         $(this).find('.vat').attr("id","vat_"+vali);
            //         $(this).find('.vat').attr("value",vali);
            //         $(this).find('.vatamt').attr("id","vatamt_"+vali);
            //         $(this).find('.vatamt').attr("value",vali);
            //         $(this).find('.amt').attr("id","amt_"+vali);
            //         $(this).find('.amt').attr("value",vali);
            //         $(this).find('.expiry_date').attr("id","expiry_date_"+vali);
            //         $(this).find('.expiry_date').attr("value",vali);

            //         $(this).find('.description').attr("id","description_"+vali);
            //         $(this).find('.description').attr("value",vali);

            //         $(this).find('.recqty').attr("id","recqty_"+vali);
            //         $(this).find('.recqty').attr("data-id",vali);
                    
            //         $(this).find('.btnAdd').attr("id","addOrder_"+vali);
            //         $(this).find('.btnAdd').attr("data-id",vali);
            //         $(this).find('.btnRemove').attr("id","addOrder_"+vali);
            //         $(this).find('.btnRemove').attr("data-id",vali);
            //         $(this).find('.btnChange').attr("id","btnChange_"+vali);
            //         $(this).find('.btnChange').attr("data-id"+vali);
            // });
            // },600);
          }
     });
</script>
<script>
    $(document).off('keyup change','.recqty');
    $(document).on('keyup change','.recqty',function(){
        var id=$(this).data('id');
        var reqqty=$(this).val();
        var avlailqty=$('#order_qty_'+id).val();
        qtynow = parseInt(reqqty);
        avlailqty = parseInt(avlailqty);
        if(qtynow > avlailqty)
        {
            alert('Received Quantity can not be greater than ordered quantity !!');
            $('#recqty_'+id).val(avlailqty); 
            return false;
        }
    })  
</script>
