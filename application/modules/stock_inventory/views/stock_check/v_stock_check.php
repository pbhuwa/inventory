<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title"><?php echo $this->lang->line('stock_check_stock_till_date_stock_summary'); ?></h3>

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
                                <li class="tab-selector <?php if($stock_check=='check') echo 'active';?>">
                                    <a href="<?php echo base_url('stock_inventory/stock_check'); ?>" <?php if($stock_check=='check') echo' aria-expanded="true"';?>" >
                                        <?php echo $this->lang->line('stock_check'); ?>
                                    </a>
                                </li>
                                <li class="tab-selector <?php if($stock_check=='till_date') echo 'active';?>">
                                    <a href="<?php echo base_url('stock_inventory/stock_check/stock_till_date'); ?>">
                                        <?php echo $this->lang->line('stock_till_date'); ?>
                                    </a>
                                </li>
                                <li class="tab-selector <?php if($stock_check=='summary') echo 'active';?>">
                                    <a href="<?php echo base_url('stock_inventory/stock_check/stock_till_date_summary'); ?>">
                                        <?php echo $this->lang->line('stock_summary'); ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="ov_report_tabs page-tabs pad-5 margin-top-120 tabbable">
                    <?php if($stock_check=='check'): ?>      
                    <div id="dtl_rpt" class="tab-pane fade in  <?php if($stock_check=='check') echo "active"; ?>">
                        <div  id="FormDiv_StockCheck" class="formdiv frm_bdy">
	                       <?php $this->load->view('stock_check/v_stock_check_list');?>
                        </div>
                    </div>
                    <?php endif; ?>
                 
                    <?php if($stock_check=='till_date'): ?>         
                        <div id="dtl_supplier" class="tab-pane fade in <?php if($stock_check=='till_date') echo "active"; ?>">
                            <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                                <?php $this->load->view('till_date/v_till_datemain');?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($stock_check=='summary'): ?>         
                        <div id="dtl_supplier" class="tab-pane fade in <?php if($stock_check=='summary') echo "active"; ?>">
                            <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                                <?php $this->load->view('till_date/v_till_datemain_summary');?>
                            </div>
                        </div>
                    <?php endif; ?>  
                </div>
            </div>
        </div>
    </div>
</div>