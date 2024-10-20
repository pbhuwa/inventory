<div class="row wb_form">
    <div class="col-sm-7">
        <div class="white-box">
            <h3 class="box-title">Pm Completed</h3>
            <div id="FormDiv_equipments" class="formdiv frm_bdy">
            <?php $this->load->view('pm_completed/v_pm_completedform') ;?>
            </div>
        </div>
    </div>

    <div class="col-sm-5">
     <div class="white-box">
        <input type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >
          <div id="TableDiv">
          <?php $this->load->view('pm_completed/v_pm_completed_list') ;?>
        </div>
        </div>
    </div>
</div>
</div>
</div>
                   
                    

