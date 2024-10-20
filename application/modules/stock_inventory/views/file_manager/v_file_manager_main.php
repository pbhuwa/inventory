<div class="row wb_form">
  <div class="col-sm-4">
    <div class="white-box">
      <h3 class="box-title">File Management</h3>
      <div id="FormDiv_filemanager" class="formdiv frm_bdy">
        <?php $this->load->view('file_manager/v_file_manager_form'); ?>
      </div> 
    </div>
  </div>
  <div class="col-sm-8">  
    <div class="white-box">
      <div id="TableDiv">
        <?php $this->load->view('file_manager/v_file_manager_list'); ?>
      </div>
    </div>
  </div>

</div>