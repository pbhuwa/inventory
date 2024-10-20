<style>	
	.table_jo_header, .jo_tbl_head, .jo_table, .jo_footer { width:100%; font-size:12px; border-collapse:collapse; }
	.table_jo_header { width:100%; vertical-align: top; font-size:12px; }
	.table_jo_header td.text-center { text-align:center; }
	.table_jo_header td.text-right { text-align:right; }
	h4 { font-size:18px; margin:0; }
	.table_jo_header u { text-decoration:underline; padding-top:15px; }

	.jo_table { border-right:1px solid #333; margin-top:5px; }
	.jo_table tr th { border-top:1px solid #333; border-bottom:1px solid #333; border-left:1px solid #333; }

	.jo_table tr th { padding:5px 3px;}
	.jo_table tr td { padding:3px 3px; height:15px; border-left:1px solid #333; }
	
	.jo_footer { border:1px solid #333; vertical-align: top; }
	.jo_footer td { padding:8px 8px;	}
	.preeti{
		font-family: preeti;
	}


	\---------- my-codes----\\


	.organizationInfo .footerWrapper {
		margin: 15px 0 0 0;
	}
	.footerWrapper th {
		padding: 10px 0 10px 4px;
	}
	tbody.upper-section, .lower-section {
		text-align: left;
		border-bottom: 1px solid#000;
	}
	.jo_footer td {
		padding: 5px 0 5px 5px !important;
	}
	.tableWrapper{
		min-height:50%;
		height:50vh;
		max-height: 100vh;
		white-space: nowrap;
		display: table;
		width: 100%;
		/*overflow-y: auto;*/
	}
	.itemInfo thead tr:first-child {
		text-align: left;
	}
	\---------- my-codes----\\
	.itemInfo{
		height:100%;
	}
	.itemInfo .td_cell{
		padding:5px;margin:5px; 
	}
	.itemInfo .td_empty{
		height:100%;
	}
	.jo_table tr td{border-bottom: 1px solid #000; padding: 0px 4px;}
	/*.itemInfo tr:last-child td{border:0px !important;}
	.itemInfo {border-bottom: 0px;}*/
	.footerWrapper{
		page-break-inside: avoid;
	}
	.dateDashedLine{
		min-width: 100px;display: inline-block; border:1px dashed #333;
	}
	.signatureDashedLine {
		min-width: 170px;display: inline-block; border:1px dashed #333;
	}
	.jo_footer img{
		margin-top: -15px;
		margin-left: 10px;
	}
	img.signatureImage{
		width: 70px;
	}
	.bold_title{
		font-weight: bold;
	}
</style>
<div class="jo_form organizationInfo">
	<div class="headerWrapper">
		<?php 
		$header['report_no'] = '';
		$header['report_title'] = 'जिन्सी हस्तान्तरण सूची ';
		$this->load->view('common/v_print_report_header',$header);
		?>
		<table class="jo_tbl_head">
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td width="25%" class="text-left" style="padding-bottom: 5px;"><span style="font-size: 12px;" class="bold_title">ख.आ.नं :-</span>
					<span style="border-bottom: 1px dashed;font-size: 12px;">
						
					</span>
				</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td width="25%" class="text-left" style="padding-bottom: 5px;"><span style="font-size: 12px;" class="bold_title"> मिति :-</span><span style="border-bottom: 1px dashed;font-size: 12px;"> 
					<?php if($issue_details){ 
						echo !empty(CURDATE_NP)?CURDATE_NP:'';
					}else{
						echo !empty(CURDATE_NP)?CURDATE_NP:'';
					} ?>
				</span>
				
			</td>
		</tr><tr>
			<td></td>
			<td></td>
			<td></td>
			<td width="25%" class="text-left" style="padding-bottom: 5px;"><span style="font-size: 12px;" class="bold_title">माग.फा.नं :- </span> 
				<span style="border-bottom: 1px dashed;font-size: 12px;">
					<?php if($issue_details){ 
						echo !empty($issue_master[0]->haov_handoverreqno)?$issue_master[0]->haov_handoverreqno:'';
					}else{
						echo !empty($report_data['haov_handoverreqno'])?$report_data['haov_handoverreqno']:'';
					} ?>
				</span>
			</td>
		</tr> 
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td width="25%" class="text-left" style="padding-bottom: 5px;"><span style="font-size: 12px;" class="bold_title">जि.नि.सू.नं. :- </span> 
				<span style="border-bottom: 1px dashed;font-size: 12px;">
					<?php if($issue_details){ 
						echo !empty($issue_master[0]->haov_invoiceno)?$issue_master[0]->haov_invoiceno:'';
					}else{
						echo !empty($report_data['haov_invoiceno'])?$report_data['haov_invoiceno']:'';
					} ?>
				</span>
			</td>
		</tr> 
		<tr>
			<td><span style="font-size: 12px;" class="bold_title"> जिन्सी भण्डार स्थान:- </span>
				<span style="border-bottom: 1px dashed;font-size: 12px;"> 
					<?php
					$location_id = !empty($issue_master[0]->haov_locationid)?$issue_master[0]->haov_locationid:'';
					$location_data = $this->general->get_tbl_data('*','loca_location',array('loca_locationid'=>$location_id));
					echo !empty($location_data[0]->loca_name)?$location_data[0]->loca_name:'';
					?>
				</span>
			</td></td>
			<td></td>
			<td></td>

			<td width="25%" class="text-left" style="padding-bottom: 5px;"><span style="font-size: 12px;" class="bold_title"> मिति :- </span> 
				<span style="border-bottom: 1px dashed;font-size: 12px;">
					<?php
					if(DEFAULT_DATEPICKER == 'NP'){
						echo !empty($issue_master[0]->haov_handoverdatebs)?$issue_master[0]->haov_handoverdatebs:'';
					} else{
						echo !empty($issue_master[0]->haov_handoverdatead)?$issue_master[0]->haov_handoverdatead:'';
					}
					?>
				</span>
			</td>
		</tr>

		
	</table>
</div>

<div class="tableWrapper">
	<table  class="jo_table itemInfo" style="border-bottom: 1px solid #333;">
		<thead>
			<tr >
				<th colspan="4" >
					<span style="font-size: 12px;" class="bold_title">सामान माग गर्ने :- </span>
					<?php
					if ($issue_details){
						echo !empty($issue_master[0]->haov_receivedby)?$issue_master[0]->haov_receivedby:'';
					} else{ echo !empty($report_data['haov_receivedby'])?$report_data['haov_receivedby']:'';
				}
				?>
				<br>	
				
				<span style="font-size: 12px;" class="bold_title">	
				कामको विवरण :- </span>
				<br>	
				<span style="font-size: 12px;" class="bold_title">
					कामको स्थान :-
				</span>
				<?php
				if ($issue_details){
					echo !empty($this->session->userdata(LOCATION_NAME))?$this->session->userdata(LOCATION_NAME):'';
				} 
				?>
			</th>

			<th colspan="5" valign="top">
				<span style="font-size: 12px;" class="bold_title">बजेट शिर्षक नं :-
				</span>
			</th>
		</tr>
		<tr>
			<th width="5%" class="td_cell" style="text-align: center" rowspan="2">विन कार्ड नं.</th>
			<th width="10%" class="td_cell" style="text-align: center"rowspan="2"> पाना नं. </th>
			<th width="10%" class="td_cell" style="text-align: center"rowspan="2"> कोड नं</th>
			<th width="30%" class="td_cell" style="text-align: center"rowspan="2"> मालसामानको विवरण  </th>

			<th width="5%" class="td_cell" style="text-align: center" colspan="2" > परिमाण </th>
			

			<!-- <th width="10%">परिमाण</th> -->
			<th width="10%" class="td_cell" style="text-align: center"rowspan="2"> इकाई</th>
			<th width="10%" class="td_cell" style="text-align: center"colspan="1"> दर  </th>
			<th width="30%" class="td_cell" style="text-align: center"colspan="1"> जम्मा रकम   </th>
		</tr>
		<tr>
			<th width="5%" class="td_cell" style="text-align: center" > माग  </th>
			<th width="5%" class="td_cell" style="text-align: center" > हस्तान्तरण  </th>
			<th width="10%" class="td_cell" style="text-align: center" > रू.  </th>
			<th width="10%" class="td_cell" style="text-align: center" > रू.  </th>
		</tr>
	</thead>
	<tbody>
		<?php
		if($issue_details){ 
			$gtotal=0;
			foreach($issue_details as $key=>$products):
				?>
				<tr>
					<td class="td_cell" style="text-align: center">
						<?php echo $key+1; ?>
					</td>
					<td></td>
					<td class="td_cell" style="text-align: center">
						<?php echo $products->itli_itemcode;?>
					</td>
					<td class="td_cell">
						<?php
						if(ITEM_DISPLAY_TYPE=='NP'){
							echo !empty($products->itli_itemnamenp)?$products->itli_itemnamenp:$products->itli_itemname;
						}else{ 
							echo !empty($products->itli_itemname)?$products->itli_itemname:'';
						}

	                    // echo $products->itli_itemname;
						?>
					</td>
					
					
					
					<td class="td_cell" style="text-align: right;">
						<?php $order_qty=!empty($products->haod_qty)?$products->haod_qty:'';?>
						<?php echo $order_qty;?>
					</td>
					<td class="td_cell" style="text-align: right;">
						<?php $qty=!empty($products->totalqty)?$products->totalqty:'';?>
						<?php echo $qty;?>
					</td>
					
					<td class="td_cell" style="text-align: center">
						<?php $unit=!empty($products->unit_unitname)?$products->unit_unitname:'';?> 
						<?php echo $unit;?> 
					</td>
	                <!-- <td>
	                    <?php $qty=!empty($products->totalqty)?$products->totalqty:'';?> 
	                        <?php echo $qty;?>
	                    </td> -->
	                    

	                    <td class="td_cell" style="text-align: right;">
	                    	<?php $haod_unitrate=!empty($products->haod_unitrate)?$products->haod_unitrate:'';?>
	                    	<?php echo $haod_unitrate;?>
	                    </td>
	                    
	                    <td class="td_cell" style="text-align: right;">
	                    	<?php $subtotal=!empty($products->subtotal)?$products->subtotal:'';?>
	                    	<?php echo $subtotal;?>
	                    </td>

	               <!--  <td class="td_cell" style="text-align: center">
	                    <?php $puderemaks=!empty($products->haod_remarks)?$products->haod_remarks:'';?>
	                        <?php echo $puderemaks;?>
	                            
	                    </td> -->
	                    
	                </tr>
	                
	                <?php  
	                $gtotal +=$subtotal;
	            endforeach;
	            ?>
	            <?php
	            $row_count = count($products);

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
	        <?php }else{ ?>
	        	<?php 
	        	$itemid = !empty($report_data['haod_itemsid'])?$report_data['haod_itemsid']:'';
				if(!empty($itemid)): // echo"<pre>";print_r($itemid);die;
				
				foreach($itemid as $key=>$products):
					?>
					<tr>
						<td class="td_cell" style="text-align: center">
							<?php echo $key+1; ?>
						</td>
						<td class="td_cell" style="text-align: center">
							<?php 
							$itemid = !empty($report_data['haod_itemsid'][$key])?$report_data['haod_itemsid'][$key]:'';
							$itemname =  $this->general->get_tbl_data('*','itli_itemslist',array('itli_itemlistid'=>$itemid),false,'DESC');
							echo !empty($itemname[0]->itli_itemcode)?$itemname[0]->itli_itemcode:'';
							?>
							<?php echo !empty($report_data['haod_code'][$key])?$report_data['haod_code'][$key]:''; ?>
						</td>
						<td class="td_cell" style="text-align: center">
							<?php 
							$itemid = !empty($report_data['haod_itemsid'][$key])?$report_data['haod_itemsid'][$key]:'';
							$itemname =  $this->general->get_tbl_data('*','itli_itemslist',array('itli_itemlistid'=>$itemid),false,'DESC');
							
							if(ITEM_DISPLAY_TYPE=='NP'){
								$iss_itemname = !empty($itemname[0]->itli_itemnamenp)?$itemname[0]->itli_itemnamenp:$itemname[0]->itli_itemname;
							}else{ 
								$iss_itemname = !empty($itemname[0]->itli_itemname)?$itemname[0]->itli_itemname:'';
							}

							echo $iss_itemname;

							?>
						</td>
						<td class="td_cell" style="text-align: center">
							<?php echo !empty($report_data['unit'][$key])?$report_data['unit'][$key]:''; ?> 
						</td>
				<!-- <td>
					<?php echo !empty($report_data['qtyinstock'][$key])?$report_data['qtyinstock'][$key]:''; ?>
				</td> -->
				<td class="td_cell" style="text-align: center">
					<?php echo !empty($report_data['remqty'][$key])?$report_data['remqty'][$key]:''; ?>
				</td>
				<td class="td_cell" style="text-align: center">
					<?php echo !empty($report_data['haod_qty'][$key])?$report_data['haod_qty'][$key]:''; ?>
				</td>
				<td class="td_cell" style="text-align: center">
					<?php echo !empty($report_data['haod_remarks'][$key])?$report_data['haod_remarks'][$key]:''; ?>
				</td>
			</tr>
			<?php
		endforeach;?>
		<?php
		$row_count = count($report_data['haod_itemsid']);

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
			</tr>
		<?php endif ?>
		<?php
	endif;
}
?>
<tr>
	<td colspan="7"><span style="font-size: 12px;" class="bold_title"> अक्षरेपी : </span>   <?php echo $this->general->number_to_word( $gtotal); ?>	</td>
	<td colspan="2" style="text-align: right;">
		<span style="font-size: 12px;" class="bold_title">कुल जम्मा :
		</span>
		<?php echo !empty($gtotal)?$gtotal:''; ?>	</td>	
	</tr>
	
</tbody>
</table>
</div>

<div class="footerWrapper">
	<table class="jo_footer" style="padding-top: 10px;padding-bottom: 10px;border: 1px solid #000;border-top: 0px;page-break-inside: avoid;margin: 15px 0 0 0">
		<tbody class="upper-section">
			<tr>
				<th colspan="5" style="border-right: 1px solid#000;">माग गर्ने :-</th>
				<th colspan="5" style="border-right: 1px solid#000;">बुझिलिने :-</th>
				<th colspan="5" style="border-right: 1px solid#000;">निकासीको लागि आदेश दिने :-</th>
			</tr>
			<tr>
				<td colspan="5" style="border-right: 1px solid#000;">नाम :-</td>
				<td colspan="5" style="border-right: 1px solid#000;">नाम :-</td>
				<td colspan="5" style="border-right: 1px solid#000;">नाम :-</td>
			</tr>
			<tr>
				<td colspan="5" style="border-right: 1px solid#000;">पद :-</td>
				<td colspan="5" style="border-right: 1px solid#000;">पद :-</td>
				<td colspan="5" style="border-right: 1px solid#000;">पद :-</td>
			</tr>
		</tbody>
		
		<tbody class="lower-section">
			<tr>
				<th colspan="4" style="border-right: 1px solid#000;">विन कार्ड भर्ने  :-</th>	
				<th colspan="4" style="border-right: 1px solid#000;">जिन्सी खाता भर्ने :-</th>
				<th colspan="4" style="border-right: 1px solid#000;">निकासी गर्ने  :-</th>	
				<th colspan="4">स्वीकृत गर्ने :-</th>		
			</tr>
			<tr>
				<td colspan="4" style="border-right: 1px solid#000;">नाम :-</td>
				<td colspan="4" style="border-right: 1px solid#000;">नाम :-</td>
				<td colspan="4" style="border-right: 1px solid#000;">नाम :-</td>
				<td colspan="4">नाम:-</td>
			</tr>
			<tr>
				<td colspan="4" style="border-right: 1px solid#000;">पद :-</td>
				<td colspan="4" style="border-right: 1px solid#000;">पद :-</td>
				<td colspan="4" style="border-right: 1px solid#000;">पद :-</td>
				<td colspan="4">पद:-</td>
			</tr>
		</tbody>
	</table>
</div>
</div>