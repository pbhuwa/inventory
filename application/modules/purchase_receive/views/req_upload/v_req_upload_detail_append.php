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
                <th width="5%"> <?php echo $this->lang->line('sn'); ?> </th>
                <th width="30%"> <?php echo $this->lang->line('item_name'); ?>  </th>
                <th width="18%"> <?php echo $this->lang->line('manufacturer'); ?> </th>
                <th width="5%"><?php echo $this->lang->line('qty'); ?></th>
                <th width="8%"><?php echo $this->lang->line('size'); ?></th>
                <th width="8%"> <?php echo $this->lang->line('rate'); ?> </th>
                <th width="8%"> <?php echo $this->lang->line('vat'); ?><input type="text" class="form-control" id="allvat"> </th>
                <th width="10%"> <?php echo $this->lang->line('total_amount'); ?> </th>
                <th width="10%"> <?php echo $this->lang->line('remarks'); ?></th>
                      
            <?php if(!empty($detail_list)) { ?> <th width="5%"> <?php echo $this->lang->line('action'); ?> </th> <?php } ?>
            </tr>
        </thead>
        <tbody id="purchaseDataBody" class=" loadedItems">
            <?php
            // echo "<pre>";

            // print_r($detail_list);
            // die();

                if(!empty($detail_list)):
                    $i=1;foreach($detail_list as $key=>$prd):

            ?>
                <tr class="orderrow" id="orderrow_<?php echo $i;?>" data-id='<?php echo $i;?>'>
                    <td>
                        <input type="text" class="form-control s_no" id="s_no_<?php echo $i; ?>" data-id='<?php echo $i; ?>' value="<?php echo $i; ?>" readonly/>
                    </td>
                    <td>
                        <input type="hidden" name="itemid[]" value="<?php echo $prd->reud_reudid; ?>">
                        <input type="text" class="form-control itemname" id="itemname_<?php echo $key+1; ?>" data-id='<?php echo $i; ?>' name="ured_itemname[]" value="<?php echo $prd->reud_itemname; ?>" title="<?php echo $prd->reud_itemname; ?>" readonly />
                    </td>
                    
                    <td>
                        <input type="text" class="form-control manufacturer" id="manufacturer_<?php echo $i; ?>" name="ured_manufacturer[]"  data-id='<?php echo $i; ?>' value="<?php echo $prd->reud_manufacturer; ?>" title="<?php echo $prd->reud_manufacturer; ?>" readonly="true">
                    </td>

                    <td>
                        <input type="text" class="form-control qty" id="qty_<?php echo $i; ?>" name="ured_qty[]"  data-id='<?php echo $i; ?>' value="<?php echo $prd->reud_qty; ?>" readonly="true">
                    </td>

                    <td>
                        <input type="text" class="form-control size" id="size_<?php echo $i; ?>" name="ured_size[]"  data-id='<?php echo $i; ?>' value="<?php echo $prd->reud_size; ?>" readonly="true">
                    </td>

                    <td>
                        <input type="text" class="form-control arrow_keypress calamt" id="rate_<?php echo $i; ?>" name="ured_rate[]" data-id='<?php echo $i; ?>' value="<?php echo !empty($prd->reud_rate)?$prd->reud_rate:0; ?>" />
                    </td>
                    <td>
                        <input type="text" class="form-control arrow_keypress calamt vatval" id="vat_<?php echo $i; ?>" name="ured_vatpc[]" data-id='<?php echo $i; ?>' value="" />
                    
                    <input type="hidden" name="ured_vatamt[]" id="vatamt_<?php echo $i; ?>" value="" >
                    </td>




                    <td>
                        <input type="text" class="form-control arrow_keypress totalamount" id="totalamount_<?php echo $i; ?>" name="ured_totalamount[]" data-id='<?php echo $i; ?>' value="0"/>
                    </td>

                    <td>
                        <input type="text" class="form-control arrow_keypress remarks" id="remarks_<?php echo $i; ?>" name="ured_remarks[]" data-id='<?php echo $i; ?>' value="<?php echo $prd->reud_remarks; ?>">
                    </td>
                
                    <td>
                        <a href="javascript:void(0)" class="btn btn-sm btn-danger btnRemove" id="btnRemove_<?php echo $key+1; ?>" data-id='<?php echo $key+1; ?>'>
                            <i class="fa fa-remove"></i>
                        </a> 
                        <a href="javascript:void(0)" class="cal_btn" data-id='<?php echo $key+1; ?>' id="cal_<?php echo $key+1; ?>">Cal</a>
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
    $(document).off('click','.btnRemove');
    $(document).on('click','.btnRemove',function(){
        var id=$(this).data('id');
        var whichtr = $(this).closest("tr");
        var conf = confirm('Are Your Want to Sure to remove?');
        if(conf){
            var trplusOne = $('.orderrow').length+1;
           
            whichtr.remove(); 
            setTimeout(function(){
                $(".orderrow").each(function(i,k) {
                    var vali=i+1;
                    $(this).attr("id","orderrow_"+vali);
                    $(this).attr("data-id",vali);    
                    $(this).find('.s_no').attr("id","s_no_"+vali);
                    $(this).find('.s_no').attr("value",vali);
                    $(this).find('.itemname').attr("id","itemname_"+vali);
                    $(this).find('.itemname').attr("data-id",vali);
                    $(this).find('.manufacturer').attr("id","manufacturer_"+vali);
                    $(this).find('.manufacturer').attr("data-id",vali);
                    $(this).find('.qty').attr("id","qty_"+vali);
                    $(this).find('.qty').attr("data-id",vali);
                     $(this).find('.size').attr("id","size_"+vali);
                    $(this).find('.size').attr("data-id",vali);

                    $(this).find('.rate').attr("id","rate_"+vali);
                    $(this).find('.rate').attr("data-id",vali);

                    $(this).find('.totalamount').attr("id","totalamount_"+vali);
                    $(this).find('.totalamount').attr("data-id",vali);

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
</script>

<script type="text/javascript">
    $(document).off('keyup change','.calamt');
    $(document).on('keyup change','.calamt',function(){
        var id = $(this).data('id');
        var rate = $('#rate_'+id).val();
        var vat =$('#vat_'+id).val();
        var qty = $('#qty_'+id).val();
        var vatamt=(vat/100)*(rate*qty);
        var total_amt = (rate*qty)+vatamt;
        $('#vatamt_'+id).val(vatamt);

        $('#totalamount_'+id).val(total_amt);
    });
</script>

<script type="text/javascript">
    $(document).off('keyup change','#allvat');
    $(document).on('keyup change','#allvat',function(e){
        var vatval=$(this).val();
        $(".vatval").each(function() { 
         $(this).val(vatval);
         // $('.calamt').change();
     });
    });

$(document).off('click','.cal_btn');
$(document).on('click','.cal_btn',function(e){
 var id = $(this).data('id');
var rate = $('#rate_'+id).val();
var vat =$('#vat_'+id).val();
var qty = $('#qty_'+id).val();
var vatamt=(vat/100)*(rate*qty);
var total_amt = (rate*qty)+vatamt;
$('#vatamt_'+id).val(vatamt.toFixed(2));

$('#totalamount_'+id).val(total_amt.toFixed(2));

})

 $(document).off('click','#all_amt_calculate');
    $(document).on('click','#all_amt_calculate',function(e){
        $('.cal_btn').click();
     });

</script>