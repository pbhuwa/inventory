

<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title">Orgnization Setup</h3>
            <div id="FormDiv" class="formdiv frm_bdy">
            <?php $this->load->view('orga_setup/v_orga_setup_form') ;?>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
     <div class="white-box">
            <h3 class="box-title">List of Organizations <i class="fa fa-refresh pull-right"></i></h3>
            <div class="pad-5">
                                  <input type="hidden" id="EditUrl" value="<?php echo $editurl; ?>" >
                                <input type="hidden" id="DeleteUrl" value="<?php echo $deleteurl; ?>" >
                                <iput type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >
                <div class="table-responsive">
                     <?php $this->load->view('orga_setup/v_orga_setup_list') ;?>
                  
                </div>
            </div>
        </div>
    </div>
</div>

   
                    

