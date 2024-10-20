<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title"><?php echo $this->lang->line('stock_requisition'); ?></h3>
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
				        <li class="tab-selector <?php if($tab_selector=='entry') echo 'active';?>"><a href="<?php echo base_url('stock_inventory/stock_adjustment/'); ?>" <?php if($tab_selector=='all') echo' aria-expanded="true"';?>" ><?php echo $this->lang->line('stock_adjustment'); ?></a></li>

				        
				        <li class="tab-selector <?php if($tab_selector=='details') echo 'active';?>"><a href="<?php echo base_url('stock_inventory/stock_adjustment/stock_adjustment_detail'); ?>"><?php echo $this->lang->line('stock_adjustment_details'); ?></a></li>

				    </ul>
				</div> -->
			</div>
		</div>
	    <div class="ov_report_tabs page-tabs pad-5 margin-top-170 tabbable">
		    <?php if($tab_selector=='entry'): ?>      
				<div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_selector=='entry') echo "active"; ?>">
		            <div  id="FormDiv_stockreqform" class="formdiv frm_bdy">
		                <?php $this->load->view('stock_adjustment/stock_adjustment_main');?>
		            </div>
				</div>
			<?php endif; ?>
			
			<?php if($tab_selector=='details'): ?>      
				<div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_selector=='details') echo "active"; ?>">
		            <div  id="FormDiv_demandform" class="formdiv frm_bdy">
		                <?php $this->load->view('stock_adjustment/stock_adjustment_detail_main');?>
		            </div>
				</div>
			<?php endif; ?>
			
        </div>
    </div>
</div>
	</div>
</div>
</div>