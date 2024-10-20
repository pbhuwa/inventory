
<div class="row wb_form">
      <div class="col-sm-12">
         <input type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >
         <div class="white-box">
            <div id="TableDiv">
        <?php $this->load->view('item/v_item_list', $this->data);?>
    </div>
    </div>
      </div>

</div>







