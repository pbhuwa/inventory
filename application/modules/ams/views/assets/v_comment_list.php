<h3 class="box-title"><?php echo $this->lang->line('previous_comments'); ?></h3>
<table id="" class="table flatTable tcTable" >
                          <thead>
                              <tr>
                                  <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                                  <th width="10%"><?php echo $this->lang->line('asset_date_AD'); ?></th>
                                  <th width="10%"><?php echo $this->lang->line('asset_date_BS'); ?></th>
                                  <th width="10%"><?php echo $this->lang->line('asset_docommission_time'); ?></th>
                                  <th width="35%"><?php echo $this->lang->line('comments'); ?></th>
                                  <th width="25%"><?php echo $this->lang->line('comments_by'); ?></th>
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
                                      <td><?php echo $com->eqco_posttime; ?></td>
                                      <td><?php echo $com->eqco_comment; ?></td>
                                       <td><?php echo $com->usma_fullname; ?></td>
                                       <td><a href="javascript:void(0)" class=" label <?php echo $class; ?> btn-xs"><?php echo $penf  ?> </a></td>
                                      <td>
                                    <!--   <a href="javascript:void(0)"  title="Edit" data-id='<?php echo $com->eqco_equipmentcommentid; ?>' data-viewurl='<?php echo base_url('biomedical/bio_medical_inventory/edit_biomedical_comments') ?>'  class="btnEdit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> -->
                                      <a href="javascript:void(0)" title="Cancel" data-id='<?php echo $com->eqco_equipmentcommentid; ?>' class="btnDelete"><i class="fa fa-times" aria-hidden="true"></i></a>
                                      </td>
                                      </tr>
                                  <?php
                                  $i++;
                                  endforeach;
                              else:
                                ?>
                                <tr>
                                  <td colspan="6"><p class="text-danger text-center">Record Empty!!</p></td>
                                </tr>
                                <?php
                                endif;


                               ?>
                           </tbody>
                          </table>