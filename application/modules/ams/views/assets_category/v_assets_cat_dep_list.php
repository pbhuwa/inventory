	  			
<table class="table table-striped dataTable" id="Dtable" width="100%">
	<thead>
		<tr>
			<th width="5%">S.n</th>
			<th width="20%">Code</th>
			<th width="25%">Category</th>
			<th width="20%">Deprication (%)</th>
		</tr>
	</thead>
	<tbody>	
		<?php if(!empty($category_type)): 
			$i=1;
			foreach($category_type as $ctype):
		?>
		<tr>
			<input type="hidden" name="eqca_equipmentcategoryid[]" value="<?php echo $ctype->eqca_equipmentcategoryid; ?>">
			<td><?php echo $i ?>.</td>
			<td><?php echo $ctype->eqca_code ?></td>
			<td><?php echo $ctype->eqca_category ?></td>
			<td><input type="text" class="form-control float" name="eqca_deprate[]" value="<?php echo $ctype->eqca_deprate; ?>"></td>
		</tr>
		<?php
		$i++;
		endforeach;
		 endif; ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="4"><button  type="submit" class="btn btn-info pull-right  save" data-operation="update" id="btnSubmit" data-isdismiss="Y">Update</button></td>
		</tr>
		<tr>
			<td colspan="4">
                <div class="alert-success success"></div>
                <div class="alert-danger error"></div>
		 </td>
		</tr>
	</tfoot>
		
</table>