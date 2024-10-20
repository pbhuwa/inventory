<div class="row">
  <div class="col-sm-12">
  <div id="TableDiv">
  <div class="white-box">
      <h3 class="box-title">Problem /Issue List</h3>
      <div class="pad-5">
          <div class="table-responsive scroll">
               <table id="repairTableInfo" class="table table-striped dataTable">
                  <thead>
                      <tr>
                          <th width="2%">S.n</th>
                          <th width="6%">Date(AD)</th>
                          <th width="6%">Date(BS)</th>
                          <th width="6%">Time</th>
                          <th width="6%">Equipment ID</th>
                          <th width="6%">Department</th>
                          <th width="6%">Room</th>
                          <th width="8%">Problem Type</th>
                          <th width="20%">Problem</th>
                          <th width="30%">Action Taken</th>
                          <th width="5%">Action</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php
                    // echo "<pre>";
                    // print_r($equipment_detail);
                    // die();

                    if($equipment_detail):
                      $i=1;
                      foreach ($equipment_detail as $eqk => $eqdt):
                        $prblmtype=$eqdt->rere_problemtype;
                        if($prblmtype=='Ex')
                        {
                          $problemtype='External';
                        }
                        else
                        {
                          $problemtype='Internal';
                        }
                      ?>
                      <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $eqdt->rere_postdatead; ?></td>
                        <td><?php echo $eqdt->rere_postdatebs ?></td>
                        <td><?php echo $eqdt->rere_posttime; ?></td>
                        <td><?php echo $eqdt->bmin_equipmentkey; ?></td>
                        <td><?php echo $eqdt->dein_department; ?></td>
                        <td><?php echo $eqdt->rode_roomname; ?></td>
                        <td><?php echo $problemtype; ?></td>
                        <td><?php echo $eqdt->rere_problem; ?></td>
                        <td><?php echo $eqdt->rere_action; ?></td>
                        <td><a href="javascript:void(0)" data-id='<?php echo $eqdt->rere_repairrequestid; ?>' data-displaydiv="Assistance" data-viewurl="<?php echo base_url('biomedical/repair_request_info/get_assistance_detail_indiv')?>" class="view" data-heading="View Problem/Issue " ><i class="fa fa-eye" aria-hidden="true" ></i></a></td>                        
                      </tr>

                      <?php
                      $i++;
                    endforeach;
                    endif;
                     ?>
                            
                  </tbody>
              </table>
          </div>
      </div>
  </div>
</div>
</div>
</div>