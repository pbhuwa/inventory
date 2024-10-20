<br/><br/>
<div class='col-md-12 table-responsive'>
	<table class='table table-striped dt_alt dataTable Dtable'>
		<thead>
			<tr>
				<th><input type='checkbox' id='checkall'/></th>
				<th><strong>Equipment Key</strong></th>
				<th><strong>Description</strong></th>
				<th><strong>Model No.</strong></th>
				<th><strong>Serial No.</strong></th>
			</tr>
		</thead>
		<tbody>
		<?php
			if(!empty($equipmentkeylist)):
			foreach($equipmentkeylist as $eq):
	 	?>
	 		<tr>
	 			<td>
	 				<input type='checkbox' id='equipid_$eq->bmin_equipmentkey' data-key=".$eq->bmin_equipmentkey." /></td>
	 			<td><?php $eq->bmin_equipmentkey; ?></td>
	 			<td><?php $eq->eqli_description; ?></td>
	 			<td><?php $eq->bmin_modelno; ?></td>
	 			<td><?php $eq->bmin_serialno; ?></td>
	 		</tr>
		<?php
			endforeach;
			endif;
		?>
		</tbody>
	</table>
	</div>

<script>
	$('.Dtable').dataTable({
        "scrollCollapse": true,
        "autoWidth": false,
        "aoColumnDefs": [{ 
        'bSortable': false, 'aTargets': [ "_all" ]
        }]
    });
</script>