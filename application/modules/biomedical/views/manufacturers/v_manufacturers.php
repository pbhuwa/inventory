<div class="row wb_form">
    <div class="col-sm-6">
        <div class="white-box">
            <h3 class="box-title">Manufacturer</h3>
            <div id="FormDiv_Manufacture" class="formdiv frm_bdy">
            <?php $this->load->view('manufacturers/v_manufacturersform') ;?>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
      <input type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >
      <div id="TableDiv">
          <?php $this->load->view('manufacturers/v_manufacturers_list') ;?>
      </div>
    </div>
</div>    
</div>
</div>   

