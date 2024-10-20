
<form method="post" id="UnrepairInformation" action="<?php echo base_url('biomedical/unrepair_information/save_unrepair_information'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('biomedical/unrepair_information/form_unrepair_information'); ?>'>
  <input type="hidden" name="ureq_equipid" value="<?php echo !empty($equipid)?$equipid:''; ?>">
   
    <div class="clearfix"></div>
   <?php 
   // print_r($reason_for_dis);
   // echo $reason_for_dis[0]->ureq_resoan_disommission;
      $is_equip_dis=!empty($eqli_is_dis)?$eqli_is_dis:'N';
   ?>
    <div class="form-group">
        <div class="col-md-12">
            <label>Reson For Decommission :<span class="required">*</span></label>
            <textarea style="width: 100%" name="ureq_resoan_disommission" placeholder="Reason For Decommission" <?php if($is_equip_dis=='Y') echo 'disabled'; ?>><?php echo !empty($reason_for_dis[0]->ureq_resoan_disommission)?$reason_for_dis[0]->ureq_resoan_disommission:''; ?></textarea>
        </div>
    </div>
    <div class="clearfix"></div>
    <?php
 
    if($eqli_is_dis=='N'):
     ?>
  <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($repair_data)?'update':'save' ?>' id="btnDeptment" ><?php echo !empty($repair_data)?'Update':'Save' ?></button>
    <?php endif; ?>     
    <div  class="alert-success success"></div>
   <div class="alert-danger error"></div>
</form>

<div class="clearfix"></div>
<div class="form-group"> 
      <h3 class="box-title">Assign History</h3>
      <div class="table-responsive">
      <table class="table table-border table-striped table-site-detail dataTable">
          <thead>
              <tr>
                  <th width="10%">Ass.Date (AD)</th>
                  <th width="10%">Ass.Date (BS)</th>
                  <th width="10%">Ent.Date(AD)</th>
                  <th width="10%">Ent.Date(BS)</th>
                  <th width="20%">Assign To</th>
                  <th width="20%">Assign By</th>
                
              </tr>
          </thead>
          <tbody>
              <?php 
              if($equip_assign):
                  foreach ($equip_assign as $eak => $assign):
                  ?>
                  <tr>
                      <td><?php echo $assign->eqas_assigndatead; ?></td>
                      <td><?php echo $assign->eqas_assigndatebs; ?></td>
                      <td><?php echo $assign->eqas_postdatead; ?></td>
                      <td><?php echo $assign->eqas_postdatebs; ?></td>
                      <td><?php echo $assign->stin_fname.' '.$assign->stin_lname; ?></td>
                      <td><?php echo $assign->usma_username; ?></td>
                      

                  </tr>
                  <?php
                  endforeach;
              endif;
              ?>
          </tbody>
      </table>
      </div>

      <h3 class="box-title">Handover History</h3>
      <div class="table-responsive">
      <table class="table table-border table-striped table-site-detail dataTable">
           
          <thead>
              <tr>
                  <th width="10%">Date (AD)</th>
                  <th width="10%">Date (BS)</th>
                  <th width="20%">Handover From</th>
                  <th width="20%">Handover To</th>
              </tr>
          </thead>
          <tbody>
              <?php 
              if($equip_handover):
                  foreach ($equip_handover as $kh => $handover):
                  ?>
              <tr>
                  <td><?php echo $handover->eqas_handoverdatead; ?></td>
                  <td><?php echo $handover->eqas_handoverdatebs; ?></td>
                  <td><?php echo $handover->stin_fname.' '.$handover->stin_lname; ?></td>
                  <td><?php echo $handover->hstin_fname.' '.$handover->hstin_lname; ?></td>

              </tr>
             <?php 
         endforeach; endif;
               ?>
              
              
          </tbody>
      </table>
      </div>
</div>
<div class="form-group">
    <div class="white-box">
        <h3 class="box-title">Comment History</h3>
        <div class="table-responsive">
        <table id="" class="table flatTable tcTable compact_Table" >
            <thead>
              <tr>
                  <th width="5%">S.n.</th>
                  <th width="10%">Date(AD)</th>
                  <th width="10%">Date(BS)</th>
                  <th width="40%">Comments</th>
                  <th width="25%">Com. By</th>
                  <th width="10%">Status</th>
                  <th width="5%">Action</th>
                 
              </tr>
            </thead>
            <tbody>
               <?php
                    if($equip_comment):
                        $i=1;
                        foreach ($equip_comment as $kc => $com):
                            if($com->eqco_comment_status == 1)
                            {
                                $penf = "Active"; 
                                $class='label-success';
                            }
                            else{ 
                                $penf = "Pending"; 
                                $class='label-danger';
                            }
                ?>
                      <tr id="listid_<?php echo $com->eqco_equipmentcommentid; ?>">
                      <td><?php echo $i; ?></td>
                      <td><?php echo $com->eqco_postdatead; ?></td>
                      <td><?php echo $com->eqco_postdatebs; ?></td>
                      <td><?php echo $com->eqco_comment; ?></td>
                       <td><?php echo $com->usma_fullname; ?></td>
                       <td><a href="javascript:void(0)" class=" label <?php echo $class; ?> btn-xs"><?php echo $penf  ?> </a></td>
                      <td>
                    <!--   <a href="javascript:void(0)"  title="Edit" data-id='<?php echo $com->eqco_equipmentcommentid; ?>' data-viewurl='<?php echo base_url('biomedical/bio_medical_inventory/edit_biomedical_comments') ?>'  class="btnEdit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> -->
                      <a href="javascript:void(0)" title="Cancel" data-id='<?php echo $com->eqco_equipmentcommentid; ?>' class="btnDelete" data-deleteurl="<?php echo base_url('biomedical/pm_data/deletepm_data');?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                      </td>
                      </tr>
                  <?php
                  $i++;
                  endforeach;
              else:
                ?>
                <tr>
                  <td colspan="7"><p class="text-danger text-center">Record Empty!!</p></td>
                </tr>
                <?php
                endif;
               ?>
            </tbody>
        </table>
        </div>
    </div>

    <div class="white-box">
        <h3 class="box-title">Repair Request History</h3>
        <div class="table-responsive">
        <table id="" class="table flatTable tcTable compact_Table" >
            <thead>
              <tr>
                <th width="5%">Id</th>
                <th width="10%">Date(AD)</th>
                <th width="10%">Date(BS)</th>
                <th width="10%">Dep</th>
                <th width="10%">Eq. Key</th>
                <th width="20%">Problem</th>
                <th width="20%">Action Taken</th>
                <th width="15%">Status</th>
                <th width="15%">Action</th>
              </tr>
            </thead>
            <tbody>
               <?php
                    if($repair_comment):
                        $i=1;
                        foreach ($repair_comment as $kc => $com):
                            if($com->rere_status == 1)
                            {
                                $penf = "Completed"; 
                                $class='label-success';
                            }
                            else{ 
                                $penf = "Not Completed"; 
                                $class='label-danger';
                            }
                ?>
                      <tr id="listid_<?php echo $com->rere_repairrequestid; ?>">
                      <td><?php echo $i; ?></td>
                      <td><?php echo $com->rere_postdatead; ?></td>
                      <td><?php echo $com->rere_postdatebs; ?></td>
                      <td><?php echo $com->dein_department; ?></td>
                      <td><?php echo $com->bmin_equipmentkey; ?></td>
                      <td><?php echo $com->rere_problem; ?></td>
                       <td><?php echo $com->rere_action; ?></td>
                       <td><a href="javascript:void(0)" class=" label <?php echo $class; ?> btn-xs"><?php echo $penf  ?> </a></td>
                      <td>
                   
                      <a href="javascript:void(0)" title="Cancel" data-id='<?php echo $com->rere_repairrequestid; ?>' class="btnDelete" data-deleteurl="<?php echo base_url('biomedical/repair_request_info/delete_repairrequest');?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                      </td>
                      </tr>
                  <?php
                  $i++;
                  endforeach;
              else:
                ?>
                <tr>
                  <td colspan="9"><p class="text-danger text-center">Record Empty!!</p></td>
                </tr>
                <?php
                endif;
               ?>
            </tbody>
        </table>
        </div>
    </div>
</div>

