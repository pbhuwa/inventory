<div class="row wb_form">
    <div class="col-sm-7">
        <div class="white-box">
            <h3 class="box-title">Un Repairable Form</h3>
            <div  id="FormDiv_PmdataForm" class="formdiv frm_bdy">
            <?php $this->load->view('repair_information/v_un_repairableform');?>
            </div>
        </div>
    </div>
    <div class="col-sm-5">
     <div class="white-box">
            <h3 class="box-title">List of Un Repairable Form<i class="fa fa-refresh pull-right"></i></h3>
            <div class="pad-5">
                <div class="table-responsive scroll">
                    <table id="myTable" class="table table-striped">
                        <thead>
                            <tr>
                              <th width="15%">Risk Id</th>
                              <th width="20%">Risk Value</th>
                              <th width="20%">Comments</th>
                              <th width="15%">Posted Date</th>
                              <th width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                                  
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>