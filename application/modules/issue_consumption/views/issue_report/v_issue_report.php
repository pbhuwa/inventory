<div class="row wb_form">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title"><?php echo $this->lang->line('issue_report'); ?></h3>
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
                        <?php  $this->load->view('common/v_common_tab_header'); ?>
               <!--  <ul class="nav nav-tabs form-tabs">
                     <li class="tab-selector <?php if($issue_report=='issueItemwise') echo 'active';?>"><a href="<?php echo base_url('issue_consumption/issue_analysis/issue_itemwise'); ?>"><?php echo $this->lang->line('item_wise_issue'); ?></a></li>
                    <li class="tab-selector <?php if($issue_report=='issuereport') echo 'active';?>"><a href="<?php echo base_url('issue_consumption/issue_analysis'); ?>" <?php if($issue_report=='issuereport') echo' aria-expanded="true"';?>" ><?php echo $this->lang->line('issue_report_department_wise'); ?></a></li>
                    <li class="tab-selector <?php if($issue_report=='issue_report_department') echo 'active';?>"><a href="<?php echo base_url('issue_consumption/issue_analysis/issue_report_department'); ?>"><?php echo $this->lang->line('cat_dep_wise_issue'); ?></a></li>
                    <li class="tab-selector <?php if($issue_report=='itemReturn') echo 'active';?>">
                        <a href="<?php echo base_url('issue_consumption/issue_analysis/item_return'); ?>"><?php echo $this->lang->line('item_return'); ?></a>
                    </li>
                    <li class="tab-selector <?php if($issue_report=='Receiver_wise_Issue') echo 'active';?>">
                        <a href="<?php echo base_url('issue_consumption/receiver_wise_issue_details'); ?>"><?php echo $this->lang->line('receiver_wise_issue'); ?></a>
                    </li> 

                    <li class="tab-selector <?php if($issue_report=='Issue_return_analysis') echo 'active';?>">
                        <a href="<?php echo base_url('issue_consumption/issue_return_analysis'); ?>"><?php echo $this->lang->line('issue_return_analysis'); ?></a>
                    </li>

                    <li class="tab-selector <?php if($issue_report=='Issue_by_value') echo 'active';?>">
                        <a href="<?php echo base_url('issue_consumption/issue_value_report'); ?>"><?php echo $this->lang->line('issue_by_value'); ?></a>
                    </li>  
                     <li class="tab-selector <?php if($issue_report=='Issue_by_Receiver') echo 'active';?>">
                        <a href="<?php echo base_url('issue_consumption/issue_by_receiver'); ?>"><?php echo $this->lang->line('issue_by_receiver'); ?></a>
                    </li>  
                </ul> -->
            </div>
        </div>
    </div>
    
    <div class="ov_report_tabs page-tabs pad-5 margin-top-170 tabbable">
            <?php if($issue_report=='issueItemwise'): ?>         
            <div id="issueItemwise" class="tab-pane fade in <?php if($issue_report=='issueItemwise') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                        <?php $this->load->view('issue_report/v_itemswise_issue');?>
               </div>
            </div>
            <?php endif; ?>

             <?php if($issue_report=='issuereport'): ?>      
            <div id="dtl_rpt" class="tab-pane fade in  <?php if($issue_report=='issuereport') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
					<?php $this->load->view('issue_report/v_issue_report_form');?> 
                </div>
            </div>
            <?php endif; ?>

            <?php if($issue_report=='issue_report_department'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($issue_report=='issue_report_department') echo "active"; ?>">
                    <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            <?php $this->load->view('issue_report/v_departmentwise_issue');?>
                        </div>
                  
                    </div>
            <?php endif; ?>

            <?php if($issue_report=='itemReturn'): ?>         
            <div id="itemReturn" class="tab-pane fade in <?php if($issue_report=='itemReturn') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                        <?php $this->load->view('issue_report/v_items_return');?>
               </div>
            </div>
            <?php endif; ?>

            <?php if($issue_report=='Receiver_wise_Issue'): ?>         
            <div id="itemReturn" class="tab-pane fade in <?php if($issue_report=='Receiver_wise_Issue') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                        <?php $this->load->view('receiver_wise_issue/v_receiver_wise_issue_details');?>
               </div>
            </div>
            <?php endif; ?>

            <?php if($issue_report=='Issue_return_analysis'): ?>         
            <div id="itemReturn" class="tab-pane fade in <?php if($issue_report=='Issue_return_analysis') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                        <?php $this->load->view('issue_return_analysis/v_issue_return_analysis_report');?>
               </div>
            </div>
            <?php endif; ?>

            <?php if($issue_report=='Issue_by_value'): ?>         
            <div id="itemReturn" class="tab-pane fade in <?php if($issue_report=='Issue_by_value') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                        <?php $this->load->view('issue_value_report/v_report_value_issue');?>
               </div>
            </div>
            <?php endif; ?>


             <?php if($issue_report=='Issue_by_Receiver'): ?>         
            <div id="itemReturn" class="tab-pane fade in <?php if($issue_report=='Issue_by_Receiver') echo "active"; ?>">
                <div  id="FormDiv_issue_by_receiver" class="formdiv frm_bdy">
                        <?php $this->load->view('issue_by_receiver/v_issue_by_receiver');?>
               </div>
            </div>
            <?php endif; ?>



            <div id="ConsumptionReport">
						
			</div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
	$(".nav-pills a").click(function(){
     	$(this).tab('show');
 	});
</script>

