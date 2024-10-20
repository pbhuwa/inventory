<div class="row wb_form">
    <div class="col-sm-5">
        <div class="white-box">
            <h3 class="box-title"><?php echo $this->lang->line('list_of_distributor'); ?></h3>
            <div id="FormDiv_Distributer" class="formdiv frm_bdy">
            <?php $this->load->view('distributors/v_distributorsform') ;?>
            </div>
        </div>
    </div>

    <div class="col-sm-7">
      <div class="white-box">
        <input type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >
          <div id="TableDiv">
             <?php $this->load->view('distributors/v_distributers_list') ;?>
           
          </div>
      </div>
    </div>
</div>
</div>
</div>

