<style>
    .purs_table tbody tr td{
        border: none;
        vertical-align: center;
    }
</style>
<form method="post" id="FormpPurchaseRequisition" action="<?php echo base_url('purchase_receive/purchase_requisition/save_requisition'); ?>" data-reloadurl='<?php echo base_url('purchase_receive/purchase_requisition/form_purchase_requisition'); ?>' data-refresh="<?php echo base_url('purchase_receive/purchase_requisition/form_purchase_requisition'); ?>" class="form-material form-horizontal form" >
    <input type="hidden" name="id" value="<?php echo !empty($requisition_approved[0]->pure_purchasereqid)?$requisition_approved[0]->pure_purchasereqid:'' ?>">
    <div class="form-group">
     <div class="col-md-3 col-sm-4">
        <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?><span class="required">*</span> :</label>
       <select name="sama_fyear" class="form-control required_field" id="fyear">
           <?php
             if($fiscal_year): 
             foreach ($fiscal_year as $kf => $fyrs):
             ?>
            <option value="<?php echo $fyrs->fiye_name; ?>" <?php if($fyrs->fiye_status=='I') echo "selected=selected"; ?> ><?php echo $fyrs->fiye_name; ?></option>
         <?php endforeach; endif; ?>
       </select>
    </div>

    <?php
        if(empty($requisition_approved)):
    ?>
    <div class="col-md-3 col-sm-4">
        <label for="example-text">Demand <?php echo $this->lang->line('req_no'); ?> :</label>
        <div class="dis_tab">
            <input type="text" class="form-control number enterinput" name="sama_requisitionno"  value="<?php echo !empty($req_num_from_dmd)?$req_num_from_dmd:''; ?>" placeholder="Enter Demand Req No." id="req_no" data-targetbtn="SrchReq">
           <a href="javascript:void(0)" class="table-cell width_30 btn btn-success"  id="SrchReq"><i class="fa fa-search"></i></a>&nbsp;
            <a href="javascript:void(0)"  data-id="0" data-fyear="<?php echo CUR_FISCALYEAR;?>" data-displaydiv="Issue" data-viewurl="<?php echo base_url() ?>stock_inventory/stock_requisition/load_requisition" class="view table-cell width_30 btn btn-success" data-heading="<?php echo $this->lang->line('load_requisition')?>" id="reqload" ><i class="fa fa-upload"></i></a>
        </div>
         <span class="errmsg"></span>
    </div>
    <?php 
        endif;
    ?>
</div>
    <div class="form-group">
        <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('requisition_date'); ?>  : </label>
            <input type="text" name="rema_reqdatead" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Service Start Date" value="<?php echo !empty($requisition_approved[0]->pure_reqdatebs)?$requisition_approved[0]->pure_reqdatebs:DISPLAY_DATE; ?>" id="ServiceStart">
            <span class="errmsg"></span>
        </div>
        
 
        
        <div class="col-md-3 col-sm-4">
            <?php
                $storeid=$this->session->userdata(STORE_ID);
                $depid=!empty($requisition_approved[0]->pure_itemstypeid)?$requisition_approved[0]->pure_itemstypeid:$storeid; 
            ?>
            <label for="example-text"><?php echo $this->lang->line('store'); ?> <span class="required">*</span>:</label>
            <select name="item_type" class="form-control required_field" id="storeid" >
                <!-- <option value="">---select---</option> -->
            <?php
                if($store):
                    foreach ($store as $km => $dep):
            ?>
                <option value="<?php echo $dep->eqty_equipmenttypeid; ?>"  <?php if($depid==$dep->eqty_equipmenttypeid) echo "selected=selected"; ?>><?php echo $dep->eqty_equipmenttype; ?></option>
            <?php
                    endforeach;
                endif;
            ?>
            </select>
        </div>
        
        <div class="col-md-3 col-sm-4">
            <?php if($requisition_approved)
                {
                    $reqno=$requisition_approved[0]->pure_reqno; 
                }else{
                    $reqno =$reqno[0]->id+1;
                }?>
            <label for="example-text">Purchase <?php echo $this->lang->line('requisition_no'); ?> <span class="required">*</span>:</label>
            <input type="text" class="form-control required_field" name="rema_reqno"  value="<?php echo $reqno; ?>" placeholder="Enter Requisition Number" readonly>
        </div>
    </div> 
    
    <div class="clearfix"></div>
    
    <div class="form-group" id="DisplayPendingList">
        <div class="table-responsive col-sm-12">
            <table style="width:100%;" class="table dataTable dt_alt purs_table">
                <thead>
                    <tr>
                        <th width="5%"> <?php echo $this->lang->line('sn'); ?> </th>
                        <th width="10%"> <?php echo $this->lang->line('item_code'); ?>  </th>
                        <th width="20%"><?php echo $this->lang->line('item_name'); ?> </th>
                        <th width="6%"> <?php echo $this->lang->line('stock_quantity'); ?></th>
                        <th width="5%"> <?php echo $this->lang->line('unit'); ?>  </th>
                        <th width="5%"> <?php echo $this->lang->line('qty'); ?> </th>
                        <th width="15%"> <?php echo $this->lang->line('remarks'); ?> </th>
                        <th width="10%"> <?php echo $this->lang->line('required_date'); ?> </th>
                        <th width="5%"><?php echo $this->lang->line('action'); ?></th>
                    </tr>
                </thead>
                <tbody id="orderBody">
                    <?php if($requisition_details) { 
                        foreach ($requisition_details as $key => $reqv) { ?>
                    <tr class="orderrow" id="orderrow_<?php echo $key+1; ?>" data-id="<?php echo $key+1; ?>">
                        <td>
                            <input type="text" class="form-control sno" id="s_no_<?php echo $key+1; ?>" value="<?php echo $key+1; ?>" readonly/>
                        </td>
                        <td>
                            <div class="dis_tab"> 
                                <input type="text" class="form-control itemcode enterinput " id="itemcode_<?php echo $key+1; ?>" name="rede_code[]" value="<?php echo $reqv->itli_itemcode;?>" data-id='<?php echo $key+1; ?>' data-targetbtn='view' placeholder="Item Code">
                                <input type="hidden" class="rede_itemsid" name="rede_itemsid[]" data-id='<?php echo $key+1; ?>' id="itemid_<?php echo $key+1; ?>" value="<?php echo $reqv->itli_itemlistid;?>">
                                <input type="hidden" class="itemsid" name="quotationmasterid[]" data-id='<?php echo $key+1; ?>' value="" id="quotationmasterid_<?php echo $key+1; ?>">
                                <input type="hidden" class="reqdetid" name="reqdetid[]" data-id='<?php echo $key+1; ?>'id="reqdetid_<?php echo $key+1; ?>" value="<?php echo $reqv->purd_reqdetid; ?>">
                              
                             </div>
                        </td>
                        <td>  
                            <?php 
                                if(ITEM_DISPLAY_TYPE=='NP'){
                                    $req_itemname = !empty($reqv->itli_itemnamenp)?$reqv->itli_itemnamenp:$reqv->itli_itemname;
                                }else{ 
                                    $req_itemname = !empty($reqv->itli_itemname)?$reqv->itli_itemname:'';
                                }
                            ?> 
                            <input type="text" class="form-control itemname" id="itemname_<?php echo $key+1; ?>" name="itemname[]" value="<?php echo $req_itemname; ?>"  data-id='<?php echo $key+1; ?>' placeholder="Item name">
                        </td>
                        <td> 
                            <input type="text" class="form-control float calculateamt stock" name="stock[]"   id="stock_<?php echo $key+1; ?>" value="<?php echo $reqv->purd_stock; ?>" data-id='<?php echo $key+1; ?>' placeholder="Stock Qty." readonly="true"> 
                        </td>
                        <td> 
                                <input type="text" class="form-control float rede_unit calculateamt rede_unit" name="rede_unit[]" value="<?php echo $reqv->purd_unit; ?>" id="rede_unit_<?php echo $key+1; ?>" data-id='<?php echo $key+1; ?>' placeholder="Unit" readonly="true"> 
                        </td>
                        <td> 
                                <input type="text" class="form-control required_field float rede_qty calculateamt rede_qty" name="rede_qty[]"  value="<?php echo $reqv->purd_qty; ?>"  id="rede_qty_<?php echo $key+1; ?>" data-id='<?php echo $key+1; ?>' placeholder="Qty."> 
                        </td>
                        <td> 
                                <input type="text" class="form-control  rede_remarks jump_to_add " id="rede_remarks_<?php echo $key+1; ?>" name="rede_remarks[]"  data-id='<?php echo $key+1; ?>' placeholder="Enter Remarks" value="<?php echo $reqv->purd_remarks; ?>"> 
                        </td>
                        <td>
                            <input type="text" name="required_date[]" class="form-control nepali <?php echo DATEPICKER_CLASS; ?> date required_date"  placeholder="Required Date" value="<?php echo $reqv->purd_reqdatebs;?>" id="Required_date_<?php echo $key+1; ?>" data-id="<?php echo $key+1; ?>" autocomplete="off">
                        </td>
                        <td>
                      
                            <div class="actionDiv acDiv2" id="acDiv2_<?php echo $key+1;?>"></div>

                            <?php
                                if(count($requisition_details) > 1):
                            ?>
                            <a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="<?php echo $key+1;?>"  id="addRequistion_<?php echo $key+1;?>"><span class="btnChange" id="btnChange_1"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>
                            <?php
                                endif;
                            ?>

                        </td>
                    </tr>
                    <?php } }
                    else if(!empty($purchase_item_list))  {
                        // echo "<pre>";
                        // print_r($purchase_item_list);
                        // die();
                        $z=1;
                    foreach ($purchase_item_list as $lpl => $plist) {
                        # code...
                    
                  
                    ?>
                    <tr class="orderrow" id="orderrow_<?php echo $z; ?>" data-id='<?php echo $z; ?>'>
                        <td>
                            <input type="text" class="form-control sno" id="s_no_<?php echo $z; ?>" value="<?php echo $z; ?>" readonly/>
                        </td>
                        <td>
                            <div class="dis_tab"> 
                                <input type="text" class="form-control itemcode enterinput " id="itemcode_<?php echo $z; ?>" name="rede_code[]"  data-id='<?php echo $z; ?>' value="<?php echo $plist->itli_itemcode ;?>" data-targetbtn='view' placeholder="Item Code">
                                <input type="hidden" class="rede_itemsid" name="rede_itemsid[]" data-id='<?php echo $z; ?>' value="<?php echo $plist->itli_itemlistid ;?>" id="itemid_<?php echo $z; ?>" >
                                <input type="hidden" class="itemsid" name="quotationmasterid[]" data-id='<?php echo $z; ?>' value="" id="quotationmasterid_<?php echo $z; ?>">
                                  <input type="hidden" class="controlno" name="controlno[]" data-id='<?php echo $z; ?>' value="" id="controlno_<?php echo $z; ?>">
                             
                            </div>
                        </td>
                        <td>  
                            <input type="text" class="form-control required_field itemname" id="itemname_<?php echo $z; ?>" name="itemname[]"  data-id='<?php echo $z; ?>' placeholder="Item name" value="<?php echo $plist->itli_itemname; ?>">
                        </td>
                        <td> 
                            <input type="text" class="form-control float calculateamt stock" name="stock[]"   id="stock_<?php echo $z; ?>" data-id='<?php echo $z; ?>' placeholder="Stock Qty." readonly="true"> 
                        </td>
                        <td> 
                                <input type="text" class="form-control float rede_unit calculateamt rede_unit" name="rede_unit[]"   id="rede_unit_<?php echo $z; ?>" data-id='<?php echo $z; ?>' placeholder="Unit" readonly="true" value="<?php echo $plist->unit_unitname ;?>"> 
                        </td>
                        <td> 
                                <input type="text" class="form-control required_field float rede_qty calculateamt rede_qty" name="rede_qty[]"   id="rede_qty_<?php echo $z; ?>" data-id='<?php echo $z; ?>' placeholder="Qty." value="<?php echo $plist->rede_remqty ;?>"> 
                        </td>
                        <td> 
                                <input type="text" class="form-control  rede_remarks jump_to_add " id="rede_remarks_<?php echo $z; ?>" name="rede_remarks[]"  data-id='<?php echo $z; ?>' placeholder="Enter Remarks" value="<?php echo $plist->rede_remarks ;?>" > 
                        </td>
                        <td>
                            <input type="text" name="required_date[]" class="form-control nepali <?php echo DATEPICKER_CLASS; ?> date required_date"  placeholder="Required Date" value="" id="Required_date_<?php echo $z; ?>" data-id="<?php echo $z; ?>" autocomplete="off" />
                        </td>
                        <td>
                            <div class="actionDiv acDiv2"></div>
                             <a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="<?php echo $z;?>"  id="addRequistion_<?php echo $z;?>"><span class="btnChange" id="btnChange_<?php echo $z; ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>
                        </td>
                    </tr>
                    <?php
                      $z++;
                    }
                    }
                    else{ ?>  
                    <tr class="orderrow" id="orderrow_1" data-id='1'>
                        <td>
                            <input type="text" class="form-control sno" id="s_no_1" value="1" readonly/>
                        </td>
                        <td>
                            <div class="dis_tab"> 
                                <input type="text" class="form-control itemcode enterinput " id="itemcode_1" name="rede_code[]"  data-id='1' data-targetbtn='view' placeholder="Item Code">
                                <input type="hidden" class="rede_itemsid" name="rede_itemsid[]" data-id='1' value="" id="itemid_1">
                                <input type="hidden" class="itemsid" name="quotationmasterid[]" data-id='1' value="" id="quotationmasterid_1">
                                  <input type="hidden" class="controlno" name="controlno[]" data-id='1' value="" id="controlno_1">
                            
                            </div>
                        </td>
                        <td>  
                            <input type="text" class="form-control required_field itemname" id="itemname_1" name="itemname[]"  data-id='1' placeholder="Item name">
                        </td>
                        <td> 
                            <input type="text" class="form-control float calculateamt stock" name="stock[]"   id="stock_1" data-id='1' placeholder="Stock Qty." readonly="true"> 
                        </td>
                        <td> 
                                <input type="text" class="form-control float rede_unit calculateamt rede_unit" name="rede_unit[]"   id="rede_unit_1" data-id='1' placeholder="Unit" readonly="true"> 
                        </td>
                        <td> 
                                <input type="text" class="form-control required_field float rede_qty calculateamt rede_qty" name="rede_qty[]"   id="rede_qty_1" data-id='1' placeholder="Qty."> 
                        </td>
                        <td> 
                                <input type="text" class="form-control  rede_remarks jump_to_add " id="rede_remarks_1" name="rede_remarks[]"  data-id='1' placeholder="Enter Remarks"> 
                        </td>
                        <td>
                            <input type="text" name="required_date[]" class="form-control nepali <?php echo DATEPICKER_CLASS; ?> date required_date"  placeholder="Required Date" value="" id="Required_date_1" data-id="1" autocomplete="off" />
                        </td>
                        <td>
                            <div class="actionDiv acDiv2"></div>
                        </td>
                    </tr>
                    <?php } ?>
               </tbody>
              
                <tbody>
                    <tr class="resp_table_breaker">
                        <td colspan="15">
                            <a href="javascript:void(0)" class="btn btn-primary btnAdd pull-right" data-id="1"  id="addOrder_1">
                                <span class="btnChange" id="btnChange_1">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                </span>
                            </a>
                        </td>
                    </tr>
                </tbody>
                
            </table>
            
        </div>
    </div>
    
    <div class="form-group">
        <div class="col-md-12">
            <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($requisition_approved)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($requisition_approved)?'Update':'Save' ?></button>
            <button type="submit" class="btn btn-info savePrint" data-operation='<?php echo !empty($requisition_approved)?'update':'save ' ?>' id="btnSubmit" data-print="print"><?php echo !empty($requisition_approved)?'Update & Print':'Save & Print' ?></button>
        </div>
        
        <div class="col-sm-12">
            <div  class="alert-success success"></div>
            <div class="alert-danger error"></div>
        </div>
    </div>

    <div id="Printable" class="print_report_section printTable">
            </div>

<script type="text/javascript">
    var storeid='<?php echo $storeid; ?>'
   $(document).off('click','.btnAdd');
    $(document).on('click','.btnAdd',function(){
        var id=$(this).data('id');
          storeid=$('#storeid').val();
          if(storeid=='')
          {
            alert('Store Types is required !!');
            $('#storeid').focus();
            return false;
          }
        var orderlen=$('.orderrow').length;
        var newitemid=$('#itemid_'+orderlen).val();
        var itm_qty=$('#rede_qty_'+orderlen).val();

        if(newitemid=='')
        {
            $('#itemcode_'+orderlen).focus();
            return false;
        }
        if(itm_qty=='')
        {
            $('#rede_qty_'+orderlen).focus();
            return false;
        }
        var itemid=$('#rede_itemsid_'+id).val();
        var qty=$('#rede_itemsid_'+id).val();
        var rate=$('#rede_qty_'+id).val();
        
        var trplusOne = $('.orderrow').length+1;
        if(trplusOne==2)
        {
            $('.actionDiv').html('<a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="1"  id="addRequistion_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>');
        }
        var template='';
        template='<tr class="orderrow" id="orderrow_'+trplusOne+'" data-id="'+trplusOne+'"><td><input type="text" class="form-control sno" id="s_no_'+trplusOne+'" value="'+trplusOne+'" readonly/></td><td><div class="dis_tab"><input type="text" class="form-control itemcode enterinput " id="itemcode_'+trplusOne+'" name="rede_code[]" data-id="'+trplusOne+'" data-targetbtn="view" placeholder="Item Code"><input type="hidden" class="rede_itemsid" name="rede_itemsid[]" data-id="'+trplusOne+'" value="" id="itemid_'+trplusOne+'"><input type="hidden" class="itemsid" name="quotationmasterid[]" data-id="'+trplusOne+'" value="" id="quotationmasterid_'+trplusOne+'"><input type="hidden" class="controlno" name="controlno[]" data-id="'+trplusOne+'" value="" id="controlno_'+trplusOne+'"></div></td><td><input type="text" class="form-control itemname" id="itemname_'+trplusOne+'" name="itemname[]" data-id="'+trplusOne+'" placeholder="Item name"></td><td> <input type="text" class="form-control float calculateamt stock" name="stock[]" id="stock_'+trplusOne+'" data-id="'+trplusOne+'" placeholder="Stock Qty." readonly></td><td><input type="text" class="form-control float rede_unit calculateamt rede_unit" name="rede_unit[]" id="rede_unit_'+trplusOne+'" data-id="'+trplusOne+'" placeholder="Unit" ></td><td><input type="text" class="form-control required_field  float rede_qty calculateamt" name="rede_qty[]" id="rede_qty_'+trplusOne+'" data-id="'+trplusOne+'" placeholder="Qty."></td><td><input type="text" class="form-control  rede_remarks jump_to_add" id="rede_remarks'+trplusOne+'" name="rede_remarks[]"  data-id="'+trplusOne+'" placeholder="Enter Remarks"> </td> <td><input type="text" name="required_date[]" class="form-control nepali <?php echo DATEPICKER_CLASS; ?> date required_date"  placeholder="Required Date" id="Required_date_'+trplusOne+'" data-id="'+trplusOne+'" autocomplete="off" /></td><td><a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="'+trplusOne+'"  id="addRequistion_'+trplusOne+'"><span class="btnChange" id="btnChange_'+trplusOne+'"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a></div> <div class="actionDiv"></td></tr>';
         // $('#addOrder_'+id).removeClass('btn btn-primary btnAdd').addClass('btn btn-danger btnRemove');
         // $('#btnChange_'+id).html('<i class="fa fa-trash-o" aria-hidden="true"></i>');
         $('#orderBody').append(template);
    });
    $(document).off('click','.btnRemove');
    $(document).on('click','.btnRemove',function(){
        var id=$(this).data('id');
         var whichtr = $(this).closest("tr");
         var conf = confirm('Are Your Want to Sure to remove?');
          if(conf)
          {
            var trplusOne = $('.orderrow').length+1;
             // console.log(trplusOne);
             // $('#orderrow_'+id).fadeOut(500, function(){ 
             // $('#orderrow_'+id).remove();
             //  });
             whichtr.remove(); 
            //  for (var i = 0; i < trplusOne; i++) {
            //   $('#s_no_'+i).val(i);
            // }
            setTimeout(function(){
                  $(".orderrow").each(function(i,k) {
                    var vali=i+1;
                    $(this).attr("id","orderrow_"+vali);
                    $(this).attr("data-id",vali);    
                    $(this).find('.sno').attr("id","s_no_"+vali);
                    $(this).find('.sno').attr("value",vali);
                    $(this).find('.orma_itemid').attr("id","orma_itemid_"+vali);

                    $(this).find('.itemcode').attr("id","itemcode_"+vali);
                    $(this).find('.itemcode').attr("data-id",vali);

                    $(this).find('.itemname').attr("id","itemname_"+vali);
                    $(this).find('.itemname').attr("data-id",vali);

                    $(this).find('.rede_itemsid').attr("id","itemid_"+vali);
                    $(this).find('.rede_itemsid').attr("data-id",vali);

                    $(this).find('.itemsid').attr("id","quotationmasterid_"+vali);
                    $(this).find('.itemsid').attr("data-id",vali);

                    $(this).find('.reqdetid').attr("id","reqdetid_"+vali);
                    $(this).find('.reqdetid').attr("data-id",vali);

                    $(this).find('.stock').attr("id","stock_"+vali);
                    $(this).find('.stock').attr("data-id",vali);

                    $(this).find('.rede_unit').attr("id","rede_unit_"+vali);
                    $(this).find('.rede_unit').attr("data-id",vali);

                    $(this).find('.rede_qty').attr("id","rede_qty_"+vali);
                    $(this).find('.rede_qty').attr("data-id",vali);

                    $(this).find('.rede_remarks').attr("id","rede_remarks_"+vali);
                    $(this).find('.rede_remarks').attr("data-id",vali);

                    $(this).find('.date').attr("id","Required_date_"+vali);
                    $(this).find('.date').attr("data-id",vali);

                    $(this).find('.controlno').attr("id","controlno_"+vali);
                    $(this).find('.controlno').attr("data-id",vali);

                    $(this).find('.view').attr("id","view_"+vali);
                    $(this).find('.view').attr("data-id",vali);

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
</script>
<script type="text/javascript">
    $(document).on('mouseover click','.nepali', function(){
        $('.nepali').nepaliDatePicker({
        npdMonth: true,
          npdYear: true,
          npdYearCount: 10 // Options | Number of years to show
        });
    });

    $(document).off('click','.itemDetail');
    $(document).on('click','.itemDetail',function(){
        var rowno=$(this).data('rowno');
        var rate=$(this).data('rate');
        var itemcode=$(this).data('itemcode');
        var itemname=$(this).data('itemname_display');
        var itemid=$(this).data('itemid');
        var stock_qty=$(this).data('issueqty');
        var quotationmasterid=$(this).data('quotationmasterid');
        var unit=$(this).data('unitname');
    

        $('#stock_'+rowno).val(stock_qty); 
        $('#rede_unit_'+rowno).val(unit); 
        $('#itemcode_'+rowno).val(itemcode);
        $('#itemid_'+rowno).val(itemid);
        $('#itemname_'+rowno).val(itemname);
        $('#quotationmasterid_'+rowno).val(quotationmasterid);
        $('#myView').modal('hide');
        $('#rede_qty_'+rowno).focus();
    })

  $(document).off('change','#storeid');
  $(document).on('change','#storeid',function(e){
  var storeid=$(this).val();
  $('.view').attr('data-storeid',storeid);
  $('.view').data('storeid',storeid);
});

</script>

<script type="text/javascript">

     function getPendingList(req_masterid, main_form=false){
            if(main_form == 'main_form'){
                var submiturl = base_url+'stock_inventory/stock_requisition/load_pendinglist/purchase_requisition_list';
                var displaydiv = '#DisplayPendingList'; 
            }else{
                var submiturl = base_url+'stock_inventory/stock_requisition/load_pendinglist';
                var displaydiv = '#pendingListBox';
            }
            
            $.ajax({
                type: "POST",
                url: submiturl,
                data: {req_masterid : req_masterid},
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

function ajax_search_requistion()
{
    var req_no=$('#req_no').val();
    var fyear=$('#fyear').val();
    var submitdata = {req_no:req_no,fyear:fyear};
    var submiturl = base_url+'issue_consumption/new_issue/issuelist_by_req_no';
        beforeSend= $('.overlay').modal('show');
        ajaxPostSubmit(submiturl,submitdata,beforeSend='',onSuccess);
    function onSuccess(jsons){
        data = jQuery.parseJSON(jsons);
        // console.log(data);
        $('#ndp-nepali-box').hide();
        if(data.status=='success')
        {
            // console.log(data.req_data);
            var reqdata=data.req_data;
            $('#requisition_date').val(reqdata.req_date);
            $('#receive_by').val(reqdata.reqby);
            $('#depnme').select2("val", reqdata.fromdepid);
            $('#depnme').val(reqdata.fromdepid);
            
            getPendingList(data.masterid,'main_form');
            setTimeout(function(){
            var limstk_cnt=$('.limited_stock').length;
            $('#stock_limit').html(limstk_cnt);
        },1500);
        } 
        else{
            alert(data.message);
            $('#requisition_date').val('');
            $('#receive_by').val('');
            $('#depnme').select2("val",'');
            $('#depnme').val("");
            $('#pendinglist').html('');
            $('#stock_limit').html(0);
            // return false;
        } 
        $('.overlay').modal('hide');

        }
    }
   $('.send_after_stop').donetyping(function(){
   // ajax_search_requistion();
});
setInterval(blink_text, 3000);
</script>
<script type="text/javascript">
    $(document).off('click','#SrchReq');
    $(document).on('click','#SrchReq',function(){
    ajax_search_requistion();
    });
    
</script>

<script>
    $(document).off('change','#fyear');
    $(document).on('change','#fyear',function(){
        var fyear = $('#fyear').val();
        $('#reqload').attr('data-fyear',fyear);
    });
</script>
