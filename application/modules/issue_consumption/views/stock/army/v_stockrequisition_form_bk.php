 <style>
     .purs_table tbody tr td {
         border: none;
         vertical-align: center;
     }
 </style>

 <?php

    // echo "<pre>";
    // print_r($department);
    // echo "</pre>";
    // die;

    $id = !empty($req_data[0]->rema_reqmasterid) ? $req_data[0]->rema_reqmasterid : '';

    ?>

 <form method="post" id="FormStockRequisition" action="<?php echo base_url('issue_consumption/stock_requisition/save_requisition'); ?>" class="form-material form-horizontal form" data-reloadurl="<?php echo base_url('issue_consumption/stock_requisition/form_stock_requisition' . '/entry'); ?>">

     <input type="hidden" name="id" value="<?php echo !empty($req_data[0]->rema_reqmasterid) ? $req_data[0]->rema_reqmasterid : '';  ?>">

     <div class="form-group">

         <div class="col-md-3">

             <?php $rema_reqno = !empty($req_data[0]->rema_reqno) ? $req_data[0]->rema_reqno : ''; ?>

             <label for="example-text"><?php echo $this->lang->line('req_no'); ?> <span class="required">*</span>:</label>

             <input type="text" class="form-control required_field" name="rema_reqno" id="rema_reqno" value="<?php echo $rema_reqno; ?>" readonly />

         </div>

         <?php

            if (ORGANIZATION_NAME != 'IMCWORLD') :

                $display = 'style="display:block"';

            else :

                $display = 'style="display:none"';

            endif;

            ?>

         <div class="col-md-3" <?php echo $display; ?>>

             <label for="example-text"><?php echo $this->lang->line('choose'); ?> : </label><br>



             <?php $rema_isdep = !empty($req_data[0]->rema_isdep) ? $req_data[0]->rema_isdep : ''; ?>

             <!-- value="issue" <?php if ($rema_isdep == 'Y') echo "checked=checked"; ?> -->



             <?php

                $rema_isdep = !empty($req_data[0]->rema_isdep) ? $req_data[0]->rema_isdep : '';

                if ($rema_isdep) {

                    $issue_checked = "checked ='checked'";

                    if ($rema_isdep == 'Y') {

                        $issue_checked = "checked ='checked'";

                        $transfer_checked = "";
                    } else {

                        $issue_checked = "";

                        $transfer_checked = "checked ='checked'";
                    }
                } else {

                    $issue_checked = "checked ='checked'";

                    $transfer_checked = '';
                }





                ?>

             <input type="radio" class="mbtm_13 chooseReqType" name="rema_isdep" data-reqtype="issue" value="Y" <?php echo $issue_checked; ?> id="chooseReqtypeIss"><?php echo $this->lang->line('issue'); ?>

             &nbsp;&nbsp;&nbsp;

             <!--   <input type="radio" class="mbtm_13 chooseReqType" name="rema_isdep" data-reqtype="transfer" value="N" <?php echo $transfer_checked; ?> id="chooseReqtypeTran" ><?php echo $this->lang->line('stock transfer'); ?> -->

         </div>



         <div class="col-md-3">

             <?php $rema_manualno = !empty($req_data[0]->rema_manualno) ? $req_data[0]->rema_manualno : 0; ?>

             <label for="example-text"><?php echo $this->lang->line('manual_no'); ?> :</label>

             <input type="text" class="form-control" name="rema_manualno" value="<?php echo $rema_manualno; ?>" placeholder="Enter Manual Number">

         </div>



         <div class="col-md-3">

             <?php

                if (DEFAULT_DATEPICKER == 'NP') {

                    $req_date = !empty($req_data[0]->rema_reqdatebs) ? $req_data[0]->rema_reqdatebs : DISPLAY_DATE;
                } else {

                    $req_date = !empty($req_data[0]->rema_reqdatead) ? $req_data[0]->rema_reqdatead : DISPLAY_DATE;
                }

                ?>

             <label for="example-text"><?php echo $this->lang->line('date'); ?>: </label>

             <input type="text" name="rema_reqdate" class="form-control <?php echo DATEPICKER_CLASS; ?> date" placeholder="Requisition Date" value="<?php echo $req_date; ?>" id="requisitionDate">

             <span class="errmsg"></span>

         </div>



         <div class="col-md-3">

             <?php $remareqby = !empty($req_data[0]->rema_reqby) ? $req_data[0]->rema_reqby : ''; ?>

             <label for="example-text"><?php echo $this->lang->line('requested_by'); ?><span class="required">*</span> :</label>

             <!--           <input type="text" class="form-control required_field" name="rema_reqby" value="<?php echo $remareqby; ?>" placeholder="Requested By" autocomplete="off" autofocus="on"> -->

             <input type="text" id="id" autocomplete="off" name="rema_reqby" value="<?php echo $remareqby; ?>" class="form-control searchText" placeholder="Requested By" data-srchurl="<?php echo base_url(); ?>issue_consumption/stock_requisition/list_of_reqby">

             <div class="DisplayBlock" id="DisplayBlock_id"></div>

         </div>

         <div class="col-md-3">

             <?php $depid = !empty($req_data[0]->rema_reqfromdepid) ? $req_data[0]->rema_reqfromdepid : ''; ?>

             <label for="example-text"><?php echo $this->lang->line('from'); ?> <span class="required">*</span>:</label>

             <div class="dis_tab">

                 <select name="rema_reqfromdepid" id="rema_reqfromdepid" class="form-control required_field select2">

                     <option value="">---select---</option>

                     <?php

                        if ($department) :

                            foreach ($department as $km => $dep) :

                        ?>

                             <option value="<?php echo $dep->dept_depid; ?>" <?php if ($depid == $dep->dept_depid) echo "selected=selected"; ?>><?php echo $dep->dept_depname; ?></option>

                     <?php

                            endforeach;

                        endif;

                        ?>

                 </select>



                 <a href="javascript:void(0)" class="table-cell frm_add_btn width_30 refresh_element" data-targetid="rema_reqfromdepid" data-viewurl="<?php echo base_url('settings/department/department_reload'); ?>"><i class="fa fa-refresh"></i></a>



                 <a href="javascript:void(0)" id="hide" name="hide" class="table-cell frm_add_btn width_30 view" data-heading='Department Entry' data-viewurl='<?php echo base_url('settings/department/department_entry/modal'); ?>'><i class="fa fa-plus"></i></a>

             </div>

         </div>



         <div class="col-md-3">

             <label for="example-text"><?php echo $this->lang->line('to'); ?> :</label>

             <?php $storeid = !empty($req_data[0]->rema_reqtodepid) ? $req_data[0]->rema_reqtodepid : ''; ?>

             <select name="rema_reqtodepid" id="rema_reqtodepid" class="form-control select2 getReqNo">

                 <option value="">---select---</option>

                 <?php

                    if (!empty($store_type)) :

                        foreach ($store_type as $km => $store) :

                    ?>

                         <option value="<?php echo $store->eqty_equipmenttypeid; ?>" <?php if ($storeid == $store->eqty_equipmenttypeid) echo "selected=selected"; ?>><?php echo $store->eqty_equipmenttype; ?></option>

                 <?php

                        endforeach;

                    endif;

                    ?>

             </select>

         </div>



         <div class="col-md-3">



         </div>

     </div>

     <div class="clearfix"></div>



     <?php

        if (!empty($req_data)) :

        ?>

     <?php

        endif;

        ?>



     <div class="form-group">

         <div class="table-responsive col-sm-12">

             <table style="width:100%;" class="table dataTable dt_alt purs_table res_vert_table">

                 <thead>

                     <tr>

                         <th scope="col" width="5%"> <?php echo $this->lang->line('sn'); ?>. </th>

                         <th scope="col" width="10%"> <?php echo $this->lang->line('code'); ?> </th>

                         <th scope="col" width="25%"> <?php echo $this->lang->line('particular'); ?> </th>

                         <th scope="col" width="5%"> <?php echo $this->lang->line('unit'); ?> </th>

                         <th scope="col" width="10%"> <?php echo $this->lang->line('req_qty'); ?> </th>

                         <th scope="col" width="15%"><?php echo $this->lang->line('remarks'); ?> </th>

                         <th scope="col" width="5%"> <?php echo $this->lang->line('action'); ?></th>

                     </tr>

                 </thead>

                 <tbody id="orderBody">

                     <?php

                        $j = 1;

                        if (!empty($req_data)) :

                            foreach ($req_data as $req_key => $req_value) :

                        ?>

                             <tr class="orderrow" id="orderrow_<?php echo !empty($req_value->rede_reqdetailid) ? $req_value->rede_reqdetailid : ''; ?>" data-id='<?php echo $j; ?>'>

                                 <td data-label="S.No.">

                                     <input type="text" class="form-control sno" id="s_no_<?php echo $j; ?>" value="<?php echo $j; ?>" readonly />

                                     <input type="hidden" name="rede_reqdetailid[]" class="reqdetailid" id="reqdetailid_<?php echo $j; ?>" value="<?php echo !empty($req_value->rede_reqdetailid) ? $req_value->rede_reqdetailid : ''; ?>" />

                                     <input type="hidden" name="rede_qtyinstock[]" data-id='<?php echo $j; ?>' class="qtyinstock" id="qtyinstock_<?php echo $j; ?>" value="" />



                                     <input type="hidden" name="rede_unitprice[]" data-id='<?php echo $j; ?>' class="unitprice" id="unitprice_<?php echo $j; ?>" value="" />



                                 </td>

                                 <td data-label="Code">

                                     <div class="dis_tab">

                                         <input type="text" class="form-control itemcode enterinput" id="itemcode_<?php echo $j; ?>" name="rede_code[]" data-id='<?php echo $j; ?>' data-targetbtn='view' value="<?php echo !empty($req_value->itli_itemcode) ? $req_value->itli_itemcode : ''; ?>" readonly />

                                         <input type="hidden" class="itemid" name="rede_itemsid[]" data-id='<?php echo $j; ?>' value="<?php echo !empty($req_value->rede_itemsid) ? $req_value->rede_itemsid : ''; ?>" id='itemid_<?php echo $j; ?>'>

                                         <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading='<?php echo $this->lang->line('list_of_items'); ?>' data-viewurl='<?php echo base_url('stock_inventory/item/list_item_with_stock_requisition'); ?>' data-id='<?php echo $j; ?>' id='view_<?php echo $j; ?>'><strong>...</strong></a>&nbsp;

                                         <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view">+</a>

                                     </div>

                                 </td>

                                 <td data-label="Particular">

                                     <?php

                                        if (ITEM_DISPLAY_TYPE == 'NP') {

                                            $req_itemname = !empty($req_value->itli_itemnamenp) ? $req_value->itli_itemnamenp : $req_value->itli_itemname;
                                        } else {

                                            $req_itemname = !empty($req_value->itli_itemname) ? $req_value->itli_itemname : '';
                                        } ?>

                                     <input type="text" class="form-control itemname" id="itemname_<?php echo $j; ?>" data-id='<?php echo $j; ?>' value="<?php echo !empty($req_itemname) ? $req_itemname : ''; ?>" readonly>

                                 </td>

                                 <td data-label="Unit">

                                     <input type="text" class="form-control float rede_unit calculateamt" id="rede_unit_<?php echo $j; ?>" data-id='<?php echo $j; ?>' value="<?php echo !empty($req_value->unit_unitname) ? $req_value->unit_unitname : ''; ?>">

                                     <input type="hidden" class="unitid" name="rede_unit[]" id="unitid_<?php echo $j; ?>" data-id='<?php echo $j; ?>' value="<?php echo !empty($req_value->rede_unit) ? $req_value->rede_unit : ''; ?>" />

                                 </td>

                                 <td data-label="Req. Quantity">

                                     <input type="text" class="form-control float rede_qty calculateamt rede_qty" name="rede_qty[]" id="rede_qty_<?php echo $j; ?>" data-id='<?php echo $j; ?>' value="<?php echo !empty($req_value->rede_qty) ? $req_value->rede_qty : ''; ?>" />

                                 </td>

                                 <td data-label="Remarks">

                                     <input type="text" class="form-control  rede_remarks jump_to_add" id="rede_remarks_<?php echo $j; ?>" name="rede_remarks[]" data-id='<?php echo $j; ?>' value="<?php echo !empty($req_value->rede_remarks) ? $req_value->rede_remarks : ''; ?>" />

                                 </td>

                                 <td data-label="Action">

                                     <div class="actionDiv acDiv2" id="acDiv2_<?php echo $j; ?>"></div>



                                     <?php

                                        if (count($req_data) > 1) :

                                        ?>

                                         <a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="<?php echo $j; ?>" id="addRequistion_<?php echo $j; ?>"><span class="btnChange" id="btnChange_1"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>

                                     <?php

                                        endif;

                                        ?>



                                 </td>

                             </tr>

                         <?php

                                $j++;

                            endforeach;

                        else :

                            ?>

                         <tr class="orderrow" id="orderrow_1" data-id='1'>

                             <td data-label="S.No.">

                                 <input type="text" class="form-control sno" id="s_no_1" value="1" readonly />

                             </td>

                             <td data-label="Code">

                                 <div class="dis_tab">

                                     <input type="text" class="form-control itemcode enterinput" id="itemcode_1" name="rede_code[]" data-id='1' data-targetbtn='view' value="">

                                     <input type="hidden" class="itemid" name="rede_itemsid[]" data-id='1' value="" id="itemid_1">

                                     <input type="hidden" name="rede_qtyinstock[]" data-id='1' class="qtyinstock" id="qtyinstock_1" value="" />

                                     <input type="hidden" name="rede_unitprice[]" data-id='1' class="unitprice" id="unitprice_1" value="" />



                                     <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading='<?php echo $this->lang->line('list_of_items'); ?>' data-viewurl='<?php echo base_url('stock_inventory/item/list_item_with_stock_requisition'); ?>' data-id='1' id="view_1"><strong>...</strong></a>&nbsp;

                                     <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading='<?php echo $this->lang->line('item_entry'); ?>' data-viewurl='<?php echo base_url('stock_inventory/item/item_entry/modal'); ?>' data-id='1' id="view_1">+</a>

                                 </div>

                             </td>

                             <td data-label="Particular">

                                 <input type="text" class="form-control itemname" id="itemname_1" name="" data-id='1' readonly>

                             </td>

                             <td data-label="Unit">

                                 <input type="text" value="" class="form-control float rede_unit calculateamt" id="rede_unit_1" data-id='1' readonly="true">

                                 <input type="hidden" class="unitid" name="rede_unit[]" id="unitid_1" data-id='1' />

                             </td>

                             <td data-label="Req. Quantity">

                                 <input type="text" class="form-control float rede_qty calculateamt rede_qty" name="rede_qty[]" id="rede_qty_1" data-id='1'>

                             </td>

                             <td data-label="Remarks">

                                 <input type="text" class="form-control  rede_remarks jump_to_add " id="rede_remarks_1" name="rede_remarks[]" data-id='1'>

                             </td>

                             <td data-label="Action">

                                 <div class="actionDiv acDiv2" id="acDiv2_1"></div>

                             </td>

                         </tr>

                     <?php endif; ?>



                 </tbody>

                 <tbody>

                     <tr class="resp_table_breaker">

                         <td colspan="7">

                             <a href="javascript:void(0)" class="btn btn-primary btnAdd pull-right" data-id="1" id="addOrder_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-plus" aria-hidden="true"></i></span></a>

                             <div class="clearfix"></div>

                         </td>

                     </tr>

                 </tbody>



             </table>

             <div id="Printable" class="print_report_section printTable">



             </div>

         </div> <!-- end table responsive -->

     </div>

     <div class="form-group">

         <div class="col-md-12">

             <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($req_data) ? 'update' : 'save' ?>' id="btnSubmit"><?php echo !empty($req_data) ? 'Update' : $this->lang->line('save');  ?></button>

             <button type="submit" class="btn btn-info savePrint" data-operation='<?php echo !empty($req_data) ? 'update' : 'save ' ?>' id="btnSubmit" data-print="print"><?php echo !empty($req_data) ? 'Update & Print' : $this->lang->line('save_and_print') ?></button>

         </div>

         <div class="col-sm-12">

             <div class="alert-success success"></div>

             <div class="alert-danger error"></div>

         </div>

     </div>

 </form>

 <script type="text/javascript">
     $(document).off('click', '.btnAdd');
     $(document).on('click', '.btnAdd', function() {

         var id = $(this).data('id');
         var itemid = $('#itemid_' + id).val();
         var qty = $('#qtyinstock_' + id).val();
         var rate = $('#rede_qty_' + id).val();
         var rates = $('#unitprice_' + id).val();

         var trplusOne = $('.orderrow').length + 1;

         var trpluOne = $('.orderrow').length;

         var itemid = $('#itemid_' + id).val();

         var code = $('#itemname_' + trplusOne).val();
         var newitemid = $('#itemid_' + trpluOne).val();

         var reqqty = $('#rede_qty_' + trpluOne).val();

         var reqrate = $('#unitprice_' + trpluOne).val();

         if (newitemid == '')

         {

             $('#itemcode_' + trpluOne).focus();

             return false;

         }

         if (reqqty == 0 || reqqty == '' || reqqty == null)

         {

             $('#rede_qty_' + trpluOne).focus();

             return false;

         }

         var storeid = $("#rema_reqtodepid option:selected").val();

         setTimeout(function() {

             $('.btnitem').attr('data-storeid', storeid);

             $('.btnitem').data('storeid', storeid);

         }, 500);

         if (trplusOne == 2)

         {

             $('.actionDiv').html('<a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="1"  id="addRequistion_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>');

         }

         var template = '';

         template = '<tr class="orderrow" id="orderrow_' + trplusOne + '" data-id="' + trplusOne + '"><td data-label="S.No."><input type="text" class="form-control sno" id="s_no_' + trplusOne + '" value="' + trplusOne + '" readonly/></td><td data-label="Code"> <div class="dis_tab"> <input type="text" class="form-control itemcode enterinput " id="itemcode_' + trplusOne + '" name="rede_code[]" data-id="' + trplusOne + '" data-targetbtn="view" readonly /> <input type="hidden" class="itemid" name="rede_itemsid[]" data-id="' + trplusOne + '" id="itemid_' + trplusOne + '" > <input type="hidden" name="rede_qtyinstock[]" data-id="' + trplusOne + '" class="qtyinstock" id="qtyinstock_' + trplusOne + '" /> <input type="hidden" name="rede_unitprice[]" data-id="' + trplusOne + '" class="unitprice" id="unitprice_' + trplusOne + '" /><a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading="List of Item" data-viewurl="<?php echo base_url('stock_inventory/item/list_item_with_stock_requisition '); ?>" data-id="' + trplusOne + '" id="view_' + trplusOne + '" ><strong>...</strong></a>&nbsp<a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading="Item Entry" data-viewurl="<?php echo base_url('stock_inventory/item/item_entry/modal'); ?>" data-storeid=' + storeid + ' data-id="' + trplusOne + '" id="view_' + trplusOne + '">+</a></div></td><td data-label="Particular"> <input type="text" class="form-control itemname" id="itemname_' + trplusOne + '" name="" data-id="' + trplusOne + '" readonly></td><td data-label="Unit"><input type="text" class="form-control float rede_unit calculateamt" name="" id="rede_unit_' + trplusOne + '" data-id="' + trplusOne + '" > <input type="hidden" class="unitid" name="rede_unit[]" id="unitid_' + trplusOne + '" data-id="' + trplusOne + '"/></td><td data-label="Req. Quantity"><input type="text" class="form-control float rede_qty calculateamt" name="rede_qty[]" id="rede_qty_' + trplusOne + '" data-id=' + trplusOne + ' ></td><td data-label="Remarks"> <input type="text" class="form-control  rede_remarks jump_to_add " id="rede_remarks_' + trplusOne + '" name="rede_remarks[]"  data-id="' + trplusOne + '"> </td><td data-label="Action"> <div class="actionDiv acDiv2" id="acDiv2_' + trplusOne + '"><a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="' + trplusOne + '"  id="addRequistion_' + trplusOne + '"><span class="btnChange" id="btnChange_' + trplusOne + '"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a></div></td></tr>';

         // $('#addOrder_'+id).removeClass('btn btn-primary btnAdd').addClass('btn btn-danger btnRemove');

         // $('#btnChange_'+id).html('<i class="fa fa-trash-o" aria-hidden="true"></i>');

         $('#itemcode_' + trplusOne).focus();

         $('#orderBody').append(template);

     });

     $(document).off('click', '.btnRemove');

     $(document).on('click', '.btnRemove', function() {

         var id = $(this).data('id');

         var whichtr = $(this).closest("tr");

         var conf = confirm('Are Your Want to Sure to remove?');

         if (conf)

         {
             var trplusOne = $('.orderrow').length + 1;

             // console.log(trplusOne);

             // $('#orderrow_'+id).fadeOut(500, function(){ 

             // $('#orderrow_'+id).remove();

             //  });



             whichtr.remove();

             //  for (var i = 0; i < trplusOne; i++) {

             //   $('#s_no_'+i).val(i);

             // }

             setTimeout(function() {

                 $(".orderrow").each(function(i, k) {

                     var vali = i + 1;

                     $(this).attr("id", "orderrow_" + vali);

                     $(this).attr("data-id", vali);

                     $(this).find('.sno').attr("id", "s_no_" + vali);

                     $(this).find('.sno').attr("value", vali);

                     $(this).find('.itemcode').attr("id", "itemcode_" + vali);

                     $(this).find('.itemcode').attr("data-id", vali);

                     $(this).find('.reqdetailid').attr("id", "reqdetailid_" + vali);

                     $(this).find('.reqdetailid').attr("data-id", vali);

                     $(this).find('.qtyinstock').attr("id", "qtyinstock_" + vali);

                     $(this).find('.qtyinstock').attr("data-id", vali);

                     $(this).find('.itemid').attr("id", "itemid_" + vali);

                     $(this).find('.itemid').attr("data-id", vali);

                     $(this).find('.itemname').attr("id", "itemname_" + vali);

                     $(this).find('.itemname').attr("data-id", vali);

                     $(this).find('.view').attr("id", "view_" + vali);

                     $(this).find('.view').attr("data-id", vali);

                     $(this).find('.unitprice').attr("id", "unitprice_" + vali);

                     $(this).find('.unitprice').attr("data-id", vali);

                     $(this).find('.rede_unit').attr("id", "rede_unit_" + vali);

                     $(this).find('.rede_unit').attr("data-id", vali);

                     $(this).find('.unitid').attr("id", "unitid_" + vali);

                     $(this).find('.unitid').attr("data-id", vali);

                     $(this).find('.rede_qty').attr("id", "rede_qty_" + vali);

                     $(this).find('.rede_qty').attr("data-id", vali);

                     $(this).find('.rede_remarks').attr("id", "rede_remarks_" + vali);

                     $(this).find('.rede_remarks').attr("data-id", vali);

                     $(this).find('.acDiv2').attr("id", "acDiv2_" + vali);

                     // $(this).find('.acDiv2').attr("data-id",vali);

                     $(this).find('.btnAdd').attr("id", "addOrder_" + vali);

                     $(this).find('.btnAdd').attr("data-id", vali);

                     $(this).find('.btnRemove').attr("id", "addOrder_" + vali);

                     $(this).find('.btnRemove').attr("data-id", vali);

                     $(this).find('.btnChange').attr("id", "btnChange_" + vali);

                 });

             }, 600);

             setTimeout(function() {

                 var trlength = $('.orderrow').length;

                 // alert(trlength);

                 if (trlength == 1)

                 {

                     $('#acDiv2_1').html('');

                 }

             }, 800);

         }

     });

     $(document).off('click', '.itemDetail');

     $(document).on('click', '.itemDetail', function() {

         var rowno = $(this).data('rowno');

         var rate = $(this).data('rate');

         var itemcode = $(this).data('itemcode');

         var itemname = $(this).data('itemname_display');

         var itemid = $(this).data('itemid');

         var stockqty = $(this).data('issueqty');

         var unitname = $(this).data('unitname');

         var purrate = $(this).data('purrate');

         var unitid = $(this).data('unitid');

         $('#itemcode_' + rowno).val(itemcode);

         // $('#itemcode_'+rowno).val(itemcode);

         $('#itemid_' + rowno).val(itemid);

         $('#itemname_' + rowno).val(itemname);

         $('#itemstock_' + rowno).val(stockqty);

         $('#rede_unit_' + rowno).val(unitname);

         $('#qtyinstock_' + rowno).val(stockqty);

         $('#unitprice_' + rowno).val(purrate);

         $('#unitid_' + rowno).val(unitid);

         $('#myView').modal('hide');

         $('#rede_qty_' + rowno).focus();

         return false;

     })
 </script>



 <script>
     $(document).off('click', '.chooseReqType');
     $(document).on('click', '.chooseReqType', function() {

         var reqType = $(this).data('reqtype');

         var submitdata = {
             type: reqType
         };

         var submiturl = base_url + 'issue_consumption/stock_requisition/get_dept_list';

         ajaxPostSubmit(submiturl, submitdata, beforeSend, onSuccess);

         function beforeSend() {

             // $('.overlay').modal('show');

         };

         function onSuccess(jsons) {

             data = jQuery.parseJSON(jsons);

             if (data.type == 'transfer') {

                 $('#rema_reqfromdepid').empty().html(data.from_depid).select2().trigger('change');

                 $('#hide').hide();



             } else {

                 $('#rema_reqfromdepid').empty().html(data.from_depid).trigger('change');

                 $('#hide').show();

             }



             $('#rema_reqtodepid').empty().html(data.to_depid).trigger('change');

         };

     });



     $(document).off('change', '.getReqNo');

     $(document).on('change', '.getReqNo', function() {

         var reqType = $('input[name=rema_isdep]:checked').data('reqtype');

         // alert(reqType);
         var todepid = $(this).val();

         // alert(todepid);

         var submitdata = {
             depid: todepid,
             type: reqType
         };

         var submiturl = base_url + 'issue_consumption/stock_requisition/get_req_no';

         ajaxPostSubmit(submiturl, submitdata, beforeSend, onSuccess);

         function beforeSend() {

             // $('.overlay').modal('show');

         };

         function onSuccess(jsons) {

             data = jQuery.parseJSON(jsons);

             setTimeout(function() {

                 $('#rema_reqno').empty().val(data.reqno);

             }, 1000);



         }

     });
 </script>



 <script>
     $(document).off('click', '#checkApproval');
     $(document).on('click', '#checkApproval', function() {

         var check = $('#checkApproval').prop('checked');

         if (check == true) {

             var conf = confirm('Do you want to approve this requisition?');

             if (conf) {

                 var checkStatus = $('#checkApproval:checked').length;

                 // alert(checkStatus);

                 if (checkStatus == '1') {

                     $('.approvalForm').show();

                 }

             }

         } else {

             $('.approvalForm').hide();

         }

     });
 </script>



 <?php

    if (empty($req_data)) :

    ?>

     <script type="text/javascript">
         $(document).ready(function() {

             var deptypeid = '<?php echo $rema_isdep ?>';

             if (deptypeid == 'N')

             {

                 $('#chooseReqtypeTran').click();

             } else

             {

                 $('#chooseReqtypeIss').click();

             }

             //         setTimeout(function(){
             // },500);  
             // $('.getReqNo').change();

         })
     </script>

 <?php
    endif; ?>



 <script type="text/javascript">
     $(document).off('change', '#rema_reqtodepid');
     $(document).on('change', '#rema_reqtodepid', function() {
         var storeid = '';

         var reqType = $("input[name='rema_isdep']:checked").val();

         if (reqType == 'Y') {
             var depname = $("#rema_reqtodepid option:selected").text();
             storeid = $("#rema_reqtodepid option:selected").val();

         } else

         {
             var depname = $("#rema_reqfromdepid option:selected").text();
             storeid = $("#rema_reqfromdepid option:selected").val();

         }
         $('.btnitem').attr('data-storeid', storeid);
         $('.btnitem').data('storeid', storeid);

     })
 </script>

 <script>
     $(document).ready(function() {
         var storeid = $("#rema_reqtodepid option:selected").val();
         $('.btnitem').attr('data-storeid', storeid);
         $('.btnitem').data('storeid', storeid);

     });
 </script>