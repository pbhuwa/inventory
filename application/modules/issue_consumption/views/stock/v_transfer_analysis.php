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

	<div class="white-box pad-5 mtop_10 pdf-wrapper">
		<div class="jo_form organizationInfo" id="printrpt">
			<div class="pull-right pad-btm-5">
				<a href="javascript:void(0)" class="btn btn_print"><i class="fa fa-print"></i></a>
				<a href="javascript:void(0)" class="btn btn_excel excelcategoriwise"><i class="fa fa-file-excel-o"></i></a>
				<a href="javascript:void(0)" class="btn btn_pdfcategoriwise btn_pdf2" ><i class="fa fa-file-pdf-o"></i></a>
			</div>
			<table width="100%" style="font-size:12px;">
		         <tr>
		          <td></td>
		          <td class="text-center"><h3 style="margin: 0px" class="<?php echo FONT_CLASS; ?>"><b><?php echo ORGNAMETITLE; ?></b></h3></td>
		          <td></td>
		        </tr>
		        <tr>
		          <td></td>
		          <td class="text-center"><h3 style="color:#101010;margin: 0px" class="<?php echo FONT_CLASS; ?>"><B><?php echo ORGNAME; ?></B></h3></td>
		          <td></td>
		        </tr>
		        <tr class="title_sub">
		          <td></td>
		      
		         <td class="text-center"><h4 style="color:black" class="<?php echo FONT_CLASS; ?>"><?php echo ORGNAMEDESC; ?></h4></td>
		          <td style="text-align:right; font-size:10px;"><?php echo $this->lang->line('date_time'); ?>: <?php echo CURDATE_NP ?> BS,</td>
		        </tr>
		        <tr class="title_sub">
		          <td></td>
		         
		         <td class="text-center"><b><font color="black" class="<?php echo FONT_CLASS; ?>"><?php echo LOCATION; ?></font></b></td>
		          <td style="text-align:right; font-size:10px;"><?php echo CURDATE_EN ?> AD </td>
		        </tr>
		        <tr class="title_sub">
		          <td width="200px"></td>
		          <td style="text-align:center;"><b></b></td>
		          <td width="200px" style="text-align:right; font-size:10px;"><?php echo $this->general->get_currenttime(); ?> </td>
		        </tr>
		      </table>
<br><br>
				<table class="table_jo_header purchaseInfo">
					<!-- <tr>
						<td width="25%" rowspan="5"></td>
						<td class="text-center"><h3><?php echo ORGNAME; ?></h3></td>
					</tr>
					<tr>
						<td class="text-center"><h4><?php echo ORGNAMEDESC; ?></h4></td>
					</tr>
					<tr>
						<td class="text-center"><?php echo LOCATION; ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr> -->
					<tr>
						<td class="text-center">
							<h4>
								<u style="color:#333">
									<?php echo $this->lang->line('requisition_analysis'); ?>
								</u>
							</h4>
						</td>
					</tr>
				</table>
				<table class="jo_tbl_head">
					<tr><!-- <td colspan="2"></td> -->

						<td class="text-center"><?php echo $this->lang->line('from_date'); ?>  : <?php echo $fromdate;?> </td>
						<td class="text-center"> <?php echo $this->lang->line('to_date'); ?>  : <?php echo $todate;?> </td>

						<!-- <td width="17%" class="text-right">मिति : <?php echo CURDATE_NP;?></td> -->
					</tr>
					<tr>
						
						
					</tr>
					<tr><td>&nbsp;</td></tr>
				</table>
		        <style>
					.alt_table {  border-collapse:collapse; border:1px solid #000; margin: 0 auto; width:100%; }
					.alt_table.no_border { border-bottom:0; }
					.alt_table thead tr th, .alt_table tbody tr td { border:1px solid #000; padding:2px 5px; font-size:13px; }
					.alt_table tbody tr td { padding:5px; font-size:12px; }
					.alt_table tbody tr.alter td { border:0; text-align:center; }
					.alt_table tbody tr td.noboder { border-right:0; text-align:center; }
					.alt_table tbody tr td.noboder+td{ border-left: 0px; }
					.alt_table.no_border tbody tr td { border:0; }
					.alt_table.no_border tbody tr.bb { border-bottom:1px solid; }


				</style>
				<?php if($req_transfer) { ?>
				<table class="alt_table no_border">
					<tbody>
						
					<?php 
					if(!empty($req_transfer)):
					foreach($req_transfer as $key=>$iue):

						$details = $this->stock_transfer_mdl->req_analysis_transfer_details(array('rd.rede_reqmasterid'=>$iue->rema_reqmasterid));
						//print_r($details);
					?><tr class="bb">
							<td colspan="8"> <b><?php echo $iue->eqty_equipmenttype; ?></b></td>
						</tr>
						<tr >
							<td><?php echo $this->lang->line('manual_no'); ?>: <label ><?php echo $iue->rema_manualno; ?></label></td>
							<td><?php echo $this->lang->line('req_no'); ?>: <label ><?php echo $iue->rema_reqno; ?></label></td>
							<td><?php echo $this->lang->line('requisition_date'); ?> :<label ><?php echo $iue->rema_reqdatebs; ?></label></td>
							<td colspan="8"><?php echo $this->lang->line('department'); ?> :<label ><?php echo $iue->eqty_equipmenttype; ?></label></td>
						</tr>
					</tbody>
				</table>

				<table class="alt_table">
					<thead>
						<tr>
							<th><?php echo $this->lang->line('sn'); ?></th>
							<th><?php echo $this->lang->line('item_code'); ?> </th>
							<th><?php echo $this->lang->line('item_name'); ?></th>
							<th><?php echo $this->lang->line('req_no'); ?></th>
							<th><?php echo $this->lang->line('date_bs'); ?></th>
							<th><?php echo $this->lang->line('request_qty'); ?></th>
							<th><?php echo $this->lang->line('rem_qty'); ?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
						 <?php if($details){
						 	foreach ($details as $key => $value) {  ?>
						 	<td><?php echo $key+1; ?></td>	
						 	<td><?php echo $value->itli_itemcode; ?></td>
						 	<td><?php echo $value->itli_itemname; ?></td>
							<td><?php echo $value->rema_reqno;?></td>
							<td><?php echo $value->rema_reqdatebs;?></td>
							<td><?php echo $value->reqqty;?></td>
							<td><?php echo $value->remqty;?></td>
						 <?php } } ?>
						</tr>

						<?php
						endforeach;
						endif; ?>
						<tr class="alter">
							<td></td>
							<td></td>
							<td></td>
							<td><b>Total</b></td>
							<td><b><?php //echo round($issueqtysum,2);?></b></td>
							<td><b><?php //echo round($returnqtysum,2);?></b></td>
							<td><b><?php //echo round($issuesum,2);?></b></td>
						</tr>
					</tbody>
				</table>

				
				<?php } ?>
				
		    <?php //} ?>
		</div>
	</div>
</div>