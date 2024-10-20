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

</style>
<div class="jo_form organizationInfo newPrintSection">
		<table class="table_jo_header purchaseInfo">
		<tr>
			<td width="25%" rowspan="5"></td>
			<td class="text-center"><h3 class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAME;?></h3></td>
			<td width="25%" rowspan="5" class="text-right"></td>
		</tr>
		<tr>
			<td class="text-center"><h4 class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAMEDESC;?></h4></td>
		</tr>
		<tr>
			<td class="text-center <?php echo FONT_CLASS; ?>"><?php echo LOCATION;?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td class="text-center <?php echo FONT_CLASS; ?>"><h4><u>माग फारम</u></h4></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td class="pull-right"><span class="<?php echo FONT_CLASS; ?>"> निकासी न </span> : <?php echo !empty($issue_master[0]->sama_invoiceno)?$issue_master[0]->sama_invoiceno:'';?></td>
			
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td class="pull-right"> <span class="<?php echo FONT_CLASS; ?>">निकासी मिति </span> : <?php echo !empty($issue_master[0]->sama_requisitiondatebs)?$issue_master[0]->sama_requisitiondatebs:'';?></td>

		</tr>
	</table>
	<table class="jo_tbl_head">
		<tr>
			<td colspan="2" style="margin-bottom: 5px;"><span class="<?php echo FONT_CLASS; ?>"> श्री  प्रमुख</span>
			</td>
		</tr>
		<tr>
			<td width="25%" style="margin-bottom: 5px;">
				<span style="border-bottom: 1px dashed;"><?php echo !empty($store[0]->eqty_equipmenttype)?$store[0]->eqty_equipmenttype:''; ?></span>  <span class="<?php echo FONT_CLASS; ?>"> शाखा </span>
			</td>
			<!-- <td width="25%" class="text-right"><span class="<?php echo FONT_CLASS; ?>"> शाखा </span></td> -->
			<td width="25%" class="text-right"><span class="<?php echo FONT_CLASS; ?>"> माग न </span>: 
				<?php echo !empty($issue_master[0]->sama_requisitionno)?$issue_master[0]->sama_requisitionno:'';?>
			</td>

			<td width="25%" class="text-right"><span class="<?php echo FONT_CLASS; ?>"> मिति </span>: 
				<?php
					if(DEFAULT_DATEPICKER == 'NP'){
						echo !empty($issue_master[0]->sama_billdatebs)?$issue_master[0]->sama_billdatebs:'';
					} else{
						echo !empty($issue_master[0]->sama_billdatead)?$issue_master[0]->sama_billdatead:'';
					}
				?>
			</td>

			<td width="25%" class="text-right"><span class="<?php echo FONT_CLASS; ?>"> आर्थिक वर्ष </span>: 
				<?php echo !empty($issue_master[0]->sama_fyear)?$issue_master[0]->sama_fyear:'';?>
			</td>
		</tr>
		
	</table>
		<table  class="jo_table itemInfo">
			<thead>
				<tr>
					<th width="5%"> सि .</th>
                    <th width="10%"> मलसामानको विवरण </th>
                    <th width="30%"> सामानको नाम </th>
                    <th width="10%"> एकाइ </th>
                    <th width="10%">परिमाण</th>
                    <th width="10%"> सामानको परिमाण </th>
                    <th width="10%"> निकासी सामानको परिमाण </th>
                    <th width="25%"> कैफियत </th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(!empty($issue_details)):
				foreach($issue_details as $key=>$products):
			?>
			<tr>
                <td>
                    <?php echo $key+1; ?>
                </td>
                <td>
                    <?php echo $products->itli_itemcode;?>
                </td>
                <td>
                    <?php echo $products->itli_itemname; ?>
                </td>
                <td>
                     <?php $unit=!empty($products->unit_unitname)?$products->unit_unitname:'';?> 
                        <?php echo $unit;?> 
                </td>
                <td>
                    <?php $qty=!empty($products->totalqty)?$products->totalqty:'';?> 
                        <?php echo $qty;?>
                </td>
                <td>
                   <?php $unitrate=!empty($products->sade_unitrate)?$products->sade_unitrate:'';?>
                        <?php echo $unitrate;?>
                </td>
                <td>
                    <?php $discount=!empty($products->sade_discount)?$products->sade_discount:'';?>
                    <?php echo $discount;?>
                </td>
                <td>
                    <?php $puderemaks=!empty($products->sade_remarks)?$products->sade_remarks:'';?>
                        <?php echo $puderemaks;?>
                            
                </td>
            </tr>
			<?php
				endforeach;
				endif;
			?>
				
			</tbody>
		</table>

		<table class="jo_footer">
			<tr>
				<td width="60%">माग गर्नेको दस्तखत  : </td>
				<td width="40%">(क) बजारबाट खरिद गरिदिनु । </td>
			</tr>
			<tr>
				<td>नाम  : </td>
				<td>(ख) मौज्दात दिनु ।</td>
			</tr>
			<tr>
				<td>मिति  : </td>
				<td></td>
			</tr>
			<tr>
				<td>प्रायोजन  : </td>
				<td>आदेश दिनेको दस्तखत  : </td>
			</tr>
			<tr>
				<td></td>
				<td>मिति  : </td>
			</tr>
			<tr>
				<td>जिन्सी खाता चढाउनेको दस्तखत  : </td>
				<td></td>
			</tr>
			<tr>
				<td>मिति  : </td>
				<td>माल सामान बुझिलिनेको दस्तखत  : </td>
			</tr>
			<tr>
				<td></td>
				<td>मिति  : </td>
			</tr>
			<tr>
				<td>तयार पार्नेका नाम  : </td>
				<td></td>
			</tr>
			<tr>
				<td>मिति  : </td>
				<td></td>
			</tr>
			<tr>
				<td>दस्तखत  : </td>
				<td></td>
			</tr>
			
		</table>

</div>