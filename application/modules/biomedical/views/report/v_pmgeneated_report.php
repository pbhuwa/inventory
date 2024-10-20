<style>
	.ov_report_dtl .ov_lst_ttl { font-size:12px; margin-bottom: 5px; padding-bottom: 5px; border-bottom: 1px solid #efefef; }
	.ov_report_dtl .pm_data_tbl { width:100%; margin-bottom:10px; }
	.ov_report_dtl .pm_data_tbl td, .ov_report_dtl .pm_data_tbl td b { font-size:12px; }
	.ov_report_dtl .count { background-color:#e3e3e3; font-size:12px; padding:2px 5px; }
	
	.ov_report_tbl { border-left:1px solid #e3e3e3; border-top:1px solid #e3e3e3; border-collapse:collapse; margin-bottom:10px; }
	.ov_report_tbl thead th { text-align:left; background-color:#e3e3e3; padding:2px; font-size:12px; }
	.ov_report_tbl tbody td { font-size:12px; border-right:1px solid #e3e3e3; border-bottom:1px solid #e3e3e3; line-height:13px; padding:2px; }
</style>

<div id="printrpt" class="pad-5">
	<div class="pull-right pad-btm-5 no-pos">
		<a href="javascript:void(0)" class="btn btn_print"><i class="fa fa-print"></i></a>
		<a href="javascript:void(0)" class="btn btn_excel"><i class="fa fa-file-excel-o"></i></a>
		<a href="javascript:void(0)" class="btn btn_pdf" ><i class="fa fa-file-pdf-o"></i></a>
	</div>
	<div class="clearfix"></div>
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
              <td style="text-align:center;"><b style="font-size:15px;">PM Report</b></td>
              <td style="text-align:right; font-size:10px;"><?php echo CURDATE_EN ?> AD </td>
            </tr>
            <tr class="title_sub">
              <td width="200px"></td>
              <td style="text-align:center;"><b></b></td>
              <td width="200px" style="text-align:right; font-size:10px;"><?php echo $this->general->get_currenttime(); ?> </td>
            </tr>
          </table>
		<table class="ov_report_tbl" width="100%">
			<thead>
				<tr>
					<th width="10%">Equip.ID</th>
					<th width="15%">PM Date (BS)</th>
					<th width="15%">PM Date (AD)</th>
					<th width="20%">PM Remarks</th>
					<th width="10%">Risk</th>
					<th width="20%">Department</th>
					<th width="15%">Status</th>
					
				</tr>
			</thead>
			<tbody>
				<?php
				if(!empty($pm_report)){
				foreach($pm_report as $val){?>
				<tr>
					<td><?php echo $val->bmin_equipmentkey;?></td>
					<td><?php echo $val->pmta_pmdatebs;?></td>
					<td><?php echo $val->pmta_pmdatead;?></td>
					<td><?php echo $val->pmta_remarks;?></td>
					<td><?php echo $val->riva_risk;?></td>
					<td><?php echo $val->dept_depname;?></td>
					<td><?php if($val->pmta_ispmcompleted == 0){echo"Not Completed";}else{ echo"Completed";}?></td>
					
				</tr>
				<?php } } ?>
			</tbody>
		</table>
</div>
		