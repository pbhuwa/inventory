<?php $pmcat=$this->input->post('pmcat'); ?>
 <ul class="nav nav-pills">
    <li <?php if($pmcat=='schedule') echo "class='active'"; ?>><a data-toggle="pill" href="#schedulepm_dtlist">Schedule PM</a></li>
    <li <?php if($pmcat=='done') echo "class='active'"; ?>><a data-toggle="pill" href="#donepm_dtlist">Done PM</a></li>
    <li <?php if($pmcat=='not_done') echo "class='active'"; ?>><a data-toggle="pill" href="#notdonepm_dtlist">Not Done</a></li>
    

  </ul>
  
  <div class="tab-content">
    <div id="schedulepm_dtlist" class="tab-pane fade in <?php if($pmcat=='schedule') echo 'active'; ?>">
      <div class="table-responsive">
     <table class="table table-striped dataTable">
              <thead>
                  <tr>
                       <th width="3%">S.N.</th>
                        <th width="8%">Equip. ID</th>
                         <th width="12%">Description</th>
                        <th width="10%">Department</th>
                        <th width="10%">Room</th>
                        <th width="15%">Risk</th>
                        <th width="10%">Manufacture</th>
                        <th width="10%">Distributor</th>
                        <th width="10%">PM Date(AD)</th>
                        <th width="10%">PM Date(BS)</th>
                        <th width="15%">Remarks</th>
                        <th width="15%">Status</th>
                         <th width="15%">PM Complete</th>
                    
                  </tr>
              </thead>
              <tbody>
                <?php
                if($pm_data_detail):
                  $i=1;
                foreach($pm_data_detail as $row)
                {
                 $ispmcomplete = $row->pmta_ispmcompleted;
                 if($ispmcomplete==1)
                 {
                  $pmcomplete='<label class="label label-success">Yes</label>';
                 }
                 else
                 {
                  $pmcomplete='<label class="label label-danger">No</label>';
                 }

              $date1=strtotime($row->pmta_pmdatead);
              $date2=strtotime(CURDATE_EN);
              $days=$this->general->get_left_days($date1,$date2);
              if($days!=='Expiry')
              {
                $status='<span class="text-success">'.$days.' Days Left</span>';;
                if($days<7)
                {
                  $status='<span class="text-danger">'.$days.' Days Left</span>';;
                }
              }
              else
              {
                $status='<span class="text-danger">Expiry</span>';
              }
              ?>
              <tr>
             <td><?php echo $i ?></td>
             <td><?php echo $row->bmin_equipmentkey;?></td>
              <td><?php echo $row->eqli_description;?></td>
              <td><?php echo $row->dein_department;?></td>
              <td><?php echo $row->rode_roomname;?></td>
              <td><?php echo $row->riva_risk;?></td>
              <td><?php echo $row->manu_manlst;?></td>
              <td><?php echo $row->dist_distributor;?></td>
              <td><?php echo $row->pmta_pmdatead;?></td>
              <td><?php echo $row->pmta_pmdatebs;?></td>
              <td><?php echo $row->pmta_remarks;?></td>
              <td><?php echo $status;?></td>
              <td><?php echo $pmcomplete;?></td>
            </tr>
           <?php 
           $i++;
        }
      endif;
                 ?>
                        
              </tbody>
          </table>
      </div>
    </div>
    <div id="donepm_dtlist" class="tab-pane fade <?php if($pmcat=='done') echo 'active in'; ?>">
     <div class="table-responsive">
     <table class="table table-striped dataTable">
              <thead>
                  <tr>
                       <th width="3%">S.N.</th>
                        <th width="8%">Equip. ID</th>
                         <th width="12%">Description</th>
                        <th width="10%">Department</th>
                        <th width="10%">Room</th>
                        <th width="15%">Risk</th>
                        <th width="10%">Manufacture</th>
                        <th width="10%">Distributor</th>
                        <th width="10%">PM Date(AD)</th>
                        <th width="10%">PM Date(BS)</th>
                        <th width="15%">Remarks</th>
                        <th width="15%">Status</th>
                         <th width="15%">PM Complete</th>
                    
                  </tr>
              </thead>
              <tbody>
                <?php
                if($pm_data_done_detail):
                  $i=1;
                foreach($pm_data_done_detail as $drow)
                {
                 $ispmcomplete = $drow->pmta_ispmcompleted;
                 if($ispmcomplete==1)
                 {
                  $pmcomplete='<label class="label label-success">Yes</label>';
                 }
                 else
                 {
                  $pmcomplete='<label class="label label-danger">No</label>';
                 }

              $date1=strtotime($drow->pmta_pmdatead);
              $date2=strtotime(CURDATE_EN);
              $days=$this->general->get_left_days($date1,$date2);
              if($days!=='Expiry')
              {
                $status='<span class="text-success">'.$days.' Days Left</span>';;
                if($days<7)
                {
                  $status='<span class="text-danger">'.$days.' Days Left</span>';;
                }
              }
              else
              {
                $status='<span class="text-danger">Expiry</span>';
              }
              ?>
              <tr>
             <td><?php echo $i ?></td>
             <td><?php echo $drow->bmin_equipmentkey;?></td>
              <td><?php echo $drow->eqli_description;?></td>
              <td><?php echo $drow->dein_department;?></td>
              <td><?php echo $drow->rode_roomname;?></td>
              <td><?php echo $drow->riva_risk;?></td>
              <td><?php echo $drow->manu_manlst;?></td>
              <td><?php echo $drow->dist_distributor;?></td>
              <td><?php echo $drow->pmta_pmdatead;?></td>
              <td><?php echo $drow->pmta_pmdatebs;?></td>
              <td><?php echo $drow->pmta_remarks;?></td>
              <td><?php echo $status;?></td>
              <td><?php echo $pmcomplete;?></td>
            </tr>
           <?php 
           $i++;
        }
      endif;
                 ?>
                        
              </tbody>
          </table>
      </div>    
          
    </div>
    <div id="notdonepm_dtlist" class="tab-pane fade <?php if($pmcat=='not_done') echo 'active in'; ?>">
      <table class="table table-striped dataTable">
              <thead>
                  <tr>
                       <th width="3%">S.N.</th>
                        <th width="8%">Equip. ID</th>
                         <th width="12%">Description</th>
                        <th width="10%">Department</th>
                        <th width="10%">Room</th>
                        <th width="15%">Risk</th>
                        <th width="10%">Manufacture</th>
                        <th width="10%">Distributor</th>
                        <th width="10%">PM Date(AD)</th>
                        <th width="10%">PM Date(BS)</th>
                        <th width="15%">Remarks</th>
                        <th width="15%">Status</th>
                         <th width="15%">PM Complete</th>
                    
                  </tr>
              </thead>
              <tbody>
                <?php
                if($pm_data_not_done_detail):
                  $i=1;
                foreach($pm_data_not_done_detail as $ndrow)
                {
                 $ispmcomplete = $ndrow->pmta_ispmcompleted;
                 if($ispmcomplete==1)
                 {
                  $pmcomplete='<label class="label label-success">Yes</label>';
                 }
                 else
                 {
                  $pmcomplete='<label class="label label-danger">No</label>';
                 }

              $date1=strtotime($ndrow->pmta_pmdatead);
              $date2=strtotime(CURDATE_EN);
              $days=$this->general->get_left_days($date1,$date2);
              if($days!=='Expiry')
              {
                $status='<span class="text-success">'.$days.' Days Left</span>';;
                if($days<7)
                {
                  $status='<span class="text-danger">'.$days.' Days Left</span>';;
                }
              }
              else
              {
                $status='<span class="text-danger">Expiry</span>';
              }
              ?>
              <tr>
             <td><?php echo $i ?></td>
             <td><?php echo $ndrow->bmin_equipmentkey;?></td>
              <td><?php echo $ndrow->eqli_description;?></td>
              <td><?php echo $ndrow->dein_department;?></td>
              <td><?php echo $ndrow->rode_roomname;?></td>
              <td><?php echo $ndrow->riva_risk;?></td>
              <td><?php echo $ndrow->manu_manlst;?></td>
              <td><?php echo $ndrow->dist_distributor;?></td>
              <td><?php echo $ndrow->pmta_pmdatead;?></td>
              <td><?php echo $ndrow->pmta_pmdatebs;?></td>
              <td><?php echo $ndrow->pmta_remarks;?></td>
              <td><?php echo $status;?></td>
              <td><?php echo $pmcomplete;?></td>
            </tr>
           <?php 
           $i++;
        }
      endif;
                 ?>
                        
              </tbody>
          </table>

    </div>
   
  </div>

