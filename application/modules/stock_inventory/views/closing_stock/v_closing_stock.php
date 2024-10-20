
<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title"><?php echo $this->lang->line('generate_stock'); ?></h3>
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
                                <li class="tab-selector <?php if($tab_type=='closingdata') echo 'active';?>">
                                    <a href="<?php echo base_url('stock_inventory/closing_stock/generate_closing_stock'); ?>" <?php if($tab_type=='all') echo' aria-expanded="true"';?> ><?php echo $this->lang->line('generate_closing_stock'); ?></a>
                                </li>
                            <li class="tab-selector <?php if($tab_type=='lists') echo 'active';?>">
                                <a href="<?php echo base_url('stock_inventory/closing_stock/lists'); ?>"><?php echo $this->lang->line('closing_stock_lists'); ?></a>
                            </li>
                                
                            </ul>
                        </div> -->
                    </div>
                </div>

                <div class="ov_report_tabs page-tabs pad-5 margin-top-220 tabbable">

                    <?php if($tab_type=='closingdata'): ?>      
                        <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='closingdata') echo "active"; ?>">
                            <div  id="FormDiv_mrnbook" class="formdiv frm_bdy">
                                <?php $this->load->view('closing_stock/v_closing_stock_form'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                 <?php if($tab_type=='lists'): ?>         
                        <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='lists') echo "active"; ?>">
                            <div  id="FormDiv_mrnbook_supplier" class="formdiv frm_bdy">
                                <?php $this->load->view('closing_stock/v_closing_stock_list');?>
                            </div>
                        </div>
                    <?php endif; ?>
                   
                </div>
            </div>
        </div>
    </div>
</div>