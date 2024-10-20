<style>	
	.table_jo_header, .jo_tbl_head, .jo_table, .jo_footer { width:100%; font-size:12px; border-collapse:collapse; }
	.table_jo_header { width:100%; vertical-align: top; font-size:12px; }
	.table_jo_header td.text-center { text-align:center; }
	.table_jo_header td.text-right { text-align:right; }
	h4 { font-size:18px; margin:0; }
	.table_jo_header u { text-decoration:underline; padding-top:15px; }

	.jo_table { border-right:1px solid #333; border-bottom:1px solid #000; margin-top:5px; }
	.jo_table tr th { border-top:1px solid #333; border-bottom:1px solid #333; border-left:1px solid #333; }

	.jo_table tr th { padding:5px 3px;}
	.jo_table tr td { padding:3px 3px; height:15px; border-left:1px solid #333;font-size: 12px; }
	.jo_table tr td span{font-size: 12px;}
	.jo_footer { vertical-align: top; }
	.jo_footer td { padding:4px 0px;	}
	.bdr-table{border: 1px solid #000;}
	.tableWrapper{
		min-height:50%;
		height:50vh;
		max-height: 100vh;
		white-space: nowrap;
		display: table;
		width: 100%;
		/*overflow-y: auto;*/
	}
		.itemInfo {
		    height: 100%;
		    margin: 0 !important;
		}
	.table_item{
		height:100%;
	}
	.table_item .td_cell{
		padding:5px;
		margin:5px; 
	}
	.table_item .td_empty{
		height:100%;
	}
	.padd-25{
		padding: 25px 0px 0px 5px;
	}
	.amount-table{
		border-collapse: collapse;
		border:1px solid #000;
		border-top: 0px;
		margin: 0px;	
	}
	.amount-table tbody tr td{
		border-bottom:1px solid #000;
		border-right:1px solid #000;
		font-size: 12px;
		padding: 5px 15px;
	}
	.amount-table tbody tr td span{
		font-size: 12px;
		display: inline-block;
		margin:0px;
		padding: 0px;
	}
	.amount-table tbody tr td:first-child{
		border: 1px solid #000;
		border-top:0px;
	}
	.footerWrapper{
		page-break-inside: avoid;
	}	
	.bold_title{
		font-weight: bold;
	}
	.dateDashedLine{
		min-width: 100px;display: inline-block; border:1px dashed #333;
	}
	.signatureDashedLine {
		min-width: 170px;display: inline-block; border:1px dashed #333;
	}
td.td_empty.text-center {
    height: 100% !important;
    padding: 15% 0;
}
</style>

<div class="jo_form organizationInfo">
	<div class="headerWrapper">

		<?php 
            $header['report_no'] = '';
            $header['report_title'] = 'खरिद आदेश';
            $this->load->view('common/v_print_report_header',$header);
        ?>

		<table width="100%">
			<tr style="border-bottom:none;">
				<td style="font-size: 12px;"> 
					<span style="font-size: 12px;" class="bold_title">बिक्रेता: </span> 
					<span style="border-bottom:1px dashed #333">
						<?php 
							echo !empty($order_details[0]->dist_distributor)?$order_details[0]->dist_distributor:'';
						?>
					</span>
				</td>
				<td></td>
				<td class="text-left" width="15%" style="font-size: 12px;"><span style="text-align: left;font-size: 12px;" class="bold_title">खरिद आदेश नं: </span> 
					<span style="border-bottom:1px dashed #333">
						<?php 
							echo !empty($order_details[0]->puor_orderno)?$order_details[0]->puor_orderno:'';
						?>
					</span>
				</td>
			</tr>
			
			<tr style="border-bottom:none;">
				<td style="font-size: 12px;"><span style="font-size: 12px;" class="bold_title">ठेगाना: </span>
					<span style="border-bottom:1px dashed #333">
						<?php  
							echo !empty($order_details[0]->dist_address1)?$order_details[0]->dist_address1:'';
						?>
					</span>
				</td>
				<td></td>
				<td width="15%" class="text-left" style="font-size: 12px;">
					<span style="font-size: 12px;" class="bold_title">
						मिति : 
					</span>
					<span style="border-bottom:1px dashed #333">
					<?php 
						if(DEFAULT_DATEPICKER == 'NP'){
							$orderdate = !empty($order_details[0]->puor_orderdatebs)?$order_details[0]->puor_orderdatebs:'';
						}else{
							$orderdate = !empty($order_details[0]->puor_orderdatead)?$order_details[0]->puor_orderdatead:'';
						}

						if($order_details){
							echo $orderdate;
						}else{
							echo CURDATE_NP;
						}
					?>
					</span>
				</td>
			</tr>
		
			<tr style="border-bottom:none;">
				<td style="font-size: 12px;">
				</td>
				<td>&nbsp;</td>
				<td class="text-left" width="15%" style="font-size: 12px;"><span style="text-align: left;font-size: 12px;" class="bold_title">माग फाराम नं </span>: 
					<span style="border-bottom:1px dashed #333">
						<?php 
							echo !empty($order_details[0]->puor_requno)?$order_details[0]->puor_requno:'';
						?>
					</span>
				</td>
			</tr>
		
			<tr style="border-bottom:none;">
				<td style="font-size: 12px;">
				</td>
				<td>&nbsp;</td>
				<td class="text-left" width="15%" style="font-size: 12px;"><span style="text-align: left;font-size: 12px;" class="bold_title">मिति </span>: 
					<span style="border-bottom:1px dashed #333">
						<?php 
							if(DEFAULT_DATEPICKER == 'NP'){
								$orderdate = !empty($order_details[0]->pure_reqdatebs)?$order_details[0]->pure_reqdatebs:'';
							}else{
								$orderdate = !empty($order_details[0]->pure_reqdatead)?$order_details[0]->pure_reqdatead:'';
							}

							if($order_details){
								echo $orderdate;
							}else{
								echo CURDATE_NP;
							}
						?>
					</span>
				</td>
			</tr>
		</table>
	</div>

	<div class="tableWrapper">
		<table  class="jo_table itemInfo table_item" border="1" style="margin: 0 !important;">
			<thead>
				<tr>
					<th rowspan="2" class="td_cell text-center" style="border-left: none;"> सि.नं. </th>
					<!-- <th rowspan="2" class="td_cell text-center"> बजेट शीर्षक नं. </th> -->
					<th rowspan="2" class="td_cell text-center"> सामानको विवरण </th>
					<!-- <th rowspan="2" class="td_cell text-center"> स्पेसिफिकेशन  </th> -->
					<th rowspan="2" class="td_cell text-center"> परिमाण </th>
					<th rowspan="2" class="td_cell text-center"> इकाई </th>
					<th rowspan="2" class="td_cell text-center"> दर </th>
					<th colspan="1" class="td_cell text-center">जम्मा रकम </th>
					<th rowspan="2" class="td_cell text-center" style="border-right: none;"> कैफियत </th>
				</tr>
				<tr>
					<th  class="td_cell text-center">रु.</th>
				</tr>
		
			</thead>
			<tbody>
				<?php
					$sub_total = 0; 
					if($order_details){ //echo"<pre>"; print_r($order_details);die;
					foreach ($order_details as $key => $dprint) { ?>
				<tr>
					<td  class="td_cell">
						<?php echo $key+1; ?>
					</td>
					
					<td  class="td_cell">
						<?php 
                          if(ITEM_DISPLAY_TYPE=='NP')
                            {
                                 echo !empty($dprint->itli_itemnamenp)?$dprint->itli_itemnamenp:$dprint->itli_itemname;
                            }
                            else
                            {
                                 echo  !empty($dprint->itli_itemname)?$dprint->itli_itemname:'';
                            } 
                        ?>
					</td>
					<!-- <td>
					</td> -->
					<td  class="td_cell">
						<?php echo !empty($dprint->pude_quantity)?$dprint->pude_quantity:0; ?>
					</td>
					<td  class="td_cell">
						<?php echo !empty($dprint->unit_unitname)?$dprint->unit_unitname:''; ?>
					</td>
					
					<td  class="td_cell" style="text-align: right;">
						<?php echo !empty($dprint->pude_rate)?number_format($dprint->pude_rate,2):0; ?>
					</td>
					<td  class="td_cell" style="text-align: right;">
						<?php 
							$qty = !empty($dprint->pude_quantity)?$dprint->pude_quantity:0;
							$rate = !empty($dprint->pude_rate)?$dprint->pude_rate:0;
							$amt = $qty*$rate;
							echo !empty($amt)?number_format($amt,2):0; 
						?>
					</td>
					<td  class="td_cell">
						<?php echo !empty($dprint->pude_remarks)?$dprint->pude_remarks:''; ?>
					</td>
				</tr>
				<?php	
					$sub_total += $amt;
				 	} 
				 ?>

				<?php
					$row_count = count($order_details);

					if($row_count < 9):
				?>
				<tr>
					<td class="td_empty"></td>
					<!-- <td class="td_empty"></td> -->
					<!-- <td class="td_empty"></td> -->
					<td class="td_empty"></td>
					<td class="td_empty"></td>
					<td class="td_empty"></td>
					<td class="td_empty"></td>
					<td class="td_empty"></td>
					<td class="td_empty"></td>
				</tr>
				<?php endif;?>
				<?php } ?>
			</tbody>
		</table>
	</div>

	<table width="100%" class="amount-table">
		<tbody>
			<tr>
				<td rowspan="3" colspan="4" style="width: 60%" valign="top">
					<span class="bold_title">अक्षरेपी: </span>
					<?php
						$total = !empty($order_details[0]->puor_amount)?$order_details[0]->puor_amount:0; 
						if($total){
                            echo $this->general->number_to_word($total);
                        }
                    ?> 
				</td>
				<td style="text-align: right;">
					<span class="bold_title">जम्मा</span>
				</td>
				<td style="text-align: right;"><?php echo !empty($sub_total)?number_format($sub_total,2):''; ?></td>
			</tr>

			<tr>
				<td style="text-align: right">
					 <span class="bold_title">१३% मु.अ.क. </span>
				</td>
				<td style="text-align: right;"><?php echo !empty($order_details[0]->puor_vatamount)?number_format($order_details[0]->puor_vatamount,2):''; ?></td>
			</tr>

			<tr>
				<td style="text-align: right">
					<span class="bold_title">कूल  जम्मा </span>
				</td>
				<td style="text-align: right;">
					<?php echo !empty($order_details[0]->puor_amount)?number_format($order_details[0]->puor_amount,2):''; ?>
				</td>
			</tr>	
		</tbody>
	</table>

	<?php 
		$puor_verified = !empty($order_details[0]->puor_verified)?$order_details[0]->puor_verified:'';
	?>

	<div class="footerWrapper" style="margin-top: -5px;">
		<table class="jo_footer" style="width: 100%;">
			<tfoot>
				<tr>
					<td>
						<table style="width: 100%;" class="inner-table" border="1">
							<tr style="border-bottom: none;">
								<td class="padd-25" style="font-size: 12px;padding: 25px 0px 0px 5px; ">
									<span class="bold_title">तयार गर्ने: </span> 
									<span style="min-width: 170px;display: inline-block; border:1px dashed #333;"></span>
								</td>

								<td style="text-align: left;font-size: 12px;padding: 25px 0px 0px 5px;">	<span class="bold_title">पेश गर्ने: </span> 
									<span style="min-width: 170px;display: inline-block; border:1px dashed #333;"></span>
								</td>

								<td style="text-align: left;font-size: 12px;padding: 25px 0px 0px 5px;">	<span class="bold_title">स्वीकृत गर्ने: </span> 
									<span style="min-width: 170px;display: inline-block; border:1px dashed #333;"></span>
								</td>
							</tr>

							<tr style="border-bottom: none;">
								<td style="font-size: 12px;padding: 15px 0px 0px 5px;"> 
									<span class="bold_title">नाम:<?php echo $name1 ?> </span> 
									<span style="min-width: 200px;display: inline-block; border:1px dashed #333;"></span>
								</td>

								<td style="text-align: left;font-size: 12px;padding: 15px 0px 0px 5px;">
									<span class="bold_title">नाम:
										<?php
											if($puor_verified == 1 || $puor_verified == 2):
										?>
										<?php echo $name2 ?> 
										<?php endif; ?>
										</span>
									<span style="min-width: 200px;display: inline-block; border:1px dashed #333;"></span></td>
								<td style="text-align: left;font-size: 12px;padding: 15px 0px 0px 5px;">
									<span class="bold_title">नाम:
										<?php
											if($puor_verified == 2):
										?>
										<?php echo $name3 ?> 
										<?php
											endif;
										?></span>
									<span style="min-width: 200px;display: inline-block; border:1px dashed #333;"></span></td>
							</tr>

							<tr style="border-bottom: none;">
								<td style="font-size: 12px;padding: 15px 0px 10px 5px;">
									<span class="bold_title">पद:<?php //echo $desig1 ?> </span> 
									<span style="min-width: 200px;display: inline-block; border:1px dashed #333;"></span>
								</td>
								
								<td style="text-align: left;font-size: 12px;padding: 15px 0px 10px 5px;">
									<span class="bold_title">पद :<?php //echo $desig2 ?> </span>
									<span style="min-width: 200px;display: inline-block; border:1px dashed #333;"></span>
								</td>
								
								<td style="text-align: left;font-size: 12px;padding: 15px 0px 10px 5px;">
									<span class="bold_title">पद : <?php //echo $desig3 ?></span>
									<span style="min-width: 200px;display: inline-block; border:1px dashed #333;"></span>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>