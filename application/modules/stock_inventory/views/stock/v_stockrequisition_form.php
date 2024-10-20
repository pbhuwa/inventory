 <style>
        .purs_table tbody tr td{
            border: none;
            vertical-align: center;
        }
    </style>
<form method="post" id="FormStockRequisition" action="<?php echo base_url('stock_inventory/stock_requisition/save_requisition'); ?>" data-refresh="<?php echo base_url('stock_inventory/stock_requisition/form_stock_requisition');?>" class="form-material form-horizontal form" >
        <div class="form-group">
            <div class="col-md-3 col-sm-4">
                <?php 
                 $itemcode=!empty($item_data[0]->rema_reqno)?$item_data[0]->rema_reqno:$reqno[0]->id; ?>
                <label for="example-text">Requisition No <span class="required">*</span>:</label>
                <input type="text" class="form-control" name="rema_reqno"  value="<?php echo $itemcode + 1; ?>" placeholder="Enter Requisition Number" readonly>
            </div>
            <div class="col-md-3 col-sm-4">
              <label for="example-text">Choose  : </label><br>

              <?php $rema_storeid=!empty($equip_data[0]->rema_storeid)?$equip_data[0]->rema_storeid:''; ?>
              <input type="radio" class="mbtm_13" name="rema_storeid" value="issue" <?php if($rema_storeid=='issue') echo "checked=checked"; ?>> Issue &nbsp;
              <input type="radio" class="mbtm_14" name="rema_storeid" value="transfer" checked="checked" > Transfer
            </div>
            <div class="col-md-3 col-sm-4">
                <?php $maxlimit=!empty($item_data[0]->rema_manualno)?$item_data[0]->rema_manualno:''; ?>
                <label for="example-text">Manual Number :</label>
                <input type="text" class="form-control float" name="rema_manualno"  value="<?php echo $maxlimit; ?>" placeholder="Enter Manual Number">
            </div>
            <div class="col-md-3 col-sm-4">
                <?php $depid=!empty($item_data[0]->rema_reqfromdepid)?$item_data[0]->rema_reqfromdepid:''; ?>
                <label for="example-text">From <span class="required">*</span>:</label>
                <select name="rema_reqfromdepid" class="form-control select2" >
                    <option value="">---select---</option>
                    <?php
                        if($depatrment):
                            foreach ($depatrment as $km => $dep):
                    ?>
                     <option value="<?php echo $dep->dept_depid; ?>"  <?php if($depid==$dep->dept_depid) echo "selected=selected"; ?>><?php echo $dep->dept_depname; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </select>
            </div>

            <div class="col-md-3 col-sm-4">
                <label for="example-text">To :</label>
                <?php $unitid=!empty($item_data[0]->rema_reqtodepid)?$item_data[0]->rema_reqtodepid:''; ?>
                <select name="rema_reqtodepid" class="form-control select2" >
                    <option value="">---select---</option>
                    <?php
                        if($equipmentcategory):
                            foreach ($equipmentcategory as $km => $eqt):
                    ?>
                    <option value="<?php echo $eqt->eqca_equipmentcategoryid; ?>" <?php if($unitid==$eqt->eqca_equipmentcategoryid) echo "selected=selected"; ?>><?php echo $eqt->eqca_category; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </select>
            </div>
            <div class="col-md-3 col-sm-4">
                <?php $reorderlevel=!empty($item_data[0]->rema_reqby)?$item_data[0]->rema_reqby:''; ?>
                <label for="example-text">By :</label>
                <input type="text" class="form-control" name="rema_reqby" value="<?php echo $reorderlevel; ?>" placeholder="Enter Posted BY ">
            </div>
            <div class="col-md-3 col-sm-4">
              <label for="example-text">Date Start  : </label>
              <input type="text" name="rema_reqdatead" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Service Start Date" value="<?php echo !empty($equip_data[0]->rema_reqdatead)?$equip_data[0]->rema_reqdatead:DISPLAY_DATE; ?>" id="ServiceStart">
              <span class="errmsg"></span>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="form-group">
            <div class="table-responsive col-sm-12">
                <table style="width:100%;" class="table dataTable dt_alt purs_table">
                    <thead>
                        <tr>
                            <th width="5%"> S.No. </th>
                            <th width="10%"> Code  </th>
                            <th width="10%"> Particular </th>
                            <th width="15%"> Unit  </th>
                            <th width="15%"> Req Quantity </th>
                            <th width="25%"> Remarks </th>
                            <th width="5%">Action</th>
                        </tr>
                    </thead>
                        <tbody id="orderBody">
                            <tr class="orderrow" id="orderrow_1" data-id='1'>
                                <td>
                                    <input type="text" class="form-control sno" id="s_no_1" value="1" readonly/>
                                </td>
                                <td>
                                    <div class="dis_tab"> 
                                      <input type="text" class="form-control itemcode enterinput" id="itemcode_1" name="itemcode[]"  data-id='1' data-targetbtn='view' value="">
                                      <input type="hidden" class="itemid" name="rede_code[]" data-id='1' value="" id="itemid_1">
                                      <input type="hidden" class="matdetailid" name="rede_code[]" data-id='1' value="" id="matdetailid_1">
                                        <input type="hidden" class="controlno" name="controlno[]" data-id='1' value="" id="controlno_1">
                                      <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading='Item List' data-viewurl='<?php echo base_url('stock_inventory/item/list_item_with_stock_transfer'); ?>' data-id='1' id="view_1"><strong>...</strong></a>
                                    </div> 
                                </td>
                                <td>  
                                    <input type="text" class="form-control itemname" id="itemname_1" name="rede_itemsid[]"  data-id='1'> 
                                </td>
                                <td> 
                                    <input type="text" class="form-control float rede_unit calculateamt rede_unit" name="rede_unit[]"   id="rede_unit_1" data-id='1' > 
                                </td>
                                <td> 
                                    <input type="text" class="form-control float rede_qty calculateamt rede_qty" name="rede_qty[]"   id="rede_qty_1" data-id='1' > 
                                </td>
                                <td> 
                                    <input type="text" class="form-control  rede_remarks " id="rede_remarks_1" name="rede_remarks[]"  data-id='1'> 
                                </td>
                                <td>
                                     <div class="actionDiv acDiv2"></div>
                                    <!-- <a href="javascript:void(0)" class="btn btn-primary btnAdd" data-id="1"  id="addOrder_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-plus" aria-hidden="true"></i></span></a> -->
                                </td>
                            </tr>    
                        </tbody>
                    <tr>
                        <td colspan="7">
                            <a href="javascript:void(0)" class="btn btn-primary btnAdd pull-right" data-id="1"  id="addOrder_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-plus" aria-hidden="true"></i></span></a>
                        </td>
                    </tr>
                    </tbody>
            </table>
            <div id="Printable" class="print_report_section printTable">
                
            </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($item_data)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($item_data)?'Update':'Save' ?></button>
                <button type="submit" class="btn btn-info savePrint" data-operation='<?php echo !empty($item_data)?'update':'save ' ?>' id="btnSubmit" data-print="print"><?php echo !empty($item_data)?'Update':'Save & Print' ?></button>
            </div>
              <div class="col-sm-12">
                <div  class="alert-success success"></div>
                <div class="alert-danger error"></div>
              </div>
        </div>

<script type="text/javascript">
   $(document).off('click','.btnAdd');
    $(document).on('click','.btnAdd',function(){
        var id=$(this).data('id');
        var itemid=$('#rede_itemsid_'+id).val();
        var qty=$('#rede_itemsid_'+id).val();
        var rate=$('#rede_qty_'+id).val();
        var trplusOne = $('.orderrow').length+1;
        var trpluOne = $('.orderrow').length;
        var itemcode=$('#itemname_'+id).val(); 
        var code=$('#itemname_'+trplusOne).val(); 
        //alert(itemcode);
        
        if(itemcode=='' || itemcode==null )
            {
                $('#itemcode_'+trpluOne).focus();
                return false;
            }

        if(trplusOne==2)
        {

            $('.actionDiv').html('<a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="1"  id="addRequistion_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>');
        }
        var template='';
        template='<tr class="orderrow" id="orderrow_'+trplusOne+'" data-id="'+trplusOne+'"><td><input type="text" class="form-control sno" id="s_no_'+trplusOne+'" value="'+trplusOne+'" readonly/></td><td> <div class="dis_tab"> <input type="text" class="form-control itemcode enterinput " id="itemcode_1" name="itemcode[]" data-id="'+trplusOne+'" data-targetbtn="view"> <input type="hidden" class="itemid" name="rede_code[]" data-id="'+trplusOne+'" value="" id="itemid_"'+trplusOne+'""> <input type="hidden" class="matdetailid" name="rede_code[]" data-id="'+trplusOne+'" value="" id="matdetailid_"'+trplusOne+'""> <input type="hidden" class="controlno" name="controlno[]" data-id="'+trplusOne+'" value="" id="controlno_"'+trplusOne+'""> <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading="Item List" data-viewurl="<?php echo base_url(' stock_inventory/item/list_item_with_stock_transfer '); ?>" data-id="'+trplusOne+'" id="view_"'+trplusOne+'""><strong>...</strong></a> </div></td><td> <input type="text" class="form-control itemname" id="itemname_'+trplusOne+'" name="rede_itemsid[]" data-id="'+trplusOne+'"></td><td><input type="text" class="form-control float rede_qty calculateamt" name="rede_qty[]" id="rede_qty_'+trplusOne+'" data-id='+trplusOne+' ></td><td> <input type="text" class="form-control float rede_unit calculateamt rede_unit" name="rede_unit[]"  id="orma_unitprice_'+trplusOne+'" data-id="'+trplusOne+'" ></td><td> <input type="text" class="form-control  rede_remarks " id="rede_remarks'+trplusOne+'" name="rede_remarks[]"  data-id="'+trplusOne+'"> </td><td><a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="'+trplusOne+'"  id="addRequistion_'+trplusOne+'"><span class="btnChange" id="btnChange_'+trplusOne+'"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a></div></td><td> <div class="actionDiv"></td></tr>';
         // $('#addOrder_'+id).removeClass('btn btn-primary btnAdd').addClass('btn btn-danger btnRemove');
         // $('#btnChange_'+id).html('<i class="fa fa-trash-o" aria-hidden="true"></i>');
        $('#itemcode_'+trplusOne).focus();
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
    $(document).on('click','.itemDetail',function(){
    var rowno=$(this).data('rowno');
    var rate=$(this).data('rate');
    var itemcode=$(this).data('itemcode');
    var itemname=$(this).data('itemname');
    var itemid=$(this).data('itemid');
    var stockqty=$(this).data('stockqty');
    var matdetailid=$(this).data('mattransdetailid');
    var controlno=$(this).data('controlno');
    $('#itemcode_'+rowno).val(itemcode);
    $('#itemid_'+rowno).val(itemid);
    $('#itemname_'+rowno).val(itemname);
    $('#itemstock_'+rowno).val(stockqty);
    $('#matdetailid_'+rowno).val(matdetailid);
    $('#controlno_'+rowno).val(controlno);
    $('#myView').modal('hide');
    $('#dis_qty_'+rowno).focus();
 })
</script>

