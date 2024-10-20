<div class="white-box chart-box">

    <div class="row">

        <div class="pad-5">

	        <div class="col-lg-12 col-sx-12">

	           <h3 class="box-title">Constant List</h3>

				<div class="table-responsive pad-5">
			 		
			 		<a href="javascript:void(0)" class="pull-right btn btn-sm btn-success btnRefresh"><i class="fa fa-refresh" aria-hidden="true" ></i></a>
			 		
		            <input type="hidden" id="ListUrl" value="<?php echo base_url('/settings/constant/reload_constant_list'); ?>">

		            <div id="TableDiv">
		  				<?php echo $this->view('settings/constant/v_constant_table'); ?>
						
					</div>

				</div>

			</div>

   		</div>

	</div>

</div>
