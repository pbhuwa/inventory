<div class="ov_report_tabs pad-5 page-tabs margin-top-250 tabbable">
<div id="FormDiv_purchase_analysis" class="formdiv frm_bdy">         
<div class="searchWrapper">
<form method="post" id="FormIssueCorrection"  class="form-material form-horizontal form">

    <input type="hidden" name="id" value="">

    <div id="issueDetails">
      
<div class="form-group">
    <?php echo $this->general->location_option(2,'locationid'); ?>
    <div class="col-md-2 col-sm-3">
        <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?> :</label>
        <select class="form-control" id="fiscalyrs">
            <?php if(!empty($fiscal)): 
                    foreach ($fiscal as $fk => $fyrs):
                ?>
                <option value="<?php echo $fyrs->fiye_name ?>" <?php if($fyrs->fiye_status=='I') echo "selected=selected"; ?>><?php echo $fyrs->fiye_name ?></option>
            <?php endforeach; endif; ?>
        </select>
    </div>
    <div class="col-md-2 col-sm-3">
       
        <label for="example-text"><?php echo $this->lang->line('issue_no'); ?> :</label>
        <input type="text" class="form-control required_field enterinput" name="sama_invoiceno" id="invoiceno"  value="<?php echo !empty($this->input->post('id'))?$this->input->post('id'):''; ?>" placeholder="Issue Number" data-targetbtn='btnSearchIssue' >
    </div> 
    <div  class="col-md-2 col-sm-3">
        <label>&nbsp;</label>
        <div>
            <a href="javascript:void(0)" class="btn btn-sm btn-success" id="btnSearchIssue"><?php echo $this->lang->line('search'); ?></a>
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
     $(document).off('click','#btnSearchIssue');
    $(document).on('click','#btnSearchIssue',function(){
         var invoiceno=$('#invoiceno').val();
          var locationid=$('#locationid').val();
          if(locationid=='')
          {
            alert('Please Select Branch/Location');
            $('#locationid').focus();
            return false;
          }
          if(locationid=='')
          {
            alert('Please Enter Issue No.');
            $('#invoiceno').focus();
            return false;
          }
          var fiscalyrs=$('#fiscalyrs').val();
           var submitdata = {invoiceno:invoiceno,locationid:locationid,fiscalyrs:fiscalyrs};
            var submiturl = base_url+'issue_consumption/new_issue/issue_list_by_issue_no';
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
