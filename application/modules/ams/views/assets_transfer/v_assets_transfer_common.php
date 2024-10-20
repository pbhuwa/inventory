

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

		                <?php 
                         if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME=='ARMY') {
                            $this->load->view('assets_transfer/ku/v_assets_transfer');
                        } else {

                           $this->load->view('assets_transfer/v_assets_transfer');
                        }   
                        ?>
                                 

		            </div>

				</div>

			<?php endif; ?>
                <?php if($tab_type=='transfer_bulk'):  ?>      

                <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='transfer_bulk') echo "active"; ?>">

                    <div  id="FormDiv_stockreqform" class="formdiv frm_bdy">

                        <?php 
                         if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME=='ARMY') {
                            // echo "sad";
                            // die();
                            $this->load->view('assets_transfer/ku/v_assets_bulk_transfer');
                        } else {

                            $this->load->view('assets_transfer/ku/v_assets_bulk_transfer');
                        }   
                        ?>
                                 

                    </div>

                </div>

            <?php endif; ?>


            <?php if($tab_type=='transfer_summary'): ?>      

                <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='transfer_summary') echo "active"; ?>">

                    <div  id="FormDiv_stockreqform" class="formdiv frm_bdy">

                        <?php 
                        if(ORGANIZATION_NAME=='KU' || ORGANIZATION_NAME=='ARMY'){
                        $this->load->view('assets_transfer/ku/v_assets_transfer_summary_list');
                        }else{
                         $this->load->view('assets_transfer/v_assets_transfer_summary_list');
                        }
                        ?>

                    </div>

                </div>

            <?php endif; ?>



             <?php if($tab_type=='transfer_detail'): ?>      

                <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='transfer_detail') echo "active"; ?>">

                    <div  id="FormDiv_stockreqform" class="formdiv frm_bdy">
                          <?php 
                        if(ORGANIZATION_NAME=='KU' || ORGANIZATION_NAME=='ARMY'){
                        $this->load->view('assets_transfer/ku/v_assets_transfer_detail_list');
                        }else{
                         $this->load->view('assets_transfer/v_assets_transfer_detail_list');
                        }
                        ?>
                       

                    </div>

                </div>

            <?php endif; ?>

            <?php if($tab_type=='correction'): ?>      

                <div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='correction') echo "active"; ?>">

                    <div  id="FormDiv_stockreqform" class="formdiv frm_bdy">
                          <?php 
                       
                         $this->load->view('assets_transfer/v_assets_transfer_correction');
                       
                        ?>
                       

                    </div>

                </div>

            <?php endif; ?>

			

		</div>

</div>

</div>

</div>

</div>







        

	<div class="clearfix"></div>