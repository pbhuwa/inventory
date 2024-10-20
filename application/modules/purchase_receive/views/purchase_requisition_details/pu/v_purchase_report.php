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
		border-bottom: 1px solid #333;
		font-size: 12px;
	}

	.jo_footer {
		vertical-align: top;
	}

	.jo_footer td {
		padding: 4px 8px;
	}

	.borderbottom {
		border-bottom: 1px dashed #333;
		padding-bottom: 0px;
	}

	.tableWrapper {
		min-height: 45%;
		height: 45vh;
		max-height: 100vh;
		white-space: nowrap;
		display: table;
		width: 100%;
		/*overflow-y: auto;*/
	}

	.itemInfo {
		height: 100%;
	}

	.itemInfo .td_cell {
		padding: 5px;
		margin: 5px;
	}

	.itemInfo .td_empty {
		height: 100%;
		border-style: none;
	}

	.footerWrapper {
		margin-top: 20px;
		page-break-inside: avoid;
	}

	.dateDashedLine {
		min-width: 100px;
		display: inline-block;
		border: 1px dashed #333;
	}

	.signatureDashedLine {
		min-width: 170px;
		display: inline-block;
		border: 1px dashed #333;
	}

	/*.jo_table tr td{border-bottom: 1px solid #000; padding: 0px 4px;}*/
	/*.itemInfo tr:last-child td{border:0px !important;}
	.itemInfo {border-bottom: 0px;}*/
	/*	@page {
	   size: 7in 9.25in;
	}*/
	.jo_footer img {
		margin-top: -15px;
		margin-left: 10px;
	}

	img.signatureImage {
		width: 70px;
	}
</style>

<div class="jo_form organizationInfo">
	<div class="headerWrapper" style="margin-bottom: -25px ">

		<?php
		$mattype = !empty($requisition_details[0]->pure_mattypeid) ? $requisition_details[0]->pure_mattypeid : '';

		if ($mattype == '1') {

			$header['report_title'] = 'नखप्ने सामान माग फारम (खरिद)';
		} else if($mattype == '2') {

			$header['report_title'] = 'खप्ने सामान माग फारम (खरिद) ';
		}
		else{
			$header['report_title'] = 'माग फारम(खरिद)';
		}


		$header['report_no'] = 'म.ले.प.फारम.नं ४०१';
		// $header['report_title'] = 'माग फारम (खरिद)';
		$this->load->view('common/v_print_report_header', $header);
		?>

		<table class="jo_tbl_head" width="100%" style="border-collapse: collapse;">
			<tr>
				<td width="35%">

					<span style="font-size: 12px; margin-bottom: 5px;" class="<?php echo FONT_CLASS; ?>"> आर्थिक वर्ष :- </span> <span class="borderbottom">
					</span>

					<span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">
						<strong><?php

						echo !empty($requisition_details[0]->pure_fyear) ? $requisition_details[0]->pure_fyear : ''; ?></strong> </span>

				</td>
				<td width="30%">
					<span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">खरिद माग फारम नं :</span>

					<?php
					if ($requisition_details) {
						$pure_reqno = !empty($requisition_details[0]->pure_reqno) ? $requisition_details[0]->pure_reqno : '';
					} else {
						$pure_reqno = !empty($report_data['rema_reqno']) ? $report_data['rema_reqno'] : '';
					}
					?>
					<span class="borderbottom">
						<strong><?php echo $pure_reqno; ?></strong>
					</span>
					<?php
					$store_reqno = !empty($requisition_details[0]->pure_streqno) ? $requisition_details[0]->pure_streqno : '';
					if(!empty($store_reqno)):
					?>
					<div style="float:right"><span>माग नं :<span class="borderbottom"><strong><?php echo $store_reqno; ?></strong></span>
					</span>
				</div>
					<?php 
					endif
					?>

				</td>
				
				<td width="35%" style="text-align: right;" class="text-center magh_faram">
					
						माग मिति:<strong><span class="borderbottom" style="min-width:80px;display: inline-block;margin: 0px;padding: 0px; "><?php echo !empty($requisition_details[0]->pure_reqdatebs) ? $requisition_details[0]->pure_reqdatebs : CURDATE_NP; ?></span></strong>

				</td>
				

				<!-- rema_reqdatebs -->

			</tr>
			

		</table>

	</div>



	<div class="tableWrapper">
		<table class="jo_table itemInfo" id="jo_table">
			<thead>
				<tr>
					<th width="5%" class="td_cell"> क्र.स</th>
					<th width="40%" class="td_cell"> मालसामानको विवरण </th>
					<th width="18%" class="td_cell"> स्पेसिफिकेशन (आवश्यक पर्नेमा) </th>
					<th width="8%" class="td_cell"> एकाइ </th>
					<th width="8%" class="td_cell"> सामानको परिमाण </th>
					<th width="10%" class="td_cell">जिन्सी खाता पाना नम्बर </th>
					<th width="25%" class="td_cell"> कैफियत </th>
				</tr>
			</thead>
			<tbody>
				<?php
				if ($purchase_requisition) {
					foreach ($purchase_requisition as $key => $details) { ?>
						<tr>
							<td class="td_cell">
								<?php echo $key + 1; ?>
							</td>
							<td class="td_cell">
								<?php

								if (ITEM_DISPLAY_TYPE == 'NP') {
									echo !empty($details->itli_itemnamenp) ? $details->itli_itemnamenp : $details->itli_itemname;
								} else {

									echo !empty($details->itli_itemname) ? $details->itli_itemname : '';
								}
								?>
							</td>
							<td class="td_cell"></td>
							<td class="td_cell">
								<?php echo !empty($details->unit_unitname) ? $details->unit_unitname : ''; ?>
							</td>
							<td class="td_cell" style="text-align: right">
								<?php echo !empty($details->purd_qty) ? sprintf('%g',$details->purd_qty) : ''; ?>
							</td>
							<td class="td_cell" style="text-align: right">
								<?php echo !empty($details->itli_itemcode) ? $details->itli_itemcode : ''; ?>
							</td>
							<td class="td_cell">
								<?php echo !empty($details->purd_remarks) ? $details->purd_remarks : ''; ?>
							</td>
						</tr>
					<?php
					}
					$row_count = count($purchase_requisition);
					if ($row_count < 15) :
					?>
						<tr>
							<td class="td_empty" style="border-left: 1px solid black;"></td>
							<td class="td_empty"></td>
							<td class="td_empty"></td>
							<td class="td_empty"></td>
							<td class="td_empty"></td>
							<td class="td_empty"></td>
							<td class="td_empty"></td>
						</tr>
				<?php
					endif;
				}
				?>
			</tbody>
		</table>
	</div>

	<div class="footerWrapper">
		<table class="jo_table_footer" style="border-collapse: collapse;padding-top: 0px;padding-bottom: 10px;border-top: 0px;">

			<tr>

				<td width="35%">

					माग गर्नेको दस्तखत:

					<span class="dateDashedLine"></span>

				</td>

				<td width="30%">



				</td>

				<td width="35%">

					क) बजारबाट खरिद गरि दिनु

					<input type="checkbox" style="margin-left: 11px" />

				</td>

			</tr>



			<tr>

				<td width="35%">

					नाम:

					<span class="borderbottom">

						<?php echo !empty($stock_requisition[0]->rema_reqby) ? $stock_requisition[0]->rema_reqby : ''; ?>

					</span>

				</td>

				<td width="30%">


				</td>

				<td width="35%">

					ख) मौज्दातबाट दिनु

					<input type="checkbox" style="margin-left: 42px" />

				</td>

			</tr>



			<tr>

				<td width="35%">

					मिति:

					<span class="borderbottom">

						<?php echo !empty($stock_requisition[0]->rema_reqdatebs) ? $stock_requisition[0]->rema_reqdatebs : ''; ?>

					</span>

				</td>

				<td width="30%">

				</td>

				<td></td>

			</tr>



			<tr>

				<td width="35%">

					प्रयोजन:

					<span class="dateDashedLine"></span>

				</td>

				<td width="30%"></td>

				<td width="35%">
					आदेश दिनेको दस्तखत:

					<span class="dateDashedLine"></span>
				</td>

			</tr>



			<tr>

				<td width="35%"></td>

				<td width="30%"></td>

				<td width="35%">
					मिति:

					<span class="borderbottom">



					</span>

				</td>

			</tr>



			<tr>

				<td width="35%">जिन्सी खातामा चढाउनेको दस्तखत:
					<span class="dateDashedLine"></span>
				</td>

				<td></td>
				<td></td>
			</tr>
			<tr>

				<td width="35%">मिति:
					<span class="borderbottom"></span>
				</td>

				<td width="30%"></td>

				<td width="35%">
					मालसामान बुझ्नेको दस्तखत:
					<span class="dateDashedLine"></span>

				</td>
			</tr>
			<tr>

				<td width="35%"></td>

				<td width="30%"></td>

				<td width="35%">
					मिति:
					<span class="borderbottom">
					</span>

				</td>

			</tr>

		</table>
	</div>
</div>