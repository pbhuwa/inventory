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
		.bold_title{
		font-weight: bold;
	}
	.jo_footer .spanborder {
      border: none !important;
      border-bottom: 1px dashed #000 !important;
   }
	.signatureDashedLine {
   min-width: 170px;display: inline-block; border:1px dashed #333;
   }
	.jo_footer tr td {
		padding: 5px auto !important;
		margin: 0 ;
		line-height: 10px !important;
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
    	// echo "<pre>";
    	// print_r($stock_req);
    	// die();
    	if($handover_master){
    		$invoiceno = !empty($handover_master[0]->harm_invoiceno)?$handover_master[0]->harm_invoiceno:'';
    		$depid = !empty($stock_req[0]->rema_reqfromdepid)?$stock_req[0]->rema_reqfromdepid:'';

    		$dep_info =  $this->general->get_tbl_data('*','dept_department',array('dept_depid'=>$depid),false,'DESC');
    		$depname = !empty($dep_info[0]->dept_depname)?$dep_info[0]->dept_depname:'';

    		if(DEFAULT_DATEPICKER == 'NP'){
    			$handover_date = !empty($handover_master[0]->harm_billdatebs)?$handover_master[0]->harm_billdatebs:'';
    			$req_date = !empty($handover_master[0]->harm_requisitiondatebs)?$handover_master[0]->harm_requisitiondatebs:'';
    		}else{
    			$handover_date = !empty($handover_master[0]->harm_billdatead)?$handover_master[0]->harm_billdatead:'';
    			$req_date = !empty($handover_master[0]->harm_requisitiondatead)?$handover_master[0]->harm_requisitiondatead:'';
    		}

	    	$receivedby = !empty($handover_master[0]->harm_receivedby)?$handover_master[0]->harm_receivedby:'';
    	}else{
    		$invoiceno = !empty($report_data['harm_invoiceno'])?$report_data['harm_invoiceno']:'';
    		$depid = !empty($report_data['harm_depid'])?$report_data['harm_depid']:'';

    		$dep_info =  $this->general->get_tbl_data('*','dept_department',array('dept_depid'=>$depid),false,'DESC');
    		$depname = !empty($dep_info[0]->dept_depname)?$dep_info[0]->dept_depname:'';
    		
	    	$req_date = !empty($report_data['requisition_date'])?$report_data['requisition_date']:'';
	    	$handover_date = !empty($report_data['issue_date'])?$report_data['issue_date']:'';
	    	$receivedby = !empty($report_data['harm_receivedby'])?$report_data['harm_receivedby']:'';
    	}    	
    ?>
	<table class="jo_tbl_head" style="margin-top: 45px !important;">
		<tr style="border-bottom:none;">
				<td style="font-size: 12px;"> 
					<span style="font-size: 12px;" class="bold_title">शाखा :- </span> 
					<span style="border-bottom:1px dashed #333">
						<?php echo $depname;?>
					</span>
				</td>
				<td></td>
				<td class="text-left" width="15%" style="font-size: 12px;"><span style="text-align: left;font-size: 12px;" class="bold_title">ह. फा. न. :- </span> 
					<span style="border-bottom:1px dashed #333">
						
						<?php if($handover_details){ 
				echo !empty($handover_master[0]->harm_handoverreqno)?$handover_master[0]->harm_handoverreqno:'';
			 }else{
			 	echo !empty($report_data['harm_handoverreqno'])?$report_data['harm_handoverreqno']:'';
			 } ?>
					</span>
				</td>
		</tr>
		<tr style="border-bottom:none;">
				<td style="font-size: 12px;"> 
					<span style="font-size: 12px;" class="bold_title">कामकाे बिबरण :-</span> 
					<span style="border-bottom:1px dashed #333">
						<?php echo !empty($stock_req[0]->rema_workdesc)?$stock_req[0]->rema_workdesc:'';;?>
					</span>
				</td>
				<td></td>
				<td class="text-left" width="15%" style="font-size: 12px;"><span style="text-align: left;font-size: 12px;" class="bold_title">मिति :-  </span> 
					<span style="border-bottom:1px dashed #333">
						<?php echo $req_date;?>
					</span>
				</td>
		</tr>
		<tr style="border-bottom:none;">
				<td style="font-size: 12px;"> 
					<span style="font-size: 12px;" class="bold_title">कामकाे स्थान :-</span> 
					<span style="border-bottom:1px dashed #333">
						<?php echo !empty($stock_req[0]->rema_workplace)?$stock_req[0]->rema_workplace:'';;?>
					</span>
				</td>
				<td></td>
				
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
					<th width="30%" class="td_cell" rowspan="2"  > विवरण </th>
					
					<th width="15%" class="td_cell" colspan="2" >  परिमाण </th>

					<th width="7%" class="td_cell" rowspan="2"> इकाई  </th>
					<th width="10%" class="td_cell" > दर </th>

					<th width="15%" class="td_cell" > जम्मा रकम  </th>
					
					<th width="10%" class="td_cell" rowspan="2"> कैफियत </th>
				</tr>

				<tr colspan="9">
					<th >माग</th>
					<th >निकासी</th>

					<th >रू</th>
					<th >रू</th>
				</tr>
				
			</thead>
			<tbody>
				<?php
					if($handover_details){
						// print_r($handover_details);
						// die();
						$gtotal=0;
						foreach($handover_details as $key=>$products):
							$productcode = $products->itli_itemcode;
							$productname = $products->itli_itemname;
							$unit=!empty($products->unit_unitname)?$products->unit_unitname:'';
							$hard_qty=!empty($products->hard_qty)?$products->hard_qty:'';	
							$rate = !empty($products->hard_unitprice)?$products->hard_unitprice:'';
							$total=!empty($products->hard_totalamt)?$products->hard_totalamt:'';
							$remaks=!empty($products->hard_remarks)?$products->hard_remarks:'';
				?>
					<tr>
		                <td class="td_cell">
		                    <?php echo $key+1; ?>
		                </td>
		                <td></td>
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
				$row_count=1;
				if(!empty($products) && is_array($products)){
					$row_count = sizeof($products);
				}
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
					<td class="td_cell" colspan="5" ><?php echo $this->general->number_to_word( $gtotal); ?>	</td>
					<td> कुल जम्मा</td>
					<td style="text-align: right;"><?php echo !empty($gtotal)? $gtotal:''; ?></td>
					<td></td>
					
				</tr>
			</tfoot>
		</table>
	</div>

	<?php

		$harm_handovermasterid = !empty($handover_master[0]->harm_handovermasterid)?$handover_master[0]->harm_handovermasterid:'';

		$where = array('aclo_tablename'=>'harm_handoverreqmaster','aclo_masterid'=>$harm_handovermasterid);
		$handover_user_details = $this->general->get_username_from_actionlog($where);

		// echo "<pre>";
		// print_r($handover_user_details);
		// die();

		$harm_username = !empty($handover_master[0]->harm_requestedby)?$handover_master[0]->harm_requestedby:'';
		$dh_fullname = !empty($handover_master[0]->harm_username)?$handover_master[0]->harm_username:'';
		$haov_username = !empty($handover_user_details[0]->usma_fullname)?$handover_user_details[0]->usma_fullname:'';
	?>
	<table class="jo_footer" style="width: 100%;border:none; margin-top:45px;">
		<tr style="padding-bottom: 20px;margin-bottom: 20px !important;">
            <td style="padding-top: 30px;">
               <span class="signatureDashedLine spanborder">
                  <?php echo $harm_username;?>
               </span></br>
               माग गर्नेको सही</br></br>
              	<span> नाम :-</span>
            </td>
            <td style="padding-top: 30px;">
               <span class="signatureDashedLine spanborder">
                  <?php echo $harm_username;?>
               </span></br>
               बुझिलिनेको सही<br><br>
               <span>नाम :-</span>
            </td>
            
            <td style="padding-top: 18px;">
               
               <span class="signatureDashedLine spanborder">
                 <?php echo $dh_fullname;?>
                <?php echo !empty($dh_empid)?'('.$dh_empid.')':'';?>
               </span></br>
              स्वीकृति गर्ने
            </td>
        </tr>
		
       <tr>
            <td style="padding-top: 25px;">
               <span class="signatureDashedLine spanborder">
                  <?php echo $haov_username;?>
               </span></br>
               निकासी गर्ने
               
            </td>
            <td style="padding-top: 25px;">
               <span class="signatureDashedLine spanborder">
                  <?php echo $haov_username;?>
               </span></br>
               मूल्य जिन्सी खाता भर्ने
            </td>
            
            <td style="padding-top: 25px;">
               
               	<span class="signatureDashedLine spanborder">
               	<?php echo $bm_fullname;?>
                <?php echo !empty($bm_empid)?'('.$bm_empid.')':'';?>
               </span></br>
             निकासीको लागि आदेश दिने
            </td>
         </tr>

         <tr>
         	<td>
         		<span class="signatureDashedLine spanborder">
                  <?php echo "";?>
               	</span></br>
               	सिफारिश गर्ने
            </td>
         </tr>


	</table>
</div>