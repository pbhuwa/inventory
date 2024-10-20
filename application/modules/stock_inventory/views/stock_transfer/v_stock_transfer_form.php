 <style>
    .purs_table tbody tr td{
        border: none;
        vertical-align: center;
    }
</style>
<form method="post" id="FormStockRequisition" action="<?php echo base_url('stock_inventory/stock_transfer/save_stocktransfer'); ?>" data-reloadurl='<?php echo base_url('stock_inventory/stock_transfer/form_stocktransfer'); ?>' class="form-material form-horizontal form" >
        <div id="requisition">
        <div class="form-group">
            <!-- <div class="col-md-3">
                <label for="example-text"><?php echo $this->lang->line('req_no'); ?>:<span class="required">*</span>:</label>
                <input type="text" class="form-control float" name="rema_reqno" id="reqno"  value="" placeholder="Req. No.">
            </div> -->

            <div class="col-md-3">  
              <label for="example-text"><?php echo $this->lang->line('req_no'); ?>:<span class="required">*</span>:</label>
              <div class="dis_tab">
                <input type="hidden" id="masterid" name="id" value="">
                  <input type="text" class="form-control required_field reqno send_after_stop number enterinput " name="rema_reqno"  value="" placeholder="Enter Req No." id="req_no" data-targetbtn="SrchReq">
                  <a href="javascript:void(0)" class="table-cell width_30 btn btn-success"  id="SrchReq"><i class="fa fa-search"></i></a>&nbsp;
                  <a href="javascript:void(0)" data-type="transfer"  data-id="0" data-displaydiv="Issue" data-viewurl="<?php echo base_url() ?>stock_inventory/stock_requisition/load_requisition" class="view table-cell width_30 btn btn-success" data-heading="Load Requisition" id="reqload" ><i class="fa fa-upload"></i></a>
              </div>
            </div>
            <div class="col-md-3">
               
                <label for="example-text"><?php echo $this->lang->line('from_store'); ?><span class="required">*</span>:</label>
                <?php $store=!empty($depart)?$depart:''; ?>
                <select name="from_store" class="form-control select2" id="frmstore" >
                  <?php
                     if($equipmnt_type): 
                     foreach ($equipmnt_type as $ket => $etype):
                     ?>
                    <option value="<?php echo $etype->eqty_equipmenttypeid; ?>" <?php echo ($etype->eqty_equipmenttypeid == $this->storeid)?'selected="selected"':""; ?> ><?php echo $etype->eqty_equipmenttype; ?></option>
                 <?php endforeach; endif; ?>
                </select>
               <!--  <input type="hidden" id="frmstore" name="from_store"/> -->
            </div>
            <div class="col-md-3">
                <label for="example-text"><?php echo $this->lang->line('to_store'); ?> <span class="required">*</span>:</label>
                <select name="to_store" class="form-control  select2" id="tostore">
                    <?php

                     if($equipmnt_type): 
                     foreach ($equipmnt_type as $ket => $etype):
                     ?>
                    <option value="<?php echo $etype->eqty_equipmenttypeid; ?>" <?php echo ($etype->eqty_equipmenttypeid != $this->storeid)?'selected="selected"':""; ?>><?php echo $etype->eqty_equipmenttype; ?></option>
                 <?php endforeach; endif; ?>
                </select>

            </div>
            <div class="col-md-3">
              <label for="example-text"><?php echo $this->lang->line('dispatch_by'); ?>:<span class="required">*</span>:</label>
                <input type="text" class="form-control required_field" name="trma_reqby" value="" placeholder="Dispatch By ">
            </div>
        </div>
        <div class="form-group"> 
            <div class="col-md-3">
              <label for="example-text"><?php echo $this->lang->line('dispatch_date'); ?><span class="required">*</span>: </label>
              <input type="text" name="trma_dispatch_date" class="form-control required_field <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Dispatch Date" value="<?php echo !empty($equip_data[0]->trma_dispatch_date)?$equip_data[0]->trma_dispatch_date:DISPLAY_DATE; ?>" id="DispatchDate">
              <span class="errmsg"></span>
            </div>
            <div class="col-md-3">
                <label for="example-text"><?php echo $this->lang->line('dispatch_to'); ?>:</label>
                <input type="text" class="form-control" name="trma_toby" value="" placeholder="Dispatch To ">
            </div>
            <div class="col-md-3">
                <?php ?>
                <label for="example-text"><?php echo $this->lang->line('transfer_number'); ?> :</label>
                <input type="text" class="form-control" name="transfer_number" value="" id="tno" readonly>
            </div>
            <div class="col-md-3">
               
                <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?> :</label>
               <!--  <input type="text" class="form-control" name="sama_fyear" id="fiscal_year" value="<?php echo $sama_fyear; ?>" placeholder="Fiscal Year" > -->
               <select name="sama_fyear" class="form-control" id="fyear">
                   <?php
                     if($fiscal_year): 
                     foreach ($fiscal_year as $kf => $fyrs):
                     ?>
                    <option value="<?php echo $fyrs->fiye_name; ?>" <?php if($fyrs->fiye_status=='I') echo "selected=selected"; ?> ><?php echo $fyrs->fiye_name; ?></option>
                 <?php endforeach; endif; ?>
               </select>
            </div>
        </div>
      
              <div class="clearfix"></div> 
      <div class="form-group">
      <div class="stock_table" id="DisplayPendingListTransfer">
          <table style="width:100%;" class="table dataTable dt_alt purs_table">
              <thead>
                  <tr>
                    <th scope="col" width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <th scope="col" width="10%"><?php echo $this->lang->line('item_code'); ?></th>
                    <th scope="col" width="15%"><?php echo $this->lang->line('item_name'); ?></th>
                    <th scope="col" width="10%"><?php echo $this->lang->line('unit'); ?></th>
                    <th scope="col" width="10%"><?php echo $this->lang->line('volume'); ?></th>
                    <th scope="col" width="10%"><?php echo $this->lang->line('stock_quantity'); ?></th>
                    <th scope="col" width="10%"><?php echo $this->lang->line('req_qty'); ?></th>
                    <th scope="col" width="10%"><?php echo $this->lang->line('dispatch_qty'); ?></th>
                    <th scope="col" width="15%"><?php echo $this->lang->line('remarks'); ?></th>
                    <th scope="col" width="5%"><?php echo $this->lang->line('action'); ?></th>
                      <!-- <th width="5%"> <?php echo $this->lang->line('sn'); ?> </th>
                      <th width="10%"><?php echo $this->lang->line('item_code'); ?> <span class="required">*</span></th>
                      <th width="15%"><?php echo $this->lang->line('item_name'); ?></th>
                      <th width="5%"><?php echo $this->lang->line('stock'); ?></th>
                      <th width="15%"><?php echo $this->lang->line('dispatch_qty'); ?><span class="required">*</span></th>
                      <th width="30%"><?php echo $this->lang->line('remarks'); ?></th>
                      <th width="5%"><?php echo $this->lang->line('action'); ?></th> -->
                  </tr>
              </thead>
                 <tbody id="stock_tranBody">
                  <?php if($pending_list){ //echo"<pre>"; print_r($req_details);die;
                      foreach ($pending_list as $key => $det) { 
                   ?>
                      <tr class="stockBdy" id="stockBdy_<?php echo $key+1; ?>" data-id='<?php echo $key+1; ?>'>
                          <td>
                              <input type="text" class="form-control sno" id="s_no_<?php echo $key+1; ?>" value="<?php echo $key+1; ?>" readonly/>
                          </td>
                          <td>
                              <div class="dis_tab"> 
                                <input type="text" class="form-control itemcode enterinput " id="itemcode_<?php echo $key+1; ?>" name="itemcode[]"  data-id='<?php echo $key+1; ?>' data-targetbtn='view' value="<?php echo $det->itli_itemcode; ?>">
                                <input type="hidden" class="itemid" name="itemid[]" data-id='<?php echo $key+1; ?>' value="<?php echo $det->itli_itemlistid; ?>" id="itemid_<?php echo $key+1; ?>">
                                <input type="hidden" class="matdetailid" name="matdetailid[]" data-id='<?php echo $key+1; ?>' value="" id="matdetailid_<?php echo $key+1; ?>">
                                <input type="hidden" class="mattransmasterid" name="mattransmasterid[]" data-id='<?php echo $key+1; ?>' value="" id="mattransmasterid_<?php echo $key+1; ?>">
                                  <input type="hidden" class="controlno" name="controlno[]" data-id='<?php echo $key+1; ?>' value="" id="controlno_<?php echo $key+1; ?>">
                                <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading='Item List' data-viewurl='<?php echo base_url('stock_inventory/item/list_item_with_stock_transfer'); ?>' data-id='<?php echo $key+1; ?>' id="view_<?php echo $key+1; ?>"><strong>...</strong></a>
                              </div> 
                          </td>
                          <td>  
                          <input type="text" class="form-control itemname" id="itemname_<?php echo $key+1; ?>" name="itemname[]"  data-id='<?php echo $key+1; ?>' value="<?php echo $det->itli_itemname; ?>"> 

                          </td>
                          <td> 
                              <input type="text" class="form-control number itemstock" name="itemstock[]"   id="itemstock_<?php echo $key+1; ?>" data-id='<?php echo $key+1; ?>' readonly="true"  value="<?php echo $det->rede_qtyinstock; ?>"> 
                          </td>
                          <td> 
                                <input type="text" class="form-control number dis_qty" name="dis_qty[]"   id="dis_qty_<?php echo $key+1; ?>" data-id='<?php echo $key+1; ?>' value="<?php echo $det->rede_remqty; ?>"> 
                          </td>
                          <td> 
                                <input type="text" class="form-control remarks " id="remarks_<?php echo $key+1; ?>" name="remarks[]"  data-id='<?php echo $key+1; ?>' value="<?php echo $det->rede_remarks ?>"> 
                          </td>
                         <!--  <td> 
                                  <input type="text" class="form-control expdate " id="expdate_<?php echo $key+1; ?>" name="expdate[]"  data-id='<?php echo $key+1; ?>'> 
                          </td> -->
                          <td>
                              <div class="actionDiv acDiv2"></div>
                          </td>
                      </tr> 
                  <?php } }  ?>   
              </tbody>
      </table>
      </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <button type="submit" class="btn btn-info  save" accesskey="n" data-operation='<?php echo !empty($item_data)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($item_data)?'Update':'Save' ?></button>
                <button type="submit" class="btn btn-info save" data-operation='<?php echo !empty($item_data)?'update':'save ' ?>' id="btnSavenPrint" data-print="print"><?php echo !empty($item_data)?'Update':'Save & Print' ?></button>
            </div>
              <div class="col-sm-12">
                <div  class="alert-success success"></div>
                <div class="alert-danger error"></div>
                <div class="showPrintedArea"></div>
              </div>
        </div>

<script type="text/javascript">
   // $(document).off('click','.btnAddtrans');
   //  $(document).on('click','.btnAddtrans',function(){
   //      var id=$(this).data('id');
   //      var storeid=$('#frmstore').val();
   //      var trplusOne = $('.stockBdy').length+1;
   //      if(trplusOne==2)
   //      {

   //          $('.actionDiv').html('<a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="1"  id="addRequistion_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>');
   //      }
   //      var template='';
   //      template='<tr class="stockBdy" id="stockBdy_'+trplusOne+'" data-id="'+trplusOne+'"><td><input type="text" class="form-control sno" id="s_no_'+trplusOne+'" value="'+trplusOne+'" readonly/></td><td><div class="dis_tab"><input type="text" class="form-control itemcode enterinput " id="itemcode_'+trplusOne+'" name="itemcode[]"  data-id="'+trplusOne+'" data-targetbtn="view" ><input type="hidden" class="itemid" name="itemid[]" data-id="'+trplusOne+'" value="" id="itemid_'+trplusOne+'">   <input type="hidden" class="matdetailid" name="matdetailid[]" data-id="'+trplusOne+'" value=""  id="matdetailid_'+trplusOne+'"><input type="hidden" class="controlno" name="controlno[]" data-id="'+trplusOne+'" value=""  id="controlno_'+trplusOne+'"><a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading="Item List" data-viewurl="<?php echo base_url("stock_inventory/item/list_item_with_stock_transfer"); ?>/"  data-id="'+trplusOne+'" id="view_'+trplusOne+'" data-storeid='+storeid+'><strong>...</strong></a></div></td><td><input type="text" class="form-control itemname" id="itemname_'+trplusOne+'" name="itemname[]"  data-id="'+trplusOne+'"> </td><td><input type="text" class="form-control number itemstock" name="itemstock[]"   id="itemstock_'+trplusOne+'" data-id="'+trplusOne+'" readonly="true" ></td> <td><input type="text" class="form-control number dis_qty" name="dis_qty[]" id="dis_qty_'+trplusOne+'" data-id="'+trplusOne+'" ></td><td><input type="text" class="form-control remarks " id="remarks_'+trplusOne+'" name="remarks[]"  data-id="'+trplusOne+'"></td><td><input type="text" class="form-control expdate " id="expdate_'+trplusOne+'" name="expdate[]"  data-id="'+trplusOne+'"></td><td> <div class="actionDiv"><a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="'+trplusOne+'"  id="addRequistion_'+trplusOne+'"><span class="btnChange" id="btnChange_'+trplusOne+'"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a></div></td></td></tr>';
   //       $('#stock_tranBody').append(template);
   //       $('#itemcode_'+trplusOne).focus();
   //  });
   //  $(document).off('click','.btnRemove');
   //  $(document).on('click','.btnRemove',function(){
   //      var id=$(this).data('id');
   //       var whichtr = $(this).closest("tr");
   //       var conf = confirm('Are Your Want to Sure to remove?');
   //        if(conf)
   //        {
   //           var trplusOne = $('.stockBdy').length+1;
   //           // console.log(trplusOne);
   //           // $('#stockBdy_'+id).fadeOut(500, function(){ 
   //           // $('#stockBdy_'+id).remove();
   //           //  });
   //           whichtr.remove(); 
   //          //  for (var i = 0; i < trplusOne; i++) {
   //          //   $('#s_no_'+i).val(i);
   //          // }
   //          setTimeout(function(){
   //                $(".stockBdy").each(function(i,k) {
   //                  var vali=i+1;
   //                  $(this).attr("id","stockBdy_"+vali);
   //                  $(this).attr("data-id",vali);    
   //                  $(this).find('.sno').attr("id","s_no_"+vali);
   //                  $(this).find('.sno').attr("value",vali);
   //                  $(this).find('.orma_itemid').attr("id","orma_itemid_"+vali);
   //                  $(this).find('.orma_qty').attr("id","orma_qty_"+vali);
   //                  $(this).find('.orma_qty').attr("data-id",vali);
   //                  $(this).find('.orma_unitprice').attr("id","orma_unitprice_"+vali);
   //                  $(this).find('.orma_unitprice').attr("data-id",vali);
   //                  $(this).find('.totalamount').attr("id","totalamount_"+vali);
   //                  $(this).find('.totalamount').attr("data-id",vali);
   //                  $(this).find('.btnAdd').attr("id","addOrder_"+vali);
   //                  $(this).find('.btnAdd').attr("data-id",vali);
   //                  $(this).find('.btnRemove').attr("id","addOrder_"+vali);
   //                  $(this).find('.btnRemove').attr("data-id",vali);
   //                  $(this).find('.btnChange').attr("id","btnChange_"+vali);
   //          });
   //            },600);
   //        }
   //   });
</script>

<script type="text/javascript">
$(document).off('change');
  $(document).on('change','#frmstore',function()
  {
      var heading=$('.view').data('heading');
      // $('#reqload').removeAttr('data-heading');
      // alert(heading);
      var depid= $(this).val();
      var depname='';
      // var depname=$(this).text();
      var depname=$("#frmstore option:selected").text();

      $('#frmstore').val(from_store);
      // alert(depname);
      var new_heading='Load Requisition'+'-'+depname;

      // console.log(depid);
      $('#reqload').attr('data-id',fromstore);
      $('#reqload').data('id',fromstore);

     
      $('#reqload').attr('data-heading',new_heading);
      $('#reqload').data('heading',new_heading);
      
     // var depid= $(this).val();
     // $('.view').removeAttr('data-id');
     // setTimeout(function(){
     //      $('#reqload').data('id',depid);
     // },2000);
     
  })

  $(document).off('change','#frmstore');
  $(document).on('change','#frmstore',function(e){
    var storeid=$(this).val();
    var action=base_url+'stock_inventory/stock_transfer/get_max_issue_no';
    $('.view').data('storeid',storeid);
    $.ajax({
          type: "POST",
          url: action,
          data:{storeid:storeid},
          dataType: 'json',
         success: function(datas) 
          {
            $('#tno').val(datas);
          }
      });
  })
  $(document).on('keyup change paste','.dis_qty',function(){
      var id=$(this).data('id');
      var dis_qty=parseInt($(this).val());
      var stockqty=parseInt($('#itemstock_'+id).val());
      // alert(stockqty);
      if(dis_qty >stockqty)
      {
          alert('Issue qty. is greater then stock qty!! ');
          $(this).val(stockqty);
          return false;
      }
      return false;
  })
</script>
<!-- This is for loading pending lists -->
<script type="text/javascript">
  function getPendingList(req_masterid, main_form=false,tran=false){
            if(tran == 'transfer')
            {
              var submiturl = base_url+'stock_inventory/stock_requisition/load_pendinglist/transfer';
              var displaydiv = '#DisplayPendingListTransfer';
            }else if(main_form == 'main_form'){
                var submiturl = base_url+'stock_inventory/stock_requisition/load_pendinglist/new_issue_pending_list';
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
    var to_storeid= $('#tostore').val();
    var submitdata = {req_no:req_no,fyear:fyear,to_storeid:to_storeid};
    var submiturl = base_url+'stock_inventory/stock_transfer/transferlist_by_req_no';
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
            
            getPendingList(data.masterid,'','transfer');
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
   ajax_search_requistion();
});
setInterval(blink_text, 3000);
</script>

<script type="text/javascript">
    $(document).off('click','#SrchReq');
    $(document).on('click','#SrchReq',function(){
    ajax_search_requistion();
    });
    
</script>

<?php if(!empty($reqno))
    {
      ?>
    <script>
        $(document).ready(function(){
            // $('.view').trigger("click");
           // $(this).trigger("enterKey");
           $('#SrchReq').click();
       });
        
    </script>
<?php } ?>