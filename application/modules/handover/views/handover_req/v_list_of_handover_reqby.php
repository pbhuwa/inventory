<table class="table flatTable tcTable">

<thead>
	<tr>
	
	<th width="20%" >Hadover Req. Name</th>
	</tr>
</thead>
	<tbody>
		<?php if($reqby_list):
		 $i=1;
                foreach ($reqby_list as $kb => $bil):
		?>
		<tr class="trSelectData" data-id="<?php echo $bil->harm_handovermasterid ?>" data-name="<?php echo $bil->harm_requestedby ?>" style="cursor:pointer;" >
			    <td><?php echo $bil->harm_requestedby ?></td>
			    
		</tr>
		<?php
	endforeach;
		
		else:
			echo '<tr><td colspan="4"><span class="text-danger">No Record match</a><td></tr>';
		endif;
		 ?>
	</tbody>
</table>

             