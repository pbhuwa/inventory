 <div class="row wb_form">
    <div class="col-sm-5">
        <div class="white-box">
            <h3 class="box-title">Risk Values</h3>
            <div id="FormDiv_risk_value" class="formdiv frm_bdy">
            <?php $this->load->view('risk_value/v_risk_valueform') ;?>
            </div>
        </div>
    </div>

    <div class="col-sm-7">
     <div class="white-box">
        <input type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >
          <div id="TableDiv">
           <?php $this->load->view('risk_value/v_risk_value_list') ;?>
          </div>
        </div>
    </div>
</div>
</div>
</div>

                    


                    


                    

