<style>
    .purs_table tbody tr td{
        border: none;
        vertical-align: center;
    }
</style>
<form method="post" id="FormIssueCancel" action="<?php echo base_url('issue_consumption/new_issue/save_new_issue'); ?>" data-reloadurl="<?php echo base_url('issue_consumption/new_issue/form_new_issue');?>" class="form-material form-horizontal form">

    <input type="hidden" name="id" value="" id="masterid" >

    <div id="issueDetails">
      
<div class="form-group">
    <?php echo $this->general->location_option(2,'locationid');?>
     <div class="col-md-2 col-sm-3">
       
        <label for="example-text"><?php echo $this->lang->line('return_no'); ?> :</label>
        <input type="text" class="form-control enterinput" name="return_no" id="return_no"  value="<?php echo !empty($this->input->post('id'))?$this->input->post('id'):''; ?>" placeholder="Return Number" data-targetbtn='btnSearchReturn' >
    </div>

    <div class="col-md-2 col-sm-3">
        <label for="example-text"><?php echo $this->lang->line('return_date'); ?> :</label>
        <?php $returndate=!empty($this->input->post('date'))?$this->input->post('date'):''; ?>
        <input type="text" class="form-control <?php echo DATEPICKER_CLASS; ?> enterinput" name="return_date" value="<?php echo !empty($returndate)?$returndate:DISPLAY_DATE; ?>" placeholder="Return Date" id="return_date"  data-targetbtn='btnSearchReturn'>
    </div>   
    <div  class="col-md-2 col-sm-3">
        <label>&nbsp;</label>
        <div>
            <a href="javascript:void(0)" class="btn btn-sm btn-success" id="btnSearchReturn"><?php echo $this->lang->line('search'); ?></a>
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
        <label><?php echo $this->lang->line('received_by'); ?> :</label> <span id="username"></span>   
    </li>  
    <li>
        <label><?php echo $this->lang->line('receive_no'); ?>:</label><span id="receive_no"></span> 
    </li>  
    <li>
        <label><?php echo $this->lang->line('return_date'); ?>:</label><span id="returndate"></span>
    </li>  
    <li>
        <label><?php echo $this->lang->line('return_time'); ?>:</label><span id="return_time"></span> 
    </li>
     <li>
        <label><?php echo $this->lang->line('return_by'); ?> :</label><span id="return_by"></span>
    </li> 
    <li><span id="cancel_issue_link">
       <a href="javascript:void(0)" class="btn btn-sm btn-danger btnConfirmAll" title='Cancel' data-url='<?php echo base_url('issue_consumption/new_issue/return_cancel_item_all') ?>' data-id="" data-msg='Cancel This Return ?' data-rowid="" ><i class="fa fa-remove" ></i> <?php echo $this->lang->line('return_cancel'); ?></a> 
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
                    <th width="10%"> <?php echo $this->lang->line('batch'); ?>  </th>
                    <th width="10%"> <?php echo $this->lang->line('expiry_date'); ?> </th>
                    <th width="10%"> <?php echo $this->lang->line('qty'); ?> </th>
                    <th width="10%"> <?php echo $this->lang->line('rate'); ?></th>
                    <th width="15%"> <?php echo $this->lang->line('amount'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('action'); ?></th>
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
    $(document).off('click','#btnSearchReturn');
   $(document).on('click','#btnSearchReturn',function(){


    var return_no=$('#return_no').val();
    var return_date=$('#return_date').val();
    var locationid=$('#locationid').val();
    // alert(return_no);
    // ajaxPostSubmit()
    var submitdata = {return_no:return_no,return_date:return_date,locationid:locationid};
    var submiturl = base_url+'issue_consumption/new_issue/issuelist_by_return_no';
    beforeSend= $('.overlay').modal('show');

    ajaxPostSubmit(submiturl,submitdata,beforeSend='',onSuccess);
  
    function onSuccess(jsons){
        data = jQuery.parseJSON(jsons);
        $('#ndp-nepali-box').hide();
        if(data.status=='success')
        {

            $('#IssueBody').html(data.tempform);
            $('#detail_issue').show();
             var return_data=data.return_data;
            // console.log(data.return_data);
            var depname=return_data[0].dept_depname;
            var username=return_data[0].rema_username;
            var return_time=return_data[0].rema_returntime;
            var fyear=return_data[0].rema_fyear;
            var totamt=return_data[0].rema_amount;
            var returndatebs=return_data[0].rema_returndatebs;
            var returndatead=return_data[0].rema_returndatead;
            var receiveno=return_data[0].rema_receiveno;
            var return_by=return_data[0].rema_returnby;
            var masterid=return_data[0].rema_returnmasterid;
            var remast=return_data[0].rema_st;
            // alert(remast);
            var rema_stdatebs=return_data[0].rema_stdatebs;
            var rema_stdatead=return_data[0].rema_stdatead;
            

            $('#depname').html(depname);
            $('#totamt').html(totamt);
            $('#return_by').html(return_by);
            $('#receive_no').html(receiveno);
            $('#returndate').html(returndatebs+'(BS) | '+returndatead+'(AD)');
            $('#return_time').html(return_time);
            $('#username').html(username);
            $('.btnConfirmAll').attr('data-id',masterid);
            $('.btnConfirmAll').data('id',masterid);

            if(remast=='C')
            {
                $('#cancel_issue_link').html('<label>Cancel Date :</label>'+rema_stdatebs+'(BS)/'+rema_stdatead+'(AD');

            }
            else
            {
                $('#cancel_issue_link').html("<a href='javascript:void(0)' class='btn btn-sm btn-danger btnConfirmAll' title='Cancel' data-url='<?php echo base_url('issue_consumption/new_issue/return_cancel_item_all') ?>' data-id='"+masterid+"' data-msg='Cancel This Return ?' data-rowid='"+masterid+"' ><i class='fa fa-remove' ></i> <?php echo $this->lang->line('return_cancel'); ?></a> ");
            }

             $('.overlay').modal('hide');
        }
        else
        {   
        $('#detail_issue').hide();
        $('#IssueBody').html('');
        $('#depname').html('');
        $('#totamt').html('');
        $('#return_by').html('');
        $('#receive_no').html('');
        $('#returndate').html('');
        $('#return_time').html('');
        $('#return_by').html('');
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
        $('#btnSearchReturn').click();
    },800);
</script>
<?php endif; ?>