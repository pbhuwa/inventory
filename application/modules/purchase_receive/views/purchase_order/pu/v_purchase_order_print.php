<style>
	.table_jo_header,
	.jo_tbl_head,
	.jo_table,
	.jo_footer {
		width: 100%;
		font-size: 12px;
		border-collapse: collapse;
	}

	.table_jo_header {
		width: 100%;
		vertical-align: top;
		font-size: 12px;
	}

	.table_jo_header td.text-center {
		text-align: center;
	}

	.table_jo_header td.text-right {
		text-align: right;
	}

	h4 {
		font-size: 18px;
		margin: 0;
	}

	.table_jo_header u {
		text-decoration: underline;
		padding-top: 15px;
	}

	.jo_table {
		border-right: 1px solid #333;
		border-bottom: 1px solid #000;
		margin-top: 5px;
	}

	.jo_table tr th {
		border-top: 1px solid #333;
		border-bottom: 1px solid #333;
		border-left: 1px solid #333;
	}

	.jo_table tr th {
		padding: 5px 3px;
	}

	.jo_table tr td {
		padding: 3px 3px;
		height: 15px;
		border-left: 1px solid #333;
		font-size: 12px;
	}

	.jo_table tr td span {
		font-size: 12px;
	}

	.jo_footer {
		vertical-align: top;
	}

	.jo_footer td {
		padding: 10px 10px !important;
	}

	.bdr-table {
		border: 1px solid #000;
	}

	.tableWrapper {
		min-height: 25%;
		height: 25vh;
		max-height: 100vh;
		white-space: nowrap;
		display: table;
		width: 100%;
		/*overflow-y: auto;*/
	}

	.table_item {
		height: 100%;
	}

	.table_item .td_cell {
		padding: 5px;
		margin: 5px;
	}

	.table_item .td_empty {
		height: 100% !important;
		padding: 12% 0;
	}

	.padd-25 {
		padding-top: 25px;
	}

	.itemInfo .td_cell {
		padding: 5px;
		margin: 5px;
		text-align: center;
		font-size: bold;
	}

	th.td_cell {
		font-weight: bold;
	}

	.amount-table {
		border-collapse: collapse;
		border: 1px solid #000;
		border-top: 0px;
		margin: 0px;
		margin-top: 5px;

	}

	.amount-table tbody tr td {
		border-bottom: 1px solid #000;
		border-right: 1px solid #000;
		font-size: 12px;
		padding: 5px 15px;
	}

	.amount-table tbody tr td span {
		font-size: 12px;
		display: inline-block;
		margin: 0px;
		padding: 0px;
	}

	.amount-table tbody tr td:first-child {
		border: 1px solid #000;
		border-top: 0px;
	}

	.footerWrapper {
		page-break-inside: avoid;
	}

	.dateDashedLine {
		min-width: 100px;
		display: inline-block;
		border-bottom:  1px dashed #333;
		/*border-top: none;*/
	}

	.signatureDashedLine {
		min-width: 170px;
		display: inline-block;
		border: 1px dashed #333;
	}


</style>

<div class="jo_form organizationInfo">
	<div class="headerWrapper">

		<?php

		$header['old_report_no'] = 'पोवि फाराम नं ';
		$header['report_title'] = 'खरिद आदेश';
		$this->load->view('common/v_print_report_header', $header);
		?>

		<table width="100%">
			<?php
			$budget_code='';
			$budget_name='';
			$buget_id= !empty($order_details[0]->puor_budgetid)?$order_details[0]->puor_budgetid:'';
			if(!empty($buget_id)){
				$db_buget_data=$this->general->get_tbl_data('budg_code,budg_budgetname','budg_budgets',array('budg_budgetid'=>$buget_id));
				if(!empty($db_buget_data)){
					$budget_code=!empty($db_buget_data[0]->budg_code)?$db_buget_data[0]->budg_code:'';
					$budget_name=!empty($db_buget_data[0]->budg_budgetname)?$db_buget_data[0]->budg_budgetname:'';
				}
			}
			$supplierid = !empty($report_data['supplier']) ? $report_data['supplier'] : '';
			$supplier_data =  $this->general->get_tbl_data('*', 'dist_distributors', array('dist_distributorid' => $supplierid), false, 'DESC');
			$suppliername = !empty($supplier_data[0]->dist_distributor) ? $supplier_data[0]->dist_distributor : '';
			$supplieraddress = !empty($supplier_data[0]->dist_address1) ? $supplier_data[0]->dist_address1 : '';
			$supplierregno = !empty($supplier_data[0]->dist_govtregno) ? $supplier_data[0]->dist_govtregno : '';
			$supplierpanno = !empty($supplier_data[0]->dist_panvatno) ? $supplier_data[0]->dist_panvatno : '';
			$supplierphone = !empty($supplier_data[0]->dist_phone1) ? $supplier_data[0]->dist_phone1 : '';
			echo $supplierphone;
			?>
			<?php
			if ($order_details) {
				$delivery_date = !empty($order_details[0]->puor_deliverydatebs) ? $order_details[0]->puor_deliverydatebs : '';
				$delivery_site = !empty($order_details[0]->puor_deliverysite) ? $order_details[0]->puor_deliverysite : '';
			} else {
				$delivery_date = !empty($report_data['delevery_date']) ? $report_data['delevery_date'] : '';
				$delivery_site = !empty($report_data['delevery_site']) ? $report_data['delevery_site'] : '';
			}
			if(!empty($supplierid )):
			?>
			<tr>
				<td style="font-size: 12px;">
					<span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">श्री</span>
					<span style="border-bottom:1px dashed #333">
						<?php if ($order_details) {
							echo !empty($order_details[0]->dist_distributor) ? $order_details[0]->dist_distributor : '';
						} else {
							echo $suppliername;
						} ?>
					</span>
				</td>
				<td></td>
				
			</tr>

			<tr>
			
				<td style="font-size: 12px;"><span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">ठेगाना:</span>
					<span style="border-bottom:1px dashed #333">
						<?php if ($order_details) {
							echo !empty($order_details[0]->dist_address1) ? $order_details[0]->dist_address1 : '';
						} else {
							echo $supplieraddress;
						} ?>
					</span>
				</td>
				<td></td>
				
			</tr>
		<?php endif; ?>
			<tr>
				
				<td style="font-size: 12px;">
					<?php if(!empty($supplierid )): ?>
					<span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">करदाता नं.</span>
					<span style="border-bottom:1px dashed #333">
						<?php if ($order_details) {
							echo !empty($order_details[0]->dist_govtregno) ? $order_details[0]->dist_govtregno : '';
						} else {
							echo $supplierregno;
						} ?>
					</span>
					 <?php endif; ?>
				</td>
				
				<td class="text-left" width="25%" style="font-size: 12px;"><span style="text-align: left;font-size: 12px;" class=""><strong>खरिद आदेश नं: </strong>
						<?php if ($order_details) {
							echo !empty($order_details[0]->puor_orderno) ? $order_details[0]->puor_orderno : '';
						} ?>
				</td>
			</tr>

			<tr>
				
				<td style="font-size: 12px;">
					<?php if(!empty($supplierid )): ?>
					<span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">TPIN/PIN</span> :
					<span style="border-bottom:1px dashed #333">
						
					</span>
				    <?php endif; ?>
				</td>
				
				<td class="text-left" width="25%" style="font-size: 12px;"><span style="text-align: left;font-size: 12px;" class=""><strong>मिति: </strong>
						<?php
						if ($order_details) {
							echo !empty($order_details[0]->puor_orderdatebs) ? $order_details[0]->puor_orderdatebs : '';
						}
						?>
				</td>
			</tr>
		</table>
	</div>

	<table style="margin: 10px 0px;">
		<tr>
			<td style="font-size: 12px;white-space: nowrap;">
				<span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">देहाय बमोजिमका सामानहरू भण्डारमा न्यून मौज्दातमा रहेको वा कार्यालय संचालनका लागि आवश्यकता पर्न गएकोले खरिद व्यवस्थाका लागि पेश गरिएको छ।</span>
				
			</td>
			<td>&nbsp;</td>
		</tr>
	</table>
	<div class="tableWrapper" style="margin-top: 0px;">
		<table class="jo_table itemInfo table_item" border="1">
			<thead>
				<tr>
					<th rowspan="2" width="2%" class="td_cell"> क्र. सं. </th>
					<th rowspan="2" width="13%" class="td_cell"> बजेट शिर्षक </th>
					<th rowspan="2"  width="25%" class="td_cell" > विवरण </th>
					<th rowspan="2"  width="20%" class="td_cell"> स्पेसिफिकेसन </th>
					<th rowspan="2" width="8%" class="td_cell"> सामानको परिमाण </th>
					<th rowspan="2"  width="8%" class="td_cell"> इकाई </th>
					<th colspan="2"  width="20%" class="td_cell"> मुल्य </th>
					<th rowspan="2"  width="10%" class="td_cell"> कैफियत </th>
				</tr>
				<tr ><th rowspan="2" width="8%"  class="td_cell">दर</th>
					<th rowspan="2" width="10%" class="td_cell">जम्मा रकम</th>
				</tr>

				<!-- <tr>
					<td class="td_cell">१</td>
					<td class="td_cell">२</td>
					<td class="td_cell">३</td>
					<td class="td_cell">४</td>
					<td class="td_cell">५</td>
					<td class="td_cell">६</td>
					<td class="td_cell">७</td>
					<td class="td_cell">८</td>
					<td class="td_cell">९</td>
				</tr> -->
			</thead>
			<tbody>
				<?php
				$sub_total = 0;
				if ($order_details) { //echo"<pre>"; print_r($order_details);die;
					foreach ($order_details as $key => $dprint) { ?>
						<tr>
							<td class="td_cell" >
								<?php echo $key + 1; ?>
							</td>
							<td class="td_cell" style="text-align:left" >
								<?php echo !empty($dprint->eqca_code_manual) ? $dprint->eqca_code_manual : ''; ?>
							</td>

							<td class="td_cell" style="text-align:left" >
								<?php
								if (ITEM_DISPLAY_TYPE == 'NP') {
									echo !empty($dprint->itli_itemnamenp) ? $dprint->itli_itemnamenp : $dprint->itli_itemname;
								} else {
									echo  !empty($dprint->itli_itemname) ? $dprint->itli_itemname : '';
								}
								?> 
							</td>
							<td style="text-align:left">
								<?php echo !empty($dprint->pude_remarks) ? $dprint->pude_remarks : ''; ?>
							</td>


							<td class="td_cell">
								<?php $pqty= !empty($dprint->pude_quantity) ? $dprint->pude_quantity : 0; 
									echo sprintf('%g',$pqty);
								?>
							</td>

							<td class="td_cell">
								<?php echo !empty($dprint->unit_unitname) ? $dprint->unit_unitname : ''; ?>
							</td>

							<td class="td_cell" style="text-align: right;">
								<?php echo !empty($dprint->pude_rate) ? number_format($dprint->pude_rate, 2) : 0; ?>
							</td>
							<td class="td_cell" style="text-align: right;">
								<?php
								$qty = !empty($dprint->pude_quantity) ? $dprint->pude_quantity : 0;
								$rate = !empty($dprint->pude_rate) ? $dprint->pude_rate : 0;
								$amt = $qty * $rate;
								echo !empty($amt) ? number_format($amt, 2) : 0;
								?>
							</td>
							<td class="td_cell">
								
							</td>
						</tr>

					<?php
						$sub_total += $amt;
					}
					?>

					<?php
					$row_count = count($order_details);

					
					if ($row_count < 12) :
					?>
						<tr>
							<td class="td_empty"></td>
							<td class="td_empty"></td>
							<td class="td_empty"></td>
							<td class="td_empty"></td>
							<td class="td_empty"></td>
							<td class="td_empty"></td>
							<td class="td_empty"></td>
							<td class="td_empty"></td>
							<td class="td_empty"></td>
						</tr>
					<?php endif; ?>
				<?php } ?>
				<tr>
				<td colspan="5" style="text-align: right">
					<span class="<?php echo FONT_CLASS; ?>"><strong>जम्मा</strong> </span>
				</td>
				<td colspan="4" style="text-align: right;"><?php echo !empty($sub_total) ? number_format($sub_total, 2) : ''; ?></td>
			</tr>
			<tr>
				<td  colspan="5" style="text-align: right">
					<span class=""><strong>कर (१३%)</strong> </span>
				</td>
				<td   colspan="4" style="text-align: right;"><?php echo !empty($order_details[0]->puor_vatamount) ? number_format($order_details[0]->puor_vatamount, 2) : ''; ?></td>
			</tr>

			<tr>
				<td colspan="5" style="text-align: right">
					<span class="<?php echo FONT_CLASS; ?>"><strong>कुल जम्मा</strong> </span>
				</td>
				<td  colspan="4" style="text-align: right;">
					<?php echo !empty($order_details[0]->puor_amount) ? number_format($order_details[0]->puor_amount, 2) : ''; ?>
				</td>
			</tr>
			<tr>
				<td colspan="9" style="overflow-wrap: break-word;white-space: nowrap;text-align: center;"><strong>शब्दमा :
					<?php
					$total = !empty($order_details[0]->puor_amount) ? $order_details[0]->puor_amount : 0;
					if ($total) {
						echo $this->general->number_to_word($total);
					}
					?>
				</strong>
				</td>
			</tr>
			</tbody>
		</table>
	</div>

	<div class="footerWrapper">
		<table style="width: 100%;" class="inner-table" style="padding:5px !important; margin: 5px !important;">
			<tr>
				<td style="font-size: 11px;padding-top: 25px;"> फाँटवालाको दस्तखत:
					
					<span class="dateDashedLine"></span></span>

				</td>
			
				<td style="text-align: right;font-size: 11px;padding-top: 25px;">शाखा प्रमुखको दस्तखत:
					

					<span class="dateDashedLine" style="display: inline-block !important;"></span></span>
				</td>
			</tr>
			
			<tr>
				<td style="font-size: 12px;padding-top: 10px;"> मिति:
					<span class="dateDashedLine"></span></span>
				</td>
				
				<td style="text-align: right;font-size: 12px;padding-top: 10px;"> मिति :
					<span class="dateDashedLine"></span></span>
				</td>
			</tr>
		</table>
		</td>
		</tr>

		<tr>
			<td style="border:1px solid black;">
			<table style="width: 100%;  border-collapse: collapse;  ">
				<tr>
					<td style="padding: 5px; border:1px solid black; " width="70%" >
						<span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">आर्थिक प्रशासन शाखाले भर्नेः</span>
						<br>
						<span style="font-size: 12px;">माथि उल्लेखित सामानहरु बजेट उपशीर्षक नं . <span class="dateDashedLine">   <?php echo $budget_code ?>   </span> को खर्च शीर्षक <span class="dateDashedLine"> <?php echo $budget_name ?></span>  बाट भूक्तानी दिन बजेट बांकी देखिन्छ/देखिंदैन ।</span>
							<br>
							<br>
						<span style="font-size: 12px;">शाखा प्रमुखको दस्तखत:</span>
					
						<span class="dateDashedLine" style="display: inline-block !important;"></span></span>
			

					</td>
					<td width="30%" style="text-align: right;font-size: 11px;padding-top: 25px;padding-right: 5px;border:1px solid black;">	<strong><u>खरिदका लागि स्वीकृत गर्ने</u></strong>
						<br>
						कार्यालय प्रमुखको दस्तखत:
						<br>
						<br>
						<br>
						<span class="dateDashedLine"></span></span>
						<br>
						<br>
						<span style="text-align: right;font-size: 12px;" class="">मिति:
							<span class="dateDashedLine" style="display: inline-block !important;"></span>
						<br>
						<br>
						<br>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	</div>
</div>