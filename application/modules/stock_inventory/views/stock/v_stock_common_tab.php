<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
                <!-- <h3 class="box-title"><?php //echo $this->lang->line('stock'); ?></h3> -->

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
                    <li class="tab-selector <?php if($tab=='stock_received') echo 'active';?>"><a href="<?php echo base_url('stock_inventory/stock_received'); ?>" <?php if($tab=='consumption') echo' aria-expanded="true"';?>" ><?php echo $this->lang->line('stock_received'); ?></a></li>

                     <li class="tab-selector <?php if($tab=='stock_requirement') echo 'active';?>"><a href="<?php echo base_url('stock_inventory/stock_requirement'); ?>"><?php echo $this->lang->line('stock_requirement'); ?> </a></li>

                    <!--  <li class="tab-selector <?php //if($tab=='stock_return') echo 'active';?>"><a href="<?php //echo base_url('stock_inventory/stock_return'); ?>" <?php //if($tab=='consumption') echo' aria-expanded="true"';?>" ><?php //echo $this->lang->line('stock');?> <?php //echo $this->lang->line('return'); ?></a></li> -->

                  <!--    <li class="tab-selector <?php //if($tab=='stock_analysis') echo 'active';?>"><a href="<?php //echo base_url('stock_inventory/stock_analysis'); ?>"><?php //echo $this->lang->line('stock_analysis'); ?> </a></li> -->

                     <!-- <li class="tab-selector <?php //if($tab=='stock_aging') echo 'active';?>"><a href="<?php //echo base_url('stock_inventory/stock_aging'); ?>"><?php //echo $this->lang->line('stock_aging'); ?> </a></li> -->

                     <li class="tab-selector <?php if($tab=='stock_in_transaction') echo 'active';?>"><a href="<?php echo base_url('stock_inventory/stock_in_transaction'); ?>" <?php if($tab=='consumption') echo' aria-expanded="true"';?>" ><?php echo $this->lang->line('stock_in_transaction'); ?></a></li>

                </ul>
            </div>
        </div>
            </div>
              <div class="ov_report_tabs page-tabs pad-5 margin-top-30 tabbable">
                <?php if($tab=='stock_received'): ?>      
                    <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab=='stock_received') echo "active"; ?>">
                        <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            
                            <?php $this->load->view('stock_received/v_stock_received');?>  
                        </div>
                    </div>
                <?php endif; ?>

                <?php if($tab=='stock_requirement'): ?>         
                    <div id="dtl_supplier" class="tab-pane fade in <?php if($tab=='stock_requirement') echo "active"; ?>">
                        <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            
                            <?php $this->load->view('stock_requirement/v_stock_requirement');?>
                        </div>
                  
                    </div>
                <?php endif; ?>

                <?php if($tab=='stock_return'): ?>      
                    <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab=='stock_return') echo "active"; ?>">
                        <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            
                            <?php $this->load->view('stock_received/v_stock_received');?>  
                        </div>
                    </div>
                <?php endif; ?>

                <?php if($tab=='stock_analysis'): ?>         
                    <div id="dtl_supplier" class="tab-pane fade in <?php if($tab=='stock_analysis') echo "active"; ?>">
                        <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            
                            <?php $this->load->view('stock_received/v_stock_received');?>
                        </div>
                  
                    </div>
                <?php endif; ?>

                <?php if($tab=='stock_aging'): ?>      
                    <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab=='stock_aging') echo "active"; ?>">
                        <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            
                            <?php $this->load->view('stock_received/v_stock_received');?>  
                        </div>
                    </div>
                <?php endif; ?>

                <?php if($tab=='stock_in_transaction'): ?>         
                    <div id="dtl_supplier" class="tab-pane fade in <?php if($tab=='stock_in_transaction') echo "active"; ?>">
                        <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            
                            <?php $this->load->view('stock_in_transaction/v_purchase_sale');?>
                        </div>
                  
                    </div>
                <?php endif; ?>
              </div>
    </div>
</div>
</div>
</div>