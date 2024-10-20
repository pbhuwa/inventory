<div class="ov_report_tabs pad-5 page-tabs margin-top-250 tabbable">
<div id="FormDiv_purchase_analysis" class="formdiv frm_bdy">         
<div class="searchWrapper">
<form method="post" id="FormIssueCancel" action="<?php echo base_url('purchase_receive/receive_against_order/save_new_issue'); ?>" data-reloadurl="<?php echo base_url('purchase_receive/receive_against_order/form_new_issue');?>" class="form-material form-horizontal form">

    <input type="hidden" name="id" value="">

    <div id="issueDetails">
      
<div class="form-group">
    <?php echo $this->general->location_option(2,'locationid'); ?>
    
    <div class="col-md-2 col-sm-3">
       
        <label for="example-text"><?php echo $this->lang->line('invoice_no'); ?> :</label>
        <input type="text" class="form-control required_field enterinput" name="sama_invoiceno" id="receive_no"  value="<?php echo !empty($this->input->post('id'))?$this->input->post('id'):''; ?>" placeholder="Receive Number" data-targetbtn='btnSearchReceive' >
    </div> 
    <div  class="col-md-2 col-sm-3">
        <label>&nbsp;</label>
        <div>
            <a href="javascript:void(0)" class="btn btn-sm btn-success" id="btnSearchReceive"><?php echo $this->lang->line('search'); ?></a>
        </div>
    </div>
</div>
</div>
</form>
</div>
<div class="clearfix"></div>
<style type="text/css">
    .jo_tbl_head{
            margin-top: 26px;
    }
</style>
<div id="displayReportDiv"></div>
</div>
</div>






<script type="text/javascript">
     $(document).off('click','#btnSearchReceive');
    $(document).on('click','#btnSearchReceive',function(){
         var receive_no=$('#receive_no').val();
          var locationid=$('#locationid').val();
           var submitdata = {receive_no:receive_no,locationid:locationid};
            var submiturl = base_url+'purchase_receive/receive_against_order/receivelist_by_receive_no_edit';
            beforeSend= $('.overlay').modal('show');
            ajaxPostSubmit(submiturl,submitdata,beforeSend='',onSuccess);
  
        function onSuccess(jsons){
            data = jQuery.parseJSON(jsons);
            $('#ndp-nepali-box').hide();
            if(data.status=='success')  {

                $('#displayReportDiv').html(data.tempform);
            }
            else{
                $('#displayReportDiv').html('');
            }
               $('.overlay').modal('hide');
        }
    });
</script>

<script type="text/javascript">
    $(document).off('click','.btnConfirm');
    $(document).on('click','.btnConfirm',function(e) {
        e.preventDefault();
        var submiturl = $(this).data('url');
        var id=$(this).data('id');
        var messg=$(this).data('msg');
        var redirect_url=base_url+'purchase_receive/receive_against_order/received_order_item_list';
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
                        
                       alert(data.message);
                       window.location.href = redirect_url;
                       return false;
                    }
                    else
                    {   
                         
                        alert(data.message); 
                         return false;
                    }
                    $('.overlay').modal('hide');
                }

            },
            onCancel: function() {
                
            }
        });
    });


</script>