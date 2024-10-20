<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
            <!-- <h3 class="box-title"><?php echo $this->lang->line('receive_ordered_items'); ?></h3> -->
            <h3 class="box-title">Received Direct Handover Items</h3>

            <div class="ov_report_tabs pad-5 tabbable">
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
                   <?php  $this->load->view('common/v_common_tab_header'); ?>
               
            </div>
			</div>
		</div>
		<div class="ov_report_tabs page-tabs margin-top-30 pad-5 tabbable">
		    <?php if($tab_type=='entry'): ?>      
				<div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='entry') echo "active"; ?>">
		            <div  id="FormDiv_stockreqform" class="formdiv frm_bdy">
		                <?php $this->load->view('handover_direct/v_handover_receive_direct_form');?>
		            </div>
				</div>
			<?php endif; ?>
			<?php if($tab_type=='summary_list'): ?>         
				<div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='summary_list') echo "active"; ?>">
		        	<div  id="FormDiv_stockreqlist" class="formdiv frm_bdy">
		            	<?php $this->load->view('handover_direct/v_handover_summary_list');?>
		        	</div>
		    	</div>
			<?php endif; ?>
			<?php if($tab_type=='detailslist'): ?>         
				<div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='detailslist') echo "active"; ?>">
		        	<div  id="FormDiv_stockreqlist" class="formdiv frm_bdy">
		            	<?php $this->load->view('handover_direct/v_handover_received_detail');?>
		        	</div>
		    	</div>
			<?php endif; ?>
			<?php if($tab_type=='handover_edit'): ?>         
							<div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='handover_edit') echo "active"; ?>">
					        	<div  id="FormDiv_stockreqlist" class="formdiv frm_bdy">
					            	<?php $this->load->view('handover_direct/v_handover_received_correction_form');?>
					        	</div>
					    	</div>
						<?php endif; ?>

			</div>
        </div>
    </div>
</div>