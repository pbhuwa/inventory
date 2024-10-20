
<?php

                if(!empty($detail_list)):
                    $i=1;foreach($detail_list as $key=>$prd):

            ?>
                 <tr class="orderrow orderrow_<?php echo $purchasereqid; ?>" id="orderrow_<?php echo $key+1; ?>" data-id='<?php echo $key+1; ?>'>
                    <td>
                        <input type="text" class="form-control s_no" id="s_no_<?php echo $key+1; ?>" value="<?php echo $key+1; ?>" readonly disabled>
                    </td>
                    <td>
                      <input type="text" class="form-control itemscode " id="itemscode_<?php echo $key+1; ?>" data-id='<?php echo $key+1; ?>'value="<?php echo $prd->itemcode; ?>" readonly />
                    </td>
                    <td>
                        <div class="dis_tab"> 
                             <?php 
                                if(ITEM_DISPLAY_TYPE=='NP'){
                                    $prd_itemname = !empty($prd->itemnamenp)?$prd->itemnamenp:$prd->itemname;
                                }else{ 
                                    $prd_itemname = !empty($prd->itemname)?$prd->itemname:'';
                                }
                                // echo $prd_itemname;
                            ?>
                            <input type="text" class="form-control itemname enterinput " id="itemname_<?php echo $key+1; ?>" name="itemname[]"  data-id='<?php echo $key+1; ?>' data-targetbtn='view' value="<?php  echo htmlentities(stripslashes(utf8_decode($prd_itemname))); ?>" readonly />
                            <input type="hidden" class="qude_itemsid" name="qude_itemsid[]" data-id='<?php echo $key+1; ?>' id="qude_itemsid_<?php echo $key+1; ?>" value="<?php echo $prd->itli_itemlistid; ?>">
                           
                            <input type="hidden" class="purd_reqdetid" name="purd_reqdetid[]" data-id='<?php echo $key+1; ?>' value="<?php echo $prd->purd_reqdetid; ?>" id="purd_reqdetid_<?php echo $key+1; ?>">
                            <input type="hidden" class="pude_orderid" name="pude_orderid[]" data-id='<?php echo $key+1; ?>' value="" id="pude_orderid_<?php echo $key+1; ?>">
                           
                        </div>
                    </td>
                    <td>  
                        <input type="text" class="form-control puit_unitid" id="puit_unitid_<?php echo $key+1; ?>" name="puit_unitid[]"  data-id='<?php echo $key+1; ?>' value="<?php echo $prd->purd_unit; ?>" readonly />
                    </td>
                    <?php $tot = ($prd->purd_remqty)*($prd->rate); ?>
                    <td>
                        <input type="text" class="form-control multiInsert float stock_qty" name="stock_qty[]" id="stock_qty_<?php echo $key+1; ?>" data-id="<?php echo $key+1; ?>" placeholder="Stock Qty" readonly="true" value="<?php echo sprintf('%g',$prd->purd_stock); ?>">
                    </td>
                    <td>
                        <input type="text" class="form-control multiInsert float calculateamt puit_qty arrow_keypress required_field" data-fieldid="puit_qty" name="puit_qty[]" id="puit_qty_<?php echo $key+1; ?>" data-id="<?php echo $key+1; ?>" value="<?php echo sprintf('%g',$prd->purd_remqty); ?>">
                    </td>
                    <td>
                        <input type="text" class="form-control puit_unitprice float multiInsert calculateamt puit_unitprice arrow_keypress" data-fieldid="puit_unitprice" name="puit_unitprice[]" id="puit_unitprice_<?php echo $key+1; ?>" data-id="<?php echo $key+1; ?>"  value="<?php echo $prd->rate; ?>">
                    </td>
                    <td>
                        <input type="text" name="discountpc[]" class="form-control float calculateamt discountpc arrow_keypress" data-fieldid="discountpc" placeholder="Discount Pc" value="0" id="discountpc_<?php echo $key+1; ?>" data-id="<?php echo $key+1; ?>">
                    </td>
                    <td>
                        <input type="text" class="form-control float multiInsert calculateamt puit_taxid vatpc arrow_keypress" data-fieldid="puit_taxid" name="puit_taxid[]" id="puit_taxid_<?php echo $key+1; ?>" data-id="<?php echo $key+1; ?>" vlue="0">
                    </td>
                    <td>
                        <input type="text" class="form-control totalamount float multiInsert puit_total" name="puit_total[]" id="puit_total_<?php echo $key+1; ?>" value="<?php echo $tot; ?>" data-id="<?php echo $key+1; ?>" readonly>
                    </td>
           
                    <td>
                        <input type="text" name="tender_no[]" class="form-control float"  placeholder="Tender Number" value="" id="tender_no_<?php echo $key+1; ?>" data-id="<?php echo $key+1; ?>">
                    </td>
                    <td>
                        <input type="text" class="form-control jump_to_add multiInsert idfornot" name="description[]" id="description_<?php echo $key+1; ?>" data-id="<?php echo $key+1; ?>" placeholder="Remarks" value="<?php echo $prd->purd_remarks; ?>">
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


       
