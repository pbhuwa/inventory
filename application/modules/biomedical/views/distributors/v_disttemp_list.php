<table class="table flatTable tcTable">

<thead>
	<tr>
	
	<th width="20%">Supplier Name</th>
	</tr>
</thead>
	<tbody>
		<?php if($supplier_list):
		 $i=1;
                foreach ($supplier_list as $kb => $sup):
		?>
		<tr class="trSelectData" data-id="<?php echo $sup->dist_distributorid ?>" data-name="<?php echo $sup->dist_distributor ?>" style="cursor:pointer;" >
			    <td><?php echo $sup->dist_distributor ?></td>
			    
		</tr>
		<?php
	endforeach;
		
		else:
			echo '<tr><td colspan="4"><span class="text-danger">No Record match</a><td></tr>';
		endif;
		 ?>
	</tbody>
</table>

             