
            <table class="table table-striped  dataTable" width="100%">
              <thead>
                <tr>
                  <th width="5%" style="text-align: center">S.N.</th>
                  <!-- <th width="15%" style="text-align: center">Equipment</th>
                  <th width="5%" style="text-align: center">Equipment Code</th> -->
                  <!-- <th width="10%" style="text-align: center">Department</th> -->
                  <th width="10%" style="text-align: center">Comment Date</th>
                  <th width="20%" style="text-align: center">Problem</th>
                  <th width="20%" style="text-align: center">Solution</th>  
                  <th width="12%" style="text-align: center">Time</th>
                  <th width="5%" style="text-align: center">Maintained By</th>
                  <th width="5%" style="text-align: center"></th>

                </tr>
              </thead>
              <tbody>

                <?php
                if(!empty($maintenance_data)){
                foreach($maintenance_data as $key=>$value){?>
                <tr id="listid_<?php echo $value->malo_maintenancelogid; ?>">
                  <td><?php echo $key+1; ?></td>
                  <td style="text-align: center"><?php echo $value->malo_postdatebs; ?></td>
                  <td style="text-align: center"><?php echo $value->malo_comment; ?></td>
                  <td style="text-align: center"><?php echo $value->malo_remark; ?></td>
                  <td style="text-align: center"><?php echo $value->malo_time; ?></td>
                  <td style="text-align: center"><?php echo $this->session->userdata('user_name'); ?></td>
                  <td style="text-align: center"><a href="javascript:void(0)" class="btnDeleteServer" data-id=<?php echo $value->malo_maintenancelogid; ?> data-tableid='<?php echo $value->malo_maintenancelogid; ?>'  data-deleteurl='delete_mlog_comment').' title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                  
                </tr>
                <?php } } ?>

              </tbody>
            </table>
          