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
	.jo_footer td { padding:0px; margin: 0;}
	.preeti{
		font-family: preeti;
	}
	.jo_footer td{
		line-height: 0;
	}
	.tableWrapper{
		min-height:40%;
		height:50vh;
		max-height: 100vh;
		white-space: nowrap;
		display: table;
		width: 100%;
		/*overflow-y: auto;*/
	}
	.tableWrapper table tr th {
		text-align: center;
	}
	.itemInfo{
		height:100%;
	}
	.jo_footer tr td {
		padding: 0px auto !important;
		margin: 0 !important;
		line-height: 0 !important;
		overflow: hidden !important;
		clear: both !important;

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
    		$invoiceno = !empty($issue_master[0]->haov_invoiceno)?$issue_master[0]->haov_invoiceno:'';
    		$handover_reqno = !empty($issue_master[0]->haov_handoverreqno)?$issue_master[0]->haov_handoverreqno:'';
    		$depid = !empty($issue_master[0]->haov_depid)?$issue_master[0]->haov_depid:'';

    		$dep_info =  $this->general->get_tbl_data('*','dept_department',array('dept_depid'=>$depid),false,'DESC');
    		$depname = !empty($dep_info[0]->dept_depname)?$dep_info[0]->dept_depname:'';

    		if(DEFAULT_DATEPICKER == 'NP'){
    			$issue_date = !empty($issue_master[0]->haov_reqdatebs)?$issue_master[0]->haov_reqdatebs:'';
    			$req_date = !empty($issue_master[0]->haov_reqdatebs)?$issue_master[0]->haov_reqdatebs:'';
    		}else{
    			$issue_date = !empty($issue_master[0]->haov_reqdatead)?$issue_master[0]->haov_reqdatead:'';
    			$req_date = !empty($issue_master[0]->haov_reqdatead)?$issue_master[0]->haov_reqdatead:'';
    		}

	    	$receivedby = !empty($issue_master[0]->haov_receivedby)?$issue_master[0]->haov_receivedby:'';
    	}else{
    		$invoiceno = !empty($report_data['haov_invoiceno'])?$report_data['haov_invoiceno']:'';
    		$depid = !empty($report_data['haov_depid'])?$report_data['haov_depid']:'';

    		$dep_info =  $this->general->get_tbl_data('*','dept_department',array('dept_depid'=>$depid),false,'DESC');
    		$depname = !empty($dep_info[0]->dept_depname)?$dep_info[0]->dept_depname:'';
    		
	    	$req_date = !empty($report_data['requisition_date'])?$report_data['requisition_date']:'';
	    	$issue_date = !empty($report_data['issue_date'])?$report_data['issue_date']:'';
	    	$receivedby = !empty($report_data['haov_receivedby'])?$report_data['haov_receivedby']:'';
    	}    	
    ?>
	<table class="jo_tbl_head" style="margin-top: -30px !important;">
		<tr>
			<td></td>
			<td></td>
			<td width="33.33333%%" class="text-right"><span style="font-size: 12px;position: relative;top:35px; right: 180px;" class="">ह. फा. न. :- <?php echo $handover_reqno;?><br> <br> मिति:- <?php echo $req_date;?></span>  
					</td>
		</tr>
		<tr>
			<td colspan="3">
				शाखा :- <?php echo $depid;?><br> <br>
				कामकाे:- <br>	<br>
				कामकाे स्थान:-  
			</td>
		</tr>	
	</table>

	<div class="tableWrapper" style="margin-top: 0px !important;">
		<table  class="jo_table itemInfo" style="border-bottom: 1px solid #333;">
			<thead>
				<tr>
					<!-- <th width="5%" class="td_cell" > क्र.स.</th> -->
					<th width="7%" class="td_cell" rowspan="2" > जिन्सी पाना न. </th>
					<th width="7%" class="td_cell" rowspan="2" > 
					 काेड न. </th>
					<th width="30%" class="td_cell" rowspan="2"  > बिबरण </th>
					
					<th width="15%" class="td_cell" colspan="2" > परमाण </th>

					<th width="7%" class="td_cell" rowspan="2"> इकाई  </th>
					<th width="10%" class="td_cell" > दर </th>

					<th width="15%" class="td_cell" > जम्मा रकम  </th>
					
					<th width="10%" class="td_cell" rowspan="2"> कैफियत </th>
				</tr>

				<tr colspan="9">
					<th >माघ</th>
					<th >निकोसी</th>

					<th >रू</th>
					<th >रू</th>
				</tr>
				
			</thead>
			<tbody>
				<?php
					if($all_issue_details){
						// print_r($all_issue_details);
						// die();
						$gtotal=0;
						foreach($all_issue_details as $key=>$products):
							$productcode = $products->itli_itemcode;
							$productname = $products->itli_itemname;
							$unit=!empty($products->unit_unitname)?$products->unit_unitname:'';
							$hard_qty=!empty($products->haod_qty)?$products->haod_qty:'';	
							$rate = !empty($products->haod_unitprice)?$products->haod_unitprice:'';
							$total=!empty($products->haod_totalamt)?$products->haod_totalamt:'';
							$remaks=!empty($products->hard_remarks)?$products->haod_remarks:'';
				?>
					<tr>
		                <td class="td_cell">
		                    <?php echo $key+1; ?>
		                </td>
		               
		                <td class="td_cell">
		                    <?php echo $productcode; ?>
		                </td>
		               
		                <td class="td_cell">
		                    <?php echo $productname; ?>
		                </td>
		               
		                <td class="td_cell" style="text-align: right;">
		                   <?php echo $hard_qty; ?>
		                </td>
		                 <td class="td_cell" style="text-align: right;">
		                   <?php echo $hard_qty; ?>
		                </td>
		                <td class="td_cell" style="text-align: right;"> 
		                    <?php echo $unit; ?> 
		                </td> 
		                <td class="td_cell" style="text-align: right;">
		                    <?php echo $rate;?>
		                </td>
		                <td class="td_cell" style="text-align: right;">
		                	 <?php echo $total;?>
		                </td>
		                 <td class="td_cell"><?php echo $remaks; ?></td> 
		            </tr>
		        <?php 
		        $gtotal+= $total;
					endforeach;
					}else{
						$itemid = !empty($report_data['hard_itemsid'])?$report_data['hard_itemsid']:'';
						if(!empty($itemid)): 
							foreach($itemid as $key=>$products):
								$itemid = !empty($report_data['hard_itemsid'][$key])?$report_data['hard_itemsid'][$key]:'';
								$itemname =  $this->general->get_tbl_data('*','itli_itemslist',array('itli_itemlistid'=>$itemid),false,'DESC');

								$productcode = !empty($itemname[0]->itli_itemcode)?$itemname[0]->itli_itemcode:'';
								$productname = !empty($itemname[0]->itli_itemname)?$itemname[0]->itli_itemname:'';

								$unit = !empty($report_data['unit'][$key])?$report_data['unit'][$key]:'';

								$cur_qty = !empty($report_data['hard_qty'][$key])?$report_data['hard_qty'][$key]:'';
								$rate = !empty($report_data['hard_purchaserate'][$key])?$report_data['hard_purchaserate'][$key]:'';

								$remarks = !empty($report_data['hard_remarks'][$key])?$report_data['hard_remarks'][$key]:'';
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
			                <td class="td_cell" style="text-align: right;">
			                   <?php echo $cur_qty; ?>
			                </td>
			                <td class="td_cell" > 
			                    <?php echo $unit; ?> 
			                </td> 
			                <td class="td_cell" style="text-align: right;">
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
					$row_count = count($all_issue_details);
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
					</tr>
				<?php endif ?>
			</tbody>
			<tfoot>
				<tr>
					<td class="td_cell">अक्षरेपी </td>
					<td class="td_cell" colspan="5" ><?php echo !empty($gtotal)?$this->general->number_to_word( $gtotal):''; ?>	</td>
					<td> कुल जम्मा</td>
					<td style="text-align: right;"><?php echo !empty($gtotal)? $gtotal:''; ?></td>
					<td></td>
					
				</tr>
			</tfoot>
		</table>
	</div>

	<?php
		// department head
     	$department_head_data = $this->general->get_username_from_actionlog(array('aclo_tablename'=>'harm_handoverreqmaster','aclo_masterid'=>$harm_handovermasterid,'aclo_status'=>1));
      	// echo $this->db->last_query();
      	// die();
      	$department_head_fullname = $department_head_data[0]->usma_fullname;
      	$department_head_empid = $department_head_data[0]->usma_employeeid;
	?>
	<table class="jo_footer" style="width: 100%;border:none; margin-top:55px;">
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

	<tr style="margin-top: -25px !important; ">
		<td style="margin-top: -25px !important; position: relative; top: -18px; "></td>
		<td style="margin-top: -25px !important; position: relative; top: -18px; ">माग गर्नेको सही</td>
		<td style="margin-top: -25px !important; position: relative; top: -18px; "></td>
		<td style="margin-top: -25px !important; position: relative; top: -18px; "></td>
		<td style="margin-top: -25px !important; position: relative; top: -18px; "></td>
		<td style="margin-top: -25px !important; position: relative; top: -18px; "></td>
		<td style="margin-top: -25px !important; position: relative; top: -18px; ">बुझिलिनेको सही</td>
		<td style="margin-top: -25px !important; position: relative; top: -18px; "></td>
		<td style="margin-top: -25px !important; position: relative; top: -18px; "></td>
		<td style="margin-top: -25px !important; position: relative; top: -18px; "></td>
		<td style="margin-top: -25px !important; position: relative; top: -18px; "></td>
		<td style="margin-top: -25px !important; position: relative; top: -18px; ">स्वीकृति गर्ने</td>
		<td style="margin-top: -25px !important; position: relative; top: -18px; "></td>
		
	</tr>
	<tr>
		<td style="margin-top: -25px !important; position: relative; top: -35px; "></td>
		<td style="margin-top: -25px !important; position: relative; top: -35px; ">नाम :-</td>
		<td style="margin-top: -25px !important; position: relative; top: -35px; "></td>
		<td style="margin-top: -25px !important; position: relative; top: -35px; "></td>
		<td style="margin-top: -25px !important; position: relative; top: -35px; "></td>
		<td style="margin-top: -25px !important; position: relative; top: -35px; "></td>
		<td style="margin-top: -25px !important; position: relative; top: -35px; ">नाम :-</td>
		<td style="margin-top: -25px !important; position: relative; top: -35px; "></td>
		<td style="margin-top: -25px !important; position: relative; top: -35px; "></td>
		<td style="margin-top: -25px !important; position: relative; top: -35px; "></td>
		<td style="margin-top: -25px !important; position: relative; top: -35px; "></td>
		<td style="margin-top: -25px !important; position: relative; top: -35px; "></td>
		<td style="margin-top: -25px !important; position: relative; top: -35px; "></td>
		<td style="margin-top: -25px !important; position: relative; top: -35px; "></td>
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
		<td style="margin-top: -25px !important; position: relative; top: -15px; "> </td>
		<td style="margin-top: -25px !important; position: relative; top: -15px; ">निकासी गर्ने</td>
		<td style="margin-top: -25px !important; position: relative; top: -15px; "></td>
		<td style="margin-top: -25px !important; position: relative; top: -15px; "></td>
		<td style="margin-top: -25px !important; position: relative; top: -15px; "></td>
		<td style="margin-top: -25px !important; position: relative; top: -15px; "></td>
		<td style="margin-top: -25px !important; position: relative; top: -15px; ">मूल्य जिन्सी खाता भर्ने</td>
		<td style="margin-top: -25px !important; position: relative; top: -15px; "></td>
		<td style="margin-top: -25px !important; position: relative; top: -15px; "></td>
		<td style="margin-top: -25px !important; position: relative; top: -15px; "></td>
		<td style="margin-top: -25px !important; position: relative; top: -15px; "></td>
		<td style="margin-top: -25px !important; position: relative; top: -15px; ">निकासीको लागि आदेश दिने</td>
		<td style="margin-top: -25px !important; position: relative; top: -15px; text-align: center; "></td>
	</tr>


	</table>
</div>