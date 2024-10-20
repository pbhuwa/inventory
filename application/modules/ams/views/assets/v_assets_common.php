
   <div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">

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

	 <div class="ov_report_tabs page-tabs pad-5 margin-top-170 tabbable">

		    <?php if($tab_type=='entry'): ?>      
				<div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='entry1') echo "active"; ?>">
		            <div  id="FormDiv_stockreqform" class="formdiv frm_bdy">
		                <?php $this->load->view('assets/v_assets_main');?>
		            </div>
				</div>
			<?php endif; ?>
			
			<?php if($tab_type=='list'): ?>         
				<div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='list1') echo "active"; ?>">
		        	<div  id="FormDiv_stockreqlist" class="formdiv frm_bdy">
		            	<?php $this->load->view('assets/v_assets_list');?>
		        	</div>
		    	</div>
			<?php endif; ?>
			<?php if($tab_type=='custom'): ?>      
				<div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='assets_search') echo "active"; ?>">
		            <div  id="FormDiv_demandform" class="formdiv frm_bdy">
		                <?php $this->load->view('assets/v_assets_search');?>
		            </div>
				</div>
			<?php endif; ?>
			<?php if($tab_type=='analysis'): ?>      
				<div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='summary_report') echo "active"; ?>">
		            <div  id="FormDiv_demandform" class="formdiv frm_bdy">
		                <?php $this->load->view('assets/v_column_wise_report');?>
		            </div>
				</div>
			<?php endif; ?>
			<?php if($tab_type=='comment'): ?>      
				<div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='c') echo "active"; ?>">
		            <div  id="FormDiv_demandform" class="formdiv frm_bdy">
		                <?php $this->load->view('assets/v_assets_comment');?>
		            </div>
				</div>
			<?php endif; ?>
			<?php if($tab_type=='decommission'): ?>      
				<div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='dec') echo "active"; ?>">
		            <div  id="FormDiv_demandform" class="formdiv frm_bdy">
		                <?php $this->load->view('assets_decommission/v_assets_decommission');?>
		            </div>
				</div>
			<?php endif; ?>
			<?php if($tab_type=='Log'): ?>      
				<div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='Log') echo "active"; ?>">
		            <div  id="FormDiv_demandform" class="formdiv frm_bdy">
		                <?php $this->load->view('assets_maintenance_log/v_assets_maintenance_log');?>
		            </div>
				</div>
			<?php endif; ?>

			<?php if($tab_type=='Handover'): ?>      
				<div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='Handover') echo "active"; ?>">
		            <div  id="FormDiv_demandform" class="formdiv frm_bdy">
		                <?php $this->load->view('assets_handover/v_assets_handover');?>
		            </div>
				</div>
			<?php endif; ?>
		</div>



        
	<div class="clearfix"></div>