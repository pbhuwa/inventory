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
		min-height:20%;
		height:20vh;
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
</style>

<div class="jo_form organizationInfo">
	<div class="headerWrapper">

		<?php 
            $header['report_no'] = 'म.ले.प.फा.नं ४५';
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
				<td class="text-right" width="25%" style="font-size: 12px;"><span style="text-align: right;font-size: 12px;" class="<?php echo FONT_CLASS; ?>">खरिद आदेश नं </span>: 
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
				<td style="font-size: 12px;"><span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">ठेगाना</span>
					<span style="border-bottom:1px dashed #333">
						<?php if($order_details){
						    echo !empty($order_details[0]->dist_address1)?$order_details[0]->dist_address1:'';
						}else{
							echo $supplieraddress; 
						} ?>
					</span>
				</td>
				<td></td>
				<td width="17%" class="text-right" style="font-size: 12px;">मिति : 
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
				<td style="font-size: 12px;">
					TPIN/PAN :
				</td>
			</tr>
			<tr>
				<td style="font-size: 12px;">
					<span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">करदाता नं </span> : 
					<span style="border-bottom:1px dashed #333">
						<?php if($order_details){
						    echo !empty($order_details[0]->dist_govtregno)?$order_details[0]->dist_govtregno:'';
						}else{
							echo $supplierregno; 
						} ?>
					</span>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<?php 
					if($order_details){
						$delivery_date = !empty($order_details[0]->puor_deliverydatebs)?$order_details[0]->puor_deliverydatebs:'';
						$delivery_site = !empty($order_details[0]->puor_deliverysite)?$order_details[0]->puor_deliverysite:'';
					}else{
						$delivery_date = !empty($report_data['delevery_date'])?$report_data['delevery_date']:'';
						$delivery_site = !empty($report_data['delevery_site'])?$report_data['delevery_site']:'';
					} 
				?>
				
				<td style="font-size: 12px;white-space: nowrap;"><span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">देहाय बमोजिमका सामान हरु मिति </span> <span style="border-bottom: 1px dashed #333"><?php 
				if($order_details){ 
					echo !empty($order_details[0]->puor_deliverydatebs)?$order_details[0]->puor_deliverydatebs:'';
				}else{
					echo $delivery_date; 
			    } ?> </span> <span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">भित्र </span>
				 <span style="border-bottom: 1px dashed #333">
					<?php 
					if($order_details){ 
						echo !empty($order_details[0]->puor_deliverysite)?$order_details[0]->puor_deliverysite:'';
					}else{
						echo $delivery_site;
					} ?></span>
					<span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">कार्यालयमा दाखिला गरी बिल इन्भोईस प्रस्तुत गर्नु होला ।</span></td>
				<td>&nbsp;</td>
			</tr> 
		</table>
	</div>

	<div class="tableWrapper">
		<table  class="jo_table itemInfo table_item" border="1">
			<thead>
				<tr>
					<th rowspan="2" class="td_cell"> क्र. सं. </th>
					<th rowspan="2" class="td_cell"> बजेट शीर्षक नं. </th>
					<th rowspan="2" class="td_cell"> मालसामानको विवरण </th>
					<th rowspan="2" class="td_cell"> स्पेसिफिकेशन  </th>
					<th rowspan="2" class="td_cell" width="50x;"> सामानको परिमाण </th>
					<th rowspan="2" class="td_cell"> एकाइ </th>
					<th colspan="2" class="td_cell"> मुल्य </th>
					<th rowspan="2" class="td_cell"> कैफियत </th>
				</tr>
				<tr>
					<th  class="td_cell">दर</th>
					<th  class="td_cell">जम्मा रकम </th>
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
					<td  class="td_cell"></td>
					
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

	<table width="100%" class="amount-table">
		<tbody>
			<tr>
				<td width="78.3%" style="text-align: right;">
					<span class="<?php echo FONT_CLASS; ?>">जम्मा</span>:
				</td>
				<td style="text-align: right;"><?php echo !empty($sub_total)?number_format($sub_total,2):''; ?></td>
			</tr>
			<tr>
				<td width="78.3%" style="text-align: right">
					<span class="<?php echo FONT_CLASS; ?>">कुल छूट रकम</span>: 
				</td>
				<td style="text-align: right;"><?php echo !empty($order_details[0]->puor_discount)?number_format($order_details[0]->puor_discount,2):''; ?></td>
			</tr>

			<tr>
				<td width="78.3%" style="text-align: right">
					 <span class="<?php echo FONT_CLASS; ?>">कूल  भ्याट रकम </span>:
				</td>
				<td style="text-align: right;"><?php echo !empty($order_details[0]->puor_vatamount)?number_format($order_details[0]->puor_vatamount,2):''; ?></td>
			</tr>

			<tr>
				<td width="78.3%"  style="text-align: right">
					<span class="<?php echo FONT_CLASS; ?>">कूल  जम्मा </span>:
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
	
	<div class="footerWrapper">
		<table class="jo_footer" style="width: 100%;">
			<tfoot>
				<tr>
					<td>
						<table style="width: 100%;" class="inner-table">
							<tr>
								<td class="padd-25" style="font-size: 12px;padding-top: 25px;">  फाँटवालाको दस्तखत: 
									<span style="min-width: 170px;display: inline-block; border:1px dashed #333;"></span></td>
								<td style="text-align: right;font-size: 12px;padding-top: 25px;">शाखा प्रमुखको दस्तखत: 
									<span style="min-width: 170px;display: inline-block; border:1px dashed #333;"></span></td>
							</tr>
							<tr>
								<td style="font-size: 12px;padding-top: 10px;"> मिति: 
									<span style="min-width: 100px;display: inline-block; border:1px dashed #333;"></span>
								</td>
								<td style="text-align: right;font-size: 12px;padding-top: 10px;"> मिति :
									<span style="min-width: 100px;display: inline-block; border:1px dashed #333;"></span></td>
							</tr>
						</table>
					</td>
				</tr>
				
				<tr>
					<td>
					<table class="bdr-table inner-table" style="width: 100%;padding-top: 10px;">
						<tr>
							<td style="font-size: 12px;padding: 4px 8px;"><u>आर्थिक प्रशासन शाखाले भर्ने </u></td>
						</tr>
						<tr>
							<td style="font-size: 12px;padding: 0 8px;">माथि उल्लेखित समानहरु बजेट उपशीर्षक न <span style="min-width: 100px;display: inline-block; border:1px dashed #333;"></span>को खर्च शीर्षक..<span style="min-width: 200px;display: inline-block; border:1px dashed #333;"></span>बाट भुक्तनी दिन बजेट बाँकी देखिन्छ/देखिदैन   ।</td>
						</tr>
						<tr>
							<td>
								<table width="100%;">
							<tr>
							
							<td style="text-align: right;font-size: 12px;padding: 10px 8px;">शाखा प्रमुखको दस्तखत: 
								<span style="min-width: 170px;display: inline-block; border:1px dashed #333;"></span>
							</td>
						</tr>
						<tr>
							<td style="text-align: right;font-size: 12px;padding: 10px 8px;"><span>मिति: <span style="min-width: 100px;display: inline-block; border:1px dashed #333;"></span></span></td>
						</tr>
								</table>
							</td>
						</tr>
					</table>
					</td>
				</tr>
				<tr>
					<td>
					<table class="bdr-table" style="width: 100%;">
						<tr>
							<td></td>
							<td></td>
							<td style="text-align: right;font-size: 12px;padding: 10px 8px;padding-top: 25px;">कार्यलय प्रमुखको दस्तखत: <span style="min-width: 170px;display: inline-block; border:1px dashed #333;"></span></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td style="text-align: right;font-size: 12px;padding: 10px 8px;">मिति: <span style="min-width: 100px;display: inline-block; border:1px dashed #333;"></span></td>
						</tr>
					</table>
				</td>
				</tr>
				<tr>
					<table style="width: 100%;">
						<tr>
							<td style="font-size: 12px;">माथि उल्लेखित समानहरु  मिति <span style="border-bottom: 1px dashed #333;"><?php echo $delivery_date; ?> </span> भित्र <span style="border-bottom: 1px dashed #333;"><?php echo $delivery_site; ?> </span> कार्यालयमा बूझाउने छु भनी सहिछाप गर्ने ।</td>
						</tr>
					</table>
				</tr>
				<tr>
					<table style="width: 100%;">
						<tr>
							<td style="font-size: 12px;padding-top: 7px;">फर्मको नाम </td>
							<td style="text-align: center;font-size: 12px;padding-top: 7px;">दस्तखत</td>
							<td style="text-align: right;font-size: 12px;padding-top: 7px;">मिति</td>
						</tr>
						<tr>
							<td style="padding-top: 25px;">
								<span style="min-width: 170px;display: inline-block; border:1px dashed #333;"></span>
							</td>
							<td style="padding-top:25px;text-align: center;font-size: 12px;"><span style="min-width: 170px;display: inline-block; border:1px dashed #333;"></span></td>
							<td style="padding-top:25px;text-align: right;font-size: 12px;"><span style="min-width: 100px;display: inline-block; border:1px dashed #333;"></span></td>
						</tr>
					</table>
				</tr>
			</tfoot>
		</table>
	</div>
</div>