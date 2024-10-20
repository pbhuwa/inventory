 <style>
        .purs_table tbody tr td{
            border: none;
            vertical-align: center;
        }
    </style>
<form method="post" id="FormDirectReceive" action="<?php echo base_url('purchase_receive/direct_receive/save_direct'); ?>" class="form-material form-horizontal form" data-reloadurl="<?php echo base_url('purchase_receive/direct_receive/form_direct_receive'); ?>">
    <input type="hidden" name="id" value="<?php //echo!empty($item_data[0]->itli_itemlistid)?$item_data[0]->itli_itemlistid:'';  ?>">
        <div class="form-group">
            <div class="col-md-2 col-sm-2">
                <?php $receive_no = $last_receiveno+1 ?>
                <label for="example-text"><?php echo $this->lang->line('direct_receive_no'); ?> <span class="required">*</span>:</label>
                <input type="text" class="form-control" name="receive_no"  value="<?php echo $receive_no; ?>" readonly="true" readonly>
            </div>
            <div class="col-md-2 col-sm-2">
                <label for="example-text"><?php echo $this->lang->line('manual_no'); ?> <span class="required">*</span>:</label>
                <input type="text" class="form-control required_field" name="manual_no"  value="">
            </div>
            <div class="col-md-2 col-sm-2">
                <label for="example-text"><?php echo $this->lang->line('date'); ?> :</label>
                <input type="text" name="receive_date" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Service Start Date" value="<?php echo !empty($equip_data[0]->receive_date)?$equip_data[0]->receive_date:DISPLAY_DATE; ?>" id="ServiceStart">
                <span class="errmsg"></span>
            </div>
            <div class="col-md-2 col-sm-2">
                <?php $locid= 1 ?>
                <label for="example-text"><?php echo $this->lang->line('from'); ?> <span class="required">*</span>:</label>
                <select name="receive_from" class="form-control select2" >
                    <option value="">---select---</option>
                    <?php
                        if($location):
                            foreach ($location as $km => $loc):
                    ?>
                     <option value="<?php echo $loc->loca_locationid; ?>"  <?php if($locid==$loc->loca_locationid) echo "selected=selected"; ?>><?php echo $loc->loca_name; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </select>
            </div>

            <div class="col-md-2 col-sm-2">
                <?php $locid=$this->session->userdata(LOCATION_ID); ?>
                <label for="example-text"><?php echo $this->lang->line('to'); ?> <span class="required">*</span>:</label>
                <select name="receive_to" class="form-control select2">
                    <option value="">---select---</option>
                    <?php
                        if($location):
                            foreach ($location as $km => $loc):
                    ?>
                     <option value="<?php echo $loc->loca_locationid; ?>"  <?php if($locid==$loc->loca_locationid) echo "selected=selected"; ?>><?php echo $loc->loca_name; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </select>
            </div> 

            <div class="col-md-2 col-sm-2">
                <?php $reorderlevel=!empty($item_data[0]->trma_fromby)?$item_data[0]->trma_fromby:''; ?>
                <label for="example-text"><?php echo $this->lang->line('received_by'); ?> :</label>
                <input type="text" class="form-control" name="receive_by" value="<?php echo $reorderlevel; ?>" placeholder="">
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-12 col-sm-12">
                <label for="example-text"><?php echo $this->lang->line('remarks'); ?> <span class="required">*</span>:</label>
                <textarea rows="3" cols="40" class="form-control required_field" name="remarks" placeholder="" ></textarea> 
            </div>
        </div>

        <div class="form-group">
            <div class="table-responsive col-sm-12">
                <table style="width:100%;" class="table dataTable dt_alt purs_table">
                    <thead>
                        <tr>
                            <th width="5%"> <?php echo $this->lang->line('sn'); ?> </th>
                            <th width="10%"> <?php echo $this->lang->line('item_code'); ?>  </th>
                            <th width="20%"> <?php echo $this->lang->line('item_name'); ?> </th>
                            <th width="8%"> <?php echo $this->lang->line('unit'); ?>  </th>
                            <th width="8%"> <?php echo $this->lang->line('qty'); ?> </th>
                            <th width="8%"> <?php echo $this->lang->line('rate'); ?> </th>
                            <th width="5%"> <?php echo $this->lang->line('action'); ?></th>
                        </tr>
                    </thead>
                    <tbody id="purchaseBody">
                        <tr class="directrow" id="directrow_1" data-id='1'>
                            <td>
                                <input type="text" class="form-control sno" id="s_no_1" value="1" readonly/>
                            </td>
                            <td>
                                <div class="dis_tab"> 
                                    <input type="text" class="form-control itemcode enterinput " id="itemcode_1" name="itemcode[]"  data-id='1' data-targetbtn='view'>
                                    <input type="hidden" class="qude_itemsid" name="trde_itemsid[]" data-id='1' value="" id="itemid_1">
                                    <input type="hidden" class="itemsid" name="itemsid[]" data-id='1' value="" id="matdetailid_1">
                                    <input type="hidden" class="controlno" name="controlno[]" data-id='1' value="" id="controlno_1">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading='Item List' data-viewurl='<?php echo base_url('stock_inventory/item/list_item_with_stock_transfer'); ?>' data-id='1' id="view_1"><strong>...</strong></a>
                                </div>
                            </td>
                            <td>  
                                <input type="text" class="form-control itemname" id="itemname_1" name="itemname[]"  data-id='1'>
                            </td>
                               
                            <td> 
                                <input type="text" class="form-control float trde_unitpercase calculateamt trde_unitpercase" name="trde_unitpercase[]"   id="trde_unitpercase_1" data-id='1' > 
                            </td>
                            <td> 
                                <input type="text" class="form-control float trde_issueqty calculateamt trde_issueqty" name="trde_issueqty[]"   id="trde_issueqty_1" data-id='1' > 
                            </td>
                            <td> 
                                <input type="text" class="form-control float trde_unitprice calculateamt trde_unitprice" name="trde_unitprice[]"   id="trde_unitprice_1" data-id='1' > 
                            </td>
                            <td>
                                <div class="actionDiv acDiv2"></div>
                            </td>
                        </tr> 
                    </tbody>
                    <tr>
                        <td colspan="7">
                            <a href="javascript:void(0)" class="btn btn-primary btnAdd pull-right" data-id="1"  id="addOrder_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-plus" aria-hidden="true"></i></span></a>
                        </td>
                    </tr>
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
        var itemid=$('#trde_itemsid_'+id).val();
        // var itemname=$('#itemname_'+id).val();

        var qty=$('#trde_unitpercase_'+id).val();
        var rate=$('#rede_qty_'+id).val();
        var trplusOne = $('.directrow').length+1;
        // if(itemid=='' || itemid==null )
            // {
            //     $('#orma_itemid_'+id).focus();
            //     return false;
            // }
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
        if(trplusOne==2)
        {

            $('.actionDiv').html('<a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="1"  id="addRequistion_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>');
        }
        var trplusOne = $('.directrow').length+1;
        var template='';
        template='<tr class="directrow" id="directrow_'+trplusOne+'" data-id="'+trplusOne+'"><td><input type="text" class="form-control sno" id="s_no_'+trplusOne+'" value="'+trplusOne+'" readonly/></td><td> <div class="dis_tab"> <input type="text" class="form-control itemcode enterinput " id="itemcode_'+trplusOne+'" name="itemcode[]" data-id="'+trplusOne+'" data-targetbtn="view"> <input type="hidden" class="qude_itemsid" name="trde_itemsid[]" data-id="'+trplusOne+'" value="" id="itemid_'+trplusOne+'"> <input type="hidden" class="itemsid" name="itemsid[]" data-id="'+trplusOne+'" value="" id="matdetailid_'+trplusOne+'"> <input type="hidden" class="controlno" name="controlno[]" data-id="'+trplusOne+'" value="" id="controlno_'+trplusOne+'"> <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading="Item List" data-viewurl="<?php echo base_url('stock_inventory/item/list_item_with_stock_transfer'); ?>" data-id="'+trplusOne+'" id="view_'+trplusOne+'"><strong>...</strong></a> </div></td><td> <input type="text" class="form-control itemname" id="itemname_'+trplusOne+'" name="itemname[]" data-id="'+trplusOne+'"> </td><td><input type="text" class="form-control float trde_unitpercase calculateamt" name="trde_unitpercase[]" id="trde_unitpercase_'+trplusOne+'" data-id="'+trplusOne+'"></td><td><input type="text" class="form-control float trde_issueqty calculateamt trde_issueqty" name="trde_issueqty[]"  id="trde_issueqty_'+trplusOne+'" data-id="'+trplusOne+'" ></td><td> <input type="text" class="form-control float trde_unitprice calculateamt trde_unitprice" name="trde_unitprice[]" id="trde_unitprice_'+trplusOne+'"></td><td> <div class="actionDiv"><a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="'+trplusOne+'"  id="addRequistion_'+trplusOne+'"><span class="btnChange" id="btnChange_'+trplusOne+'"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a></div></td></tr>';
         // $('#addOrder_'+id).removeClass('btn btn-primary btnAdd').addClass('btn btn-danger btnRemove');
         // $('#btnChange_'+id).html('<i class="fa fa-trash-o" aria-hidden="true"></i>');
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
                    $(this).find('.itemname').attr("id","itemname_"+vali);
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
    $(document).off('click','.itemDetail');
    $(document).on('click','.itemDetail',function(){
        var rowno=$(this).data('rowno');
        var rate=$(this).data('rate');
        var itemcode=$(this).data('itemcode');
        var itemname=$(this).data('itemname');
        var itemname_display=$(this).data('itemname_display');
        var itemid=$(this).data('itemid');
        var stockqty=$(this).data('stockqty');
        var matdetailid=$(this).data('mattransdetailid');
        var controlno=$(this).data('controlno');
        $('#itemcode_'+rowno).val(itemcode);
        $('#itemid_'+rowno).val(itemid);
        // $('#itemname_'+rowno).val(itemname);
        $('#itemname_'+rowno).val(itemname_display);

        $('#itemstock_'+rowno).val(stockqty);
        $('#matdetailid_'+rowno).val(matdetailid);
        $('#controlno_'+rowno).val(controlno);
        $('#myView').modal('hide');
        $('#dis_qty_'+rowno).focus();
     })
</script>