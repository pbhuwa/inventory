
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

		    <?php if($tab_type=='list'): ?>      
				<div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='list') echo "active"; ?>">
		            <div  id="FormDiv_stockreqform" class="formdiv frm_bdy">
		                <?php $this->load->view('chart_of_assets/v_chart_of_assets_view');?>
		            </div>
				</div>
			<?php endif; ?>
          
			
		</div>
</div>
</div>
</div>
</div>



        
	<div class="clearfix"></div>