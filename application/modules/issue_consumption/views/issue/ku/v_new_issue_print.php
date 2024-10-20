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

            padding:.25rem !important    

        }

        .ku.table th {

            text-align: center !important;

            font-weight: 600;

            font-size: 15px

            color: #000;

        }

        .ku.table-bordered td, .ku.table-bordered th {

            border-color: black !important;

            border-bottom-width: 1px !important;

        }

         .ku.table tbody tr td.td_empty {

             height: 300px;

         }

        .ku_bottom {

            display:grid;

            grid-template-columns: repeat(5,18%);

            grid-column-gap: 2em;

            align-items: center;

            padding: 2rem 0rem 2rem;

            text-align: center;

            color: #000;

        }

        .ku_bottom > div {position: relative;}

        .ku_bottom p {

        	margin:0;

        }

        .ku_bottom h6 {

            border-top:1.5px dotted;

            text-align: center;

            padding:.75rem 0 .5rem;

            font-size: 15px;

        }

        .ku_bottom > div > span{

        	position: absolute;top:-10px;

        	left: 40%;

        }

        .ku_bottom p span {

            border-bottom: 1.5px dotted;

                width: 75%;

                padding:0;

    display: inline-block;

        }

        .ku.table tfoot th {

            text-align: right !important;

            padding:.25rem !important

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

        .details_individual{

            display: grid;

            grid-template-columns: 75% 25%;

            align-items: center;

        }

        .details_individual h6 .value , .remarks, .received{

            text-transform: uppercase;

        }

        .ku.table tfoot th[colspan="4"]{

            text-align: center !important;

        }

        .note {

            border-top:1.5px solid #000;

            padding-top: .25rem;

            font-weight: bold;

        }

        .other_details p {

        	font-weight: 600;

        }

         .other_details span{

         	font-weight: 400; 

         	line-height: 1

         }

</style>

<div class="jo_form organizationInfo">

	<div class="headerWrapper" style="margin-bottom: -25px;">

		<?php 

			$header['report_no'] = 'फाराम न. ७';

			// $header['old_report_no'] = 'साबिकको फारम न. ५१';

			$mattype = !empty($issue_master[0]->sama_mattypeid)?$issue_master[0]->sama_mattypeid:'';

			if($mattype == '1'){

				$header['report_title'] = 'नखप्ने सामान माग फाराम';

			}else{

				$header['report_title'] = 'खप्ने सामान माग फाराम';

			}

			$header['show_department'] = 'Y';

			$dep_code = !empty($issue_master[0]->sama_depname)?$issue_master[0]->sama_depname:'';

			$header['dep_code'] = $dep_code;

			$this->load->view('common/v_print_report_header',$header);

		?>

		<table class="jo_tbl_head" width="100%" style="border-collapse: collapse;">

			<tr>

				<td width="30%">

				 <p class="mb-1">सि.न. </p>

			            <p>श्री स्टोर इन्चार्ज,</p>

			            <p>कृपया तलका सामानहरु दिनु होला ।</p>

				</td>

				<td width="40%">

					निकासी नं :<u><?php echo !empty($issue_master[0]->sama_invoiceno)?$issue_master[0]->sama_invoiceno:'';?></u>

				</td>

				<td width="30%" style="text-align: left;">

				<div class="other_details text-left">

		            <p>स्कुल :- <span><?php 

						echo !empty($issue_master[0]->loca_name)?$issue_master[0]->loca_name:'';

					?> </span></p>

		            <p>विभाग :- <span><?php echo $dep_code; ?></span></p>

		            <p>मा.फा.न. :- 

		            	<?php

						if(!empty($issue_master)){ ?>

							<span > 

								<?php 

							echo !empty($issue_master[0]->sama_requisitionno)?$issue_master[0]->sama_requisitionno:''; ?> 

							</span>

						<?php }else{ ?>

						<span >

						 	<?php echo '--'; ?>

						</span>

						<?php } ?>

		            </p>

		            <p>माल सामान समुह :- 

		            	<span>

		            	<?php 

						echo !empty($stock_requisition[0]->categories)?$stock_requisition[0]->categories:'';

					?>

				</span>

		            </p>

		        </div>

				</td>

			</tr>

		</table>

	</div>

	<div class="tableWrapper">

		<table  class="ku table table-bordered " width="100%" style="margin:2rem 0">

			<thead>

				<tr>

					<th width="5%" class="td_cell">सि.न.</th>

					<th width="25%" class="td_cell">विवरण<br>(आकृति, बनोट इवं विशेषता)  </th>

					<th width="15%"  class="td_cell">एकाई  </th>

					<th width="10%"  class="td_cell">माग गरेको परिमाण </th>

					<th width="10%"  class="td_cell">निकासी गरेको परिमाण</th>

					<th width="10%" class="td_cell">खाता पाना </th>

					<th width="10%" class="td_cell">दर </th>

					<th width="10%" class="td_cell">रकम्(रु)</th>

					<th width="10%" class="td_cell">कैफियत </th>

				</tr>

			</thead>

			<tbody>

				<?php if(!empty($issue_details)){  //echo"<pre>";  print_r($issue_details);die;

					foreach($issue_details as $key => $isdet){ ?>

				<tr>

					<td class="td_cell">

						<?php echo $key+1; ?>

					</td>

						<td class="td_cell">

							<?php 

							if(ITEM_DISPLAY_TYPE=='NP'){

								$item_name=!empty($isdet->itli_itemnamenp)?$isdet->itli_itemnamenp:$isdet->itli_itemname;

							}else

							{

								$item_name=!empty($isdet->itli_itemname)?$isdet->itli_itemname:'';



							}

							echo $item_name.'('.$isdet->itli_itemcode.')';

							?>

						</td>

						<td class="td_cell">

							<?php echo !empty($isdet->unit_unitname)?$isdet->unit_unitname:''; ?>

						</td>

						<td class="td_cell">

							<?php echo !empty($isdet->rede_qty)?$isdet->rede_qty:''; ?>

						</td>

						<td class="td_cell">

							<?php echo !empty($isdet->sade_qty)?$isdet->sade_qty:''; ?>

						</td>

						<td class="td_cell">

							<?php echo !empty($isdet->eqca_code)?$isdet->eqca_code:''; ?>

						</td> 

						<td class="td_cell">

						<?php echo !empty($isdet->sade_unitrate)?$isdet->sade_unitrate:''; ?>	

						</td>

						<td class="td_cell">

						<?php  

							$sqty=!empty($isdet->sade_qty)?$isdet->sade_qty:'0.00';

							$srate=!empty($isdet->sade_unitrate)?$isdet->sade_unitrate:'';

							$total=$sqty*$srate;

							echo number_format($total,2);

						?>

						</td>

						<td class="td_cell">

							<?php echo !empty($isdet->sade_remarks)?$isdet->sade_remarks:''; ?>

						</td>

					</tr>

				<?php //$sumnewno += $newno; 

			}?>

			<?php

					$row_count = (is_array($isdet))?count($isdet):0;

					if($row_count < 15):

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

				<?php endif;?>

				<?php }else{ ?>

				<?php 

				$itemid = !empty($report_data['sade_itemsid'])?$report_data['sade_itemsid']:'';

				if(!empty($itemid)): // echo"<pre>";print_r($itemid);die;

				

				foreach($itemid as $key=>$products):

			?>

			<tr>

				<td class="td_cell" style="text-align: center">

					<?php echo $key+1; ?>

				</td>

				<td class="td_cell" style="text-align: center">

									

					<?php 

						$itemid = !empty($report_data['sade_itemsid'][$key])?$report_data['sade_itemsid'][$key]:'';

						$itemname =  $this->general->get_tbl_data('*','itli_itemslist',array('itli_itemlistid'=>$itemid),false,'DESC');

						

						if(ITEM_DISPLAY_TYPE=='NP'){

                    	$iss_itemname = !empty($itemname[0]->itli_itemnamenp)?$itemname[0]->itli_itemnamenp:$itemname[0]->itli_itemname;

		                }else{ 

		                    $iss_itemname = !empty($itemname[0]->itli_itemname)?$itemname[0]->itli_itemname:'';

		                }

		                $iss_code=!empty($itemname[0]->itli_itemcode)?$itemname[0]->itli_itemcode:'';



						echo $iss_itemname.'('.$iss_code.')';



					?>



				</td>

				

				<td class="td_cell" style="text-align: center">

					<?php echo !empty($report_data['unit'][$key])?$report_data['unit'][$key]:''; ?> 

				</td>



				<td class="td_cell" style="text-align: center">

					<?php echo !empty($report_data['remqty'][$key])?$report_data['remqty'][$key]:''; ?>

				</td>

				<td class="td_cell" style="text-align: center">

					<?php echo !empty($report_data['sade_qty'][$key])?$report_data['sade_qty'][$key]:''; ?>

				</td>

				<td class="td_cell" style="text-align: center">



				</td>

				<td class="td_cell" style="text-align: center">

					

				</td>

				<td class="td_cell" style="text-align: center">

					

				</td>

				<td class="td_cell" style="text-align: center">

					<?php echo !empty($report_data['sade_remarks'][$key])?$report_data['sade_remarks'][$key]:''; ?>

				</td>

			</tr>

			<?php

				endforeach;?>

				<?php

						$row_count = count($report_data['sade_itemsid']);



						if($row_count < 12):

					?>

				<tr>

						<td class="td_empty" style="text-align: center"></td>

						<td class="td_empty" style="text-align: center"></td>

						<td class="td_empty" style="text-align: center"></td>

						<td class="td_empty" style="text-align: center"></td>

						<td class="td_empty" style="text-align: center"></td>

						<td class="td_empty" style="text-align: center"></td>

						<td class="td_empty" style="text-align: center"></td>

						<td class="td_empty" style="text-align: center"></td>

						<td class="td_empty" style="text-align: center"></td>

					</tr>

				<?php endif ?>

				<?php

				endif;

			}

			?>

			</tbody>

		</table>

	</div>

	<div class="ku_bottom">

        <div>

        	<span><?php echo !empty($requisition_data[0]->rema_reqby)?$requisition_data[0]->rema_reqby:'';?> </span>

            <h6>माग गर्ने</h6>

            <p>मिति: <span>	<?php echo !empty($requisition_data[0]->rema_reqdatebs)?$requisition_data[0]->rema_reqdatebs:'';?></span></p>

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

