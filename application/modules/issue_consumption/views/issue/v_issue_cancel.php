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
       
        <label for="example-text"><?php echo $this->lang->line('issue_no'); ?> :</label>
        <input type="text" class="form-control required_field enterinput" name="sama_invoiceno" id="issue_no"  value="<?php echo !empty($this->input->post('id'))?$this->input->post('id'):''; ?>" placeholder="Issue Number" data-targetbtn='btnSearchIssue' >
    </div>

    <div class="col-md-2 col-sm-3">
        <label for="example-text"><?php echo $this->lang->line('issue_date'); ?>:</label>
        <?php $issuedate=!empty($this->input->post('date'))?$this->input->post('date'):''; ?>
        <input type="text" class="form-control <?php echo DATEPICKER_CLASS; ?> enterinput" name="issue_date" value="<?php echo !empty($issuedate)?$issuedate:DISPLAY_DATE; ?>" placeholder="Issue Date" id="issue_date"  data-targetbtn='btnSearchIssue'>
    </div>   
    <div  class="col-md-2 col-sm-3">
        <label>&nbsp;</label>
        <div>
            <a href="javascript:void(0)" class="btn btn-sm btn-success" id="btnSearchIssue"><?php echo $this->lang->line('search'); ?></a>
        </div>
    </div>
</div>
<div class="search_pm_data pad-5" id="detail_issue" style="display: none">
    <ul class="pm_data pm_data_body col4 ">
 <li>
    <label><?php echo $this->lang->line('department'); ?> :</label><span id="depname"></span>
    </li>  
    <li>
        <label><?php echo $this->lang->line('total_amount'); ?> :</label><span id="totamt"></span>
    </li>  
    <li>
        <label><?php echo $this->lang->line('received_by'); ?> :</label> <span id="received_by"></span>   
    </li>  
    <li>
        <label><?php echo $this->lang->line('req_no'); ?>:</label><span id="req_no"></span> 
    </li>  
    <li>
        <label><?php echo $this->lang->line('issue_date'); ?>:</label><span id="issuedate"></span>
    </li>  
    <li>
        <label><?php echo $this->lang->line('issue_time'); ?>:</label><span id="issue_time"></span> 
    </li>
     <li>
        <label><?php echo $this->lang->line('issue_by'); ?> :</label><span id="issueby"></span>
    </li> 
    <li><span id="cancel_issue_link">
       <a href="javascript:void(0)" class="btn btn-sm btn-danger btnConfirmAll" title='Cancel' data-url='<?php echo base_url('issue_consumption/new_issue/issue_cancel_item_all') ?>' data-id="" data-msg='Cancel This Issue ?' data-rowid="" ><i class="fa fa-remove" ></i> <?php echo $this->lang->line('issue_cancel'); ?></a> 
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
                    <th width="10%"> <?php echo $this->lang->line('item_code'); ?> </th>
                    <th width="15%"> <?php echo $this->lang->line('item_name'); ?> </th>
                   <!--  <th width="10%"> Batch  </th>
                    <th width="10%"> Expiry Date </th> -->
                    <th width="10%"> <?php echo $this->lang->line('qty'); ?> </th>
                    <th width="10%"> <?php echo $this->lang->line('rate'); ?> </th>
                    <th width="15%"> <?php echo $this->lang->line('amount'); ?> </th>
                    <!-- <th width="10%">Action</th> -->
                </tr>
            </thead>
                <tbody id="IssueBody">
                   
                   
                </tbody>
        </table>
    </div>
    </div>
</div>

<div class="clearfix"></div>

    <!-- <div class="form-group">
        <div class="col-md-12">
            <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($item_data)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($item_data)?'Update':'Save' ?></button>
        </div>
          <div class="col-sm-12">
            <div  class="alert-success success"></div>
            <div class="alert-danger error"></div>
          </div>
    </div> -->
</div>

</form> 


<script type="text/javascript">

  $(document).off('click','#btnSearchIssue');
   $(document).on('click','#btnSearchIssue',function(){
    var issue_no=$('#issue_no').val();
    var issue_date=$('#issue_date').val();
    var locationid=$('#locationid').val();
    // alert(issue_no);
    // ajaxPostSubmit()
    var submitdata = {issue_no:issue_no,issue_date:issue_date ,locationid:locationid};
    var submiturl = base_url+'issue_consumption/new_issue/issuelist_by_issue_no';
    beforeSend= $('.overlay').modal('show');

    ajaxPostSubmit(submiturl,submitdata,beforeSend='',onSuccess);
  
    function onSuccess(jsons){
        data = jQuery.parseJSON(jsons);
        $('#ndp-nepali-box').hide();
        if(data.status=='success')
        {

            $('#IssueBody').html(data.tempform);
            $('#detail_issue').show();
             var issue_data=data.issue_data;
            // console.log(data.issue_data);
            var depname=issue_data[0].sama_depname;
            var received_by=issue_data[0].sama_receivedby;
            var issue_time=issue_data[0].sama_billtime;
            var fyear=issue_data[0].sama_fyear;
            var totamt=issue_data[0].sama_totalamount;
            var billdatebs=issue_data[0].sama_billdatebs;
            var billdatead=issue_data[0].sama_billdatead;
            var reqno=issue_data[0].sama_requisitionno;
            var issueby=issue_data[0].sama_soldby;
            var masterid=issue_data[0].sama_salemasterid;
            var samast=issue_data[0].sama_st;
            // alert(samast);
            var sama_stdatebs=issue_data[0].sama_stdatebs;
            var sama_stdatead=issue_data[0].sama_stdatead;
            

            $('#depname').html(depname);
            $('#totamt').html(totamt);
            $('#received_by').html(received_by);
            $('#req_no').html(reqno);
            $('#issuedate').html(billdatebs+'(BS) | '+billdatead+'(AD)');
            $('#issue_time').html(issue_time);
            $('#issueby').html(depname);
            $('.btnConfirmAll').attr('data-id',masterid);
            $('.btnConfirmAll').data('id',masterid);
            if(samast=='C')
            {
                $('#cancel_issue_link').html('<label>Cancel Date :</label>'+sama_stdatebs+'(BS)/'+sama_stdatead+'(AD');

            }
             $('.overlay').modal('hide');
        }
        else
        {   
        $('#detail_issue').hide();
        $('#IssueBody').html('');
        $('#depname').html('');
        $('#totamt').html('');
        $('#received_by').html('');
        $('#req_no').html('');
        $('#issuedate').html('');
        $('#issue_time').html('');
        $('#issueby').html('');
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
        $('#btnSearchIssue').click();
    },800);
</script>
<?php endif; ?>