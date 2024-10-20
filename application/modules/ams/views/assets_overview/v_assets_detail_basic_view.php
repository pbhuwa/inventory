<h5 class="ov_lst_ttl"><b>Basic</b></h5>

<ul class="pm_data pm_data_body">



	<li>

		<label> Asset Location:</label>

		<span><?php echo !empty($assets_rec_data[0]->loca_name) ? $assets_rec_data[0]->loca_name : ''; ?></span>

	</li>



	<li>

		<label> System ID:</label>

		<span><?php echo !empty($assets_rec_data[0]->asen_asenid) ? $assets_rec_data[0]->asen_asenid : ''; ?></span>

	</li>



	<li>

		<label>Asset Category:</label>

		<span><?php echo !empty($assets_rec_data[0]->eqca_category) ? $assets_rec_data[0]->eqca_category : ''; ?></span>

	</li>

	<li>

		<label> Asset Code:</label>

		<span><?php echo $ass_code = !empty($assets_rec_data[0]->asen_assetcode) ? $assets_rec_data[0]->asen_assetcode : ''; ?></span>

	</li>

	<li>

		<label> Asset Manual Code:</label>

		<span><?php echo !empty($assets_rec_data[0]->asen_assestmanualcode) ? $assets_rec_data[0]->asen_assestmanualcode : ''; ?></span>

	</li>

	<li>

		<label>Parent Asset:</label>

		<span></span>

	</li>



	<li>

		<label> Asset Description:</label>

		<span>

			<?php echo $ass_desc = !empty($assets_rec_data[0]->asen_desc) ? $assets_rec_data[0]->asen_desc : ''; ?>

		</span>

	</li>



	<li>

		<label>Make:</label>

		<span><?php echo !empty($assets_rec_data[0]->asen_make) ? $assets_rec_data[0]->asen_make : ''; ?></span>

	</li>



	<li>

		<label>Model No:</label>

		<span><?php echo !empty($assets_rec_data[0]->asen_modelno) ? $assets_rec_data[0]->asen_modelno : ''; ?></span>

	</li>

	<li>

		<label>Serial No:</label>

		<span><?php echo !empty($assets_rec_data[0]->asen_serialno) ? $assets_rec_data[0]->asen_serialno : ''; ?></span>

	</li>

	<li>

		<label> Asset Status:</label>

		<span><?php echo !empty($assets_rec_data[0]->asst_statusname) ? $assets_rec_data[0]->asst_statusname : ''; ?></span>

	</li>



	<li>

		<label> Asset Condition:</label>

		<span><?php echo !empty($assets_rec_data[0]->asco_conditionname) ? $assets_rec_data[0]->asco_conditionname : ''; ?></span>

	</li>





	<li>

		<label> Accessories:</label>

		<span><?php echo !empty($assets_rec_data[0]->asen_accessories) ? $assets_rec_data[0]->asen_accessories : ''; ?></span>

	</li>

	<li>

		<label> Remarks:</label>

		<span><?php echo !empty($assets_rec_data[0]->asen_remarks) ? $assets_rec_data[0]->asen_remarks : ''; ?></span>

	</li>

	<li class="eqp_cod">

		<label>Assets Code:</label>

		<span>

			<?php

			$equipid = !empty($eqli_data[0]->bmin_equipmentkey) ? $eqli_data[0]->bmin_equipmentkey : '';

			$desc = !empty($eqli_data[0]->eqli_description) ? $eqli_data[0]->eqli_description : '';

			$servicedate = !empty($eqli_data[0]->bmin_servicedatead) ? $eqli_data[0]->bmin_servicedatead : '';

			?>



			<div class="white-box pull-right pad-5">

				<div class="printBox" style="padding:4px !important; text-align: center; max-width: 2in;max-height:1in">

					<?php

					Zend_Barcode::render('code128', 'image', array('text' => $ass_code, 'barHeight' => 42, 'factor' => 4, 'drawText' => false, 'font' => 4), array());

					$buffer = ob_get_contents();



					// return $buffer;

					ob_end_clean();

					?>



					<p style="font-size: 10px; padding: 0px; margin: 0px; display: block; font-weight: 600; "><?php echo ORGA_NAME; ?></p>

					<p style="font-size:9px;padding: 0px; margin: 0px; font-weight: 600;"><?php echo $ass_desc; ?></p>

					<div style="max-width: 1.3in; width: 70%; float:left; padding-top:5px;  ">



						<p style="font-size:9px;padding: 0px; margin: 0px; font-weight: 600;"><?php echo $ass_code; ?></p>



						<?php echo "<img src='data:image/png;base64," . base64_encode($buffer) . "'>"; ?>

					</div>



					<div style="max-width: 0.7in; width:30%; float:right;">

						<?php

						// echo $qr_link;

						// die();

						ob_start();

						header("Content-Type: image/png");

						$params['data'] = $qr_link;

						$this->ciqrcode->generate($params);

						$qr = ob_get_contents();

						ob_end_clean();

						echo "<img src='data:image/png;base64," . base64_encode($qr) . "'>";

						?>

					</div>

					<div class="clearfix"></div>

				</div>

				<!-- <button class="btn btn-xs btn_print" id="barcodePrint"><i class="fa fa-print"></i></button> -->



			</div>

		</span>

	</li>



</ul>



<h5 class="ov_lst_ttl"><b>General</b></h5>

<ul class="pm_data pm_data_body">

	<li>

		<label> Asset Department:</label>

		<span><?php echo !empty($assets_rec_data[0]->dept_depname) ? $assets_rec_data[0]->dept_depname : ''; ?></span>

	</li>

	<li>

		<label> Asset Room:</label>

		<span><?php echo !empty($assets_rec_data[0]->asen_room) ? $assets_rec_data[0]->asen_room : ''; ?></span>

	</li>

	<li>

		<label>Asset Manufacture:</label>

		<span><?php echo !empty($assets_rec_data[0]->manu_manlst) ? $assets_rec_data[0]->manu_manlst : ''; ?></span>

	</li>

	<li>

		<label> Date of Manufacture:</label>

		<span><?php

				if (DEFAULT_DATEPICKER == 'NP') {

					echo !empty($assets_rec_data[0]->asen_manufacture_datebs) ? $assets_rec_data[0]->asen_manufacture_datebs : '';
				} else {

					echo !empty($assets_rec_data[0]->asen_manufacture_datead) ? $assets_rec_data[0]->asen_manufacture_datead : '';
				}

				?></span>

	</li>

	<li>

		<label>Supplier:</label>

		<span><?php echo !empty($assets_rec_data[0]->dist_distributor) ? $assets_rec_data[0]->dist_distributor : ''; ?></span>

	</li>

</ul>