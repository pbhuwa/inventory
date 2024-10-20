
 <div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title"><?php echo $this->lang->line('faq_category_setup'); ?></h3>
            <div  id="FormDiv_item" class="formdiv frm_bdy">
            <?php $this->load->view('v_faq_category');?>
            </div>
        </div>
    </div>

      <div class="col-sm-12">
         <input type="hidden" id="ListUrl" value="">
         <div class="white-box">
            <div id="TableDiv">
        <?php $this->load->view('v_faq_category_list');?>
    </div>
    </div>
      </div>
  
</div>