<?php if($purhasre_requisition){ //echo"<pre>"; print_r($purhasre_requisition);die;
 foreach ($purhasre_requisition as $key => $prd) { ?>
<tr class="orderrow" id="orderrow_<?php echo $key+1; ?>" data-id='<?php echo $key+1; ?>'>
    <td>
        <input type="text" class="form-control" id="s_no_<?php echo $key+1; ?>" value="<?php echo $key+1; ?>" readonly/ disabled>
    </td>
    <td>
        <div class="dis_tab"> 
            <input type="text" class="form-control itemcode enterinput " id="itemcode_<?php echo $key+1; ?>" name="itemcode[]"  data-id='<?php echo $key+1; ?>' data-targetbtn='view' value="<?php echo $prd->itli_itemname; ?>">
            <input type="hidden" class="qude_itemsid" name="qude_itemsid[]" data-id='<?php echo $key+1; ?>' id="itemid_<?php echo $key+1; ?>" value="<?php echo $prd->itli_itemlistid; ?>">
            <input type="hidden" class="itemsid" name="itemsid[]" data-id='<?php echo $key+1; ?>' value="<?php echo $prd->itli_itemlistid; ?>" id="matdetailid_<?php echo $key+1; ?>">
              <input type="hidden" class="purd_reqdetid" name="purd_reqdetid[]" data-id='<?php echo $key+1; ?>' value="<?php echo $prd->purd_reqdetid; ?>" id="purd_reqdetid_<?php echo $key+1; ?>">
            <!-- <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading='Item List' data-viewurl='<?php echo base_url('stock_inventory/item/list_item_with_stock_transfer'); ?>' data-id='<?php echo $key+1; ?>' id="view_<?php echo $key+1; ?>"><strong>...</strong></a> -->
        </div>
    </td>
    <td>  
        <input type="text" class="form-control puit_unitid" id="puit_unitid_<?php echo $key+1; ?>" name="puit_unitid[]"  data-id='<?php echo $key+1; ?>' value="<?php echo $prd->purd_unit; ?>" >
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
        <input type="text" name="discountpc[]" class="form-control float calculateamt"  placeholder="Discount Pc" value="0" id="discountpc_<?php echo $key+1; ?>" data-id="<?php echo $key+1; ?>">
    </td>
    <td>
        <input type="text" class="form-control float multiInsert calculateamt" name="puit_taxid[]" id="puit_taxid_<?php echo $key+1; ?>" data-id="<?php echo $key+1; ?>" vlue="0">
    </td>
    <td>
        <input type="text" class="form-control totalamount float multiInsert puit_total" name="puit_total[]" id="puit_total_<?php echo $key+1; ?>" value="<?php echo $tot; ?>" data-id="<?php echo $key+1; ?>" readonly>
    </td>
    <!-- <td>
        <input type="text" class="form-control   multiInsert" name="free[]" id="free_<?php echo $key+1; ?>" data-id="<?php echo $key+1; ?>">
    </td> -->
    <td>
        <input type="text" name="tender_no[]" class="form-control float"  placeholder="Tender Number" value="" id="tender_no_<?php echo $key+1; ?>" data-id="<?php echo $key+1; ?>">
    </td>
    <td>
        <input type="text" class="form-control   multiInsert idfornot" name="description[]" id="description_<?php echo $key+1; ?>" data-id="<?php echo $key+1; ?>" placeholder="Remarks" value="<?php echo $prd->purd_remarks; ?>">
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
        var totalamt =0; 
        var discount = 0;
        var taxvalue =  0;
        function calculate(){
            var stotal=0;
            var trid=$('.idfornot').data('id');
            var qty=$('#puit_qty_'+trid).val();
            //console.log(trid);
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
                $('#puit_total_'+trid).val(totalamt);
                stotal += parseFloat($(this).val());
            });
            $('#subtotal').val(stotal);
            $('#grandtotal').val(stotal);
            $('#discountType').change();
        };
    })
</script>
<?php    
} } ?>
<script>
    $(document).off('blur','.puit_qty');
    $(document).on('blur','.puit_qty',function(e){
        var id = $(this).data('id'); //alert(id);
        var remqty = $('#puit_qty_'+id).val();
        var fiscalyear = $('#fiscalYear').val();
        var pid = $('#purd_reqdetid_'+id).val();
        purd_reqdetid_1
        var action=base_url+'purchase_receive/purchase_order/purhasre_requisition_check_remainigqty';
        $.ajax({
          type: "POST",
          url: action,
          data:{remqty:remqty,fiscalyear:fiscalyear,pid:pid},
          dataType: 'html',
          success: function(jsons) 
            {
                data = jQuery.parseJSON(jsons);   
                // alert(data.status);
                if(data.status=='success')
                {
                  $('.requisitionOrder').html(data.tempform);
                  
                }
                if(data.status=='errorLimit')
                {
                   
                    $('#puit_qty_'+id).val(data.qty);
                    alert('Requisition Quantiy Is Exceeded');
                    return false;
                }
            }
        });
    })
</script>

