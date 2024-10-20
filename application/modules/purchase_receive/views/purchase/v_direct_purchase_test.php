<style>
   .purs_table tbody tr td{
   border: none;
   vertical-align: center;
   }
</style>
<form method="post" id="FormIssueNew" action="<?php echo base_url('purchase_receive/direct_purchase/save_direct_pur_req'); ?>" data-reloadurl="<?php echo base_url('purchase_receive/direct_purchase/form_purchase_req');?>" class="form-material form-horizontal form">
   <?php
      $receivedmasterid = !empty($purchased_data[0]->recm_receivedmasterid)?$purchased_data[0]->recm_receivedmasterid:'';
      ?>
   <input type="hidden" name="id" value="<?php echo $receivedmasterid;  ?>">
   <div id="issueDetails">
      <div class="form-group">
         <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('receipt_no'); ?> <span class="required">*</span>:</label>
            <?php $receivedno=!empty($purchased_data[0]->recm_invoiceno)?$purchased_data[0]->recm_invoiceno:''; ?>
            <div class="dis_tab">
               <input type="text" class="form-control required_field enterinput"  name="receipt_no"  value="<?php echo !empty($receivedno)?$receivedno:$received_no; ?>" placeholder="" id="receipt_no">
            </div>
         </div>
         <div class="col-md-3 col-sm-4">
            <?php $supplierid=!empty($purchased_data[0]->recm_supplierid)?$purchased_data[0]->recm_supplierid:''; ?>
            <label for="example-text"><?php echo $this->lang->line('supplier_name'); ?>: <span class="required">*</span>:</label>
            <div class="dis_tab">
            <select name="supplier" id="direct_req_supplierid" class="form-control required_field select2 " >
               <option value="">---select---</option>
               <?php
                  if(!empty($distributor)):
                      foreach ($distributor as $km => $sup):
                  ?>
               <option value="<?php echo $sup->dist_distributorid; ?>"  <?php if($supplierid == $sup->dist_distributorid) echo "selected=selected" ?>><?php echo $sup->dist_distributor; ?></option>
               <?php
                  endforeach;
                  endif;
                  ?>
            </select>

            <a href="javascript:void(0)" class="table-cell frm_add_btn width_30 refresh_element" data-targetid="direct_req_supplierid" data-viewurl="<?php echo base_url('biomedical/distributors/distributor_reload'); ?>"><i class="fa fa-refresh"></i></a>
          <a href="javascript:void(0)" class="table-cell frm_add_btn width_30 view" data-heading='Supplier Entry' data-viewurl='<?php echo base_url('biomedical/distributors/supplier_entry/modal'); ?>'><i class="fa fa-plus"></i></a>
            </div>
         </div>
         <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('order_date'); ?>: </label>
            <input type="text" name="order_date" class="form-control <?php echo DATEPICKER_CLASS;?> date"  placeholder="Order Date" id="order_date" value="<?php echo !empty($purchased_data[0]->recm_purchaseorderdatebs)?$purchased_data[0]->recm_purchaseorderdatebs:DISPLAY_DATE; ?>">
            <span class="errmsg"></span>
         </div>
         <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('received_date'); ?>: </label>
            <input type="text" name="received_date" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Received Date" id="received_date"  value="<?php echo !empty($purchased_data[0]->recm_receiveddatebs)?$purchased_data[0]->recm_receiveddatebs:DISPLAY_DATE; ?>">
            <span class="errmsg"></span>
         </div>
      </div>
      <div class="clearfix"></div>
      <div class="form-group">
         <div class="col-md-3 col-sm-4">
            <?php if($reqno){
               $sama_reqnodb = !empty($reqno)?$reqno:'';
               }else{
               $sama_reqnodb = !empty($new_issue[0]->sama_requisitionno)?$new_issue[0]->sama_requisitionno:'';
               }
               ?>
            <label for="example-text"><?php echo $this->lang->line('req_no'); ?> <span class="required">*</span>:</label>
            <div class="dis_tab">
               <input type="text" class="form-control reqno send_after_stop number enterinput required_field " name="sama_requisitionno"  value="<?php echo $sama_reqnodb; ?>" placeholder="Enter Req No." id="req_no" data-targetbtn="SrchReq" autocomplete="off" autofocus="on">
               <a href="javascript:void(0)" class="table-cell width_30 btn btn-success"  id="SrchReq"><i class="fa fa-search"></i></a>&nbsp;
               <a href="javascript:void(0)"  data-id="0" data-fyear="<?php echo CUR_FISCALYEAR;?>" data-type="direct_purchase" data-displaydiv="Issue" data-viewurl="<?php echo base_url() ?>stock_inventory/stock_requisition/load_requisition" class="view table-cell width_30 btn btn-success" data-heading="<?php echo $this->lang->line('load_requisition')?>" id="reqload" ><i class="fa fa-upload"></i></a>
            </div>
         </div>
         <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('supplier_bill_no'); ?>:<span class="required">*</span> </label>
            <input type="text" name="suplier_bill_no" value="<?php echo !empty($purchased_data[0]->recm_supplierbillno)?$purchased_data[0]->recm_supplierbillno:''; ?>" class="form-control required_field"  placeholder="Supplier Bill No" >
            <span class="errmsg"></span>
         </div>
         <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('supplier_bill_date'); ?><span class="required">*</span>: </label>
            <input type="text" name="suplier_bill_date" class="form-control required_field <?php echo DATEPICKER_CLASS; ?> date "  placeholder="Sup.Bill No" id="receivedno" value="<?php echo !empty($purchased_data[0]->recm_supbilldatebs)?$purchased_data[0]->recm_supbilldatebs:DISPLAY_DATE; ?>" id="suplier_bill_date">
            <span class="errmsg"></span>
         </div>
         <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?><span class="required">*</span> :</label>
            <?php 
               $puorfyear=!empty($purchased_data[0]->recm_fyear)?$purchased_data[0]->recm_fyear:''; 
               ?>
            <select name="fiscalyearid" class="form-control required_field" id="fyear">
               <?php
                  if($fiscal):
                      foreach ($fiscal as $km => $fy):
                  ?>
               <?php
                  if(!empty($puorfyear)):
                  ?>
               <option value="<?php echo $fy->fiye_name; ?>" <?php if($puorfyear==$fy->fiye_name) echo "selected=selected"; ?>><?php echo $fy->fiye_name; ?></option>
               <?php else: ?>
               <option value="<?php echo $fy->fiye_name; ?>" <?php if($fy->fiye_status == 'I') echo "selected=selected"; ?>><?php echo $fy->fiye_name; ?></option>
               <?php endif;?>
               <?php
                  endforeach;
                  endif;
                  ?>
            </select>
         </div>
      </div>
      <div class="clearfix"></div>
      <div class="form-group">
         <div class="pad-5" id="DisplayPendingList">
            <div class="table-responsive">
               <table style="width:100%;" class="table purs_table dt_alt dataTable">
                  <thead>
                     <tr>
                       
                        <th width="2%"><?php echo $this->lang->line('sn'); ?></th>
                       <th width="12%"><?php echo $this->lang->line('item_code'); ?></th>
                       <th width="18%"><?php echo $this->lang->line('item_name'); ?></th>
                       <th width="5%"><?php echo $this->lang->line('unit'); ?> </th>
                       <th width="5%"><?php echo $this->lang->line('qty'); ?></th>
                       <th width="8%"><?php echo $this->lang->line('rate'); ?></th>
                       <th width="5%"><?php echo $this->lang->line('cc'); ?></th>
                       <th width="5%"><?php echo $this->lang->line('dis'); ?></th>
                       <th width="5%"><?php echo $this->lang->line('vat'); ?></th>
                       <th width="8%"><?php echo $this->lang->line('amount'); ?></th>
                       <th width="10%"><?php echo $this->lang->line('description'); ?></th>
                       <th width="5%"><?php echo $this->lang->line('action'); ?></th> 
                     </tr>
                  </thead>
                  <tbody id="orderBody">
                     <tr class="orderrow" id="orderrow_1" data-id='1'>
                        <?php $i=1; if($purchased_details):
                           foreach ($purchased_details as $key => $pd) { ?>
                        <td data-label="S.No."><?php echo $i; ?></td>
                        <td data-label="Items Code"> 
                           <input type="text" class="form-control float rede_code calculateamt" id="rede_code_1" name="rede_code[]" value="<?php //echo $isu->rede_itemsid;?>" data-id='1' readonly> 
                        </td>
                        <td data-label="Items Name">                             
                           <input type="text" class="form-control float rede_code calculateamt" id="rede_code_1" name="item[]" value="<?php echo $pd->rede_itemsid;?>" data-id='1' readonly> 
                        </td>
                        <td data-label="Unit"> 
                           <input type="text" class="form-control float rede_unit calculateamt rede_unit" name="particular[]" value="<?php echo $pd->rede_itemsid;?>"  id="rede_unit_1" data-id='1' > 
                        </td>
                        <td><input type="text" class="form-control float calamt" name="puit_qty[]" value="<?php echo !empty($pd->recd_purchasedqty)?$pd->recd_purchasedqty:'0'; ?>" data-id='<?php echo $key+1; ?>' id="puit_qty_<?php echo $key+1; ?>" placeholder="Qty">
                            </td>
                            <td>
                                <input type="text" class="form-control puit_unitprice float calamt" name="puit_unitprice[]" id="puit_unitprice_<?php echo $key+1; ?>" value="<?php echo !empty($pd->recd_unitprice)?$pd->recd_unitprice:'0'; ?>"  data-id='<?php echo $key+1; ?>' placeholder="Rate">
                                <input type="hidden" class="form-control unitprice float" name="unitprice[]" id="unitprice_<?php echo $key+1;?>" value="0"  data-id='1' placeholder="Rate">
                            </td>
                            <td>
                                <input type="text" class="form-control float calamt eachcc" name="cc[]" id="cc_<?php echo $key+1; ?>" value="<?php echo !empty($pd->recd_cccharge)?$pd->recd_cccharge:'0'; ?>"  data-id='<?php echo $key+1; ?>' placeholder="CC">
                            </td>
                            <td>
                                <input type="text" class="form-control discount float calamt " name="discount[]" id="discount_<?php echo $key+1; ?>"  value="<?php echo !empty($pd->recd_discountpc)?$pd->recd_discountpc:'0'; ?>"  data-id='<?php echo $key+1; ?>' placeholder="Dis">

                            </td>
                            <td>
                                <input type="text" class="form-control vat float calamt idfornot" name="vat[]" id="vat_<?php echo $key+1; ?>" value="<?php echo !empty($pd->recd_vatpc)?$pd->recd_vatpc:'0'; ?> "  data-id='<?php echo $key+1; ?>' placeholder="Vat">
                              
                            </td>
                            <td>
                                <?php $subtotal = ($pd->recd_purchasedqty)*($pd->recd_unitprice); ?>
                                <input type="text" name="totalamt[]" class="form-control eachtotalamt" value="<?php echo !empty($subtotal)?$subtotal:'0'; ?>"  id="totalamt_<?php echo $key+1; ?>" readonly="true"> 
                            </td>
                            <td>
                                <input type="text" class="form-control description" name="description[]" value="<?php echo !empty($pd->recd_description)?$pd->recd_description:''; ?>" data-id='<?php echo $key+1; ?>' placeholder="Description" id="description_<?php echo $key+1; ?>"> 
                            </td>
                        <?php $i++;
                           } endif;?>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
       <div class="roi_footer">
                    <div class="row">
                        <div class="col-sm-4">
                            <div>
                                <label for=""><?php echo $this->lang->line('remarks'); ?> : </label>
                                <textarea name="remarks" class="form-control" rows="4" placeholder=""></textarea>
                            </div>
                            
                        </div>
                        <div class="col-sm-6 pull-right">
                            <fieldset class="pull-right mtop_10 pad-top-14">
                                <ul>
                                     <li>
                                        <label><?php echo $this->lang->line('sub_total'); ?></label>
                                        <input type="text" class="form-control float" name="subtotalamt" id="subtotalamt" value=""  />
                                    </li>
                                    <li>
                                        <label><?php echo $this->lang->line('discount'); ?></label>
                                        <input type="text" class="form-control float" name="discountamt" id="discountamt" value="0" />
                                    </li>
                                    <!-- readonly="true" -->
                                   
                                    <li>
                                    <label><?php echo $this->lang->line('tax'); ?></label>
                                    <input type="text" class="form-control float" name="taxamt" id="taxamt" value=""  />

                                    </li>
                                     <li>
                                        <label><?php echo $this->lang->line('grand_total'); ?> </label>
                                        <input type="text" class="form-control float" name="totalamount" id="totalamount" />
                                    </li>

                                    <li>
                                    <label><?php echo $this->lang->line('extra'); ?></label>
                                   <input type="text" class="form-control float extra" name="extra" id="extra" value="0" />
                               </li>
                               <li>
                                    <label><?php echo $this->lang->line('rf'); ?></label>
                                   <input type="text" class="form-control float" name="rf" id="rf" value="" />
                               </li>
                                <li>
                                    <label><?php echo $this->lang->line('clearance_amt'); ?></label>
                                    <input type="text" class="form-control extra" name="clearanceamt" id="clearanceamt">
                                </li>
                            </ul>
                            </fieldset>
                        </div>
                    </div> 
                </div> 
      <div class="clearfix"></div>
   </div>
   <div class="form-group">
            <div class="col-md-12"> 
         <?php 
         $save_var=$this->lang->line('save');
         $save_n_print= $this->lang->line('save_and_print');
         $update_var= $this->lang->line('update');
         $update_n_print= $this->lang->line('update_and_print');?>      
                <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($purchased_data)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($purchased_data)?$update_var:$save_var ?></button>
                <button type="submit" class="btn btn-info savePrint" data-operation='<?php echo !empty($purchased_data)?'update':'save ' ?>' id="btnSubmit" data-print="print"><?php echo !empty($purchased_data)?$update_n_print:$save_n_print ?></button>
              
            </div>
              <div class="col-sm-12">
                <div  class="alert-success success"></div>
                <div class="alert-danger error"></div>
              </div>
        </div>
   <div id="Printable" class="print_report_section printTable"></div>
</form>
<script type="text/javascript">
   $.fn.pressEnter = function(fn) {  
   
   return this.each(function() {  
       $(this).bind('enterPress', fn);
       $(this).keyup(function(e){
           if(e.keyCode == 13)
           {
             $(this).trigger("enterPress");
           }
       })
   });  
   }; 
   
   
   
   
   $(document).off('change');
   $(document).on('change','#depnme',function()
   {
   var heading=$('.view').data('heading');
   // $('#reqload').removeAttr('data-heading');
   // alert(heading);
   
   var depid= $(this).val();
   var depname='';
   // var depname=$(this).text();
   var depname=$("#depnme option:selected").text();
   
   $('#depname').val(depname);
   // alert(depname);
   var new_heading='Load Requisition'+'-'+depname;
   
   // console.log(depid);
   $('#reqload').attr('data-id',depid);
   $('#reqload').data('id',depid);
   
   
   $('#reqload').attr('data-heading',new_heading);
   $('#reqload').data('heading',new_heading);
   
   // var depid= $(this).val();
   // $('.view').removeAttr('data-id');
   // setTimeout(function(){
   //      $('#reqload').data('id',depid);
   // },2000);
   
   })
   
</script>

<script type="text/javascript">
   function getPendingList(req_masterid, main_form=false){
          if(main_form == 'main_form'){
              var submiturl = base_url+'stock_inventory/stock_requisition/load_pendinglist/new_direct_purchase';
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
                              $('.calamt').change();
                          }
                      }
                  }else{
                      if(data.status == 'success'){
                          $(displaydiv).empty().html(data.tempform);
                          $('.calamt').change();
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
<?php if($reqno)
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
<script>
   $(document).off('change','#fyear');
   $(document).on('change','#fyear',function(){
       var fyear = $('#fyear').val();
       $('#reqload').attr('data-fyear',fyear);
   });
</script>

<script type="text/javascript">
    $(document).on('change keyup','.extra',function(){
    var totalamt=$('#totalamount').val();
    var extraamt=$('#extra').val();
    if(totalamt==null || totalamt=='' || totalamt=='NaN')
    {
        totalamt=0;
    }
    if(extraamt==null || extraamt=='')
    {
        extraamt=0;
    }
    var clearanceamt=parseFloat(totalamt)+parseFloat(extraamt);
    $('#clearanceamt').val(clearanceamt);
    })
    $(document).off('keyup change','.calamt');
    $(document).on('keyup change','.calamt',function(){
        var id=$(this).data('id');
        var qty=$('#puit_qty_'+id).val();
        if(qty ==null || qty==' ' || qty=='NaN')
        {
            qty=0;
        }
        var rate=$('#puit_unitprice_'+id).val();
        if(rate ==null || rate==' ' || rate=='NaN')
        {
            rate=0;
        }
        var discount=$('#discount_'+id).val();
        if(discount ==null || discount==' ' || discount=='NaN')
        {
            discount=0;
        }
        var vat =$('#vat_'+id).val();
        if(vat ==null || vat==' ' || vat=='NaN')
        {
            vat=0;
        }
        var cc=$('#cc_'+id).val();
        if(cc ==null || cc==' ' || cc=='NaN')
        {
            cc=0;
        }
        var totalamt=0;
        var rate_qty=parseFloat(checkValidValue(qty))*parseFloat(checkValidValue(rate));
        //alert(rate_qty);
        $('#eachsubtotal_'+id).val(rate_qty);
        if(rate>0)
        {
            $('#free_'+id).val(0);
        }

        // alert(rate_qty);
        var disamt=0;
        var with_dis=0;
        var with_vat=0;
        if(discount)
        {
            disamt= rate_qty*(discount/100);
            with_dis=rate_qty-disamt;
        }
        else
        {
            disamt=0;
            with_dis=rate_qty;

        }
      if(vat)
      {
        vatamt=with_dis*vat/100;
        with_vat=with_dis+vatamt;
      }
      else
      {
        vatamt=with_dis*vat/100;
        with_vat=with_dis+vatamt;

      }
      $('#totalamt_'+id).val(with_vat.toFixed(2));
        // $('#totalamt_1').val(500);
        $('#vatamt_'+id).val(vatamt.toFixed(2));
        $('#disamt_'+id).val(disamt.toFixed(2));
        // $('#cc_'+id).

      // console.log(with_vat);

      // eachtotalamt
      var stotal=0;
      var stotalvat=0;
      var stotoaldis=0;
      var eachsubtotal=0;
      var eachcctotal=0;
        $(".eachtotalamt").each(function() {
                stotal += parseFloat(checkValidValue($(this).val()));
            });

         $(".vatamt").each(function() {
                stotalvat += parseFloat(checkValidValue($(this).val()));
            });

          $(".disamt").each(function() {
                stotoaldis += parseFloat(checkValidValue($(this).val()));
            });

          $(".eachsubtotal").each(function() {
                eachsubtotal += parseFloat(checkValidValue($(this).val()));
                // alert(eachsubtotal);
            });

          $(".eachcc").each(function() {
                eachcctotal += parseFloat(checkValidValue($(this).val()));
            });

          // alert(with_vat);
          eachsubtotal=parseFloat(checkValidValue(eachsubtotal))+parseFloat(checkValidValue(eachcctotal));
          //alert(eachsubtotal);
          stotoaldis==parseFloat(checkValidValue(stotoaldis))+parseFloat(checkValidValue(cc));
          stotal=parseFloat(checkValidValue(stotal))+parseFloat(checkValidValue(eachcctotal));
          with_vat=parseFloat(checkValidValue(with_vat))+parseFloat(checkValidValue(cc));

       
        $('#taxamt').val(stotalvat.toFixed(2));
        $('#discountamt').val(stotoaldis.toFixed(2));
        $('#subtotalamt').val(eachsubtotal.toFixed(2));
        $('#totalamount').val(stotal.toFixed(2));
        $('.extra').change();

    })
     

</script>
<script>
    $(document).ready(function () {
        var id=$('.idfornot').data('id');
        calculate();
        $('#puit_qty_'+id).change();
        $('#puit_unitprice_'+id).change();
   
        var grandtotal = 0;
        var discounttotal = 0;
        
        var type = '';
        var discount = 0;
        var taxvalue =  0;
       
        function calculate(){
            var stotal=0;
            var trid=$('.idfornot').data('id');
            var qty=$('#puit_qty_'+trid).val();
            if(qty=='')
            {
                qty=0;
            }
            else
            {
                qty=parseFloat(qty);
            }
            var price=$('#puit_unitprice_'+trid).val();
            if(price=='')
            {
                price=0;
            }
            else
            {
                price=parseFloat(price);
            }
            var totalamt=qty*price;
            $('#puit_total_'+trid).val(totalamt);
            $(".totalamount").each(function() {
                stotal += parseFloat($(this).val());
            });
            $('#subtotal').val(stotal);
            $('#grandtotal').val(stotal);
            $('#discountType').change();
        };
    })
</script>

<script type="text/javascript">
   $(document).off('blur','.vat');
    $(document).on('blur','.vat',function(){
        var id = $(this).data('id');
        var vat = $('#vat_'+id).val();
        // alert(vat);
        setTimeout(function(){
            $('.vat').val(vat);
            if(vat){
                $('.calamt').change();
            }
        },1000);
    });
</script>