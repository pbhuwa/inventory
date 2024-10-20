<style>
	.ov_report_dtl .ov_lst_ttl { font-size:12px; margin-bottom: 5px; padding-bottom: 5px; border-bottom: 1px solid #efefef; }
	.ov_report_dtl .pm_data_tbl { width:100%; margin-bottom:10px; }
	.ov_report_dtl .pm_data_tbl td, .ov_report_dtl .pm_data_tbl td b { font-size:12px; }
	.ov_report_dtl .count { background-color:#e3e3e3; font-size:12px; padding:2px 5px; }
	
	table.ov_report_tbl { border-left:1px solid #e3e3e3; border-top:1px solid #e3e3e3; border-collapse:collapse; margin-bottom:10px; }
	table.ov_report_tbl thead th { text-align:left; background-color:#e3e3e3; padding:2px; font-size:12px; }
	table.ov_report_tbl tbody td { font-size:12px; border-right:1px solid #e3e3e3; border-bottom:1px solid #e3e3e3; line-height:13px; padding:2px; }
	.search_pm_data ul.pm_data li label{
		width: 150px;
	}
	.search_pm_data ul.pm_data li{
		font-size: 13px;
    	line-height: 17px;
    	display:table;
    	width:100%;
	}
	.search_pm_data ul.pm_data li label, .search_pm_data ul.pm_data li span{ display:table-cell; vertical-align: top; padding:4px 0; }
	.search_pm_data ul.pm_data { padding:5px 7px; }
	#barcodePrint{
		position: absolute;top: 0;right: 5px;    background-color: #03a9f3; border: 1px solid #03a9f3; color:#fff;
	}

	.ov_report_tabs #tab_selector { margin-bottom:5px; }

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
	.ov_report_tabs ul.nav-tabs li a { font-size:12px; padding:10px; }
	 }
	 @media only screen and (max-width:767px) {
	 	.ov_report_tabs ul.nav-tabs li a { font-size: 12px; padding: 10px 29px; }
	 }
	 @media only screen and (max-width:667px) {
	 	.ov_report_tabs ul.nav-tabs li { width:33.33333333%; }
	 	.ov_report_tabs ul.nav-tabs li a { padding:10px; text-align:center; }
	 	.search_pm_data ul.pm_data li.eqp_cod label, .search_pm_data ul.pm_data li.eqp_cod span { display:block; }
	 }
	 @media only screen and (max-width:414px) {
	 	.ov_report_tabs ul.nav-tabs li { width:50%; }
	 	.search_pm_data ul.pm_data { column-count: 1; }
	 }
	 #detl label{
	 	display: inline-block !important;
	 }
	 .life_cycle_table .tab-content{
	 	margin-top: 0px;
	 }
	 .life_cycle_table table.dataTable{
	 	margin-top: 0px;
	 }
	 .life_cycle_table .table-responsive + .table-responsive{
	 	margin-top: 0px;
	 }
	 #detl{
	 	/*margin-top: 10px;*/
	 	padding: 15px;
	 	background: #f7f7f7;
	 }
	 #detl ul{
	 	margin: 0px;
	 	padding: 0px;
	 	list-style: none;

	 }
	 #detl h4{
	 	margin-bottom: 15px;
	 }
	 #detl ul li{
	 	padding-left: 12px;
	 	padding-bottom: 5px;
	 	position: relative;
	 }
	 #detl ul li::before{
	 	position: absolute;
	 	content: "\f054";
	 	font-family:  "fontawesome";
	 	left: 0px;
	 	top: 3px;
	 	font-size: 8px;
	 }
</style>

<div class="ov_report_tabs pad-5 tabbable life_cycle_table">

<ul class="nav nav-tabs form-tabs hidden-xs">
    <!-- <li class="active"><a data-toggle="tab" href="#home">Home</a></li> -->
    <li class="tab-selector active"><a data-toggle="tab" href="#detl"><?php echo $this->lang->line('details'); ?></a></li>
    <li class="tab-selector"><a data-toggle="tab" href="#opn_stk"><?php echo $this->lang->line('opening_stock'); ?></a></li>
    <li class="tab-selector"><a data-toggle="tab" href="#pur_req"><?php echo $this->lang->line('purchase_requisition'); ?></a></li>
    <li class="tab-selector"><a data-toggle="tab" href="#pur_ord"><?php echo $this->lang->line('purchase_order'); ?></a></li>
    <li class="tab-selector"><a data-toggle="tab" href="#pur_rec"><?php echo $this->lang->line('purchase_received'); ?></a></li>
    <li class="tab-selector"><a data-toggle="tab" href="#pur_ret"><?php echo $this->lang->line('purchase_return'); ?></a></li>
    <li class="tab-selector"><a data-toggle="tab" href="#req"><?php echo $this->lang->line('demand_req'); ?></a></li>
    <li class="tab-selector"><a data-toggle="tab" href="#iss_sal"><?php echo $this->lang->line('issue_sales'); ?></a></li>
    <li class="tab-selector"><a data-toggle="tab" href="#chln"><?php echo $this->lang->line('challan'); ?></a></li>
     <li class="tab-selector"><a data-toggle="tab" href="#hand"><?php echo $this->lang->line('handover'); ?></a></li>
    <li class="tab-selector"><a data-toggle="tab" href="#cnvr"><?php echo $this->lang->line('conversion'); ?></a></li>
  </ul>
  <select class="mb10 form-control select2 visible-xs" id="tab_selector">
        <option value="0">Details</option>
        <option value="1">Opening Stock</option>
        <option value="2">Purchase Requisition</option>
        <option value="3">Purchase Order</option>
        <option value="4">Purchase Received</option>
        <option value="5">Purchase Return</option>
        <option value="6">Demand</option>
        <option value="7">Issue & Sales</option>
        <option value="8">Challan</option>
         <option value="8">Handover</option>
        <option value="10">Conversion</option> 
        

    </select>

  <div class="tab-content">
    <div id="detl" class="tab-pane fade in active">
      <h4 class="ov_lst_ttl"><b><?php echo $this->lang->line('item_detail'); ?></b></h4>
     
			 <div id="TableDiv">
      	<div class="table-responsive"  >
				<table class="table table-striped dataTable" id="Dtable" width="100%">
					<thead>
						<tr>
							<th width="5%"><?php echo $this->lang->line('sn'); ?></th>
							<th width="10%"><?php echo $this->lang->line('item_name'); ?></th>
							<th width="15%"><?php echo $this->lang->line('item_name_np'); ?></th>
							<th width="15%"><?php echo $this->lang->line('item_code'); ?></th>
							<th width="15%"><?php echo $this->lang->line('purchase_rate'); ?></th>
							<th width="10%"><?php echo $this->lang->line('sales_rate'); ?></th>
							<th width="10%"><?php echo $this->lang->line('reorder_level'); ?></th>
							<th width="10%"><?php echo $this->lang->line('max_limit'); ?></th>
							<th width="10%"><?php echo $this->lang->line('material_type'); ?></th>
							
						</tr>
					</thead>
					<tbody>
					<tr>
                            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                            <th width="10%"><?php echo $detail[0]->itli_itemname; ?></th>
                            <th width="15%"><?php echo $detail[0]->itli_itemnamenp; ?></th>
                            <th width="15%"><?php echo $detail[0]->itli_itemcode; ?></th>
                            <th width="15%"><?php echo $detail[0]->itli_purchaserate; ?></th>
                            <th width="10%"><?php echo $detail[0]->itli_salesrate; ?></th>
                            <th width="10%"><?php echo $detail[0]->itli_reorderlevel; ?></th>
                            <th width="10%"><?php echo $detail[0]->itli_maxlimit; ?></th>
                            <th width="10%"><?php echo $detail[0]->maty_material; ?></th>
                            
                        </tr>	
							
					</tbody>
				</table>
		</div>
		 <h4 class="ov_lst_ttl">Item price log</b></h4>
     
			 <div id="TableDiv">
      	<div class="table-responsive"  >
				<table class="table table-striped dataTable" id="Dtable" width="100%">
					<thead>
						<tr>
							<th width="5%"><?php echo $this->lang->line('sn'); ?></th>
							<th width="10%"><?php echo $this->lang->line('item_name'); ?></th>
							<th width="15%"><?php echo $this->lang->line('item_name_np'); ?></th>
							<th width="15%"><?php echo $this->lang->line('item_code'); ?></th>
							<th width="15%"><?php echo $this->lang->line('purchase_rate'); ?></th>
							<th width="10%"><?php echo $this->lang->line('sales_rate'); ?></th>
							<th width="10%"><?php echo $this->lang->line('reorder_level'); ?></th>
							<th width="10%"><?php echo $this->lang->line('max_limit'); ?></th>
							<th width="10%"><?php echo $this->lang->line('material_type'); ?></th>
							
						</tr>
					</thead>
					<tbody>
					<?php
							if(!empty($detail_log)){
								foreach ($detail_log as $key => $det_log) 
								{
									if(ITEM_DISPLAY_TYPE=='NP'){
                	$itpl_itemname = !empty($det_log->itpl_itemname)?$det_log->itpl_itemname:$det_log->itli_itemname;
                }else{ 
                    $itpl_itemname = !empty($det_log->itpl_itemname)?$det_log->itpl_itemname:'';
                }  
									?>
								<tr>
									<td><?php echo $key+1; ?></td>
									<!-- <td><?php echo $det_log->itli_itemcode; ?></td> -->
									<td><?php echo $itpl_itemname; ?></td>
									<td><?php echo $det_log->itpl_pricedatebs; ?></td>
									<td><?php echo $det_log->itpl_pricedatead; ?></td>
									<td><?php echo $det_log->itpl_stock; ?></td>
									<!-- <td><?php echo $det_log->trde_requiredqty; ?></td>
									<td><?php echo $det_log->trde_issueqty; ?></td> -->
									<td><?php echo $det_log->itpl_purrate; ?></td>

								</tr>	
							<?php }	}else{ ?>
						<tr>
						<td colspan="12" style="text-align: center;"><?php	echo "No Data"; ?>
						</td>
					</tr>
					<?php	}
						 ?>	
							
					</tbody>
				</table>
		</div>
    </div>
    <div id="opn_stk" class="tab-pane fade" >
      <!-- <h4 class="ov_lst_ttl"><b><?php echo $this->lang->line('opening_stock'); ?></b></h4> -->
      <div id="TableDiv">
      	<div class="table-responsive"  >
				<table class="table table-striped dataTable" id="Dtable" width="100%">
					<thead>
						<tr>
							<th width="5%"><?php echo $this->lang->line('sn'); ?></th>
							<th width="10%"><?php echo $this->lang->line('item_code'); ?></th>
							<th width="15%"><?php echo $this->lang->line('item_name'); ?></th>
							<th width="15%"><?php echo $this->lang->line('transaction_date_bs'); ?></th>
							<th width="15%"><?php echo $this->lang->line('transaction_date_ad'); ?></th>
							<th width="10%"><?php echo $this->lang->line('fiscal_year'); ?></th>
							<th width="10%"><?php echo $this->lang->line('req_qty'); ?></th>
							<th width="10%"><?php echo $this->lang->line('issue_qty'); ?></th>
							<th width="10%"><?php echo $this->lang->line('rate'); ?></th>
							
						</tr>
					</thead>
					<tbody>
						<?php
							if(!empty($opening)){
								foreach ($opening as $key => $op) 
								{
									if(ITEM_DISPLAY_TYPE=='NP'){
                	$req_itemname = !empty($op->itli_itemnamenp)?$op->itli_itemnamenp:$op->itli_itemname;
                }else{ 
                    $req_itemname = !empty($op->itli_itemname)?$op->itli_itemname:'';
                }  
									?>
								<tr>
									<td><?php echo $key+1; ?></td>
									<td><?php echo $op->itli_itemcode; ?></td>
									<td><?php echo $req_itemname; ?></td>
									<td><?php echo $op->trma_transactiondatebs; ?></td>
									<td><?php echo $op->trma_transactiondatead; ?></td>
									<td><?php echo $op->trma_fyear; ?></td>
									<td><?php echo $op->trde_requiredqty; ?></td>
									<td><?php echo $op->trde_issueqty; ?></td>
									<td><?php echo $op->trde_unitprice; ?></td>

								</tr>	
							<?php }	}else{ ?>
						<tr>
						<td colspan="12" style="text-align: center;"><?php	echo "No Data"; ?>
						</td>
					</tr>
					<?php	}
						 ?>
					</tbody>
				</table>
		</div>
    </div>
</div>
    <div id="pur_req" class="tab-pane fade">
      <!-- <h4 class="ov_lst_ttl"><b>Purchase Requisition</b></h4> -->
      <div id="TableDiv">
      <div class="table-responsive " >
				<table class="table table-striped dataTable" width="100%">
					<thead>
						<tr>
							<th width="5%">S.N.</th>
							<th width="10%">Item Code</th>
							<th width="15%">Item Name</th>
							<th width="15%">Purchase Req Date(B.S.)</th>
							<th width="15%">Purchase Req Date(A.D.)</th>
							<th width="10%">Fiscal Year</th>
							<th width="10%">Stock Qty</th>
							<th width="10%">Requisited Qty</th>
							<th width="10%">Rate</th>
							
						</tr>
					</thead>
					<tbody>
						<?php 
						if(!empty($pur_req)){
							foreach ($pur_req as $key => $pur) 
								{ 

									?>
								
								<tr>
									<td><?php echo $key+1; ?></td>
									<td><?php echo $pur->itli_itemcode; ?></td>
									<td>
									<?php 
										if(ITEM_DISPLAY_TYPE=='NP'){
					                	echo $pur->itli_itemnamenp?$pur->itli_itemnamenp:$pur->itli_itemname;
					                	}else{ 
					                    echo ($pur->itli_itemname)?$pur->itli_itemname:'';
					                	} 
					               	?>
									</td>
									<td><?php echo $pur->pure_reqdatebs; ?></td>
									<td><?php echo $pur->pure_reqdatead; ?></td>
									<td><?php echo $pur->pure_fyear; ?></td>
									<td><?php echo $pur->purd_stock; ?></td>
									<td><?php echo $pur->purd_qty; ?></td>
									<td><?php echo $pur->purd_rate; ?></td>
								</tr>
						<?php	}
						}else{ ?>
						<tr>
						<td colspan="12" style="text-align: center;"><?php	echo "No Data"; ?>
						</td>
					</tr>
					<?php	}

						?>
					</tbody>
				</table>
			</div>
      	</div>
    </div>
    <div id="pur_ord" class="tab-pane fade">
     <!--  <h4 class="ov_lst_ttl"><b>Purchase Order</b></h4> -->
     <div id="TableDiv">
      		<div class="table-responsive">
				<table class="table table-striped dataTable" width="100%">
					<thead>
						<tr>
							<th width="5%">S.N.</th>
							<th width="10%">Item Code</th>
							<th width="15%">Item Name</th>
							<th width="10%">Order Date(B.S.)</th>
							<th width="10%">Order Date(A.D.)</th>
							<th width="10%">Quantity</th>
							<th width="10%">Rate</th>
							<th width="10%">Discount</th>
							<th width="10%">Vat</th>
							<th width="10%">Amount</th>
							
						</tr>
					</thead>
					<tbody>
						<?php 
						if(!empty($order)){
							foreach ($order as $key => $ord) 
								{ 
									if(ITEM_DISPLAY_TYPE=='NP'){
                	$req_itemname = !empty($ord->itli_itemnamenp)?$ord->itli_itemnamenp:$ord->itli_itemname;
                }else{ 
                    $req_itemname = !empty($ord->itli_itemname)?$ord->itli_itemname:'';
                }  
                ?>
								
								<tr>
									<td><?php echo $key+1; ?></td>
									<td><?php echo $ord->itli_itemcode; ?></td>
									<td><?php echo $req_itemname; ?></td>
									<td><?php echo $ord->puor_orderdatebs; ?></td>
									<td><?php echo $ord->puor_orderdatead; ?></td>
									<td><?php echo $ord->pude_quantity; ?></td>
									<td><?php echo $ord->pude_rate; ?></td>
									<td><?php echo $ord->pude_discount; ?></td>
									<td><?php echo $ord->pude_vat; ?></td>
									<td><?php echo $ord->pude_amount; ?></td>
								</tr>
						<?php	}
						}else{ ?>
						<tr>
						<td colspan="12" style="text-align: center;"><?php	echo "No Data"; ?>
						</td>
					</tr>
					<?php	}

						?>
					</tbody>
				</table>
			</div>
     </div>
    </div>
    <div id="pur_rec" class="tab-pane fade">
     <!--  <h4 class="ov_lst_ttl"><b>Purchase Received</b></h4> -->
      
      <div class="table-responsive">
				<table class="table table-striped dataTable" width="100%">
					<thead>
						<tr>
							<th width="5%">S.N.</th>
							<th width="10%">Item Code</th>
							<th width="15%">Item Name</th>
							<th width="10%">Received Date(B.S.)</th>
							<th width="10%">Received Date(A.D.)</th>
							<th width="5%">Fiscal Year</th>
							<th width="7%">Received Qty</th>
							<th width="8%">Rate</th>
							<th width="10%">Selling Rate</th>
							<th width="5%">Discount</th>
							<th width="5%">VAT</th>
							<th width="10%">Amount</th>
							
						</tr>
					</thead>
					<tbody>
						<?php 
						if(!empty($pur_rec)){
							foreach ($pur_rec as $key => $pur) 
								{ 
									if(ITEM_DISPLAY_TYPE=='NP'){
                	$req_itemname = !empty($pur->itli_itemnamenp)?$pur->itli_itemnamenp:$pur->itli_itemname;
                }else{ 
                    $req_itemname = !empty($pur->itli_itemname)?$pur->itli_itemname:'';
                }  	

									?>
								
								<tr>
									<td><?php echo $key+1; ?></td>
									<td><?php echo $pur->itli_itemcode; ?></td>
									<td><?php echo $req_itemname; ?></td>
									<td><?php echo $pur->recm_receiveddatebs; ?></td>
									<td><?php echo $pur->recm_receiveddatead; ?></td>
									<td><?php echo $pur->recm_fyear; ?></td>
									<td><?php echo $pur->recd_purchasedqty; ?></td>
									<td><?php echo $pur->recd_unitprice; ?></td>
									<td><?php echo $pur->recd_salerate; ?></td>
									<td><?php echo $pur->recd_discountamt; ?></td>
									<td><?php echo $pur->recd_vatamt; ?></td>
									<td><?php echo $pur->recd_amount; ?></td>
								</tr>
						<?php	}
						}else{ ?>
						<tr>
						<td colspan="12" style="text-align: center;"><?php	echo "No Data"; ?>
						</td>
					</tr>
					<?php	}

						?>
					</tbody>
				</table>
			</div>
      <!-- <h4 class="ov_lst_ttl"><b>Direct Purchase</b></h4> -->
      	<div class="table-responsive">
				<table class="table table-striped dataTable" width="100%">
					<thead>
						<tr>
							<th width="5%">S.N.</th>
							<th width="10%">Item Code</th>
							<th width="15%">Item Name</th>
							<th width="10%">Received Date(B.S.)</th>
							<th width="10%">Received Date(A.D.)</th>
							<th width="5%">Fiscal Year</th>
							<th width="7%">Received Qty</th>
							<th width="8%">Rate</th>
							<th width="10%">Selling Rate</th>
							<th width="5%">Discount</th>
							<th width="5%">VAT</th>
							<th width="10%">Amount</th>
							
						</tr>
					</thead>
					<tbody>
						<?php 
						if(!empty($direct_pur)){
							foreach ($direct_pur as $key => $pur) 
								{ 
									if(ITEM_DISPLAY_TYPE=='NP'){
                	$req_itemname = !empty($pur->itli_itemnamenp)?$pur->itli_itemnamenp:$pur->itli_itemname;
                }else{ 
                    $req_itemname = !empty($pur->itli_itemname)?$pur->itli_itemname:'';
                }  	

									?>
								
								<tr>
									<td><?php echo $key+1; ?></td>
									<td><?php echo $pur->itli_itemcode; ?></td>
									<td><?php echo $req_itemname; ?></td>
									<td><?php echo $pur->recm_receiveddatebs; ?></td>
									<td><?php echo $pur->recm_receiveddatead; ?></td>
									<td><?php echo $pur->recm_fyear; ?></td>
									<td><?php echo $pur->recd_purchasedqty; ?></td>
									<td><?php echo $pur->recd_unitprice; ?></td>
									<td><?php echo $pur->recd_salerate; ?></td>
									<td><?php echo $pur->recd_discountamt; ?></td>
									<td><?php echo $pur->recd_vatamt; ?></td>
									<td><?php echo $pur->recd_amount; ?></td>
								</tr>
						<?php	}
						}else{ ?>
						<tr>
						<td colspan="12" style="text-align: center;"><?php	echo "No Data"; ?>
						</td>
					</tr>
					<?php	}

						?>
					</tbody>
				</table>
			</div>
    </div>

    <div id="pur_ret" class="tab-pane fade">
      <!-- <h4 class="ov_lst_ttl"><b>Purchase Return</b></h4> -->
      
     <div class="table-responsive">
				<table class="table table-striped dataTable" width="100%">
					<thead>
						<tr>
							<th width="5%">S.N.</th>
							<th width="10%">Item Code</th>
							<th width="15%">Item Name</th>
							<th width="10%">Return Date(B.S.)</th>
							<th width="10%">Return Date(A.D.)</th>
							<th width="10%">Fiscal Year</th>
							<th width="10%">Received Qty</th>
							<th width="10%">Returned Qty</th>
							<th width="10%">Purchased Rate</th>
							
						</tr>
					</thead>
					<tbody>
						<?php 
						if(!empty($return)){
							foreach ($return as $key => $ret) 
								{ 
									if(ITEM_DISPLAY_TYPE=='NP'){
                	$req_itemname = !empty($ret->itli_itemnamenp)?$ret->itli_itemnamenp:$ret->itli_itemname;
                }else{ 
                    $req_itemname = !empty($ret->itli_itemname)?$ret->itli_itemname:'';
                }  	
									?>
								
								<tr>
									<td><?php echo $key+1; ?></td>
									<td><?php echo $ret->itli_itemcode; ?></td>
									<td><?php echo $req_itemname; ?></td>
									<td><?php echo $ret->purr_returndatebs; ?></td>
									<td><?php echo $ret->purr_returndatead; ?></td>
									<td><?php echo $ret->purr_fyear; ?></td>
									<td><?php echo $ret->prde_receivedqty; ?></td>
									<td><?php echo $ret->prde_returnqty; ?></td>
									<td><?php echo $ret->prde_purchaserate; ?></td>
								</tr>
						<?php	}
						}else{ ?>
						<tr>
						<td colspan="12" style="text-align: center;"><?php	echo "No Data"; ?>
						</td>
					</tr>
					<?php	}

						?>
					</tbody>
				</table>
			</div>
    </div>
    <div id="req" class="tab-pane fade">
     <!--  <h4 class="ov_lst_ttl"><b>Requisition</b></h4> -->
      
      <div class="table-responsive">
				<table class="table table-striped dataTable" width="100%">
					<thead>
						<tr>
							<th width="5%">S.N.</th>
							<th width="15%">Item Code</th>
							<th width="20%">Item Name</th>
							<th width="15%">Requisition Date(B.S.)</th>
							<th width="15%">Requisition Date(A.D.)</th>
							<th width="15%">Fiscal Year</th>
							<th width="15%">Requisited Qty</th>
							
						</tr>
					</thead>
					<tbody>
						<?php 
						if(!empty($requisition)){
							foreach ($requisition as $key => $req) 
								{ 
									if(ITEM_DISPLAY_TYPE=='NP'){
                	$req_itemname = !empty($req->itli_itemnamenp)?$req->itli_itemnamenp:$req->itli_itemname;
                }else{ 
                    $req_itemname = !empty($req->itli_itemname)?$req->itli_itemname:'';
                }  	
									?>
								
								<tr>
									<td><?php echo $key+1; ?></td>
									<td><?php echo $req->itli_itemcode; ?></td>
									<td><?php echo $req_itemname; ?></td>
									<td><?php echo $req->rema_reqdatebs; ?></td>
									<td><?php echo $req->rema_reqdatead; ?></td>
									<td><?php echo $req->rema_fyear; ?></td>
									<td><?php echo $req->rede_qty; ?></td>
									
								</tr>
						<?php	}
						}else{ ?>
						<tr>
						<td colspan="12" style="text-align: center;"><?php	echo "No Data"; ?>
						</td>
					</tr>
					<?php	}

						?>
					</tbody>
				</table>
			</div>
    </div>
    <div id="iss_sal" class="tab-pane fade">
      <!-- <h4 class="ov_lst_ttl"><b>Issue and Issue Details</b></h4> -->
       <div class="table-responsive">
				<table class="table table-striped dataTable" width="100%">
					<thead>
						<tr>
							<th width="5%">S.N.</th>
							<th width="10%">Item Code</th>
							<th width="15%">Item Name</th>
							<th width="10%">Issue Date(B.S.)</th>
							<th width="10%">Issue Date(A.D.)</th>
							<th width="10%">Fiscal Year</th>
							<th width="10%">Sales Qty</th>
							<th width="10%">Stock Qty</th>
							<th width="10%">Rate</th>
							<th width="10%">Is Cancelled</th>
							
						</tr>
					</thead>
					<tbody>
						<?php 
						if(!empty($issue)){
							foreach ($issue as $key => $req) 
								{ 
									if(ITEM_DISPLAY_TYPE=='NP'){
                	$req_itemname = !empty($req->itli_itemnamenp)?$req->itli_itemnamenp:$req->itli_itemname;
                }else{ 
                    $req_itemname = !empty($req->itli_itemname)?$req->itli_itemname:'';
                }  	
									?>
								
								<tr>
									<td><?php echo $key+1; ?></td>
									<td><?php echo $req->itli_itemcode; ?></td>
									<td><?php echo $req_itemname; ?></td>
									<td><?php echo $req->sama_billdatebs; ?></td>
									<td><?php echo $req->sama_billdatead; ?></td>
									<td><?php echo $req->sama_fyear; ?></td>
									<td><?php echo $req->sade_qty; ?></td>
									<td><?php echo $req->sade_curqty; ?></td>
									<td><?php echo $req->sade_unitrate; ?></td>
									<td><?php if($req->sade_iscancel=='Y')
									{echo "Yes";}else{echo "No";} ?></td>
									
								</tr>
						<?php	}
						}else{ ?>
						<tr>
						<td colspan="12" style="text-align: center;"><?php	echo "No Data"; ?>
						</td>
					</tr>
					<?php	}

						?>
					</tbody>
				</table>
			</div>
      <h4 class="ov_lst_ttl"><b>Sales Return</b></h4>
      
      <div class="table-responsive">
				<table class="table table-striped dataTable" width="100%">
					<thead>
						<tr>
							<th width="5%">S.N.</th>
							<th width="10%">Item Code</th>
							<th width="15%">Item Name</th>
							<th width="10%">Return Date(B.S.)</th>
							<th width="10%">Return Date(A.D.)</th>
							<th width="10%">Fiscal Year</th>
							<th width="10%">Return Qty</th>
							<th width="10%">Rate</th>
							<th width="10%">Total</th>
							<th width="10%">Is Cancelled</th>
							
						</tr>
					</thead>
					<tbody>
						<?php 
						if(!empty($sales_return)){
							foreach ($sales_return as $key => $req) 
								{
									if(ITEM_DISPLAY_TYPE=='NP'){
                	$req_itemname = !empty($req->itli_itemnamenp)?$req->itli_itemnamenp:$req->itli_itemname;
                }else{ 
                    $req_itemname = !empty($req->itli_itemname)?$req->itli_itemname:'';
                }  	
								 ?>
								
								<tr>
									<td><?php echo $key+1; ?></td>
									<td><?php echo $req->itli_itemcode; ?></td>
									<td><?php echo $req_itemname; ?></td>
									<td><?php echo $req->rema_returndatebs; ?></td>
									<td><?php echo $req->rema_returndatead; ?></td>
									<td><?php echo $req->rema_fyear; ?></td>
									<td><?php echo $req->rede_qty; ?></td>
									<td><?php echo $req->rede_unitprice; ?></td>
									<td><?php echo $req->rede_total; ?></td>
									<td><?php if($req->rede_iscancel=='Y')
									{echo "Yes";}else{echo "No";} ?></td>
									
								</tr>
						<?php	}
						}else{ ?>
						<tr>
						<td colspan="12" style="text-align: center;"><?php	echo "No Data"; ?>
						</td>
					</tr>
					<?php	}

						?>
					</tbody>
				</table>
			</div>
    </div>
    <div id="chln" class="tab-pane fade">
     <!--  <h4 class="ov_lst_ttl"><b>Challan</b></h4> -->
      
       <div class="table-responsive">
				<table class="table table-striped dataTable" width="100%">
					<thead>
						<tr>
							<th width="5%">S.N.</th>
							<th width="10%">Item Code</th>
							<th width="25%">Item Name</th>
							<th width="15%">Challan Date(B.S.)</th>
							<th width="15%">Challan Date(A.D.)</th>
							<th width="10%">Challan Qty</th>
							<th width="10%">Is Cancelled</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						if(!empty($challan)){
							foreach ($challan as $key => $chln) 
								{ 
									if(ITEM_DISPLAY_TYPE=='NP'){
                	$req_itemname = !empty($chln->itli_itemnamenp)?$chln->itli_itemnamenp:$chln->itli_itemname;
                }else{ 
                    $req_itemname = !empty($chln->itli_itemname)?$chln->itli_itemname:'';
                }  	
									?>
								
								<tr>
									<td><?php echo $key+1; ?></td>
									<td><?php echo $chln->itli_itemcode; ?></td>
									<td><?php echo $req_itemname; ?></td>
									<td><?php echo $chln->chma_challanrecdatebs; ?></td>
									<td><?php echo $chln->chma_challanrecdatead; ?></td>
									<td><?php echo $chln->chde_qty; ?></td>
									
									<td><?php if($chln->chde_receivecomplete=='Y')
									{echo "Yes";}else{echo "No";} ?></td>
									
								</tr>
						<?php	}
						}else{ ?>
						<tr>
						<td colspan="12" style="text-align: center;"><?php	echo "No Data"; ?>
						</td>
					</tr>
					<?php	}

						?>
					</tbody>
				</table>
			</div>
    </div>
    <div id="cnvr" class="tab-pane fade">
     <!--  <h4 class="ov_lst_ttl"><b>Conversion In</b></h4> -->
      <div class="table-responsive">
				<table class="table table-striped dataTable" width="100%">
					<thead>
						<tr>
							<th width="5%">S.N.</th>
							<th width="10%">Item Code</th>
							<th width="25%">Item Name</th>
							<th width="15%">Conversion Date(B.S.)</th>
							<th width="15%">Conversion Date(A.D.)</th>
							<th width="10%">Conversion Qty</th>
							<th width="10%">Rate</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						if(!empty($conv_in)){
							foreach ($conv_in as $key => $conv) 
								{ 
									if(ITEM_DISPLAY_TYPE=='NP'){
                	$req_itemname = !empty($conv->itli_itemnamenp)?$conv->itli_itemnamenp:$conv->itli_itemname;
                }else{ 
                    $req_itemname = !empty($conv->itli_itemname)?$conv->itli_itemname:'';
                }  	
									?>
								
								<tr>
									<td><?php echo $key+1; ?></td>
									<td><?php echo $conv->itli_itemcode; ?></td>
									<td><?php echo $req_itemname; ?></td>
									<td><?php echo $conv->conv_condatebs; ?></td>
									<td><?php echo $conv->conv_condatead; ?></td>
									<td><?php echo $conv->conv_childqty; ?></td>
									<td><?php echo $conv->conv_childrate; ?></td>
									
									
									
									
								</tr>
						<?php	}
						}else{ ?>
						<tr>
						<td colspan="12" style="text-align: center;"><?php	echo "No Data"; ?>
						</td>
					</tr>
					<?php	}

						?>
					</tbody>
				</table>
			</div>
      <!-- <h4 class="ov_lst_ttl"><b>Conversion Out</b></h4> -->
      
       <div class="table-responsive">
				<table class="table table-striped dataTable" width="100%">
					<thead>
						<tr>
							<th width="5%">S.N.</th>
							<th width="10%">Item Code</th>
							<th width="25%">Item Name</th>
							<th width="15%">Conversion Date(B.S.)</th>
							<th width="15%">Conversion Date(A.D.)</th>
							<th width="10%">Conversion Qty</th>
							<th width="10%">Rate</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						if(!empty($conv_out)){
							foreach ($conv_out as $key => $conv) 
								{ 
									if(ITEM_DISPLAY_TYPE=='NP'){
                	$req_itemname = !empty($conv->itli_itemnamenp)?$conv->itli_itemnamenp:$conv->itli_itemname;
                }else{ 
                    $req_itemname = !empty($conv->itli_itemname)?$conv->itli_itemname:'';
                }  	
									?>
								
								<tr>
									<td><?php echo $key+1; ?></td>
									<td><?php echo $conv->itli_itemcode; ?></td>
									<td><?php echo $req_itemname; ?></td>
									<td><?php echo $conv->conv_condatebs; ?></td>
									<td><?php echo $conv->conv_condatead; ?></td>
									<td><?php echo $conv->conv_parentqty; ?></td>
									<td><?php echo $conv->conv_parentrate; ?></td>
									
									
									
									
								</tr>
						<?php	}
						}else{ ?>
						<tr>
						<td colspan="12" style="text-align: center;"><?php	echo "No Data"; ?>
						</td>
					</tr>
					<?php	}

						?>
					</tbody>
				</table>
			</div>
    </div>
    
  </div> 
</div>
<?php if(!empty($expenses_sum)):?>
<span>Total Expenses: </span><?php echo !empty($expenses_sum[0]->total_expenses)?$expenses_sum[0]->total_expenses:'0'; ?>
<?php endif; ?>