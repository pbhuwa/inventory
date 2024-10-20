<style>
    .purs_table tbody tr td{
        border: none;
        vertical-align: center;
    }
</style>
<form method="post" id="FormIssueCancel" action="<?php echo base_url('issue_consumption/new_issue/save_issue_return'); ?>" data-reloadurl="<?php echo base_url('issue_consumption/new_issue/form_issue_return');?>" class="form-material form-horizontal form">

    <input type="hidden" name="id" value="">

    <div id="issueDetails">
      
        <div class="form-group">
            <div class="col-md-2 col-sm-3">
                <label for="example-text"><?php echo $this->lang->line('issue_no'); ?> :</label>
                <input type="text" class="form-control enterinput" name="rema_issueno" id="issue_no"  value="<?php echo !empty($this->input->post('id'))?$this->input->post('id'):''; ?>" placeholder="Issue Number" data-targetbtn='btnSearchreturn'>
            </div>
            
            <div class="col-md-2 col-sm-3">
                <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?> <span class="required">*</span>:</label>
                <select name="rema_fyear" class="form-control required_field" id="fiscalyrs" >
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
                        <a href="javascript:void(0)" class="btn btn-sm btn-success" id="btnSearchreturn"><?php echo $this->lang->line('search'); ?></a>
                    </div>
            </div>
        </div>

        <div class="clearfix"></div>
    
        <div class="form-group">
            <div class="col-md-2 col-sm-3">
                <label for="example-text"><?php echo $this->lang->line('return_date'); ?> :</label>
                <input type="text" class="form-control <?php echo DATEPICKER_CLASS; ?> " name="rema_returndate" value="<?php echo DISPLAY_DATE; ?>" placeholder="Return Date" id="return_date" >
            </div>   
            
            <div class="col-md-2 col-sm-3">
                <label for="example-text"><?php echo $this->lang->line('return_by'); ?><span class="required">*</span>:</label>
                <input type="text" class="form-control required_field " name="rema_returnby" value="" id="return_by"  >
            </div>   
            
            <div class="col-md-3 col-sm-4">
                <label for="example-text"><?php echo $this->lang->line('issue_to'); ?>:</label>
                <input type="text" class="form-control " name="rema_issueto" value=""  id="issue_to" disabled="disabled" >
                <input type="hidden" name="rema_depid" id="depid" />
            </div>   
            
            <div class="col-md-2 col-sm-3">
                <label for="example-text"><?php echo $this->lang->line('amount'); ?>:</label>
                <input type="text" class="form-control " name="rema_amount" value="0.00" placeholder="Return Amount" id="return_amt" disabled="disabled" >
            </div>   
            
            <div class="col-md-2 col-sm-3">
                <label><?php echo $this->lang->line('bill_date'); ?></label>
                <span id="billdate"></span>
            </div>
        </div>
    
        <div class="clearfix"></div>
        
        <div class="form-group">
            <div class="col-md-2 col-sm-3">
                <label for="example-text"><?php echo $this->lang->line('return_invoice'); ?>:</label>
                <input type="text" class="form-control " name="rema_invoiceno" value="<?php echo $return_issue_no; ?>"  id="return_invoice"  >
            </div>
        </div>
       

        <div class="form-group">
            <div class="pad-5" id="DisplayIssue_cancel">
                <div class="table-responsive">
                    <table style="width:100%;" class="table purs_table dt_alt dataTable">
                        <thead>
                            <tr>
                                <th width="5%"> <?php echo $this->lang->line('sn'); ?> </th>
                                <th width="8%"> <?php echo $this->lang->line('item_code'); ?>  </th>
                                <th width="25%"> <?php echo $this->lang->line('item_name'); ?> </th>
                                <th width="8%"> <?php echo $this->lang->line('issue_qty'); ?> </th>
                                <!-- <th width="15%"> AR Qty </th> -->
                                <th width="8%"> <?php echo $this->lang->line('rate'); ?>  </th>
                                <th width="8%"> <?php echo $this->lang->line('return_qty'); ?> </th>
                                <th width="8%"> <?php echo $this->lang->line('total_amount'); ?> </th>
                                <th width="15%"><?php echo $this->lang->line('remarks'); ?></th>
                                <th width="5%"><?php echo $this->lang->line('action'); ?></th>
                            </tr>
                        </thead>
                        <tbody id="IssueBody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <label for="example-text"><?php echo $this->lang->line('notes_if_any'); ?>: </label>
                <input type="text" name="rema_remarks" class="form-control"  placeholder="Enter Notes (If any)" value="<?php echo !empty($new_issue[0]->rema_remarks)?$new_issue[0]->rema_remarks:''; ?>" id="rema_remarks">
                <span class="errmsg"></span>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="form-group">
            <div class="col-md-12">
                <?php 
          $save_var=$this->lang->line('save');
                $update_var=$this->lang->line('search');

                // $update_var:$save_var;
        ?>
                <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($item_data)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($item_data)?$update_var:$save_var; ?></button>
                 <button type="submit" class="btn btn-info savePrint" data-operation='<?php echo !empty($item_data)?'update':'save ' ?>' id="btnSubmit" data-print="print"><?php echo !empty($item_data)?'Update & Print':'Save & Print' ?></button>
            </div>
            
            <div class="col-sm-12">
                <div  class="alert-success success"></div>
                <div class="alert-danger error"></div>
            </div>
        </div>
    </div>
</form> 

<script type="text/javascript">
    $(document).off('click','#btnSearchreturn');
   $(document).on('click','#btnSearchreturn',function(){


    var issue_no=$('#issue_no').val();
    var fiscalyrs=$('#fiscalyrs').val();
    // alert(issue_no);
    // ajaxPostSubmit()
    var submitdata = {issue_no:issue_no,fiscalyrs:fiscalyrs};
    var submiturl = base_url+'issue_consumption/new_issue/issuelist_by_issue_no_for_return';
    beforeSend= $('.overlay').modal('show');

    ajaxPostSubmit(submiturl,submitdata,beforeSend='',onSuccess);
  
    function onSuccess(jsons){
        data = jQuery.parseJSON(jsons);
        // console.log(data.order_data);
        var issue_data=data.issue_data;
        console.log(issue_data);

       

        $('#ndp-nepali-box').hide();
       
        if(data.status=='success')
        {
            if(issue_data)
            {
                var depid = issue_data[0].sama_depid;
                var issue_to=issue_data[0].sama_depname;
                var return_by=issue_data[0].sama_receivedby;
                var billdatead=issue_data[0].sama_billdatead;
                var billdatebs=issue_data[0].sama_billdatebs;
                $('#depid').val(depid); 
                $('#issue_to').val(issue_to);  
                $('#return_by').val(return_by);  
                $('#billdate').html(billdatead+'(AD)|'+billdatebs+'(BS)');

            }
            $('#IssueBody').html(data.tempform);
        }
        else
        {   
             $('#IssueBody').html('');
             $('#issue_to').val('');
             $('#return_by').val('');

            alert(data.message); 
           
        }
        $('.overlay').modal('hide');
    }

   })
</script>

<script type="text/javascript">
    $(document).on('keyup','.calculatamt',function()
    {
        var id=$(this).data('id');
        var retqty=$('#returnqty_'+id).val();
        var rate =$('#unite_rate_'+id).val();
        var issqty=$('#issueqty_'+id).val();
        var stotal=0;
        if(parseInt(retqty)>parseInt(issqty))
        {
            alert('Return Qty. is greater than issue Qty.');
            $('#returnqty_'+id).val(0);
            return false;
        }
        if(!retqty)
        {
            retqty=0;
        }
        var totalval=parseFloat(retqty)*parseFloat(rate);
        $('#returnAmt_'+id).html(totalval.toFixed(2));
        $('#retamt_total_'+id).val(totalval.toFixed(2));
         $(".retamttotal").each(function() {
            retamt=$(this).val();
                if(!retamt)
                {
                    retamt=0;
                }

                stotal += parseFloat(retamt);
                });
            $('#return_amt').val(stotal);

    })
</script>

<?php if($this->input->post()): ?>
<script type="text/javascript">
    setTimeout(function(){
        $('#btnSearchreturn').click();
    },800);
</script>
<?php endif; ?>