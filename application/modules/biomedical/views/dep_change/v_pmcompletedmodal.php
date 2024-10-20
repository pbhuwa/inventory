<div id="pmCompletedModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Biomedical Equipment Repair Request</h4>
                </div>
                <div class="modal-body">
                <form method="post" id="formIsPmCompleted" action="<?php echo base_url('biomedical/pm_completed/save_pm_completed'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php //echo base_url('biomedical/pm_completed/form_pm_completed'); ?>'>
                  <input type="hidden" id="pmtatable" name="pmtaid" value="">
                  <input type="hidden" id="equiPid" name="equipid" value="">
                  <div class="clearfix"></div>
                  <div class="pm_data_body">
                      <div id="FormDiv_PmCompleteForm" class="search_pm_data">
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="col-md-3">
                          <label for="example-text">Result :
                          </label>
                          <select name="pmco_amccontractor" class="form-control">
                              <option value="">---select---</option>
                              <option value="pass">Pass</option>
                              <option value="fail">Fail</option>
                              <option value="Comment">See Comment</option>
                          </select>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="col-md-3">
                       <label for="example-text">Amc:
                          </label>
                           <input type="text" name="pmco_amc" class="form-control" placeholder="Number " value="<?php echo !empty($pm_completed_data[0]->pmco_amc)?$pm_completed_data[0]->pmco_amc:''; ?>">
                      </div>
                      <div class="col-md-3">
                          <label for="example-text">Amccontractor:
                          </label>
                          <input type="text" name="pmco_amccontractor" class="form-control" placeholder="Amccontractor " value="<?php echo !empty($pm_completed_data[0]->pmco_amccontractor)?$pm_completed_data[0]->pmco_amccontractor:''; ?>">
                      </div>  

                      <div class="col-md-6">
                          <label>Comments</label>
                          <textarea style="width: 100%" name="pmco_comments"><?php echo !empty($equip_data[0]->pmco_comments)?$equip_data[0]->pmco_comments:''; ?></textarea>
                      </div>
                  </div>    
                  <div class="clearfix"></div>
                  <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 savelist" data-isdismiss="Y" data-operation='<?php echo !empty($pm_completed_data)?'update':'save' ?>'><?php echo !empty($pm_completed_data)?'Update':'Save' ?></button>
                  <div  class="waves-effect waves-light m-r-10 text-success success"></div>
                 <div class="waves-effect waves-light m-r-10 text-danger error"></div>
              </form>
            </div>

        </div>
    </div>
  