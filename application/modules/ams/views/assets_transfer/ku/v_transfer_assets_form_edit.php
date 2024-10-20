<form method="post" id="FormCancelTransferAssets" action="<?php echo base_url('ams/assets_transfer/cancel_asset_transfer'); ?>" class="form-material form-horizontal form" data-reloadurl="<?php echo base_url('ams/assets_transfer/correction'); ?>">

    <input type="hidden" name="id" value="<?php echo !empty($assets_transfer_master[0]->astm_assettransfermasterid)?$assets_transfer_master[0]->astm_assettransfermasterid:'';  ?>"> 
    <input type="hidden" name="astm_transferno" value="<?php echo !empty($assets_transfer_master[0]->astm_transferno)?$assets_transfer_master[0]->astm_transferno:'';  ?>">

      <?php echo $this->load->view('assets_transfer/' . REPORT_SUFFIX . '/v_asset_transfer_print', $this->data, true); ?>
       
        <div class="form-group">
            <div class="col-md-12">
              <button type="submit" class="btn btn-danger btnConfirm" data-url="<?php echo base_url('ams/assets_transfer/cancel_asset_transfer'); ?>"
                data-id="<?php echo !empty($assets_transfer_master[0]->astm_assettransfermasterid)?$assets_transfer_master[0]->astm_assettransfermasterid:'';  ?>"
                >Cancel</button>
            </div>

            <div class="col-sm-12">

                <div  class="alert-success success"></div>

                <div class="alert-danger error"></div>

            </div>

        </div>
</form>
<script type="text/javascript">
    $(document).off('click', '.btnConfirm');
    $(document).on('click', '.btnConfirm', function(e) {
        e.preventDefault();
        var submiturl = $(this).data('url');
        var id = $(this).data('id');
        var messg = $(this).data('msg');
        var redirect_url = base_url + 'ams/assets_transfer/correction';
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
    });
</script>


