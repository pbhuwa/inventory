<div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title">Users Management</h3>
                            <div id="FormDiv" class="pad-10">
                            <?php $this->load->view('doctor/v_doctorform') ;?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <div class="table-responsive pad-5">
                            <input type="hidden" id="EditUrl" value="<?php echo $editurl; ?>" >
                            <input type="hidden" id="DeleteUrl" value="<?php echo $deleteurl; ?>" >
                                <table id="Dtable" class="table table-striped" >
                                    <thead>
                                        <tr>
                                            <th>S.n</th>
                                            <th>Doc.Code</th>
                                            <th>Desig.</th>
                                            <th>Doc.Name </th>
                                            <th>Qualification.</th>
                                            <th>Specialization</th>
                                            <th>Dep.Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    $i=1;
                                    if($doctor_all):
                                        foreach ($doctor_all as $km => $doct):
                                        ?>
                                        <tr id="listid_<?php echo $doct->dose_docid; ?>">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $doct->dose_doccode; ?></td>
                                        <td><?php echo $doct->dose_desig; ?></td>
                                        <td><?php echo $doct->dose_docname ?></td>
                                        <td><?php echo $doct->dose_qualification ?></td>
                                        <td><?php echo $doct->dose_specialization ?></td>
                                          <td><?php echo $doct->dose_specialization ?></td>
                                        <td>
                                        <a href="javascript:void(0)" data-id='<?php echo $doct->dose_docid; ?>' class="btnEdit"><i class="fa fa-edit"></i> </a> |
                                        <a href="javascript:void(0)" data-id='<?php echo $doct->dose_docid; ?>' class="btnDelete"><i class="fa fa-trash"></i></a>
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
                   
                    

