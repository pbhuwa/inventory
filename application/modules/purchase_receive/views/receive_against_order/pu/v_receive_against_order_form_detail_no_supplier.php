<?php

if (!empty($order_detail)) :
    $i = 1;
    foreach ($order_detail as $ko => $ord_det) :
        $order_qty = !empty($ord_det->pude_remqty) ? $ord_det->pude_remqty : '';

        if ($order_qty > 0) :
?>
<tr id="row_<?php echo $i; ?> receivedOrderItem_<?php echo $i; ?>" class="receivedItems">
    <td>
        <input type="text" class="form-control sno noBorderInput" id="sno_<?php echo $ko + 1; ?>"
            value="<?php echo $ko + 1; ?>" readonly />
    </td>
    <td>
        <?php echo $ord_det->itli_itemcode; ?>
        <input type="hidden" class="itemsid" name="itemsid[]" value="<?php echo $ord_det->itli_itemlistid; ?>"
            id="itemsid_<?php echo $i; ?>" />
        <input type="hidden" class="pudeid" name="pudeid[]" value="<?php echo $ord_det->pude_puordeid; ?>"
            id="pudeid_<?php echo $i; ?>" />
    </td>
    <td>
        <?php
                    if (ITEM_DISPLAY_TYPE == 'NP') {
                        echo !empty($ord_det->itli_itemnamenp) ? $ord_det->itli_itemnamenp : $ord_det->itli_itemname;
                    } else {
                        echo !empty($ord_det->itli_itemname) ? $ord_det->itli_itemname : '';
                    }
                    ?>
    </td>
    <!--  <td>
        <input type="text" class="form-control batchno" name="batchno[]" data-id='<?php echo $i; ?>' id="batchno_<?php echo $i; ?>" />
    </td> -->
    <td>
        <?php echo $ord_det->pude_unit; ?>
        <input type="hidden" class="form-control unit" name="unit[]" value="<?php echo $ord_det->pude_unit; ?>"
            data-id="<?php echo $i; ?>" id="unit_<?php echo $i; ?>" readonly />
    </td>
    <td>
        <?php echo sprintf('%g', $ord_det->pude_remqty); ?>
        <input type="hidden" class="order_qty" name="order_qty[]"
            value="<?php echo sprintf('%g', $ord_det->pude_remqty); ?>" id="order_qty_<?php echo $i; ?>">
    </td>
    <td>
        <input type="text" class="form-control float calamt recqty arrow_keypress" name="received_qty[]"
            data-fieldid="recqty" value="0" data-id='<?php echo $i; ?>' id="recqty_<?php echo $i; ?>">
    </td>
    <!--  <td>
        <input type="text" class="form-control number calamt free" name="free[]" value="<?php echo $ord_det->pude_free; ?>" id="free_<?php echo $i; ?>" data-id='<?php echo $i; ?>' >
    </td> -->
    <td>
                <?php
                    if (ORGANIZATION_NAME == 'KU') :
                        $readonly = "";
                    else :
                        $readonly = "readonly";
                    endif;
                    ?>
        <input type="text" class="form-control float calamt rate arrow_keypress" name="rate[]"
            id="rate_<?php echo $i; ?>" value="<?php echo $ord_det->pude_rate; ?>" data-id='<?php echo $i; ?>'
            <?php echo $readonly; ?> />
        <input type="hidden" class="form-control float calamt purchase_rate[]" name="purchase_rate[]"
            id="purchase_rate_<?php echo $i; ?>" value="<?php echo $ord_det->itli_purchaserate; ?>"
            data-id='<?php echo $i; ?>'>
    </td>
    <td>
        <input type="text" class="form-control number calamt cc" name="cc[]" id="cc_<?php echo $i; ?>"
            value="<?php echo '0'; ?>" data-id='<?php echo $i; ?>'>
    </td>
    <td>
        <input type="text" class="form-control float calamt discount discountpc arrow_keypress" name="discount[]"
            data-fieldid="discount" id="discount_<?php echo $i; ?>" value="<?php echo $ord_det->pude_discount; ?>"
            data-id='<?php echo $i; ?>'>
        <input type="hidden" name="disamt[]" value="" id="disamt_<?php echo $i; ?>" class="disamt calamt">
    </td>
    <td>
        <input type="text" class="form-control float calamt vat arrow_keypress" name="vat[]" id="vat_<?php echo $i; ?>"
            data-fieldid="vat" value="<?php echo sprintf('%g', $ord_det->pude_vat); ?>" data-id='<?php echo $i; ?>'>
        <input type="hidden" name="vatamt[]" value="" id="vatamt_<?php echo $i; ?>" class="vatamt calamt">
    </td>
    <td>
        <input type="text" class="form-control eachtotalamt amt" name="amount[]" value="" readonly="readonly"
            id="amt_<?php echo $i; ?>">
        <input type="hidden" class="form-control eachratexqty ratexqty" name="ratexqty[]" value=""
            id="ratexqty_<?php echo $i; ?>" />
    </td>
   
      <td>
        <textarea class="form-control description" name="description[]"
            style="margin: 0px; width: 200px; height: 76px; line-height: 18px;" id="description_<?php echo $i; ?>"
            data-id='<?php echo $i; ?>'><?php echo $ord_det->pude_remarks; ?></textarea>
    </td>
    <td>
                <select class="table-cell form-control select3 budgetopt required_field" name="bugetid[]" id="budgetid-<?php echo $i; ?>">
                    <option value="">--- Select ---</option>
                    <?php if (!empty($budgets_list)) :
                        foreach ($budgets_list as $kb => $buget) :
                    ?>
                            <option value="<?php echo $buget->budg_budgetid; ?>"><?php echo $buget->budg_budgetname; ?></option>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </select>
    </td>
    <td>
            <select name="supplierid[]" class="form-control supplieropt required_field select3" readonly="readonly" id="supplierid_<?php echo $i; ?>">
                    <option value="">---select---</option>
                    <?php
                    if ($supplier_all) :
                        foreach ($supplier_all as $km => $sup) :
                    ?>
                            <option value="<?php echo $sup->dist_distributorid; ?>" ><?php echo $sup->dist_distributor; ?></option>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </select>
    </td>
    <td><input type="text" name="bill_no[]"  class="form-control bill_no_txt required_field"></td>
    <td>
    <input type="text" name="bill_date[]"  class="form-control bill_date_txt required_field <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>" id="bill_date_<?php echo $i; ?>">
    </td>
    <td>
        <a href="javascript:void(0)" class="btn btn-sm btn-danger btnRemove" id="btnRemove_<?php echo $i; ?>"
            data-id='<?php echo $i; ?>'>
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

<script type="text/javascript">
$('.calamt').change();
</script>
<script>
$(document).off('click', '.btnRemove');
$(document).on('click', '.btnRemove', function() {
    var id = $(this).data('id');
    var whichtr = $(this).closest("tr");
    var conf = confirm('Are Your Want to Sure to remove?');
    if (conf) {
        var trplusOne = $('.receivedItems').length + 1;
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
        //         $(this).find('.temperature').attr("id","temperature_"+vali);
        //         $(this).find('.temperature').attr("value",vali);

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
$(document).off('keyup change', '.recqty');
$(document).on('keyup change', '.recqty', function() {
    var id = $(this).data('id');
    var reqqty = $(this).val();
    var avlailqty = $('#order_qty_' + id).val();
    qtynow = parseInt(reqqty);
    avlailqty = parseInt(avlailqty);
    if (qtynow > avlailqty) {
        alert('Received Quantity can not be greater than ordered quantity !!');
        $('#recqty_' + id).val(avlailqty);
        return false;
    }
});

$(document).off('keyup blur', '.vat');
$(document).on('keyup blur', '.vat', function() {
    var id = $(this).data('id');
    var vat = $('#vat_' + id).val();

    // $(".vat").each(function() {
    //     $('.vat').val(vat);
    $('.calamt').change();
    // }
    // });
});
$('.nepdatepicker').nepaliDatePicker({
    npdMonth: true,
    npdYear: true,
    //npdYearCount: 10 // Options | Number of years to show
});

$(document).ready(function(e){
    $('.select3').select2();
})
</script>