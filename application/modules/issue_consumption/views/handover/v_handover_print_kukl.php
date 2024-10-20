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
	.jo_footer td { padding:2px;	}
	.preeti{
		font-family: preeti;
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
</style>

<div class="jo_form organizationInfo">
	<?php 
			$header['report_no'] = '';
			$header['report_title'] = 'हस्तान्तरण फाराम';
			$this->load->view('common/v_print_report_header',$header);
		?>

    <?php
    	// print_r($issue_master);
    	// die();
    	if($issue_master){
    		$invoiceno = !empty($issue_master[0]->sama_invoiceno)?$issue_master[0]->sama_invoiceno:'';
    		$depid = !empty($issue_master[0]->sama_depid)?$issue_master[0]->sama_depid:'';

    		$dep_info =  $this->general->get_tbl_data('*','dept_department',array('dept_depid'=>$depid),false,'DESC');
    		$depname = !empty($dep_info[0]->dept_depname)?$dep_info[0]->dept_depname:'';

    		if(DEFAULT_DATEPICKER == 'NP'){
    			$issue_date = !empty($issue_master[0]->sama_billdatebs)?$issue_master[0]->sama_billdatebs:'';
    			$req_date = !empty($issue_master[0]->sama_requisitiondatebs)?$issue_master[0]->sama_requisitiondatebs:'';
    		}else{
    			$issue_date = !empty($issue_master[0]->sama_billdatead)?$issue_master[0]->sama_billdatead:'';
    			$req_date = !empty($issue_master[0]->sama_requisitiondatead)?$issue_master[0]->sama_requisitiondatead:'';
    		}

	    	$receivedby = !empty($issue_master[0]->sama_receivedby)?$issue_master[0]->sama_receivedby:'';
    	}else{
    		$invoiceno = !empty($report_data['sama_invoiceno'])?$report_data['sama_invoiceno']:'';
    		$depid = !empty($report_data['sama_depid'])?$report_data['sama_depid']:'';

    		$dep_info =  $this->general->get_tbl_data('*','dept_department',array('dept_depid'=>$depid),false,'DESC');
    		$depname = !empty($dep_info[0]->dept_depname)?$dep_info[0]->dept_depname:'';
    		
	    	$req_date = !empty($report_data['requisition_date'])?$report_data['requisition_date']:'';
	    	$issue_date = !empty($report_data['issue_date'])?$report_data['issue_date']:'';
	    	$receivedby = !empty($report_data['sama_receivedby'])?$report_data['sama_receivedby']:'';
    	}    	
    ?>
	<table class="jo_tbl_head" style="margin-top: 10px;">
		<tr>
			<td></td>
			<td></td>
			<td width="33.33333%%" class="text-right"><span style="font-size: 12px;" class="">ह. फा. न. </span>  :
			<?php if($issue_details){ 
				echo !empty($issue_master[0]->sama_invoiceno)?$issue_master[0]->sama_invoiceno:'';
			 }else{
			 	echo !empty($report_data['sama_invoiceno'])?$report_data['sama_invoiceno']:'';
			 } ?>
			</td>
		</tr>
		<tr>
			<td colspan="3">
				शाखा :- 						ह.फा.न:-
				कामकाे:-					मिति:-
				कामकाे स्थान:-
			</td>
		</tr>	
	</table>

	<div class="tableWrapper">
		<table  class="jo_table itemInfo" style="border-bottom: 1px solid #333;">
			<thead>
				<tr>
					<th width="5%" class="td_cell" rowspan="2"> क्र.स.</th>
					<th width="7%" class="td_cell" rowspan="2"> जिन्सी पाना न. </th>
					<th width="7%" class="td_cell" rowspan="2"> 
					 काेड न. </th>
					<th width="25%" class="td_cell" rowspan="2"> सामानको नाम </th>
					
					<th width="7%" class="td_cell" colspan="2"> परमाण </th>
					<th width="7%" class="td_cell" rowspan="2"> इकाई </th>
					<th width="10%" class="td_cell"> दर</th>

					<th width="10%" class="td_cell"> जम्मा रकम </th>
					
					<th width="15%" class="td_cell" rowspan="2"> कैफियत </th>
				</tr>
				<tr>
					<th width="10%" class="td_cell">माग</th>
					<th width="10%" class="td_cell">निकास </th><th width="10%" class="td_cell"> रू</th>
					<th width="10%" class="td_cell">रू </th>
					
				</tr>
			</thead>
			<tbody>
				<?php
					if($issue_details){
						// print_r($issue_details);
						// die();
						foreach($issue_details as $key=>$products):
							$productcode = $products->itli_itemcode;
							$productname = $products->itli_itemname;
							$unit=!empty($products->unit_unitname)?$products->unit_unitname:'';
							$cur_qty=!empty($products->sade_curqty)?$products->sade_curqty:'';	
							$rate = !empty($products->sade_purchaserate)?$products->sade_purchaserate:'';	 
							$remaks=!empty($products->sade_remarks)?$products->sade_remarks:'';
				?>
					<tr>
		                <td class="td_cell">
		                    <?php echo $key+1; ?>
		                </td>
		                <td class="td_cell">
		                    <?php echo $productcode; ?>
		                </td>
		                <td class="td_cell">
		                </td>
		                <td class="td_cell">
		                    <?php echo $productname; ?>
		                </td>
		                <td class="td_cell">
		                </td>
		                <td class="td_cell">
		                   <?php echo $cur_qty; ?>
		                </td>
		                <td class="td_cell"> 
		                    <?php echo $unit; ?> 
		                </td> 
		                <td class="td_cell">
		                    <?php echo $rate;?>
		                </td>
		                <td class="td_cell"></td>
		                <td class="td_cell"></td>
		            </tr>
		        <?php 
					endforeach;
					}else{
						$itemid = !empty($report_data['sade_itemsid'])?$report_data['sade_itemsid']:'';
						if(!empty($itemid)): 
							foreach($itemid as $key=>$products):
								$itemid = !empty($report_data['sade_itemsid'][$key])?$report_data['sade_itemsid'][$key]:'';
								$itemname =  $this->general->get_tbl_data('*','itli_itemslist',array('itli_itemlistid'=>$itemid),false,'DESC');

								$productcode = !empty($itemname[0]->itli_itemcode)?$itemname[0]->itli_itemcode:'';
								$productname = !empty($itemname[0]->itli_itemname)?$itemname[0]->itli_itemname:'';

								$unit = !empty($report_data['unit'][$key])?$report_data['unit'][$key]:'';

								$cur_qty = !empty($report_data['sade_qty'][$key])?$report_data['sade_qty'][$key]:'';
								$rate = !empty($report_data['sade_purchaserate'][$key])?$report_data['sade_purchaserate'][$key]:'';

								$remarks = !empty($report_data['sade_remarks'][$key])?$report_data['sade_remarks'][$key]:'';
					?>
						<tr>
			                <td class="td_cell">
			                    <?php echo $key+1; ?>
			                </td>
			                <td class="td_cell">
			                    <?php echo $productcode; ?>
			                </td>
			                <td class="td_cell">
			                </td>
			                <td class="td_cell">
			                    <?php echo $productname; ?>
			                </td>
			                <td class="td_cell">
			                </td>
			                <td class="td_cell">
			                   <?php echo $cur_qty; ?>
			                </td>
			                <td class="td_cell"> 
			                    <?php echo $unit; ?> 
			                </td> 
			                <td class="td_cell">
			                    <?php echo $rate;?>
			                </td>
			                <td class="td_cell"></td>
			                <td class="td_cell"></td>
			            </tr>
					<?php
							endforeach;
						endif;
					}
				?>
				
				<?php
					$row_count = count($products);
					if($row_count < 7):
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
						<td class="td_empty"></td>
					</tr>
				<?php endif ?>
			</tbody>
			<tfoot>
				<tr>
					<td class="td_cell" colspan="7">अक्षरेपी </td>
					<td> कुल जम्मा</td>
					<td></td>
					<td></td>
					
				</tr>
			</tfoot>
		</table>
	</div>

	<table class="jo_footer" style="width: 100%;border:0px; margin-top:20px;">
	<tr>
		<td></td>
		<td colspan="2">__________________</td>
		<td></td>
		<td></td>
		<td></td>
		<td colspan="2">__________________</td>
		<td></td>
		<td></td>
		<td></td>
		<td colspan="2">__________________</td>
		
	</tr>

	<tr>
		<td></td>
		<td>माग गर्नेको सही</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td>बुझिलिनेको सही</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td>स्वीकृति गर्ने</td>
		<td></td>
		
	</tr>
	<tr>
		<td></td>
		<td>नाम</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td>नाम</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td colspan="2">__________________</td>
		<td></td>
		<td></td>
		<td></td>
		<td colspan="2">__________________</td>
		<td></td>
		<td></td>
		<td></td>
		<td colspan="2">__________________</td>
		
	</tr>
	
	<tr>
		<td> </td>
		<td>निकासी गर्ने</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td>मूल्य जिन्सी खाता भर्ने</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td>निकासीको लागि आदेश दिने</td>
		<td></td>
	</tr>


	</table>
</div>