
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
				<div id="dtl_entry" class="tab-pane fade in  <?php if($tab_type=='entry') echo "active"; ?>">
		            <div  id="FormDiv_repairreqform" class="formdiv frm_bdy">
		                <?php $this->load->view('repair_request/v_assets_repair_request_form');?>
		            </div>
				</div>
			<?php endif; ?>
            <?php if($tab_type=='repair_request_summary'): ?>      
                <div id="dtl_summary" class="tab-pane fade in  <?php if($tab_type=='repair_request_summary') echo "active"; ?>">
                    <div  id="FormDiv_summaryform" class="formdiv frm_bdy">
                        <?php $this->load->view('repair_request/v_assets_repair_request_summary_list');?>
                    </div>
                </div>
            <?php endif; ?>

             <?php if($tab_type=='repair_request_detail'): ?>      
                <div id="dtl_request" class="tab-pane fade in  <?php if($tab_type=='repair_request_detail') echo "active"; ?>">
                    <div  id="FormDiv_requestdetail" class="formdiv frm_bdy">
                        <?php $this->load->view('repair_request/v_assets_repair_request_detail_list');?>
                    </div>
                </div>
            <?php endif; ?>
			
		</div>
</div>
</div>
</div>
</div>


