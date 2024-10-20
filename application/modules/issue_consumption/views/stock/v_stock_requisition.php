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

				        <li class="tab-selector <?php if($tab_type=='entry') echo 'active';?>"><a href="<?php echo base_url('issue_consumption/stock_requisition'); ?>" <?php if($tab_type=='all') echo' aria-expanded="true"';?>" ><?php echo $this->lang->line('stock_requisition'); ?></a></li>



				        <li class="tab-selector <?php if($tab_type=='list') echo 'active';?>"><a href="<?php echo base_url('issue_consumption/stock_requisition/requisition_list'); ?>"><?php echo $this->lang->line('stock_requisition_summary'); ?></a></li>



				        <li class="tab-selector <?php if($tab_type=='details') echo 'active';?>"><a href="<?php echo base_url('issue_consumption/stock_requisition/stock_requisition_details'); ?>"><?php echo $this->lang->line('stock_requisition_details'); ?></a></li>



				        <li class="tab-selector <?php if($tab_type=='demand_analysis') echo 'active';?>"><a href="<?php echo base_url('issue_consumption/stock_requisition/demand_analysis'); ?>"><?php echo $this->lang->line('demand_analysis'); ?></a></li> 

				        

						<li class="tab-selector <?php if($tab_type=='req_analysis') echo 'active';?>"><a href="<?php echo base_url('issue_consumption/stock_transfer/req_analysis'); ?>"><?php echo $this->lang->line('req_analysis'); ?></a></li>

						<li class="tab-selector <?php if($tab_type=='monthlywise_dep_req') echo 'active';?>"><a href="<?php echo base_url('issue_consumption/stock_requisition/monthlywise_dep_req'); ?>"><?php echo $this->lang->line('monthlywise_dep_req'); ?></a></li>

				    </ul>

				</div> -->

			</div>

		</div>

	    <div class="ov_report_tabs page-tabs pad-5 margin-top-170 tabbable">

		    <?php if($tab_type=='entry'): ?>      

				<div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='entry') echo "active"; ?>">

		            <div  id="FormDiv_stockreqform" class="formdiv frm_bdy">

		            	<?php

                    if(defined('STOCK_REQ_FORM_TYPE')):

                        if(STOCK_REQ_FORM_TYPE == 'DEFAULT'){

                            $this->load->view('stock/v_stockrequisition_form');

                        }else{

                            $this->load->view('stock/'.REPORT_SUFFIX.'/v_stockrequisition_form');

                        }

                    else:

                        $this->load->view('stock/v_stockrequisition_form');

                    endif;

                    ?>

		               <!--  <?php //$this->load->view('stock/v_kukl_stockrequisition_form');?> -->

		            </div>

				</div>

			<?php endif; ?>

			

			<?php if($tab_type=='list'): ?>         

				<div id="dtl_supplier" class="tab-pane fade in <?php if($tab_type=='list') echo "active"; ?>">

		        	<div  id="FormDiv_stockreqlist" class="formdiv frm_bdy">

		        		<?php

		        		if(defined('STOCK_DEMAND_LIST')):

                        if(STOCK_DEMAND_LIST == 'DEFAULT'){

                            $this->load->view('stock/v_stockrequisition_list');

                        }else{

                            $this->load->view('stock/'.REPORT_SUFFIX.'/v_stockrequisition_list');

                        }

                    else:

                        $this->load->view('stock/v_stockrequisition_list');

                    endif;

                    ?>



		        	</div>

		    	</div>

			<?php endif; ?>

			<?php if($tab_type=='details'): ?>      

				<div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='details') echo "active"; ?>">

		            <div  id="FormDiv_demandform" class="formdiv frm_bdy">

		            	<?php

		        		if(defined('STOCK_DEMAND_LIST')):

                        if(STOCK_DEMAND_LIST == 'DEFAULT'){

                            $this->load->view('stock/v_stock_requisition_lists');

                        }else{

                            $this->load->view('stock/'.REPORT_SUFFIX.'/v_stock_requisition_lists');

                        }

                    else:

                        $this->load->view('stock/v_stock_requisition_lists');

                    endif;

                    ?>



		                <?php // $this->load->view('stock/v_stock_requisition_lists');?>

		            </div>

				</div>

			<?php endif; ?>

			

			<?php if($tab_type=='demand_analysis'): ?>      

				<div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='demand_analysis') echo "active"; ?>">

		            <div  id="FormDiv_demandform" class="formdiv frm_bdy">

		                <?php $this->load->view('stock/v_demandanalysis_form');?>

		            </div>

				</div>

			<?php endif; ?>

			<?php if($tab_type=='req_analysis'): ?>      

				<div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='req_analysis') echo "active"; ?>">

		            <div  id="FormDiv_demandform" class="formdiv frm_bdy">

		                <?php $this->load->view('stock/v_reqanalysis_form');?>

		            </div>

				</div>

			<?php endif; ?>

			<?php if($tab_type=='monthlywise_dep_req'): ?>      

				<div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='monthlywise_dep_req') echo "active"; ?>">

		            <div  id="FormDiv_demandform" class="formdiv frm_bdy">

		                <?php $this->load->view('stock/v_monthlywise_dep_req');?>

		            </div>

				</div>

			<?php endif; ?>



			<?php if($tab_type=='requisition_vs_issue'): ?>      

				<div id="dtl_rpt" class="tab-pane fade in  <?php if($tab_type=='requisition_vs_issue') echo "active"; ?>">

		            <div  id="FormDiv_demandform" class="formdiv frm_bdy">

		                <?php $this->load->view('stock/v_requisition_vs_issue');?>

		            </div>

				</div>

			<?php endif; ?>

        </div>

    </div>

</div>

	</div>

</div>

</div>