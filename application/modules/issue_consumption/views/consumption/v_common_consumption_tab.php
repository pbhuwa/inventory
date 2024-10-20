<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
                <h3 class="box-title"><?php echo $this->lang->line('consumption_report'); ?></h3>

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
                    <li class="tab-selector <?php if($tab=='consumption') echo 'active';?>"><a href="<?php echo base_url('issue_consumption/consumption_report'); ?>" <?php if($tab=='consumption') echo' aria-expanded="true"';?>" ><?php echo $this->lang->line('consumption'); ?></a></li>

                     <li class="tab-selector <?php if($tab=='current_stock') echo 'active';?>"><a href="<?php echo base_url('issue_consumption/consumption_report/current_stock_details'); ?>"><?php echo $this->lang->line('detail'); ?> </a></li>
                </ul>
            </div> -->
        </div>
            </div>
              <div class="ov_report_tabs page-tabs pad-5 margin-top-30 tabbable">
                 <?php if($tab=='consumption'): ?>      
            <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab=='consumption') echo "active"; ?>">
                        <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            <!-- <?php // $this->load->view('current_stock/v_current_stock_form');?> -->
                            <?php $this->load->view('consumption/v_consumption');?>  
                        </div>
            </div>
            <?php endif; ?>
                 <?php if($tab=='current_stock'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($tab=='current_stock') echo "active"; ?>">
                    <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            <!-- <?php $this->load->view('current_stock/v_current_stock_details');?> -->
                            <?php $this->load->view('consumption/v_current_stok');?>
                        </div>
                  
                    </div>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>
</div>