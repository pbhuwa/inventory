
<h5 class="ov_lst_ttl"><b>Transfer Detail</b></h5>

<div class="table-wrapper" id="tblwrapper">

<table class="table format_pdf">

	<thead>
	<tr style="
    border: 1px solid black;
">
	<th>S.n</th>

	<th>Transfer Date(AD)</th>

	<th>Transfer Date(BS)</th>

	<th>Assets Code</th>

	<th>Assets Description</th>

	<th>From Department </th>

	<th>To  Department </th>

	<th>Previous Receiver</th>

	<th>Current Receiver</th>

	<th>Remarks</th>	
	</tr>
	</thead>

	

	<tbody>

		<?php

	if(!empty($assets_transfer_data_rec)):

		foreach ($assets_transfer_data_rec as $kat => $atran):
			$trantype=$atran->astm_transfertypeid;



	 ?>

	 <tr>

	 <td><?php echo $kat+1; ?></td>

	 <td><?php echo $atran->astm_transferdatebs ?></td>

	 <td><?php echo $atran->astm_transferdatead ?></td>

	 <td><?php echo $atran->asen_assetcode ?></td>

	 <td><?php echo $atran->asen_desc ?></td>

	<?php
	$fromschool = $atran->fromschoolname;
	$fromdepparent = $atran->fromdepparent;
	$fromdep = $atran->fromdep;
	if (!empty($fromdepparent)) {
		$from_departmentname = $fromdepparent . '/' . $fromdep;
	} else {
		$from_departmentname = $fromdep;
	}
	$from = $fromschool . '-' . $from_departmentname;

	$toschoolname = $atran->toschoolname;
	$todep = $atran->todep;
	$todepparent = $atran->todepparent;
	if (!empty($todepparent)) {
		$to_departmentname = $todepparent . '/' . $todep;
	} else {
		$to_departmentname = $todep;
	}

	$to= $toschoolname . '-' . $to_departmentname;
	$received_by = $atran->astm_receivedby;
	?>
	<td><?php echo $from; ?></td>
	<td><?php echo $to; ?></td>
	<td> <?php echo $atran->astd_prev_staffname; ?></td>
	<td><?php echo $atran->stin_fname.' '.$atran->stin_mname.' '.$atran->stin_lname; ?></td>

	

	 <td><?php echo $atran->astd_remark ?></td>

	</tr>

	<?php endforeach; endif; ?>

	</tbody>



</table>

</div>