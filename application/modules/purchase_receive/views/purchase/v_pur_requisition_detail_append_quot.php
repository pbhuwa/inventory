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
                    <th width="12%"> <?php echo $this->lang->line('item_code'); ?>  </th>
                    <th width="25%"> <?php echo $this->lang->line('item_name'); ?> </th>
                     <th width="10%"><?php echo $this->lang->line('qty'); ?></th>
                    <th width="10%"> <?php echo $this->lang->line('rate'); ?> </th>
                    <th width="10%"> <?php echo $this->lang->line('dis'); ?></th>
                    <th width="10%"> <?php echo $this->lang->line('dis_amt'); ?></th>
                    <th width="10%"> <?php echo $this->lang->line('vat'); ?></th>
                    <th width="10%"> <?php echo $this->lang->line('net_rate'); ?></th>
                      
            <?php if(!empty($detail_list)) { ?> <th width="5%"> <?php echo $this->lang->line('action'); ?> </th> <?php } ?>
            </tr>
        </thead>
        <tbody id="purchaseDataBody" class="requisitionOrder loadedItems">
            <?php
            // echo "<pre>";

            // print_r($detail_list);
            // die();

                if(!empty($detail_list)):
                    $i=1;foreach($detail_list as $key=>$prd):

            ?>
                 <tr class="stockBdy" id="stockBdy_1" data-id='1'>
                    <td>
                        <input type="text" class="form-control sno" id="s_no_<?php echo $i; ?>" value="<?php echo $i; ?>" readonly/>
                    </td>
                    <td>
                        <input type="text" class="form-control" id="item_code<?php echo $key+1; ?>" value="<?php echo $prd->itemcode; ?>" readonly disabled>
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
                              <input type="text" class="form-control itemname" id="itemname_1" name="itemname[]"  data-id='1' placeholder="Item Name" readonly value="<?php echo $prd_itemname; ?>" />
                             <input type="hidden" class="qude_itemsid" name="qude_itemsid[]" data-id='<?php echo $key+1; ?>' value="<?php echo $prd->itli_itemlistid; ?>" id="itemid_<?php echo $key+1; ?>">
                              <input type="hidden" class="purd_reqdetid" name="purd_reqdetid[]" data-id='<?php echo $key+1; ?>' value="<?php echo $prd->purd_reqdetid; ?>" id="purd_reqdetid_<?php echo $key+1; ?>">
                        </div>
                    </td>
                    
                    <td>
                        <input type="text" class="form-control qty" id="itemqty_<?php echo $i; ?>" name="qude_qty[]"  data-id='<?php echo $i; ?>' value="1" readonly="true">
                    </td>

                    <td>
                        <input type="hidden" data-id='<?php echo $i; ?>' value="" id="discount_amt_<?php echo $i; ?>" class="discountamt" >
                            <input type="hidden" data-id='<?php echo $i; ?>' value="" id="tax_amt_<?php echo $i; ?>" class="taxamt" >

                          <input type="text" class="form-control float calculateamt qude_rate arrow_keypress" data-fieldid="qude_rate" name="qude_rate[]" value="0" id="qude_rate_<?php echo $i; ?>" data-id='<?php echo $i; ?>' > 
                    </td>
                    <td>
                      <input type="text" class="form-control float qude_discountpc calculateamt arrow_keypress" name="qude_discountpc[]" data-fieldid="qude_discountpc" value="0"  id="qude_discountpc_<?php echo $i; ?>" data-id='<?php echo $i; ?>'  />
                    </td>
                    <td> 
                        <input type="text" class="form-control float qude_discount_amt arrow_keypress" name="qude_discount_amt[]" data-fieldid="qude_discount_amt"  id="qude_discount_amt_<?php echo $i; ?>" data-id='<?php echo $i; ?>' value="0" /> 
                    </td>
                    <td>
                         <input type="text" class="form-control float calculateamt qude_vatpc arrow_keypress"  data-fieldid="qude_vatpc" name="qude_vatpc[]"   id="qude_vatpc_<?php echo $i; ?>" value="0" data-id='<?php echo $i; ?>' value="0" /> 
                    </td>
                    <td>
                       <input type="text" class="form-control float totalamount qude_netrate arrow_keypress" name="qude_netrate[]" data-fieldid="qude_netrate" value="0"  id="qude_netrate_<?php echo $i; ?>" data-id='<?php echo $i; ?>' /> 
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
                    $(this).find('.itemsid').attr("id","itemsid_"+vali);
                    $(this).find('.itemsid').attr("data-id",vali);
                    $(this).find('.itemname').attr("id","itemname_"+vali);
                    $(this).find('.itemname').attr("data-id",vali);
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
<script type="text/javascript">
    /*
     $(document).off('keyup keydown','.qude_rate');
        $(document).on('keyup keydown','.qude_rate',function(e){
 // e.preventDefault();
        var dataid=$(this).data('id');
        // alert(dataid);
        var countrate=$('.qude_rate').length;
        counter=0;
      
        if(e.which==40)
        {   
           
            counter=dataid+1;
            $('#qude_rate_'+counter).focus();
             e.preventDefault();
        }

        if(e.which==38)
        {
          
            counter=dataid-1;
            $('#qude_rate_'+counter).focus();
              e.preventDefault();
        }

    })
    */
</script>