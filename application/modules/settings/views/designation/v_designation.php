<div class="row formdiv ">
        <div class="col-sm-4">
            <div class="white-box">
                <h3 class="box-title"><?php echo $this->lang->line('designation_management'); ?></h3>
                <div id="FormDiv" class="frm_bdy">
                   <?php $this->load->view('designation/v_designationform') ;?>
                </div>
            </div>
        </div>

        <div class="col-sm-8">
            <!-- <a href="javascript:void(0)" class="pull-right btn btn-sm btn-success btnRefresh"><i class="fa fa-refresh" aria-hidden="true"></i></a> -->
            <div class="white-box">
                <h3 class="box-title"><?php echo $this->lang->line('designation_list'); ?></h3>
                <div class="table-responsive dtable_pad scroll">
                    <input type="hidden" id="EditUrl" value="<?php echo $editurl; ?>" >
                    <input type="hidden" id="DeleteUrl" value="<?php echo $deleteurl; ?>" >
                    <input type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >
                    <div id="TableDiv">
                        <?php echo $this->load->view('v_designation_list'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>