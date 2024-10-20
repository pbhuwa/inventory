 <style>
        .purs_table tbody tr td{
            border: none;
            vertical-align: center;
        }
    </style>
<form method="post" id="FormStockRequisition" action="<?php echo base_url('stock_inventory/stock_requisition/save_requisition'); ?>" class="form-material form-horizontal form" >
    <input type="hidden" name="id" value="<?php //echo!empty($item_data[0]->itli_itemlistid)?$item_data[0]->itli_itemlistid:'';  ?>">
        <div class="form-group">
            <div class="col-md-4">
                <?php $reqno=!empty($item_data[0]->rema_reqno)?$item_data[0]->rema_reqno:''; ?>
                <label for="example-text">REQ NO :<span class="required">*</span>:</label>
                <input type="text" class="form-control" name="rema_reqno"  value="<?php echo $reqno; ?>" placeholder="Enter REQ Number">
            </div>
            <div class="col-md-4">
              <label for="example-text">CHOOSE  : </label><br>

              <?php $rema_storeid=!empty($equip_data[0]->rema_storeid)?$equip_data[0]->rema_storeid:''; ?>
              <input type="radio" class="mbtm_13" name="rema_storeid" value="issue" <?php if($rema_storeid=='issue') echo "checked=checked"; ?>  >ISSUE
              <input type="radio" class="mbtm_13" name="rema_storeid" value="transfer" checked="checked" >TRANSFER
            </div>
            <div class="col-md-4">
                <?php $reorderlevel=!empty($item_data[0]->itli_reorderlevel)?$item_data[0]->itli_reorderlevel:''; ?>
                <label for="example-text">Reorder Level :</label>
                <input type="text" class="form-control" name="rema_reorderlevel" value="<?php echo $reorderlevel; ?>" placeholder="Enter Reorder Level">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-4">
                <?php $maxlimit=!empty($item_data[0]->rema_manualno)?$item_data[0]->rema_manualno:''; ?>
                <label for="example-text">Manual Number :</label>
                <input type="text" class="form-control float" name="rema_manualno"  value="<?php echo $maxlimit; ?>" placeholder="Enter Manual Number">
            </div>
        <div class="col-md-2">
                <label><?php echo $this->lang->line('date_search'); ?> :</label>
                <select name="searchDateType" id="searchDateType" class="form-control">
                    <option value="date_range">By Date Range</option>
                    <option value="date_all">All</option>
                </select>
            </div>
         <div class="dateRangeWrapper">
            <div class="col-md-4">
                <?php $depid=!empty($item_data[0]->rema_reqfromdepid)?$item_data[0]->rema_reqfromdepid:''; ?>
                <label for="example-text">FROM :<span class="required">*</span>:</label>
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
            </div>
            <div class="col-md-4">
                <label for="example-text">TO :</label>
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
        </div>
        <div class="clearfix"></div>    
        <div class="form-group">
            <div class="col-md-4">
               <div class="col-md-4">
                <?php $reorderlevel=!empty($item_data[0]->rema_reqby)?$item_data[0]->rema_reqby:''; ?>
                <label for="example-text">Posted BY :</label>
                <input type="text" class="form-control" name="rema_reqby" value="<?php echo $reorderlevel; ?>" placeholder="Enter Posted BY ">
            </div> 
            </div>
             <div class="col-md-4 col-sm-6 col-xs-6">
              <label for="example-text">Date Start: </label>
              <input type="text" name="rema_reqdatead" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Service Start Date" value="<?php echo !empty($equip_data[0]->rema_reqdatead)?$equip_data[0]->rema_reqdatead:DISPLAY_DATE; ?>" id="ServiceStart">
              <span class="errmsg"></span>
            </div>
        </div>
        <div class="form-group">
            <div class="table-responsive">
                <table style="width:100%;" class="table purs_table">
                    <thead>
                        <tr>
                            <th width="5%"> S.No. </th>
                            <th width="5%"> Code  </th>
                            <th width="10%"> Particular </th>
                            <th width="15%"> Unit  </th>
                            <th width="15%"> Req Quantity </th>
                            <th width="30%"> Remarks </th>
                            <th width="5%">Action</th>
                        </tr>
                    </thead>
                       <tbody id="orderBody">
                            <tr class="orderrow" id="orderrow_1" data-id='1'>
                                <td>
                                      <input type="text" class="form-control sno" id="s_no_1" value="1" readonly/>
                                </td>
                                <td> 
                                    <input type="text" class="form-control float rede_code calculateamt" id="rede_code_1" name="rede_code[]"  data-id='1'> 
                                </td>
                                <td>                             
                                    <select name="rede_itemsid[]" class="form-control rede_itemsid " id="rede_itemsid_1" >
                                        <option value="">---Select---</option>
                                        <?php if($item_all):
                                        foreach ($item_all as $key => $itm):?>
                                        <option value="<?php echo $itm->itli_itemlistid; ?>"><?php echo $itm->itli_itemname; ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
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
                                    <a href="javascript:void(0)" class="btn btn-primary btnAdd" data-id="1"  id="addOrder_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-plus" aria-hidden="true"></i></span></a>
                                </td>
                            </tr>    
                    </tbody>
                    <tr>
                    </tr>
                    </tbody>
                  
            </table>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($item_data)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($item_data)?'Update':'Save' ?></button>
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
        var template='';
        template='<tr class="orderrow" id="orderrow_'+trplusOne+'" data-id="'+trplusOne+'"><td><input type="text" class="form-control sno" id="s_no_'+trplusOne+'" value="'+trplusOne+'" readonly/></td><td><input type="text" class="form-control float rede_code calculateamt" id="rede_code_'+trplusOne+'" name="rede_code[]"  data-id='+trplusOne+'></td><td><select name="rede_itemsid[]" class="form-control rede_itemsid " id="rede_itemsid_'+trplusOne+'" ><option value="">---Select---</option><?php if($item_all):
                foreach ($item_all as $key => $itm):?> <option value="<?php echo $itm->itli_itemlistid; ?>"><?php echo $itm->itli_itemname; ?></option> <?php endforeach; endif; ?></select></td><td><input type="text" class="form-control float rede_qty calculateamt" name="rede_qty[]" id="rede_qty_'+trplusOne+'" data-id='+trplusOne+' ></td><td> <input type="text" class="form-control float rede_unit calculateamt rede_unit" name="rede_unit[]"  id="orma_unitprice_'+trplusOne+'" data-id="'+trplusOne+'" ></td><td> <input type="text" class="form-control  rede_remarks " id="rede_remarks'+trplusOne+'" name="rede_remarks[]"  data-id="'+trplusOne+'"> </td><td><a href="javascript:void(0)" class="btn btn-primary btnAdd" data-id="'+trplusOne+'"  id="addOrder_'+trplusOne+'"><span class="btnChange" id="btnChange_'+trplusOne+'"><i class="fa fa-plus" aria-hidden="true"></i></span></a></td></tr>';
         $('#addOrder_'+id).removeClass('btn btn-primary btnAdd').addClass('btn btn-danger btnRemove');
         $('#btnChange_'+id).html('<i class="fa fa-trash-o" aria-hidden="true"></i>');
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


    $(document).off('click','#searchByDate')
    $(document).on('click','#searchByDate',function(){
        frmDate=$('#frmDate').val();
        toDate=$('#toDate').val();
        
        locationid=$('#locationid').val();
        type=$('#searchByType').val(); 
        dtablelist.fnDraw();
    });

        $(document).off('change', '#searchDateType');
       $(document).on('change', '#searchDateType', function() {
        var search_date_val = $(this).val();

        if (search_date_val == 'date_all') {
            $('.dateRangeWrapper').hide();
        } else {
            $('.dateRangeWrapper').show();
        }
    });
       
</script>