<div id="challanForm">
    <form method="post" id="FormMenu" action="<?php echo base_url('issue_consumption/challan/save_challan'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('issue_consumption/challan/form_challan'); ?>'>
        <input type="hidden" name="id" value="<?php echo!empty($challan_data[0]->chma_challanmasterid)?$challan_data[0]->chma_challanmasterid:'';  ?>">
        <div class="form-group">
            <div class="col-md-2 col-sm-2">
                <?php $fiscalyear=!empty($order_details[0]->puor_fyear)?$order_details[0]->puor_fyear:''; ?>
                <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?><span class="required">*</span>:</label>
                <select name="fiscalyear" class="form-control select2" id="fiscalyear" >
                    <option value="">---select---</option>
                        <?php
                            if($fiscal):
                                foreach ($fiscal as $km => $fy):
                        ?>
                    <option value="<?php echo $fy->fiye_name; ?>" <?php if($fy->fiye_status=='I') echo "selected=selected"; ?>><?php echo $fy->fiye_name; ?></option>
                        <?php
                                endforeach;
                            endif;
                        ?>
                </select>
            </div>

            <div class="col-md-3 col-sm-3">
                <?php $orderno=!empty($order_details[0]->puor_order_for)?$order_details[0]->puor_order_for:''; ?>
                <label for="example-text"><?php echo $this->lang->line('order_no'); ?><span class="required">*</span>:</label>
                <div class="dis_tab">
                    <input type="text" class="form-control required_field enterinput"  name="orderno"  value="<?php  echo!empty($challan_data[0]->chma_puorid)?$challan_data[0]->chma_puorid:''; ?>" placeholder="Enter Order Number" id="orderno" data-targetbtn='btnSearchOrderno'>
                   
                    <a href="javascript:void(0)" class="table-cell width_30 btn btn-success" id="btnSearchOrderno" ><i class="fa fa-search"></i></a>
                    &nbsp;
              
                    <a href="javascript:void(0)" data-id="0" data-displaydiv="Issue" data-viewurl="<?php echo base_url('issue_consumption/challan/load_order_list'); ?>" class="view table-cell width_30 btn btn-success" data-heading="Load Order list" id="orderload"><i class="fa fa-upload"></i></a>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-2">
                <label for="example-text"><?php echo $this->lang->line('challan_receive_no'); ?><span class="required">*</span>:</label>
                <?php
                    if(!empty($challan_data)){
                        $chma_receiveno = !empty($challan_data[0]->chma_challanrecno)?$challan_data[0]->chma_challanrecno:'';
                    }else{
                        $chma_receiveno = $receiveno[0]->id+1;
                    }
                ?>
                <input type="text" class="form-control required_field" name="chma_receiveno" id="txtchallanCode" placeholder="Enter Challan Receive No " value="<?php echo $chma_receiveno; ?>" readonly>
            </div>
            <div class="col-md-3">
                <label for="example-text"><?php echo $this->lang->line('supplier_name'); ?>: <span class="required">*</span>:</label>
                <?php
                    $chma_supplierid = !empty($challan_data[0]->chma_supplierid)?$challan_data[0]->chma_supplierid:'';
                ?>
                <select name="chma_supplierid" class="form-control required_field select2" id="suppliername">
                    <option value="">---select---</option>
                    <?php
                    if($supplier):
                    foreach ($supplier as $km => $mat):
                    ?>
                    <option value="<?php echo $mat->dist_distributorid; ?>" <?php echo ($chma_supplierid == $mat->dist_distributorid)?"selected":""; ?> ><?php echo $mat->dist_distributor; ?></option>
                    <?php
                    endforeach;
                    endif;
                    ?>
                </select>
            </div>
            <div class="col-md-2">
                <label for="example-text"><?php echo $this->lang->line('challan_receive_date'); ?><span class="required">*</span>:</label>
                <?php
                    if(DEFAULT_DATEPICKER == 'NP'){
                        $chma_receivedate = !empty($challan_data[0]->chma_receivedatebs)?$challan_data[0]->chma_receivedatebs:DISPLAY_DATE;
                    }else{
                        $chma_receivedate = !empty($challan_data[0]->chma_receivedatead)?$challan_data[0]->chma_receivedatead:DISPLAY_DATE;
                    }
                ?>
                <input type="text" name="chma_receivedatebs" class="form-control required_field <?php echo DATEPICKER_CLASS; ?>"  placeholder="" value="<?php echo $chma_receivedate; ?>" id="receivw_date" placeholder="Enter Challan Receive Date">
            </div>

            <div class="col-md-2">
                <label for="example-text"><?php echo $this->lang->line('sup_challan_no'); ?> <span class="required">*</span>:</label>
                <?php
                    $chma_suchallanno = !empty($challan_data[0]->chma_suchallanno)?$challan_data[0]->chma_suchallanno:'';
                ?>
                <input type="text" class="form-control required_field" name="chma_suchallanno" id="txtchallanCode" placeholder="Sup Challan No" value="<?php echo $chma_suchallanno;?>">
            </div>
            <div class="col-md-2">
                <label for="example-text"><?php echo $this->lang->line('supplier_challan_date'); ?> :</label>
                <?php
                    if(DEFAULT_DATEPICKER == 'NP'){
                        $chma_challandate = !empty($challan_data[0]->chma_challanrecdatebs)?$challan_data[0]->chma_challanrecdatebs:DISPLAY_DATE;
                    }else{
                        $chma_challandate = !empty($challan_data[0]->chma_challanrecdatead)?$challan_data[0]->chma_challanrecdatead:DISPLAY_DATE;
                    }
                ?>
                <input type="text" name="suchalandatebs" class="form-control <?php echo DATEPICKER_CLASS; ?>"  placeholder="" value="<?php echo $chma_challandate; ?>" id="challan_date">
            </div>
        </div>

        <div class="form-group">
            <div class="pad-5" id="displayDetailList">
                <div class="table-responsive">
                    <table style="width:100%;" class="table purs_table dataTable">
                        <thead>
                            <tr>
                                <th width="5%"> <?php echo $this->lang->line('sn'); ?> </th>
                                <th width="10%"> <?php echo $this->lang->line('item_code'); ?></th>
                                <th width="30%"><?php echo $this->lang->line('item_name'); ?> </th>
                                <th width="10%"> <?php echo $this->lang->line('unit'); ?>  </th>
                                <th width="7%"><?php echo $this->lang->line('qty'); ?>  </th>
                                <th width="20%"> <?php echo $this->lang->line('remarks'); ?> </th>
                                <th width="5%"><?php echo $this->lang->line('action'); ?></th>
                            </tr>
                        </thead>
                        <tbody id="purchaseBody">
                            <?php 
                                if(!empty($challan_data)){
                                    foreach($challan_data as $key => $challan):
                            ?>
                                <tr class="directrow" id="directrow_1" data-id='1'>
                                    <td>
                                        <input type="text" class="form-control sno" id="s_no_<?php echo $key+1;?>" value="<?php echo $key+1; ?>" readonly/>
                                        <input type="hidden" class="chde_challandetailid" name="chde_challandetailid[]" id="chde_challandetailid_<?php echo $key+1;?>" value="<?php echo !empty($challan->chde_challandetailid)?$challan->chde_challandetailid:'';?>" /> 
                                    </td>
                                    <td>
                                        <div class="dis_tab"> 
                                            <input type="text" class="form-control itemcode enterinput " id="itemcode_<?php echo $key+1; ?>" name="trde_mtmid[]"  data-id='<?php echo $key+1; ?>' data-targetbtn='view' value="<?php echo !empty($challan->chde_code)?$challan->chde_code:'';?>" >

                                            <input type="hidden" class="qude_itemsid" name="trde_itemsid[]" data-id='<?php echo $key+1; ?>' id="itemid_<?php echo $key+1; ?>" value="<?php echo !empty($challan->chde_itemsid)?$challan->chde_itemsid:'';?>" >

                                            <input type="hidden" class="itemsid" name="itemsid[]" data-id='<?php echo $key+1; ?>' id="matdetailid_<?php echo $key+1; ?>" value="<?php echo !empty($challan->chde_itemsid)?$challan->chde_itemsid:'';?>" >

                                            <input type="hidden" class="controlno" name="controlno[]" data-id='<?php echo $key+1; ?>' id="controlno_<?php echo $key+1; ?>">

                                            <input type="hidden" class="trdeid" name="trdeid[]" data-id='<?php echo $key+1; ?>' id="trdeid_<?php echo $key+1; ?>" value="<?php echo !empty($challan->trde_trdeid)?$challan->trde_trdeid:'';?>">

                                            <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading='Item List' data-viewurl='<?php echo base_url('stock_inventory/item/list_item_normal'); ?>' data-id='<?php echo $key+1; ?>' id="view_1; ?>"><strong>...</strong></a>
                                        </div>
                                    </td>
                                    <td>
                                        <?php
                                            if(ITEM_DISPLAY_TYPE=='NP'){
                                                $ord_itemname = !empty($challan->itli_itemnamenp)?$challan->itemnamenp:$challan->itli_itemname;
                                            }else{ 
                                                $ord_itemname = !empty($challan->itli_itemname)?$challan->itli_itemname:'';
                                            }
                                        ?>
                                        <input type="text" class="form-control itemname" id="itemname_<?php echo $key+1; ?>" name="itemname[]"  data-id='<?php echo $key+1; ?>' value="<?php echo $ord_itemname; ?>">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control float trde_unitpercase calculateamt trde_unitpercase" name="trde_unitpercase[]" id="trde_unitpercase_<?php echo $key+1; ?>" data-id='<?php echo $key+1; ?>' value="<?php echo !empty($challan->unit_unitname)?$challan->unit_unitname:''; ?>" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control float trde_issueqty calculateamt trde_issueqty" name="trde_issueqty[]"   id="trde_issueqty_<?php echo $key+1; ?>" data-id='<?php echo $key+1; ?>' value="<?php echo !empty($challan->chde_qty)?$challan->chde_qty:''; ?>">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control remarks calculateamt " name="remarks[]"   id="remarks_<?php echo $key+1; ?>" data-id='<?php echo $key+1; ?>' value="<?php echo !empty($challan->chde_remarks)?$challan->chde_remarks:''; ?>">
                                    </td>
                                    <td>
                                        <div class="actionDiv acDiv2"></div>
                                    </td>
                                </tr>
                            <?php
                                    endforeach;
                            ?>

                            <?php
                                }else{
                            ?>
                           <!--  <tr class="directrow" id="directrow_1" data-id='1'>
                                <td>
                                    <input type="text" class="form-control sno" id="s_no_1" value="1" readonly/>
                                </td>
                                <td>
                                    <div class="dis_tab"> 
                                        <input type="text" class="form-control itemcode enterinput " id="itemcode_1" name="trde_mtmid[]"  data-id='1' data-targetbtn='view'>
                                        <input type="hidden" class="qude_itemsid" name="trde_itemsid[]" data-id='1' value="" id="itemid_1">
                                        <input type="hidden" class="itemsid" name="itemsid[]" data-id='1' value="" id="matdetailid_1">
                                        <input type="hidden" class="controlno" name="controlno[]" data-id='1' value="" id="controlno_1">
                                        <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading='Item List' data-viewurl='<?php echo base_url('stock_inventory/item/list_item_normal'); ?>' data-id='1' id="view_1; ?>"><strong>...</strong></a>
                                    </div>
                                </td>
                                <td>  
                                    <input type="text" class="form-control itemname" id="itemname_1" name="itemname[]"  data-id='1'>
                                </td>
                                <td>
                                    <input type="text" class="form-control float trde_unitpercase calculateamt trde_unitpercase" name="trde_unitpercase[]"   id="trde_unitpercase_1" data-id='1' readonly="readonly">
                                </td>
                                <td>
                                    <input type="text" class="form-control float trde_issueqty calculateamt trde_issueqty" name="trde_issueqty[]"   id="trde_issueqty_1" data-id='1' >
                                </td>
                                <td>
                                    <input type="text" class="form-control remarks calculateamt " name="remarks[]"   id="remarks_1" data-id='1' >
                                </td>
                                <td>
                                    <div class="actionDiv acDiv2"></div>
                                </td>
                            </tr> -->
                            <?php
                                }
                            ?>
                        </tbody>
                       <!--  <tbody> 
                            <tr>
                                <td colspan="7">
                                   <a href="javascript:void(0)" class="btn btn-primary btnAdd pull-right" data-id="1"  id="addOrder_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-plus" aria-hidden="true"></i></span></a>
                                </td>
                            </tr>
                        </tbody> -->
                    </table>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-md-12">
                <?php
                    $save_var=$this->lang->line('save');
                    $update_var=$this->lang->line('update'); 
                ?>
                <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($menu_data)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($menu_data)?$update_var:$save_var; ?></button>
                <button type="submit" class="btn btn-info savePrint" data-operation='<?php echo !empty($menu_data)?'update':'save ' ?>' id="btnSubmit" data-print="print"><?php echo !empty($menu_data)?$this->lang->line('update_and_print'):$this->lang->line('save_and_print'); ?>
                </button>
            </div>
            <div class="col-sm-12">
                <div  class="alert-success success"></div>
                <div class="alert-danger error"></div>
            </div>
        </div>
    </form>
</div>

<div class="print_report_section printTable"></div>

<script type="text/javascript">
    $('.engdatepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    });
    $('.nepdatepicker').nepaliDatePicker();
</script>

<script type="text/javascript">
    $(document).off('click','.btnAdd');
    $(document).on('click','.btnAdd',function(){
        var id=$(this).data('id');
        var itemid=$('#itemid_'+id).val();
        var qty=$('#trde_unitpercase_'+id).val();
        var rate=$('#rede_qty_'+id).val();

        if(itemid=='' || itemid==null )
        {
            $('#itemcode_'+id).focus();
            return false;
        }
        // if(qty=='' || qty==null )
        // {
        //     $('#orma_qty_'+id).focus();
        //     return false;
        // }
        //  if(rate=='' || rate==null )
        // {
        //     $('#orma_unitprice_'+id).focus();
        //     return false;
        // }
        var trplusOne = $('.directrow').length+1;
        if(trplusOne==2)
        {

            $('.actionDiv').html('<a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="1"  id="addRequistion_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>');
        }
        var template='';
        template='<tr class="directrow" id="directrow_'+trplusOne+'" data-id="'+trplusOne+'"><td><input type="text" class="form-control sno" id="s_no_'+trplusOne+'" value="'+trplusOne+'" readonly/></td><td> <div class="dis_tab"> <input type="text" class="form-control itemcode enterinput " id="itemcode_'+trplusOne+'" name="trde_mtmid[]" data-id="'+trplusOne+'" data-targetbtn="view"> <input type="hidden" class="qude_itemsid" name="trde_itemsid[]" data-id="'+trplusOne+'" value="" id="itemid_'+trplusOne+'"> <input type="hidden" class="itemsid" name="itemsid[]" data-id="'+trplusOne+'" value="" id="matdetailid_'+trplusOne+'"> <input type="hidden" class="controlno" name="controlno[]" data-id="'+trplusOne+'" value="" id="controlno_'+trplusOne+'"> <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading="Item List" data-viewurl="<?php echo base_url('stock_inventory/item/list_item_normal'); ?>" data-id="'+trplusOne+'" id="view_'+trplusOne+'"><strong>...</strong></a> </div></td><td> <input type="text" class="form-control itemname" id="itemname_'+trplusOne+'" name="itemname[]" data-id="'+trplusOne+'"></td><td><input type="text" class="form-control float trde_unitpercase calculateamt" name="trde_unitpercase[]" id="trde_unitpercase_'+trplusOne+'" data-id="'+trplusOne+'"></td><td><input type="text" class="form-control float trde_issueqty calculateamt trde_issueqty" name="trde_issueqty[]"  id="trde_issueqty_'+trplusOne+'" data-id="'+trplusOne+'" ></td><td> <input type="text" class="form-control remarks calculateamt remarks" name="remarks[]" id="remarks_'+trplusOne+'"></td><td><a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="'+trplusOne+'"  id="addRequistion_'+trplusOne+'"><span class="btnChange" id="btnChange_'+trplusOne+'"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a></div> <div class="actionDiv"></td></tr>';
            // $('#addOrder_'+id).removeClass('btn btn-primary btnAdd').addClass('btn btn-danger btnRemove');
            // $('#btnChange_'+id).html('<i class="fa fa-trash-o" aria-hidden="true"></i>');
            // <td><a href="javascript:void(0)" class="btn btn-primary btnAdd" data-id="'+trplusOne+'"  id="addOrder_'+trplusOne+'"><span class="btnChange" id="btnChange_'+trplusOne+'"><i class="fa fa-plus" aria-hidden="true"></i></span></a></td></tr>
        $('#itemcode_'+trplusOne).focus();
        $('#purchaseBody').append(template);
    });

    $(document).off('click','.btnRemove');
    $(document).on('click','.btnRemove',function(){
        var id=$(this).data('id');
        var whichtr = $(this).closest("tr");
        var conf = confirm('Are Your Want to Sure to remove?');
        if(conf)
        {
        var trplusOne = $('.directrow').length+1;
        // console.log(trplusOne);
        // $('#directrow_'+id).fadeOut(500, function(){
        // $('#directrow_'+id).remove();
        //  });
        whichtr.remove();
        //  for (var i = 0; i < trplusOne; i++) {
        //   $('#s_no_'+i).val(i);
        // }
        setTimeout(function(){
        $(".directrow").each(function(i,k) {
        var vali=i+1;
        $(this).attr("id","directrow_"+vali);
        $(this).attr("data-id",vali);
        $(this).find('.sno').attr("id","s_no_"+vali);
        $(this).find('.sno').attr("value",vali);

        $(this).find('.chde_challandetailid').attr("id","chde_challandetailid_"+vali);
        $(this).find('.chde_challandetailid').attr("data-id",vali);

        $(this).find('.itemcode').attr("id","itemcode_"+vali);
        $(this).find('.itemcode').attr("data-id",vali);

        $(this).find('.itemsid').attr("id","matdetailid_"+vali);
        $(this).find('.itemsid').attr("data-id",vali);

        $(this).find('.qude_itemsid').attr("id","itemid_"+vali);
        $(this).find('.qude_itemsid').attr("data-id",vali);

        $(this).find('.view').attr("id","view_"+vali);
        $(this).find('.view').attr("data-id",vali);

        $(this).find('.controlno').attr("id","controlno_"+vali);
        $(this).find('.controlno').attr("data-id",vali);

        $(this).find('.itemname').attr("id","itemname_"+vali);
        $(this).find('.itemname').attr("data-id",vali);

        $(this).find('.trde_unitpercase').attr("id","trde_unitpercase_"+vali);
        $(this).find('.trde_unitpercase').attr("data-id",vali);

        $(this).find('.trde_issueqty').attr("id","trde_issueqty_"+vali);
        $(this).find('.trde_issueqty').attr("data-id",vali);

        $(this).find('.trdeid').attr("id","trdeid_"+vali);
        $(this).find('.trdeid').attr("data-id",vali);

        $(this).find('.remarks').attr("id","remarks_"+vali);
        $(this).find('.remarks').attr("data-id",vali);

        $(this).find('.orma_itemid').attr("id","orma_itemid_"+vali);
        $(this).find('.orma_itemid').attr("data-id",vali);
        $(this).find('.orma_qty').attr("id","orma_qty_"+vali);
        $(this).find('.orma_qty').attr("data-id",vali);
        $(this).find('.orma_unitprice').attr("id","orma_unitprice_"+vali);
        $(this).find('.orma_unitprice').attr("data-id",vali);
        $(this).find('.totalamount').attr("id","totalamount_"+vali);
        $(this).find('.totalamount').attr("data-id",vali);
        $(this).find('.btnAdd').attr("id","addOrder_"+vali);
        $(this).find('.btnAdd').attr("data-id",vali);
        $(this).find('.btnRemove').attr("id","addOrder_"+vali);
        $(this).find('.btnRemove').attr("data-id",vali);
        $(this).find('.btnChange').attr("id","btnChange_"+vali);
        });
        },600);
        }
    });

    // $(document).on('click','.itemDetail',function(){
    //     var rowno=$(this).data('rowno');
    //     var rate=$(this).data('rate');
    //     var itemcode=$(this).data('itemcode');
    //     var itemname=$(this).data('itemname');
    //     var itemname_display=$(this).data('itemname_display');

    //     var itemid=$(this).data('itemid');
    //     var stockqty=$(this).data('stockqty');
    //     var matdetailid=$(this).data('mattransdetailid');
    //     var controlno=$(this).data('controlno');
    //     var unit=$(this).data('unit');
    //     var purchaserate=$(this).data('purchaserate');

    //     $('#puit_unitprice_'+rowno).val(rate); 
    //     $('#unitprice_'+rowno).val(rate); 
    //     $('#trde_unitpercase_'+rowno).val(unit); 
    //     $('#itemcode_'+rowno).val(itemcode);
    //     $('#itemid_'+rowno).val(itemid);
    //     // $('#itemname_'+rowno).val(itemname);
    //     $('#itemname_'+rowno).val(itemname_display);
        
    //     $('#itemstock_'+rowno).val(stockqty);
    //     $('#matdetailid_'+rowno).val(matdetailid);
    //     $('#controlno_'+rowno).val(controlno);
    //     $('#myView').modal('hide');
    //     $('#batch_no_'+rowno).focus();
    //     $('.calamt').change();
    // })
</script>


<script type="text/javascript">

     function getDetailList(masterid, main_form=false){
            if(main_form == 'main_form'){
                var submiturl = base_url+'issue_consumption/challan/load_detail_list/new_detail_list';
                var displaydiv = '#displayDetailList'; 
            }else{
                var submiturl = base_url+'issue_consumption/challan/load_detail_list';
                var displaydiv = '#detailListBox';
            }
            
            $.ajax({
                type: "POST",
                url: submiturl,
                data: {masterid : masterid},
                beforeSend: function (){
                    // $('.overlay').modal('show');
                },
                success: function(jsons){
                    var data = jQuery.parseJSON(jsons);
                    // console.log(data);
                    if(main_form == 'main_form'){
                        if(data.status == 'success'){
                            if(data.isempty == 'empty'){
                                alert('Pending list is empty. Please try again.');
                                   $('#requisition_date').val('');
                                   $('#receive_by').val(''); 
                                   $('#depnme').select2("val",'');
                                   $('#pendinglist').html('');
                                   $('#stock_limit').html(0);
                                   $('.loadedItems').empty();
                                return false;
                            }else{
                                $(displaydiv).empty().html(data.tempform);
                            }
                        }
                        }else{
                            if(data.status == 'success'){
                            $(displaydiv).empty().html(data.tempform);
                        }
                    }
                    
                    // $('.overlay').modal('hide');
                }
            });
        }

    function blink_text() {
        $('.blink').fadeOut(100);
        $('.blink').fadeIn(1000);
    }

    $(document).off('change','#fiscalyear');
    $(document).on('change','#fiscalyear',function(){
        var fyear = $('#fiscalyear').val();
        $('#cancelLoad').attr('data-fyear',fyear);
    });
</script>

<script type="text/javascript">
    $(document).off('click','#btnSearchOrderno');
    $(document).on('click','#btnSearchOrderno',function(){
        var orderno=$('#orderno').val();
        var fiscalyear=$('#fiscalyear').val();
        // alert(orderno);
        // ajaxPostSubmit()
        var submitdata = {orderno:orderno,fiscalyear:fiscalyear};
        var submiturl = base_url+'issue_consumption/challan/orderlist_by_order_no';
        beforeSend= $('.overlay').modal('show');

        ajaxPostSubmit(submiturl,submitdata,beforeSend='',onSuccess);
      
        function onSuccess(jsons){
            data = jQuery.parseJSON(jsons);
            // console.log(data.order_data);
            var orderdata=data.order_data;
           
            var defaultdatepicker='NP';

            if(orderdata)
            {
            var orderdatead=orderdata[0].puor_orderdatead;
            var orderdatebs=orderdata[0].puor_orderdatebs;
            var supplierid=orderdata[0].puor_supplierid;
            var purchaseordermasterid = orderdata[0].puor_purchaseordermasterid;
                if(defaultdatepicker=='NP')
                {
                    $('#OrderDate').val(orderdatebs);
                }
                else{
                    $('#OrderDate').val(orderdatead);
                }
                $("#supplierid").select2("val", supplierid).trigger('change');
                $('#purchaseordermasterid').val(purchaseordermasterid);
            }
            // console.log(orderdata);
            if(data.status=='success')
            {
                $('#challanForm').html(data.tempform);
                $('#supplierid').css('pointer-events','none');
            }
            else
            {   
                alert(data.message); 
                $('#OrderDate').val('');
                $("#supplierid").select2("val", 0).trigger('change');
                // $('#challanForm').html('');
            }
            $('.overlay').modal('hide');
        }
   });
</script>
