
<?php
    if(!empty($received_data_detail)):
        $i=1;
        foreach ($received_data_detail as $ko => $rec_det):

            if(ITEM_DISPLAY_TYPE=='NP'){
                    $req_itemname = !empty($rec_det->itli_itemnamenp)?$rec_det->itli_itemnamenp:$rec_det->itli_itemname;
                }else{ 
                    $req_itemname = !empty($rec_det->itli_itemname)?$rec_det->itli_itemname:'';
                }
            
            $purchased_qty = !empty($rec_det->recd_purchasedqty)?$rec_det->recd_purchasedqty:0;
            if($purchased_qty >0):
?>
<tr id="row_<?php echo $i; ?> receivedOrderItem_<?php echo $i;?>" class="receivedItems">
    <td>
        <input type="text" class="form-control sno noBorderInput" id="sno_<?php echo $ko+1; ?>" value="<?php echo $ko+1; ?>" readonly/>
    </td>
    <td>
        <?php echo $rec_det->itli_itemcode; ?>
        <input type="hidden" class="itemsid" name="itemsid[]" value="<?php echo $rec_det->recd_itemsid; ?>" id="itemsid_<?php echo $i; ?>" />
        <input type="hidden" class="receiveddetailid" name="receiveddetailid[]" value="<?php echo $rec_det->recd_receiveddetailid; ?>" id="receiveddetailid_<?php echo $i; ?>" />
    </td>
    <td><?php echo $req_itemname; ?></td>
    <td>
        <?php echo $rec_det->unit_unitname; ?>
       
    </td>
    <td>
        <?php echo (int)$rec_det->recd_purchasedqty; ?>
       <input type="hidden" class="received_qty" name="received_qty[]" value="<?php echo $rec_det->recd_purchasedqty; ?>" id="received_qty_<?php echo $i; ?>" >
    </td>
    <td>
        <input type="text" class="form-control number calamt return_qty" name="return_qty[]" value="0"  data-id='<?php echo $i; ?>' id="return_qty_<?php echo $i; ?>">
    </td>
  
    <td>
        <?php echo !empty($rec_det->recd_salerate)?$rec_det->recd_salerate:''; ?>
        <input type="hidden" class="sales_rate" name="sales_rate[]" id="sales_rate_<?php echo $i;?>" value="<?php echo !empty($rec_det->recd_salerate)?$rec_det->recd_salerate:''; ?>"/>
        <input type="hidden" class="purchase_rate" name="purchase_rate[]" id="purchase_rate_<?php echo $i;?>" value="<?php echo !empty($rec_det->recd_unitprice)?$rec_det->recd_unitprice:''; ?>"/>
    </td>
    <td>
       <?php //echo !empty($rec_det->recd_cccharge)?$rec_det->recd_cccharge:''; ?>
       <input type="text" class="form-control float calamt cc" name="cc[]" id="cc_<?php echo $i; ?>" value="<?php echo !empty($rec_det->recd_cccharge)?$rec_det->recd_cccharge:''; ?>"  data-id='<?php echo $i; ?>'>
    </td>
    <td>
        <?php echo $rec_det->recd_discountpc; ?>
        <input type="hidden" class="form-control float calamt discount" name="discount[]" id="discount_<?php echo $i; ?>"  value="<?php echo $rec_det->recd_discountpc; ?>"  data-id='<?php echo $i; ?>'>
        <input type="hidden" name="disamt[]" value="" id="disamt_<?php echo $i; ?>" class="disamt calamt">
    </td>
    <td>
        <?php echo $rec_det->recd_vatpc; ?>
        <input type="hidden" class="form-control float calamt vat" name="vat[]" id="vat_<?php echo $i; ?>" value="<?php echo $rec_det->recd_vatpc; ?>"  data-id='<?php echo $i; ?>'>
        <input type="hidden" name="vatamt[]" value="" id="vatamt_<?php echo $i; ?>" class="vatamt calamt">
    </td>
    <td>
        <input type="text" class="form-control eachtotalamt amt" name="amount[]" value="0" readonly="readonly" id="amt_<?php echo $i; ?>">
    </td>
  <!--   <td>
        <?php
        if(DEFAULT_DATEPICKER=='NP')
        {
        $expdate=$rec_det->recd_expdatebs; 
        }
        else
        {
        $expdate=$rec_det->recd_expdatead; 
        }
        echo $expdate;
        ?>
    </td> -->
    <td>
        <input type="text" class="form-control description" name="description[]" id="description_<?php echo $i;?>" />
    </td>
    <td>
        <a href="javascript:void(0)" class="btn btn-sm btn-danger btnRemove" id="btnRemove_<?php echo $i; ?>" data-id='<?php echo $i; ?>'>
            <i class="fa fa-remove"></i>
        </a>
    </td>
</tr>
<?php
        $i++;
        else:
?>
<tr>
    <td colspan="13" class="text-center">No items are available for return.</td>
</tr>
<?php
endif;
        endforeach;
    endif;
?>

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
    $(document).off('keyup change','.return_qty');
    $(document).on('keyup change','.return_qty',function(){
        var id=$(this).data('id');
        var retqty=$(this).val();
        var pur_qty=$('#received_qty_'+id).val();
        pur_qty = parseInt(pur_qty);
        retqty = parseInt(retqty);
        if(retqty > pur_qty)
        {
            alert('Return Quantity can not be greater than Received quantity !!');
            $('#return_qty_'+id).val(pur_qty); 
            return false;
        }
    })  
</script>
