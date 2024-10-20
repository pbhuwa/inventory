<style type="text/css">
    .stock-limit{
        width: 240px;
        float: right;
    }
    .index_chart li div.stock_limit{
        background-color: #fbbe4e;
    }
</style>

<div class="table-responsive">
    <table style="width:100%;" class="table dataTable dt_alt purs_table">
        <thead>
            <tr>
                <th width="2%"> <?php echo $this->lang->line('sn'); ?> </th>
                <th width="25%"> <?php echo $this->lang->line('item_name'); ?></th>
                <th width="5%"> <?php echo $this->lang->line('unit'); ?> </th>
                <th width="5%"> <?php echo $this->lang->line('stock_quantity'); ?> </th>
                <th width="5%"> <?php echo $this->lang->line('qty'); ?> </th> 
                <th width="8%"> <?php echo $this->lang->line('unit_price'); ?> </th>
                <th width="8%"><?php echo $this->lang->line('dis'); ?></th>
                <th width="8%"> <?php echo $this->lang->line('select_vat'); ?> (%) </th>
                <th width="10%"> <?php echo $this->lang->line('total_amount'); ?> </th>
                <!-- <th width="5%"> Free </th> -->
                <th width="10%"><?php echo $this->lang->line('tender_no'); ?></th>
                <!-- <th width="8%">Dis (%)</th> -->
                <th width="10%"><?php echo $this->lang->line('remarks'); ?></th>
               <?php if(!empty($detail_list)) { ?> <th width="5%"> <?php echo $this->lang->line('action'); ?> </th> <?php } ?>
            </tr>
        </thead>
        <tbody id="purchaseDataBody" class="requisitionOrder loadedItems">
            <?php
                if(!empty($detail_list)):
                    $i=1;foreach($detail_list as $key=>$prd):

            ?>
                 <tr class="orderrow" id="orderrow_<?php echo $key+1;?>" data-id='<?php echo $key+1; ?>'  data-old_sno='<?php echo $key+1; ?>'>
                    <td>
                        <input type="text" class="form-control s_no" id="s_no_<?php echo $key+1; ?>" value="<?php echo $key+1; ?>" readonly/ disabled>
                    </td>
                    <td>
                        <div class="dis_tab"> 
                             <?php 
                                if(ITEM_DISPLAY_TYPE=='NP'){
                                    $prd_itemname = !empty($prd->itemnamenp)?$prd->itemnamenp:$prd->itemname;
                                }else{ 
                                    $prd_itemname = !empty($prd->itemname)?$prd->itemname:'';
                                }
                            ?>
                            <input type="text" class="form-control itemcode enterinput " id="itemcode_<?php echo $key+1; ?>" name="itemcode[]"  data-id='<?php echo $key+1; ?>' data-targetbtn='view' value="<?php echo $prd_itemname; ?>" readonly />
                            <input type="hidden" class="itemid" name="qude_itemsid[]" data-id='<?php echo $key+1; ?>' id="itemid_<?php echo $key+1; ?>" value="<?php echo $prd->itli_itemlistid; ?>">
                            <input type="hidden" class="itemsid" name="itemsid[]" data-id='<?php echo $key+1; ?>' value="<?php echo $prd->itli_itemlistid; ?>" id="matdetailid_<?php echo $key+1; ?>">
                            <input type="hidden" class="purd_reqdetid" name="purd_reqdetid[]" data-id='<?php echo $key+1; ?>' value="<?php echo $prd->purd_reqdetid; ?>" id="purd_reqdetid_<?php echo $key+1; ?>">
                            <!-- <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading='Item List' data-viewurl='<?php echo base_url('stock_inventory/item/list_item_with_stock_transfer'); ?>' data-id='<?php echo $key+1; ?>' id="view_<?php echo $key+1; ?>"><strong>...</strong></a> -->
                        </div>
                    </td>
                    <td>  
                        <input type="text" class="form-control puit_unitid" id="puit_unitid_<?php echo $key+1; ?>" name="puit_unitid[]"  data-id='<?php echo $key+1; ?>' value="<?php echo $prd->purd_unit; ?>" readonly />
                    </td>
                    <?php $tot = ($prd->purd_remqty)*($prd->itli_purchaserate); ?>
                    <td>
                        <input type="text" class="form-control multiInsert float stock_qty" name="stock_qty[]" id="stock_qty_<?php echo $key+1; ?>" data-id="<?php echo $key+1; ?>" placeholder="Stock Qty" readonly="true" value="<?php echo $prd->purd_stock; ?>">
                    </td>
                    <td>
                        <input type="text" class="form-control multiInsert float calculateamt puit_qty" name="puit_qty[]" id="puit_qty_<?php echo $key+1; ?>" data-id="<?php echo $key+1; ?>" value="<?php echo $prd->purd_remqty; //purd_qty?>">
                    </td>
                    <td>
                        <input type="text" class="form-control puit_unitprice float multiInsert calculateamt puit_unitprice" name="puit_unitprice[]" id="puit_unitprice_<?php echo $key+1; ?>" data-id="<?php echo $key+1; ?>"  value="<?php echo $prd->itli_purchaserate; ?>">
                    </td>
                    <td>
                        <input type="text" name="discountpc[]" class="form-control float calculateamt discountpc"  placeholder="Discount Pc" value="0" id="discountpc_<?php echo $key+1; ?>" data-id="<?php echo $key+1; ?>">
                    </td>
                    <td>
                        <input type="text" class="form-control float multiInsert calculateamt vatpc puit_taxid" name="puit_taxid[]" id="puit_taxid_<?php echo $key+1; ?>" data-id="<?php echo $key+1; ?>" vlue="0">
                    </td>
                    <td>
                        <input type="text" class="form-control totalamount float multiInsert puit_total" name="puit_total[]" id="puit_total_<?php echo $key+1; ?>" value="<?php echo $tot; ?>" data-id="<?php echo $key+1; ?>" readonly>
                    </td>
                    <!-- <td>
                        <input type="text" class="form-control   multiInsert" name="free[]" id="free_<?php echo $key+1; ?>" data-id="<?php echo $key+1; ?>">
                    </td> -->
                    <td>
                        <input type="text" name="tender_no[]" class="form-control float tender_no"  placeholder="Tender Number" value="" id="tender_no_<?php echo $key+1; ?>" data-id="<?php echo $key+1; ?>">
                    </td>
                    <td>
                        <input type="text" class="form-control   multiInsert idfornot description" name="description[]" id="description_<?php echo $key+1; ?>" data-id="<?php echo $key+1; ?>" placeholder="Remarks" value="<?php echo $prd->purd_remarks; ?>">
                    </td>
                    <td>
                        <a href="javascript:void(0)" class="btn btn-sm btn-danger btnRemove" id="btnRemove_<?php echo $key+1; ?>" data-id='<?php echo $key+1; ?>'>
                            <i class="fa fa-remove"></i>
                        </a>
                    </td>
                </tr>  
                <?php
                    
                    $i++;
                    endforeach;
                endif;
            ?>
        </tbody>
    </table>
</div>

<script>
    $(document).off('keyup blur change','.sade_qty');
    $(document).on('keyup blur change','.sade_qty',function(){
        var rowid = $(this).data('id');

        var sade_qty = $('#sade_qty_'+rowid).val();
        if(sade_qty==NaN || sade_qty =='')
        {
            sade_qty=0;
        }
        var qtyinstock = $('#qtyinstock_'+rowid).val();
        var remqty=$('#remqty_'+rowid).val();
        var my_rem_qty=0;

        // console.log('rowid :'+rowid);
        // console.log('sade_qty :'+sade_qty);
        // console.log('qtyinstock :'+qtyinstock);
        sade_qty = parseInt(sade_qty);
        qtyinstock = parseInt(qtyinstock);
        remqty=parseInt(remqty);
        my_rem_qty=parseInt(remqty)-parseInt(sade_qty);
        $('#my_remqty_'+rowid).val(my_rem_qty);

        if(sade_qty > remqty)
        {
            alert('Issue Qty should not exceed Req. qty. Please check it.');
            $('#sade_qty_'+rowid).val(remqty);
            my_rem_qty=parseInt(remqty)-parseInt(sade_qty);
            $('#my_remqty_'+rowid).val(my_rem_qty);

            return false;
        }

        if(sade_qty > qtyinstock){

            // $('.error').addClass('alert');
                alert('Issue Qty should not exceed stock qty. Please check it.');
                // return false;
            // $('.error').html('Issue Qty should not exceed stock qty. Please check it.').show().delay(1000).fadeOut();
            $('#sade_qty_'+rowid).val(qtyinstock);
            $('#sade_qty_'+rowid).focus();
            my_rem_qty=parseInt(remqty)-parseInt(qtyinstock);
            $('#my_remqty_'+rowid).val(my_rem_qty);
            return false;
        }
        
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
                    $(this).find('.reqdetailid').attr("id","reqdetailid_"+vali);
                    $(this).find('.reqdetailid').attr("data-id",vali);
                    $(this).find('.itemcode').attr("id","itemcode_"+vali);
                    $(this).find('.itemcode').attr("data-id",vali);
                    
                    $(this).find('.itemid').attr("id","itemid_"+vali);
                    $(this).find('.itemid').attr("data-id",vali);

                    $(this).find('.itemsid').attr("id","itemsid_"+vali);
                    $(this).find('.itemsid').attr("data-id",vali);
                    $(this).find('.purd_reqdetid').attr("id","purd_reqdetid_"+vali);
                    $(this).find('.purd_reqdetid').attr("data-id",vali);
                    $(this).find('.itemname').attr("id","itemname_"+vali);
                    $(this).find('.itemname').attr("data-id",vali);

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

                    $(this).find('.unitrate').attr("id","unitrate_"+vali);
                    $(this).find('.unitrate').attr("data-id",vali);
                    $(this).find('.unit').attr("id","unit_"+vali);
                    $(this).find('.unit').attr("data-id",vali);
                    $(this).find('.volume').attr("id","volume_"+vali);
                    $(this).find('.volume').attr("data-id",vali);
                    $(this).find('.qtyinstock').attr("id","qtyinstock_"+vali);
                    $(this).find('.qtyinstock').attr("data-id",vali);
                    $(this).find('.remqty').attr("id","remqty_"+vali);
                    $(this).find('.remqty').attr("data-id",vali);
                    $(this).find('.sade_qty').attr("id","sade_qty_"+vali);
                    $(this).find('.sade_qty').attr("data-id",vali);
                    $(this).find('.remarks').attr("id","remarks_"+vali);
                    $(this).find('.remarks').attr("data-id",vali);

                    $(this).find('.btnAdd').attr("id","addOrder_"+vali);
                    $(this).find('.btnAdd').attr("data-id",vali);
                    $(this).find('.btnRemove').attr("id","addOrder_"+vali);
                    $(this).find('.btnRemove').attr("data-id",vali);
                    $(this).find('.btnChange').attr("id","btnChange_"+vali);
                });
                $('.calculateamt').change();
            },600);
        }
    });
</script>
<script type="text/javascript">
    $(document).off('click','.zero_stk_remove');
    $(document).on('click','.zero_stk_remove',function(){
        var cnt_zero_stock=$('.stk_zero').length;
        if(cnt_zero_stock>0)
        {
            var conf = confirm('Are your want to sure to remove zero stock ?');
              if(conf)
              {
                $('.stk_zero').fadeOut(1000, function(){ 
                        $('.stk_zero').remove();
                    });
                setTimeout(function(){
                var limstk_cnt=$('.limited_stock').length;
                $('#stock_limit').html(limstk_cnt);
                },1100);
            }
        }
    })
</script>