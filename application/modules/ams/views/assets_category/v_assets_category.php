<div class="white-box chart-box">

    <div class="row">

        <div class="pad-5">

	        <div class="col-lg-8 col-sx-8">

	           <h3 class="box-title">Assets Category</h3>

				<div class="table-responsive pad-5">
			 		
			 		<a href="javascript:void(0)" class="pull-right btn btn-sm btn-success btnRefresh"><i class="fa fa-refresh" aria-hidden="true" ></i></a>
			 		<input type="hidden" id="ListUrl" value="<?php echo !empty($listurl)?$listurl:''; ?>">
		            <form action="<?php echo base_url('ams/asset_category/update_category'); ?>" method="post" id="formCatUpdate">
		            <div id="TableDiv">

	<?php echo $this->load->view('v_assets_cat_dep_list'); ?>

</div>
</form>
</div>

</div>

</div>

</div>

</div>
