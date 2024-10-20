<div class="row wb_form">
	<div class="col-sm-12">
		<div class="white-box">
			<h3 class="box-title"><?php echo $this->lang->line('issue_analysis_report'); ?></h3>
			<div  id="FormDiv_item" class="formdiv frm_bdy issue_cons">
				
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

              <!--   <div class="self-tabs">
                    <ul class="nav nav-tabs form-tabs">
                    <li class="tab-selector <?php if($current_tab=='item_wise') echo 'active';?>"><a href="<?php echo base_url('issue_consumption/report/item_wise_display'); ?>" <?php if($current_tab=='item_wise') echo' aria-expanded="true"';?>" ><?php echo $this->lang->line('item_wise_issue'); ?></a></li>
                     
                    <li class="tab-selector <?php if($current_tab=='issue_book') echo 'active';?>"><a href="<?php echo base_url('issue_consumption/report/issue_book_display'); ?>"><?php echo $this->lang->line('issue_book'); ?></a></li>

                    <li class="tab-selector <?php if($current_tab=='category_wise') echo 'active';?>">  <a href="<?php echo base_url('issue_consumption/report'); ?>" <?php if($current_tab=='category_wise') echo' aria-expanded="true"';?>" ><?php echo $this->lang->line('category_wise_issue'); ?></a>
                    </li>

                    <li class="tab-selector <?php if($current_tab=='receive_dispatch_analysis') echo 'active';?>">  <a href="<?php echo base_url('issue_consumption/receive_dispatch_analysis'); ?>" <?php if($current_tab=='receive_dispatch_analysis') echo' aria-expanded="true"';?>" ><?php echo $this->lang->line('receive_dispatch_analysis'); ?></a>
                    </li>

                   
                     
                     <li class="tab-selector <?php if($current_tab=='sub_category_wise') echo 'active';?>"><a href="<?php echo base_url('issue_consumption/report/sub_categorywise_display'); ?>"><?php echo $this->lang->line('sub_category_wise_issue'); ?> </a></li>

                    
                     
                     
                     <li class="tab-selector <?php if($current_tab=='issue_summary') echo 'active';?>"><a href="<?php echo base_url('issue_consumption/report/issue_summary_display'); ?>"><?php echo $this->lang->line('issue_summary'); ?></a></li>

                    <li class="tab-selector <?php if($current_tab=='issue_details') echo 'active';?>"><a href="<?php echo base_url('issue_consumption/report/issue_details_display'); ?>" <?php if($current_tab=='issue_details') echo' aria-expanded="true"';?>" ><?php echo $this->lang->line('issue_detail'); ?></a></li>

                     </ul>
                 </div> -->
             </div>
        </div>
    </div>

        <div class="ov_report_tabs pad-5 page-tabs margin-top-250 tabbable">
            <?php if($current_tab=='category_wise'): ?>      
            <div id="dtl_rpt" class="tab-pane fade in  <?php if($current_tab=='category_wise') echo "active"; ?>">
                        <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            <?php $this->load->view('report/v_categories');?>
                        </div>
            </div>


   
            <?php endif; ?>
                 <?php if($current_tab=='sub_category_wise'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($current_tab=='sub_category_wise') echo "active"; ?>">
                    <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            <?php $this->load->view('report/v_sub_categories');?>
                        </div>
                  
                    </div>
            <?php endif; ?>



             <?php if($current_tab=='item_wise'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($current_tab=='item_wise') echo "active"; ?>">
                    <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            <?php $this->load->view('report/v_itemswise');?>
                        </div>                  
                    </div>
            <?php endif; ?>
            
            <?php if($current_tab=='receive_dispatch_analysis'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($current_tab=='receive_dispatch_analysis') echo "active"; ?>">
                    <!-- <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            <?php // $this->load->view('purchase_receive/analysis/v_analysis');?>
                        </div> -->
                    <div  id="FormDiv_DirectReceive" class="formdiv frm_bdy">
                        <?php $this->load->view('receive_dispatch/v_receive_dispatch');?>
                    </div>
            </div>
            <?php endif; ?>

            
            <?php if($current_tab=='issue_book'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($current_tab=='issue_book') echo "active"; ?>">
                    <!-- <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                            <?php // $this->load->view('purchase_receive/analysis/v_analysis');?>
                        </div> -->
                    <div  id="FormDiv_DirectReceive" class="formdiv frm_bdy">
                        <?php $this->load->view('report/v_issue_book');?>
                    </div>
            </div>
            <?php endif; ?>

             <?php if($current_tab=='issue_summary'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($current_tab=='issue_summary') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                        <?php $this->load->view('report/v_issue_summary');?>
                    </div>
              
                </div>
            <?php endif; ?>


             <?php if($current_tab=='issue_details'): ?>         
            <div id="dtl_supplier" class="tab-pane fade in <?php if($current_tab=='issue_details') echo "active"; ?>">
                <div  id="FormDiv_purchase_analysis" class="formdiv frm_bdy">
                        <?php $this->load->view('report/v_issue_details');?>
                    </div>
              
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>




				<div class="clearfix"></div>
				<div id="itemWiseReport">
					
				</div>
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