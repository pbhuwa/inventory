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
	
	.jo_footer {vertical-align: top; }
	.jo_footer td { padding:8px 8px;}

	.preeti{
		font-family: preeti;
		}
	.bb{border-bottom:1px dashed #333;}
	.bold{ font-weight: bold; }
	.jo_table tr td{border-bottom: 1px solid #333;}
	.dakhila_form_footer {border: 1px solid #212121;border-top: 0px;padding: 5px 15px;}
    .officer_detailTable tr th{text-align: left; font-weight: 500;margin-bottom: 5px;font-size: 12px;}
    .officer_detailTable tr td{font-size: 12px;}	
        .preeti{
        font-family: preeti;
    }
    .bordertblone{border-bottom: 1px dashed #333; }	
    .purchaserecive{border-collapse: collapse;}
    .purchaserecive-table tr th{border-bottom: 1px solid #ddd;padding: 4px;}
    .purchaserecive-table tr td{border-bottom: 1px solid #ddd;padding: 4px;}
    .purchaserecive-table tr:last-child td{border-bottom: 0px;}
    .jo_table tr.total-amount td{border-bottom: 0px !important;}
    .jo_table tr.total-amount td:last-child{border-left: 0px;}
    .jo_table tr.total-amount td:nth-child(2){border: 0px;}
	/*.jo_table tr:last-child td:nth-child(2){border: 0px;}*/
	/*.jo_table tr:last-child td:last-child{border-left: 0px;}*/
	.tableWrapper{
		min-height:52%;
		height:52vh;
		max-height: 100vh;
		white-space: nowrap;
		display: table;
		width: 100%;
		/*overflow-y: auto;*/
	}
	.itemInfo{
		height:100%;
	}
	.itemInfo .td_cell{
		padding:5px;
		margin:5px; 
	}

	.itemInfo th.td_cell{
		font-weight: bold;
		text-align: center; 
	}

	.itemInfo .td_empty{
		height:100%;
	}
	.jo_table tbody tr td:nth-child(3){
		width: 100% !important;
	}
	.tableWrapper tr th{
		word-wrap: break-word;
		white-space: initial;
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
</style>

<div class="jo_form organizationInfo">
	<div class="headerWrapper">

		<?php 
            $header['report_no'] = '';
            $header['report_title'] = 'जिन्सी आम्दानी भौचर';
            $this->load->view('common/v_print_report_header',$header);
        ?>

		<table class="jo_tbl_head">
			<tr>
				<td><span style="font-size: 12px;" class="bold_title"> दा. नं. :</span> 
					<span class="bb"> 
					<?php
						if($req_detail_list){
					 		echo !empty($req_detail_list[0]->recm_invoiceno)?$req_detail_list[0]->recm_invoiceno:'';  
						} else{
							echo !empty($report_data['received_no'])?$report_data['received_no']:''; 
						} 
					?>
					</span>
				</td>

				<?php
					if(!empty($challan_no)):
				?>
					<td>
						<span style="font-size: 12px;" class="bold_title"> चलान न :</span> 
						<span class="bb"> 
						<?php 
							$challanno = array();
							foreach($challan_no as $ch){
								$challanno[] = $ch->chma_challanmasterid;
							}
							echo implode(',',$challanno);
						?>
						</span>
					</td>
				<?php
					endif;
				?>
				
				<td width="17%" class="text-right " style="white-space: nowrap;">
					<span style="font-size: 12px;" class="bold_title">मिति :</span>
				 	<span class="bb"> 
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
				</td>
			</tr>

			<tr>
				<td>
					<span style="font-size: 12px;" class="bold_title">फर्मको नाम</span>
					<span class="bb">
						<?php
							echo !empty($req_detail_list[0]->dist_distributor)?$req_detail_list[0]->dist_distributor:''; 
						?>
					</span>
				</td>
			</tr>

			<tr>
				<td>
					<span style="font-size: 12px;" class="bold_title">खरिद आदेश नं </span>
					<span class="bb">
						<?php echo !empty($req_detail_list[0]->recm_purchaseorderno)?$req_detail_list[0]->recm_purchaseorderno:'';?>
					</span>
				</td>
			</tr>

			<tr>
				<td>
					<span style="font-size: 12px;" class="bold_title">बिल नं र मिति </span>
					<span class="bb">
						<?php echo !empty($direct_purchase_master[0]->recm_supplierbillno)?$direct_purchase_master[0]->recm_supplierbillno:'';?>  
						(<?php
							if(DEFAULT_DATEPICKER == 'NP'){
								echo !empty($direct_purchase_master[0]->recm_supbilldatebs)?$direct_purchase_master[0]->recm_supbilldatebs:'';
							}else{
								echo !empty($direct_purchase_master[0]->recm_supbilldatead)?$direct_purchase_master[0]->recm_supbilldatead:'';
							}
						?>)
					</span>
				</td>
			</tr>

			<tr>
				<td>
					<span style="font-size: 12px;" class="bold_title"> सामानको किसिम </span>

				</td>
			</tr>

			<tr>
				<td>
					<span style="font-size: 12px;" class="bold_title"> स्टोर दाखिला मिति </span>
					<span class="bb">
						<?php
							if(DEFAULT_DATEPICKER == 'NP'){
								echo !empty($direct_purchase_master[0]->recm_receiveddatebs)?$direct_purchase_master[0]->recm_receiveddatebs:'';
							}else{
								echo !empty($direct_purchase_master[0]->recm_receiveddatead)?$direct_purchase_master[0]->recm_receiveddatead:'';
							}
						?>
					</span>
				</td>
			</tr>
		</table>
	</div>
	

	<div class="tableWrapper">
		<table  class="jo_table itemInfo" style="border-bottom: 1px solid #333; width: 100%;table-layout: fixed;">
			<thead>
				<tr>
					<th width="5%" rowspan="2" class="td_cell">सि.नं.</th>
					<th width="10%" rowspan="2" class="td_cell">सामानको कोड नं</th>
					<th width="30%" rowspan="2" class="td_cell">विवरण</th>
					<th width="8%" rowspan="2" class="td_cell">परिमाण आदेश </th>
					<th width="5%" rowspan="2" class="td_cell">एकाई </th>
					<th width="8%" rowspan="2" class="td_cell">परिमाण प्राप्त</th>
					<th width="10%" colspan="1" class="td_cell">दर</th>
					<th width="10%" colspan="1" class="td_cell">जम्मा रकम </th>
					<th width="8%" rowspan="2" class="td_cell">कैफियत </th>
				</tr>
				<tr>
					<th class="td_cell">रू.</th>
					<th class="td_cell">रू.</th>
				</tr>
			</thead>
			<tbody>
				<?php if($req_detail_list){ //echo "<pre>"; print_r($req_detail_list);die;
					$sum= 0; $vatsum=0;
                    foreach ($req_detail_list as $key => $direct) { ?>
            	<tr style="border-bottom: 1px solid #212121;">
					<td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
						<?php echo $key+1; ?>
					</td>
					<td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
						<?php echo !empty($direct->itli_itemcode)?$direct->itli_itemcode:''; ?>
					</td>
					<td width="500px" class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
						<?php
							if(ITEM_DISPLAY_TYPE=='NP'){
		                		echo !empty($direct->itli_itemnamenp)?$direct->itli_itemnamenp:$direct->itli_itemname;
		                	}else{ 
		                    	echo !empty($direct->itli_itemname)?$direct->itli_itemname:'';
		                	}
						?>
					</td>
					<td class="td_cell">
						<?php
							$order_qty = !empty($direct->puord_qty)?$direct->puord_qty:0; 
							echo number_format($order_qty); 
						?>
                	</td>
					<td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
                    	<?php echo !empty($direct->unit_unitname)?$direct->unit_unitname:''; ?>
                	</td>

	                <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
	                    <?php
	                    	$received_qty = !empty($direct->recd_purchasedqty)?$direct->recd_purchasedqty:0;
	                    	echo number_format($received_qty); 
	                    ?>
	                </td>

	                <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;text-align: right;">
	                    <?php echo !empty($direct->recd_unitprice)?$direct->recd_unitprice:''; ?>
	                </td>
				
					<td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word; text-align: right;">
						<?php echo $direct->recd_amount; ?>
					</td>
					<td style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
						<?php echo $direct->recd_description; ?>
					</td>
				</tr>
				<?php
					$sum += $direct->recd_discountamt;
			 		$vatsum += $direct->recd_vatamt;
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
               <td class="td_cell" colspan="6">अक्षरूपी : <?php echo $this->general->number_to_word( $total);?> </td>
               <td>कुल जम्मा :</td>
               <td align="right"><?php echo $total; ?></td>
               <td></td>
            </tr>
         </tfoot>


		<!-- 	<tfoot>
			
			<tr>
				<td width="60%" colspan="6" style="overflow-wrap: break-word;white-space: nowrap;text-align: left;"><span class="bold_title">अक्षरेपी:  </span>
					<?php if($req_detail_list){
                            echo $this->general->number_to_word($total);
                        }else{
                            echo $this->general->number_to_word($report_data['clearanceamt']);
                        } ?> </td>
				<td style="text-align: right;font-size: 12px;">
					<span class="bold_title">कुल जम्मा : </span>
				</td>
				<td>
					<?php echo !empty($total)?number_format($total,2):''; ?>
				</td>
			</tr>
            <?php } ?>
		</tfoot> -->
		</table>
	</div>

	

	<div class="footerWrapper">
		<table class="table officer_detailTable purchaserecive-table" style="width: 100%;border-left: 1px solid #333;border-right: 1px solid #333;border-bottom: 1px solid #333;border-top: 1px solid #ddd;">
			<tr>
				<th><span class="bold_title">माथि उल्लेखित सामानहरु आम्दानी बाँध्न आदेश दिने</span></th>
				<th><span class="bold_title">उल्लेखित सामानहरु नियमानुसार आम्दानी बाँधिएको छ |</span></th>
			</tr>
			<tr>
				<td><span class="signatureDashedLine"></span></td>
				<td><span class="signatureDashedLine"></span></td>
			</tr>
			<tr>
	            <td><span class="bold_title">जिन्सीशाखा प्रमुखको सही</span></td>
	            <td><span class="bold_title">स्टोर किपरको सही</span></td>
			</tr>
			<tr>
				<td><span class="bold_title">नाम:</span></td>
				<td><span class="bold_title">नाम:</span></td>
			</tr>
			<tr>
	            <td><span class="bold_title">पद:</span></td>
	            <td><span class="bold_title">पद:</span></td>
			</tr>
	    </table>
	</div>
</div>