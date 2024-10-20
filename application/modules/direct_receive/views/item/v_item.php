<div class="row wb_form">
    <div class="col-sm-6">
        <div class="white-box">
            <h3 class="box-title">Item Entry</h3>
            <div  id="FormDiv_item" class="formdiv frm_bdy">
            <?php $this->load->view('item/v_item_form');?>
            </div>
        </div>
    </div>

      <div class="col-sm-6">
         <input type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >
         <div class="white-box">
            <div id="TableDiv">
        <?php $this->load->view('item/v_item_list');?>
    </div>
    </div>
      </div>
  
</div>





                    

