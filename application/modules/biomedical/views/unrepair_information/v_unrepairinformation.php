<div class="row wb_form">
    <div class="col-sm-7">
        <div class="white-box">
            <h3 class="box-title">Unrepairable Equipment</h3>
            <div  id="FormDiv_PmdataForm" class="formdiv frm_bdy">
            <?php $this->load->view('unrepair_information/v_un_repairableform');?>
            </div>
        </div>
    </div>
    <div class="col-sm-5">
      <div class="white-box">
        <input type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >
          <div id="TableDiv">
           <?php $this->load->view('unrepair_information/v_unrepair_information_list');?> 
          </div>
      </div>
    </div>
</div>
</div>
</div>
