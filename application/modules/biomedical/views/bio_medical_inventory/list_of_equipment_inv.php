<table class="table flatTable tcTable">

<thead>
	<tr>
	
	<th width="20%">Equip.ID</th>
	<th width="25%">Description</th>
	<th width="25%">Dept.</th>
	 <th width="30%">Risk </th>
	</tr>
</thead>
	<tbody>
		<?php if($equipment_inv_list):
		 $i=1;
                foreach ($equipment_inv_list as $kb => $bil):
		?>
		<tr class="trSelectData" data-id="<?php echo $bil->bmin_equipmentkey ?>" data-name="<?php echo $bil->bmin_equipmentkey ?>" style="cursor:pointer;" >
			<td><?php echo $bil->bmin_equipmentkey ?></td>
			    <td><?php echo $bil->eqli_description ?></td>
			    <td><?php echo $bil->dein_department ?></td>
			     <td><?php echo $bil->riva_risk ?></td>
		</tr>
		<?php
	endforeach;
		
		else:
			echo '<tr><td colspan="4"><span class="text-danger">No Record match</a><td></tr>';
		endif;
		 ?>
	</tbody>
</table>

             