    <div class="row">
        <div class="col-sm-4">
            <div class="white-box">
                <h3 class="box-title">Add Scheme</h3>
                <div id="FormDiv" class="formdiv frm_bdy">
                <?php $this->load->view('community/v_communityform');?>
                </div>
            </div>
        </div>

        <div class="col-sm-8">
            <div class="white-box">
                <h3 class="box-title">Scheme List</h3>
                <div class="table-responsive dtable_pad scroll">
                    <input type="hidden" id="EditUrl" value="<?php echo $editurl; ?>" >
                    <input type="hidden" id="DeleteUrl" value="<?php echo $deleteurl; ?>" >
                    <table id="Dtable" class="table table-striped" >
                        <thead>
                            <tr>
                                <th>Scheme</th>
                                <th>Posted Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                        if($department_all):
                            foreach ($department_all as $km => $department):
                            ?>
                            <tr id="listid_<?php echo $department->comm_communityid; ?>">
                            <td><?php echo $department->comm_community; ?></td>
                            <td><?php echo $department->comm_postdatead; ?></td>
                            <td>
                            <a href="javascript:void(0)" data-id='<?php echo $department->comm_communityid; ?>' class="btnEdit">Edit </a> |
                            <a href="javascript:void(0)" data-id='<?php echo $department->comm_communityid; ?>' class="btnDelete">Delete</a>
                            </td>
                            </tr>
                            <?php
                            endforeach;
                        endif;
                         ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
                   
                    

