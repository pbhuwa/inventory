<table class="table flatTable tcTable">

<thead>
	<tr>
	
	<th width="20%"><?php echo $this->lang->line('assets_code'); ?></th>
	<th width="25%"><?php echo $this->lang->line('description'); ?></th>	
	<th width="25%"><?php echo $this->lang->line('serial_no'); ?></th>
	<th width="25%"><?php echo $this->lang->line('model_no'); ?></th>
	<th width="25%"><?php echo $this->lang->line('purchase_date'); ?></th>
	<th width="25%"><?php echo $this->lang->line('brand'); ?></th>

	</tr>
</thead>
	<tbody>
		<?php if($equipment_inv_list):
		 $i=1;
                foreach ($equipment_inv_list as $kb => $bil):
		?>
		<tr class="trSelectData" data-id="<?php echo $bil->asen_assetcode ?>" data-name="<?php echo $bil->asen_assetcode ?>" style="cursor:pointer;" >
			<td><?php echo $bil->asen_assetcode ?></td>
			    <td><?php echo $bil->asen_description ?></td>
			    <td><?php echo $bil->asen_serialno ?></td>
			    <td><?php echo $bil->asen_modelno ?></td>    
			    <td><?php echo $bil->asen_purchasedatebs ?></td>
			    <td><?php echo $bil->asen_brand ?></td>
			    
		</tr>
		<?php
	endforeach;
		
		else:
			echo '<tr><td colspan="4"><span class="text-danger">No Record match</a><td></tr>';
		endif;
		 ?>
	</tbody>
</table>

             