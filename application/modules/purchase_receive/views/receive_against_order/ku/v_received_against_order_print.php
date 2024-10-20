<style>	

	@page  {

    	size: auto;   

    	margin: 10mm;  

    } 



	

  h5 {

            margin: 0 0 10px;

            font-size: 16px;

            font-weight: 600;

        }



        h6 {

            font-size: 16px;

            font-weight: 600

        }

    .ku_details h6 {

    	margin-bottom: .5rem

    }

	.ku_table td,

        .ku_table th {

            padding: .5rem .5rem  .25rem !important;

            font-size: 15px;

            border:0 !important;

            

        }

        .ku_table td{

            font-size: 14px;

            padding:.25rem !important;

            vertical-align: middle !important;

        }

           .ku_table th {

            vertical-align: middle !important; 

            font-weight: 600;

        }



        .ku_table thead{

            border-color: black !important;

            border-bottom: 1px solid !important;

        }

        .ku_table tfoot {

            border-top: 1.5px solid #000

        }



        .ku_bottom {

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding: 5rem 1rem;

        }

        .ku_table tfoot th {

            text-align: right !important;

            padding:0rem .25rem !important

        }



        .ku_bottom h6 {

            padding: .5rem 2rem 0;

            border-top: 1px solid;

            text-align: center;

            font-weight: 700;

        }

         .ku_print_header {

           /* display: grid;

            grid-template-columns: 25% 50% 25%;*/

            padding-bottom: .75rem;

            margin-bottom: .75rem;

/*            border-bottom: 1px solid #000;
*/
        }

        .ku_print_header .title{

            text-align: center;

        }

         .ku_print_header .title h5{

            font-weight: 600;

            color: #000;

            font-size: 1.375rem;

            margin:0;

        }

        .ku_print_header .title span{

            text-transform: uppercase;

            font-weight: 600;

            color: #000;



        }

        .ku_details ,.ku_table-wrapper{

            padding-left:1.275rem;padding-right: 1.275rem;

        }

  

        .ku_print_header .page {

            text-align: right;

            align-self: flex-start;

        }

        .ku_details_individual{

            display: grid;

            grid-template-columns: 60% 35%;

            grid-column-gap: 2em;

            align-items: center;

        }

        .ku_details_individual h6 .value , .remarks, .received{

            text-transform: uppercase;

        }

        .ku_table tfoot th[colspan="4"]{

            text-align: center !important;

        }

         .ku_double h6{

             text-align: left;

             width: 70%;

            color: #000;

             font-weight: bold;

             margin: 0 auto;

         }

          h6.ku_double-border{

            padding-bottom: .35rem;

             color: #000;

             font-weight: bold;



          }

         .ku_double-border {

            position: relative;

            border-bottom: 4px double #000 !important;

        }

</style>



<div class="jo_form organizationInfo">

	<div class="headerWrapper"  >

		<div class="ku_print_header">

		<?php 

			$header['report_no'] = '';

			$header['old_report_no'] = '';

            $header['report_title'] = 'INVENTORY ENTRY REPORT';

            $this->load->view('common/v_print_report_header',$header);

        ?>



        <div class="text-right page" style="margin-bottom: 2rem">Page No.: </div>



        <div class="text-right">Print Date: <?php echo CURDATE_NP.' '.date('h:i A');?></div>

    </div>

		

		<div class="ku_details">

        <div class="ku_details_individual">

            <h6>

                Supplier Name : 

                <span class="ku_value">

                	<?php echo !empty($req_detail_list[0]->dist_distributor)?$req_detail_list[0]->dist_distributor:'';  ?>

                </span>

            </h6>

            <h6>

                A.C Head :

                <span class="ku_value"></span>

            </h6>

        </div>

        <div class="ku_details_individual">

            <h6>

                Bill / Invoice :

                <span class="ku_value">

                	<?php echo !empty($req_detail_list[0]->recm_supplierbillno)?$req_detail_list[0]->recm_supplierbillno:'';  ?>

                </span>

            </h6>

            <h6>

                Entry No :

                <span class="ku_value">

                	<?php

						if($req_detail_list){

						 echo !empty($req_detail_list[0]->recm_invoiceno)?$req_detail_list[0]->recm_invoiceno:'';  

						} else{

						echo !empty($report_data['received_no'])?$report_data['received_no']:''; } ?>

                </span>

            </h6>

        </div>

        <div class="ku_details_individual">

            <h6>

                Date :

                <span class="ku_value">

                	<?php 

						if($req_detail_list)

						{	

							if(DEFAULT_DATEPICKER == 'NP'){

								echo !empty($direct_purchase_master[0]->recm_supbilldatebs)?$direct_purchase_master[0]->recm_supbilldatebs:'';

							}else{

								echo !empty($direct_purchase_master[0]->recm_supbilldatead)?$direct_purchase_master[0]->recm_supbilldatead:'';

							}

						} else{

							if(DEFAULT_DATEPICKER == 'NP'){

								echo CURDATE_NP;	

							}else{

								echo CURDATE_EN;

							}

						} 

					?>

                </span>

            </h6>

            <h6>

                Date :

                <span class="ku_value">

                	<?php 

						if($req_detail_list)

						{	

							if(DEFAULT_DATEPICKER == 'NP'){

								echo !empty($direct_purchase_master[0]->recm_receiveddatebs)?$direct_purchase_master[0]->recm_receiveddatebs:'';

							}else{

								echo !empty($direct_purchase_master[0]->recm_receiveddatead)?$direct_purchase_master[0]->recm_receiveddatead:'';

							}

						} else{

							if(DEFAULT_DATEPICKER == 'NP'){

								echo CURDATE_NP;	

							}else{

								echo CURDATE_EN;

							}

						} 

					?>

                </span>

            </h6>

        </div>

    </div>

    

	

	<div class="ku_table-wrapper">

    <table class="ku_table table table-borderless " width="100%" style="margin:1.5rem 0">

        <thead>

            <tr>

                <th width="10%">Inv No</th>

                <th width="18%">Description</th>

                <th>Unit</th>

                <th>Qty</th>

                <th>Rate</th>

                <th style="text-align: right;">Amount</th>

                <th style="text-align: center !important;">Vat</th>

                <th>Remarks</th>

                <th>Received By</th>

            </tr>

        </thead>

        <tbody>

        	<?php 

				if($req_detail_list){

					$sum= 0; $vatsum=0;

                    

                    foreach ($req_detail_list as $key => $direct) { ?>

	            		<tr>

							<td class="td_cell">

								<?php echo !empty($direct->eqca_jinsicode)?$direct->eqca_jinsicode:''; ?>

							</td>

							<td width="500px" class="td_cell">

								<?php

									if(ITEM_DISPLAY_TYPE=='NP'){

					                	echo !empty($direct->itli_itemnamenp)?$direct->itli_itemnamenp:$direct->itli_itemname;

					                }else{ 

					                    echo !empty($direct->itli_itemname)?$direct->itli_itemname:'';

					                }

								?>

							</td>

			                <td class="td_cell">

			                    <?php echo !empty($direct->unit_unitname)?$direct->unit_unitname:''; ?>

			                </td>



				            <td class="td_cell">

				            	<?php echo number_format($direct->recd_purchasedqty); ?>

				            </td>



			                <td class="td_cell">

			                  	<?php 

			                  		$unit_price = !empty($direct->recd_unitprice)?$direct->recd_unitprice:''; 

			                  		echo number_format($unit_price,2);

			                  	?>

			                </td>

							<td class="td_cell" style="text-align: right">

								<?php 

									$total_wo_vat = $direct->recd_purchasedqty*$direct->recd_unitprice; 

									echo number_format($total_wo_vat,2);

								?>

							</td>

							<td class="td_cell" style="text-align: center !important;">

								<?php 

									echo $direct->recd_vatamt;

								?>

							</td>

					

							 <td class="td_cell ku_remarks">

								<?php echo $direct->recd_description; ?>

							</td>

							<td class="td_cell ku_received"></td>

						</tr>

						<?php

							$sum += $direct->recd_discountamt;

					 		$vatsum += $direct->recd_vatamt;

					 	}

					}

				

						$row_count = count($req_detail_list);

						if($row_count < 11): ?>

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

				 	<?php 

				 		$total = $direct->recm_clearanceamount;

				  	?>

        	</tbody>

        	

        	<tfoot>

	            <tr>

	                <th colspan="10" style="padding:8px !important"></th>

	            </tr>

	            <tr>

	                <th colspan="4">



	                </th>

	                <th style="border-top: 1px solid !important;border-bottom: 1px solid !important;" colspan="2"> <?php echo !empty($total_wo_vat)?number_format($total_wo_vat,2):0; ?></th>

	                <th style="text-align: center !important;"><?php echo !empty($vatsum)?number_format($vatsum,2):0; ?></th>

	            </tr>

	            <tr >

	                <th style="padding-top:1.2rem !important" colspan=""></th>

	                <th style="padding-top:1.2rem !important" colspan="3" class="ku_double"><h6>Discount :</h6></th>

	                <th style="padding-top:1.2rem !important" colspan="2"><?php echo !empty($sum)?number_format($sum,2):0; ?></th>

	            </tr>

	            <tr>

	                <th></th>

	                <th  colspan="3" class="ku_double"><h6 class="ku_double-border">Grand Total :</h6></th>

	                <th colspan="2"><h6  class="ku_double-border"><?php echo !empty($total)?number_format($total,2):0; ?></h6></th>

	            </tr>

	        </tfoot>

    </table>

    </div>

    <div class="ku_bottom">

        <h6>Prepared by</h6>

        <h6>Checked by</h6>

    </div>

	

	</div>

</div>