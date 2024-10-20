<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title"><?php echo $this->lang->line('frequently_asked_questions'); ?></h3>
            <div class="ov_report_tabs pad-5 tabbable">
            <div class="margin-bottom-30">
                <div class="dropdown-tabs">
                    <div class="mobile-tabs">
                    <a href="#" class="tabs-dropdown_toogle">
                        <i class="fa fa-bar"></i>
                        <i class="fa fa-bar"></i>
                        <i class="fa fa-bar"></i>
                    </a>
                    </div>
                <div class="self-tabs">
            <ul class="nav nav-tabs form-tabs">
                <li class="tab-selector <?php if($tab_type=='cat_setup') echo 'active';?>"><a href="<?php echo base_url('faq/faq_category_setup'); ?>" <?php if($tab_type=='all') echo' aria-expanded="true"';?>" ><?php echo $this->lang->line('faq_category_setup'); ?></a></li>

                <li class="tab-selector <?php if($tab_type=='entry') echo 'active';?>"><a href="<?php echo base_url('faq/insert_faq'); ?>" <?php if($tab_type=='all') echo' aria-expanded="true"';?>" ><?php echo $this->lang->line('faq_form'); ?></a></li>

                <li class="tab-selector <?php if($tab_type=='list') echo 'active';?>"><a href="<?php echo base_url('faq/faq_list'); ?>"><?php echo $this->lang->line('faq_list'); ?></a></li>

               </ul>
        </div>
      </div>
    </div>
      <div class="ov_report_tabs page-tabs pad-5 margin-top-170 tabbable">
        
        <?php if($tab_type=='cat_setup'): ?>      
        <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='cat_setup') echo "active"; ?>">
            <div  id="FormDiv_FormFaqCategorySetup" class="formdiv frm_bdy">
              <?php $this->load->view('v_faq_category'); ?>
            </div>
        </div>
      <?php endif; ?>

        <?php if($tab_type=='entry'): ?>      
        <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='entry') echo "active"; ?>">
            <div  id="FormDiv_Formfaqlist" class="formdiv frm_bdy">
                <?php $this->load->view('v_faq_main'); ?>
            </div>
        </div>
      <?php endif; ?>
      
      <?php if($tab_type=='list'): ?>         
        <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='list') echo "active"; ?>">
              <div  id="FormDiv_stockreqlist" class="formdiv frm_bdy">
                  <?php $this->load->view('v_faq_list');?>
              </div>
          </div>
      <?php endif; ?>
     


        </div>
    </div>
</div>
</div>
</div>