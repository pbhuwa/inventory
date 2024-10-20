<style>	
	@page  {
    	size: auto;   
    	margin: 5mm 5mm 5mm 10mm;  
    	/*size: landscape;*/
    } 

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
		min-height:40%;
		height:40vh;
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
		font-size: 8px;
	}

	.itemInfo th.td_cell {
		padding:5px;
		margin:5px; 
		text-align: center;
		font-size: 10px;
	}

	th.td_cell{
		font-size: 10px;
		font-weight: bold;
	}

	.itemInfo .td_cell_num{
		font-size: 7px;
		/*text-align: left;*/
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
		margin-top: 15px;
	
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
</style>

<div class="jo_form organizationInfo">
	<div class="headerWrapper" style="margin-bottom: -25px " >
		<?php 
			$header['report_no'] = '';
			$header['old_report_no'] = '';
            $header['report_title'] = 'INVENTORY ENTRY REPORT';
            $this->load->view('common/v_print_report_header',$header);
        ?>

        <div class="text-right">Page No.: </div>

        <div class="text-right">Print Date: <?php echo CURDATE_NP.' '.date('h:i A');?></div>
		<table class="jo_tbl_head">
			<tr>
				<td>
					<strong>Supplier Name:</strong>
				</td>
				<td>
					<strong>AC Head:</strong>
				</td>
			</tr>

			<tr>
				<td>
					<strong>Bill /Invoice:</strong>
				</td>
				<td>
					<strong>Entry No.:</strong>
					<span class="bb"> 
						<?php
						if($req_detail_list){
						 echo !empty($req_detail_list[0]->recm_invoiceno)?$req_detail_list[0]->recm_invoiceno:'';  
						} else{
						echo !empty($report_data['received_no'])?$report_data['received_no']:''; } ?>
					</span>
				</td>
			</tr>

			<tr>
				<td>
					<strong>Date:</strong>
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
				<td>
					<strong>Date:</strong>
				</td>
			</tr>
		
		</table>
	</div>
	
	<div class="tableWrapper">
		<table class="jo_table itemInfo" style="border-bottom: 1px solid #333; width: 100%;table-layout: fixed;text-align: center;">
			<thead>
				<tr>
					<th width="4%" class="td_cell">Inv No</th>
					<th width="4%" class="td_cell">Description</th>
					<th width="4%" class="td_cell">Unit</th>
					<th width="4%" class="td_cell">Qty</th>
					<th width="4%" class="td_cell">Rate</th>
					<th width="4%" class="td_cell">Amount</th>
					<th width="4%" class="td_cell">Vat</th>
					<th width="4%" class="td_cell">Remarks</th>
					<th width="4%" class="td_cell">Received By</th>
				</tr>
			</thead>
			<tbody>
				

				<?php 
					if($req_detail_list){
						$sum= 0; $vatsum=0;
                    	foreach ($req_detail_list as $key => $direct) { ?>
	            			<tr style="border-bottom: 1px solid #212121;">
								<td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
									<?php echo !empty($direct->eqca_jinsicode)?$direct->eqca_jinsicode:''; ?>
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
			                	<td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
			                    	<?php echo !empty($direct->unit_unitname)?$direct->unit_unitname:''; ?>
			                	</td>

				                <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
				                    <?php echo number_format($direct->recd_purchasedqty); ?>
				                </td>

				                <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;text-align: right;">
				                  	<?php 
				                  		$unit_price = !empty($direct->recd_unitprice)?$direct->recd_unitprice:''; 
				                  		echo number_format($unit_price,2);
				                  	?>
				                </td>
								<td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
									<?php 
										$total_wo_vat = $direct->recd_purchasedqty*$direct->recd_unitprice; 
										echo number_format($total_wo_vat,2);
									?>
								</td>
								<td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;text-align: right;">
									<?php 
										echo $direct->recd_vatamt;
									?>
								</td>
							<!-- 	<td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word; text-align: right;">
									<?php echo $direct->recd_amount; ?>
								</td>
								 -->
								 <td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word;">
									<?php echo $direct->recd_description; ?>
								</td>
								<td></td>
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
		</table>
	</div>

	<table width="100%" class="amount-table">
		<tbody>
			<tr margin>
				<td width="75.8%"  style="text-align: right;font-size: 12px; padding-top:5px;">
					
				</td>
				<td style="border-right: 1px solid #000; padding-top:5px;">
					<?php echo !empty($vatsum)?number_format($vatsum,2):0; ?>
				</td>
			</tr>

			<tr margin>
				<td width="75.8%"  style="text-align: right;font-size: 12px; padding-top:5px;">
					<span class="">Discount </span>:
				</td>
				<td style="border-right: 1px solid #000; padding-top:5px;">
					<?php echo !empty($sum)?number_format($sum,2):0; ?>
				</td>
			</tr>

			<tr margin>
				<td width="75.8%"  style="text-align: right;font-size: 12px; padding-top:5px;">
					<span class="">Grand Total </span>:
				</td>
				<td style="border-right: 1px solid #000; padding-top:5px;">
					<?php echo !empty($total)?number_format($total,2):0; ?>
				</td>
			</tr>
            <?php } ?>
			<tr>
				<td colspan="12" style="overflow-wrap: break-word;white-space: nowrap;text-align: center;"><strong>शब्दमा : </strong> 
					<?php 
						if($req_detail_list){
                            echo $this->general->number_to_word($total);
                        }else{
                            echo $this->general->number_to_word($report_data['clearanceamt']);
                        } 
                    ?> 
                </td>
			</tr>
		</tbody>
	</table>

	
	
		<table class="table officer_detailTable purchaserecive-table" style="width: 100%;border-left: 1px solid #333;border-right: 1px solid #333;border-bottom: 1px solid #333;border-top: 1px solid #ddd;">
		
			<tr>
				<th style="padding-top: 30px;">Prepared By </th>
				<th style="padding-top: 30px;"></th>
				<th style="padding-top: 30px;">Checked By</th>
			</tr>
			
	    </table>
	</div>
</div>