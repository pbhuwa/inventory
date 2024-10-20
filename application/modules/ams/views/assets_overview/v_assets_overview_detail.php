<style>
	.ov_report_dtl .ov_lst_ttl {
		font-size: 12px;
		margin-bottom: 5px;
		padding-bottom: 5px;
		border-bottom: 1px solid #efefef;
	}

	.ov_report_dtl .pm_data_tbl {
		width: 100%;
		margin-bottom: 10px;
	}

	.ov_report_dtl .pm_data_tbl td,
	.ov_report_dtl .pm_data_tbl td b {
		font-size: 12px;
	}

	.ov_report_dtl .count {
		background-color: #e3e3e3;
		font-size: 12px;
		padding: 2px 5px;
	}



	table.ov_report_tbl {
		border-left: 1px solid #e3e3e3;
		border-top: 1px solid #e3e3e3;
		border-collapse: collapse;
		margin-bottom: 10px;
	}

	table.ov_report_tbl thead th {
		text-align: left;
		background-color: #e3e3e3;
		padding: 2px;
		font-size: 12px;
	}

	table.ov_report_tbl tbody td {
		font-size: 12px;
		border-right: 1px solid #e3e3e3;
		border-bottom: 1px solid #e3e3e3;
		line-height: 13px;
		padding: 2px;
	}

	.search_pm_data ul.pm_data li label {

		width: 150px;

	}

	.search_pm_data ul.pm_data li {

		font-size: 13px;

		line-height: 17px;

		display: table;

		width: 100%;

	}

	.search_pm_data ul.pm_data li label,
	.search_pm_data ul.pm_data li span {
		display: table-cell;
		vertical-align: top;
		padding: 4px 0;
	}

	.search_pm_data ul.pm_data {
		padding: 5px 7px;
	}

	#barcodePrint {

		position: absolute;
		top: 0;
		right: 5px;
		background-color: #03a9f3;
		border: 1px solid #03a9f3;
		color: #fff;

	}



	.ov_report_tabs #tab_selector {
		margin-bottom: 5px;
	}



	.ov_report_tabs #tab_selector {

		border: none;

		background-color: #00663f;

		background: -webkit-linear-gradient(#00b588, #017558);

		background: -o-linear-gradient(#00b588, #017558);

		background: -moz-linear-gradient(#00b588, #017558);

		background: linear-gradient(#00b588, #017558);

		color: #fff;

	}

	.ov_report_tabs #tab_selector option {

		color: #444;

	}



	@media only screen and (max-width:991px) {

		.ov_report_tabs ul.nav-tabs li a {
			font-size: 12px;
			padding: 10px;
		}

	}

	@media only screen and (max-width:767px) {

		.ov_report_tabs ul.nav-tabs li a {
			font-size: 12px;
			padding: 10px 29px;
		}
		.search_pm_data ul.pm_data {
			    -webkit-column-count: 2;
    -moz-column-count: 2;
    column-count: 2;
		}

	}

	@media only screen and (max-width:667px) {

		.ov_report_tabs ul.nav-tabs li {
			width: 33.33333333%;
		}

		.ov_report_tabs ul.nav-tabs li a {
			padding: 10px;
			text-align: center;
		}

		.search_pm_data ul.pm_data li.eqp_cod label,
		.search_pm_data ul.pm_data li.eqp_cod span {
			display: block;
		}

	}

	@media only screen and (max-width:414px) {

		.ov_report_tabs ul.nav-tabs li {
			width: 50%;
		}

		.search_pm_data ul.pm_data {
			column-count: 1;
		}

	}
</style>


<div class="ov_report_tabs pad-5 tabbable">



	<ul class="nav nav-tabs form-tabs hidden-xs">

		<li class="tab-selector active "><a data-toggle="tab" href="#dtl_detail">Details</a></li>

		<li class="tab-selector "><a data-toggle="tab" href="#rep_lease">Lease</a></li>

		<li class="tab-selector"><a data-toggle="tab" href="#rep_insurance">Insurance</a></li>

		<li class="tab-selector"><a data-toggle="tab" href="#pm_amc_report">PM/AMC</a></li>

		<li class="tab-selector"><a data-toggle="tab" href="#depreciation_tbl">Depreciation</a></li>

		<li class="tab-selector"><a data-toggle="tab" href="#transfer_report">Transfer</a></li>

		<li class="tab-selector"><a data-toggle="tab" href="#maintainance">Maintainance Log</a></li>



	</ul>



	<select class="mb10 form-control select2 visible-xs" id="tab_selector">

		<option value="0" id="#dtl_detail">Details</option>

		<option value="1" id="#rep_lease">Lease</option> 

		<option value="2" id="#rep_insurance">Insurance</option>

		<option value="3" id="#pm_amc_report">PM/AMC</option>

		<option value="4" id="#depreciation_tbl">Depriciation</option>

		<option value="5" >Assign</option>

		<option value="6" id="#transfer_report">Transfer</option>

		<option value="7" id="#maintainance" >Maintanance</option>

		<option value="8">Print Preview</option>

	</select>



	<div class="tab-content white-box pad-5 ">

		<div id="dtl_detail" class="tab-pane fade in active  ">

			<?php 
			if(ORGANIZATION_NAME=='KU' || ORGANIZATION_NAME=='ARMY' ){
				$this->load->view(REPORT_SUFFIX.'/v_assets_detail_basic_view');
			}else{
				$this->load->view('v_assets_detail_basic_view');
			}

			 ?>

		</div>



		<div id="rep_lease" class="tab-pane fade  ">

			<?php $this->load->view('v_assets_lease_view') ?>

		</div>

		<div id="rep_insurance" class="tab-pane fade ">

			<?php $this->load->view('v_assets_insurance_view') ?>

		</div>

		<div id="pm_amc_report" class="tab-pane fade ">

			<h5 class="ov_lst_ttl"><b>PM/AMC</b></h5>

		</div>

		<div id="depreciation_tbl" class="tab-pane fade ">

			<h5 class="ov_lst_ttl"><b>Depreciation</b></h5>

			<?php $this->load->view('v_assets_depreciation_view') ?>

		</div>

		<div id="transfer_report" class="tab-pane fade ">

			<?php 
			if(ORGANIZATION_NAME=='KU'){
				$this->load->view('ku/v_assets_transfer_view'); 
				}else{
				$this->load->view('v_assets_transfer_view'); 		
				}
			

			?>

		</div>



		<div id="maintainance" class="tab-pane fade ">

			<h5 class="ov_lst_ttl"><b>Maintance Log</b></h5>

		</div>

	</div>

</div>

<script type="text/javascript">
	$(document).off('click','.nav.nav-tabs li a');
	$(document).on('click', '.nav.nav-tabs li a' , function(){
		var link = $(this).attr('href');
		$(link).addClass('in active');
		$(link).siblings().removeClass('in active')
	} );
	$(document).off('change','#tab_selector');
	$(document).on('change', '#tab_selector' , function(){
		var link = $('#tab_selector option:selected').attr('id');
		console.log(link); 
		$(link).addClass('in active');
		$(link).siblings().removeClass('in active')
	} )
</script>