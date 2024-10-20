<div class="row ">
        <div class="col-sm-4">
            <div class="white-box">
                <h3 class="box-title"><?php echo $this->lang->line('brand_management'); ?></h3>
                <div id="FormDiv" class="frm_bdy formdiv">
                   <?php $this->load->view('brand/v_brandform') ;?>
                </div>
            </div>
        </div>

        <div class="col-sm-8">
            <a href="javascript:void(0)" class="pull-right btn btn-sm btn-success btnRefresh"><i class="fa fa-refresh" aria-hidden="true"></i></a>
            <div class="white-box">
                <h3 class="box-title"><?php echo $this->lang->line('brand_list'); ?></h3>
                <div class="table-responsive dtable_pad scroll">
                    <input type="hidden" id="EditUrl" value="<?php echo $editurl; ?>" >
                    <input type="hidden" id="DeleteUrl" value="<?php echo $deleteurl; ?>" >
                    <input type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >
                    <div id="TableDiv">
                        <?php echo $this->load->view('v_brand_list'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>