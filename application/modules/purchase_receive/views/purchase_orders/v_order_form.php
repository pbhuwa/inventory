    <div class="form-group">
        <input type="hidden" value="<?php echo !empty($order_details[0]->puor_purchaseordermasterid)?$order_details[0]->puor_purchaseordermasterid:''; ?>" name="id">
        <div class="row p-row">
        <div class="col-md-3 col-sm-4">
            <?php $puor_requno=!empty($order_details[0]->puor_requno)?$order_details[0]->puor_requno:''; ?>
            <label for="example-text"><?php echo $this->lang->line('req_no'); ?>: </label>
            <div class="dis_tab">
            <input type="text" name="req_no" class="form-control enterinput"  placeholder="Enter Requistion Number" value="<?php echo $puor_requno; ?>" id="requisitionNumber" data-targetbtn="btnSearchReqno">
            <a href="javascript:void(0)" class="table-cell frm_add_btn width_30" id="btnSearchReqno"><i class="fa fa-search"></i></a>
          </div>
          <span class="errmsg"></span>
        </div>
        <div class="col-md-3 col-sm-4">
            <?php $puor_fyear=!empty($order_details[0]->puor_fyear)?$order_details[0]->puor_fyear:'';  ?>
            <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?> <span class="required">*</span>:</label>
            <!-- <input type="text" name="fiscalyear" class="form-control" id="fiscalYear"  value="<?php echo !empty($puor_fyear)?$puor_fyear:CUR_FISCALYEAR; ?>" readonly="true"> -->

              <select name="fiscalyear" class="form-control" id="fiscalYear" >
           <?php
             if($fiscal_year): 
             foreach ($fiscal_year as $kf => $fyrs):
             ?>
            <option value="<?php echo $fyrs->fiye_name; ?>" <?php if($fyrs->fiye_status=='I') echo "selected=selected"; ?> ><?php echo $fyrs->fiye_name; ?></option>
         <?php endforeach; endif; ?>
       </select>

        </div>
        <div class="col-md-3 col-sm-4">
            <?php $stid=!empty($order_details[0]->puor_storeid)?$order_details[0]->puor_storeid:''; ?>
            <label for="example-text"><?php echo $this->lang->line('item_types'); ?> <span class="required">*</span>:</label>
            <select name="item_type" class="form-control select2" id="item_type" >
                <option value="">---select---</option>
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
            <select name="supplier" class="form-control select2" >
                <option value="">---select---</option>
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
        </div>
        <div class="col-md-3 col-sm-4">
            <?php $datedb=!empty($order_details[0]->puor_orderdatebs)?$order_details[0]->puor_orderdatebs:DISPLAY_DATE; //print_r($datedb);die;?>
          <label for="example-text"><?php echo $this->lang->line('order_date'); ?>: </label>
          <input type="text" name="order_date" class="form-control <?php echo DATEPICKER_CLASS;?> date"  placeholder="Order Date" id="ServiceReceived" value="<?php echo $datedb;?>">
          <span class="errmsg"></span>
        </div>
        <div class="col-md-3 col-sm-4"><!-- puor_order_for -->
            <?php $orderno=!empty($order_details[0]->puor_orderno)?$order_details[0]->puor_orderno:''; ?>
            <label for="example-text"><?php echo $this->lang->line('order_no'); ?> <span class="required">*</span>:</label>
            <input type="text" class="form-control"  name="order_number"  value="<?php echo !empty($orderno)?$orderno:$order_no[0]->ordnumb+1;?>" placeholder="Enter Order Number" readonly>
        </div>
        <div class="col-md-3 col-sm-4">
            <?php
            $default_delivery_date=!empty($delivery_date)?$delivery_date:''; 
            $deleverydb=!empty($order_details[0]->puor_deliverydatebs)?$order_details[0]->puor_deliverydatebs:$default_delivery_date; //print_r($datedb);die;?>
              <label for="example-text"><?php echo $this->lang->line('delivery_date'); ?>: </label>
              <input type="text" name="delevery_date" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Delivery Date" value="<?php echo $deleverydb;?>" id="ServiceDelivery">
          <span class="errmsg"></span>
        </div>
        <div class="col-md-3 col-sm-4">
          <label for="example-text"><?php echo $this->lang->line('delivery_site'); ?> : </label> 
           <?php $dsite=!empty($order_details[0]->puor_deliverysite)?$order_details[0]->puor_deliverysite:''; ?>  
          <input type="text" name="delevery_site" class="form-control"  placeholder="Delivery Site" value="<?php echo $dsite; ?>">
          <span class="errmsg"></span>
        </div>
      <!--   <div class="col-md-3 col-sm-4">
            <?php $puorfyear=!empty($order_details[0]->puor_fyear)?$order_details[0]->puor_fyear:''; ?>
            <label for="example-text">Fiscal Year <span class="required">*</span>:</label>
            <select name="fiye_fiscalyear_id" class="form-control select2" >
                <option value="">---select---</option>
                <?php
                    if($fiscal):
                        foreach ($fiscal as $km => $fy):
                ?>
                 <option value="<?php echo $fy->fiye_fiscalyear_id; ?>" <?php if($puorfyear==$fy->fiye_fiscalyear_id) echo "selected=selected"; ?>><?php echo $fy->fiye_name; ?></option>
                <?php
                        endforeach;
                    endif;
                ?>
            </select>
        </div> -->
       <!--  <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('counter'); ?> :</label>
            <select name="storeid" class="form-control" >
                <?php
                    if($eqty_equipmenttype):  
                        foreach ($eqty_equipmenttype as $km => $st):
                ?>
                 <option value="<?php echo $st->eqty_equipmenttypeid; ?>" selected="selected"><?php echo $st->eqty_equipmenttype; ?></option>
                <?php
                        endforeach;
                    endif;
                ?>
            </select>
        </div> -->
        <div class="col-md-3 col-sm-4">
            <?php $puor_isfreezer=!empty($order_details[0]->puor_isfreezer)?$order_details[0]->puor_isfreezer:''; ?>
            <label for=""><?php echo $this->lang->line('is_freeze'); ?></label><br>
            <input type="checkbox" value="Y" name="isfreeze" <?php if($puor_isfreezer == 'Y')echo "checked" ?> >
        </div>
        <!-- <div class="col-md-3 col-sm-4">
            <?php $manualnodb=!empty($order_details[0]->rema_manualno)?$order_details[0]->rema_manualno:''; ?>
            <label for="example-text">Manual Number :</label>
            <input type="text" class="form-control float" name="rema_manualno"  value="<?php echo $manualnodb; ?>" placeholder="Enter Manual Number">
        </div>
        <div class="col-md-3 col-sm-4">
          <label for="example-text">Sup Bill Date: </label>
          <input type="text" name="suplier_bill_date" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Service Start Date" value="" id="ServiceBill">
          <span class="errmsg"></span>
        </div>
        <div class="col-md-3 col-sm-4">
            <?php $receivenodb=!empty($order_details[0]->receiveno)?$order_details[0]->receiveno:''; ?>
            <label for="example-text">Received Number :</label>
            <input type="text" class="form-control" name="receiveno" value="<?php echo $receivenodb; ?>" placeholder="Enter Posted BY ">
        </div>
        <div class="col-md-3 col-sm-4">
            <?php $suplier_bill_nodb=!empty($order_details[0]->suplier_bill_no)?$order_details[0]->suplier_bill_no:''; ?>
            <label for="example-text">Sup Bill Number :</label>
            <input type="text" class="form-control" name="suplier_bill_no" value="<?php echo $suplier_bill_nodb; ?>" placeholder="Enter Posted BY ">
        </div> -->
    </div>
  </div>
<script>
    $(document).off('click','#btnSearchReqno');
    $(document).on('click','#btnSearchReqno',function(e){
        var requisitionno = $("#requisitionNumber").val();
        var fiscalyear = $("#fiscalYear").val();
        var action=base_url+'purchase_receive/purchase_order/purchase_requisition_find';
        $.ajax({
          type: "POST",
          url: action,
          data:{requisitionno:requisitionno,fiscalyear:fiscalyear},
          dataType: 'html',
          success: function(jsons) 
            {
                data = jQuery.parseJSON(jsons);   
                // alert(data.status);
                // console.log(data);
                // return false;
                if(data.status=='success')
                {
                  $('.requisitionOrder').html(data.tempform);
                  var storeid=data.storeid;
                  
                  $('#item_type').select2('val',storeid);

                  
                }
                if(data.status=='error')
                {
                    alert('Requisition Number Not Found')
                }
            }
        });
    })
    $(document).off('blur','.puit_qty');
    $(document).on('blur','.puit_qty',function(e){
        var id = $(this).data('id'); 
        var qty = $('#puit_qty_'+id).val();
        var fiscalyear = $("#fiscalYear").val();
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
</script>