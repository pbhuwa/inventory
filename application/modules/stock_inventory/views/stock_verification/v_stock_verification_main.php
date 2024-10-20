<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title"><?php echo $this->lang->line('stock_verification'); ?></h3>
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

                        <!-- <div class="self-tabs">
                            <ul class="nav nav-tabs form-tabs">
                                <li class="tab-selector <?php if($tab_type=='issue') echo 'active';?>">
                                    <a href="<?php echo base_url('stock_inventory/stock_verification'); ?>" <?php if($tab_type=='all') echo' aria-expanded="true"';?>" ><?php echo $this->lang->line('issue'); ?></a>
                                </li>
                            <li class="tab-selector <?php if($tab_type=='purchase') echo 'active';?>">
                                    <a href="<?php echo base_url('stock_inventory/stock_verification/verification_purchase'); ?>"><?php echo $this->lang->line('purchase'); ?></a>
                                </li>
                          <li class="tab-selector <?php if($tab_type=='transfer') echo 'active';?>">
                                    <a href="<?php echo base_url('stock_inventory/stock_verification/verification_stock_transfer'); ?>"><?php echo $this->lang->line('stock_transfer'); ?></a>
                                </li> 

                            <li class="tab-selector <?php if($tab_type=='issuereturn') echo 'active';?>">
                                    <a href="<?php echo base_url('stock_inventory/stock_verification/verification_issue_return'); ?>"><?php echo $this->lang->line('issue_return'); ?></a>
                                </li> 

                             <li class="tab-selector <?php if($tab_type=='purchasereturn') echo 'active';?>">
                                    <a href="<?php echo base_url('stock_inventory/stock_verification/verification_purchase_return'); ?>"><?php echo $this->lang->line('purchase_return'); ?></a>
                                </li> 

                            <li class="tab-selector <?php if($tab_type=='stockreceive') echo 'active';?>">
                                    <a href="<?php echo base_url('stock_inventory/stock_verification/verification_stock_receive'); ?>"><?php echo $this->lang->line('stock_receive'); ?></a>
                                </li> 


                            </ul>
                        </div> -->
                    </div>
                </div>

                <div class="ov_report_tabs page-tabs pad-5 margin-top-220 tabbable">

                    <?php if($tab_type=='issue'): ?>      
                        <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='issue') echo "active"; ?>">
                            <div  id="FormDiv_mrnbook" class="formdiv frm_bdy">
                                <?php $this->load->view('stock_verification/v_stock_verification_issue');?>
                            </div>
                        </div>
                    <?php endif; ?>

               <?php if($tab_type=='purchase'): ?>         
                        <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='purchase') echo "active"; ?>">
                            <div  id="FormDiv_mrnbook_supplier" class="formdiv frm_bdy">
                                <?php $this->load->view('stock_verification/v_stock_verification_purchase');?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php if($tab_type=='transfer'): ?>         
                        <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='transfer') echo "active"; ?>">
                            <div  id="FormDiv_mrnbook_supplier" class="formdiv frm_bdy">
                                <?php $this->load->view('stock_verification/v_stock_verification_stock_transfer');?>
                            </div>
                        </div>
                    <?php endif; ?>

                     <?php if($tab_type=='issuereturn'): ?>         
                        <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='issuereturn') echo "active"; ?>">
                            <div  id="FormDiv_mrnbook_supplier" class="formdiv frm_bdy">
                                <?php $this->load->view('stock_verification/v_stock_verification_issue_return');?>
                            </div>
                        </div>
                    <?php endif; ?>

                     <?php if($tab_type=='purchasereturn'): ?>         
                        <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='purchasereturn') echo "active"; ?>">
                            <div  id="FormDiv_mrnbook_supplier" class="formdiv frm_bdy">
                                <?php $this->load->view('stock_verification/v_stock_verification_purchase_return');?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($tab_type=='stockreceive'): ?>         
                        <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='stockreceive') echo "active"; ?>">
                            <div  id="FormDiv_mrnbook_supplier" class="formdiv frm_bdy">
                                <?php $this->load->view('stock_verification/v_stock_verification_stock_receive');?>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>