<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title"><?php echo $this->lang->line('opening_stock_opening_stock_list'); ?></h3>
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
            </div>
        </div>
    </div>
            <div class="ov_report_tabs page-tabs pad-5 margin-top-80 tabbable">
                <?php if($curtab=='opening_stock'): ?>
                <div id="dtl_rpt" class="tab-pane fade in  <?php if($curtab=='opening_stock') echo "active"; ?>">
                   <div  id="FormDiv_openingstock" class="formdiv frm_bdy">
                        <?php $this->load->view('opening_stock/opening_stock_form');?>
                    </div>
                </div>
                <?php endif; ?>
                <?php if($curtab=='opening_lists'): ?>
                <div id="dtl_supplier" class="tab-pane fade in <?php if($curtab=='opening_lists') echo "active"; ?>">
                    <div id="TableDiv">
                        <?php $this->load->view('opening_stock/opening_stock_list');?>
                    </div>
                </div>
                <?php endif; ?>
                 <?php if($curtab=='opening_stock_excel'): ?>
                <div id="dtl_supplier" class="tab-pane fade in <?php if($curtab=='opening_stock_excel') echo "active"; ?>">
                    <div id="TableDiv">
                        <?php $this->load->view('opening_stock/opening_stock_excel_list');?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>