   <h3 class="box-title">Department Change Log <a href="javascript:void(0)" class="btnRefresh"><i class="fa fa-refresh pull-right"></i></a></h3>
   <div class="table-responsive">
        <table id="" class="table flatTable tcTable compact_Table" >
            <thead>
              <tr>
                <th width="5%">S.n.</th>
                <th width="8%">Date(AD)</th>
                <th width="8%">Date(BS)</th>
                <th width="8%">Time</th>
                <th width="15%">New Dept.</th>
                <th width="15%">New Room</th>
                <th width="15%">Old Dept.</th>
                <th width="15%">Old Room</th>
                <!-- <th width="10%">Action</th> -->
              </tr>
            </thead>
            <tbody>
              <?php 
              $i=1;
              if($equip_dep_change_list):
              foreach ($equip_dep_change_list as $kchq => $edc):
              ?>
              <tr>
                
                <td><?php echo $i; ?>.</td>
                <td><?php echo $edc->eqdc_datead; ?></td>
                <td><?php echo $edc->eqdc_datebs; ?></td>
                <td><?php echo $edc->eqdc_posttime; ?></td>
                <td><?php echo $edc->new_depname; ?></td>
                <td><?php echo $edc->new_room; ?></td>  
                <td><?php echo $edc->old_depname; ?></td>
                <td><?php echo $edc->old_room; ?></td>
                <!-- <td></td> -->
              </tr>
              <?php
              $i++;
            endforeach;
              endif;
              ?>
  
            </tbody>
    </table>
    </div>

