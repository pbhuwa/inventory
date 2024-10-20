<div class="ov_report_tabs pad-5 page-tabs margin-top-250 tabbable">
    <div id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
        <div class="searchWrapper">
            <form method="post" id="FormIssueCancel" action="<?php echo base_url('purchase_receive/receive_against_order/save_new_issue'); ?>" data-reloadurl="<?php echo base_url('purchase_receive/receive_against_order/form_new_issue'); ?>" class="form-material form-horizontal form">

                <input type="hidden" name="id" value="">

                <div id="issueDetails">

                    <div class="form-group">
                        <div class="col-md-2 col-sm-3">

                            <label for="example-text"><?php echo $this->lang->line('invoice_no'); ?> :</label>
                            <input type="text" class="form-control required_field enterinput" name="transfer_no" id="transfer_no" value="<?php echo !empty($this->input->post('id')) ? $this->input->post('id') : ''; ?>" placeholder="Transfer Number" data-targetbtn='btnTransferEdit'>
                        </div>
                        <div class="col-md-2 col-sm-3">
                            <label>&nbsp;</label>
                            <div>
                                <a href="javascript:void(0)" class="btn btn-sm btn-success" id="btnTransferEdit"><?php echo $this->lang->line('search'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="clearfix"></div>
        <style type="text/css">
            .jo_tbl_head {
                margin-top: 26px;
            }
        </style>
        <div id="displayReportDiv"></div>
    </div>
</div>

<script type="text/javascript">
    $(document).off('click', '#btnTransferEdit');
    $(document).on('click', '#btnTransferEdit', function() {
        var transfer_no = $('#transfer_no').val();
        var locationid = $('#locationid').val();
        var mattypeid = $('#mattypeid').val();
        var submitdata = {
            transfer_no: transfer_no,
            locationid: locationid,
            mattypeid: mattypeid
        };
        var submiturl = base_url + 'ams/assets_transfer/get_transfer_assets_form_edit';
        beforeSend = $('.overlay').modal('show');
        ajaxPostSubmit(submiturl, submitdata, beforeSend = '', onSuccess);

        function onSuccess(jsons) {
            data = jQuery.parseJSON(jsons);
            $('#ndp-nepali-box').hide();
            if (data.status == 'success') {

                $('#displayReportDiv').html(data.tempform);
            } else {
                alert(data.message);
                $('#displayReportDiv').html('');
            }
            $('.overlay').modal('hide');
        }
    });
</script>
