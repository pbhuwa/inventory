<style>
	h5 {

		margin: 0 0 8px;

		font-size: 1.8rem;

		font-weight: 700;

	}

	h6 {

		font-size: 16px;

	}

	.ku.table td,

	.ku.table th {

		font-size: 14px;

		padding: 2px 5px !important
	}

	.ku.table th {

		text-align: center !important;

		font-weight: 600;

		font-size: 15px;

		color: #000;

		padding: 3px 2px 2px !important;

	}

	.ku.table-bordered td,
	.ku.table-bordered th {

		border-color: black !important;

		border-bottom-width: 1px !important;

	}

	.ku.table tbody tr td.td_empty {

		height: 300px;

	}

	.ku_bottom {

		display: grid;

		grid-template-columns: repeat(5, 18%);

		grid-column-gap: 2em;

		align-items: center;

		padding: 2rem 0rem 2rem;

		text-align: center;

		color: #000;

	}

	.ku_bottom>div {
		position: relative;
	}

	.ku_bottom p {

		margin: 0;

	}

	.ku_bottom h6 {

		border-top: 1.5px dotted;

		text-align: center;

		padding: .75rem 0 .5rem;

		font-size: 15px;

	}

	.ku_bottom>div>span {

		position: absolute;
		top: -10px;
		left: 0;
		width: 100%;
		text-align: center;

	}

	.ku_bottom p span {

		border-bottom: 1.5px dotted;

		width: 75%;

		padding: 0;

		display: inline-block;

	}

	.table tfoot th {

		text-align: right !important;

		padding: .25rem !important
	}

	.ku_print_header {

		display: grid;

		grid-template-columns: repeat(3, 33.33%);

		padding-bottom: 1rem;

	}

	p {

		margin: 0;

		font-size: 15px;

		line-height: 1.6;

	}

	.ku_print_header .title {

		text-transform: uppercase;

		font-weight: 700;

		text-align: center;

	}

	.ku_print_header .date {

		text-align: right;

		align-self: center;

	}

	.details_individual {

		display: grid;

		grid-template-columns: 75% 25%;

		align-items: center;

	}

	.details_individual h6 .value,
	.remarks,
	.received {

		text-transform: uppercase;

	}

	.table tfoot th[colspan="4"] {

		text-align: center !important;

	}

	.note {

		border-top: 1.5px solid #000;

		padding-top: .25rem;

		font-weight: bold;

	}

	.other_details p {

		font-weight: 600;

	}

	.other_details span {

		font-weight: 400;

		line-height: 1
	}
</style>

<div class="jo_form organizationInfo">

	<div class="headerWrapper" style="margin-bottom: -25px;">

		<?php

		$header['report_no'] = 'फाराम न. ७';

		// $header['old_report_no'] = 'साबिकको फारम न. ५१';

		$mattype = !empty($stock_requisition_details[0]->rema_mattypeid) ? $stock_requisition_details[0]->rema_mattypeid : '';

		if ($mattype == '1') {

			$header['report_title'] = 'नखप्ने सामान माग फाराम';
		} else {

			$header['report_title'] = 'खप्ने सामान माग फाराम';
		}

		$header['show_department'] = 'Y';

		$dep_code = !empty($stock_requisition[0]->fromdepname) ? $stock_requisition[0]->fromdepname : '';

		$header['dep_code'] = $dep_code;

		$this->load->view('common/v_print_report_header', $header);

		?>

		<table class="jo_tbl_head" width="100%" style="border-collapse: collapse;">

			<tr>

				<td width="30%">

					<p class="mb-1">सि.न. </p>

					<p>श्री स्टोर इन्चार्ज,</p>

					<p>कृपया तलका सामानहरु दिनु होला ।</p>

				</td>

				<td width="40%">

				</td>

				<td width="30%" style="text-align: left;">

					<div class="other_details text-left">

						<p>स्कुल :- <span><?php

											$schoolid = !empty($stock_requisition_details[0]->rema_school) ? $stock_requisition_details[0]->rema_school : '';

											if (!empty($schoolid)) {

												$schooldata = $this->general->get_tbl_data('loca_name', 'loca_location', array('loca_locationid' => $schoolid));

												if ($schooldata) {

													echo $schooldata[0]->loca_name;
												} else {

													echo "-";
												}
											}

											?> </span></p>

						<p>विभाग :- <span><?php echo $dep_code; ?></span></p>

						<p>मा.फा.न. :-

							<?php

							if (!empty($stock_requisition)) { ?>

								<span>

									<?php

									echo !empty($stock_requisition[0]->rema_reqno) ? $stock_requisition[0]->rema_reqno : ''; ?>

								</span>

							<?php } else { ?>

								<span>

									<?php echo !empty($report_data['rema_reqno']) ? $report_data['rema_reqno'] : ''; ?>

								</span>

							<?php } ?>

						</p>

						<p>माल सामान समुह :-

							<span>

								<?php

								echo !empty($stock_requisition[0]->categories) ? $stock_requisition[0]->categories : '';

								?>

							</span>

						</p>

					</div>

				</td>

			</tr>

		</table>

	</div>

	<div class="tableWrapper">

		<table class="ku table table-bordered " width="100%" style="margin:2rem 0">

			<thead>

				<tr>

					<th width="5%">सि.न.</th>

					<th width="25%">विवरण<br>(आकृति, बनोट इवं विशेषता) </th>

					<th width="7%">एकाई </th>

					<th width="10%">माग गरेको परिमाण </th>

					<th width="12%">निकासी गरेको परिमाण</th>

					<th width="10%">खाता पाना </th>

					<th width="10%">दर </th>

					<th width="10%">रकम्(रु)</th>

					<th width="10%">कैफियत </th>

				</tr>

			</thead>

			<tbody>

				<?php if (!empty($stock_requisition)) {  //echo"<pre>";  print_r($stock_requisition);die;

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

							<td align="center" class="td_cell">

								<?php echo !empty($stock->unit_unitname) ? $stock->unit_unitname : ''; ?>

							</td>

							<td align="center" class="td_cell">

								<?php echo !empty($stock->rede_qty) ? number_format($stock->rede_qty, 0) : ''; ?>

							</td>

							<td class="td_cell">

							</td>

							<td class="td_cell">

								<?php echo !empty($stock->eqca_code) ? $stock->eqca_code : ''; ?>

							</td>

							<td align="center" class="td_cell">

								<?php echo !empty($stock->rede_unitprice) ? $stock->rede_unitprice : ''; ?>

							</td>

							<td align="right" class="td_cell">

								<?php echo !empty($stock->rede_totalamt) ? $stock->rede_totalamt : ''; ?>

							</td>

							<td class="td_cell">

								<?php echo !empty($stock->rede_remarks) ? $stock->rede_remarks : ''; ?>

							</td>

						</tr>

					<?php //$sumnewno += $newno; 

					} ?>

					<?php

					$row_count = (is_array($stock)) ? count($stock) : 0;

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

	<div class="ku_bottom">

		<div>

			<span><?php echo !empty($stock_requisition[0]->rema_reqby) ? $stock_requisition[0]->rema_reqby : ''; ?> </span>

			<h6>माग गर्ने</h6>

			<p>मिति: <span> <?php echo !empty($stock_requisition[0]->rema_reqdatebs) ? $stock_requisition[0]->rema_reqdatebs : ''; ?></span></p>

		</div>

		<div>

			<span></span>

			<h6>सिफारिस गर्ने</h6>

			<p>मिति: <span></span></p>

		</div>

		<div>

			<span></span>

			<h6>आदेश गर्ने</h6>

			<p>मिति: <span></span></p>

		</div>

		<div>

			<span></span>

			<h6>बुझिलिने</h6>

			<p>मिति: <span></span></p>

		</div>

		<div>

			<span></span>

			<h6>स्टोर इन्चार्ज्</h6>

			<p>मिति: <span></span></p>

		</div>

	</div>

	<div class="note">

		<p>कृपया एउटै प्रकृति भएको सामान हरुको लागि एउटै मात्र माग फाराम प्रयोग गर्नुहोला ।</p>

	</div>

</div>