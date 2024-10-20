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
		padding: 8px 8px;
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
		min-height: 30%;
		height: 30vh;
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
		text-align: center;
		font-size: bold;
	}

	th.td_cell {
		font-weight: bold;
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
</style>

<div class="jo_form organizationInfo" style="position: relative;">
	<div class="headerWrapper" style="margin-bottom: -25px;">
		<?php
		$header['report_no'] = 'म.ले.प.फारम.नं ४०१';
		// $header['old_report_no'] = 'साबिकको फारम न. ५१';
		if (ORGANIZATION_NAME == 'KUKL') {
			$header['report_title'] = 'माग फारम';
		} else if (ORGANIZATION_NAME == 'NPHL') {
			$header['report_title'] = 'माग/निकासी फारम';
		} else {
			$header['report_title'] = 'निकासी फारम';
		}

		$header['show_department'] = 'Y';

		$dep_code = !empty($issue_master[0]->fromdepcode) ? $issue_master[0]->fromdepcode : '';

		$header['dep_code'] = $dep_code;

		$this->load->view('common/v_print_report_header', $header);
		?>

		<table class="jo_tbl_head" width="100%" style="border-collapse: collapse;">
			<tr>
				<td width="40%">श्री ......................................................................</td>
				<td width="40%"></td>
				<td width="20%" style="text-align: left;">
					<span style="font-size: 12px;"><strong>आ. व. </strong></span>
					<span class="borderbottom">
						<?php
						echo !empty($issue_master[0]->sama_fyear) ? $issue_master[0]->sama_fyear : '';
						?>
					</span>
				</td>
			</tr>
			<tr>
				<td width="40%"></td>
				<td width="20%" style="padding-left:70px">
					<span style="font-size: 12px;"><strong>माग नं: </strong></span>
					<?php
					if ($issue_master) { ?>
						<span class="borderbottom">
							<?php
							echo !empty($issue_master[0]->sama_requisitionno) ? $issue_master[0]->sama_requisitionno : ''; ?>
						</span>
					<?php } else { ?>
						<span class="borderbottom">
							<?php echo !empty($report_data['sama_requisitionno']) ? $report_data['sama_requisitionno'] : ''; ?>
						</span>
					<?php } ?>
				</td>
				<td width="30%" style="text-align: left;">
					<span style="font-size: 12px;"><strong>निकासी नं: </strong></span>
					<?php
					if ($issue_master) { ?>
						<span class="borderbottom">
							<?php
							echo !empty($issue_master[0]->sama_invoiceno) ? $issue_master[0]->sama_invoiceno : ''; ?>
						</span>
					<?php } else { ?>
						<span class="borderbottom">
							<?php echo !empty($report_data['sama_invoiceno']) ? $report_data['sama_invoiceno'] : ''; ?>
						</span>
					<?php } ?>

				</td>
			</tr>
			<tr>
				<td width="40%">
					..............................................................................
				</td>
				<td width="40%">
				</td>
				<td width="20%" style="text-align: left;">
					<span style="font-size: 12px;"><strong>मिति: </strong></span>
					<span class="borderbottom">
						<?php
						if (DEFAULT_DATEPICKER == 'NP') {
							echo !empty($issue_master[0]->sama_billdatebs) ? $issue_master[0]->sama_billdatebs : '';
						} else {
							echo !empty($issue_master[0]->sama_billdatead) ? $issue_master[0]->sama_billdatead : '';
						}
						?>
					</span>
				</td>
			</tr>
		</table>
	</div>

	<div class="tableWrapper">
		<table class="jo_table itemInfo" style="border-bottom: 1px solid #333;">
			<thead>
				<tr>
					<th width="5%" rowspan="2" class="td_cell"> क्र.स.</th>
					<th width="25%" rowspan="2" class="td_cell">सामानको नाम </th>
					<th width="15%" rowspan="2" class="td_cell">स्पेलसिफिकेसन </th>
					<th width="10%" colspan="3" class="td_cell">माग गरिएको </th>
					<th width="10%" colspan="3" class="td_cell">खर्च/निकासा विवरण</br>(म.ले.पा फा.नं ४०४ काे प्रथाेजनार्थ)</th>
					<th width="10%" rowspan="2" class="td_cell">कैफियत </th>
				</tr>

				<tr>
					<th width="10%" class="td_cell">एकाइ </th>
					<th width="10%" class="td_cell">परिमाण </th>
					<th width="10%" class="td_cell">जम्मा</th>
					<th width="10%" class="td_cell">एकाइ </th>
					<th width="10%" class="td_cell">परिमाण </th>
					<th width="10%" class="td_cell">जम्मा</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($issue_details) {  //echo"<pre>";  print_r($issue_details);die;
					foreach ($issue_details as $key => $stock) { ?>
						<tr>
							<td class="td_cell">
								<?php echo $key + 1; ?>
							</td>
							<!-- 	<td class="td_cell">
						<?php echo !empty($stock->itli_itemcode) ? $stock->itli_itemcode : ''; ?>
					</td> -->
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
							</td>
							<td class="td_cell">
								<?php echo !empty($stock->unit_unitname) ? $stock->unit_unitname : ''; ?>
							</td>
							<td class="td_cell">
								<?php echo !empty($stock->totaldemandqty) ? $stock->totaldemandqty : 0; ?>
							</td>
							<td class="td_cell">
								<?php echo !empty($stock->totaldemandqty) ? $stock->totaldemandqty : 0; ?>
							</td>

							<td class="td_cell">
								<?php echo !empty($stock->unit_unitname) ? $stock->unit_unitname : ''; ?>
							</td>

							<td class="td_cell">
								<?php echo !empty($stock->totalqty) ? $stock->totalqty : 0; ?>
							</td>
							<td class="td_cell">
								<?php echo !empty($stock->totalqty) ? $stock->totalqty : 0; ?>
							</td>

							<!-- <td class="td_cell"></td> -->
							<td class="td_cell">
								<?php $puderemaks = !empty($stock->sade_remarks) ? $stock->sade_remarks : ''; ?>
								<?php echo $puderemaks; ?>
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
							<td class="td_empty"></td>
							<td class="td_empty"></td>
							<!-- <td class="td_empty"></td> -->
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
								<!-- 	<td class="td_cell">
					<?php echo !empty($report_data['rede_code'][$key]) ? $report_data['rede_code'][$key] : ''; ?>
				</td> -->
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

								<td class="td_cell"></td>

								<td class="td_cell">
									<?php
									$unitid = !empty($report_data['rede_unit'][$key]) ? $report_data['rede_unit'][$key] : '';
									$unitname =  $this->general->get_tbl_data('*', 'unit_unit', array('unit_unitid' => $unitid), false, 'DESC');
									echo !empty($unitname[0]->unit_unitname) ? $unitname[0]->unit_unitname : '';
									?>
								</td>

								<td class="td_cell">
									<?php echo !empty($report_data['rede_qty'][$key]) ? $report_data['rede_qty'][$key] : ''; ?>
								</td>

								<!-- <td class="td_cell"></td> -->
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
								<td class="td_empty"></td>
								<td class="td_empty"></td>
								<!-- <td class="td_empty"></td> -->
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
		<table class="jo_footer" style="padding-top: 0px;padding-bottom: 10px;border: 1px solid #000;border-top: 0px;page-break-inside: avoid;">
			<tr>
				<td style="padding-top: 40px !important;margin-top: 30px !important;">

					माग गर्नेको दस्तखत:
					<span class="dateDashedLine"></span>
				</td>

				<td style="padding-top: 40px !important;margin-top: 30px !important;">
					सिफारिस गर्नेको दस्तखत:
					<span class="dateDashedLine"></span>
				</td>

				<td style="padding-top: 40px !important;margin-top: 30px !important;">
					क) बजारबाट खरिद गरि दिनु
					<input type="checkbox" style="margin-left: 11px" />
				</td>

			</tr>

			<tr>
				<td>
					नाम:
					<span class="borderbottom">
						<?php echo !empty($issue_master[0]->sama_receivedby) ? $issue_master[0]->sama_receivedby : '';
							echo !empty($issue_master[0]->sama_depname) ? '</br>('.$issue_master[0]->sama_depname.')' : '';
						  ?>
					</span>
				</td>
				<td>
					नाम:
					<span class="dateDashedLine"></span>
				</td>
				<td>
					ख) मौज्दातबाट दिनु
					<input type="checkbox" style="margin-left: 42px" />
				</td>
			</tr>

			<tr>
				<td>
					मिति:
					<span class="borderbottom">
						<?php echo !empty($issue_master[0]->sama_billdatebs) ? $issue_master[0]->sama_billdatebs : ''; ?>
					</span>
				</td>
				<td>
					मिति:
					<span class="dateDashedLine"></span>
				</td>
				<td></td>
			</tr>

			<tr>
				<td>
					प्रयोजन:
					<span class="dateDashedLine"></span>
				</td>
				<td></td>
				<td>
					आदेश दिनेको दस्तखत:
					<span class="dateDashedLine"></span>
				</td>
			</tr>

			<!-- <tr>
				<td></td>
				<td></td>
				<td>
					आदेश दिनेको दस्तखत:
					<span class="dateDashedLine"></span>
				</td>
			</tr> -->
			<tr>
				<td></td>
				<td></td>
				<td>
					मिति:
					<span class="dateDashedLine"></span>
				</td>

			</tr>
		</table>

		<table class="jo_footer" style="padding-top: 0px;padding-bottom: 10px;border: 1px solid #000;border-top: 0px;page-break-inside: avoid; margin-top: 0px">
			<tr>
				<td style="padding-top: 30px;">
					मालसामान बुझ्नेको दस्तखत:
					<span class="dateDashedLine"></span>
				</td>
				<td style="padding-top: 30px;">
					जिन्सी खातामा चढाउनेको दस्तखत:
					<span class="dateDashedLine"></span>
				</td>
			</tr>

			<tr>
				<td>
					मिति:
					<span class="dateDashedLine"></span>
				</td>
				<td>
					मिति:
					<span class="dateDashedLine"></span>
				</td>
			</tr>
		</table>
	</div>
</div>