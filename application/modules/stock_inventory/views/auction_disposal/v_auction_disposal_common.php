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

				<div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='entry') echo "active"; ?>">

		            <div  id="FormDiv_stockreqform" class="formdiv frm_bdy">

		                <?php $this->load->view('auction_disposal/v_auction_disposal_form');?>

		            </div>

				</div>

			<?php endif; ?>

		    <?php if($tab_type=='summary'): ?>      

				<div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='summary') echo "active"; ?>">

		            <div  id="FormDiv_stockreqform" class="formdiv frm_bdy">

		                <?php $this->load->view('auction_disposal/v_auction_disposal_summary');?>

		            </div>

				</div>

			<?php endif; ?>

		    <?php if($tab_type=='detail'): ?>      

				<div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='detail') echo "active"; ?>">

		            <div  id="FormDiv_stockreqform" class="formdiv frm_bdy">

		                <?php $this->load->view('auction_disposal/v_auction_disposal_detail');?>

		            </div>

				</div>

			<?php endif; ?>

		</div>

</div>

</div>

</div>

</div>

	<div class="clearfix"></div>