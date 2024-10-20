<table class="table flatTable tcTable compact_Table">
  <thead>
    <tr>
      <th>PM Date(AD)</th>
      <th>PM Date(BS)</th>
      <th>Remarks</th>
      <th>Entry Date(AD)</th>
      <th>Entry Date(BS)</th>
      <th>IP Address</th>

    </tr>
  </thead>
  <tbody>
    <?php if($pm_data_rec):
      foreach ($pm_data_rec as $kpmr => $rec):
     ?>
    <tr>
      <td>
        <?php echo $rec->pmta_pmdatead;  ?>
      </td>
      <td>
        <?php echo $rec->pmta_pmdatebs;  ?>
      </td>
      <td>
        <?php echo $rec->pmta_remarks;  ?>
      </td>
      <td>
        <?php echo $rec->pmta_postdatead;  ?>
      </td>
       <td>
        <?php echo $rec->pmta_postdatebs;  ?>
      </td>
       <td>
        <?php echo $rec->pmta_postip;  ?>
      </td>

    </tr>
  <?php endforeach; endif; ?>
  </tbody>
</table>
<div class="white-box pad-5">
<form method="post" id="formIsPmCompleted" action="<?php echo base_url('biomedical/pm_completed/save_pm_completed'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php //echo base_url('biomedical/pm_completed/form_pm_completed'); ?>'>
                  <input type="hidden" id="pmtatable" name="pmtaid" value="<?php echo $pmtaid; ?>">
                  <input type="hidden" id="equiPid" name="equipid" value="<?php echo $equipid; ?>">
                  <div class="clearfix"></div>
                 
                  <div class="form-group">
                      <div class="col-md-3">
                          <label for="example-text">Result :
                          </label>
                          <select name="pmco_results" class="form-control" id="pmco_rslt">
                              <option value="">---select---</option>
                              <option value="pass">Pass</option>
                              <option value="fail">Fail</option>
                              <option value="comment">See Comment</option>
                          </select>
                      </div>

                      <div class="col-md-2">
                       <label for="example-text">AMC:
                          </label>
                          <?php $pmco_amc= !empty($pmco_amc)?$pmco_amc:'N'; ?>
                          <select name="pmta_amc" class="form-control" id="amc" >
                            <option value="Y">Yes</option>
                            <option value="N" <?php if($pmco_amc=='N') echo "selected=selected"; ?>>No</option>
                          </select>
  
                          
                      </div>
                      <div class="col-md-4" id="amc_contractor" style="display: none">
                          <label for="example-text">AMC Contractor:
                          </label>
                          <?php $pmco_amccontractor= !empty($amccontractor)?$amccontractor:''; 
                            $distributor_list=$this->bio_medical_mdl->get_distributor_list();
                          ?>

                           <select name="pmta_amccontractorid" class="form-control"  >
                            <option value="">---select---</option>
                            <?php if($distributor_list):
                            foreach ($distributor_list as $kdl => $distrubutor):?>
                            <option value="<?php echo $distrubutor->dist_distributorid; ?>" <?php if($pmco_amccontractor==$distrubutor->dist_distributorid) echo 'selected=selected'; ?>><?php echo $distrubutor->dist_distributor; ?></option>

                            <?php endforeach; endif; ?>
                          </select>
                      </div>  
                      <div class="col-md-3">
                        <label>PM Complete Date</label>
                          <input type="text" name="pm_completeddate" class="form-control date <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>" id="pm_completeddate">
                        
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-12" style="display: none" id="pmco_comments">
                          <label>Comments</label>
                          <textarea class="form-control" style="width: 100% ;height: 65px" name="pmco_comments" id="commentarea"><?php echo !empty($equip_data[0]->pmco_comments)?$equip_data[0]->pmco_comments:''; ?></textarea>
                      </div>
                  </div>    
                  <div class="clearfix"></div>
                  <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 savelist" data-isdismiss="Y" data-operation='<?php echo !empty($pm_completed_data)?'update':'save' ?>'><?php echo !empty($pm_completed_data)?'Update':'Save' ?></button>
                  <div  id="ResponseSuccess_formIsPmCompleted" class="alert-success success"></div>
                 <div  id="ResponseError_formIsPmCompleted" class="alert-danger error"></div>
              </form>
              </div>

              <script type="text/javascript">
                $(document).on('change','#amc',function(){
                  var amcval=$(this).val();
                  if(amcval =='Y')
                  {
                    $('#amc_contractor').show();
                  }
                  else
                  {
                    $('#amc_contractor').hide();
                  }

                });
              </script>

              <?php
              if($pmco_amc=='Y'):
                ?>
                <script type="text/javascript">
                  $('#amc').change();
                </script>
                <?php 
              endif;
              ?>