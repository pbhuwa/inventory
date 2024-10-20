<div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog">    
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit AMC </h4>
            </div>
            <div class="modal-body">
                <form method="post" id="pm_editform" action="<?php echo base_url('biomedical/amc_data/edit_amc_data'); ?>" data-reloadurl='<?php echo base_url('biomedical/pm_data'); ?>'>
                    <div class="form-group">
                        <label>AMC Date: </label>
                        <input type="text" name="amta_amcdatebs" id="modal_amcdatebs" class="form-control date <?php echo DATEPICKER_CLASS; ?>"/>
                    </div>

                    <div class="form-group">
                        <label>Remarks: </label>
                        <input type="text" name="amta_remarks" id="modal_remarks" class="form-control"/>
                    </div>

                    <div>
                        <input type="hidden" name="modal_editid" id="modal_editid"/>
                        <button type="submit" class="btn btn-info savelist mtop_10" data-isdismiss="Y">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>