
<div class="row wb_form">
    <div class="col-sm-6">
        <div class="white-box">
            <h3 class="box-title">Staff Management Form</h3>
            <div id="FormDiv_staff" class="formdiv frm_bdy">
            <?php $this->load->view('staff_manager/v_staff_manager_form') ;?>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
      <div class="white-box">
         <input type="hidden" id="EditUrl" value="<?php echo $editurl; ?>" >
        <input type="hidden" id="DeleteUrl" value="<?php echo $deleteurl; ?>" >
        <input type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >
          <div id="TableDiv">
             <?php $this->load->view('staff_manager/v_staff_manager_list') ;?>
           
          </div>
      </div>
    </div>
</div>
</div>
</div>


   
                    

