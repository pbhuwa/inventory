<style type="text/css">
    .stock-limit{
        width: 240px;
        float: right;
    }
    .index_chart li div.stock_limit{
        background-color: #fbbe4e;
    }
</style>

<div class="list_c2 label_mw125">
    <div class="form-group row resp_xs">
        <div class="col-md-12 col-xs-12">
            <table class="table table-bordered dataTable dt_alt res_vert_table" id="Dttable">
                <thead>
                    <tr>
                        <th width="2%"><?php echo $this->lang->line('sn'); ?></th>
                       <th width="12%"><?php echo $this->lang->line('item_code'); ?></th>
                       <th width="18%"><?php echo $this->lang->line('item_name'); ?></th>
                       <th width="5%"><?php echo $this->lang->line('unit'); ?> </th>
                       <th width="5%"><?php echo $this->lang->line('qty'); ?></th>
                       <th width="8%"><?php echo $this->lang->line('rate'); ?></th>
                       <th width="5%"><?php echo $this->lang->line('cc'); ?></th>
                       <th width="5%"><?php echo $this->lang->line('dis'); ?></th>
                       <th width="5%"><?php echo $this->lang->line('vat'); ?></th>
                       <th width="8%"><?php echo $this->lang->line('amount'); ?></th>
                       <th width="10%"><?php echo $this->lang->line('description'); ?></th>
                       <th width="5%"><?php echo $this->lang->line('action'); ?></th> 
                    </tr>
                </thead>
                <tbody id="pendinglist">
                    <?php
                        if(!empty($pending_list)):
                            //echo "<pre>"; print_r($pending_list); die;

                            $i=1;
                            foreach($pending_list as $key=> $list):

                                    if(ITEM_DISPLAY_TYPE=='NP'){
                    $req_itemname = !empty($list->itli_itemnamenp)?$list->itli_itemnamenp:$list->itli_itemname;
                }else{ 
                    $req_itemname = !empty($list->itli_itemname)?$list->itli_itemname:'';
                }
                            // if($list->rede_remqty != 0 && $list->rede_qtyinstock != 0):
                            if($list->rede_remqty != 0):
                               $qty_in_stock= (int) (!empty($list->stockqty)?$list->stockqty:0);
                               $qty_rem=!empty($list->rede_remqty)?$list->rede_remqty:0;
                               if($qty_rem>$qty_in_stock)
                               {
                                $issue_qty=(int) $qty_in_stock;
                                $my_rem_qty=$qty_rem-$qty_in_stock;
                                $limited_stockClass='limited_stock';
                               }
                               else
                               {
                                $issue_qty=$qty_rem;
                                $limited_stockClass='';
                                $my_rem_qty=0;
                               }
                               if($qty_in_stock==0)
                               {
                                $stk_zero='stk_zero';
                               }else
                               {
                                 $stk_zero='';
                               }

                    ?>
                        <tr class="orderrow <?php echo $limited_stockClass .' '.  $stk_zero; ?>" id="orderrow_<?php echo $i;?>" data-id="<?php echo $i; ?>">
                            <td data-label="S.No.">
                                <input type="text" class="form-control s_no" name="s_no[]" id="s_no_<?php echo $i;?>" value="<?php echo $i;?>" data-id='<?php echo $i; ?>' readonly/>
                                <input type="hidden" name="masterid" value="<?php echo !empty($list->rede_reqmasterid)?$list->rede_reqmasterid:''; ?>">
                                <input type="hidden" class="receiveddetailid" name="receiveddetailid[]" id="receiveddetailid_<?php echo $key+1;?>" value="<?php echo !empty($list->recd_receiveddetailid)?$list->recd_receiveddetailid:'';?>"/>

                             <!--    <input type="hidden" name="sade_unitrate[]" class="unitrate" id="unitrate_<?php echo $i; ?>" value="<?php echo !empty($list->itli_salesrate)?$list->itli_salesrate:'';?>" data-id="<?php echo $i;?>" />
                                <input type="hidden" name="my_rem_qty[]" class="my_rem_qty" id="my_remqty_<?php echo $i; ?>" value="<?php echo $my_rem_qty; ?>"> -->
                            </td>
                            <td data-label="Items Code">
                                <input type="hidden" class="itemsid" id="itemsid_<?php echo $i;?>" name="trde_itemsid[]" data-id='<?php echo $i; ?>' value="<?php echo !empty($list->itli_itemlistid)?$list->itli_itemlistid:'';?>"/>

                                <input type="text" class="form-control itemcode" id="itemcode_<?php echo $i; ?>" data-id='<?php echo $i; ?>'  name="puit_barcode[]" value="<?php echo !empty($list->itli_itemcode)?$list->itli_itemcode:'';?>" readonly /></td>
                                
                            <td data-label="Items Name">
                                <input type="text" class="form-control itemname" id="itemname_<?php echo $i; ?>" name="itemname[]" data-id='<?php echo $i; ?>' value="<?php echo $req_itemname;?>" readonly/>
                                <input type="hidden" class="eachsubtotal" name="eachsubtotal[]" id="eachsubtotal_<?php echo $key+1; ?>" >
                                <input type="hidden" name="disamt[]" value="" id="disamt_<?php echo $key+1; ?>" class="disamt calamt"> 
                                <input type="hidden" name="vatamt[]" value="" id="vatamt_<?php echo $key+1; ?>" class="vatamt">
                            </td>
                            <td data-label="Unit">
                                <input type="text" class="form-control unit" id="unit_<?php echo $i; ?>" name="unit[]" data-id='<?php echo $i; ?>' value="<?php echo !empty($list->unit_unitname)?$list->unit_unitname:'';?>" readonly/>
                            </td>
                            <td><input type="text" class="form-control number puit_qty calamt" name="puit_qty[]" value="<?php echo !empty($list->rede_remqty)?$list->rede_remqty:'';?>" data-id='<?php echo $key+1; ?>' id="puit_qty_<?php echo $key+1; ?>" placeholder="Qty">
                            </td>
                            <td>
                                <input type="text" class="form-control puit_unitprice float calamt" name="puit_unitprice[]" id="puit_unitprice_<?php echo $key+1; ?>" value="<?php echo !empty($list->itli_purchaserate)?$list->itli_purchaserate:'0'; ?>"  data-id='<?php echo $key+1; ?>' placeholder="Rate">
                                <input type="hidden" class="form-control unitprice float" name="unitprice[]" id="unitprice_<?php echo $key+1; ?>" value="0"  data-id='1' placeholder="Rate">
                            </td>
                            <td>
                                <input type="text" class="form-control number calamt eachcc" name="cc[]" id="cc_<?php echo $key+1; ?>" value=""  data-id='<?php echo $key+1; ?>' placeholder="CC">
                            </td>
                            <td>
                                <input type="text" class="form-control discount float calamt " name="discount[]" id="discount_<?php echo $key+1; ?>"  value=""  data-id='<?php echo $key+1; ?>' placeholder="Dis">

                            </td>
                            <td>
                                <input type="text" class="form-control float calamt idfornot vat" name="vat[]" id="vat_<?php echo $key+1; ?>" value=""  data-id='<?php echo $key+1; ?>' placeholder="Vat">
                              
                            </td>
                            <td>
                         <?php $subtotal = ($list->rede_remqty)*($list->itli_purchaserate); ?>
                                <input type="text" name="totalamt[]" class="form-control eachtotalamt" value="<?php echo $subtotal; ?>"  id="totalamt_<?php echo $key+1; ?>" readonly="true"> 
                            </td>
                            <td>
                                <input type="text" class="form-control description" name="description[]" value="" data-id='<?php echo $key+1; ?>' placeholder="Description" id="description_<?php echo $key+1; ?>"> 
                            </td>
                           
                            <td data-label="Action">
                                <a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="<?php echo $i; ?>"  id="addRequistion_<?php echo $i; ?>"><span class="btnChange" id="btnChange_<?php echo $i; ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>
                            </td>
                        </tr>
                        <?php
                            endif;
                            $i++;
                            endforeach;
                        endif;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- <script>
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
</script> -->

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
                    $(this).find('.receiveddetailid').attr("id","receiveddetailid__"+vali);
                    $(this).find('.receiveddetailid').attr("data-id",vali);
                    $(this).find('.itemcode').attr("id","itemcode_"+vali);
                    $(this).find('.itemcode').attr("data-id",vali);
                    $(this).find('.itemsid').attr("id","itemsid_"+vali);
                    $(this).find('.itemsid').attr("data-id",vali);
                    $(this).find('.itemname').attr("id","itemname_"+vali);
                    $(this).find('.itemname').attr("data-id",vali);
                    $(this).find('.puit_unitprice').attr("id","puit_unitprice_"+vali);
                    $(this).find('.puit_unitprice').attr("data-id",vali);
                    $(this).find('.unit').attr("id","unit_"+vali);
                    $(this).find('.unit').attr("data-id",vali);

                    $(this).find('.vat').attr("id","vat_"+vali);
                    $(this).find('.vat').attr("data-id",vali);

                    $(this).find('.unitprice').attr("id","unitprice_"+vali);
                    $(this).find('.unitprice').attr("data-id",vali);

                    $(this).find('.discount').attr("id","discount_"+vali);
                    $(this).find('.discount').attr("data-id",vali);
                    
                    $(this).find('.puit_qty').attr("id","puit_qty_"+vali);
                    $(this).find('.puit_qty').attr("data-id",vali);
                    $(this).find('.disamt').attr("id","disamt_"+vali);
                    $(this).find('.disamt').attr("data-id",vali);
                    $(this).find('.vatamt').attr("id","vatamt_"+vali);
                    $(this).find('.vatamt').attr("data-id",vali);
                    $(this).find('.totalamt').attr("id","totalamt_"+vali);
                    $(this).find('.totalamt').attr("data-id",vali);
                    $(this).find('.eachcc').attr("id","cc_"+vali);
                    $(this).find('.eachcc').attr("data-id",vali);
                    $(this).find('.eachsubtotal').attr("id","eachsubtotal_"+vali);
                    $(this).find('.eachsubtotal').attr("data-id",vali);
                    $(this).find('.eachtotalamt').attr("id","totalamt_"+vali);
                    $(this).find('.eachtotalamt').attr("data-id",vali);
                    $(this).find('.eachcc').attr("id","eachcc_"+vali);
                    $(this).find('.eachcc').attr("data-id",vali);

                    $(this).find('.description').attr("id","description_"+vali);
                    $(this).find('.description').attr("data-id",vali);

                    $(this).find('.btnAdd').attr("id","addOrder_"+vali);
                    $(this).find('.btnAdd').attr("data-id",vali);
                    $(this).find('.btnRemove').attr("id","addOrder_"+vali);
                    $(this).find('.btnRemove').attr("data-id",vali);
                    $(this).find('.btnChange').attr("id","btnChange_"+vali);
                });
            },600);

            setTimeout(function(){
                 $('.calamt').change();
            },800);
           
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