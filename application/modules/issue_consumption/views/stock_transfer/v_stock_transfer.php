<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title"><?php echo $this->lang->line('stock_transfer'); ?></h3>
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
	                			<li class="tab-selector <?php if($tab_type=='entry') echo 'active';?>">
	                				<a href="<?php echo base_url('issue_consumption/stock_transfer'); ?>" <?php if($tab_type=='all') echo' aria-expanded="true"';?>" ><?php echo $this->lang->line('stock_transfer'); ?></a>
	                			</li>
                                <li class="tab-selector <?php if($tab_type=='list') echo 'active';?>">
                                    <a href="<?php echo base_url('issue_consumption/stock_transfer/list_stocktransfer'); ?>"><?php echo $this->lang->line('stock_transfer_list'); ?></a>
                                </li>
	                			<li class="tab-selector <?php if($tab_type=='detailslist') echo 'active';?>">
	                				<a href="<?php echo base_url('issue_consumption/stock_transfer/list_stock_transfer_details'); ?>"><?php echo $this->lang->line('stock_transfer_detail'); ?></a>
	                			</li>
                                <li class="tab-selector <?php if($tab_type=='locationstock') echo 'active';?>">
                        <a href="<?php echo base_url('stock_inventory/current_stock/location_wise_item_stock'); ?>"><?php echo $this->lang->line('location_wise_item_stock'); ?></a>
                    </li>
	            			</ul>
	        			</div> -->
	      			</div>
    			</div>

    			<div class="ov_report_tabs page-tabs pad-5 margin-top-220 tabbable">

    				<?php if($tab_type=='entry'): ?>      
    					<div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='entry') echo "active"; ?>">
                			<div  id="FormDiv_mrnbook" class="formdiv frm_bdy">
                    			<?php $this->load->view('stock_transfer/v_stock_transfer_form');?>
                			</div>
        				</div>
        			<?php endif; ?>
                    <?php if($tab_type=='list'): ?>         
                        <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='list') echo "active"; ?>">
                            <div  id="FormDiv_mrnbook_supplier" class="formdiv frm_bdy">
                                <?php $this->load->view('stock_transfer/v_stock_transfer_lists');?>
                            </div>
                        </div>
                    <?php endif; ?>
        			<?php if($tab_type=='detailslist'): ?>         
        				<div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='detailslist') echo "active"; ?>">
              				<div  id="FormDiv_mrnbook_supplier" class="formdiv frm_bdy">
                  				<?php $this->load->view('stock_transfer/v_stock_transfer_details_lists');?>
              				</div>
        				</div>
        			<?php endif; ?>
                    <?php if($tab_type=='locationstock'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='locationstock') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                    <?php $this->load->view('current_stock/v_location_wise_item_stock_list');?>
                </div>
            </div>
            <?php endif; ?>
        		</div>
    		</div>
		</div>
	</div>
</div>