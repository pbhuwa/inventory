<div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title">Users Management</h3>
                            <div id="FormDiv" class="frm_bdy">
                            <?php $this->load->view('users/v_usersform') ;?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box list">
                            <div class="table-responsive">
                            <input type="hidden" id="EditUrl" value="<?php echo $editurl; ?>" >
                            <input type="hidden" id="DeleteUrl" value="<?php echo $deleteurl; ?>" >
                                <table id="Dtable" class="table table-striped" >
                                    <thead>
                                        <tr>
                                            <th>S.n</th>
                                            <th>Username</th>
                                            <th>Fullname</th>
                                            <th>Department</th>
                                            <th>Group.</th>
                                            <th>Post Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    $i=1;
                                    if($users_all):
                                        foreach ($users_all as $km => $user):
                                        ?>
                                        <tr id="listid_<?php echo $user->usma_userid; ?>">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $user->usma_username; ?></td>
                                        <td><?php echo $user->usma_fullname; ?></td>
                                        <td><?php echo $this->users_mdl->get_userwise_dep($user->usma_userid,'V');?></td>
                                        <td><?php echo $this->users_mdl->get_userwise_group($user->usma_userid,'V');?></td>
                                        <td><?php echo $user->usma_postdatebs; ?></td>
                                        <td>
                                        <a href="javascript:void(0)" data-id='<?php echo $user->usma_userid; ?>' class="btnEdit">Edit </a> |
                                        <a href="javascript:void(0)" data-id='<?php echo $user->usma_userid; ?>' class="btnDelete">Delete</a>
                                        </td>
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
                   
                    

