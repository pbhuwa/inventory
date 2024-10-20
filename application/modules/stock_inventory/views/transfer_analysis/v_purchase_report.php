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
<div class="clearfix"></div>
<div class="col-sm-12">
	<div class="white-box pad-5 mtop_10 pdf-wrapper">
		<div class="jo_form organizationInfo" id="printrpt">
			<div class="pull-right pad-btm-5">
				<a href="javascript:void(0)" class="btn btn_print"><i class="fa fa-print"></i></a>
				<a href="javascript:void(0)" class="btn btn_excel stockInpurchase"><i class="fa fa-file-excel-o"></i></a>
				<a href="javascript:void(0)" class="btn pdfstock_inpurchase btn_pdf2" ><i class="fa fa-file-pdf-o"></i></a>
			</div>
			<table width="100%" style="font-size:12px;">
		        <tr>
		          <td></td>
		          <td class="web_ttl text-center" style="text-align:center;"><h2><?php echo ORGA_NAME; ?></h2></td>
		          <td></td>
		        </tr>
		        <tr class="title_sub">
		          <td></td>
		          <td style="text-align:center;"><?php echo ORGA_ADDRESS1.','.ORGA_ADDRESS2 ?></td>
		          <td style="text-align:right; font-size:10px;">Date/Time: <?php echo CURDATE_NP ?> BS,</td>
		        </tr>
		        <tr class="title_sub">
		          <td></td>
		          <td style="text-align:center;"><b style="font-size:15px;">
		          	Categorieswise Issue</b></td>
		          <td style="text-align:right; font-size:10px;"><?php echo CURDATE_EN ?> AD </td>
		        </tr>
		        <tr class="title_sub">
		          <td width="200px"></td>
		          <td style="text-align:center;"><b></b></td>
		          <td width="200px" style="text-align:right; font-size:10px;"><?php echo $this->general->get_currenttime(); ?> </td>
		        </tr>
		      </table>

				<table class="table_jo_header purchaseInfo">
					<tr>
						<td width="25%" rowspan="5"></td>
						<td class="text-center"><h3>चिकित्सा विज्ञान राष्ट्रिय प्रतिष्ठान</h3></td>
					</tr>
					<tr>
						<td class="text-center"><h4>राष्ट्रिय ट्रमा सेन्टर</h4></td>
					</tr>
					<tr>
						<td class="text-center">महाबौद्घ , काठमाडौँ</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td class="text-center">
							<h4>
								<u>
									Receive Summary
									<?php 
									if(!empty($equipmenttype[0]->eqty_equipmenttype))
									{
										echo $equipmenttype[0]->eqty_equipmenttype;
									}else{
										echo "| General Store |  Medical Store";
									}
									?>
								</u>
							</h4>
						</td>
					</tr>
				</table>
				<table class="jo_tbl_head">
					<tr><td colspan="2">

						<td colspan="2"> 
							From Date : <?php echo $fromdate;?> 
							To Date : <?php echo $todate;?> 
						</td>

						<td width="17%" class="text-right">मिति : <?php echo CURDATE_NP;?></td>
					</tr>
					<tr>
						
						
					</tr>
					<tr><td>&nbsp;</td></tr>
				</table>
		        <style>
					.alt_table {  border-collapse:collapse; border:1px solid #000; margin: 0 auto;}
					.alt_table thead tr th, .alt_table tbody tr td { border:1px solid #000; padding:2px 5px; font-size:13px; }
					.alt_table tbody tr td { padding:5px; font-size:12px; }
					.alt_table tbody tr.alter td { border:0; text-align:center; }
					.alt_table tbody tr td.noboder { border-right:0; text-align:center; }
					.alt_table tbody tr td.noboder+td{ border-left: 0px; }


				</style>
				<table class="alt_table">
					<thead>
						<tr>
							<th>sno</th>
							<th>Counter Code</th>
							<th>Counter Name</th>
							<th>Receive Amount</th>
						</tr>
					</thead>
					<tbody>
					<?php
					if(!empty($purchase)):
					$totalstockvalue = 0;
					foreach($purchase as $key=>$iue):
					?>
			<!-- [eqty_equipmenttype] => General Store
            [itli_itemname] => ARTERY FORCEP(CURVED)
            [stock] => 496.00
            [stockvalue] => 509630.00 -->
						<tr>
							<td><?php echo $key+1; ?></td>
							<td><?php echo $iue->eqty_equipmenttype; ?></td>
							<td><?php echo $iue->eqty_equipmenttype; ?></td>
							<td><?php echo round($iue->stockvalue,2);?></td>
							<?php
							$totalstockvalue += $iue->stockvalue;
							 ?>
						</tr>
						
					<?php
						endforeach;
						endif;
					?>
						<tr class="alter">
							<td></td>
							<td></td>
							<td><b>Total : </b></td>
							<td><b><?php echo round($totalstockvalue,2);?></b></td>
						</tr>
					</tbody>
				</table>
		    <?php //} ?>
		</div>
	</div>
</div>