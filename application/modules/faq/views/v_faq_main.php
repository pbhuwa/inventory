<!-- <script src="<?php echo base_url('assets/common/ckeditor/ckeditor.js'); ?>"></script> -->
<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box padding24">
          <?php $this->load->view('v_faq_form');?>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="white-box padding24">
          <div id="TableDiv">
            <?php $this->load->view('v_faq_form_list');?>
          </div>
      </div>
    </div>
</div>