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
</style>
<div class="jo_form organizationInfo">
		<table class="table_jo_header purchaseInfo">
			<tr>
				<td width="25%" rowspan="5"></td>
				<td class="text-center"><h3><?php echo ORGNAME;?></h3></td>
				<td width="25%" rowspan="5" class="text-right">2</td>
			</tr>
			<tr>
				<td class="text-center"><h4><?php echo ORGNAMEDESC;?></h4></td>
			</tr>
			<tr>
				<td class="text-center"><?php echo LOCATION;?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class="text-center"><h4><u>माग फारम</u></h4></td>
			</tr>
		</table>

		<table class="jo_tbl_head">
			<tr>
				<td></td>
				<td width="17%" class="text-right">मिति : <?php echo CURDATE_NP;?></td>
			</tr>
			<tr>
				<td colspan="2">श्री ....................................................................................................................................................................................लाई</td>
			</tr>
		</table>

		<table  class="jo_table itemInfo">
			<thead>
				<tr>
					<th width="5%"> सि .</th>
					<th width="10%"> मलसामानको विवरण </th>
					<th width="30%"> स्पेसिफिकेशन (आवश्यक पर्नेमा) </th>
					<th width="10%"> एकाइ </th>
					<th width="10%"> सामानको परिमाण </th>
				<!-- 	<th width="10%"> निकासी सामानको परिमाण </th> -->
					<th width="25%"> कैफियत </th>
				</tr>
			</thead>
			<tbody>
				<?php
				$itemid = !empty($report_data['rede_itemsid'])?$report_data['rede_itemsid']:'';
				if(!empty($itemid)): // echo"<pre>";print_r($itemid);die;
				foreach($itemid as $key=>$products):
			?>
			<tr>
				<td>
					<?php echo $key+1; ?>
				</td>
				<td>
					<?php echo !empty($report_data['rede_code'][$key])?$report_data['rede_code'][$key]:''; ?>
				</td>
				<td>
					<?php
						echo !empty($item_name[$key]->itli_itemname)?$item_name[$key]->itli_itemname:'';
					?>
				</td>
				<td>
					<?php echo !empty($report_data['rede_unit'][$key])?$report_data['rede_unit'][$key]:''; ?>
				</td>
				<td>
					<?php echo !empty($report_data['rede_qty'][$key])?$report_data['rede_qty'][$key]:''; ?>
				</td>
				<td>
					<?php echo !empty($report_data['rede_remarks'][$key])?$report_data['rede_remarks'][$key]:''; ?>
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