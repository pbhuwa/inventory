<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title"><?php echo $this->lang->line('purchase_report'); ?></h3>
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
				    	
				    	<li class="tab-selector <?php if($tab_type=='pending_order') echo 'active';?>"><a href="<?php echo base_url('purchase_receive/pending_order'); ?>"> <?php echo $this->lang->line('pending_orders'); ?></a></li>

				        <li class="tab-selector <?php if($tab_type=='pending_order_detail') echo 'active';?>"><a href="<?php echo base_url('purchase_receive/pending_order_detail'); ?>" <?php if($tab_type=='all') echo' aria-expanded="true"';?>" ><?php echo $this->lang->line('pending_order_detail'); ?></a></li>

				        <li class="tab-selector <?php if($tab_type=='demand_report') echo 'active';?>"><a href="<?php echo base_url('purchase_receive/demand_report'); ?>"><?php echo $this->lang->line('demand_report'); ?></a></li>

				        <li class="tab-selector <?php if($tab_type=='order_detail') echo 'active';?>"><a href="<?php echo base_url('purchase_receive/order_detail'); ?>"><?php echo $this->lang->line('order_details'); ?></a></li>

				        <li class="tab-selector <?php if($tab_type=='purchase_details') echo 'active';?>"><a href="<?php echo base_url('purchase_receive/purchase_detail'); ?>"><?php echo $this->lang->line('purchase_detail'); ?> </a></li> 

						<li class="tab-selector <?php if($tab_type=='change_supplier') echo 'active';?>"><a href="<?php echo base_url('stock_inventory/change_supplier'); ?>"><?php echo $this->lang->line('change_supplier'); ?></a></li>
				    </ul>
				</div>
			</div>
		</div>

	    <div class="ov_report_tabs page-tabs pad-5 margin-top-170 tabbable">
		    <?php if($tab_type=='pending_order'): ?>      
				<div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='pending_order') echo "active"; ?>">
		            <div  id="FormDiv_demandform" class="formdiv frm_bdy">
		                <?php $this->load->view('pending_order/v_pending_order');?>
		            </div>
				</div>
			<?php endif; ?>

		    <?php if($tab_type=='pending_order_detail'): ?>      
				<div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='pending_order_detail') echo "active"; ?>">
		            <div  id="FormDiv_stockreqform" class="formdiv frm_bdy">
		                <?php $this->load->view('pending_order_detail/v_pending_order_detail');?>
		            </div>
				</div>
			<?php endif; ?>
			
			<?php if($tab_type=='demand_report'): ?>         
				<div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='demand_report') echo "active"; ?>">
		        	<div  id="FormDiv_stockreqlist" class="formdiv frm_bdy">
		            	<?php $this->load->view('demand_report/v_demand_report');?>
		        	</div>
		    	</div>
			<?php endif; ?>
			<?php if($tab_type=='order_detail'): ?>      
				<div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='order_detail') echo "active"; ?>">
		            <div  id="FormDiv_demandform" class="formdiv frm_bdy">
		                <?php $this->load->view('order_detail/v_order_detail');?>
		            </div>
				</div>
			<?php endif; ?>
			
			<?php if($tab_type=='purchase_details'): ?>      
				<div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='purchase_details') echo "active"; ?>">
		            <div  id="FormDiv_demandform" class="formdiv frm_bdy">
		                <?php $this->load->view('purchase_detail/v_purchase_detail');?>
		            </div>
				</div>
			<?php endif; ?>

			<?php if($tab_type=='change_supplier'): ?>      
				<div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='change_supplier') echo "active"; ?>">
		            <div  id="FormDiv_demandform" class="formdiv frm_bdy">
		                <?php $this->load->view('change_supplier/v_change_supplier_main');?>
		            </div>
				</div>
			<?php endif; ?>
        </div>
    </div>
</div>
	</div>
</div>
</div>