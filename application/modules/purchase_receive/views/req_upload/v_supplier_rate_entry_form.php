<style>
    .purs_table tbody tr td{
    border: none;
    vertical-align: center;
    }
</style>
<?php
    if(DEFAULT_DATEPICKER == 'NP'){
        $quotation_date = !empty($upload_data[0]->quma_quotationdatebs)?$upload_data[0]->quma_quotationdatebs:'';
        $supplier_qdate = !empty($upload_data[0]->quma_supplierquotationdatebs)?$upload_data[0]->quma_supplierquotationdatebs:'';  
        $expdate = !empty($upload_data[0]->quma_expdatebs)?$upload_data[0]->quma_expdatebs:''; 
        $curdate = CURDATE_NP; 
    }else{
        $quotation_date = !empty($upload_data[0]->quma_quotationdatead)?$upload_data[0]->quma_quotationdatead:'';
        $supplier_qdate = !empty($upload_data[0]->quma_supplierquotationdatead)?$upload_data[0]->quma_supplierquotationdatead:'';
        $expdate = !empty($upload_data[0]->quma_expdatead)?$upload_data[0]->quma_expdatead:'';
        $curdate = CURDATE_EN;
    }
?>

<form method="post" id="formReqUpload" action="<?php echo base_url('purchase_receive/req_upload/save_supplier_rate_entry'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('purchase_receive/req_upload/form_supplier_rate_entry'); ?>' enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo!empty($upload_data[0]->reum_reumid)?$upload_data[0]->reum_reumid:'';  ?>">

    <div class="form-group">
        <div class="col-md-3 col-sm-4">

            <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?><span class="required">*</span>:</label>
            <select name="fiscalyear" class="form-control select2" id="fiscalyear" >
                <option value="">---select---</option>
                    <?php
                        if($fiscal):
                            foreach ($fiscal as $km => $fy):
                    ?>
                <option value="<?php echo $fy->fiye_name; ?>" <?php if($fy->fiye_status=='I') echo "selected=selected"; ?>><?php echo $fy->fiye_name; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
            </select>
        </div>
              
         <div class="col-md-3 col-sm-4">
            <label for="example-text"><?php echo $this->lang->line('upload_no'); ?><span class="required">*</span>: </label>

            <div class="dis_tab">
                <input type="text" name="req_no" class="form-control number enterinput required_field"  placeholder="Enter Requisition Upload Number" value="" id="requisitionNumber" data-targetbtn="btnSearchReqno">
                
                <a href="javascript:void(0)" class="table-cell width_30 btn btn-success" id="btnSearchReqno"><i class="fa fa-search"></i></a>&nbsp;

                <a href="javascript:void(0)"  data-id="0" data-fyear="<?php echo CUR_FISCALYEAR;?>" data-displaydiv="Order" data-viewurl="<?php echo base_url() ?>purchase_receive/req_upload/load_req_upload_for_rate_entry" class="view table-cell width_30 btn btn-success" data-heading="<?php echo $this->lang->line('supplier_rate_entry')?>" id="orderLoad" ><i class="fa fa-upload"></i></a> 
            </div>
            <span class="errmsg"></span>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-3 col-sm-4">
            <label for="Supplier"><?php echo $this->lang->line('supplier_name'); ?> <span class="required">*</span>:</label>
            <div class="dis_tab">
                <?php
                    $supplierid = !empty($upload_data[0]->reum_supplierid)?$upload_data[0]->reum_supplierid:'';
                ?>
                <select id="supplierid" name="supplierid" class="form-control required_field select2" >
                    <option value="">---select---</option>
                    <?php
                        if($supplier_all):
                            foreach ($supplier_all as $ks => $supp):
                        ?>
                    <option value="<?php echo $supp->dist_distributorid; ?>" 
                        <?php echo ($supplierid == $supp->dist_distributorid)?'selected="selected"':''; ?> 
                        <?php echo in_array($supp->dist_distributorid,$quotation_supplier)?'disabled="disabled"':''; ?> >
                        <?php echo $supp->dist_distributor; ?> 
                    </option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </select>
                <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading='Supplier Entry' data-viewurl='<?php echo base_url('biomedical/distributors/supplier_entry/modal'); ?>'><i class="fa fa-plus"></i></a>
            </div>
        </div>

        <div class="col-md-3 col-sm-4">
            <label for="urem_supplierdate">
                <?php echo $this->lang->line('supplier_date'); ?>
                <span class="required">*</span>:
            </label>
            <input type="text" name="supplierdate" class="form-control required_field <?php echo DATEPICKER_CLASS; ?> date" placeholder="Valid Upto" id="urem_supplierdate" value="<?php echo !empty($valid_date)?$valid_date:$curdate; ?>" readonly="true">
        </div>

        <div class="col-md-3 col-sm-4">
            <label for="urem_manualno">
                <?php echo !empty($this->lang->line('manual_no'))?$this->lang->line('manual_no'):'Manual No.'; ?> : 
            </label>
            <input type="text" name="urem_manualno" class="form-control number" placeholder="Enter Manual Number" value="" id="urem_manualno" />
            <span class="errmsg"></span>
        </div>

        <div class="col-md-3 col-sm-4">
            <label for="urem_validdate">
                <?php echo $this->lang->line('valid_till'); ?>
                <span class="required">*</span>:
            </label>
            <input type="text" name="urem_validdate" class="form-control required_field <?php echo DATEPICKER_CLASS; ?> date" placeholder="Valid Upto" id="urem_validdate" value="<?php echo !empty($valid_date)?$valid_date:$curdate; ?>" readonly="true">
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="form-group">
        <div class="col-md-6 col-sm-4">
            <?php
                $remarks = !empty($upload_data[0]->urem_remarks)?$upload_data[0]->urem_remarks:'';
            ?>
            <label for="urem_remarks"><?php echo $this->lang->line('remarks'); ?>:</label>
            <input type="text" name="urem_remarks" class="form-control" placeholder="Remarks" id="urem_remarks" value="<?php echo $remarks;  ?>"  />
        </div>
         <div class="col-md-2 ">
         </div>
          <div class="col-md-4 ">
           <a href="javascript:void(0)" class="btn btn-sm" id="all_amt_calculate"> All Calculate Amount </a>
         </div>

    </div>
    <div class="clearfix"></div>
   

    <div class="form-group">
        <div class="table-responsive col-sm-12">
            <div class="pad-5" id="displayDetailList">
                <table style="width:100%;" class="table purs_table dataTable">
                    <thead>
                        <tr>
                            <th width="5%"> <?php echo $this->lang->line('sn'); ?> </th>
                            <th width="12%"> <?php echo $this->lang->line('item_name'); ?>  </th>
                            <th width="25%"> <?php echo $this->lang->line('manufacturer'); ?> </th>
                            <th width="10%"><?php echo $this->lang->line('qty'); ?></th>
                            <th width="10%"> <?php echo $this->lang->line('size'); ?> </th>
                            <th width="10%"> <?php echo $this->lang->line('rate'); ?></th>
                            <th width="10%"> <?php echo $this->lang->line('remarks'); ?></th>
                        </tr>
                    </thead>

                    <tbody id="purchaseBody">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-12">
            <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($upload_data)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($upload_data)?'Update':'Save' ?></button>
        </div>
        
        <div class="col-sm-12">
            <div  class="alert-success success"></div>
            <div class="alert-danger error"></div>
        </div>
    </div>
</form>


<script type="text/javascript">
    function getDetailList(masterid, main_form=false){
        if(main_form == 'main_form'){
            var submiturl = base_url+'purchase_receive/req_upload/load_req_upload_detail_list/new_detail_list';
            var displaydiv = '#displayDetailList'; 
        }else{
            var submiturl = base_url+'purchase_receive/req_upload/load_req_upload_detail_list';
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
                if(main_form == 'main_form'){
                    if(data.status == 'success'){
                        if(data.isempty == 'empty'){
                            alert('Pending list is empty. Please try again.');
                               $('#requisition_date').val('');
                               $('#receive_by').val(''); 
                               $('#depnme').select2("val",'');
                               $('#pendinglist').html('');
                               $('#stock_limit').html(0);
                               $('.loadedItems').empty();
                            return false;
                        }else{
                            $(displaydiv).empty().html(data.tempform);
                        }
                        $('.calculateamt').change();
                    }
                    load_supplier_list();
                }else{
                    if(data.status == 'success'){
                        // console.log('test detail');
                        // return false;
                        $(displaydiv).empty().html(data.tempform);
                        $('.calculateamt').change();
                        // alert('test');
                        load_supplier_list();
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

    setInterval(blink_text, 3000);
</script>

<script>
    $(document).off('click','#btnSearchReqno');
    $(document).on('click','#btnSearchReqno',function(e){
        var requisitionno = $("#requisitionNumber").val();
        var fiscalyear = $("#fiscalyear").val();
        var action=base_url+'purchase_receive/req_upload/load_req_upload_detail_list/new_detail_list';
        $.ajax({
            type: "POST",
            url: action,
            data:{requisitionno:requisitionno,fiscalyear:fiscalyear},
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
                $('#displayDetailList').html('');
                if(data.status=='success')
                {
                  $('#displayDetailList').html(data.tempform);
                  var storeid=data.storeid;
                  
                  $('#item_type').select2('val',storeid);

                  load_supplier_list();
                }
                if(data.status=='error')
                {
                     alert(data.message);
                    $("#requisitionNumber").focus();
                    $('#displayDetailList').html('');

                    load_supplier_list();
                }
                $('.overlay').modal('hide');
            }
        });
    })
</script>

<script type="text/javascript">
    function load_supplier_list(){
        var requisitionno = $("#requisitionNumber").val();
        var fiscalyear = $("#fiscalyear").val();
        var action=base_url+'purchase_receive/req_upload/load_supplier_list';
        $.ajax({
            type: "POST",
            url: action,
            data:{requisitionno:requisitionno,fiscalyear:fiscalyear},
            dataType: 'html',
             beforeSend: function() {
              // $(this).prop('disabled',true);
              // $(this).html('Saving..');
              // $('.overlay').modal('show');
            },
            success: function(jsons) 
            {
                data = jQuery.parseJSON(jsons);   
                // alert(data.status);
                // console.log(data);
                // return false;
                $('#supplierid').html('');
                if(data.status=='success')
                {
                  $('#supplierid').html(data.tempform);
                  var storeid=data.storeid;
                  
                  $('#item_type').select2('val',storeid);

                  
                }
                if(data.status=='error')
                {
                      alert(data.message);
                    $("#requisitionNumber").focus();
                    $('#supplierid').html('');
                }
                // $('.overlay').modal('hide');
            }
        });
    }
</script>

<?php
    if($loadselect2=='yes'):
    ?>
<script type="text/javascript">
    $('.select2').select2();
</script>
<?php
    endif;
?>