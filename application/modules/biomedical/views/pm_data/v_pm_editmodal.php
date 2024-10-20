<div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog">    
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Preventive Maintenance </h4>
            </div>
            <div class="modal-body">
                <form method="post" id="pm_editform" action="<?php echo base_url('biomedical/pm_data/edit_pm_data'); ?>" data-reloadurl='<?php echo base_url('biomedical/pm_data'); ?>'>
                    <div class="form-group">
                        <label>Preventive Maintenance Date: </label>
                        <input type="text" name="pmta_pmdatebs" id="modal_pmdatebs" class="form-control date <?php echo DATEPICKER_CLASS; ?>"/>
                    </div>

                    <div class="form-group">
                        <label>Remarks: </label>
                        <input type="text" name="pmta_remarks" id="modal_remarks" class="form-control"/>
                    </div>

                    <div>
                        <input type="hidden" name="modal_editid" id="modal_editid"/>
                        <button type="submit" class="btn btn-info savelist mtop_10" data-isdismiss="Y">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>