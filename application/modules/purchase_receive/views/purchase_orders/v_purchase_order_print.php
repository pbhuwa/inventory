<style>	
	.table_jo_header, .jo_tbl_head, .jo_table, .jo_footer { width:100%; font-size:12px; border-collapse:collapse; }
	.table_jo_header { width:100%; vertical-align: top; font-size:12px; }
	.table_jo_header td.text-center { text-align:center; }
	.table_jo_header td.text-right { text-align:right; }
	h4 { font-size:18px; margin:0; }
	.table_jo_header u { text-decoration:underline; padding-top:15px; }

	.jo_table { border-right:1px solid #333; border-bottom:1px solid #000; margin-top:5px; margin-bottom:15px; }
	.jo_table tr th { border-top:1px solid #333; border-bottom:1px solid #333; border-left:1px solid #333; }

	.jo_table tr th { padding:5px 3px;}
	.jo_table tr td { padding:3px 3px; height:15px; border-left:1px solid #333;font-size: 12px; }
	.jo_table tr td span{font-size: 12px;}
	.jo_footer { vertical-align: top; }
	.jo_footer td { padding:4px 0px;	}
	.bdr-table{border: 1px solid #000;}
</style>
<div class="jo_form organizationInfo">
		<table class="table_jo_header purchaseInfo">
			<tr>
				<td></td>
				<td class="text-center"><span class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAMETITLE ;?></span></td>
				<td width="30%" class="text-right"><span style="text-align: right; white-space: nowrap;">म.ले.प.फा.नं ४५</span></td>
			</tr>
			<tr>
				<td width="25%" rowspan="5"></td>
				<td class="text-center"><span style="font-size: 18px;font-weight: 600;" class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAME;?></span></td>
				<td width="25%" rowspan="5" class="text-right"></td>
			</tr>
		<tr>
			<td class="text-center" style="font-size: 12px;"><h4 style="font-size: 12px !important;margin-top: 5px;margin-bottom: 0px;"> <span class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAMEDESC;?></span>  </h4></td>
		</tr>
			<tr style="margin-top: 3px;">
			<td class="text-center"><span><?php echo LOCATION; ?></span></td>
		</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class="text-center"><h4 style="margin-top: 0px;"><u><span class="<?php echo FONT_CLASS; ?>">खरिद आदेश</span></u></h4></td>
			</tr>
		</table>
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
					<span style="border-bottom:1px dotted #333">
						<?php if($order_details){
						 echo !empty($order_details[0]->dist_distributor)?$order_details[0]->dist_distributor:'';
						}else{
							echo $suppliername; 
						} ?>
					</span>
				</td>
				<td></td>
				<td class="text-right" width="25%" style="font-size: 12px;"><span style="text-align: right;font-size: 12px;" class="<?php echo FONT_CLASS; ?>">खरिद आदेश न </span>: <?php 
				if($order_details){
					echo !empty($order_details[0]->puor_orderno)?$order_details[0]->puor_orderno:'';
				}else{
					echo !empty($report_data['order_number'])?$report_data['order_number']:''; } ?>
				</td>
			</tr>
			<tr>
				<td style="font-size: 12px;"><span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">ठेगना</span>
					<span style="border-bottom:1px dotted #333">
						<?php if($order_details){
						    echo !empty($order_details[0]->dist_address1)?$order_details[0]->dist_address1:'';
						}else{
							echo $supplieraddress; 
						} ?>
					</span>
				</td>
				<td></td>
				<td width="17%" class="text-right" style="font-size: 12px;">मिति : <?php echo CURDATE_NP;?></td>
			</tr>
			<tr>
				<td style="font-size: 12px;">
					TPIN/PAN :
				</td>
			</tr>
			<tr>
				<td style="font-size: 12px;">
					<span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">करदाता न </span> : 
					<span style="border-bottom:1px dotted #333">
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
					$delivery_date = !empty($report_data['delevery_date'])?$report_data['delevery_date']:'';
					$delivery_site = !empty($report_data['delevery_site'])?$report_data['delevery_site']:''; 
				?>
				
				<td style="font-size: 12px;white-space: nowrap;"><span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">देहाय बमोजिमका सामान हरु मिति </span> <span style="border-bottom: 1px dotted #333"><?php 
				if($order_details){ 
					echo !empty($order_details[0]->puor_deliverydatebs)?$order_details[0]->puor_deliverydatebs:'';
				}else{
					echo $delivery_date; 
			    } ?> </span> <span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>">भित्र </span>
				 <span style="border-bottom: 1px dotted #333">
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

		<table  class="jo_table itemInfo" border="1">
			<thead>
				<tr>
					<th rowspan="2"> क्र. सं. </th>
					<th rowspan="2"> बजेट शीर्षक नं. </th>
					<th rowspan="2"> मालसामानको विवरण </th>
					<th rowspan="2"> स्पेसिफिकेशन  </th>
					<th rowspan="2"> सामानको परिमाण </th>
					<th rowspan="2"> एकाइ </th>
					<th colspan="2"> मुल्य </th>
					<th rowspan="2"> कैफियत </th>
				</tr>
				<tr>
					<th>दर</th>
					<th>जम्मा रकम </th>
				</tr>
			</thead>
			<tbody>
				<?php if($order_details){ //echo"<pre>"; print_r($order_details);die;
					foreach ($order_details as $key => $dprint) { ?>
				<tr>
					<td>
						<?php echo $key+1; ?>
					</td>
					<td></td>
					<td>
						<?php echo !empty($dprint->itli_itemcode)?$dprint->itli_itemcode:''; ?>
					</td>
					<td>
						<?php echo !empty($dprint->itli_itemname)?$dprint->itli_itemname:''; ?>
					</td>
					<td>
						<?php echo !empty($dprint->pude_rate)?$dprint->pude_rate:''; ?>
					</td>
					<td>
						<?php echo !empty($dprint->pude_quantity)?$dprint->pude_quantity:''; ?>
					</td>
					
					<td>
						<?php echo !empty($dprint->unit_unitname)?$dprint->unit_unitname:''; ?>
					</td>
					<td>
						<?php echo !empty($dprint->pude_amount)?number_format($dprint->pude_amount,2):''; ?>
					</td>
					<td>
						<?php echo !empty($dprint->pude_remarks)?$dprint->pude_remarks:''; ?>
					</td>
				</tr>
				<?php } ?>
				<tr>
					<td colspan="7"  style="text-align: right">
						<span class="<?php echo FONT_CLASS; ?>">कुल छूट राशि</span>: 
					</td>
					<td><?php echo !empty($order_details[0]->puor_discount)?number_format($order_details[0]->puor_discount):''; ?></td>
					<td></td>
				</tr>

				<tr>
					<td colspan="7"  style="text-align: right">
						 <span class="<?php echo FONT_CLASS; ?>">कूल  भ्याट राशि </span>:
					</td>
					<td><?php echo !empty($order_details[0]->puor_vatamount)?number_format($order_details[0]->puor_vatamount):''; ?></td>
					<td></td>
				</tr>

				<tr>
					<td colspan="7"  style="text-align: right">
						<span class="<?php echo FONT_CLASS; ?>">कूल  जम्मा </span>:
					</td>
					<td>
						<?php echo !empty($order_details[0]->puor_amount)?number_format($order_details[0]->puor_amount):''; ?>
					</td>
					<td></td>
				</tr>
				<?php }else{ ?>
				<?php 
				$itemid = !empty($report_data['qude_itemsid'])?$report_data['qude_itemsid']:'';
				if(!empty($itemid)):
				foreach($itemid as $key=>$products):	?>
				<tr>
					<td>
						<?php echo $key+1; ?>
					</td>
					<td></td>
					<td>
						<?php 
							$itemid = !empty($report_data['qude_itemsid'][$key])?$report_data['qude_itemsid'][$key]:'';
							$itemname =  $this->general->get_tbl_data('*','itli_itemslist',array('itli_itemlistid'=>$itemid),false,'DESC');
							echo !empty($itemname[0]->itli_itemcode)?$itemname[0]->itli_itemcode:'';
						?>
						
					</td>
					<td>
						<?php echo !empty($report_data['itemcode'][$key])?$report_data['itemcode'][$key]:''; ?>
					</td>
					<td>
						<?php echo !empty($report_data['puit_qty'][$key])?$report_data['puit_qty'][$key]:''; ?>
					</td>
					<td>
						<?php echo !empty($report_data['puit_unitid'][$key])?$report_data['puit_unitid'][$key]:''; ?>
					</td>
					<td>
						<?php echo !empty($report_data['puit_unitprice'][$key])?$report_data['puit_unitprice'][$key]:''; ?>
					</td>
					<td>
						<?php echo !empty($report_data['puit_total'][$key])?$report_data['puit_total'][$key]:''; ?>
					</td>
					<td>
						<?php echo !empty($report_data['description'][$key])?$report_data['description'][$key]:''; ?>
					</td>
				</tr>
			<?php
				endforeach;
				endif;
			?>
			
			<?php
				$sub_total = !empty($report_data['subtotal'])?$report_data['subtotal']:''; 
				$discount_amt = !empty($report_data['puin_discountamt'])?$report_data['puin_discountamt']:'';
				$tax_amount = !empty($report_data['taxtamount'])?$report_data['taxtamount']:''; 
				$total_amount = !empty($report_data['totalamount'])?$report_data['totalamount']:''; 
			?>
			<tr>
				<td colspan="7" style="text-align: right">
					Total: 
				</td>
				<td><?php echo $sub_total; ?></td>
				<td></td>
			</tr>

			<tr>
				<td colspan="7"  style="text-align: right">
					<span class="<?php echo FONT_CLASS; ?>">कुल छूट राशि</span>: 
				</td>
				<td><?php echo $discount_amt; ?></td>
				<td></td>
			</tr>

			<tr>
				<td colspan="7"  style="text-align: right">
					 <span class="<?php echo FONT_CLASS; ?>">कूल  भ्याट राशि </span>:
				</td>
				<td><?php echo $tax_amount; ?></td>
				<td></td>
			</tr>

			<tr>
				<td colspan="7"  style="text-align: right">
					<span class="<?php echo FONT_CLASS; ?>">कूल जम्मा </span>:
				</td>
				<td>
					<?php echo $total_amount; ?>
				</td>
				<td></td>
			</tr>
			<?php } ?>
			</tbody>
		</table>
		<table class="jo_footer" style="width: 100%;">
			<tfoot>
				<tr>
					<td>
					<table style="width: 100%;" class="inner-table">
					<tr>
					<td style="font-size: 12px;">  फाटवालाको दस्तखत: .......................</td>
					<td style="text-align: right;font-size: 12px;"> <span>शाखा प्रमुखको दस्तखत: .......................</span></td>
				</tr>
				<tr>
					<td style="font-size: 12px;"> मिति: .......................</td>
					<td style="text-align: right;font-size: 12px;"> <span>मिति : .......................</span></td>
				</tr>
					</table>
				</td>
				</tr>
				
				<tr>
					<td>
					<table class="bdr-table" style="width: 100%;padding-top: 10px;class="inner-table">
						<tr>
							<td style="font-size: 12px;padding: 4px 8px;"><u>आर्थिक प्रशासन शाखाले भर्ने </u></td>
						</tr>
						<tr>
							<td style="font-size: 12px;padding: 0 8px;">माथि उल्लेखित समानहरु बजेट उपशीर्षक न ..................को खर्च शीर्षक....................................................................बाट भुक्तनी दिन बजेट बाँकी देखिन्छ/देखिदैन   ।</td>
						</tr>
						<tr>
							<td>
								<table width="100%;">
							<tr>
							
							<td style="text-align: right;font-size: 12px;padding: 0 8px;"><span>शाखा प्रमुखको दस्तखत:............</span></td>
						</tr>
						<tr>
							<td style="text-align: right;font-size: 12px;padding: 0 8px;"><span>मिति: .......................</span></td>
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
							<td style="text-align: right;font-size: 12px;padding: 2px 8px;"><span>कार्यलय प्रमुखको दस्तखत:.......................</span></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td style="text-align: right;font-size: 12px;padding: 2px 8px;"><span>मिति: .......................</span></td>
						</tr>
					</table>
				</td>
				</tr>
				<tr>
					<table style="width: 100%;">
						<tr>
							<td style="font-size: 12px;">माथि उल्लेखित समानहरु  मिति <span style="border-bottom: 1px dotted #333;"><?php echo $delivery_date; ?> </span> भित्र <span style="border-bottom: 1px dotted #333;"><?php echo $delivery_site; ?> </span> कार्यालयमा बूझाउने छु भनी सहिछाप गर्ने ।</td>
						</tr>
					</table>
				</tr>
				<tr>
					<table style="width: 100%;">
						<tr>
							<td style="font-size: 12px;">फर्मको नाम </td>
							<td style="text-align: center;font-size: 12px;">दस्तखत</td>
							<td style="text-align: right;font-size: 12px;">मिति</td>
						</tr>
						<tr>
							<td>..........................</td>
							<td style="text-align: center;font-size: 12px;">..........................</td>
							<td style="text-align: right;font-size: 12px;">..........................</td>
						</tr>
					</table>
				</tr>
			</tfoot>
			
		</table>

</div>