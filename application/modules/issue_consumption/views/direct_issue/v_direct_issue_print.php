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
		height:60vh;
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
	<table class="table_jo_header purchaseInfo">
		<tr>
            <td width="33.333333%"></td>
            <td width="33.333333%" style="text-align: center;"><span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAMETITLE ;?></span></td>
            <td width="33.333333%" style="text-align: right;white-space: nowrap;"><span style="text-align: right;font-size: 12px;">म.ले.प.फा.नं ४८</span></td>
        </tr>
        <tr>
            <td width="33.333333%"></td>
            <td width="33.333333%" style="text-align: center;white-space: nowrap;"><h3 style="font-weight: 600;margin-bottom: 3px;margin-top: 3px;" class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAME;?></h3></td>
            <td width="33.333333%"></td>
        </tr>
        <tr>
            <td width="33.333333%"></td>
            <td width="33.333333%" style="text-align: center;"><h4 style="margin-bottom: 0px;" ><span class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAMEDESC;?></span> </h4></td>
            <td width="33.333333%"></td>
        </tr>
        <tr>
            <td width="33.333333%"></td>
            <td width="33.333333%" style="text-align: center;"><?php echo LOCATION;?></td>
            <td width="33.333333%"></td>
        </tr>
        <tr>
            <td width="33.333333%"></td>
            <td width="33.333333%" style="text-align: center;"><h4 style="margin-top: 5px;font-size: 16px;font-weight: 600;"><u>हस्तान्तरण फारम</u></h4></td>
            <td width="33.333333%"></td>
        </tr>
    </table>

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
				<span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>"> श्री </span>
				<span style="border-bottom: 1px dashed;font-size: 12px;"> 
					<?php echo $depname; ?>
				</span> <br/>
				निम्न लिखित मालसामानहरु मिति <?php echo $issue_date;?> को निर्णयानुसार <?php echo $depname; ?> मन्त्रालय/ विभाग/ कार्यालय/ आयोजनाका श्री <?php echo $receivedby; ?> को हस्ते पठाएको छु। सो समान भण्डार गरी ७ दिनभित्र दाखिला समेत पठाइदिनुहुन अनुरोध छ। 
			</td>
		</tr>	
	</table>

	<div class="tableWrapper">
		<table  class="jo_table itemInfo" style="border-bottom: 1px solid #333;">
			<thead>
				<tr>
					<th width="5%" class="td_cell"> क्र.स.</th>
					<th width="7%" class="td_cell"> जिन्सी खाता पाना न. </th>
					<th width="7%" class="td_cell"> जिन्सी वर्गीकरण संकेत न. </th>
					<th width="25%" class="td_cell"> सामानको नाम </th>
					<th width="7%" class="td_cell"> स्पेसिफिकेशन </th>
					<th width="7%" class="td_cell"> परमाण </th>
					<th width="7%" class="td_cell"> इकाई </th>
					<th width="10%" class="td_cell"> जम्मा परल मुल्य </th>
					<th width="7%" class="td_cell"> शुरु प्राप्त मिति </th>
					<th width="15%" class="td_cell"> मालको भौतिक अवस्था </th>
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
					$row_count = count($issue_details);
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
		</table>
	</div>

	<table class="jo_footer" style="width: 100%;border:0px; margin-top:10px;">
		<tr>
	        <td width="10%"><span style="white-space: nowrap;">फाटवाला: </span></td>
	        <td width="40%"><span style="white-space: nowrap;">दस्तखत: </span></td>
	        <td width="10%"><span style="white-space: nowrap;">कार्यालय प्रमुख: </span></td>
	        <td width="40%"><span style="white-space: nowrap;">दस्तखत: </span></td>
	    </tr>
	    <tr>
	        <td width="10%"></td>
	        <td width="40%" style="white-space: nowrap;">नाम: </td>
	        <td width="10%">
	        	<?php 
	        		echo !empty($issue_master[0]->sama_username)?$issue_master[0]->sama_username:'';
	        	?>
	        </td>
	        <td width="40%" style="white-space: nowrap;">नाम: </td>
	    </tr>
	    <tr>
	        <td width="10%"></td>
	        <td width="40%" style="white-space: nowrap;">मिति: </td>
	        <td width="10%"></td>
	        <td width="40%" style="white-space: nowrap;">मिति: </td>
	    </tr>
	</table>

	<table class="jo_footer" style="width: 100%;border:0px; margin-top:10px;">
		<tr>
			<td colspan="4">
				माथि लेखिए बमोजिम मालसामानहरु <?php echo $depname; ?> मन्त्रालय / विभाग / कार्यालय / आयोजनामा दाखिला गर्ने गरी दुइ प्रति हस्तान्तरण फारम समेत बुझिलिए।
			</td>
		</tr>

	    <tr>
	        <td width="15%"><span>सामान बुझिलिनेको: </span></td>
	        <td width="25%"><span style="text-align: right;">नाम: </span></td>
	        <td width="20%"><span>पद: </span></td>
	        <td width="20%"><span>कार्यालय: </span></td>
	    </tr>
	     <tr>
	        <td width="15%"><span></span></td>
	        <td width="25%"><span style="text-align: right;">दस्तखत : </span></td>
	        <td width="20%"><span>मिति: <?php echo $issue_date;?></span></td>
	        <td width="20%"><span></span></td>
	    </tr>
	</table>

	<table class="jo_footer" style="width: 100%;border:0px; margin-top:10px;">
		<tr>
			<td colspan="4">
				माथि लेखिए बमोजिमका मालसामानहरु कार्यालयका श्री ........................................ हस्ते यस कार्यालयमा प्राप्त भएको प्रमाणित गर्दछु।
			</td>
		</tr>
		
		 <tr>
	        <td width="15%"><span>प्रमाणित गर्ने: </span></td>
	        <td width="25%"><span style="text-align: right;">नाम: </span></td>
	        <td width="20%"><span>पद: </span></td>
	        <td width="20%"><span>कार्यालय: </span></td>
	    </tr>
	     <tr>
	        <td width="15%"><span></span></td>
	        <td width="25%"><span style="text-align: right;">दस्तखत : </span></td>
	        <td width="20%"><span>मिति: </span></td>
	        <td width="20%"><span></span></td>
	    </tr>
	</table>
</div>