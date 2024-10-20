<div class="row wb_form">
    <div class="col-sm-7">
        <div class="white-box">
            <h3 class="box-title">Department Information</h3>
            <div id="FormDiv_departmentInformation" class="formdiv frm_bdy">
            <?php $this->load->view('department_information/v_department_informationform') ;?>
            </div>
        </div>
    </div>

    <div class="col-sm-5">
     <div class="white-box">
          <input type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >
          <div id="TableDiv">
            <?php $this->load->view('department_information/v_list_department_information') ;?> 
          </div>
        </div>
    </div>
</div>
