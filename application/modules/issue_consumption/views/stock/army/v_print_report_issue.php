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

	.jo_tbl_head td td {
		padding-bottom: 10px;
	}

	.jo_table {
		margin-top: 15px !important;
	}

	.jo_table {
		border-right: 1px solid #333;
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
	}

	.jo_footer {
		border: 1px solid #333;
		vertical-align: top;
	}

	.jo_footer td {
		padding: 3px;
	}

	.footerWrapper {
		padding-top: 100px
	}

	.jo_table_footer td {
		padding: 4px;
		font-size: 12px
	}

	.preeti {
		font-family: preeti;
	}

	.borderbottom {
		border-bottom: 1px dashed #333;
		margin: 0px;
		padding: 0px;
	}

	.tableWrapper {
		min-height: 40%;
		height: 40vh;
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
		margin: 2px;
	}

	.itemInfo .td_empty {
		height: 100%;
	}

	.jo_table tr td {
		border-bottom: 1px solid #000;
		padding: 0px 4px;
	}

	/*.itemInfo tr:last-child td{border:0px !important;}
	.itemInfo {border-bottom: 0px;}*/
	.footerWrapper {
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

	.jo_footer img {
		margin-top: -15px;
		margin-left: 10px;
	}

	img.signatureImage {
		width: 70px;
	}

	td.magh_faram span.borderbottom {
		min-width: 80px;
		display: inline-block;
		margin: 0px;
		padding: 0px;
		text-align: center;
	}
</style>



<div class="jo_form organizationInfo">

	<div class="headerWrapper" style="padding-bottom: 5px">

		<?php

		$header['report_no'] = 'सै.क.कोष फा.नं. २२';

		// $header['report_title'] = 'माग फारम';
		$mattype = !empty($stock_requisition_details[0]->rema_mattypeid) ? $stock_requisition_details[0]->rema_mattypeid : '';

		if ($mattype == '1') {

			$header['report_title'] = 'माग फाराम (नखप्ने सामान )';
		} else {

			$header['report_title'] = 'माग फाराम(खप्ने सामान )';
		}

		$this->load->view('common/v_print_report_header', $header);

		?>

		<table class="jo_tbl_head" width="100%" style="border-collapse: collapse;">
			<tr>
				<td width="40%">

					<span style="font-size: 12px; margin-bottom: 5px;" class="<?php echo FONT_CLASS; ?>"> कार्यालयको नाम :- </span> <span class="borderbottom">
					</span>

					<span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">
						<?php
						$locationid = !empty($stock_requisition_details[0]->rema_locationid) ? $stock_requisition_details[0]->rema_locationid : '';

						if (!empty($locationid)) {
							$location_data = $this->general->get_tbl_data('loca_name,loca_namenp', 'loca_location', array('loca_locationid' => $locationid));
							if ($location_data) {
								echo $location_data[0]->loca_namenp;
							} else {
								echo "-";
							}
						}
						?>
					</span>

				</td>
				<td width="20%"></td>
				<td width="40%" style="text-align: right;" class="text-center magh_faram">

					<span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">माग फारम नं </span>

					<?php

					if ($stock_requisition) { ?>

						<span class="borderbottom">

							<?php

							echo !empty($stock_requisition[0]->rema_reqno) ? $stock_requisition[0]->rema_reqno : ''; ?>

						<?php } else { ?>

							<span class="borderbottom">

							<?php echo !empty($report_data['rema_reqno']) ? $report_data['rema_reqno'] : '';
						} ?></span>

				</td>

				<!-- rema_reqdatebs -->

			</tr>
			<tr>
				<td width="40%">

					<span style="font-size: 12px; margin-bottom: 5px;" class="<?php echo FONT_CLASS; ?>"> आर्थिक वर्ष :- </span> <span class="borderbottom">
					</span>

					<span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">
						<?php

						echo !empty($stock_requisition[0]->rema_fyear) ? $stock_requisition[0]->rema_fyear : ''; ?> </span>

				</td>
				<td width="20%"></td>
				<td width="40%" style="text-align: right;">

					<span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">निकासी नं </span>

					<span class="borderbottom" style="min-width:80px;display: inline-block;margin: 0px;padding: 0px; "></span>

				</td>
			</tr>
		</table>

	</div>



	<div class="tableWrapper">

		<table class="jo_table itemInfo" style="border-bottom: 1px solid #333;">

			<thead>

				<tr>

					<th width="3%" class="td_cell"> क्.सं.</th>

					<th width="25%" class="td_cell">सामानको नाम</th>

					<th width="20%" class="td_cell">स्पेसिफिकेशन</th>

					<th width="10%" class="td_cell">सामानको परिमाण </th>

					<th width="8%" class="td_cell">एकाइ </th>

					<th width="10%" class="td_cell">निकासी सामानको परिमाण </th>

					<th width="10%" class="td_cell">जिन्सी खाता पाना नम्बर </th>

					<th width="12%" class="td_cell">कैफियत </th>

				</tr>

			</thead>

			<tbody>

				<?php if ($stock_requisition) {  //echo"<pre>";  print_r($stock_requisition);die;
					foreach ($stock_requisition as $key => $stock) { ?>
						<tr>
							<td class="td_cell">
								<?php echo $key + 1; ?>
							</td>

							<td class="td_cell">

								<?php

								if (ITEM_DISPLAY_TYPE == 'NP') {
									echo !empty($stock->itli_itemnamenp) ? $stock->itli_itemnamenp : $stock->itli_itemname;
								} else {
									echo !empty($stock->itli_itemname) ? $stock->itli_itemname : '';
								}

								?>

							</td>

							<td class="td_cell">
								<?php echo !empty($stock->rede_remarks) ? $stock->rede_remarks : ''; ?>
							</td>

							<td class="td_cell">

								<?php echo !empty($stock->rede_qty) ? sprintf('%g',$stock->rede_qty) : ''; ?>

							</td>

							<td class="td_cell">

								<?php echo !empty($stock->unit_unitname) ? $stock->unit_unitname : ''; ?>

							</td>


							<td class="td_cell"></td>
							<td class="td_cell">

								<?php echo !empty($stock->itli_itemcode) ? $stock->itli_itemcode : ''; ?>
							</td>

							<td class="td_cell">

								

							</td>

						</tr>

					<?php //$sumnewno += $newno; 

					} ?>

					<?php

					$stock = array();

					$row_count = count($stock);

					if ($row_count < 15) :

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

						</tr>

					<?php endif; ?>

				<?php

				} else { ?>

					<?php

					$itemid = !empty($report_data['rede_itemsid']) ? $report_data['rede_itemsid'] : '';

					if (!empty($itemid)) : // echo"<pre>";print_r($itemid);die;

						//$sumnewno=0; $newno=0;

						foreach ($itemid as $key => $products) :

					?>

							<tr>

								<td class="td_cell">

									<?php echo $key + 1; ?>

								</td>

								<td class="td_cell">

									<?php echo !empty($report_data['rede_code'][$key]) ? $report_data['rede_code'][$key] : ''; ?>

								</td>

								<td class="td_cell">

									<?php

									$itemid = !empty($report_data['rede_itemsid'][$key]) ? $report_data['rede_itemsid'][$key] : '';

									$itemname =  $this->general->get_tbl_data('*', 'itli_itemslist', array('itli_itemlistid' => $itemid), false, 'DESC');

									if (ITEM_DISPLAY_TYPE == 'NP') {

										echo !empty($itemname[0]->itli_itemnamenp) ? $itemname[0]->itli_itemnamenp : $itemname[0]->itli_itemname;
									} else {

										echo !empty($itemname[0]->itli_itemname) ? $itemname[0]->itli_itemname : '';
									}

									?>

								</td>

								<td class="td_cell">

									<?php echo !empty($report_data['rede_qty'][$key]) ? $report_data['rede_qty'][$key] : ''; ?>

								</td>

								<td class="td_cell">

									<?php

									$unitid = !empty($report_data['rede_unit'][$key]) ? $report_data['rede_unit'][$key] : '';

									$unitname =  $this->general->get_tbl_data('*', 'unit_unit', array('unit_unitid' => $unitid), false, 'DESC');

									echo !empty($unitname[0]->unit_unitname) ? $unitname[0]->unit_unitname : '';

									?>

									<!-- <?php echo !empty($report_data['rede_unit'][$key]) ? $report_data['rede_unit'][$key] : ''; ?> -->

								</td>

								<td class="td_cell"></td>

								<td class="td_cell"></td>

								<td class="td_cell">

									<?php echo !empty($report_data['rede_remarks'][$key]) ? $report_data['rede_remarks'][$key] : ''; ?>

								</td>

							</tr>

						<?php

						endforeach;

						?>

						<?php

						$row_count = count($report_data['rede_itemsid']);

						if ($row_count < 15) :

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

							</tr>

						<?php endif; ?>

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