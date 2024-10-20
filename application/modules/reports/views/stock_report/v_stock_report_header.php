<style>
.table_jo_header,
.jo_tbl_head,
.jo_table,
.jo_footer {
	width: 100%;
	font-size: 12px;
	border-collapse: collapse;
}

.table_jo_header {
	width: 100%;
	vertical-align: top;
	font-size: 12px;
}

.table_jo_header td.text-center {
	text-align: center;
}

.table_jo_header td.text-right {
	text-align: right;
}

h4 {
	font-size: 18px;
	margin: 0;
}

.table_jo_header u {
	text-decoration: underline;
	padding-top: 15px;
}

.jo_table {
	border-right: 1px solid #333;
	margin-top: 5px;
}

.jo_table tr th {
	border-top: 1px solid #333;
	border-bottom: 1px solid #333;
	border-left: 1px solid #333;
}

.jo_table tr th {
	padding: 5px 3px;
}

.jo_table tr td {
	padding: 3px 3px;
	height: 15px;
	border-left: 1px solid #333;
}

.jo_footer {
	border: 1px solid #333;
	vertical-align: top;
}

.jo_footer td {
	padding: 8px 8px;
}

.preeti {

	font-family: preeti;

}

tr.title_sub img {

	margin-top: -0px;

}

.alt_table {
	border-collapse: collapse;
	border: 1px solid #000;
	margin: 0 auto;
	width: 100%;
}

.alt_table thead tr th,
.alt_table tbody tr td {
	border: 1px solid #000;
	padding: 2px 5px;
	font-size: 12px;
}

.alt_table thead tr th {
	font-weight: bold;
}

.alt_table tbody tr td {
	font-size: 13px;
	letter-spacing: 0.5px;
	font-weight: 400;
}

.alt_table tbody tr td.header {
	padding: 5px;
	font-size: 12px;
	font-weight: bold;
}

.alt_table tbody tr.alter td {
	border: 0;
	text-align: center;
}

.alt_table tbody tr td.noboder {
	border-right: 0;
	text-align: center;
}

.alt_table tbody tr td.noboder+td {
	border-left: 0px;
}

.alt_table table.noborder {
	border: 0px;
}

.alt_table tr.noborder {
	border: 0px;
}

.alt_table td.noborder {
	border: 0px;
}

.alt_table tr.borderBottom {
	border-bottom: none;
}

.alt_table tr.header td {
	font-weight: bold;
}

.table>tbody+tbody {

	border-top: 1px solid #ddd;

}

table.organizationInfo {

	margin: 0px;

	/*margin-top: -50px;*/

	padding: 0px;

}

.header-content {

	margin-top: 13px;

	font-size: 12px;

}

/*used in purchase reports */

.format_pdf {
	border: 1px solid #000;
	border-collapse: initial;
}

.format_pdf thead tr th,
.format_pdf tbody tr td {
	font-size: 13px;
	border: 1px solid #000;
	padding: 2px 4px;
}

.format_pdf tbody tr td {
	font-size: 12px;
	padding: 4px;
}

.format_sub_tbl_pdf {
	width: 80%;
	border-collapse: collapse;
	border-color: #ccc;
}

.format_sub_pdf,
.format_sub_tbl_pdf thead tr th,
.format_sub_tbl_pdf tbody tr td {
	background-color: #fff;
}

.format_sub_pdf {
	background-color: #f0f0f0;
	clear: both;
}
</style>

<?php if (!empty($pdf_url) || !empty($excel_url)) : ?>

<div class="pull-right pad-btm-5 reportGeneration">

	<a href="javascript:void(0)" class="btn btn_print"><i class="fa fa-print"></i></a> 

	<a href="javascript:void(0)" class="btn btn_excel btn_gen_report" data-exporturl="<?php echo !empty($excel_url) ? $excel_url : ''; ?>" data-exporttype="excel" data-targetformid="<?php echo $target_formid ?? ''; ?>"><i class="fa fa-file-excel-o"></i></a>

	<a href="javascript:void(0)" class="btn btn_pdf2 btn_gen_report" data-exporturl="<?php echo !empty($excel_url) ? $excel_url : ''; ?>" data-exporttype="word" data-targetformid="<?php echo $target_formid ?? ''; ?>"><i class="fa fa-file-word-o"></i></a>

	<a href="javascript:void(0)" class="btn btn_pdf2 btn_gen_report" data-exporturl="<?php echo !empty($pdf_url) ? $pdf_url : ''; ?>" data-exporttype="pdf" data-targetformid="<?php echo $target_formid ?? ''; ?>"><i class="fa fa-file-pdf-o"></i></a>

</div>

<?php endif; ?>

<div class="table-wrapper" id="tblwrapper">

	<table class="organizationInfo" width="100%" style="font-size:12px; margin-bottom: 5px;">

		<tr class="title_sub">

			<td width="33.33%" style="">

				<a href="javascript:void(0)"> <img src="<?php echo base_url('assets/template/images') . '/' . ORGA_IMAGE; ?>" style="width: 100px;"></a>

			</td>

			<td width="33.33%" style="text-align: center;    padding: 16px 0 0 0;    font-weight: 900;">

				<strong style="font-weight: bold !important;">
					<h4 style="font-weight: 900;color:#101010;margin-bottom: 0px;font-size: 14px;font-weight: bold !important;">

						<span class="" style="font-weight: 900;"><?php echo ORGNAME; ?></span>

					</h4>

				</strong>

				<font color="black"><span style="font-size: 12px; " class=""><?php echo ORGNAMETITLE; ?></span></font>

				<div class="header-content">
					 
					<strong>
					 कार्यालय काेड नं:	
					</strong>
					<br>

					<?php if (!empty($fromdate)) : ?>

						<strong style=""><?php echo $this->lang->line('from_date'); ?> :</strong> <?php echo !empty($fromdate) ? $fromdate : ''; ?>

					<?php endif; ?>

					<?php if (!empty($todate)) : ?>

						<strong><?php echo $this->lang->line('to_date'); ?> :</strong> <?php echo !empty($todate) ? $todate : ''; ?>

					<?php endif; ?>

					<?php

					if (!empty($fiscalyrs)) :

						?>
						<br>
						<strong>

							आर्थिक वर्ष <?php echo $fiscalyrs; ?>

						</strong>

						<?php

					endif;

					?>

				</div>

				<h4 style="margin: 0px; margin-top:4.5px;padding: 0px;font-size: 15px;line-height: 14px;padding-bottom: 9px !important;">

					<u>

						<?php echo !empty($report_title) ? $report_title : ''; ?>

					</u>

				</h4>

			</td>

			<td width="33.33%" style="text-align:right; font-size:12px;position: relative;top: -31px;padding: 0 0 0 28px;">
				<span>

					<?php echo !empty($report_no)?$report_no:'';?><br/>

					<?php echo !empty($old_report_no)?$old_report_no:'';?>

				</span>
			</td>

		</tr>

		<tr class="title_sub">

			<td colspan="5" style="text-align: center;" align="center">

			</td>

		</tr>

	</table>

	<table class="table_jo_header purchaseInfo">

		<tr>

			<td class="text-center" align="center">

			</td>

		</tr>

	</table>