<style type="text/css">
    .stock-limit{
        width: 240px;
        float: right;
    }
    .index_chart li div.stock_limit{
        background-color: #fbbe4e;
    }
</style>
<?php $storeid=!empty($pending_list[0]->rema_reqtodepid)?$pending_list[0]->rema_reqtodepid:'1';
$mattypeid=!empty($pending_list[0]->rema_mattypeid)?$pending_list[0]->rema_mattypeid:'1';
 ?>
<div class="list_c2 label_mw125">

        <div class="col-md-12 col-xs-12">
            <table class="table dataTable dt_alt purs_table" id="Dttable">
                <thead>
                    <tr>
                        <th scope="col" width="5%"><?php echo $this->lang->line('sn'); ?></th>
                        <th scope="col" width="15%"><?php echo $this->lang->line('item_code'); ?> </th>
                        <th scope="col" width="15%"><?php echo $this->lang->line('item_name'); ?></th>
                         <th scope="col" width="10%"><?php echo $this->lang->line('stock_quantity'); ?></th>
                        <th scope="col" width="10%"><?php echo $this->lang->line('unit'); ?></th>
                        <th scope="col" width="8%"><?php echo $this->lang->line('qty'); ?></th>
                        <th scope="col" width="15%"><?php echo $this->lang->line('remarks'); ?></th>
                         <th scope="col" width="15%"><?php echo $this->lang->line('required_date'); ?></th>
                        <th scope="col" width="5%"><?php echo $this->lang->line('action'); ?></th>
                    </tr>
                </thead>
                <tbody id="orderBody">
                    <?php
                        if(!empty($pending_list)):

                            $i=1;
                            foreach($pending_list as $list):

                                    if(ITEM_DISPLAY_TYPE=='NP'){
                                $req_itemname = !empty($list->itli_itemnamenp)?$list->itli_itemnamenp:$list->itli_itemname;
                            }else{ 
                                $req_itemname = !empty($list->itli_itemname)?$list->itli_itemname:'';
                            }
                            // if($list->rede_remqty != 0 && $list->rede_qtyinstock != 0):
                            if($list->rede_remqty != 0):
                               $qty_in_stock= (!empty($list->stockqty)?$list->stockqty:0);
                               $qty_rem=!empty($list->rede_remqty)?$list->rede_remqty:0;
                               if($qty_rem>$qty_in_stock)
                               {
                                $issue_qty=$qty_in_stock;
                                $my_rem_qty=$qty_rem-$qty_in_stock;
                                $limitedstockClass='limitedstock';
                               }
                               else
                               {
                                $issue_qty=$qty_rem;
                                $limitedstockClass='';
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
                        <tr class="orderrow <?php echo $limitedstockClass .' '.  $stk_zero; ?>" id="orderrow_<?php echo $i;?>" data-id="<?php echo $i; ?>">
                            <td data-label="S.No.">
                                <input type="text" class="form-control s_no" name="s_no[]" id="s_no_<?php echo $i;?>" value="<?php echo $i;?>" data-id='<?php echo $i; ?>' readonly/>

                                <input type="hidden" name="rede_reqdetailid[]" class="reqdetailid" id="reqdetailid_<?php echo $i;?>" value="<?php echo !empty($list->rede_reqdetailid)?$list->rede_reqdetailid:'';?>" data-id="<?php echo $i; ?>" />

                                <input type="hidden" name="sade_unitrate[]" class="unitrate" id="unitrate_<?php echo $i; ?>" value="<?php echo !empty($list->itli_salesrate)?$list->itli_salesrate:'';?>" data-id="<?php echo $i;?>" />
                                <input type="hidden" name="my_rem_qty[]" class="my_rem_qty" id="my_remqty_<?php echo $i; ?>" value="<?php echo $my_rem_qty; ?>">
                            </td>
                            <td data-label="Items Code">
                                  <div class="dis_tab"> 
                                <input type="hidden" class="itemsid" id="itemsid_<?php echo $i;?>" name="rede_itemsid[]" data-id='<?php echo $i; ?>' value="<?php echo !empty($list->itli_itemlistid)?$list->itli_itemlistid:'';?>"/>

                                <input type="text" class="form-control itemcode" id="itemcode_<?php echo $i; ?>" data-id='<?php echo $i; ?>' value="<?php echo !empty($list->itli_itemcode)?$list->itli_itemcode:'';?>" readonly />
                                <a href="javascript:void(0)" class="btnitem btn btn-sm btn-default table-cell width_30 view" data-heading='Item List' data-viewurl='<?php echo base_url('stock_inventory/item/list_item_with_stock_requisition'); ?>' data-id='<?php echo $i; ?>' id="view_<?php echo $i; ?>" data-storeid='<?php echo $storeid; ?>' data-type="<?php echo $mattypeid ?>"><strong>...</strong></a>
                                &nbsp
                                <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading='Item Entry' data-viewurl='<?php echo base_url('stock_inventory/item/item_entry/modal'); ?>' data-id='<?php echo $i; ?>' id="view_<?php echo $i; ?>" data-storeid='<?php echo $storeid; ?>'  data-type="<?php echo $mattypeid ?>" >+</a></div></td>
                            <td data-label="Items Name">
                                <input type="text" class="form-control itemname" id="itemname_<?php echo $i; ?>" name="sade_itemsname[]" data-id='<?php echo $i; ?>' value="<?php echo htmlspecialchars($req_itemname, ENT_QUOTES);?>" readonly/>
                            </td>
                            <td data-label="Stock Qty">
                                <input type="text" class="form-control required_field qtyinstock" id="qtyinstock_<?php echo $i;?>" name="qtyinstock[]" data-id='<?php echo $i; ?>' value="<?php echo sprintf('%g',$qty_in_stock);?>" readonly />
                            </td>
                            <td data-label="Unit">
                                <input type="text" class="form-control unit" id="unit_<?php echo $i; ?>" name="unit[]" data-id='<?php echo $i; ?>' value="<?php echo !empty($list->unit_unitname)?$list->unit_unitname:'';?>" readonly/>
                            </td>
                             <td data-label="Qty">
                                <input type="text" class="form-control required_field remqty" id="remqty_<?php echo $i; ?>" name="rede_qty[]" data-id='<?php echo $i; ?>' value="<?php echo !empty($list->rede_remqty)?sprintf('%g',$list->rede_remqty):'';?>" />
                            </td>
                            <td  data-label="Remarks">
                                <input type="text" class="form-control remarks" id="remarks_<?php echo $i; ?>" name="sade_remarks[]" data-id='<?php echo $i;?>' value='<?php echo !empty($list->rede_remarks)?$list->rede_remarks:''; ?>'/>
                            </td>
                            <td  data-label="Required Date">
                            <input type="text" name="required_date[]" class="form-control nepali <?php echo DATEPICKER_CLASS; ?> date required_date"  placeholder="Required Date" value="" id="Required_date_<?php echo $i;?>" data-id="<?php echo $i;?>">
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
                <tfoot>
                    <tr class="resp_table_breaker">
                        <td colspan="9">
                            <a href="javascript:void(0)" class="btn btn-primary btnAdd pull-right" data-id="1" id="addOrder_1">
                                <span class="btnChange" id="btnChange_1">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                </span>
                            </a>
                        </td>
                    </tr>
                </tfoot>
            </table>
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
            var limstk_cnt=$('.limitedstock').length;
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
                var limstk_cnt=$('.limitedstock').length;
                $('#stock_limit').html(limstk_cnt);
                },1100);
            }
        }
    })
</script>
