<div class="row wb_form">
    <div class="col-sm-7">
        <div class="white-box">
            <h3 class="box-title">Purchase Donate</h3>
            <div id="FormDiv_purchase_donate" class="formdiv frm_bdy">
            <?php $this->load->view('purchase_donate/v_purchasedonateform') ;?>
            </div>
        </div>
    </div>

    <div class="col-sm-5">
     <div class="white-box">
        <input type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >
          <div id="TableDiv">
              <?php $this->load->view('purchase_donate/v_purchase_donate_list') ;?>
          </div>
        </div>
    </div>
</div>
</div>
</div>
                    


                    

