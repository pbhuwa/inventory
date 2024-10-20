
  <h3 class="box-title">List of Pipezone Type<a href="javascript:void(0)" class="btnRefresh"><i class="fa fa-refresh pull-right"></i></a></h3>

            <div class="pad-5">

                <div class="table-responsive">

                    <table id="myTable" class="table table-striped dataTable">

                        <thead>

                            <tr>

                              <th width="10%"><?php echo $this->lang->line('sn'); ?> </th>

                                <th width="30%">Pipezone Type</th>
                                <th width="30%">Pipezone Category</th>
                                <th width="20%">Is active ?</th>
                                <th width="10%"><?php echo $this->lang->line('action'); ?></th>

                            </tr>

                        </thead>

                        <tbody>
                          <?php
                          if(!empty($pipezone_type)):
                            foreach($pipezone_type as $key=>$pz):?>
                            <tr>
                              <td><?php echo $key+1; ?></td>
                              <td><?php echo !empty($pz->pizo_name)?$pz->pizo_name:''; ?></td>

                              <?php if (!empty($pipezone_cat)):
                                foreach ($pipezone_cat as $key => $pc): 
                                    if($pc->pizo_id==$pz->pizo_parentid): ?>
                                       <td><?php echo !empty($pc->pizo_name)?$pc->pizo_name:''; ?></td>
                                    <?php
                                    else:?><td></td>
                                  <?php endif;?>
                              <?php 
                                endforeach;
                                  endif; ?>

                              <td><?php echo !empty($pz->pizo_isactive)?$pz->pizo_isactive:''; ?></td>
                              <td>
                             <a href="javascript:void(0)" title="Edit" data-id='<?php echo $pz->pizo_id; ?>' class="btnEdit"><i class="fa fa-edit"></i> </a>
                              
                           
                                <a href="#"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>

                              </td>
                            </tr>
                              <?php
                            endforeach;
                          endif; ?>
                                  

                        </tbody>

                    </table>

                </div>

            </div>





