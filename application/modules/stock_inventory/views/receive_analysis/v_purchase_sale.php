<div class="row wb_form">
	<div class="col-sm-12">
		<div class="white-box">
			<h3 class="box-title"><?php echo $this->lang->line('receive_analyis'); ?></h3>
			<div  id="FormDiv_item" class="formdiv frm_bdy issue_cons">
				<div class="row">
					<div class="col-md-10 col-sm-9">
						<div class="tab-content white-box pad-5">
							<div id="home" class="tab-pane fade in active">
								<?php $this->load->view('stock_in_transaction/v_purchase');?>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					<div id="purchaseSale">
						
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
