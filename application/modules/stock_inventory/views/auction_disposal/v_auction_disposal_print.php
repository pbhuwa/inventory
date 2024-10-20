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
	.officer_detailTable tr th{text-align: left; font-weight: 500;margin-bottom: 5px;font-size: 12px;}
    .officer_detailTable tr td{font-size: 12px;}	
        .preeti{
        font-family: preeti;
    }
    .purchaserecive{border-collapse: collapse;}
    .purchaserecive-table tr th{border-bottom: 1px solid #ddd;padding: 4px;}
    .purchaserecive-table tr td{border-bottom: 1px solid #ddd;padding: 4px;}
    .purchaserecive-table tr:last-child td{border-bottom: 0px;}
	/*.itemInfo tr:last-child td{border:0px !important;}
	.itemInfo {border-bottom: 0px;}*/
</style>

<div class="jo_form organizationInfo">
	<table class="table_jo_header purchaseInfo">
		<tr>
            <td width="33.333333%"></td>
            <td width="33.333333%" style="text-align: center;"><span style="font-size: 12px;" class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAMETITLE ;?></span></td>
            <td width="33.333333%" style="text-align: right;white-space: nowrap;"><span style="text-align: right;font-size: 12px;"><!--म.ले.प.फा.नं ४८--></span></td>
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
            <td width="33.333333%" style="text-align: center;"><h4 style="margin-top: 5px;font-size: 16px;font-weight: 600;"><u>लिलामी/नष्ट फारम</u></h4></td>
            <td width="33.333333%"></td>
        </tr>
    </table>

    <?php

    $invoiceno = '';
    $depname = '';
    $disposal_type = '';
    $customer_name = '';
    	
    	if($disposal_master){
    		$invoiceno = !empty($disposal_master[0]->sama_invoiceno)?$disposal_master[0]->sama_invoiceno:'';
    		$disposal_type = !empty($disposal_master[0]->dety_name)?$disposal_master[0]->dety_name:'';
    		$customer_name = !empty($disposal_master[0]->asde_customer_name)?$disposal_master[0]->asde_customer_name:'';
    		
    		if(DEFAULT_DATEPICKER == 'NP'){
    			$disposal_date = !empty($disposal_master[0]->asde_deposaldatebs)?$disposal_master[0]->asde_deposaldatebs:CURDATE_NP;
    		}else{
    			$disposal_date = !empty($disposal_master[0]->asde_desposaldatead)?$disposal_master[0]->asde_desposaldatead:CURDATE_EN;
    		}

	    	$customer_name = !empty($disposal_master[0]->asde_customer_name)?$disposal_master[0]->asde_customer_name:'';
    	}
    ?>
	<table class="jo_tbl_head" style="margin-top: 10px;">
		<tr>
			<td width="33.33333%" class="text-left">
				<strong>प्रकार :</strong>
				<?php echo $disposal_type; ?>
			</td>
			<td></td>
			<td width="33.33333%" class="text-right" >
				<strong>मिति: </strong>
			 	<span class="bb"> 
					<?php 
						echo $disposal_date;
					?>
				</span>
			</td>
		</tr>
		<tr>
			<td width="33.33333%" class="text-left">
				<strong>ग्राहकको नाम:</strong>
				<?php 
						echo $customer_name;
					?>
			</td>
			<td></td>
			<td width="33.33333%" class="text-right"><span style="font-size: 12px;" class="">
			<strong>लि/न. फा. न. :</strong> </span> 
			<?php if($disposal_detail){ 
				echo !empty($disposal_master[0]->asde_disposalno)?$disposal_master[0]->asde_disposalno:'';
			 }?>
			</td>
		</tr>
		<tr>
			<td colspan="3">
			</td>
		</tr>	
	</table>

	<div class="tableWrapper">
		<table  class="jo_table itemInfo" style="border-bottom: 1px solid #333;">
			<thead>
				<tr>
					<th width="5%" class="td_cell">क्र.स.</th>
					<th width="7%" class="td_cell">जिन्सी खाता पाना न. </th>
					<th width="7%" class="td_cell">जिन्सी वर्गीकरण संकेत न. </th>
					<th width="25%" class="td_cell">सामानको नाम </th>
					<th width="7%" class="td_cell">लिलामी/नष्ट परिमाण </th>
					<th width="10%" class="td_cell">बिक्री मुल्य</th>
					<th width="10%" class="td_cell">टिप्पणी</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$total_disposal_qty = 0;
					$total_sales_amount = 0;	
					if($disposal_detail){
					foreach($disposal_detail as $key=>$products):
					$total_disposal_qty += $products->asdd_disposalqty;
					$total_sales_amount += $products->asdd_sales_totalamt;

				?>
					<tr>
		                <td class="td_cell">
		                    <?php echo $key+1; ?>
		                </td>
		                <td class="td_cell">
		                    <?php echo $products->asen_assetcode; ?>
		                </td>
		                <td class="td_cell">
		                </td>
		                <td class="td_cell">
		                    <?php echo $products->asen_description; ?>
		                </td>
		            
		                <td class="td_cell" style="text-align: right;">
		                   <?php echo $products->asdd_disposalqty; ?>
		                </td>
		                <td class="td_cell" style="text-align: right;"> 
		                    <?php echo number_format($products->asdd_sales_totalamt,2); ?> 
		                </td> 
		                <td class="td_cell">
		                    <?php echo $products->asdd_remarks;?>
		                </td>
		         
		            </tr>
		        <?php 
					endforeach;
					}
				?>
				
				<?php
					$row_count = (!empty($disposal_detail) && is_array($disposal_detail) )? count($disposal_detail) : 0;
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
					</tr>
				<?php endif ?>
			</tbody>
			<tfoot>
				<tr>
					<td class="td_cell" style="text-align: right;"colspan="4">कूल जम्मा:</td>
					<td class="td_cell" style="text-align: right;"><?php echo number_format($total_disposal_qty,2);?></td>
					<td class="td_cell" style="text-align: right;"><?php echo number_format($total_sales_amount,2);?></td>
					<td class="td_cell"></td>
				</tr>
				<tr>
				<td colspan="7" style="overflow-wrap: break-word;white-space: nowrap;text-align: center;"><strong>शब्दमा : </strong> 
					<?php 
						if($disposal_detail){
                            echo $this->general->number_to_word($total_sales_amount);
                        } 
                    ?> 
                </td>
				</tr>
			</tfoot> 
		</table>
	</div>
	<!-- <table width="100%" class="amount-table">
		<tbody>
			<tr>
				<td colspan="4" style="text-align: right;font-size: 12px;">
					<span class="">कूल  जम्मा </span>:
				</td>
				<td style="border-right: 1px solid #000;">
					<?php echo !empty($total_disposal_qty)?number_format($total_disposal_qty,2):''; ?>
				</td>
				<td style="border-right: 1px solid #000;">
					<?php echo !empty($total_sales_amount)?number_format($total_sales_amount,2):''; ?>
				</td>
			</tr>
			<tr>
				<td colspan="12" style="overflow-wrap: break-word;white-space: nowrap;text-align: center;"><strong>शब्दमा : </strong> 
					<?php 
						if($disposal_detail){
                            echo $this->general->number_to_word($total_sales_amount);
                        } 
                    ?> 
                </td>
			</tr>
		</tbody>
	</table> -->

	<table class="table officer_detailTable purchaserecive-table" style="width: 100%;border-left: 1px solid #333;border-right: 1px solid #333;border-bottom: 1px solid #333;border-top: 1px solid #fff;">
			<tr>
				<th style="padding-top: 30px;">फांटवालाको दस्तखत </th>
				<th style="padding-top: 30px;">कार्यालय प्रमुखको दस्तखत </th>
				<th style="padding-top: 30px;">प्रमाणित गर्नेको दस्तखत</th>
			</tr>
			<tr>
				<td>नाम:</td>
				<td>नाम:</td>
				<td>नाम:</td>
			</tr>
			<tr>
	            <td>पद:</td>
	            <td>पद:</td>
				<td>पद:</td>
			</tr>
			<tr>
	            <td>मिति: </td>
	            <td>मिति: </td>
				<td>मिति: </td>
			</tr>
	    </table>

	<!-- <table class="jo_footer" style="width: 100%;border:0px; margin-top:10px;">
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
	        		// echo !empty($disposal_master[0]->sama_username)?$disposal_master[0]->sama_username:'';
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
	        <td width="20%"><span>मिति: <?php //echo $issue_date;?></span></td>
	        <td width="20%"><span></span></td>
	    </tr>
	</table>

	<table class="jo_footer" style="width: 100%;border:0px; margin-top:10px;">
		<tr>
			<td colspan="4">
				
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
	</table> -->
</div>