<div class="row wb_form">
	<div class="col-sm-12">
		<div class="white-box">
			<h3 class="box-title"><?php echo $this->lang->line('issue_analysis_report'); ?></h3>
			<div  id="FormDiv_item" class="formdiv frm_bdy issue_cons">
				<!-- <div class="row">
					<div class="col-sm-2"> -->
						
					<!-- </div>
					<div class="col-sm-10"> -->
						<div class="tab-content white-box pad-5">
							<div id="home" class="tab-pane fade in active">
								<!-- <h3><?php // echo $this->lang->line('issue_by_value'); ?></h3> -->
								<?php $this->load->view('issue_value_report/v_issue_value');?>
							</div>
							<!-- <div id="menu2" class="tab-pane fade">
								<h3>Menu 2</h3>
								<p>Some content in menu 2.</p>
								</div>
								<div id="menu3" class="tab-pane fade">
									<h3>Item Wise Issue</h3>
									<?php //$this->load->view('report/v_itemswise');?>
								</div>
								<div id="menu4" class="tab-pane fade">
									<h3>Issue Book Report</h3>
									<?php //$this->load->view('report/v_issue_book');?>
								</div>
								<div id="menu5" class="tab-pane fade">
									<h3>Issue Summary</h3>
									<?php //$this->load->view('report/v_issue_summary');?>
								</div>
								<div id="menu6" class="tab-pane fade">
								<h3>Issue Details</h3>
								<?php //$this->load->view('report/v_issue_details');?>
							</div> -->
						</div>
					<!-- </div> -->
					<div id="InventoryRpt">
						
					</div>
				<!-- </div> -->
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(".nav-pills a").click(function(){
     	$(this).tab('show');
 	});
</script>