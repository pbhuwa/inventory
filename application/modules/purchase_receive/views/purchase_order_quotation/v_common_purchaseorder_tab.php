     <div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
                <h3 class="box-title"><?php echo $this->lang->line('purchase_order_purchase_order_summary_purchase_order_details_purchase_order_aging_cancel_order'); ?></h3>
            <div class="ov_report_tabs pad-5 tabbable r-tabs">
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
                    
                    <li class="tab-selector <?php if($current_stock=='purchase_order') echo 'active';?>"><a href="<?php echo base_url('purchase_receive/purchase_order_quotation'); ?>" <?php if($current_stock=='purchase_order') echo' aria-expanded="true"';?>" ><?php echo $this->lang->line('purchase_order'); ?></a></li>
                     
                     <!-- <li class="tab-selector <?php if($current_stock=='purchase_order_book') echo 'active';?>"><a href="<?php echo base_url('purchase_receive/purchase_order/purchase_order_book'); ?>"><?php echo $this->lang->line('purchase_order_summary'); ?> </a></li>
                      
                      <li class="tab-selector <?php if($current_stock=='purchase_order_details') echo 'active';?>"><a href="<?php echo base_url('purchase_receive/purchase_order_details'); ?>" <?php if($current_stock=='purchase_order_details') echo' aria-expanded="true"';?>" ><?php echo $this->lang->line('purchase_order_detail'); ?></a></li>
                     
                     <li class="tab-selector <?php if($current_stock=='purchase_order_aging') echo 'active';?>"><a href="<?php echo base_url('purchase_receive/purchase_order_aging'); ?>"><?php echo $this->lang->line('purchase_order_aging'); ?> </a></li>
                    <li class="tab-selector <?php if($current_stock=='cancel_order') echo 'active';?>"><a href="<?php echo base_url('purchase_receive/cancel_order'); ?>"><?php echo $this->lang->line('cancel_order'); ?></a></li>
                    <li class="tab-selector <?php if($current_stock=='cancel_order_list') echo 'active';?>"><a href="<?php echo base_url('purchase_receive/cancel_order/cancel_order_lists'); ?>"><?php echo $this->lang->line('cancel_order_list'); ?></a></li> -->
                </ul>
                <!-- <select class="mb10 form-control visible-xs" id="tab_selector">
                    <option value="0">Purchase Order</option>
                    <option value="1">Purchase Order Book</option>
                    <option value="2">Purchase Order Details</option>
                    <option value="3">Cancel Order</option>
                    <option value="4">Cancel Order List</option>
                </select> -->
            </div>
            </div>
            </div>
        <div class="ov_report_tabs page-tabs margin-top-250 pad-5 tabbable">
            <?php if($current_stock=='purchase_order'): ?>      
            <div id="dtl_rpt" class="tab-pane fade in  <?php if($current_stock=='purchase_order') echo "active"; ?>">
                        <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            
                        <?php $this->load->view('purchase_order_quotation/v_purchase_order_form');?>
                        </div>
            </div>
            <?php endif; ?>
                 <?php if($current_stock=='purchase_order_book'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($current_stock=='purchase_order_book') echo "active"; ?>">
                    <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            <?php $this->load->view('purchase_order/v_purchase_order_book_list');?>
                        </div>
                  
                    </div>
            <?php endif; ?>
             <?php if($current_stock=='purchase_order_details'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($current_stock=='purchase_order_details') echo "active"; ?>">
                    <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            <!-- );?> -->
                            <?php $this->load->view('purchase_order_details/v_purchase_order_details');?>
                        </div>
                  
                    </div>
            <?php endif; ?>
             <?php if($current_stock=='purchase_order_aging'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($current_stock=='purchase_order_aging') echo "active"; ?>">
                    
                    <div  id="FormDiv_DirectReceive" class="formdiv frm_bdy">
                       
                        <?php $this->load->view('purchase_order_aging/v_purchase_order_aging_list');?>
                    </div>
            </div>
            <?php endif; ?>
            <?php if($current_stock=='cancel_order_list'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($current_stock=='cancel_order_list') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                    <?php $this->load->view('cancel_order/v_cancel_order');?>
                </div>
            </div>
            <?php endif; ?>
            <?php if($current_stock=='cancel_order'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($current_stock=='cancel_order') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                    <?php $this->load->view('cancel_order/v_cancel_order_form');?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        </div>
    </div>
</div>


            