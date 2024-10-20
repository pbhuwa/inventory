<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
                <h3 class="box-title"><?php echo $this->lang->line('purchase_issue_report'); ?></h3>

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
                    <li class="tab-selector <?php if($tab=='purchase') echo 'active';?>"><a href="<?php echo base_url('stock_inventory/purchase_sale'); ?>" <?php if($tab=='purchase') echo' aria-expanded="true"';?>" ><?php echo $this->lang->line('purchase'); ?></a></li>

                     <li class="tab-selector <?php if($tab=='issue') echo 'active';?>"><a href="<?php echo base_url('stock_inventory/purchase_sale/issue_display'); ?>"><?php echo $this->lang->line('issue'); ?> </a></li>
                </ul>
            </div>
        </div>
    </div>
     <div class="ov_report_tabs page-tabs pad-5 margin-top-80 tabbable">
                 <?php if($tab=='purchase'): ?>      
            <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab=='purchase') echo "active"; ?>">
                        <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                           
                            <!-- <?php // $this->load->view('consumption/v_consumption');?>  --> 
                           <!-- <?php // $this->load->view('purchase_sale/v_purchase_sale');?>  -->
                           <?php $this->load->view('purchase_sale/v_purchase');?>  
                        </div>
            </div>
            <?php endif; ?>
                 <?php if($tab=='issue'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($tab=='issue') echo "active"; ?>">
                    <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            
                            <!-- <?php // $this->load->view('purchase_sale/v_issue');?> -->
                             <?php $this->load->view('purchase_sale/v_issue');?>  
                        </div>
                  
                    </div>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>