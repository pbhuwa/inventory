<div class="row wb_form">
    <div class="col-sm-5">
        <div class="white-box">
            <h3 class="box-title">Services Technician</h3>
            <div id="FormDiv_service_techs" class="formdiv frm_bdy">
            <?php $this->load->view('service_techs/v_service_techsform') ;?>
            </div>
        </div>
    </div>

    <div class="col-sm-7">
     <div class="white-box">
        <input type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >
          <div id="TableDiv">  
            <?php $this->load->view('service_techs/v_service_tec_list') ;?>
          </div> 
          </div>
        </div>
    </div>
</div>
                    


                    


              