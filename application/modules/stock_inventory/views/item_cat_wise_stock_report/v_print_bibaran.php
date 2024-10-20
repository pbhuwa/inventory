<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700" rel="stylesheet">
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
	.bb{border-bottom:1px dotted #333;}
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
	.jo_table tr:last-child td:nth-child(2){border: 0px;}
	.jo_table tr:last-child td:last-child{border-left: 0px;}
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
		padding:5px;
		margin:5px; 
	}
	.itemInfo .td_empty{
		height:100%;
	}
	.jo_table tbody tr td:nth-child(3){
		width: 100% !important;
	}
	
</style>
<div class="jo_form organizationInfo">

	<table class="table_jo_header purchaseInfo">
		<tr>
			<td></td>
			<td class="text-center"><span class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAMETITLE ;?></span></td>
			<td width="30%" class="text-right">
				<?php if(ORGANIZATION_NAME=='army'):
				 ?>
				 <span style="text-align: right; white-space: nowrap;">सै.क.कोष.फा.नं २८</span>
				 <?php else: ?>
				<span style="text-align: right; white-space: nowrap;">म.ले.प.फा.नं ५७</span>
			<?php endif; ?>
				</td>
		</tr>
		<tr>
			<td width="25%" rowspan="5"></td>
			<td class="text-center"><span style="font-size: 18px;font-weight: 600;" class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAME;?></span></td>
			<td width="25%" rowspan="5" class="text-right"></td>
		</tr>

	<tr>
		<td class="text-center" style="font-size: 12px;"><h4 style="font-size: 12px;margin-top: 5px;margin-bottom: 0px;"> <span class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAMEDESC;?></span>  </h4></td>
	</tr>
		<tr style="margin-top: 3px;">
		<td class="text-center"><span><?php echo LOCATION; ?></span></td>
	</tr>

		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td class="text-center"><h4 style="margin-top: 0px;"><u><span class="<?php echo FONT_CLASS; ?>">जिन्सी मौज्दातको वार्षिक विवरण</span></u></h4></td>
		</tr>
		<tr>
			<td></td>
<!-- 			<td class="text-center"><span class="<?php echo FONT_CLASS; ?>">आर्थिक बर्ष.....</span></td> -->
			<td></td>
		</tr>
	</table>

		
		 <?php if(!empty($searchResult)){ ?>
		
    	<div class="tableWrapper">
		<table class="jo_table itemInfo" style="width: 100%;border-collapse: collapse;border: 1px solid #333;">
			<tr>
				<th rowspan="2" width="5%">क्र. सं.</th>
				<th rowspan="2" width="10%">जिन्सी नं./ खातापान नं.</th>
				<th rowspan="2" width="20%">जिन्सी सामानको नाम / स्पेसीफिकेसन</th>
				<th colspan="4" width="33%">मौज्दात बाँकी</th>
				<th colspan="4" width="35%">जिन्सी सामानको भौतिक अवस्था परिमाण</th>
				<th rowspan="2" width="7%">कैफियत</th>

			</tr>
			<tr>
				<th>परिमाण</th>
				<th>एकाइ</th>
				<th>दर</th>
				<th>जम्मा मूल्य रु</th>
				<th>प्रयोगमा रहेको </th>
				<th>प्रयोगमा नरहेको</th>
				<th>मर्मत गर्नु पर्ने</th>
				<th>मर्मत हुन नसक्ने </th>

			</tr>
			<tr>
			<td style="text-align: center">१</td>
			<td style="text-align: center">२</td>
			<td style="text-align: center">३</td>
			<td style="text-align: center">४</td>
			<td style="text-align: center">५</td>
			<td style="text-align: center">६</td>
			<td style="text-align: center">७</td>
			<td style="text-align: center">८</td>
			<td style="text-align: center">९</td>
			<td style="text-align: center">१०</td>
			<td style="text-align: center">११</td>
			<td style="text-align: center">१२</td>
			

			</tr>
			<?php
			$sum=0;
			foreach ($searchResult as $key => $direct) { ?>
	            <tr style="border-bottom: 1px solid #212121;">
					<td class="td_cell" style="text-align: center">
						<?php echo $key+1; ?>
					</td>
					<td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word; text-align: center">
						<?php echo !empty($direct->itli_itemcode)?$direct->itli_itemcode:''; ?>
					</td>
					
					<td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word; text-align: center">
						<?php echo !empty($direct->itli_itemname)?$direct->itli_itemname:''; ?>
					</td>
					<td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word; text-align: center">
						<?php echo !empty($direct->balanceqty)?round($direct->balanceqty,2):''; ?>
					</td>
					<td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word; text-align: center">
						 <?php echo !empty($direct->unit_unitname)?$direct->unit_unitname:''; ?>
					</td>
					<td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word; text-align: center">
						<?php 
						if($direct->balanceqty!=0){
						$rate=$direct->balanceamt/$direct->balanceqty;
						echo round($rate,2); } ?>
					</td>
					<td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word; text-align: center">
						<?php 
						$amt=$direct->balanceamt;
						echo round($direct->balanceamt,2); ?>
						
					</td>
					<td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word; text-align: center">
						
					</td>
					<td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word; text-align: center">
						
					</td>
					<td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word; text-align: center">
						
					</td>
					<td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word; text-align: center">
				
					</td>
					<td class="td_cell" style="text-overflow: ellipsis;overflow: hidden; overflow-wrap: break-word; text-align: center">
						
					</td>
					
				</tr>
				<?php
				$sum += $amt;
				   } ?>
				    <tr>
					<td colspan="8"  style="text-align: right;font-size: 12px;">
						<span class=""> जम्मा : </span>
					
						<?php echo !empty($sum)?number_format($sum,2):''; ?>
					</td>
				
				</tr>
		</table>
	</div>
    	 <?php } ?> 

		<table class="table officer_detailTable purchaserecive-table" style="width: 100%;border-left: 1px solid #333;border-right: 1px solid #333;border-bottom: 1px solid #333;border-top: 1px solid #ddd;">
			<tr>
				<th>फांटवालाको दस्तखत </th>
				<th>शाखा प्रमुखको दस्तखत </th>
				<th>जिल्ला निरिक्षक दस्तखत</th>
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
			
        </table>

        <table class="jo_footer" style="width: 100%;border-left: 1px solid #333;border-right: 1px solid #333;border-bottom:  1px solid #333;">
			<tfoot>
			<tr>
				<td>१.</td>
				<td style="padding: 4px;">

					<span class="<?php echo CURDATE_NP;?>"> कार्यालय प्रमुखले सामानको स्पेसीफिकेसन अनुसार सम्बन्धित प्राविधिक समेतलाई समावेश गराई कम्तीमा बर्षको एक पटक जिन्सी निरिक्षण गरी तालुक कार्यालयमा समेत पठाउनु पर्ने छ| </span> 
					
				</td> 
			</tr>
			<tr>
				<td>२.</td>
				<td style="padding: 4px;">
					<span class="<?php echo CURDATE_NP;?>"> यो फारम अनुसार जिन्सी निरिक्षण गरी मर्मत गराउनु पर्ने तथा लिलाम बिक्रि गराउनु कारवाही संचालन गर्नु पर्ने छ| </span> 
					
				</td> 
			</tr>
			<tr>
				<td>३.</td>
				<td style="padding: 4px;">
					<span class="<?php echo CURDATE_NP;?>"> यो फारम सम्बन्धित फांटवाला र निरिक्षकले पेश गर्नु पर्ने छ| </span> 
					
				</td> 
			</tr>
			<tr>
				<td>४.</td>
				<td style="padding: 4px;">
					<span class="<?php echo CURDATE_NP;?>">मिशनको हकमा प्रत्येक डफ्फाको प्रमुखले आफ्नो कार्यालयमा जिन्सी निरिक्षण गराउनु पर्ने छ| </span> 
					
				</td> 
			</tr>
			</tfoot>
		</table>
</div>