<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
                <h3 class="box-title"><?php echo $this->lang->line('current_stock_summary_details'); ?></h3>

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
                    <li class="tab-selector <?php if($current_stock=='summary') echo 'active';?>"><a href="<?php echo base_url('issue_consumption/current_stock'); ?>" <?php if($current_stock=='summary') echo' aria-expanded="true"';?>" ><?php echo $this->lang->line('summary'); ?></a></li>
                     <li class="tab-selector <?php if($current_stock=='detail') echo 'active';?>"><a href="<?php echo base_url('issue_consumption/current_stock/current_stock_details'); ?>">
                        <?php echo $this->lang->line('stock_detail_report'); ?></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="ov_report_tabs page-tabs pad-5 margin-top-30 tabbable">
                 <?php if($current_stock=='summary'): ?>      
            <div id="dtl_rpt" class="tab-pane fade in  <?php if($current_stock=='summary') echo "active"; ?>">
                        <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            <?php $this->load->view('current_stock/v_current_stock_form');?>  
                        </div>
            </div>
            <?php endif; ?>
                 <?php if($current_stock=='detail'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($current_stock=='detail') echo "active"; ?>">
                    <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            <?php $this->load->view('current_stock/v_current_stock_details');?>
                    </div>
        
                    </div>
            <?php endif; ?>
        </div>
        </div>
</div>

</div>