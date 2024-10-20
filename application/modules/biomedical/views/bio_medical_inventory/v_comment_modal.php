<div id="repairCommentModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Repair Comments</h4>
            </div>
            <div class="modal-body">
                <form method="post" id="FormComments" action="<?php echo base_url('biomedical/Bio_medical_inventory/save_comment'); ?>"  class="form-material form-horizontal form">
                    <div class="form-group mbtm_0">
                        <div class="col-md-12">
                            <label>Describe Problem: </label>
                            <textarea style="width: 100%;height: 50px;" name="eqco_comment" class="form-control" autofocus="true"></textarea>
                            <input type="hidden" value="<?php echo !empty($eqli_data[0]->bmin_equipid)?$eqli_data[0]->bmin_equipid:''; ?>" name="eqco_eqid" id="eqco_eqid"/>
                        </div>
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-info save mtop_10" >Save</button>
                            <div  class="alert-success success"></div>
                            <div class="alert-danger error"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>