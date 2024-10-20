
    <div class="row">
        <div class="col-sm-4">
            <div class="white-box">
                <h3 class="box-title">Room Management</h3>
                <div id="FormDiv" class="formdiv frm_bdy">
                <?php $this->load->view('room/v_roomform') ;?>
                </div>
            </div>
        </div>

        <div class="col-sm-8">
            <a href="javascript:void(0)" class="pull-right btn btn-sm btn-success btnRefresh"><i class="fa fa-refresh" aria-hidden="true"></i></a>
            <div class="white-box">
                <h3 class="box-title">Room List</h3>
                <div class="table-responsive dtable_pad scroll">
                    <input type="hidden" id="EditUrl" value="<?php echo $editurl; ?>" >
                    <input type="hidden" id="DeleteUrl" value="<?php echo $deleteurl; ?>" >
                    <input type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >
                    <div id="TableDiv">
                        <?php echo $this->load->view('room/v_room_list'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


   
                    

