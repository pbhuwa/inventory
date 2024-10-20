<div class="table-responsive">
    <table style="width:100%;" class="table purs_table dataTable">
        <thead>
            <tr>
                <th width="2%"><?php echo $this->lang->line('sn'); ?></th>
                <th width="8%"><?php echo $this->lang->line('item_code'); ?></th>
                <th width="15%"><?php echo $this->lang->line('item_name'); ?></th>
                <th width="8%"><?php echo $this->lang->line('unit'); ?></th>
                <th width="8%"><?php echo $this->lang->line('odr_qty'); ?></th> 
                <th width="8%"><?php echo $this->lang->line('qty'); ?></th>
                <th width="10%"><?php echo $this->lang->line('remarks'); ?></th>
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
                    <input type="hidden" class="itemsid" name="trde_itemsid[]" value="<?php echo $ord_det->itli_itemlistid; ?>" id="itemsid_<?php echo $i; ?>" />
                    <input type="hidden" class="pudeid" name="pudeid[]" value="<?php echo $ord_det->pude_puordeid; ?>" id="pudeid_<?php echo $i; ?>" />
                    <input type="hidden" class="form-control itemcode enterinput " id="itemcode_<?php echo $i; ?>" name="trde_mtmid[]"  data-id='<?php echo $i; ?>' data-targetbtn='view' value="<?php echo !empty($ord_det->itemcode)?$ord_det->itemcode:'';?>" >
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
                    <input type="hidden" class="form-control unit" name="trde_unitpercase[]" value="<?php echo $ord_det->unit_unitname; ?>" data-id="<?php echo $i; ?>" id="unit_<?php echo $i; ?>" readonly />
                </td>
                <td>
                    <?php echo $ord_det->pude_remqty; ?>
                   <input type="hidden" class="order_qty" name="order_qty[]" value="<?php echo $ord_det->pude_remqty; ?>" id="order_qty_<?php echo $i; ?>" >
                </td>
                <td>
                    <input type="text" class="form-control number calamt recqty arrow_keypress" data-fieldid="recqty" name="trde_issueqty[]" value="0"  data-id='<?php echo $i; ?>' id="recqty_<?php echo $i; ?>">
                </td>
               
                <td>
                    <input type="text" class="form-control description arrow_keypress" name="remarks[]" data-fieldid="description" value="<?php echo $ord_det->pude_remarks; ?>" id="description_<?php echo $i; ?>" data-id='<?php echo $i; ?>'>
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
