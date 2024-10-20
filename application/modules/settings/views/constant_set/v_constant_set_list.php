
<table style="border-collapse: collapse;" class="table table-striped dataTable" id="Dtable">
	<thead>

	<?php
		if($category):
			foreach ($category as $km => $cat):
	?>
	<tr  style="color: #4cc2fb background: #96ccb98a;">
		<h3 style="text-decoration-style: yellow;"><th colspan="4" bgcolor="#c1dcc8" ><?php echo $cat->cons_category; ?></th></h3> 

	</tr>
	</thead>
	<tbody>
		<tr  style="color: #9e9e9e; background: #607d8b;">
			<th style="padding-left: 15px;padding-bottom: 10px;padding-top: 15px;border:1px solid #d7d7d7;">Display Name</th>
			<th style="padding-left: 15px;padding-bottom: 10px;padding-top: 15px;border:1px solid #d7d7d7; color: #2a3f54;">Cons Name</th>
			<th style="padding-left: 15px;padding-bottom: 10px;padding-top: 15px;border:1px solid #d7d7d7; color: #2a3f54;">Description</th>

			<th style="padding-left: 15px;padding-bottom: 10px;padding-top: 15px;border:1px solid #d7d7d7; color: #2a3f54;">Value</th>



		</tr>

	</tbody>
	<tbody>

		<?php
		$constant_list=$this->constant_set_mdl->get_constant_set_list(false,array('cons_category'=>$cat->cons_category));

		if($constant_list):
			foreach ($constant_list as $km => $constant):
				?>
				<tr>

					<td style="padding-bottom: 10px;padding-left: 15px;padding-top: 10px;   width: 30%;font-size: 13px;border:1px solid #d7d7d7;"><?php echo $constant->cons_display; ?></td>
					<td style="padding-bottom: 10px;padding-left: 15px;padding-top: 10px;   width: 30%;font-size: 13px;border:1px solid #d7d7d7;"><?php echo $constant->cons_name; ?></td>
					<td style="padding-bottom: 10px;padding-left: 15px;padding-top: 10px;   width: 30%;font-size: 13px;border:1px solid #d7d7d7;"><?php echo $constant->cons_description; ?></td>

					<td style="padding-bottom: 10px;padding-left: 10px;padding-top: 10px;   width: 50%;border:1px solid #d7d7d7;"><input  type="hidden" name="cons_id[]" value="<?php echo $constant->cons_id; ?>">
						<input style="padding-left: 5px;font-size: 13px;padding-top: 5px;padding-bottom: 5px;border:0px;" type="text" name="cons_value[]" value="<?php echo $constant->cons_value; ?>" ></td>


					</tr>
					<?php
				endforeach;
			endif;
			?>
		</tbody>



	<?php endforeach;endif; ?>

</table>
