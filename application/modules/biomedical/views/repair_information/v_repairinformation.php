<div class="row wb_form">
    <div class="col-sm-7">
        <div class="white-box">
            <h3 class="box-title">Repair Information</h3>
            <div id="FormDiv" class="formdiv frm_bdy">
            <?php $this->load->view('repair_information/v_repairinformationform');?>
            </div>
        </div>
    </div>
    <div class="col-sm-5">
     <div class="white-box">
        <input type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >
          <div id="TableDiv">
          <?php $this->load->view('repair_information/v_repairrequest_lists');?>
           </div> 
        </div>
    </div>
</div>

                    


                    


                    



                    


                   
                    

