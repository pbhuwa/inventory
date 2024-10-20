<table class="table flatTable tcTable">

<thead>
	<tr>
	<th width="20%">Acc. Code</th>
	<th width="25%">Acc. Name</th>

	</tr>
</thead>
	<tbody>
		<?php if($account_code_list):
		 $i=1;
                foreach ($account_code_list as $kb => $acl):
		?>
		<tr class="trSelectData" data-id="<?php echo $acl->acty_accode ?>" data-name="<?php echo $acl->acty_accode ?>" style="cursor:pointer;" >
			<td><?php echo $acl->acty_accode ?></td>
			    <td><?php echo $acl->acty_acname ?></td>
		</tr>
		<?php
	endforeach;
		
		else:
			echo '<tr><td colspan="4"><span class="text-danger">No Record match</a><td></tr>';
		endif;
		 ?>
	</tbody>
</table>

             