<div class="row wb_form">
    <div class="col-sm-6">
        <div class="white-box">
            <h3 class="box-title"><?php echo $this->lang->line('renew_contract'); ?></h3>
            <div id="FormDiv_contractmgmt" class="formdiv frm_bdy">
                <?php $this->load->view('contractmgmt/v_contractrenewform') ;?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="white-box">
            <input type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >
            <div id="TableDiv">
                <?php $this->load->view('contractmgmt/v_contractrenew_list') ;?>
            </div>
        </div>
    </div>
</div>

<div id="myModal1" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Contract Detail</h4>
            </div>
            <div class="modal-body">
                <div class="white-box list">
                    <form method="post" id="FormContract" action="<?php echo base_url('biomedical/contractmanagement/save_renew_contract'); ?>" class="form-material form-horizontal form">
                        <div class="resultrComment">
                        </div>
                        <div class="form-group mbtm_0">
                            <div class="col-md-12">
                                <label>Contract ID: </label>
                                <span id="contractId"></span>
                            </div>
                            <div class="clear"></div>
                            <div class="col-md-6">
                                <label>Contract Type: </label>
                                <span id="conType"></span>
                            </div>
                            <div class="col-md-6">
                                <label>Name: </label>
                                <span id="contractName"></span>
                            </div>
                            <div class="clear"></div>
                            <div class="col-md-6">
                                <label>Title: </label>
                                <span id="conTitle"></span>
                            </div>
                            <div class="col-md-6">
                                <label>Value: </label>
                                <span id="conValue"></span>
                            </div>
                            <div class="col-md-6">
                                <label>Start Date: </label>
                                <span id="contractStartDate"></span>
                            </div>
                            <div class="col-md-6">
                                <label>End Date: </label>
                                <span id="contractEndDate"></span>
                            </div>
                            <div class="clear"></div>
                             <div class="col-md-6">
                                <label>Renew Type: </label>
                                <span id="contractRenew"></span>
                            </div>
                            <div class="clear"></div>
                            <div class="col-md-12">
                                <label>Description: </label>
                                <span id="contractDescription"></span>
                            </div>
                            <div class="clear"></div>
                            <div class="col-md-12">
                                <label>Download Attachments: </label>
                                <span id="conAttachments"></span>
                            </div>
                            <div class="clear"></div>
                            <div id="ResponseSuccess_FormComments" class="waves-effect waves-light m-r-10 text-success"></div>
                            <div id="ResponseError_FormComments" class="waves-effect waves-light m-r-10 text-danger"></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
</div>
</div>
<script type="text/javascript">
    $(document).off('click','.myModalCall');
    $(document).on('click','.myModalCall',function(){
      
      var contractid = $(this).data('id');
      $.ajax({
        type: "POST",
        url: base_url+'biomedical/contractmanagement/get_contractmgmt_data',
        data:{contractid:contractid},
        dataType: 'json',
        success: function(datas) {
          if(datas.status=='success') {
            console.log(datas);
            $('#contractId').html(datas.contractId);
            $('#conType').html(datas.contractType);            
            $('#contractName').html(datas.contractName);
            $('#conTitle').html(datas.contractTitle);
            $('#contractStartDate').html(datas.contractStartDate);
            $('#contractEndDate').html(datas.contractEndDate);
            $('#conValue').html(datas.contractValue);
            $('#contractRenew').html(datas.contractRenew);
            $('#contractDescription').html(datas.contractDescription);
            $('#conAttachments').html(datas.download);
          }
        }
      });
      $('#myModal1').modal({
        show: true
      });
    })
    
    
</script>