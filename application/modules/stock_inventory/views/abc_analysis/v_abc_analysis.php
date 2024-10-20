<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
                <h3 class="box-title"><?php echo $this->lang->line('abc_analysis_abc_setup'); ?></h3>
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
                    <?php $this->load->view('common/v_common_tab_header'); ?>

                   <!--  <div class="self-tabs">
                <ul class="nav nav-tabs form-tabs">
                    <li class="tab-selector <?php if($receive_analysis=='abcsetup') echo 'active';?>"><a href="<?php echo base_url('stock_inventory/abc_analysis'); ?>" <?php if($receive_analysis=='abcsetup') echo' aria-expanded="true"';?>" ><?php echo $this->lang->line('abc_analysis'); ?></a></li>
                     <li class="tab-selector <?php if($receive_analysis=='abcenrty') echo 'active';?>"><a href="<?php echo base_url('stock_inventory/abc_analysis/abc_setup'); ?>"><?php echo $this->lang->line('abc_setup'); ?> </a></li>
                </ul>
            </div> -->
        </div>
    </div>
      <div class="ov_report_tabs page-tabs pad-5 margin-top-80 tabbable">
                 <?php if($receive_analysis=='abcsetup'): ?>      
            <div id="dtl_rpt" class="tab-pane fade in  <?php if($receive_analysis=='abcsetup') echo "active"; ?>">
                <div  id="FormDiv_StockCheck" class="formdiv frm_bdy">
                	<?php $this->load->view('abc_analysis/v_abc_analysis_list');?>
            	</div>
            </div>
            <?php endif; ?>
                 <?php if($receive_analysis=='abcenrty'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($receive_analysis=='abcenrty') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                    <?php $this->load->view('abc_analysis/v_abc_setup_form');?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>