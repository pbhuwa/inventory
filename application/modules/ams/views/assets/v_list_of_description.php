<table class="table flatTable tcTable">

<thead>
	<tr>
	<th>Assets Descriptions ALL</th>
	</tr>
</thead>
	<tbody>
		<?php if($desc_list):
		 $i=1;
                foreach ($desc_list as $kb => $desc):
		?>
		<tr class="trSelectData" data-id="<?php echo $desc->asen_asenid ?>" data-name="<?php echo $desc->asen_description ?>" style="cursor:pointer;" >
			    <td><?php echo $desc->asen_description ?></td>
			    
		</tr>
		<?php
	endforeach;
		
		else:
			echo '<tr><td><span class="text-danger">No Record match</span><td></tr>';
		endif;
		 ?>
	</tbody>
</table>

             