<style>
    .purs_table tbody tr td{
        border: none;
        vertical-align: center;
    }
</style>

<form method="post" id="FormIssueCancel" action="<?php echo base_url('issue_consumption/new_issue/save_new_issue'); ?>" data-reloadurl="<?php echo base_url('issue_consumption/new_issue/form_new_issue');?>" class="form-material form-horizontal form">
    <input type="hidden" name="id" value="">

    <div id="issueDetails">
        <div class="form-group">
             <?php echo $this->general->location_option(2,'locationid'); ?>
            <div class="col-md-2 col-sm-3">
                <label for="example-text"><?php echo $this->lang->line('invoice_no'); ?> <span class="required">*</span>:</label>
                <input type="text" class="form-control required_field enterinput" name="invoice_no" id="invoice_no"  value="<?php echo !empty($this->input->post('id'))?$this->input->post('id'):''; ?>" placeholder="Receive No." data-targetbtn='btnSearchDirectPurchase' >
            </div>

            <div class="col-md-2 col-sm-3">
                <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?><span class="required">*</span>:</label>
                
                <select name="fiscal_year" id="fiscal_year" class="form-control required_field select2" >
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
            
            <div  class="col-md-2 col-sm-3">
                <label>&nbsp;</label>
                <div>
                    <a href="javascript:void(0)" class="btn btn-sm btn-success" id="btnSearchDirectPurchase"><?php echo $this->lang->line('search'); ?></a>
                </div>
            </div>
        </div>
    
        <div class="search_pm_data pad-5" id="detail_issue" style="display: none">
            <ul class="pm_data pm_data_body col4 ">
                <li>
                    <label><?php echo $this->lang->line('invoice_no'); ?> :</label><span id="invoiceno"></span>
                </li> 
                <li>
                    <label><?php echo $this->lang->line('supplier_name'); ?> :</label><span id="supplier_name"></span>
                </li> 
                <li>
                    <label><?php echo $this->lang->line('total_discount'); ?>: </label><span id="total_discount"></span>
                </li> 

                <li>
                    <label><?php echo $this->lang->line('receive_no'); ?> :</label><span id="received_no"></span>
                </li>
                <li>
                    <label><?php echo $this->lang->line('received_date'); ?> :</label><span id="received_date"></span> 
                </li>  
                <li>
                    <label><?php echo $this->lang->line('total_vat'); ?>: </label><span id="total_vat"></span>
                </li>

                <li>
                    <label><?php echo $this->lang->line('supplier_bill_no'); ?> :</label><span id="supplier_billno"></span>
                </li>
                <li>
                    <label><?php echo $this->lang->line('supplier_bill_date'); ?> :</label><span id="supplier_billdate"></span> 
                </li>
                <li>
                    <label><?php echo $this->lang->line('total_amount'); ?>: </label><span id="total_amount"></span>
                </li>

                <li>
                    <label><?php echo $this->lang->line('fiscal_year'); ?>: </label><span id="fyear"></span>
                </li>
                <li>
                    <label><?php echo $this->lang->line('received_by'); ?> :</label><span id="received_by"></span>
                </li> 
               
                <li>
                    <span id="cancel_issue_link">
                        <a href="javascript:void(0)" class="btn btn-sm btn-danger btnConfirmAll" title='Cancel' data-url='<?php echo base_url('purchase_receive/direct_purchase/direct_purchase_cancel_item_all') ?>' data-id="" data-msg='Cancel This Direct Purchase ?' data-rowid="" ><i class="fa fa-remove" ></i> Cancel Direct Purchase</a> 
                    </span>
                </li> 
            </ul>
        </div>

        <div class="form-group">
            <div class="pad-5" id="DisplayIssue_cancel">
                <div class="table-responsive">
                    <table style="width:100%;" class="table purs_table dt_alt dataTable">
                        <thead>
                            <tr>
                                <th width="5%"> <?php echo $this->lang->line('sn'); ?> </th>
                                <th width="10%"> <?php echo $this->lang->line('item_code'); ?>  </th>
                                <th width="15%"> <?php echo $this->lang->line('item_name'); ?> </th>
                                <th width="10%"> <?php echo $this->lang->line('qty'); ?> </th>
                                <th width="10%"> <?php echo $this->lang->line('rate'); ?></th>
                                <th width="15%"> <?php echo $this->lang->line('amount'); ?></th>
                            </tr>
                        </thead>
                        
                        <tbody id="IssueBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="success"></div>
        <div class="error"></div>
        
        <div class="clearfix"></div>
    </div>
</form> 


<script type="text/javascript">
    $(document).off('click','#btnSearchDirectPurchase');
    $(document).on('click','#btnSearchDirectPurchase',function(){

        var invoice_no=$('#invoice_no').val();
        var fiscal_year=$('#fiscal_year').val();
        var locationid=$('#locationid').val();

        // alert(invoice_no);
        // ajaxPostSubmit()
        var submitdata = {invoice_no:invoice_no,fiscal_year:fiscal_year,locationid:locationid};
        var submiturl = base_url+'purchase_receive/direct_purchase/direct_purchase_list_by_invoice_no';
        beforeSend= $('.overlay').modal('show');

        ajaxPostSubmit(submiturl,submitdata,beforeSend='',onSuccess);
      
        function onSuccess(jsons){
            data = jQuery.parseJSON(jsons);
            $('#ndp-nepali-box').hide();
            if(data.status=='success')
            {
                $('#IssueBody').html(data.tempform);
                $('#detail_issue').show();
                var received_data=data.received_data;
                // console.log(data.received_data);
                var receive_no=received_data[0].recm_receivedno;
                var supplier_name=received_data[0].dist_distributor;
                var received_datead=received_data[0].recm_receiveddatead;
                var received_datebs=received_data[0].recm_receiveddatebs;
                var supplier_billno=received_data[0].recm_supplierbillno;
                var supplier_billdatead=received_data[0].recm_supbilldatead;
                var supplier_billdatebs=received_data[0].recm_supbilldatebs;
                var received_by=received_data[0].recm_postusername;
                var total_discount=received_data[0].recm_discount;
                var total_tax=received_data[0].recm_taxamount;
                var total_amount=received_data[0].recm_amount;
                var masterid = received_data[0].recm_receivedmasterid;
                var status = received_data[0].recm_status;
                var postdatebs = received_data[0].recm_postdatebs;
                var postdatead = received_data[0].recm_postdatead;
                var invoice_no = received_data[0].recm_invoiceno;
                var fyear = received_data[0].recm_fyear;
                // alert(status);
                

                $('#received_no').html(receive_no);
                $('#supplier_name').html(supplier_name);
                $('#received_date').html(received_datead+'(AD) | '+received_datebs+'(BS)');
                $('#supplier_billno').html(supplier_billno);
                $('#supplier_billdate').html(supplier_billdatead+'(AD) | '+supplier_billdatebs+'(BS)');
                $('#received_by').html(received_by);
                $('#total_discount').html(total_discount);
                
                $('#total_vat').html(total_tax);
                $('#total_amount').html(total_amount);
                $('#invoiceno').html(invoice_no);
                $('#fyear').html(fyear);
                $('.btnConfirmAll').attr('data-id',masterid);
                $('.btnConfirmAll').data('id',masterid);
                if(status=='C')
                {
                    $('#cancel_issue_link').html('<label>Cancel Date :</label>'+postdatebs+'(BS)/'+postdatead+'(AD');

                }
                $('.overlay').modal('hide');
            }
            else
            {   
                $('#receive_no').html('');
                $('#supplier_name').html('');
                $('#received_date').html('');
                $('#supplier_billno').html('');
                $('#supplier_billdate').html('');
                $('#received_by').html('');
                $('#total_discount').html('');
                
                $('#total_vat').html('');       
                $('#total_amount').html('');

                alert(data.message);
                $('.overlay').modal('hide');
            } 
        }
   })
</script>

<script type="text/javascript">
    $(document).off('click','.btnConfirm');
    $(document).on('click','.btnConfirm',function(e) {
        e.preventDefault();
        var submiturl = $(this).data('url');
        var id=$(this).data('id');
        var messg=$(this).data('msg');
        var rowid=$(this).data('rowid');
        // alert(url);
        $.confirm({
            template: 'primary',
            templateOk: 'primary',
            message: messg,
            onOk: function() {
                 var submitdata = {id:id}
                 var beforeSend= $('.overlay').modal('show');
                 ajaxPostSubmit(submiturl,submitdata,beforeSend='',onSuccess);
                   function onSuccess(jsons){
                    data = jQuery.parseJSON(jsons);
                    // console.log(data.order_data);
                    if(data.status=='success')
                    {
                        $('#row_'+rowid).addClass('text-danger');
                    }
                    else
                    {   
                         
                        alert(data.message); 
                    }
                    $('.overlay').modal('hide');
                }

            },
            onCancel: function() {
                
            }
        });
    });

$(document).off('click','.btnConfirmAll');
    $(document).on('click','.btnConfirmAll',function(e) {
        e.preventDefault();
        var submiturl = $(this).data('url');
        var id=$(this).data('id');
        var messg=$(this).data('msg');
        var rowid=$(this).data('rowid');
        // alert(url);
        $.confirm({
            template: 'primary',
            templateOk: 'primary',
            message: messg,
            onOk: function() {
                 var submitdata = {id:id}
                 var beforeSend= $('.overlay').modal('show');
                 ajaxPostSubmit(submiturl,submitdata,beforeSend='',onSuccess);
                   function onSuccess(jsons){
                    data = jQuery.parseJSON(jsons);
                    // console.log(data.order_data);
                    if(data.status=='success')
                    {
                        // $('#row_'+rowid).addClass('text-danger');
                        $('#cancel_issue_link').html('');
                        $('.trclass').addClass('text-danger');
                        $('.trstatus').html('');
                    }
                    else
                    {   
                         
                        alert(data.message); 
                    }
                    $('.overlay').modal('hide');
                }

            },
            onCancel: function() {
                
            }
        });
    });
</script>

<?php if($this->input->post()): ?>
<script type="text/javascript">
    setTimeout(function(){
        $('#btnSearchDirectPurchase').click();
    },800);
</script>
<?php endif; ?>