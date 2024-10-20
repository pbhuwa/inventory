 <style>
        .purs_table tbody tr td{
            border: none;
            vertical-align: center;
        }
    </style>
<form method="post" id="FormStoreRequisition" action="<?php echo base_url('stock_inventory/store_requisition/save_requisition'); ?>" data-reloadurl="<?php echo base_url('stock_inventory/store_requisition/form_store_requisition');?>" class="form-material form-horizontal form" >
        <div class="form-group">
            <div class="col-md-3 col-sm-4">
                
                <label for="example-text"><?php echo $this->lang->line('requisition_date'); ?> <span class="required">*</span>:</label>
                <input type="text" class="form-control required_field <?php echo DATEPICKER_CLASS; ?>" name="reqdate"  value="<?php echo DISPLAY_DATE; ?>" placeholder="Enter Requisition Date" id="reqdate">
            </div>
            <div class="col-md-3 col-sm-4">
              <label for="example-text"><?php echo $this->lang->line('requested_by'); ?> : </label>
              <input type="text" class="form-control" name="requ_appliedby"  value="<?php ?>" placeholder="Requested By">
              
            </div>
            <div class="col-md-3 col-sm-4">
               
                <label for="example-text"><?php echo $this->lang->line('requisition_no'); ?>:</label>
                <input type="text" class="form-control number" name="requ_requno"  value="<?php echo $req_no; ?>" placeholder="Requisition No.">
            </div>
            <div class="col-md-3 col-sm-4">
                <label for="example-text"><?php echo $this->lang->line('requested_to'); ?>:</label>
                <input type="text" class="form-control " name="requ_requestto"  value="d]l8sn ;'lk|6]G8]G8" placeholder="Requested To." style="font-family:preeti;font-size: 16px;">
            </div>

           
        </div>
        <div class="clearfix"></div>
        <div class="form-group">
            <div class="table-responsive col-sm-12">
                <table style="width:100%;" class="table dataTable dt_alt purs_table">
                    <thead>
                        <tr>
                            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                            <th width="10%"><?php echo $this->lang->line('item_code'); ?> </th>
                            <th width="20%"><?php echo $this->lang->line('item_name'); ?></th>
                            <th width="5%"><?php echo $this->lang->line('unit'); ?></th>
                            <th width="8%"><?php echo $this->lang->line('reorder_level'); ?></th>
                            <th width="5%"><?php echo $this->lang->line('stock'); ?></th>
                            <th width="5%"><?php echo $this->lang->line('qty'); ?></th>
                            <th width="10%"><?php echo $this->lang->line('rate'); ?></th>
                            <th width="10%"><?php echo $this->lang->line('total_amount'); ?></th>
                            <th width="10%"><?php echo $this->lang->line('budget_code'); ?></th>
                            <th width="10%"><?php echo $this->lang->line('remarks'); ?></th>
                            <th width="5%"><?php echo $this->lang->line('action'); ?></th>
                        </tr>
                    </thead>
                        <tbody id="orderBody">
                            <tr class="reqtr" id="reqtr_1" data-id='1'>
                                <td>
                                    <input type="text" class="form-control sno" id="s_no_1" value="1" readonly/>
                                </td>
                                <td>
                                <div class="dis_tab"> 
                                    <input type="text" class="form-control itemcode enterinput " id="itemcode_1" name="itemcode[]"  data-id='1'>
                                    <input type="hidden" class="itemid" name="itemid[]" data-id='1' value="" id="itemid_1">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading='Item List' data-viewurl='<?php echo base_url('stock_inventory/item/list_item_with_stock'); ?>' data-id='1'><strong>...</strong></a>
                                </div> 
                                </td>
                                <td>                             
                                    <input type="text" class="form-control itemname" id="itemname_1" name="itemname[]"  data-id='1'> 
                                </td>
                                 <td> 
                                        <input type="text" class="form-control itemunit" name="itemunit[]"   id="itemunit_1" data-id='1'  > 
                                </td>

                                <td> 
                                        <input type="text" class="form-control reorderlvl" name="reorderlvl[]"   id="reorderlvl_1" data-id='1' readonly="true" > 
                                </td>
                                <td> 
                                        <input type="text" class="form-control number itemstock" name="itemstock[]"   id="itemstock_1" data-id='1' readonly="true" > 
                                </td>
                                <td> 
                                        <input type="text" class="form-control number itemqty  calculateamt" id="itemqty_1" name="itemqty[]"  data-id='1'> 
                                </td>
                                 <td> 
                                        <input type="text" class="form-control float itemrate calculateamt " id="itemrate_1" name="itemrate[]"  data-id='1'> 
                                </td>
                                 <td> 
                                        <input type="text" class="form-control float totalamt calculateamt " id="totalamt_1" name="totalamt[]"  data-id='1' readonly="true"> 
                                </td>
                                 <td> 
                                        <input type="text" class="form-control bugetcode" id="bugetcode_1" name="bugetcode[]"  data-id='1'> 
                                </td>
                                 <td> 
                                        <input type="text" class="form-control remarks " id="remarks_1" name="remarks[]"  data-id='1'> 
                                </td>
                                 <td>
                                  <div class="actionDiv acDiv2"></div>
                                </td>
                            </tr>    
                    </tbody>
                    <tbody>
                        <tr><td colspan="12"> <a href="javascript:void(0)" class="btn btn-primary pull-right btnAddReq" data-id="1"  id="addRequistion_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-plus" aria-hidden="true"></i></span></a></td></tr>
                    </tbody>
                    </tbody>
                     </table>
            <div id="Printable" class="print_report_section printTable">
                
            </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($item_data)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($item_data)?'Update':'Save' ?></button>
               <!--  <button type="submit" class="btn btn-info save" data-operation='<?php echo !empty($item_data)?'update':'save ' ?>' id="btnSavenPrint" data-print="print"><?php echo !empty($item_data)?'Update':'Save & Print' ?></button> -->
            </div>
              <div class="col-sm-12">
                <div  class="alert-success success"></div>
                <div class="alert-danger error"></div>
              </div>
        </div>
         <div class="clearfix"></div>
    </form>


<script type="text/javascript">
 $(document).on('click','.itemDetail',function(){
    var rowno=$(this).data('rowno');
    var unit=$(this).data('unit');
    var rate=$(this).data('rate');
    var itemcode=$(this).data('itemcode');
    // var itemname=$(this).data('itemname');
    var itemname=$(this).data('itemname_display');

    var itemid=$(this).data('itemid');
    var stockqty=$(this).data('stockqty');

    $('#itemcode_'+rowno).val(itemcode);
    $('#itemid_'+rowno).val(itemid);
    $('#itemname_'+rowno).val(itemname);
    $('#itemunit_'+rowno).val(unit);
    $('#itemrate_'+rowno).val(rate);
    $('#itemstock_'+rowno).val(stockqty);
    $('#myView').modal('hide');
    $('#itemqty_'+rowno).focus();

 })

</script>

<script type="text/javascript">
    $(document).off('click','.btnAddReq');
    $(document).on('click','.btnAddReq',function(){
         var id=$(this).data('id');
        var trplusOne = $('.reqtr').length+1;
        // alert(trplusOne);
        if(trplusOne==2)
        {

            $('.actionDiv').html('<a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="1"  id="addRequistion_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>');
        }
        var tempform='';
    var tempform =' <tr class="reqtr" id="reqtr_'+trplusOne+'" data-id="'+trplusOne+'"><td><input type="text" class="form-control sno" id="s_no_'+trplusOne+'" value="'+trplusOne+'" readonly/></td><td><div class="dis_tab"><input type="text" class="form-control icode enterinput " id="itemcode_'+trplusOne+'" name="itemcode[]"  data-id="'+trplusOne+'"><input type="hidden" name="itemid[]" data-id="'+trplusOne+'" value="<?php ?>" id="itemid_'+trplusOne+'"><a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading="Item List" data-viewurl="<?php echo base_url("stock_inventory/item/list_item_with_stock"); ?>" data-id="'+trplusOne+'"><strong>...</strong></a></div></td><td><input type="text" class="form-control" id="itemname_'+trplusOne+'" name="itemname[]"  data-id="'+trplusOne+'"></td><td><input type="text" class="form-control" name="itemunit[]"   id="itemunit_'+trplusOne+'" data-id="'+trplusOne+'"  ></td><td> <input type="text" class="form-control" name="reorderlvl[]"   id="reorderlvl_'+trplusOne+'" data-id="'+trplusOne+'" readonly="true" ></td><td><input type="text" class="form-control number" name="itemstock[]"   id="itemstock_'+trplusOne+'" data-id="'+trplusOne+'" readonly="true" ></td><td><input type="text" class="form-control number calculateamt " id="itemqty_'+trplusOne+'" name="itemqty[]"  data-id="'+trplusOne+'"></td><td><input type="text" class="form-control float calculateamt" id="itemrate_'+trplusOne+'" name="itemrate[]"  data-id="'+trplusOne+'"></td><td><input type="text" class="form-control calculateamt " id="totalamt_'+trplusOne+'" name="totalamt[]"  data-id="'+trplusOne+'"></td><td><input type="text" class="form-control" id="bugetcode_'+trplusOne+'" name="bugetcode[]"  data-id="'+trplusOne+'"></td><td><input type="text" class="form-control " id="remarks_'+trplusOne+'" name="remarks[]"  data-id="'+trplusOne+'"></td><td> <div class="actionDiv"><a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="'+trplusOne+'"  id="addRequistion_'+trplusOne+'"><span class="btnChange" id="btnChange_'+trplusOne+'"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a></div></td></tr>';

    $('#orderBody').append(tempform);
    })

    $(document).off('click','.btnRemove');
    $(document).on('click','.btnRemove',function(){
        var id=$(this).data('id');
         var whichtr = $(this).closest("tr");
         var conf = confirm('Are Your Want to Sure to remove?');
          if(conf)
          {
             var trplusOne = $('.reqtr').length+1;
             alert(trplusOne);
             if(trplusOne==3 || trplusOne==2)
             {
                $('.acDiv2').html('');
             }
             whichtr.remove(); 
            setTimeout(function(){
                  $(".reqtr").each(function(i,k) {
                    var vali=i+1;
                    $(this).attr("id","reqtr_"+vali);
                    $(this).attr("data-id",vali);    
                    $(this).find('.sno').attr("id","s_no_"+vali);
                    $(this).find('.sno').attr("value",vali);
                    $(this).find('.itemcode').attr("id","itemcode_"+vali);
                    $(this).find('.itemid').attr("id","orma_qty_"+vali);
                    $(this).find('.itemid').attr("data-id",vali);
                    $(this).find('.itemname').attr("id","itemname_"+vali);
                    $(this).find('.itemname').attr("data-id",vali);
                    $(this).find('.itemunit').attr("id","itemunit_"+vali);
                    $(this).find('.itemunit').attr("data-id",vali);
                    $(this).find('.reorderlvl').attr("id","reorderlvl_"+vali);
                    $(this).find('.reorderlvl').attr("data-id",vali);
                    $(this).find('.itemstock').attr("id","itemstock_"+vali);
                    $(this).find('.itemstock').attr("data-id",vali);
                    $(this).find('.itemqty').attr("id","itemqty_"+vali);
                    $(this).find('.itemqty').attr("data-id",vali);
                    $(this).find('.itemrate').attr("id","itemrate_"+vali);
                    $(this).find('.itemrate').attr("data-id",vali);
                    $(this).find('.totalamt').attr("id","totalamt_"+vali);
                    $(this).find('.totalamt').attr("data-id",vali);
                    $(this).find('.bugetcode').attr("id","bugetcode_"+vali);
                    $(this).find('.bugetcode').attr("data-id",vali);
                    $(this).find('.remarks').attr("id","remarks_"+vali);
                    $(this).find('.remarks').attr("data-id",vali);
                    $(this).find('.btnAddReq').attr("id","addRequistion_"+vali);
                    $(this).find('.btnAddReq').attr("data-id",vali);
                    $(this).find('.btnRemove').attr("id","addRequistion_"+vali);
                    $(this).find('.btnRemove').attr("data-id",vali);
                    $(this).find('.btnChange').attr("id","btnChange_"+vali);
            });
              },600);
          }
     });
</script>

<script type="text/javascript">
    $(document).on('keyup change','.calculateamt',function()
    {
        var did=$(this).data('id');
        var qty=$('#itemqty_'+did).val();
        var irate=$('#itemrate_'+did).val();
        var totalamt=qty*irate;
        $('#totalamt_'+did).val(totalamt);
    })


    
</script>


