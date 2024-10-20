<ul class="pm_data pm_data_body">
     <li>
        <label><?php echo $this->lang->line('equipment_code');?></label>
        <?php echo !empty($eqli_data[0]->bmin_equipmentkey)?$eqli_data[0]->bmin_equipmentkey:'';?>
    </li>

    <li>
        <input type="hidden" name="pmta_equipid" value="<?php echo !empty($eqli_data[0]->bmin_equipid)?$eqli_data[0]->bmin_equipid:'';?>">
        <label><?php echo $this->lang->line('description');?> </label>
        <?php echo !empty($eqli_data[0]->eqli_description)?$eqli_data[0]->eqli_description:'';?>
    </li>
    <li>
        <label><?php echo $this->lang->line('model_no');?></label>
        <?php echo !empty($eqli_data[0]->bmin_modelno)?$eqli_data[0]->bmin_modelno:'';?>
    </li>
    <li>
        <label><?php echo $this->lang->line('serial_no');?></label>
        <?php echo !empty($eqli_data[0]->bmin_serialno)?$eqli_data[0]->bmin_serialno:'';?>
    </li>
    
     <li>
        <label><?php echo $this->lang->line('department');?></label>
        <?php echo !empty($eqli_data[0]->dein_department)?$eqli_data[0]->dein_department:'';?>
    </li>

     <li>
        <label><?php echo $this->lang->line('room');?></label>
        <?php echo !empty($eqli_data[0]->rode_roomname)?$eqli_data[0]->rode_roomname:'';?>
    </li>

     <li>
        <label><?php echo $this->lang->line('equipment');?> <?php echo $this->lang->line('operation');?></label>
        <?php echo !empty($eqli_data[0]->bmin_equip_oper)?$eqli_data[0]->bmin_equip_oper:'';?>
    </li>

     <li>
        <label><?php echo $this->lang->line('manufacture');?></label>
        <?php echo !empty($eqli_data[0]->manu_manlst)?$eqli_data[0]->manu_manlst:'';?>
    </li>

     <li>
        <label><?php echo $this->lang->line('distributor');?></label>
        <?php echo !empty($eqli_data[0]->dist_distributor)?$eqli_data[0]->dist_distributor:'';?>
    </li>
     <li>
        <label><?php echo $this->lang->line('amc');?></label>
        <?php echo !empty($eqli_data[0]->bmin_amc)?$eqli_data[0]->bmin_amc:'';?>
    </li>
     <li>
        <label><?php echo $this->lang->line('service');?><?php echo $this->lang->line('start_date');?></label>
        
<?php echo !empty($eqli_data[0]->bmin_servicedatead)?$eqli_data[0]->bmin_servicedatead:''; ?>(AD)/
   <?php echo !empty($eqli_data[0]->bmin_servicedatebs)?$eqli_data[0]->bmin_servicedatebs:''; ?>(BS)    

        
    </li>
    <li>
        <label><?php echo $this->lang->line('warrenty');?> <?php echo $this->lang->line('end_date');?></label>
        <?php echo !empty($eqli_data[0]->bmin_endwarrantydatead)?$eqli_data[0]->bmin_endwarrantydatead:'';?>(AD)/
         <?php echo !empty($eqli_data[0]->bmin_endwarrantydatebs)?$eqli_data[0]->bmin_endwarrantydatebs:''; ?>(BS)    
    </li>
   <li>
        <label><?php echo $this->lang->line('risk');?></label>
        <?php echo !empty($eqli_data[0]->riva_risk)?$eqli_data[0]->riva_risk:'';?>
    </li>
   
    <li>
        <label><?php echo $this->lang->line('accessories');?></label>
        <?php echo !empty($eqli_data[0]->bmin_accessories)?$eqli_data[0]->bmin_accessories:'';?>
    </li>
    <li>
        <label><?php echo $this->lang->line('comments');?></label>
        <?php echo !empty($eqli_data[0]->bmin_comments)?$eqli_data[0]->bmin_comments:'';?>
    </li>
   
    
</ul>
<form method="post" id="Formpmdata" action="<?php echo base_url('biomedical/pm_data/save_pm_data'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('biomedical/pm_data/form_pm_data'); ?>'>
    <input type="hidden" name="id" value="<?php echo !empty($pmdata[0]->riva_riskid)?$pmdata[0]->riva_riskid:'';  ?>">
    <input type="hidden" name="pmtableid" value="<?php echo !empty($pmdata[0]->pmta_pmtableid)?$pmdata[0]->pmta_pmtableid:''; ?>">
    <div class="clearfix"></div>
    <div class="clearfix"></div>
    <div class="pm_data_body">
        <div id="FormDiv_PmData" class="search_pm_data">
        </div>
    </div>
    <div class="clearfix"></div>
    <div  class="waves-effect waves-light m-r-10 text-success success"></div>
    <div class="waves-effect waves-light m-r-10 text-danger error"></div>
</form>
<div class="form-group"> 
      <h3 class="box-title"><?php echo $this->lang->line('assign_history'); ?></h3>
      <div class="table-responsive">
    <table class="table table-border table-striped table-site-detail dataTable">
        <thead>
            <tr>
                <th width="10%"><?php echo $this->lang->line('assign_date_AD'); ?></th>
                <th width="10%"><?php echo $this->lang->line('assign_date_BS'); ?></th>
                <th width="10%"><?php echo $this->lang->line('entry_date'); ?>(AD)</th>
                <th width="10%"><?php echo $this->lang->line('entry_date'); ?>(BS)</th>
                <th width="20%"><?php echo $this->lang->line('assign_to'); ?></th>
                <th width="20%"><?php echo $this->lang->line('assign_by'); ?></th>
                <th width="20%"><?php echo $this->lang->line('action'); ?></th>
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
                    <td>

                        <?php if($assign->eqas_ishandover=='N'): ?>
                        <a href="javascript:void(0)" class="btn btn-sm btn-success btnHandover" data-eqas_equipmentassignid="<?php echo $assign->eqas_equipmentassignid; ?>" data-equipid="<?php echo $assign->eqas_equipid; ?>" data-equipdepid="<?php echo $assign->eqas_equipdepid; ?>" data-equiproomid="<?php echo $assign->eqas_equiproomid; ?>" data-staffcode="<?php echo $assign->stin_code; ?>" data-staffname="<?php echo $assign->stin_fname.' '.$assign->stin_lname; ?>">Handover</a>
                    <?php endif; ?>
                    </td>

                </tr>
                <?php
                endforeach;
            endif;
            ?>
        </tbody>
    </table>
    </div>
     <h3 class="box-title"><?php echo $this->lang->line('handover'); ?> <?php echo $this->lang->line('history'); ?></h3>
     <div class="table-responsive">
    <table class="table table-border table-striped table-site-detail dataTable">
        
        <thead>
            <tr>
                <th width="10%"><?php echo $this->lang->line('date'); ?>(AD)</th>
                <th width="10%"><?php echo $this->lang->line('date'); ?>(BS)</th>
                <th width="20%"><?php echo $this->lang->line('handover'); ?> <?php echo $this->lang->line('from'); ?></th>
                <th width="20%"><?php echo $this->lang->line('handover'); ?> <?php echo $this->lang->line('to'); ?></th>
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
        <h3 class="box-title"><?php echo $this->lang->line('comment_history'); ?></h3>
        <div class="table-responsive">
        <table id="" class="table table-border table-striped flatTable tcTable compact_Table" >
            <thead>
              <tr>
                  <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                  <th width="10%"><?php echo $this->lang->line('date'); ?>(AD)</th>
                  <th width="10%"><?php echo $this->lang->line('date'); ?>(BS)</th>
                  <th width="40%"><?php echo $this->lang->line('comments'); ?></th>
                  <th width="25%"><?php echo $this->lang->line('comment_by'); ?></th>
                  <th width="10%"><?php echo $this->lang->line('status'); ?></th>
                  <th width="5%"><?php echo $this->lang->line('action'); ?></th>
                 
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
        <h3 class="box-title"><?php echo $this->lang->line('repair_request_history'); ?></h3>
        <div class="table-responsive">
          <table id="" class="table flatTable tcTable compact_Table" >
              <thead>
                <tr>
                  <th width="5%"><?php echo $this->lang->line('id'); ?></th>
                  <th width="10%"><?php echo $this->lang->line('date'); ?>(AD)</th>
                  <th width="10%"><?php echo $this->lang->line('date'); ?>(BS)</th>
                  <th width="10%"><?php echo $this->lang->line('department'); ?></th>
                  <th width="10%"><?php echo $this->lang->line('equipment_code'); ?></th>
                  <th width="20%"><?php echo $this->lang->line('problem'); ?></th>
                  <th width="20%"><?php echo $this->lang->line('action_taken'); ?></th>
                  <th width="15%"><?php echo $this->lang->line('status'); ?></th>
                  <th width="15%"><?php echo $this->lang->line('action'); ?></th>
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


 <div class="modal fade" id="equipHandover" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content xyz-modal-123">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Handover Equipment</h4>
            </div>
            
            <div class="modal-body pad-5 scroll vh80 displyblock">

            
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).off('click','.btnHandover');
    $(document).on('click','.btnHandover',function(){
      
      var id=$(this).data('equipid');
      var departmentid=$(this).data('equipdepid');
      var roomid=$(this).data('equiproomid');
      var assignid=$(this).data('eqas_equipmentassignid');
      var staffcode=$(this).data('staffcode');
      var staffname=$(this).data('staffname');
      var action=base_url+'biomedical/assign_equipement/get_equipment_handover_detail';
      // alert(url);

     $('#equipHandover').modal('show');

        $.ajax({
          type: "POST",
          url: action,
          data:{id:id,departmentid:departmentid,roomid:roomid,assignid:assignid,staffcode:staffcode,staffname:staffname},
          dataType: 'html',
          beforeSend: function() {
            $('.overlay').modal('show');
          },
        success: function(jsons) 
          {

         data = jQuery.parseJSON(jsons);   
        // alert(data.status);
        if(data.status=='success')
        {
        
          $('.displyblock').html(data.tempform);
        }  
       
       else{
        alert(data.message);
       }
       $('.overlay').modal('hide');
     }
       });

  });


</script>