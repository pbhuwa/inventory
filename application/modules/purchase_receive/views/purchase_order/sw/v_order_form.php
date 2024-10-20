<div class="form-group">
    <input type="hidden" value="<?php echo !empty($order_details[0]->puor_purchaseordermasterid)?$order_details[0]->puor_purchaseordermasterid:''; ?>" name="id">
    <?php $pur_reqmaster=!empty($purreqmasterid)?$purreqmasterid:''; 
    $purreqid=!empty($order_details[0]->puor_purchasereqmasterid)?$order_details[0]->puor_purchasereqmasterid:$pur_reqmaster;
    $pur_reqarr=array();
    ?>
    <div id="purmasteriddiv">
        <?php 
        if(!empty($purreqid)):
                        $purreqarr=explode(',', $purreqid);
                        $pur_reqarr=$this->db->select('pure_purchasereqid,pure_reqno')
                        ->from('pure_purchaserequisition')
                        ->where_in('pure_purchasereqid',$purreqarr)
                        ->get()
                        ->result();
                        endif; 
        ?>   
        <?php
        if($pur_reqarr): 
            foreach ($pur_reqarr as $kpa => $purr) {
            ?>
              <input type="hidden" name="puor_purchasereqmasterid[]" id="purchasereqmasterid_<?php echo $purr->pure_purchasereqid; ?>" value="<?php echo $purr->pure_purchasereqid; ?>">
            <?php
            }
        ?>
  
    <?php endif; ?>
    </div>

    <div class="container row p-row">
        <div class="col-md-3 col-sm-4">
            <?php $puor_fyear=!empty($order_details[0]->puor_fyear)?$order_details[0]->puor_fyear:'';  ?>
            <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?> <span class="required">*</span>:</label>

            <select name="fiscalyear" class="form-control required_field" id="fiscalyear" >
                <?php
                    if($fiscal_year): 
                        foreach ($fiscal_year as $kf => $fyrs):
                ?>
                    <option value="<?php echo $fyrs->fiye_name; ?>" <?php if($fyrs->fiye_status=='I') echo "selected=selected"; ?> ><?php echo $fyrs->fiye_name; ?></option>
                <?php endforeach; endif; ?>
            </select>
        </div>
         <div class="col-md-3">
                <label for="example-text">Choose Material Type   : </label><br>
                <?php
                    $mattypeid = !empty($order_details[0]->puro_mattypeid)?$order_details[0]->puro_mattypeid:$puro_mattypeid;   
                    
                ?>
                <select name="puro_mattypeid" id="material_type" class="form-control chooseMatType required_field">
                 <?php 
                 if(!empty($material_type)):
                    foreach($material_type as $mat):
                 ?>
                 <option value="<?php echo $mat->maty_materialtypeid; ?>" <?php if($mattypeid==$mat->maty_materialtypeid) echo "selected=selected"; ?>>  <?php echo $mat->maty_material; ?></option>
                 <?php
                    endforeach;
                 endif;
                 ?>
                </select>
            </div>
        <div class="col-md-3 col-sm-4">
            <?php $puor_requno=!empty($order_details[0]->puor_requno)?$order_details[0]->puor_requno:$pure_reqno; ?>
            <label for="example-text">Pur. <?php echo $this->lang->line('req_no'); ?><span class="required">*</span>: </label>

            <div class="dis_tab" style="display: flex;">
                <div id="pr_req_listdiv" style="width: 200px">
                   
                    <?php 
                    $reqno='';
                        if(!empty($pur_reqarr) && is_array($pur_reqarr)){
 
                            foreach($pur_reqarr as $reqn){
                                $reqno=$reqn->pure_reqno;
                                ?>
                                 <span class="req_data" id="pur_reqdiv_<?php $reqn->pure_purchasereqid ?>"><a href="javascript:void(0)" class="btn btn-sm number "><?php echo $reqn->pure_reqno; ?></a><span class="remove pur_req" data-purchasereqid="<?php echo $reqn->pure_purchasereqid; ?>"><i class="fa fa-minus-circle"></i></span><span></span></span>
                                <?php
                            }
                        }

                        ?>
                   
                </div>
                
                <input style="width: 60px" type="text" name="req_no" class="form-control number enterinput required_field"  placeholder="Enter Requistion Number" value="<?php echo !empty($reqno)?$reqno:''; ?>" id="requisitionNumber" data-targetbtn="btnSearchReqno">
                
                <a href="javascript:void(0)" class="table-cell width_30 btn btn-success " id="btnSearchReqno"><i class="fa fa-search"></i></a>&nbsp;

                <a href="javascript:void(0)"  data-id="0" data-fyear="<?php echo CUR_FISCALYEAR;?>" data-displaydiv="Order" data-viewurl="<?php echo base_url() ?>purchase_receive/purchase_order/load_pur_reqisition_list" class="view table-cell width_30 btn btn-success" data-heading="<?php echo $this->lang->line('purchase_requisition_list')?>" id="orderLoad" ><i class="fa fa-upload"></i></a> 
            </div>
            <span class="errmsg"></span>
        </div>
        
        <div class="col-md-3 col-sm-4">
            <?php $stid=!empty($order_details[0]->puor_storeid)?$order_details[0]->puor_storeid:''; ?>
            <label for="example-text">
                <?php echo $this->lang->line('store'); ?> <span class="required">*</span>:
            </label>
            <select name="item_type" class="form-control required_field" id="item_type" >
                <?php 
                    if($store):
                        foreach ($store as $km => $dep):
                ?>
                <option value="<?php echo $dep->eqty_equipmenttypeid; ?>"  <?php if($stid==$dep->eqty_equipmenttypeid) echo "selected=selected"; ?>><?php echo $dep->eqty_equipmenttype; ?></option>
                <?php
                        endforeach;
                    endif;
                ?>
            </select>
        </div>

        <div class="col-md-3 col-sm-4">
            <?php $supid=!empty($order_details[0]->puor_supplierid)?$order_details[0]->puor_supplierid:''; ?>
            <label for="example-text"><?php echo $this->lang->line('supplier_name'); ?> <span class="required">*</span>:</label>
            <div class="dis_tab">
            <select name="supplier" id="order_supplierid" class="form-control select2 required_field" >
                <option value="">---All---</option>
                <?php
                    if(!empty($distributor)):
                        foreach ($distributor as $km => $sup):
                ?>
                 <option value="<?php echo $sup->dist_distributorid; ?>" <?php if($supid==$sup->dist_distributorid) echo "selected=selected"; ?>><?php echo $sup->dist_distributor; ?></option>
                <?php
                        endforeach;
                    endif;
                ?>
            </select>

             <a href="javascript:void(0)" class="table-cell frm_add_btn width_30 refresh_element" data-targetid="order_supplierid" data-viewurl="<?php echo base_url('biomedical/distributors/distributor_reload'); ?>"><i class="fa fa-refresh"></i></a>

               <a href="javascript:void(0)" class="table-cell frm_add_btn width_30 view" data-heading='Supplier Entry' data-viewurl='<?php echo base_url('biomedical/distributors/supplier_entry/modal'); ?>'><i class="fa fa-plus"></i></a>
            </div>
        </div>

        <div class="col-md-3 col-sm-4">
            <?php $datedb=!empty($order_details[0]->puor_orderdatebs)?$order_details[0]->puor_orderdatebs:DISPLAY_DATE; //print_r($datedb);die;?>
            <label for="example-text"><?php echo $this->lang->line('order_date'); ?><span class="required">*</span>: </label>
            <input type="text" name="order_date" class="form-control <?php echo DATEPICKER_CLASS;?> date required_field"  placeholder="Order Date" id="ServiceReceived" value="<?php echo $datedb;?>">
            <span class="errmsg"></span>
        </div>

        <div class="col-md-3 col-sm-4"><!-- puor_order_for -->
            <?php 
            $orderno=!empty($order_details[0]->puor_orderno)?$order_details[0]->puor_orderno:''; ?>
            <label for="example-text"><?php echo $this->lang->line('order_no'); ?> <span class="required">*</span>:</label>
            <input type="text" class="form-control required_field"  name="order_number"  value="<?php echo !empty($orderno)?$orderno:$order_no;?>" placeholder="Enter Order Number" readonly id="orderno">
        </div>

        <div class="col-md-3 col-sm-4">
            <?php
                $default_delivery_date=!empty($delivery_date)?$delivery_date:''; 
                $deleverydb=!empty($order_details[0]->puor_deliverydatebs)?$order_details[0]->puor_deliverydatebs:$default_delivery_date;
            ?>
            <label for="example-text"><?php echo $this->lang->line('delivery_date'); ?><span class="required">*</span>: </label>
            <input type="text" name="delevery_date" class="form-control <?php echo DATEPICKER_CLASS; ?> date required_field"  placeholder="Delivery Date" value="<?php echo $deleverydb;?>" id="ServiceDelivery">
            <span class="errmsg"></span>
        </div>

        <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('delivery_site'); ?> : </label> 
            <?php $dsite=!empty($order_details[0]->puor_deliverysite)?$order_details[0]->puor_deliverysite:''; ?>  
            <input type="text" name="delevery_site" class="form-control"  placeholder="Delivery Site" value="<?php echo $dsite; ?>">
            <span class="errmsg"></span>
        </div>
         <div class="col-md-3 col-sm-4">
          <label>Budget<span class="required">*</span> :</label>
           <select class="table-cell form-control select2 required_field" name="puor_budgetid" id="budgetid">
            <?php $bid=!empty($order_details[0]->puor_budgetid)?$order_details[0]->puor_budgetid:''; 
                // echo $bid;
            ?>  
                    <option value="">--- Select ---</option>
                    <?php if (!empty($budgets_list)) :
                        foreach ($budgets_list as $kb => $buget) :
                    ?>
                            <option value="<?php echo $buget->budg_budgetid; ?>"
                                <?php if($bid==$buget->budg_budgetid): echo "selected=selected"; endif; ?>
                                ><?php echo $buget->budg_budgetname; ?></option>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </select>
         </div>
     
      <!--   <div class="col-md-3 col-sm-4">
            <?php $puor_isfreezer=!empty($order_details[0]->puor_isfreezer)?$order_details[0]->puor_isfreezer:''; ?>
            <label for=""><?php echo $this->lang->line('is_freeze'); ?></label><br>
            <input type="checkbox" value="Y" name="isfreeze" <?php if($puor_isfreezer == 'Y')echo "checked" ?> >
        </div> -->
        
    </div>
</div>

<script>
     function update_serial_no()
    {
         $(".orderrow").each(function(i,k) {
                    var vali=i+1;
                    $(this).attr("id","orderrow_"+vali);
                    $(this).attr("data-id",vali);    
                    $(this).find('.s_no').attr("id","s_no_"+vali);
                    $(this).find('.s_no').attr("value",vali);

                    $(this).find('.itemscode').attr("id","itemscode_"+vali);
                    $(this).find('.itemscode').attr("data-id",vali);

                    $(this).find('.itemcode').attr("id","itemcode_"+vali);
                    $(this).find('.itemcode').attr("data-id",vali);

                    $(this).find('.itemsid').attr("id","itemsid_"+vali);
                    $(this).find('.itemsid').attr("data-id",vali);

                    $(this).find('.itemname').attr("id","itemname_"+vali);
                    $(this).find('.itemname').attr("data-id",vali);

                    $(this).find('.qude_itemsid').attr("id","qude_itemsid_"+vali);
                    $(this).find('.qude_itemsid').attr("data-id",vali);

                    $(this).find('.purd_reqdetid').attr("id","purd_reqdetid_"+vali);
                    $(this).find('.purd_reqdetid').attr("data-id",vali);

                    $(this).find('.controlno').attr("id","controlno_"+vali);
                    $(this).find('.controlno').attr("data-id",vali);

                    $(this).find('.puit_unitid').attr("id","puit_unitid_"+vali);
                    $(this).find('.puit_unitid').attr("data-id",vali);

                    $(this).find('.stock_qty').attr("id","stock_qty_"+vali);
                    $(this).find('.stock_qty').attr("data-id",vali);

                    $(this).find('.puit_qty').attr("id","puit_qty_"+vali);
                    $(this).find('.puit_qty').attr("data-id",vali);

                    $(this).find('.puit_unitprice').attr("id","puit_unitprice_"+vali);
                    $(this).find('.puit_unitprice').attr("data-id",vali);

                    $(this).find('.discountpc').attr("id","discountpc_"+vali);
                    $(this).find('.discountpc').attr("data-id",vali);

                    $(this).find('.puit_taxid').attr("id","puit_taxid_"+vali);
                    $(this).find('.puit_taxid').attr("data-id",vali);

                    $(this).find('.puit_total').attr("id","puit_total_"+vali);
                    $(this).find('.puit_total').attr("data-id",vali);

                    $(this).find('.tender_no').attr("id","tender_no_"+vali);
                    $(this).find('.tender_no').attr("data-id",vali);

                    $(this).find('.description').attr("id","description_"+vali);
                    $(this).find('.description').attr("data-id",vali);

                    $(this).find('.btnAdd').attr("id","addOrder_"+vali);
                    $(this).find('.btnAdd').attr("data-id",vali);
                    $(this).find('.btnRemove').attr("id","addOrder_"+vali);
                    $(this).find('.btnRemove').attr("data-id",vali);
                    $(this).find('.btnChange').attr("id","btnChange_"+vali);
                });
    }
$(document).ready(function(e){
     var matType = $("#material_type").val();
     $('#orderLoad').attr('data-id',matType);
     $('#orderLoad').data('id',matType);
})

    $(document).off('click','#btnSearchReqno');
    $(document).on('click','#btnSearchReqno',function(e){
        var requisitionno = $("#requisitionNumber").val();
        var fiscalyear = $("#fiscalyear").val();
        var mattypeid =$('#material_type').val();

        var reqn=[];
        $('.requisitionno').each(function() { 
            reqn.push($(this).val()); });
        console.log(reqn);

        var action=base_url+'purchase_receive/purchase_order/purchase_requisition_find';
        $.ajax({
            type: "POST",
            url: action,
            data:{requisitionno:requisitionno,fiscalyear:fiscalyear,mat_type_id:mattypeid,reqn:reqn},
            dataType: 'html',
             beforeSend: function() {
              // $(this).prop('disabled',true);
              // $(this).html('Saving..');
              $('.overlay').modal('show');
            },
            success: function(jsons) 
            {
                data = jQuery.parseJSON(jsons);   
                // alert(data.status);
                // console.log(data);
                // return false;
                // console.log(data.tempform);
                // $('#displayDetailList').html('');
                if(data.status=='success')
                {
                  $('#purchaseDataBody').append(data.tempform);
                  $('#pr_req_listdiv').append('<span class="req_data" id="pur_reqdiv_'+data.purchasereqid+'"><a href="javascript:void(0)" class="btn btn-sm number "   >'+requisitionno+'</a><span class="remove pur_req" data-purchasereqid="'+data.purchasereqid+'" data-reqno="'+requisitionno+'"><i class="fa fa-minus-circle"></i></span><span>');
                  var storeid=data.storeid;
                  
                  $('#item_type').select2('val',storeid);
                  // $('#purchasereqmasterid').val(data.purchasereqid);
                  $('#purmasteriddiv').append('<input type="hidden"  name="puor_purchasereqmasterid[]"  id="purchasereqmasterid_'+data.purchasereqid+'" value="'+data.purchasereqid+'"><input type="hidden"  name="" class="requisitionno" id="requisitionno_'+data.purchasereqno+'" value="'+data.purchasereqno+'" >')
                  update_serial_no();
                  $('.calculateamt').change();
                  $("#requisitionNumber").focus().select();
                  
                }
                if(data.status=='error')
                {
                    alert(data.message);

                    $("#requisitionNumber").focus().select();
                    // $('.orderrow').remove('');
                    $('#purchasereqmasterid').val('');
                }
                $('.overlay').modal('hide');
            }
        });
    })

    $(document).off('blur','.puit_qty');
    $(document).on('blur','.puit_qty',function(e){
        var id = $(this).data('id'); 
        var qty = $('#puit_qty_'+id).val();
        var fiscalyear = $("#fiscalyear").val();
        var purdetailsid = $('#purd_reqdetid_'+id).val();
        var action=base_url+'purchase_receive/purchase_order/purhasre_requisition_chaeck_miniumqty';
        $.ajax({
            type: "POST",
            url: action,
            data:{qty:qty,purdetailsid:purdetailsid,fiscalyear:fiscalyear},
            dataType: 'html',
            success: function(jsons) 
            {
                data = jQuery.parseJSON(jsons);   
                // alert(data.status);
                if(data.status=='success')
                {
                    alert('New Entered Quantity Is Not Less Then Previous Quantity')
                    $('#puit_qty_'+id).val(data.qty);
                  
                }
                if(data.status=='error')
                {
                    alert('Please Try Latter');
                }
            }
        });
    })

      $(document).off('change','.chooseMatType,#fiscalyear');
        $(document).on('change','.chooseMatType,#fiscalyear',function(){
        var matType = $('.chooseMatType').val();
        var fyear=$('#fiscalyear').val();
        var purreqid=$('#purchasereqmasterid').val();
        $('#orderLoad').attr('data-id',matType);
        $('#orderLoad').data('id',matType);
        if(purreqid){
            $('#purchasereqmasterid').val('');
            $('.orderrow').remove();
            $('#requisitionNumber').val('');
            $('#requisitionNumber').focus().select();
        }

        var submitdata = {mattype:matType,fyear:fyear};
        var submiturl = base_url+'purchase_receive/purchase_order/get_order_no_by_material_type_id';
        ajaxPostSubmit(submiturl,submitdata,beforeSend,onSuccess);
        function beforeSend(){
                    // $('.overlay').modal('show');
                    $('#orderno').attr('disabled','disabled');
                    $('#orderno').val('Loading...');
          };
         function onSuccess(jsons){
                    data = jQuery.parseJSON(jsons);
                    setTimeout(function(){
                        $('#orderno').empty().val(data.orderno);
                        $('#orderno').removeAttr('disabled');
                    },500);
                }

            });

</script>

<script>
    $(document).off('keyup blur change','.sade_qty');
    $(document).on('keyup blur change','.sade_qty',function(){
        var rowid = $(this).data('id');

        var sade_qty = $('#sade_qty_'+rowid).val();
        if(sade_qty==NaN || sade_qty =='')
        {
            sade_qty=0;
        }
        var qtyinstock = $('#qtyinstock_'+rowid).val();
        var remqty=$('#remqty_'+rowid).val();
        var my_rem_qty=0;

        // console.log('rowid :'+rowid);
        // console.log('sade_qty :'+sade_qty);
        // console.log('qtyinstock :'+qtyinstock);
        sade_qty = parseInt(sade_qty);
        qtyinstock = parseInt(qtyinstock);
        remqty=parseInt(remqty);
        my_rem_qty=parseInt(remqty)-parseInt(sade_qty);
        $('#my_remqty_'+rowid).val(my_rem_qty);

        if(sade_qty > remqty)
        {
            alert('Issue Qty should not exceed Req. qty. Please check it.');
            $('#sade_qty_'+rowid).val(remqty);
            my_rem_qty=parseInt(remqty)-parseInt(sade_qty);
            $('#my_remqty_'+rowid).val(my_rem_qty);

            return false;
        }

        if(sade_qty > qtyinstock){

            // $('.error').addClass('alert');
            alert('Issue Qty should not exceed stock qty. Please check it.');
                // return false;
            // $('.error').html('Issue Qty should not exceed stock qty. Please check it.').show().delay(1000).fadeOut();
            $('#sade_qty_'+rowid).val(qtyinstock);
            $('#sade_qty_'+rowid).focus();
            my_rem_qty=parseInt(remqty)-parseInt(qtyinstock);
            $('#my_remqty_'+rowid).val(my_rem_qty);
            return false;
        }
        
    });
</script>

<script>
 $(document).off('click','.btnRemove');
    $(document).on('click','.btnRemove',function(){
        var id=$(this).data('id');
        var whichtr = $(this).closest("tr");
        var conf = confirm('Are Your Want to Sure to remove?');
        if(conf){
            var trplusOne = $('.orderrow').length+1;
             setTimeout(function(){
            var limstk_cnt=$('.limited_stock').length;
            $('#stock_limit').html(limstk_cnt);
        },1000);
            whichtr.remove(); 
            setTimeout(function(){
               update_serial_no();
            },600);
        }
    });
    $(document).off('click','.pur_req');
    $(document).on('click','.pur_req',function(e){
        var pmasterid=$(this).data('purchasereqid');
        var reqno=$(this).data('reqno');
        var conf = confirm('Are Your Want to Sure to remove?');
        if(conf){
            $(this).parent().remove().fadeOut(500);
            $('.orderrow_'+pmasterid).remove();
            $('#purchasereqmasterid_'+pmasterid).remove();
            $('#requisitionno_'+reqno).remove();

             setTimeout(function(){
               update_serial_no();
            },600);
        }
    })
</script>
<script type="text/javascript">
    $(document).off('click','.zero_stk_remove');
    $(document).on('click','.zero_stk_remove',function(){
        var cnt_zero_stock=$('.stk_zero').length;
        if(cnt_zero_stock>0)
        {
            var conf = confirm('Are your want to sure to remove zero stock ?');
              if(conf)
              {
                $('.stk_zero').fadeOut(1000, function(){ 
                        $('.stk_zero').remove();
                    });
                setTimeout(function(){
                var limstk_cnt=$('.limited_stock').length;
                $('#stock_limit').html(limstk_cnt);
                },1100);
            }
        }
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
        var totalamt =0; 
        var discount = 0;
        var taxvalue =  0;

        function calculate(){
            var stotal=0;
            var trid=$('.idfornot').data('id');
            var qty=$('#puit_qty_'+trid).val();
            //console.log(trid);
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
                $('#puit_total_'+trid).val(totalamt);
                stotal += parseFloat($(this).val());
            });
            $('#subtotal').val(stotal);
            $('#grandtotal').val(stotal);
            $('#discountType').change();
        };
    })
</script>
