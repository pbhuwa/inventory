

<h5 class="ov_lst_ttl"><b>Transfer Detail</b></h5>

<div class="table-wrapper" id="tblwrapper">

<table class="table  format_pdf">

	<thead>

	<th>S.n</th>

	<th>Transfer Date(AD)</th>

	<th>Transfer Date(BS)</th>

	<th>Transfer Type</th>

	<th>Assets Code</th>

	<th>Assets Description</th>

	<th>From</th>

	<th>To </th>

	<th>Original Cost</th>

	<th>Current Cost</th>

	<th>Remarks</th>	

	</thead>

	

	<tbody>

		<?php

	if(!empty($assets_transfer_data_rec)):

		foreach ($assets_transfer_data_rec as $kat => $atran):

			$trantype=$atran->astm_transfertypeid;

		$transfertype='';

		$from='';

		$to='';



		if($trantype=='D'){

			$transfertype='Department';

			$from=$atran->fromdep;

			$to=$atran->todep;

		}

		if($trantype=='B'){

			$transfertype='Branch';

			$from=$atran->fromlocation;

			$to=$atran->tolocation;

		}

	 ?>

	 <tr>

	 <td><?php echo $kat+1; ?></td>

	 <td><?php echo $atran->astm_transferdatebs ?></td>

	 <td><?php echo $atran->astm_transferdatead ?></td>

	 <td><?php echo $transfertype ?></td>

	 <td><?php echo $atran->asen_assetcode ?></td>

	 <td><?php echo $atran->asen_desc ?></td>

	 <td><?php echo $from; ?></td>

	 <td><?php echo $to; ?></td>

	 <td><?php echo $atran->astd_originalamt ?></td>

	 <td><?php echo $atran->astd_currentamt ?></td>

	 <td><?php echo $atran->astd_remark ?></td>

	</tr>

	<?php endforeach; endif; ?>

	</tbody>



</table>

</div>