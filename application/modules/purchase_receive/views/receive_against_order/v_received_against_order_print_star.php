<style>
	.table_jo_header,
	.jo_tbl_head,
	.jo_table,
	.jo_footer {
		width: 100%;
		font-size: 13px;
		border-collapse: collapse;
	}

	.table_jo_header {
		width: 100%;
		vertical-align: top;
		font-size: 13px;
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
		font-size: 14px;
	}

	.jo_table tr td span {
		font-size: 14px;
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
		padding: 18% 0px !important;
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
			$header['report_no'] = 'म.ले.प.फारम.नं ४०३';
			$header['old_report_no'] = 'साबिकको फारम न. ४६';
            $header['report_title'] = 'दाखिला प्रतिबेदन फारम';
            $this->load->view('common/v_print_report_header',$header);
        ?>

		<table class="jo_tbl_head">
			<tr>
				<td><span style="font-size: 14px;" class="text-right">
						<strong>दाखिला प्रतिबेदन नं: </strong>
					</span>
					<span class="bb">
						<?php
						if ($req_detail_list) {
							echo !empty($req_detail_list[0]->recm_invoiceno) ? $req_detail_list[0]->recm_invoiceno : '';
						} else {
							echo !empty($report_data['received_no']) ? $report_data['received_no'] : '';
						} ?>
					</span>
				<td width="20%" class="text-left " style="white-space: nowrap;">
					<strong>आपूर्तिकर्ताकाे नाम</strong>
					<span class="bb">
					<?php
					if ($req_detail_list) {
						echo !empty($req_detail_list[0]->dist_distributor) ? $req_detail_list[0]->dist_distributor : '';
					} ?>
					<span>
				</td>
				<td width="20%" class="text-left " style="white-space: nowrap;">
					<strong>दाखिला मिति: </strong>
				 	<span class="bb"> 
						<?php
						if ($req_detail_list) {
							if (DEFAULT_DATEPICKER == 'NP') {
								echo !empty($direct_purchase_master[0]->recm_receiveddatebs) ? $direct_purchase_master[0]->recm_receiveddatebs : '';
							} else {
								echo !empty($direct_purchase_master[0]->recm_receiveddatead) ? $direct_purchase_master[0]->recm_receiveddatead : '';
							}
						} else {
							if (DEFAULT_DATEPICKER == 'NP') {
								echo CURDATE_NP;
							} else {
								echo CURDATE_EN;
							}
						}
						?>
					</span>
				</td> 
			</tr>
		</table>
	</div>

	<div class="tableWrapper" style="margin-top: 0px;">
		<table class="jo_table itemInfo table_item" border="1">
			<thead>
				<tr>
					<th width="4%" style="font-size: 15px" rowspan="2" class="td_cell">क्र. सं.</th>
					<th width="5%" style="font-size: 15px" rowspan="2" class="td_cell">जिन्सि खा.पा.नं</th>
					<th width="5%" style="font-size: 15px" rowspan="2" class="td_cell">जिन्सि वर्गिकरण संकेत</th>
					<th width="30%" style="font-size: 15px" rowspan="2" class="td_cell">सामानको नाम</th>
					<th width="10%" style="font-size: 15px" rowspan="2" class="td_cell">स्पेसी. फिकेसन </th>
					<th width="5%" style="font-size: 15px" rowspan="2" class="td_cell">इकाई</th>
					<th width="5%" style="font-size: 15px" rowspan="2" class="td_cell">परि. माण</th>
					<th width="15%" style="font-size: 15px" colspan="5" class="td_cell">मुल्य(इन्भ्वाइस अनसार)</th>
					<th width="10%" style="font-size: 15px" rowspan="2" class="td_cell" style="border-right: 1px solid">कैफियत </th>
				</tr>
				<tr>
					<th class="td_cell" width="10%">प्रति इकाई दर</th>
					<th class="td_cell" width="10%">मु. अ. कर</th>
					<th class="td_cell" width="10%">इकाई मुल्य</th>
					<th class="td_cell" width="5%">अन्य खर्च</th>
					<th class="td_cell" width="10%">जम्मा</th>
				</tr>
				
			</thead>
			<tbody>
				
				<?php
				$sum_wo_vat=0;
					$sum = 0;
					$vatsum = 0;
				if ($req_detail_list) {
					$sum = 0;
					$vatsum = 0;
					foreach ($req_detail_list as $key => $direct) { ?>
						<tr style="border-bottom: 1px solid #212121;">
							<td class="td_cell" style="text-align:left">
								<?php echo $key + 1; ?>
							</td>

							<td class="td_cell" style="text-align:left">
								<?php echo !empty($direct->itli_itemcode) ? $direct->itli_itemcode : ''; ?>
							</td>
							<td class="td_cell" style="text-align:left">
								
							</td>
							<td width="500px" class="td_cell" style="text-align:left">
								<?php
								if (ITEM_DISPLAY_TYPE == 'NP') {
									echo !empty($direct->itli_itemnamenp) ? $direct->itli_itemnamenp : $direct->itli_itemname;
								} else {
									echo !empty($direct->itli_itemname) ? $direct->itli_itemname : '';
								}
								?>
							</td>
							<td class="td_cell"></td>
							<td class="td_cell" style="text-align:left">
								<?php echo !empty($direct->unit_unitname) ? $direct->unit_unitname : ''; ?>
							</td>

							<td class="td_cell" style="text-align:left">
								<?php echo number_format($direct->recd_purchasedqty); ?>
							</td>

							<td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;text-align: right;">
								<?php
								$unit_price = !empty($direct->recd_unitprice) ? $direct->recd_unitprice : '';
								echo number_format($unit_price, 2);
								?>
							</td>
							<td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;text-align: right;">
								<?php
								echo $direct->recd_vatamt;
								?>
							</td>
							<td class="td_cell" style="text-align: right;">
								<?php
								$total_wo_vat = $direct->recd_purchasedqty * $direct->recd_unitprice;
								$sum_wo_vat +=$total_wo_vat;
								echo number_format($total_wo_vat, 2);
								?>
							</td>
							<td class="td_cell"></td>
							<td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word; text-align: right;">
								<?php echo number_format($direct->recd_amount,2); ?>
							</td>
							<td class="td_cell" style="text-align:left">
								<?php if($direct->recd_description!=$direct->itli_itemname){ echo $direct->recd_description; }; ?>
							</td>
							
						</tr>
					<?php
						$sum += $direct->recd_discountamt;
						$vatsum += $direct->recd_vatamt;
					}

					$row_count = count($req_detail_list);
					
					if ($row_count < 13) : ?>
						<tr style="border-top: none !important">
							<td class="td_empty"></td>
							<td class="td_empty"></td>
							<td class="td_empty"></td>
							<td class="td_empty"></td>
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
					<?php
					$total = $direct->recm_clearanceamount;
					?>
				<tr>
					<td colspan="8" style="text-align: right;font-size: 14px;">
						<span class=""><strong>जम्मा </strong></span>:
					</td>
					<td colspan="5" style="border-right: 1px solid #000;text-align: right">
						<strong><?php echo !empty($sum_wo_vat) ? number_format($sum_wo_vat, 2) : ''; ?></strong>
					</td>
				</tr>
				<tr>
					<td colspan="8" style="text-align: right;font-size: 14px;">
						<span class=""><strong>१३% VAT</strong> </span>:
					</td>
					<td colspan="5" style="border-right: 1px solid #000;;text-align: right">
						<strong><?php echo !empty($vatsum) ? number_format($vatsum, 2) : ''; ?></strong>
					</td>
				</tr>
				<tr>
					<td colspan="8" style="text-align: right;font-size: 14px;">
						<span class=""><strong>कूल रकम</strong></span>:
					</td>
					<td colspan="5" style="border-right: 1px solid #000;text-align: right">
						<strong><?php echo !empty($total) ? number_format($total, 2) : ''; ?></strong>
					</td>
				</tr>
			<?php } ?>
			<tr>
				<td colspan="13" style="overflow-wrap: break-word;white-space: nowrap;text-align: center;border-right: 1px solid #000;"><strong>शब्दमा : 
					<?php
					if ($req_detail_list) {
						echo $this->general->number_to_word($total);
					} else {
						echo $this->general->number_to_word($report_data['clearanceamt']);
					}
					?>
					</strong>
				</td>
			</tr>
			<tr>
				<td colspan="13">&nbsp;</td>
			</tr>
			</tbody>
		</table>
	</div>

<div class="footerWrapper">
	<table class="table officer_detailTable purchaserecive-table" style="width: 100%;border-left: 1px solid #333;border-right: 1px solid #333;border-bottom: 1px solid #333;border-top: 1px solid #ddd;">
		<tr>
			<td colspan="3">माथि उल्लेखित सामानहरु खरिद आदेश नं.
				<span style="border-bottom: 1px dashed #333">
					<?php
					if ($req_detail_list) {
						echo !empty($req_detail_list[0]->recm_purchaseorderno) ? $req_detail_list[0]->recm_purchaseorderno : '';
					} ?>
				</span>
				मिति
				<span style="border-bottom: 1px dashed #333">
					<?php
					if ($req_detail_list) {
						echo !empty($req_detail_list[0]->recm_receiveddatebs) ? $req_detail_list[0]->recm_receiveddatebs : '';
					} ?>
				</span>
				अनुसार श्री
				<span style="border-bottom: 1px dashed #333">
					<?php
					if ($req_detail_list) {
						echo !empty($req_detail_list[0]->dist_distributor) ? $req_detail_list[0]->dist_distributor : '';
					} ?>
				</span>
				बाट प्राप्त हुन आएकोे 
				<br>हुदा जाचि गन्तिगरि हेरि ठिक दूरुस्त भएकोले खातामा आम्दानी बांदी प्रमाणित गरेको छु ।
			</td>
		</tr>
		<tr>
			<td style="padding-top: 30px;">फांटवालाको दस्तखत </td>
			<td style="padding-top: 30px;">शाखा प्रमुखको दस्तखत </td>
			<td style="padding-top: 30px;">कार्यालय प्रमुखको दस्तखत</td>
		</tr>
		<tr>
			<td>नाम:</td>
			<td>नाम:</td>
			<td>नाम:</td>
		</tr>
		<tr>
			<td>मिति: </td>
			<td>मिति: </td>
			<td>मिति: </td>
		</tr>
	</table>
</div>