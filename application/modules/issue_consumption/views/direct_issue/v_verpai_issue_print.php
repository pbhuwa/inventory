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
	.itemInfo tr th {
		text-align: center;
		font-size: 14px;
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
           
        </tr>
        <tr>
            <td width="33.333333%"></td>
            <td width="33.333333%" style="text-align: center;white-space: nowrap;"><h3 style="font-weight: 600;margin-bottom: 3px;margin-top: 3px;" class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAME;?></h3></td>
            <td width="33.333333%"></td>
        </tr>
        <tr>
            <td width="33.333333%"></td>
            <td width="33.333333%" style="text-align: center;"><h4 style="margin-bottom: 0px;" <span class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAMEDESC;?></span> </h4></td>
            <td width="33.333333%"></td>
        </tr>
        <tr>
            <td width="33.333333%"></td>
            <td width="33.333333%" style="text-align: center;"><?php echo LOCATION;?></td>
            <td width="33.333333%"></td>
        </tr>
        <tr>
            <td width="33.333333%"></td>
            <td width="33.333333%" style="text-align: center;"><h4 style="margin-top: 5px;font-size: 16px;font-weight: 600;"><u>भर्पाइ फारम</u></h4></td>
            <td width="33.333333%"></td>
        </tr>
    </table>

   
<table class="main" width="100%" style="margin-top: 14px;">
		<thead>
			<tr>
				<td width="">जिन्सी शाखा</td>
				<td width=""></td>
				<td width=""></td>
			</tr>
			<tr>
				<td width="" class="overflow" style="padding:15px 0 ;">स्थान :-<?php echo LOCATION;?></td>
				<td width="" class="overflow" style="padding:15px 0 ">नं :-
				<?php
							
								echo !empty($issue_master[0]->sama_invoiceno)?$issue_master[0]->sama_invoiceno:'';
							
						?></td>
				<td width="" class="overflow" style="text-align: right;padding:15px 0 ">मिति :-
				<span style="border-bottom: 1px dashed;font-size: 12px;"> 
						<?php
							if(DEFAULT_DATEPICKER == 'NP'){
								echo !empty($issue_master[0]->sama_billdatebs)?$issue_master[0]->sama_billdatebs:'';
							} else{
								echo !empty($issue_master[0]->sama_billdatead)?$issue_master[0]->sama_billdatead:'';
							}
						?>
					</span></td>
			</tr>

		</thead>
		<table width="100%">
			<tr>
				<td style="padding-left: 22px;padding-top: 12px;padding-bottom: 18px;">
				तपसिल बमोजिमका सामानहरू ठीक हालतमा प्राप्त भएका छन् ।प्राप्त सामानहरू जीन्सी रजिष्टरमा चढाइएका छन्।
				</td>
				
			</tr>
		</table>
	</table>

	<div class="tableWrapper">
		<table  class="jo_table itemInfo" style="border-bottom: 1px solid #333;">
			<thead>
				<tr>
					<th width="5%" class="td_cell"> क्र.स.</th>
					<th width="30%" class="td_cell"> सामानको विवरण</th>
					<th width="10%" class="td_cell"> परिमाण </th>
					<th width="3%" class="td_cell"> ईकाई</th>
					<th width="10%" class="td_cell"> रकम रू </th>
					<th width="10%" class="td_cell"> बिल मिति</th>
					<th width="10%" class="td_cell"> बिल नं </th>
					<th width="10%" class="td_cell"> कैफियत </th>
					
				</tr>
			</thead>
			<tbody >
				<?php
					if($issue_details):
						
						
						
						foreach($issue_details as $key=>$issue):
							$productcode = $issue->itli_itemcode;
							$productname = $issue->itli_itemname;
							$unit=!empty($issue->unit_unitname)?$issue->unit_unitname:'';
							$cur_qty=!empty($issue->sade_curqty)?$issue->sade_curqty:'';	
							$rate = !empty($issue->sade_purchaserate)?$issue->sade_purchaserate:'';	
							$billdate = !empty($issue->sade_billdatebs)?$issue->sade_billdatebs:'';	 
							$remaks=!empty($issue->sade_remarks)?$issue->sade_remarks:'';?>
				
					<tr>
		                <td class="td_cell">
		                    <?php echo $key+1; ?>
		                </td>
		                <td class="td_cell">
		                    <?php echo $productname; ?>
		                </td>
		               
		                <td class="td_cell">
		                    <?php echo $cur_qty; ?>
		                </td>
		                 <td class="td_cell">
		                 	 <?php echo $unit; ?>
		                </td>
		                
		                <td class="td_cell">
		                   <?php echo $rate; ?>
		                </td>
		                <td class="td_cell"> 
		                    
		                </td> 
		                <td class="td_cell">
		                   
		                </td>
		                <td class="td_cell">
		                	<?php echo $remaks; ?>
		                </td>
		                
		            </tr>
		        <?php 
					endforeach;
					
				 endif ?>
				 <?php
				 if($issue_details):
				 	$row_count=1;
				 		if(is_array($issue)):
							$row_count = sizeof($issue);
						endif;
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
						
					</tr>
				<?php endif;
				endif; ?>
			</tbody>
		</table>
	</div>

	<table class="table-footer" width="100%" style="border-top: 1px solid #333">
		<tr>
			<td style="padding: 25px 0 5px 0;">
				<span style="border-bottom: 1px dashed;font-size: 12px;"> 
					<?php echo !empty($issue_master[0]->sama_receivedby)?$issue_master[0]->sama_receivedby:''; ?>
				</span>
			</td>
			<td style="text-align: center; padding: 25px 0 5px 0;">
				<span style="border-bottom: 1px dashed;font-size: 12px;"> 
					<?php echo !empty($issue_master[0]->sama_soldby)?$issue_master[0]->sama_soldby:''; ?>
				</span>
			</td>
		</tr>
		<tr>
			<td>बुझिलिने कर्मचारीको सही</td>
			<td style="text-align: center;">शाखा प्रमुखको सही</td>
		</tr>
		<tr>
			<td style="padding: 25px 0 0px 0;">नाम :-</td>
		</tr>
		<tr>
			<td style="padding: 10px 0;">पद :-</td>
		</tr>
		<tr>
			<td style="padding: 0px 0;">शाखा :-</td>
		</tr>
	</table>

</div>