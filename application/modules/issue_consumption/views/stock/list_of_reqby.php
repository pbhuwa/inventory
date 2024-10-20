<table class="table flatTable tcTable">

<thead>
	<tr>
	
	<th width="20%">Req Name</th>
	</tr>
</thead>
	<tbody>
		<?php if($reqby_list):
		 $i=1;
                foreach ($reqby_list as $kb => $bil):
		?>
		<tr class="trSelectData" data-id="<?php echo $bil->rema_reqmasterid ?>" data-name="<?php echo $bil->rema_reqby ?>" style="cursor:pointer;" >
			    <td><?php echo $bil->rema_reqby ?></td>
			    
		</tr>
		<?php
	endforeach;
		
		else:
			echo '<tr><td colspan="4"><span class="text-danger">No Record match</a><td></tr>';
		endif;
		 ?>
	</tbody>
</table>

             