<div class="row wb_form">
	<div class="col-sm-12">
		<div class="white-box">
			
			<!-- <div  id="FormDiv_item" class="formdiv frm_bdy issue_cons"> -->
					<!-- <ul class="nav nav-pills">
						<li class="active"><a data-toggle="tab" href="#home">Purchase</a></li>
						<li><a data-toggle="tab" href="#menu2">Issue</a></li>
					</ul> -->
					<div class="tab-content white-box pad-5">
						<div id="home" class="tab-pane fade in active">
							<!-- <h3>Purchase</h3> -->
							<?php $this->load->view('purchase_sale/v_purchase');?>
						</div>
						<div id="menu2" class="tab-pane fade">
							<h3>Issue</h3>
							<?php $this->load->view('purchase_sale/v_issue');?>
						</div>
					</div>
					
					<div id="purchaseSale">
						
					</div>
			<!-- </div> -->
		</div>
	</div>
</div>
<script type="text/javascript">
	$(".nav-pills a").click(function(){
     	$(this).tab('show');
 	});
</script>
