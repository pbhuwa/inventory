<table class="table flatTable tcTable">
    <thead>
    	<tr>
		<th width="10%"><strong>Date(AD)</strong></th>
		<th width="10%"><strong>Date(BS)</strong></th>
		<th width="10%"><strong>Date(BS)</strong></th>
		<th width="30%"><strong>Comment</strong></th>
		<th width="10%"><strong>Status</strong></th>
		<th width="15%"><strong>Dept.App</strong></th>
		<th width="15%"><strong>Head.App</strong></th>
		
	</tr>
    </thead>
    <tbody>
    	<?php
	if(!empty($equip_comment)):
		foreach($equip_comment as $comment):
			$status = ($comment->eqco_comment_status == 1)?"Viewed":"Not Viewed";
			$depapproved = ($comment->eqco_isdepapproved == 1)?"Yes":"No";
			$headapproved = ($comment->eqco_isdepheadapproved == 1)?"Yes":"No";
			echo '<tr>';
			echo '<td>'.$comment->eqco_postdatead.'</td>';
			echo '<td>'.$comment->eqco_postdatebs.'</td>';
			echo '<td>'.$comment->eqco_posttime.'</td>';
			echo '<td>'.$comment->eqco_comment.'</td>';
			echo '<td>'.$status.'</td>';
			echo '<td>'.$depapproved.'</td>';
			echo '<td>'.$headapproved.'</td>';
			echo '</tr>';
		endforeach;
	endif;
?>
    </tbody>


</table>
