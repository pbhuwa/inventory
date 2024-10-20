<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
                <h3 class="box-title"><?php echo $this->lang->line('receive_analysis_summary_dispatch_wise_item_wise'); ?></h3>

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
                    <li class="tab-selector <?php if($receive_analysis=='summary') echo 'active';?>"><a href="<?php echo base_url('stock_inventory/receive_analysis'); ?>" <?php if($receive_analysis=='summary') echo' aria-expanded="true"';?>" ><?php echo $this->lang->line('summary'); ?></a></li>
                     <li class="tab-selector <?php if($receive_analysis=='dispatchwise') echo 'active';?>"><a href="<?php echo base_url('stock_inventory/receive_analysis/dispatch_wise'); ?>"><?php echo $this->lang->line('dispatch_wise'); ?> </a></li>
                     <li class="tab-selector <?php if($receive_analysis=='itemwise') echo 'active';?>"><a href="<?php echo base_url('stock_inventory/receive_analysis/item_wise'); ?>"><?php echo $this->lang->line('itemwise'); ?> </a></li>
                    </ul>
                    </div> -->
        </div>
    </div>
           <div class="ov_report_tabs page-tabs pad-5 margin-top-120 tabbable">
                 <?php if($receive_analysis=='summary'): ?>      
            <div id="dtl_rpt" class="tab-pane fade in  <?php if($receive_analysis=='summary') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                    <?php $this->load->view('receive_analysis/v_current_stock_details');?> 
                    
                </div>
            </div>
            <?php endif; ?>
                 <?php if($receive_analysis=='dispatchwise'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($receive_analysis=='dispatchwise') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                    <?php $this->load->view('dispatch_wise/v_dispatch_wise_detsils');?>
                </div>
            </div>
            <?php endif; ?>
                 <?php if($receive_analysis=='itemwise'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($receive_analysis=='itemwise') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                    <?php $this->load->view('dispatch_wise/v_itemwise_details');?>
                </div>
            </div>
            <?php endif; ?>  
        </div>
    </div>
</div>
</div>