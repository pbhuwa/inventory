 <style>
    .purs_table tbody tr td{
        border: none;
        vertical-align: center;
    }
</style>
<?php 
    if(!empty($transferred_main)){
        $disabled = "disabled";
    }else{
        $disabled = "";
    }
?>
<form method="post" id="FormStockRequisition" action="<?php echo base_url('issue_consumption/stock_transfer/save_stocktransfer'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('issue_consumption/stock_transfer/form_stocktransfer'); ?>'>
    <input type="hidden" name="id" value="<?php echo !empty($transferred_main[0]->tfma_tfmaid)?$transferred_main[0]->tfma_tfmaid:''; ?>" />

    <div class="form-group">
        <div class="col-md-2">
            <?php
                $db_transferno = !empty($transferred_main[0]->tfma_transferinvoice)?$transferred_main[0]->tfma_transferinvoice:$last_transferno;
            ?>
            <label for="example-text"><?php echo $this->lang->line('transfer_number'); ?>: </label>
            <input type="text" class="form-control" name="transfer_no"  value="<?php echo $db_transferno;?>" id="transfer_no" readonly>
            <span class="errmsg"></span>
        </div>

        <div class="col-md-2">
            <?php
                $db_fiscal_year = !empty($transferred_main[0]->tfma_fiscalyear)?$transferred_main[0]->tfma_fiscalyear:CUR_FISCALYEAR;
            ?>
            <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?><span class="required">*</span>:</label>
            <select name="fiscal_year" class="form-control required_field" id="fiscal_year" <?php echo $disabled;?>>
                <option value="">---select---</option>
                    <?php
                        if($fiscal):
                            foreach ($fiscal as $km => $fy):
                    ?>
                <option value="<?php echo $fy->fiye_name; ?>" <?php if($fy->fiye_name==$db_fiscal_year) echo "selected=selected"; ?>><?php echo $fy->fiye_name; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
            </select>
        </div>
        
        <div class="col-md-2">
            <?php
                if(DEFAULT_DATEPICKER == 'NP'){
                    $db_transfer_date = !empty($transferred_main[0]->tfma_transferdatebs)?$transferred_main[0]->tfma_transferdatebs:CURDATE_NP;
                }else{
                    $db_transfer_date = !empty($transferred_main[0]->tfma_transferdatead)?$transferred_main[0]->tfma_transferdatead:CURDATE_EN;
                }
            ?>
            <label for="example-text"><?php echo $this->lang->line('transfer_date'); ?>: </label>
            <input type="text" name="transfer_date" class="form-control required_field <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Transfer Date" value="<?php echo DISPLAY_DATE; ?>" id="transfer_date" <?php echo $disabled; ?>>
            <span class="errmsg"></span>
        </div>

        <div class="col-md-2">
            <?php
                $db_from_locationid = !empty($transferred_main[0]->tfma_fromlocationid)?$transferred_main[0]->tfma_fromlocationid:$this->locid;
            ?>
            <label for="example-text"><?php echo $this->lang->line('location_from'); ?>:<span class="required">*</span>:</label>
            <select name="from_location" id="from_location" class="form-control select2 location"  data-locationtype="from" <?php echo $disabled;?>>
                <option value="">---select---</option>
                <?php
                    if($from_location):
                        foreach ($from_location as $km => $loc):
                ?>
                 <option value="<?php echo $loc->loca_locationid; ?>" <?php echo ($db_from_locationid == $loc->loca_locationid)?'selected="selected"':'';?>><?php echo $loc->loca_name; ?></option>
                <?php
                        endforeach;
                    endif;
                ?>
            </select>
        </div>

        <div class="col-md-2">
            <?php
                $db_to_locationid = !empty($transferred_main[0]->tfma_tolocationid)?$transferred_main[0]->tfma_tolocationid:'';
            ?>
            <label for="example-text"><?php echo $this->lang->line('location_to'); ?>:<span class="required">*</span>:</label>
            <select name="to_location" id="to_location" class="form-control required_field select2 location" data-locationtype="to" <?php echo $disabled;?>>
                <option value="">---select---</option>
                <?php
                    if($to_location):
                        foreach ($to_location as $km => $loc):
                ?>
                 <option value="<?php echo $loc->loca_locationid; ?>" <?php echo ($db_to_locationid == $loc->loca_locationid)?'selected="selected"':''; ?>><?php echo $loc->loca_name; ?></option>
                <?php
                        endforeach;
                    endif;
                ?>
            </select>
        </div>

        <div class="col-md-2">
            <?php
                $db_transferby = !empty($transferred_main[0]->tfma_transferby)?$transferred_main[0]->tfma_transferby:strtoupper($this->username);
            ?>
            <label for="example-text"><?php echo $this->lang->line('transfer_by'); ?> :</label>
            
            <input type="text" class="form-control" name="transfer_by" id="transfer_by" value="<?php echo $db_transferby; ?>" <?php echo $disabled; ?> />
        </div>

        <div class="col-md-12">
            <?php
                $db_transferby = !empty($transferred_main[0]->tfma_remarks)?$transferred_main[0]->tfma_remarks:'';
            ?>
            <label for="example-text"><?php echo $this->lang->line('transfer_reason'); ?> :</label>
            <textarea class="form-control" name="transfer_reason" id="transfer_reason" <?php echo $disabled; ?>><?php echo $db_transferby;?></textarea>
        </div>

        <?php if(!empty($transferred_main)):?>
        <div class="col-md-2">
            <?php 
                $approve_by = strtoupper($this->username);
            ?>
            <label for="example-text"><?php echo $this->lang->line('approved_by'); ?> :</label>
            
            <input type="text" class="form-control" name="approve_by" id="approve_by" value="<?php echo $approve_by;?>" />
        </div>
        <?php endif;?>
    </div>
        
    <div class="clearfix"></div> 

    <div class="form-group">
        <div class="table-responsive">
            <table style="width:100%;" class="table dataTable dt_alt purs_table res_vert_table">
                <thead>
                     <tr>
                        <th scope="col" width="5%"> <?php echo $this->lang->line('sn'); ?>. </th>
                        <th scope="col" width="10%"> <?php echo $this->lang->line('code'); ?>  </th>
                        <th scope="col" width="25%"> <?php echo $this->lang->line('particular'); ?> </th>
                        <th scope="col" width="5%"> <?php echo $this->lang->line('unit'); ?>  </th>
                        <th scope="col" width="10%"> <?php echo $this->lang->line('stock_quantity');?>
                        </th>
                        <?php 
                            if(!empty($transferred_details)):
                        ?>
                            <th scope="col" width="10%">
                            <?php echo $this->lang->line('req_transfer_qty');?> 
                            </th>
                            <th scope="col" width="10%">
                            <?php echo $this->lang->line('transfer_qty');?> 
                            </th>
                        <?php else: ?>
                            <th scope="col" width="10%">
                            <?php echo $this->lang->line('transfer_qty');?> 
                            </th>
                        <?php endif; ?>

                        <th scope="col" width="15%"><?php echo $this->lang->line('remarks'); ?> </th>
                        <th scope="col" width="5%"> <?php echo $this->lang->line('action'); ?></th>
                    </tr>
                </thead>
                <tbody id="orderBody">
                    <?php
                        $j = 1;
                        if(!empty($transferred_details)):
                            foreach($transferred_details as $tr_key=>$tr_row): 

                                // echo "<pre>";
                                // print_r($transferred_details);
                                // die();
                                // $stock_qty = !empty($tr_row->tfde_stockqty)?$tr_row->tfde_stockqty:'';
                                
                                $cur_stk_qty = !empty($cur_stock_qty[$tr_key][0]->cur_stock)?$cur_stock_qty[$tr_key][0]->cur_stock:0;
                                
                                $req_transfer_qty = !empty($tr_row->tfde_reqtransferqty)?$tr_row->tfde_reqtransferqty:'';

                                if($req_transfer_qty < $cur_stk_qty){
                                    $transferring_qty = $req_transfer_qty;
                                    $stockTRClass="";
                                }else{
                                    $transferring_qty = (int)$cur_stk_qty;
                                    $stockTRClass="warning";
                                }


                    ?>
                        <tr class="orderrow <?php echo $stockTRClass;?>" id="orderrow_<?php echo $j;?>" data-id='<?php echo $j;?>'>
                            <td data-label="S.No.">
                                <input type="text" class="form-control sno" id="s_no_<?php echo $j;?>" value="<?php echo $j;?>" readonly/>
                                <input type="hidden" class="tfdeid" name="tfdeid[]" id="tfde_<?php echo $j; ?>" value="<?php echo !empty($tr_row->tfde_tfdeid)?$tr_row->tfde_tfdeid:''; ?>" />
                            </td>
                            <td data-label="Code">
                                <div class="dis_tab"> 
                                    <input type="text" class="form-control itemcode enterinput" id="itemcode_<?php echo $j;?>" name="itemcode[]"  data-id='<?php echo $j;?>' data-targetbtn='view' value="<?php echo !empty($tr_row->tfde_itemcode)?$tr_row->tfde_itemcode:''; ?>" readonly>
                                    <input type="hidden" class="itemid" name="itemid[]" data-id='<?php echo $j;?>' value="<?php echo !empty($tr_row->tfde_itemid)?$tr_row->tfde_itemid:''; ?>" id="itemid_<?php echo $j;?>">
                                    <input type="hidden" class="purchase_rate" name="purchase_rate[]" data-id='<?php echo $j;?>' value="<?php echo !empty($tr_row->tfde_purchaserate)?$tr_row->tfde_purchaserate:''; ?>" id="purchase_rate_<?php echo $j;?>">
                                    <input type="hidden" class="sales_rate" name="sales_rate[]" data-id='<?php echo $j;?>' value="<?php echo !empty($tr_row->tfde_salesrate)?$tr_row->tfde_salesrate:''; ?>" id="sales_rate_<?php echo $j;?>">

                                    <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading='Item List' data-viewurl='<?php echo base_url('stock_inventory/item/list_item_with_stock_for_transfer_location'); ?>' data-id='<?php echo $j;?>' id="view_<?php echo $j;?>" data-storeid="<?php echo $this->locid;?>"><strong>...</strong></a>
                                </div> 
                            </td>
                            <td data-label="Particular">  
                                <input type="text" name="itemname[]" class="form-control itemname" id="itemname_<?php echo $j;?>" value="<?php echo !empty($tr_row->itli_itemname)?$tr_row->itli_itemname:''; ?>"  data-id='<?php echo $j;?>' readonly /> 
                            </td>
                            <td data-label="Unit"> 
                                <input type="text" value="<?php echo !empty($tr_row->unit_unitname)?$tr_row->unit_unitname:''; ?>" class="form-control number unit calculateamt" id="unit_<?php echo $j;?>" data-id='<?php echo $j;?>' readonly="true"> 
                                <input type="hidden" class="unitid" name="unit[]" id="unitid_<?php echo $j;?>" data-id='<?php echo $j;?>' value="<?php echo !empty($tr_row->tfde_unit)?$tr_row->tfde_unit:''; ?>" readonly/>
                            </td>
                           
                            <td data-label="Stock Quantity"> 
                                <input type="text" class="form-control number stock_qty calculateamt required_field" name="stock_qty[]" id="stock_qty_<?php echo $j;?>" data-id='<?php echo $j;?>' value="<?php echo (int)$cur_stk_qty; ?>" readonly> 
                            </td>
                            <td data-label="Req. Transfer Qty"> 
                                <input type="text" class="form-control number reqtransfer_qty calculateamt" name="reqtransfer_qty[]" id="reqtransfer_qty_<?php echo $j;?>" value="<?php echo $req_transfer_qty; ?>" data-id='<?php echo $j;?>' readonly>
                            </td>
                            <td data-label="Transfer Quantity"> 
                                <input type="text" class="form-control number required_field transfer_qty calculateamt" name="transfer_qty[]" id="transfer_qty_<?php echo $j;?>" value="<?php echo $transferring_qty; ?>" data-id='<?php echo $j;?>' >
                            </td>
                            <td data-label="Remarks"> 
                                <input type="text" class="form-control remarks" id="remarks_<?php echo $j;?>" name="remarks[]" value="<?php echo !empty($tr_row->tfde_remarks)?$tr_row->tfde_remarks:''; ?>" data-id='<?php echo $j;?>'> 
                            </td>
                            <td data-label="Action">
                                <a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="1"  id="addRequistion_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>
                            </td>
                        </tr>

                    <?php
                            $j++;
                            endforeach;
                        else:
                    ?>
                    <tr class="orderrow" id="orderrow_1" data-id='1'>
                        <td data-label="S.No.">
                            <input type="text" class="form-control sno" id="s_no_1" value="1" readonly/>
                        </td>
                        <td data-label="Code">
                            <div class="dis_tab"> 
                                <input type="text" class="form-control itemcode enterinput" id="itemcode_1" name="itemcode[]"  data-id='1' data-targetbtn='view' value="" readonly>
                                <input type="hidden" class="itemid" name="itemid[]" data-id='1' value="" id="itemid_1">
                                <input type="hidden" class="purchase_rate" name="purchase_rate[]" data-id='1' value="" id="purchase_rate_1">
                                <input type="hidden" class="sales_rate" name="sales_rate[]" data-id='1' value="" id="sales_rate_1">

                                <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading='Item List' data-viewurl='<?php echo base_url('stock_inventory/item/list_item_with_stock_for_transfer_location'); ?>' data-id='1' id="view_1" data-storeid="<?php echo $this->locid;?>"><strong>...</strong></a>
                            </div> 
                        </td>
                        <td data-label="Particular">  
                            <input type="text" name="itemname[]" class="form-control itemname" id="itemname_1" name=""  data-id='1' readonly /> 
                        </td>
                        <td data-label="Unit"> 
                            <input type="text" value="" class="form-control number unit calculateamt" id="unit_1" data-id='1' readonly="true"> 
                            <input type="hidden" class="unitid" name="unit[]" id="unitid_1" data-id='1' readonly/>
                        </td>
                        <td data-label="Stock Quantity"> 
                            <input type="text" class="form-control  number stock_qty calculateamt" name="stock_qty[]" id="stock_qty_1" data-id='1' readonly> 
                        </td>
                        <td data-label="Transfer Quantity"> 
                            <input type="text" class="form-control required_field number transfer_qty calculateamt" name="transfer_qty[]"   id="transfer_qty_1" data-id='1' > 
                        </td>
                        <td data-label="Remarks"> 
                            <input type="text" class="form-control remarks " id="remarks_1" name="remarks[]"  data-id='1'> 
                        </td>
                        <td data-label="Action">
                            <div class="actionDiv acDiv2"></div>
                        </td>
                    </tr> 
                    <?php
                        endif;
                    ?>
                </tbody>
                <tbody>
                    <?php
                        if(empty($transferred_details)):
                    ?>
                    <tr class="resp_table_breaker">
                        <td colspan="8">
                            <a href="javascript:void(0)" class="btn btn-primary btnAdd pull-right" data-id="1"  id="addOrder_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-plus" aria-hidden="true"></i></span></a>
                            <div class="clearfix"></div>
                        </td>
                    </tr>
                    <?php
                        endif;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="form-group">
        <div class="col-md-12">
            <?php 
            $save_var= $this->lang->line('save');
            $update_var = $this->lang->line('update');
            $approve_var = $this->lang->line('approve');
            ?>
            <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($transferred_details)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($transferred_details)?$approve_var:$save_var; ?></button>
            <button type="submit" class="btn btn-info savePrint" data-operation='<?php echo !empty($transferred_details)?'update':'save ' ?>' id="btnSubmit" data-print="print"><?php echo !empty($transferred_details)?'Approve & Print':$this->lang->line('save_and_print') ?></button>   
        </div>
        
        <div class="col-sm-12">
            <div  class="alert-success success"></div>
            <div class="alert-danger error"></div>
        </div>
    </div>
    <div id="Printable" class="print_report_section printTable"></div> 
</form>
<script type="text/javascript">
   $(document).off('click','.btnAdd');
    $(document).on('click','.btnAdd',function(){
        var id=$(this).data('id');
        var itemid=$('#itemid_'+id).val();
        var qty=$('#qtyinstock_'+id).val();
        var rate=$('#transfer_qty_'+id).val();
        var trplusOne = $('.orderrow').length+1;
        var trpluOne = $('.orderrow').length;
        var itemcode=$('#itemname_'+id).val(); 
        var itemname=$(this).data('itemname_display');

        var code=$('#itemname_'+trplusOne).val(); 
        //alert(itemcode);

        var storeid= $('#from_location').val();
        if(storeid=='')
        {
            storeid='<?php echo $this->locid; ?>'
        }
        // alert(storeid);
        setTimeout(function(){
            $('.btnitem').attr('data-storeid',storeid);
            $('.btnitem').data('storeid',storeid);
        },500);     
        
        if(itemcode=='' || itemcode==null )
            {
                $('#itemcode_'+trpluOne).focus();
                return false;
            }
        if(trplusOne==2)
        { 
            $('.actionDiv').html('<a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="1"  id="addRequistion_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>');
        }
        var templat='';
        templat='<tr class="orderrow" id="orderrow_'+trplusOne+'" data-id="'+trplusOne+'"><td> <input type="text" class="form-control sno" id="s_no_'+trplusOne+'" value="'+trplusOne+'" readonly/></td><td><div class="dis_tab"> <input type="text" class="form-control itemcode enterinput" id="itemcode_'+trplusOne+'" name="itemcode[]" data-id="'+trplusOne+'" data-targetbtn="view" readonly=""> <input type="hidden" class="itemid" name="itemid[]" data-id="'+trplusOne+'" value="" id="itemid_'+trplusOne+'"> <input type="hidden" class="purchase_rate" name="purchase_rate[]" data-id="'+trplusOne+'" value="" id="purchase_rate_'+trplusOne+'"> <input type="hidden" class="sales_rate" name="sales_rate[]" data-id="'+trplusOne+'" value="" id="sales_rate_'+trplusOne+'"> <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading="Item List" data-viewurl="<?php echo base_url('stock_inventory/item/list_item_with_stock_for_transfer_location ');?>" data-id="'+trplusOne+'" id="view_'+trplusOne+'" data-storeid="<?php echo $this->locid;?>" ><strong>...</strong></a> </div></td><td data-label="Particular"> <input type="text" class="form-control itemname" id="itemname_'+trplusOne+'" name="itemname[]" data-id="'+trplusOne+'"> </td><td data-label="Unit"> <input type="text" class="form-control number unit calculateamt" name="" id="unit_'+trplusOne+'" data-id="'+trplusOne+'"> <input type="hidden" class="unitid" name="unit[]" id="unitid_'+trplusOne+'" data-id="'+trplusOne+'"/> </td><td data-label="Req. Quantity"> <input type="text" class="form-control number stock_qty calculateamt" name="stock_qty[]" id="stock_qty_'+trplusOne+'" data-id='+trplusOne+'> </td><td data-label="Req. Quantity"> <input type="text" class="required_field form-control number transfer_qty calculateamt" name="transfer_qty[]" id="transfer_qty_'+trplusOne+'" data-id='+trplusOne+'> </td><td data-label="Remarks"> <input type="text" class="form-control remarks " id="remarks_'+trplusOne+'" name="remarks[]" data-id="'+trplusOne+'"> </td><td data-label="Action"><a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="'+trplusOne+'" id="addRequistion_'+trplusOne+'"><span class="btnChange" id="btnChange_'+trplusOne+'"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a></div><div class="actionDiv"> </td></tr>';
         // $('#addOrder_'+id).removeClass('btn btn-primary btnAdd').addClass('btn btn-danger btnRemove');
         // $('#btnChange_'+id).html('<i class="fa fa-trash-o" aria-hidden="true"></i>');
        $('#orderBody').append(templat);
        $('#itemcode_'+trplusOne).focus();
        //$('#orderBody').append(template);
    });
    $(document).off('click','.btnRemove');
    $(document).on('click','.btnRemove',function(){
        var id=$(this).data('id');
         var whichtr = $(this).closest("tr");
         var conf = confirm('Are Your Want to Sure to remove?');
          if(conf)
          {
             var trplusOne = $('.orderrow').length+1;
             // console.log(trplusOne);
             // $('#orderrow_'+id).fadeOut(500, function(){ 
             // $('#orderrow_'+id).remove();
             //  });
             whichtr.remove(); 
            //  for (var i = 0; i < trplusOne; i++) {
            //   $('#s_no_'+i).val(i);
            // }
            setTimeout(function(){
                  $(".orderrow").each(function(i,k) {
                    var vali=i+1;
                    $(this).attr("id","orderrow_"+vali);
                    $(this).attr("data-id",vali);    
                    $(this).find('.sno').attr("id","s_no_"+vali);
                    $(this).find('.sno').attr("value",vali);
                    $(this).find('.itemcode').attr("id","itemcode_"+vali);
                    $(this).find('.itemcode').attr("data-id",vali);
                    $(this).find('.purchase_rate').attr("id","purchase_rate_"+vali);
                    $(this).find('.purchase_rate').attr("data-id",vali);
                    $(this).find('.sales_rate').attr("id","sales_rate_"+vali);
                    $(this).find('.sales_rate').attr("data-id",vali);
                    $(this).find('.reqdetailid').attr("id","reqdetailid_"+vali);
                    $(this).find('.reqdetailid').attr("data-id",vali);
                    $(this).find('.qtyinstock').attr("id","qtyinstock_"+vali);
                    $(this).find('.qtyinstock').attr("data-id",vali);
                    $(this).find('.itemid').attr("id","itemid_"+vali);
                    $(this).find('.itemid').attr("data-id",vali);
                    $(this).find('.itemname').attr("id","itemname_"+vali);
                    $(this).find('.itemname').attr("data-id",vali);
                    $(this).find('.view').attr("id","view_"+vali);
                    $(this).find('.view').attr("data-id",vali);
                    $(this).find('.unit').attr("id","unit_"+vali);
                    $(this).find('.unit').attr("data-id",vali);
                    $(this).find('.unitid').attr("id","unitid_"+vali);
                    $(this).find('.unitid').attr("data-id",vali);
                    $(this).find('.stock_qty').attr("id","stock_qty_"+vali);
                    $(this).find('.stock_qty').attr("data-id",vali);
                    $(this).find('.transfer_qty').attr("id","transfer_qty_"+vali);
                    $(this).find('.transfer_qty').attr("data-id",vali);
                    $(this).find('.remarks').attr("id","remarks_"+vali);
                    $(this).find('.remarks').attr("data-id",vali);

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
        var stockqty=$(this).data('issueqty');
        var purrate=$(this).data('purrate');
        var salesrate=$(this).data('salesrate');

        var valid_stockqty = checkValidValue(stockqty);
        var unitname=$(this).data('unitname');
        var unitid=$(this).data('unitid');
        $('#itemcode_'+rowno).val(itemcode);
        $('#itemid_'+rowno).val(itemid);
        $('#itemname_'+rowno).val(itemname);
        //$('#itemname_'+rowno).val(itemname_display);

        $('#purchase_rate_'+rowno).val(purrate);
        $('#sales_rate_'+rowno).val(salesrate);
        // $('#itemstock_'+rowno).val(stockqty);
        $('#unit_'+rowno).val(unitname);
        $('#stock_qty_'+rowno).val(valid_stockqty);
        $('#unitid_'+rowno).val(unitid);
        $('#myView').modal('hide');
        $('#transfer_qty_'+rowno).focus();
    })
</script>

<script type="text/javascript">
    $(document).off('keyup blur change','.transfer_qty');
    $(document).on('keyup blur change','.transfer_qty',function(){
        var rowid = $(this).data('id');
        
        var stock_qty = $('#stock_qty_'+rowid).val();
        var transfer_qty = $('#transfer_qty_'+rowid).val();
        var reqtransfer_qty = $('#reqtransfer_qty_'+rowid).val(); 

        var new_stock_qty = checkValidValue(stock_qty);
        var new_transfer_qty = checkValidValue(transfer_qty);
        var new_reqtransfer_qty = checkValidValue(reqtransfer_qty);

        if(new_transfer_qty > new_stock_qty){
            alert('Transfer quantity can not exceed stock qty. Please check it.');
            $('#transfer_qty_'+rowid).val(new_stock_qty);
            $('#transfer_qty_'+rowid).select();
        }

        if(typeof reqtransfer_qty != 'undefined' && new_transfer_qty > new_reqtransfer_qty){
            alert('Transfer quantity can not exceed Required qty. Please check it.');
            $('#transfer_qty_'+rowid).val(new_reqtransfer_qty);
            $('#transfer_qty_'+rowid).select();
        }
    }); 
</script>

<script>
    $(document).off('change','.location');
    $(document).on('change','.location',function(){
        var from_location = $('#from_location').val();
        var to_location = $('#to_location').val();
        var locationtype = $(this).data('locationtype');

        if(from_location == to_location){
            alert('You can not transfer to same location. Please choose different location.');
            if(locationtype =='from'){
                $("#from_location").select2().select2("val", null);
                return false;
            }else if(locationtype == 'to'){
                $("#to_location").select2().select2("val", null);
                return false;
            }
        }
    });

</script>
<script type="text/javascript">
    $(document).on('change','#from_location',function()
    {
        var frmlocattionid=$('#from_location').val();
          setTimeout(function(){
            $('.btnitem').attr('data-storeid',frmlocattionid);
            $('.btnitem').data('storeid',frmlocattionid);
        },500);     

    })
</script>
<script type="text/javascript">
$(document).ready(function() {
    $("#from_location").on("click", function() {
         var from_location = $('#from_location').val();
        // alert(from_location);
        if(from_location !== ''){

           document.location.reload('#orderBody');

        }
    });
});
</script>