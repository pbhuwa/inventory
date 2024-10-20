
<div class="row wb_form">
	<div class="col-sm-12">
		<div class="white-box">
			<div  id="FormDiv_item" class="formdiv frm_bdy issue_cons">
				<div class="tab-content white-box pad-5">
					<div id="home1" class="tab-pane fade in active">
						<p><?php $this->load->view('consumption/v_consumption_form');?></p>
					</div>
					<div id="menu21" class="tab-pane fade">
						<h3><?php echo $this->lang->line('current_stock'); ?>Current Stock</h3>
						<p><?php $this->load->view('consumption/v_current_stok');?></p>
					</div>
				</div>
				<div id="ConsumptionReport" id="displayReportDiv">
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