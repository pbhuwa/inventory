<div class="white-box pad-5 mtop_10 ">
<style>
    .purs_table tbody tr td{
    border: none;
    vertical-align: center;
    }
</style>
<?php
    if(DEFAULT_DATEPICKER == 'NP'){
        $curdate = CURDATE_NP; 
    }else{
        $curdate = CURDATE_EN;
    }
?>

<form method="post" id="formReqUpload" action="<?php echo base_url('purchase_receive/req_upload/update_req_upload'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('purchase_receive/req_upload/correction_upload_requistion_empty'); ?>' enctype="multipart/form-data">
    <input type="hidden" name="masterid" value="<?php echo!empty($master_data->reum_reumid)?$master_data->reum_reumid:'';  ?>">

    <div class="form-group">
        <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?>
                <span class="required">*</span>:
            </label>
            <?php echo !empty($master_data->reum_fyear)?$master_data->reum_fyear:''; ?>
        </div>

        <div class="col-md-3 col-sm-4">
            <label for="example-text">
                Upload No:
            </label>
           <?php echo !empty($master_data->reum_uploadno)?$master_data->reum_uploadno:''; ?>
        </div>

        <div class="col-md-3 col-sm-4">
            <label for="example-text">
                <?php echo !empty($this->lang->line('manual_no'))?$this->lang->line('manual_no'):'Manual No.'; ?> : 
            </label>
            <input type="text" name="reum_manualno" class="form-control number" placeholder="Enter Manual Number" value="<?php echo !empty($master_data->reum_manualno)?$master_data->reum_manualno:''; ?>" id="reum_manualno" />
            <span class="errmsg"></span>
        </div>

        <div class="col-md-3 col-sm-4">
            <label for="reum_validdate">
                <?php echo $this->lang->line('valid_till'); ?>
                <span class="required">*</span>:
            </label>
            <input type="text" name="reum_validdate" class="form-control required_field <?php echo DATEPICKER_CLASS; ?> date" placeholder="Valid Upto" id="reum_validdate" value="<?php echo !empty($master_data->reum_validdatebs)?($master_data->reum_validdatebs):''; ?>" readonly="true">
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="form-group">
      

        <div class="col-md-9 col-sm-4">
            <?php
                $remarks = !empty($master_data->reum_remarks)?$master_data->reum_remarks:'';
            ?>
            <label for="reum_remarks"><?php echo $this->lang->line('remarks'); ?>:</label>
            <textarea name="reum_remarks" class="form-control" placeholder="Remarks" id="reum_remarks" ><?php echo $remarks;  ?></textarea>
        </div>
         <div class="col-md-3">
            <label>&nbsp;</label>
            <a href="javascript:void(0)" class="btn btn-sm btn-danger btnCancel" data-id="<?php echo!empty($master_data->reum_reumid)?$master_data->reum_reumid:'';  ?>" data-url="<?php echo base_url('/purchase_receive/req_upload/req_upload_cancel'); ?>" style="margin-top: 48px;" data-msg='Are you want to sure to cancel this upload requisition ? '>Cancel</a>
         </div>

    </div>
    <div class="clearfix"></div>

 
    <div class="form-group">        
        <div class="table-responsive col-sm-12">            
            <div class="pad-5" id="displayDetailList">                
                <table style="width:100%;" class="table purs_table dataTable">
                    <thead>                        
                        <tr >
                            <th width="5%"> S.No.</th>                            
                            <th width="20%">Item Name</th>                         
                            <th width="25%">Manufacturer</th>
                            <th width="7%">Qty.</th>                            
                            <th width="8%">Size </th>                            
                            <th width="10%">Rate</th>                            
                            <th width="20%">Remarks</th>  
                            <th width="10%">Action</th>                      
                        </tr>                    
                    </thead>                    
                    <tbody id="excelBody">    
                    <?php
                    if(!empty($detail_data)):
                        $i=1;
                        foreach ($detail_data as $kd => $ddata):
                    ?>
                    <tr class="orderrow" id="upload_item_<?php echo $i ?>">
                        <td>
                            <input type="hidden" name="reud_reudid[]" value="<?php echo $ddata->reud_reudid ?>" class="reud_reudid" id="reud_reudid_<?php echo $i ?>">
                            <input type="text" name="" value="<?php echo $i ?>" class=" form-control s_no" id="s_no_<?php echo $i ?>" disabled="disabled">
                        </td>
                        <td>
                            <input type="text"  class="form-control "  name="reud_itemname[]" id="itemname_<?php echo $i ?>" value="<?php echo $ddata->reud_itemname ?>">
                            
                        </td>
                        <td>
                            <input type="text"  class="form-control manufacturer" name="reud_manufacturer[]" id="manufacturer_<?php echo $i ?>" value="<?php echo $ddata->reud_manufacturer ?>">
                             
                        </td>
                        <td>
                            <input type="text"  class="form-control float qty" name="reud_qty[]" id="qty_<?php echo $i; ?>" value="<?php echo $ddata->reud_qty ?>">
                           
                        </td>
                        <td>
                            <input type="text"  class="form-control size" name="reud_size[]" id="size_<?php echo $i ?>" value="<?php echo $ddata->reud_size ?>">
                            
                        </td>
                        <td>
                            <input type="text"  class="form-control float rate" name="reud_rate[]" id="rate_<?php echo $i ?>" value="<?php echo $ddata->reud_rate ?>">
                        </td>
                        <td>
                            <input type="text"  class="form-control remarks" name="reud_remarks[]" id="remarks_<?php echo $i  ?>" value="<?php echo $ddata->reud_remarks ?>">

                        </td>
                        <td>
                        <a href="javascript:void(0)" class="btn btn-sm btn-danger btnRemove" id="btnRemove_<?php echo $ddata->reud_reudid ?>" data-id="<?php echo $i ?>">
                            <i class="fa fa-remove"></i>
                        </a> 
                    </td>
                    </tr>                
                    <?php 
                        $i++;
                        endforeach;
                        endif;
                    ?>

                    </tbody>  
                    <tr class="resp_table_breaker">                        
                        <td colspan="7">                        
                        </td>                        
                        <td>
                            <a href="javascript:void(0)" class="btn btn-primary btnAdd pull-right" data-id="1" id="addOrder_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-plus" aria-hidden="true"></i></span></a>
                            <div class="clearfix"></div>
                        </td>                    
                    </tr>              
                </table>            
            </div>        
        </div>    
    </div>
    <div class="form-group">       
     <div class="col-md-12">            
        <button type="submit" class="btn btn-info  save" data-operation="save" id="btnSubmit">Update </button>        
    </div>        
        <div class="col-sm-12">            
            <div class="alert-success success"></div>            
            <div class="alert-danger error"></div>        
        </div>    
    </div>
  
</form>
</div>


<script>
    $(document).off('click','.btnRemove');
    $(document).on('click','.btnRemove',function(){
        var id=$(this).data('id');
        var whichtr = $(this).closest("tr");
        var conf = confirm('Are Your Want to Sure to remove?');
        if(conf){
            var trplusOne = $('.orderrow').length+1;
           
            whichtr.remove(); 
            setTimeout(function(){
                $(".orderrow").each(function(i,k) {
                    var vali=i+1;
                    $(this).attr("id","orderrow_"+vali);
                    $(this).attr("data-id",vali);    
                    $(this).find('.s_no').attr("id","s_no_"+vali);
                    $(this).find('.s_no').attr("value",vali);
                    $(this).find('.itemname').attr("id","itemname_"+vali);
                    $(this).find('.itemname').attr("data-id",vali);
                    $(this).find('.manufacturer').attr("id","manufacturer_"+vali);
                    $(this).find('.manufacturer').attr("data-id",vali);
                    $(this).find('.qty').attr("id","qty_"+vali);
                    $(this).find('.qty').attr("data-id",vali);
                     $(this).find('.size').attr("id","size_"+vali);
                    $(this).find('.size').attr("data-id",vali);

                    $(this).find('.rate').attr("id","rate_"+vali);
                    $(this).find('.rate').attr("data-id",vali);

                    $(this).find('.remarks').attr("id","remarks_"+vali);
                    $(this).find('.remarks').attr("data-id",vali);

                    $(this).find('.btnAdd').attr("id","addOrder_"+vali);
                    $(this).find('.btnAdd').attr("data-id",vali);
                    $(this).find('.btnRemove').attr("id","addOrder_"+vali);
                    $(this).find('.btnRemove').attr("data-id",vali);
                    $(this).find('.btnChange').attr("id","btnChange_"+vali);
                });
            },600);
        }
    });
</script>

<script type="text/javascript">
    $(document).off('click','.btnAdd');
    $(document).on('click','.btnAdd',function(e){
      var trplusOne = $('.orderrow').length + 1;
      var trpluOne = $('.orderrow').length;
      var template='<tr class="orderrow" id="upload_item_' + trplusOne +'"><td><input type="hidden" name="reud_reudid[]" value="" class="reud_reudid" id="reud_reudid_' + trplusOne +'"><input type="text" name="" value="'+trplusOne+'" class=" form-control s_no" id="s_no_' + trplusOne +'" disabled="disabled"></td><td><input type="text" class="form-control " name="reud_itemname[]" id="itemname_' + trplusOne +'" value=""></td><td><input type="text" class="form-control manufacturer" name="reud_manufacturer[]" id="manufacturer_' + trplusOne +'" value=""></td><td><input type="text" class="form-control float qty" name="reud_qty[]" id="qty_' + trplusOne +'" value=""></td><td><input type="text" class="form-control size" name="reud_size[]" id="size_' + trplusOne +'" value=""></td><td><input type="text" class="form-control float rate" name="reud_rate[]" id="rate_' + trplusOne +'" value=""></td><td><input type="text" class="form-control remarks" name="reud_remarks[]" id="remarks_' + trplusOne +'" value=""></td><td><a href="javascript:void(0)" class="btn btn-sm btn-danger btnRemove" id="btnRemove_'+trplusOne+'" data-id="' + trplusOne +'"><i class="fa fa-remove"></i></a></td></tr>';

        $('#excelBody').append(template);
    })


</script>

<script type="text/javascript">    
    $(document).off('click', '.btnCancel');
    $(document).on('click', '.btnCancel', function(e) {
        e.preventDefault();
        var submiturl = $(this).data('url');
        var id = $(this).data('id');
        var messg = $(this).data('msg');
        var redirect_url = base_url + 'purchase_receive/req_upload/req_upload_correction';
        $.confirm({
            template: 'primary',
            templateOk: 'primary',
            message: messg,
            onOk: function() {
                var submitdata = {
                    id: id
                }
                var beforeSend = $('.overlay').modal('show');
                ajaxPostSubmit(submiturl, submitdata, beforeSend = '', onSuccess);

                function onSuccess(jsons) {
                    data = jQuery.parseJSON(jsons);
                    // console.log(data.order_data);
                    if (data.status == 'success') {

                        alert(data.message);
                        window.location.href = redirect_url;
                        return false;
                    } else {

                        alert(data.message);
                        return false;
                    }
                    $('.overlay').modal('hide');
                }

            },
            onCancel: function() {

            }
        });
    });</script>

