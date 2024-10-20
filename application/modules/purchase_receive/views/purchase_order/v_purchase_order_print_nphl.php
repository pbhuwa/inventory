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
	.jo_footer td { padding:10px 10px !important; 	}
	.bdr-table{border: 1px solid #000;}
	.tableWrapper{
		min-height:35%;
		height:35vh;
		max-height: 100vh;
		white-space: nowrap;
		display: table;
		width: 100%;
		/*overflow-y: auto;*/
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
		padding-top: 25px;
	}

	.itemInfo .td_cell{
		padding:5px;margin:5px;
		text-align: center;
		font-size: bold; 
	}

	th.td_cell{
		font-weight: bold;
	}
	.amount-table{
		border-collapse: collapse;
		border:1px solid #000;
		border-top: 0px;
		margin: 0px;
		margin-top: 5px;
	
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

	.dateDashedLine{
		min-width: 100px;display: inline-block; border:1px dashed #333;
	}
	.signatureDashedLine {
		min-width: 170px;display: inline-block; border:1px dashed #333;
	}
</style>

<div class="jo_form organizationInfo">
	<div class="headerWrapper">

		<?php 
            $header['report_no'] = 'म.ले.प.फारम.नं ४०२';
            $header['old_report_no'] = 'साबिकको फारम न. ४५';
            $header['report_title'] = 'खरिद आदेश';
            $this->load->view('common/v_print_report_header',$header);
        ?>

		<table width="100%">
			<?php
				$supplierid = !empty($report_data['supplier'])?$report_data['supplier']:'';
				$supplier_data =  $this->general->get_tbl_data('*','dist_distributors',array('dist_distributorid'=>$supplierid),false,'DESC');
				$suppliername = !empty($supplier_data[0]->dist_distributor)?$supplier_data[0]->dist_distributor:'';
				$supplieraddress = !empty($supplier_data[0]->dist_address1)?$supplier_data[0]->dist_address1:'';
				$supplierregno = !empty($supplier_data[0]->dist_govtregno)?$supplier_data[0]->dist_govtregno:'';
				$supplierpanno = !empty($supplier_data[0]->dist_panvatno)?$supplier_data[0]->dist_panvatno:'';
				$supplierphone = !empty($supplier_data[0]->dist_phone1)?$supplier_data[0]->dist_phone1:'';
				echo $supplierphone;
			?>
			<?php 
				if($order_details){
					$delivery_date = !empty($order_details[0]->puor_deliverydatebs)?$order_details[0]->puor_deliverydatebs:'';
					$delivery_site = !empty($order_details[0]->puor_deliverysite)?$order_details[0]->puor_deliverysite:'';
				}else{
					$delivery_date = !empty($report_data['delevery_date'])?$report_data['delevery_date']:'';
					$delivery_site = !empty($report_data['delevery_site'])?$report_data['delevery_site']:'';
				} 
			?>
			<tr>
				<td style="font-size: 12px;"> 
					<span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">श्री</span> 
					<span style="border-bottom:1px dashed #333">
						<?php if($order_details){
						 echo !empty($order_details[0]->dist_distributor)?$order_details[0]->dist_distributor:'';
						}else{
							echo $suppliername; 
						} ?>
					</span>
				</td>
				<td></td>
				<td class="text-left" width="25%" style="font-size: 12px;"><span style="text-align: left;font-size: 12px;" class="<?php echo FONT_CLASS; ?>">
					<strong>खरिद आदेश नं: </strong></span>
					<span style="border-bottom:1px dashed #333">
						<?php 
							if($order_details){
								echo !empty($order_details[0]->puor_orderno)?$order_details[0]->puor_orderno:'';
							}else{
								echo !empty($report_data['order_number'])?$report_data['order_number']:''; 
							} 
						?>
					</span>
				</td>
			</tr>

			<tr>
				<td style="font-size: 12px;"><span style="font-size: 12px;" class="">आदेश गरिएको व्यक्ति/निकायको नाम </span>
					<span style="border-bottom:1px dashed #333">
						<?php if($order_details){
						    echo !empty($order_details[0]->dist_distributor)?$order_details[0]->dist_distributor:'';
						}else{
							echo $suppliername; 
						} ?>
					</span>
				</td>
				<td></td>
				<td width="17%" class="text-left" style="font-size: 12px;">
					<strong>खरिद आदेश मिति : </strong> 
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

			<tr>
				<td style="font-size: 12px;"><span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">ठेगाना</span>
					<span style="border-bottom:1px dashed #333">
						<?php if($order_details){
						    echo !empty($order_details[0]->dist_address1)?$order_details[0]->dist_address1:'';
						}else{
							echo $supplieraddress; 
						} ?>
					</span>
				</td>
				<td class="text-left" width="25%" style="font-size: 12px;">
					<span style="text-align: left;font-size: 12px;" class="">फोन नं:  </span>
					<span style="border-bottom:1px dashed #333">
						<?php echo $supplierphone; ?>
					</span>
				</td>
				<td class="text-left" width="25%" style="font-size: 12px;"><span style="text-align: left;font-size: 12px;" class=""><strong>खरिद सम्बन्धि निर्णय नं: </strong></strong></td>
			</tr>

			<tr>
				<td style="font-size: 12px;">
					<span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">संस्था दर्ता नं </span> : 
					<span style="border-bottom:1px dashed #333">
						<?php if($order_details){
						    echo !empty($order_details[0]->dist_govtregno)?$order_details[0]->dist_govtregno:'';
						}else{
							echo $supplierregno; 
						} ?>
					</span>
				</td>
				<td class="text-left" width="25%" style="font-size: 12px;"><span style="text-align: left;font-size: 12px;" class="">
					पान नं
					<span style="border-bottom:1px dashed #333">
						<?php echo $supplierpanno; ?>
					</span>
				</td>
				<td class="text-left" width="25%" style="font-size: 12px;"><span style="text-align: left;font-size: 12px;" class=""><strong>निर्णय मिति: </strong></td>
			</tr>
		</table>
	</div>

	<div class="tableWrapper" style="margin-top: 0px;">
		<table  class="jo_table itemInfo table_item" border="1">
			<thead>
				<tr>
					<th rowspan="2" class="td_cell text-center"> क्र. सं. </th>
					<th colspan="5" class="td_cell text-center"> सामानको </th>
					<th colspan="2" class="td_cell text-center"> मुल्य </th>
					<th rowspan="2" class="td_cell text-center"> कैफियत </th>
				</tr>
				<tr>

					<th class="td_cell text-center"> जिन्सी वर्गीकरण संकेत नं  </th>
					<th class="td_cell text-center"> नाम </th>
					<th class="td_cell text-center"> स्पेसिफिकेसन  </th>
					<th class="td_cell text-center"> इकाई </th>
					<th class="td_cell text-center"> परिमाण </th>

					<th class="td_cell text-center">दर</th>
					<th class="td_cell text-center">जम्मा </th>
				</tr>

				<tr>
					<td class="td_cell">१</td>
					<td class="td_cell">२</td>
					<td class="td_cell">३</td>
					<td class="td_cell">४</td>
					<td class="td_cell">५</td>
					<td class="td_cell">६</td>
					<td class="td_cell">७</td>
					<td class="td_cell">८</td>
					<td class="td_cell">९</td>
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
						<?php echo !empty($dprint->itli_itemcode)?$dprint->itli_itemcode:''; ?>
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
					<td>
					</td>
					
					<td  class="td_cell">
						<?php echo !empty($dprint->unit_unitname)?$dprint->unit_unitname:''; ?>
					</td>
					
					<td  class="td_cell">
						<?php echo !empty($dprint->pude_quantity)?$dprint->pude_quantity:0; ?>
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
				<?php } ?>
			</tbody>
		</table>
	</div>

	<table width="100%" class="amount-table" style="padding-top: 13px; margin-top: 13px;">
		<tbody>
			<tr>
				<td width="78.3%" style="text-align: right;">
					<span class="<?php echo FONT_CLASS; ?>">जम्मा रकम </span>
				</td>
				<td style="text-align: right;"><?php echo !empty($sub_total)?number_format($sub_total,2):''; ?></td>
			</tr>
		<!-- 	<tr>
				<td width="78.3%" style="text-align: right">
					<span class="<?php echo FONT_CLASS; ?>">कुल छूट रकम</span>: 
				</td>
				<td style="text-align: right;"><?php echo !empty($order_details[0]->puor_discount)?number_format($order_details[0]->puor_discount,2):''; ?></td>
			</tr> -->

			<tr>
				<td width="78.3%" style="text-align: right">
					 <span class="">मु.अ.कर (१३%) </span>
				</td>
				<td style="text-align: right;"><?php echo !empty($order_details[0]->puor_vatamount)?number_format($order_details[0]->puor_vatamount,2):''; ?></td>
			</tr>

			<tr>
				<td width="78.3%"  style="text-align: right">
					<span class="<?php echo FONT_CLASS; ?>">कुल जम्मा रकम  </span>
				</td>
				<td style="text-align: right;">
					<?php echo !empty($order_details[0]->puor_amount)?number_format($order_details[0]->puor_amount,2):''; ?>
				</td>
			</tr>	
			<tr>
				<td colspan="12" style="overflow-wrap: break-word;white-space: nowrap;text-align: center;">शब्दमा : 
					<?php
						$total = !empty($order_details[0]->puor_amount)?$order_details[0]->puor_amount:0; 
						if($total){
                            echo $this->general->number_to_word($total);
                        }
                    ?> 
                </td>
			</tr>
		</tbody>
	</table>

	<table style="margin: 10px 0px;">
		<tr>
			<td style="font-size: 12px;white-space: nowrap;">
				<span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">माथि उल्लेखित सामान मिति </span> 
				<span style="border-bottom: 1px dashed #333">
					<?php 
						if($order_details){ 
							echo !empty($order_details[0]->puor_deliverydatebs)?$order_details[0]->puor_deliverydatebs:'';
						}else{
							echo $delivery_date; 
			    		} 
			    	?> 
			    </span> 
			    <span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">भित्र </span>
			     
			    <span style="border-bottom: 1px dashed #333">
					<?php 
						if($order_details){ 
							echo !empty($order_details[0]->puor_deliverysite)?$order_details[0]->puor_deliverysite:'';
						}else{
							echo $delivery_site;
						} ?>
				</span>
			    कार्यालय
				<span style="border-bottom: 1px dashed #333">
					<?php 
						if($order_details){ 
							echo !empty($order_details[0]->puor_deliverysite)?$order_details[0]->puor_deliverysite:'';
						}else{
							echo $delivery_site;
						}
					?>
				</span>
				<span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">स्थानमा दाखिला गरी बिल इन्भोईस प्रस्तुत गर्नुहोला ।</span>
			</td>
			<td>&nbsp;</td>
		</tr>
	</table>
	
	<div class="footerWrapper">
		<table class="jo_footer" style="width: 100%;  padding-left: 15px; border-bottom: 1px solid #333">
			<tfoot>
				<tr>
					<td>
						<table style="width: 100%;" class="inner-table" style="padding:5px !important; margin: 5px !important;">
							<tr>
								<td colspan="3">
									उपर्युक्त अनुसार खरिद आदेश तयार गर्ने, सिफारिश गर्ने र स्वीकृत गर्ने:
								</td>
							</tr>
							<tr>
								<td style="font-size: 12px;padding-top: 25px;">  फाँटवालाको दस्तखत: 
									<span class="dateDashedLine"></span></td>
								<td style="text-align: left;font-size: 12px;padding-top: 25px;">शाखा प्रमुखको दस्तखत: 
									<span class="dateDashedLine"></span></td>
								<td style="text-align: left;font-size: 12px;padding-top: 25px;">कार्यालय प्रमुखको दस्तखत: 
									<span class="dateDashedLine"></span></td>
							</tr>
							<tr>
								<td style="font-size: 12px;padding-top: 10px;"> नाम: 
									<span class="dateDashedLine"></span></span>
								</td>
								<td style="text-align: left;font-size: 12px;padding-top: 10px;"> नाम :
									<span class="dateDashedLine"></span></span></td>
								<td style="text-align: left;font-size: 12px;padding-top: 10px;"> नाम :
									<span class="dateDashedLine"></span></span></td>
							</tr>
							<tr>
								<td style="font-size: 12px;padding-top: 10px;"> मिति: 
									<span class="dateDashedLine"></span></span>
								</td>
								<td style="text-align: left;font-size: 12px;padding-top: 10px;"> मिति :
									<span class="dateDashedLine"></span></span></td>
								<td style="text-align: left;font-size: 12px;padding-top: 10px;"> मिति :
									<span class="dateDashedLine"></span></span></td>
							</tr>
						</table>
					</td>
				</tr>
			
				<tr>
					<table style="width: 100%;">
						<tr>
							<td colspan="3">माथि उल्लेखित सामानहरु मिति  भित्र  कार्यालयमा बुझाउने छु भनी सहिछाप गर्ने ।</td>
						</tr>
						<tr>
							<td style="width: 33%">फर्मको नाम</td>
							<td style="width: 33%">दस्तखत र छाप </td>
							<td style="width: 33%">मिति </td>
						</tr>
					</table>
				</tr>
			</tfoot>
		</table>
	</div>
</div>