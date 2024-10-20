<style>	
	.table_jo_header, .jo_tbl_head, .jo_table, .jo_footer, .info_block { width:100%; font-size:12px; border-collapse:collapse; }
	.table_jo_header { width:100%; vertical-align: top; font-size:12px; }
	.table_jo_header td.text-center { text-align:center; }
	.table_jo_header td.text-right { text-align:right; }
	h4 { font-size:18px; margin:0; }
	.table_jo_header u { text-decoration:underline; padding-top:15px; }

	.jo_table { border-right:1px solid #333; margin-top:5px; }
	.jo_table tr th { border-top:1px solid #333; border-bottom:1px solid #333; border-left:1px solid #333; }

	.jo_table tr th { padding:5px 3px;}
	.jo_table tr td { padding:3px 3px; height:15px; border-left:1px solid #333; }
	
	.jo_footer, .info_block { border:1px solid #333; vertical-align: top; }
	.jo_footer td { padding:8px 8px;	}
	.jo_table.itemInfo { border-bottom:1px solid #000; }
	.info_block tr td { padding:2px; }
</style>
<div class="jo_form organizationInfo">
		<table class="table_jo_header purchaseInfo" style="text-align:center; font-size:12px; width:100%;">
			<tr>
				<td width="25%" rowspan="5"></td>
				<td class="text-center"><h3 style="margin:0; margin-top:10px;"><?php echo ORGA_NAME;?></h3></td>
				<td width="25%" rowspan="5" class="text-right"></td>
			</tr>
			<tr>
				<td class="text-center"><h4 style="margin:0;"><?php echo ORGA_SOFTWARENAME;?></h4></td>
			</tr>
			<tr>
				<td class="text-center"><?php echo ORGA_ADDRESS2;?> <?php echo ORGA_PHONE;?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class="text-center"><h4 style="margin:0;"><u>Requisition Form</u></h4></td>
			</tr>
		</table>

		<table class="jo_tbl_head" style="font-size:12px; width:100%;">
			<tr>
				<td></td>
				<td width="17%" class="text-right" style="text-align:right;"><b>Date :</b> <?php echo CURDATE_NP;?></td>
			</tr>
		</table>

		<table class="info_block" style="font-size:12px; border:1px solid #777; width:100%; margin-bottom:5px;">
			<tr>
				<td>
					<label ><b>Req No:</b> <?php echo !empty($report_data['rema_reqno'])?$report_data['rema_reqno']:''; ?></label> 			
				</td>
				<td>
					<label ><b>Manual No:</b> <?php echo !empty($report_data['rema_manualno'])?$report_data['rema_manualno']:''; ?></label> 
				</td>
				<td>
					<label ><b>Req Date:</b> <?php echo !empty($report_data['rema_reqdate'])?$report_data['rema_reqdate']:''; ?></label>
				</td>
			</tr>
			<tr>
				<?php if($report_data['rema_isdep'] == 'Y'){ ?>
				<td>
					<label><b>From Department:</b> <?php echo $from[0]->dept_depname; ?></label>
				</td>
				<?php } ?>
				<?php if($report_data['rema_isdep'] == 'N'){ ?>
				<td>
					<label><b>From:</b> <?php echo $from[0]->eqty_equipmenttype; ?></label>
				</td>
				<?php } ?>
				<td>
					<label><b>To:</b> <?php echo  $tostore[0]->eqty_equipmenttype; ?></label>
				</td>
				<td></td>
			</tr>
		</table>

		<table  class="jo_table itemInfo" style="width:100%; border: 1px solid #777; border-collapse:collapse;">
			<thead>
				<tr>
					<!-- <th width="5%">SN सि .</th>
					<th width="10%"> मलसामानको विवरण </th>
					<th width="30%"> स्पेसिफिकेशन (आवश्यक पर्नेमा) </th>
					<th width="10%"> एकाइ </th>
					<th width="10%"> सामानको परिमाण </th>
					<th width="25%"> कैफियत </th> -->
					<th style="padding:3px; border:1px solid #777;" width="5%">SN </th>
					<th style="padding:3px; border:1px solid #777;" width="10%">Item Name </th>
					<th style="padding:3px; border:1px solid #777;" width="30%">Req Qty </th>
					<th style="padding:3px; border:1px solid #777;" width="10%">Unit </th>
					<th style="padding:3px; border:1px solid #777;" width="10%">Qty </th>
					<th style="padding:3px; border:1px solid #777;" width="25%"> Remarks </th>
				</tr>
			</thead>
			<tbody>
				<?php
				$itemid = !empty($report_data['rede_itemsid'])?$report_data['rede_itemsid']:'';
				if(!empty($itemid)): // echo"<pre>";print_r($itemid);die;
				foreach($itemid as $key=>$products):
			?>
			<tr>
				<td style="padding:3px; border-right:1px solid #777;">
					<?php echo $key+1; ?>
				</td>
				<td style="padding:3px; border-right:1px solid #777;">
					<?php echo !empty($report_data['rede_code'][$key])?$report_data['rede_code'][$key]:''; ?>
				</td>
				<td style="padding:3px; border-right:1px solid #777;">
					<?php 
						$itemid = !empty($report_data['rede_itemsid'][$key])?$report_data['rede_itemsid'][$key]:'';
						$itemname =  $this->general->get_tbl_data('*','itli_itemslist',array('itli_itemlistid'=>$itemid),false,'DESC');
						echo !empty($itemname[0]->itli_itemname)?$itemname[0]->itli_itemname:'';
					?>
				</td>
				<td style="padding:3px; border-right:1px solid #777;">
					<?php 
						$unitid = !empty($report_data['rede_unit'][$key])?$report_data['rede_unit'][$key]:'';
						$unitname =  $this->general->get_tbl_data('*','unit_unit',array('unit_unitid'=>$unitid),false,'DESC');
						echo !empty($unitname[0]->unit_unitname)?$unitname[0]->unit_unitname:'';
					?>
					<!-- <?php echo !empty($report_data['rede_unit'][$key])?$report_data['rede_unit'][$key]:''; ?> -->
				</td>
				<td style="padding:3px; border-right:1px solid #777;">
					<?php echo !empty($report_data['rede_qty'][$key])?$report_data['rede_qty'][$key]:''; ?>
				</td>
				<td style="padding:3px; border-right:1px solid #777;">
					<?php echo !empty($report_data['rede_remarks'][$key])?$report_data['rede_remarks'][$key]:''; ?>
				</td>
			</tr>
			<?php
				endforeach;
				endif;
			?>
			</tbody>
		</table>
		<br>
<?php $reqno =$report_data['rema_reqno']; ?>
		<a href="https://xelwel.com.np/biomedical/issue_consumption/stock_requisition/verification_requisition/1/<?php echo $reqno?>"><u><i>Click Here To Approve Requisition</i></u></a><br><br>
		<a href="https://xelwel.com.np/biomedical/issue_consumption/stock_requisition/verification_requisition/2/<?php echo $reqno?>"><u><i>Click Here To UnApprove Requisition</i></u></a>
</div>