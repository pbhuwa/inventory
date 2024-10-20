<?php
    //id after redirect
    $pure_id =  !empty($this->input->post('pure_id'))?$this->input->post('pure_id'):'';
    $mat_type_id = !empty($this->input->post('mat_type_id'))?$this->input->post('mat_type_id'):'';
?>
<div class="form-group">
    <input type="hidden" value="<?php echo !empty($order_details[0]->puor_purchaseordermasterid)?$order_details[0]->puor_purchaseordermasterid:''; ?>" name="id">

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

        <?php
            if(ORGANIZATION_NAME == 'KUKL'):
        ?>
      <!--   <div class="col-md-3 col-sm-4">
            <?php //$puor_fyear=!empty($order_details[0]->puor_fyear)?$order_details[0]->puor_fyear:'';  ?>
            <label for="example-text"><?php echo $this->lang->line('material_type'); ?> <span class="required">*</span>:</label>

            <select name="mat_type_id" class="form-control required_field" id="material_type" >
                <?php
                    if($material_type): 
                        foreach ($material_type as $km => $mat):
                ?>
                    <option value="<?php echo $mat->maty_materialtypeid; ?>" <?php if($mat->maty_materialtypeid==$mat_type_id) echo "selected=selected"; ?> ><?php echo $mat->maty_material; ?></option>
                <?php endforeach; endif; ?>
            </select>
        </div> -->
        <?php
            endif;
        ?>

        <div class="col-md-3 col-sm-4">
            <?php $puor_requno=!empty($order_details[0]->puor_requno)?$order_details[0]->puor_requno:$pure_id; ?>
            <label for="example-text"><?php echo $this->lang->line('pur_req_no'); ?><span class="required">*</span>: </label>

            <div class="dis_tab">
                <input type="text" name="req_no" class="form-control number enterinput required_field"  placeholder="Enter Pur. Requisition No." value="<?php echo $puor_requno; ?>" id="requisitionNumber" data-targetbtn="btnSearchReqno">
                
                <a href="javascript:void(0)" class="table-cell width_30 btn btn-success" id="btnSearchReqno"><i class="fa fa-search"></i></a>&nbsp;

                <a href="javascript:void(0)"  data-id="0" data-fyear="<?php echo CUR_FISCALYEAR;?>" data-displaydiv="Order" data-viewurl="<?php echo base_url() ?>purchase_receive/purchase_order/load_pur_reqisition_list" class="view table-cell width_30 btn btn-success" data-heading="<?php echo $this->lang->line('purchase_requisition_list')?>" id="orderLoad" ><i class="fa fa-upload"></i></a> 
            </div>
            <span class="errmsg"></span>
        </div>
        
        <div class="col-md-3 col-sm-4">
            <?php 
                $session_store=$this->session->userdata(STORE_ID);
            $stid=!empty($order_details[0]->puor_storeid)?$order_details[0]->puor_storeid:$session_store; ?>
            <label for="example-text">
                <?php echo $this->lang->line('store'); ?> <span class="required">*</span>:
            </label>
            <select name="item_type" class="form-control required_field" id="item_type" >
                <option value="">---All---</option>
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
            <?php $orderno=!empty($order_details[0]->puor_orderno)?$order_details[0]->puor_orderno:''; ?>
            <label for="example-text"><?php echo $this->lang->line('order_no'); ?> <span class="required">*</span>:</label>
            <input type="text" class="form-control required_field"  name="order_number"  value="<?php echo !empty($orderno)?$orderno:$order_no;?>" placeholder="Enter Order Number" readonly>
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
            <?php $puor_isfreezer=!empty($order_details[0]->puor_isfreezer)?$order_details[0]->puor_isfreezer:''; ?>
            <label for=""><?php echo $this->lang->line('is_freeze'); ?></label><br>
            <input type="checkbox" value="Y" name="isfreeze" <?php if($puor_isfreezer == 'Y')echo "checked" ?> >
        </div>
        
    </div>
</div>

<script>
    $(document).off('click','#btnSearchReqno');
    $(document).on('click','#btnSearchReqno',function(e){
        var requisitionno = $("#requisitionNumber").val();
        var fiscalyear = $("#fiscalyear").val();
        var mat_type_id = $("#material_type").val();
        // alert(mat_type_id);
        // var mat_type_id = "<?php echo $mat_type_id; ?>";
        var action=base_url+'purchase_receive/purchase_order/purchase_requisition_find';
        $.ajax({
            type: "POST",
            url: action,
            data:{requisitionno:requisitionno,fiscalyear:fiscalyear, mat_type_id:mat_type_id},
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
                console.log(data.tempform);
                $('#displayDetailList').html('');
                if(data.status=='success')
                {
                  $('#displayDetailList').html(data.tempform);
                  var storeid=data.storeid;
                  
                  $('#item_type').select2('val',storeid);

                  
                }
                if(data.status=='error')
                {
                    alert('Requisition Number Not Found');
                    $("#requisitionNumber").focus();
                    $('#displayDetailList').html('');
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
</script>

<?php
    if(!empty($pure_id)):
?>
<script>
    $(document).ready(function(){
        $('#btnSearchReqno').click();
    });
</script>
<?php
    endif;
?>