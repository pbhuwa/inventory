<style>
	.info_table { width:100%; border:1px dotted #000; font-size:12px; margin-top:30px; }
	.info_table tr td { padding:2px 4px; }
	.info_table tr td label {  padding-right:5px; }
	.info_table tr td b { padding-left:15px; float:left; }

	.result_table { font-size:12px; border-collapse: collapse;}
	.result_table thead th { padding:15px 2px; border-top:1px solid #000; border-bottom:1px solid #000; text-align:left; }
	.result_table tbody td { padding:4px 2px; }
	h5 { padding-bottom:0 }

	.signature { margin-top:60px; width:100%; font-size:12px; }
	.text-right { text-align:right; }

</style>

<table class="result_table" width="100%">
	<thead>
		<tr>
			<th><b>Department</b></th>
			<th><b>Description</b></th>
			<th><b>ID</b></th>
			<th><b>Jan</b></th>
			<th><b>Feb</b></th>
			<th><b>Mar</b></th>
			<th><b>Apr</b></th>
			<th><b>May</b></th>
			<th><b>Jun</b></th>
			<th><b>july</b></th>
			<th><b>Aug</b></th>
			<th><b>Sep</b></th>
			<th><b>Oct</b></th>
			<th><b>Nov</b></th>
			<th><b>Dec</b></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($pmReportByDepartment as $key => $value) { ?>
			<tr>
				<td><?php echo $value->dein_department ?></td>
				<td><?php echo $value->pmta_comment ?></td>
				<td><?php echo $value->pmta_equipid?></td>
				<td><?php echo $value->pmta_jan ?></td>
				<td><?php echo $value->pmta_feb ?></td>
				<td><?php echo $value->pmta_mar ?></td>
				<td><?php echo $value->pmta_apr ?></td>
				<td><?php echo $value->pmta_may ?></td>
				<td><?php echo $value->pmta_jun ?></td>
				<td><?php echo $value->pmta_jul ?></td>
				<td><?php echo $value->pmta_aug ?></td>
				<td><?php echo $value->pmta_sep ?></td>
				<td><?php echo $value->pmta_oct ?></td>
				<td><?php echo $value->pmta_nov ?></td>
				<td><?php echo $value->pmta_dec ?></td>
				
			</tr>
		<?php } ?>
	</tbody>
</table>

<table class="signature">
	<tr>
		<td width="50%">_______________________</td>
		<td width="50%" class="text-right">_______________________</td>
	</tr>
	<tr>
		<td>Performed By</td>
		<td class="text-right">Checked By</td>
	</tr>
</table>
