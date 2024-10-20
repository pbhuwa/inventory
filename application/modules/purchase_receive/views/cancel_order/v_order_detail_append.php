<style type="text/css">
    .stock-limit{
        width: 240px;
        float: right;
    }
    .index_chart li div.stock_limit{
        background-color: #fbbe4e;
    }
</style>
<!-- <div class="row">
    <div class="col-md-6"></div>
    <div class="col-md-6">

       <div class="stock-limit white-box noborder">
                <ul class="index_chart">
                    <li>
                        <div class="pending"></div><a href="javascript:void(0)" data-approvedtype="pending" class="stock_limit font-xs"> Stock Limit</a> 
                        <span id="stock_limit" class="blink">0</span>
                    </li>
                    <li>
                       <a href="javascript:void(0)"  class="zero_stk_remove font-xs"> Remove Zero Stock</a> 
                        
                    </li>
                    <div class="clearfix"></div>
                    
                </ul>
            </div>
    </div>
</div> -->
<div class="list_c2 label_mw125">
    <div class="form-group row resp_xs">
        <div class="col-md-12 col-xs-12">
            <table class="table table-bordered dataTable dt_alt res_vert_table" id="Dttable">
                <thead>
                    <tr>
                        <th width="5%"> <?php echo $this->lang->line('sn'); ?> </th>
                        <th width="10%"><?php echo $this->lang->line('item_code'); ?> <span class="required">*</span></th>
                        <th width="25%"><?php echo $this->lang->line('item_name'); ?></th>
                        <th width="10%"><?php echo $this->lang->line('unit'); ?></th>
                        <th width="10%"><?php echo $this->lang->line('odr_qty'); ?></th>
                        <th width="10%"><?php echo $this->lang->line('rate'); ?></th>
                        <th width="10%"><?php echo $this->lang->line('total'); ?></th>
                        <th width="25%"><?php echo $this->lang->line('remarks'); ?></th>
                    </tr>
                </thead>
                <tbody id="pendinglist">
                    <?php
                        if(!empty($detail_list)):
                            $i=1;foreach($detail_list as $key=>$cd):

                    ?>
                         <tr class="stockBdy" id="stockBdy_1" data-id='1'>
                            <td>
                                <input type="text" class="form-control sno" id="s_no_1" value="<?php echo $key+1; ?>" readonly/>
                            </td>
                            <td>
                                <input type="hidden"  id="pude_puordeid_1" name="pude_puordeid[]" data-id='1' value="<?php echo !empty($cd->pude_puordeid)?$cd->pude_puordeid:'';?>">
                                <input type="hidden"  id="itemsid_1" name="itemsid[]" data-id='1' value="<?php echo !empty($cd->pude_itemsid)?$cd->pude_itemsid:'';?>">
                                <input type="text" class="form-control itemcode enterinput " id="itemcode_1" name="itemcode[]"  data-id='1' data-targetbtn='view' value="<?php echo !empty($cd->itemcode)?$cd->itemcode:'';?>" readonly>
                            </td>
                            <td> 
                                <input type="text" class="form-control itemname" id="itemname_1" name="itemname[]"  data-id='1' value="<?php echo !empty($cd->itemname)?$cd->itemname:'';?>" readonly>
                            </td>
                            <td> 
                                <input type="text" class="form-control unitname" id="unitname_1" name="unitname[]"  data-id='1' value="<?php echo !empty($cd->unit_unitname)?$cd->unit_unitname:'';?>" readonly>
                            </td>
                            <td> 
                                <input type="text" class="form-control number quantity" name="quantity[]"   id="quantity_1" data-id='1' readonly="true" value="<?php echo !empty($cd->quantity)?$cd->quantity:0;?>" readonly> 
                            </td>
                            <td> 
                                <input type="text" class="form-control number rate" name="rate[]"   id="rate_1" data-id='1' readonly="true" value="<?php echo !empty($cd->rate)?$cd->rate:0;?>" readonly> 
                            </td>
                            <td> 
                                <input type="text" class="form-control amount" name="amount[]"   id="amount_1" data-id='1' readonly="true" value="<?php echo !empty($cd->pude_amount)?$cd->pude_amount:0;?>" readonly> 
                            </td>
        
                            <td> 
                                <input type="text" class="form-control remarks " id="remarks_1" name="remarks[]"  data-id='1' value="<?php echo !empty($cd->remarks)?$cd->remarks:''; ?>" > 
                            </td>
                        </tr>  
                        </tr>
                        <?php
                            
                            $i++;
                            endforeach;
                        endif;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
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