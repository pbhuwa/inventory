<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
                <h3 class="box-title"><?php echo $this->lang->line('reports_analysis'); ?></h3>

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
                        <li class="tab-selector <?php if($transfer_analysis=='moving_analysis') echo 'active';?>"><a href="<?php echo base_url('stock_inventory/moving_analysis'); ?>" <?php if($transfer_analysis=='moving_analysis') echo' aria-expanded="true"';?>" ><?php echo $this->lang->line('moving_analysis'); ?></a></li>

                        <li class="tab-selector <?php if($transfer_analysis=='non_moving_items') echo 'active';?>"><a href="<?php echo base_url('stock_inventory/non_moving_items'); ?>" <?php if($transfer_analysis=='non_moving_items') echo' aria-expanded="true"';?>" ><?php echo $this->lang->line('non_moving_items'); ?></a></li>

                        <li class="tab-selector <?php if($transfer_analysis=='summary') echo 'active';?>"><a href="<?php echo base_url('stock_inventory/transfer_analysis'); ?>" <?php if($transfer_analysis=='summary') echo' aria-expanded="true"';?>" ><?php echo $this->lang->line('transfer_analysis_summary'); ?></a></li>

                        <li class="tab-selector <?php if($transfer_analysis=='itemwise') echo 'active';?>"><a href="<?php echo base_url('stock_inventory/transfer_analysis/item_wise'); ?>"><?php echo $this->lang->line('item_wise_transfer_analysis'); ?> </a></li>

                        <li class="tab-selector <?php if($transfer_analysis=='itemwisesummary') echo 'active';?>"><a href="<?php echo base_url('stock_inventory/transfer_analysis/item_wise_summary'); ?>"><?php echo $this->lang->line('item_wise_transfer_analysis_summary'); ?> </a></li>
                        </ul>
                    </div> -->
        </div>
    </div>
       <div class="ov_report_tabs page-tabs pad-5 margin-top-120 tabbable">
            
            <?php if($transfer_analysis=='moving_analysis'): ?>      
                <div id="dtl_rpt" class="tab-pane fade in  <?php if($transfer_analysis=='moving_analysis') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                    <?php $this->load->view('moving_analysis/v_moving_analysis');?> 
                    
                </div>
                </div>
            <?php endif; ?>


            <?php if($transfer_analysis=='non_moving_items'): ?>      
                <div id="dtl_rpt" class="tab-pane fade in  <?php if($transfer_analysis=='non_moving_items') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                    <?php $this->load->view('non_moving_items/v_non_moving_items');?> 
                    
                </div>
                </div>
            <?php endif; ?>
            

            <?php if($transfer_analysis=='summary'): ?>      
                <div id="dtl_rpt" class="tab-pane fade in  <?php if($transfer_analysis=='summary') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                    <?php $this->load->view('transfer_analysis/v_summary');?> 
                    
                </div>
                </div>
            <?php endif; ?>

            <?php if($transfer_analysis=='itemwise'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($transfer_analysis=='itemwise') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                    <?php $this->load->view('transfer_analysis/v_itemwise_details');?>
                </div>
            </div>
            <?php endif; ?>
                 <?php if($transfer_analysis=='itemwisesummary'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($transfer_analysis=='itemwisesummary') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                    <?php $this->load->view('transfer_analysis/v_itemwise_summary');?>
                </div>
            </div>
            <?php endif; ?>
              
        </div>
    </div>
</div>
</div>