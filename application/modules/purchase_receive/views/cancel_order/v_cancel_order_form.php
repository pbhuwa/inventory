<?php
 if (defined('SHOW_MATERIAL_OPTION_TYPE')) :
                $show_material_type=SHOW_MATERIAL_OPTION_TYPE;
                else:
                    $show_material_type='N';
                endif;

?>
<style>
    .purs_table tbody tr td{
        border: none;
        vertical-align: center;
    }
</style>
<div id="orderForm">
    <form method="post" id="FormStockRequisition" action="<?php echo base_url('purchase_receive/cancel_order/save_cancel_order'); ?>" class="form-material form-horizontal form" data-reloadurl="<?php echo base_url('purchase_receive/cancel_order/form_cancel_order'); ?>">
        <div class="form-group">
            <?php if($show_material_type=='Y'): ?>
             <div class="col-md-3">
                <label for="example-text">Choose Material Type : </label><br>
               
                <select name="recm_mattypeid" id="mattypeid" class="form-control chooseMatType required_field">
                    <?php
                    if (!empty($material_type)) :
                        foreach ($material_type as $mat) :
                    ?>
                            <option value="<?php echo $mat->maty_materialtypeid; ?>" > <?php echo $mat->maty_material; ?></option>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </select>
            </div>
        <?php endif; ?>

            <div class="col-md-3">
                <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?> :</label>
                <?php  ?>
                <select name="fiscalyear" class="form-control" id="fiscalyear">
                    <option value="">---select---</option>
                    <?php
                        if($fiscal):
                            foreach ($fiscal as $km => $fy):
                    ?>
                
                        <option value="<?php echo $fy->fiye_name; ?>" <?php if($fy->fiye_status == 'I') echo "selected=selected"; ?>><?php echo $fy->fiye_name; ?></option>
                    
                    <?php
                            endforeach;
                        endif;
                    ?>
                </select>
            </div>

            <div class="col-md-3">
                <label for="example-text"><?php echo $this->lang->line('order_no'); ?><span class="required">*</span>:</label>
                <div class="dis_tab">
                    <input type="text" class="form-control send_after_stop enterinput required_field" name="orderno" placeholder="Enter Order No" id="orderNumber" value="<?php echo !empty($order_details[0]->orderno)?$order_details[0]->orderno:'' ?>" data-targetbtn="srchCancelOrder">
                    <a href="javascript:void(0)" class="table-cell width_30 btn btn-success"  id="srchCancelOrder"><i class="fa fa-search"></i></a>&nbsp;
                        
                    <a href="javascript:void(0)"  data-id="0" data-fyear="<?php echo CUR_FISCALYEAR;?>" data-displaydiv="Cancel" data-viewurl="<?php echo base_url() ?>purchase_receive/cancel_order/load_order_list_for_cancel" class="view table-cell width_30 btn btn-success" data-heading="<?php echo $this->lang->line('purchase_order_list')?>" id="cancelLoad" ><i class="fa fa-upload"></i></a> 
                </div>
            </div>
            
            <div class="col-md-3">
                <label for="example-text"><?php echo $this->lang->line('supplier_name'); ?> <span class="required">*</span>:</label>
                <select name="supplier" class="form-control select2 required_field" id="frmstore" >
                    <option value="">---Select---</option>
                    <?php
                        $dbsupplier = !empty($order_details[0]->puor_supplierid)?$order_details[0]->puor_supplierid:'';
                        if($distributor): 
                            foreach ($distributor as $ket => $etype):
                    ?>
                    <option value="<?php echo $etype->dist_distributorid; ?>" <?php if($dbsupplier == $etype->dist_distributorid) echo "Selected= Selected"; ?> ><?php echo $etype->dist_distributor; ?></option>
                    <?php endforeach; endif; ?>
                </select>
            </div>
            
            <div class="col-md-3">
                <label for="example-text"><?php echo $this->lang->line('order_date'); ?><span class="required">*</span>: </label>
                <input type="text" name="puor_orderdate" class="form-control <?php echo DATEPICKER_CLASS; ?> date required_field"  placeholder="Dispatch Date" value="<?php echo !empty($order_details[0]->puor_orderdatebs)?$order_details[0]->puor_orderdatebs:DISPLAY_DATE; ?>" id="OrderDate">
                <span class="errmsg"></span>
            </div>
            
            <div class="col-md-3">
                <label for="example-text"><?php echo $this->lang->line('delivery_date'); ?><span class="required">*</span>: </label>
                <input type="text" name="deliverydate" class="form-control <?php echo DATEPICKER_CLASS; ?> date required_field"  placeholder="Dispatch Date" value="<?php echo !empty($order_details[0]->puor_deliverydatebs)?$order_details[0]->puor_deliverydatebs:DISPLAY_DATE; ?>" id="DeliveryDate">
                <span class="errmsg"></span>
            </div>
            
            <div class="col-md-3">
                <label for="example-text"><?php echo $this->lang->line('cancel_date'); ?><span class="required">*</span>: </label>
                <input type="text" name="canceldate" class="form-control CancelDate <?php echo DATEPICKER_CLASS; ?> date required_field"  placeholder="Dispatch Date" value="<?php echo DISPLAY_DATE; ?>" id="CancelDate">
                <span class="errmsg"></span>
            </div>
            
            <div class="col-md-3" style="display: none;">
                <div class="form-check">
                    <br/>
                    <input type="checkbox" class="form-check-input" id="checkbox100"  name="cancel_all" checked> <?php echo $this->lang->line('cancel_all'); ?>
                </div>
            </div>
            
            <div class="col-md-6" id="cancelReasonWrapper">
                <label for="textarea"><?php echo $this->lang->line('enter_cancel_all_reason'); ?> : </label>
                <textarea id="cancel_reason" class="form-control" name="cancel_reason" placeholder="Enter All Cancel Reason"></textarea>
            </div>
        </div>
        
        <div class="clearfix"></div> 
        
        <div class="form-group">
            <div class="pad-5" id="displayDetailList">
            <div class="table-responsive">
                <table style="width:100%;" class="table dataTable dt_alt purs_table">
                    <thead>
                        <tr>
                            <th width="5%"> <?php echo $this->lang->line('sn'); ?> </th>
                            <th width="10%"><?php echo $this->lang->line('item_code'); ?> <span class="required">*</span></th>
                            <th width="25%"><?php echo $this->lang->line('item_name'); ?></th>
                            <th width="10%"><?php echo $this->lang->line('unit'); ?></th>
                            <th width="10%"><?php echo $this->lang->line('odr_qty'); ?></th>
                            <th width="10%"><?php echo $this->lang->line('rate'); ?></th>
                            <th width="10%"><?php echo $this->lang->line('total'); ?></th>
                            <!-- <th width="15%"><?php echo $this->lang->line('rem_qty'); ?><span class="required">*</span></th>
                            <th width="15%"><?php echo $this->lang->line('cancel_qty'); ?></th> -->
                            <th width="25%"><?php echo $this->lang->line('remarks'); ?></th>
                        </tr>
                    </thead>
                    
                    <tbody id="stock_tranBody">
                        <?php 
                            if($order_details){
                                foreach ($order_details as $key => $cd) {

                                    if(ITEM_DISPLAY_TYPE=='NP'){
                    $req_itemname = !empty($cd->itemnamenp)?$cd->itemnamenp:$cd->itemname;
                }else{ 
                    $req_itemname = !empty($cd->itemname)?$cd->itemname:'';
                }

                                 //echo "<pre>";print_r($order_details);die; ?>
                        <tr class="stockBdy" id="stockBdy_1" data-id='1'>
                            <td>
                                <input type="text" class="form-control sno" id="s_no_1" value="<?php echo $key+1; ?>" readonly/>
                            </td>
                            <td>
                                <input type="hidden"  id="pude_puordeid_1" name="pude_puordeid[]" data-id='1' value="<?php echo !empty($cd->pude_puordeid)?$cd->pude_puordeid:'';?>">
                                <input type="hidden"  id="itemsid_1" name="itemsid[]" data-id='1' value="<?php echo !empty($cd->pude_itemsid)?$cd->pude_itemsid:'';?>">
                                <input type="text" class="form-control itemcode enterinput required_field " id="itemcode_1" name="itemcode[]"  data-id='1' data-targetbtn='view' value="<?php echo !empty($cd->itemcode)?$cd->itemcode:'';?>" readonly>
                            </td>
                            <td> 
                                <input type="text" class="form-control itemname" id="itemname_1" name="itemname[]"  data-id='1' value="<?php echo $req_itemname;?>" readonly>
                            </td>
                            <td> 
                                <input type="text" class="form-control unitname" id="unitname_1" name="unitname[]"  data-id='1' value="<?php echo !empty($cd->unit_unitname)?$cd->unit_unitname:'';?>" readonly>
                            </td>
                            <td> 
                                <input type="text" class="form-control number quantity" name="quantity[]"   id="quantity_1" data-id='1' readonly="true" value="<?php echo !empty($cd->quantity)?sprintf('%g',$cd->quantity):0;?>" readonly> 
                            </td>
                            <td> 
                                <input type="text" class="form-control number rate" name="rate[]"   id="rate_1" data-id='1' readonly="true" value="<?php echo !empty($cd->rate)?$cd->rate:0;?>" readonly> 
                            </td>
                            <td> 
                                <input type="text" class="form-control amount" name="amount[]"   id="amount_1" data-id='1' readonly="true" value="<?php echo !empty($cd->pude_amount)?$cd->pude_amount:0;?>" readonly> 
                            </td>
                           <!--  <td> 
                                <input type="text" class="form-control number pude_remqty" name="pude_remqty[]"   id="pude_remqty_1" data-id='1' value="<?php echo !empty($cd->pude_remqty)?$cd->pude_remqty:0;?>" readonly="true"> 
                            </td>
                            <td> 
                                <input type="text" class="form-control  " id="cancelqty_1" name="cancelqty[]"  data-id='1'  value="<?php echo !empty($cd->cancelqty)?$cd->cancelqty:0;?>"> 
                            </td> -->
                            <td> 
                                <input type="text" class="form-control remarks " id="remarks_1" name="remarks[]"  data-id='1' value="<?php echo !empty($cd->remarks)?$cd->remarks:''; ?>" > 
                            </td>
                        </tr>  
                        <?php  } } ?>  
                    </tbody>
                </table>
            </div>
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-md-12">
                <button type="submit" class="btn btn-info  save" accesskey="n" data-operation='<?php echo !empty($item_data)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($item_data)?'Update':'Save' ?></button>
            </div>
            
            <div class="col-sm-12">
                <div class="alert-success success"></div>
                <div class="alert-danger error"></div>
                <div class="showPrintedArea"></div>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).off('click','#srchCancelOrder');
    $(document).on('click','#srchCancelOrder',function(){
        ajax_search_cancel_order();
    });

    function blink_text() {
        $('.blink').fadeOut(100);
        $('.blink').fadeIn(1000);
    }

    function ajax_search_cancel_order()
    {
        var ordernumber = $("#orderNumber").val();
        var fiscalyear = $("#fiscalyear").val();
        var mattypeid=  $('#mattypeid').val();

        var submitdata = {ordernumber:ordernumber,fiscalyear:fiscalyear,mattypeid:mattypeid};
        var submiturl = base_url+'purchase_receive/cancel_order/cancel_order_details';
        beforeSend= $('.overlay').modal('show');

        ajaxPostSubmit(submiturl,submitdata,beforeSend='',onSuccess);

        function onSuccess(jsons) 
        {
            data = jQuery.parseJSON(jsons);   
            // alert(data.status);
            if(data.status=='success')
            {
                $('#orderForm').html(data.tempform);
                // handleMessage('success',data.message);

            }else{
                $('.dataTable').html('');
                handleMessage('error',data.message);
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
    $('.nepdatepicker').nepaliDatePicker({
        npdMonth: true,
        npdYear: true,
        //npdYearCount: 10 // Options | Number of years to show
    });
</script>



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

<script>
    $(document).off('blur change','#issuedate');
    $(document).on('blur change','#issuedate',function(){
        var issuedate = $('#issuedate').val();
        var curdate = "<?php echo CURDATE_NP;?>";

        var selected_date_id = '#issuedate';
        var errorMsg = 'Issue date should not exceed current date. Please check it.';
        compare_date(issuedate, curdate, selected_date_id,errorMsg);
    });
   

    $(document).off('blur change','#requisition_date');
    $(document).on('blur change','#requisition_date',function(){
        var req_date = $('#requisition_date').val();
        var issuedate = $('#issuedate').val();

        var selected_date_id = '#requisition_date';
        var errorMsg = 'Requisition date should not exceed issue date. Please check it.';
        compare_date(req_date, issuedate, selected_date_id, errorMsg);
    });

</script>

<script type="text/javascript">

     function getDetailList(masterid, main_form=false){
            if(main_form == 'main_form'){
                var submiturl = base_url+'purchase_receive/cancel_order/load_detail_list/new_detail_list';
                var displaydiv = '#displayDetailList'; 
            }else{
                var submiturl = base_url+'purchase_receive/cancel_order/load_detail_list';
                var displaydiv = '#detailListBox';
            }
            
            $.ajax({
                type: "POST",
                url: submiturl,
                data: {masterid : masterid},
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

    $(document).off('change','#fiscalyear');
    $(document).on('change','#fiscalyear',function(){
        var fyear = $('#fiscalyear').val();
        $('#cancelLoad').attr('data-fyear',fyear);
    });
</script>