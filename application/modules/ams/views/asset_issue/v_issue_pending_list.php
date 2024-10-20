<style type="text/css">
    .stock-limit{
        width: 240px;
        float: right;
    }
    .index_chart li div.stock_limit{
        background-color: #fbbe4e;
    }
    .white-box.noborder ul li {
    padding: 4px !important;
    font-size: 13px !important;
    background: #ff6849 !important;
}
</style>
<div class="row">
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
</div>
<div class="list_c2 label_mw125">
    <div class="form-group row resp_xs">
        <div class="col-md-12 col-xs-12 table-responsive">
            <table class="table table-bordered dataTable dt_alt res_vert_table" id="Dttable">
                <tr>
                    <th scope="col" width="5%"> <?php echo $this->lang->line('sn'); ?></th>
                    <th scope="col" width="10%"> <?php echo $this->lang->line('item_code'); ?></th>
                    <th scope="col" width="15%"><?php echo $this->lang->line('item_name'); ?></th>
                    <th scope="col" width="5%"> <?php echo $this->lang->line('unit'); ?></th>
                    <th scope="col" width="5%"> Req.Qty </th>
                    <th scope="col" width="10%"> <?php echo $this->lang->line('rem_qty'); ?></th>
                    <th scope="col" width="10%"> Store Qty </th>
                    <th scope="col" width="20%"> Assets </th>
                    <th scope="col" width="15%"> <?php echo $this->lang->line('remarks'); ?></th>
                    <th scope="col" width="5%"><?php echo $this->lang->line('action'); ?></th>
                </tr>
            </thead>
                <tbody id="pendinglist">
                    <?php
                        if(!empty($pending_list)):

                            $i=1;
                            foreach($pending_list as $list_key => $list):

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
                                $issue_qty = $qty_in_stock;
                                $my_rem_qty = $qty_rem - $qty_in_stock;
                                $limited_stockClass = 'limited_stock';
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

                                <input type="hidden" name="rede_reqdetailid[]" class="reqdetailid" id="reqdetailid_<?php echo $i;?>" value="<?php echo !empty($list->rede_reqdetailid)?$list->rede_reqdetailid:'';?>" data-id="<?php echo $i; ?>" />

                                <input type="hidden" name="asid_unitrate[]" class="unitrate" id="unitrate_<?php echo $i; ?>" value="<?php echo !empty($list->itli_salesrate)?$list->itli_salesrate:'';?>" data-id="<?php echo $i;?>" />
                                <input type="hidden" name="my_rem_qty[]" class="my_rem_qty" id="my_remqty_<?php echo $i; ?>" value="<?php echo $my_rem_qty; ?>">
                            </td>
                            <td data-label="Items Code">
                                <input type="hidden" class="itemsid" id="itemsid_<?php echo $i;?>" name="asid_itemsid[]" data-id='<?php echo $i; ?>' value="<?php echo !empty($list->itli_itemlistid)?$list->itli_itemlistid:'';?>"/>

                                <input type="text" class="form-control itemcode" id="itemcode_<?php echo $i; ?>" data-id='<?php echo $i; ?>' value="<?php echo !empty($list->itli_itemcode)?$list->itli_itemcode:'';?>" readonly /></td>
                            <td data-label="Items Name">
                                <input type="text" class="form-control itemname" id="itemname_<?php echo $i; ?>" name="asid_itemsname[]" data-id='<?php echo $i; ?>' value="<?php echo $req_itemname;?>" readonly/>
                            </td>
                            <td data-label="Unit">
                                <input type="text" class="form-control unit" id="unit_<?php echo $i; ?>" name="unit[]" data-id='<?php echo $i; ?>' value="<?php echo !empty($list->unit_unitname)?$list->unit_unitname:'';?>" readonly/>
                            </td>
                            <td data-label="Req. Qty">
                                <input type="text" class="form-control required_field reqqty" id="reqqty_<?php echo $i; ?>" name="reqqty[]" data-id='<?php echo $i; ?>' value="<?php echo !empty($list->rede_qty)?$list->rede_qty:'';?>" readonly/>
                            </td>
                            <td data-label="Rem. Qty">
                                <input type="text" class="form-control required_field remqty" id="remqty_<?php echo $i; ?>" name="remqty[]" data-id='<?php echo $i; ?>' value="<?php echo !empty($list->rede_remqty)?$list->rede_remqty:'';?>" readonly/>
                            </td>

                            <td data-label="Stock Qty">
                                <input type="text" class="form-control required_field qtyinstock" id="qtyinstock_<?php echo $i;?>" name="qtyinstock[]" data-id='<?php echo $i; ?>' value="<?php echo $qty_in_stock;?>" readonly />
                            </td>
                           <td data-label="Assets List"> 
                               <select class="form-control assets_list required_field select2assets" multiple="true" id="assets_list_<?php echo $i; ?>" name="assetslist[<?php echo $list_key; ?>][]" data-id=<?php echo $i; ?> >
                                   <?php 
                                   if (!empty($list->asset_list)) {
                                      foreach ( explode(',',$list->asset_list) as $key => $asset) {
                                           $asset_detail = explode('@',$asset); ?>
                                           <option value="<?php echo $asset_detail[0]; ?>">
                                               <?php echo $asset_detail[1]; ?>
                                           </option>
                                   <?php 
                                        } 
                                    }
                                   ?>
                               </select> 
                            </td>   
                            <td  data-label="Remarks">
                                <input type="text" class="form-control remarks" id="remarks_<?php echo $i; ?>" name="asid_remarks[]" data-id='<?php echo $i;?>' value='<?php echo !empty($list->rede_remarks)?$list->rede_remarks:''; ?>'/>
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
    $(document).off('change','.assets_list');
    $(document).on('change','.assets_list',function(){
        
        var rowid = $(this).data('id');
        var selected_assets = $(`#assets_list_${rowid}`).val();
        console.log(selected_assets);
        if(selected_assets == undefined || selected_assets == null)
        {
            selected_assets = [] ;
        }
        var sade_qty = selected_assets.length;
        var qtyinstock = $('#qtyinstock_'+rowid).val();
        var remqty=$('#remqty_'+rowid).val();
        var my_rem_qty=0;

        sade_qty = parseInt(sade_qty);
        qtyinstock = parseInt(qtyinstock);
        remqty = parseInt(remqty);
        my_rem_qty = remqty - sade_qty;
        $('#my_remqty_'+rowid).val(my_rem_qty);

        if(sade_qty > remqty)
        {  var new_asset_list = selected_assets.slice(0,remqty)
            alert('Issue Qty should not exceed Req. qty. Please check it.');
           $(`#assets_list_${rowid}`).val(new_asset_list);
           $(`#assets_list_${rowid}`).select2("val",new_asset_list);
            my_rem_qty=parseInt(remqty)-parseInt(sade_qty);
            $('#my_remqty_'+rowid).val(my_rem_qty);

            return false;
        }

        if(sade_qty > qtyinstock){
            alert('Issue Qty should not exceed stock qty. Please check it.');
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
                    $(this).find('.reqqty').attr("id","reqqty_"+vali);
                    $(this).find('.reqqty').attr("data-id",vali);
                    $(this).find('.qtyinstock').attr("id","qtyinstock_"+vali);
                    $(this).find('.qtyinstock').attr("data-id",vali);
                    $(this).find('.remqty').attr("id","remqty_"+vali);
                    $(this).find('.remqty').attr("data-id",vali);
                    $(this).find('.assets_list').attr("name","assetslist["+i+"][]");
                    $(this).find('.assets_list').attr("id","assets_list_"+vali);
                    $(this).find('.assets_list').attr("data-id",vali);
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