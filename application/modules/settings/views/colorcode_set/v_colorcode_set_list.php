<div class="table-responsive">
	<table class="table table-striped dataTable" id="Dtable">
		<thead>
			<tr style="color: #9e9e9e; background: #607d8b;">
				<th width="5%">S.N</th>
				<th width="10%">Status Name</th>
				<th width="10%">Display Name</th>
				<th width="5%">Value</th>
				<th width="25%">List Name</th>
				<th width="10%">Color</th>
				<th width="10%">Bg color</th>
				<th width="5%"> Isactive?</th>
				<th width="5%">Isallorg?</th>
				<th width="15%">Table Name</th>
			</tr>
		</thead>
		
		<tbody>
			<?php
				if($colorcode_data):
					$i=1;
					foreach ($colorcode_data as $km => $color):
			?>
			<tr >
				<td><?php echo $i; ?></td>
				<td ><?php echo $color->coco_statusname; ?></td>
				<td >
					<input class="form-control" type="text" name="coco_displaystatus[]" value="<?php echo $color->coco_displaystatus; ?>" >
				</td>
				<td >
					<?php echo $color->coco_statusval; ?>
				</td>
				<td ><?php echo $color->coco_listname; ?></td>					
				<td style="color: <?php echo $color->coco_color; ?>;" id="td_color_<?php echo $i;?>">
					<input type="hidden" name="coco_colorcodeid[]" value="<?php echo $color->coco_colorcodeid; ?>">
					<input href="javascript:void(0);" class="colorbtn" type="text" name="coco_color[]"  data-id="<?php echo $color->coco_colorcodeid; ?>" id="color_<?php echo $color->coco_colorcodeid; ?>" value="<?php echo $color->coco_color; ?>" >
				</td>
				<td  style="color: #9e9e9e; background: <?php echo $color->coco_bgcolor; ?>;" id="td_bgcolor_<?php echo $i; ?>">
					<input href="javascript:void(0);" class="bgcolotbtn form-control" type="text" data-id="<?php echo $color->coco_colorcodeid; ?>" id="colorbg_<?php echo $color->coco_colorcodeid; ?>" name="coco_bgcolor[]" value="<?php echo $color->coco_bgcolor; ?>" ></td>
				<td>
					<?php 
						if($color->coco_isactive=='Y'){echo "Active";}
							else{echo "Inactive";} ?>
				</td>
				<td>
					<?php 
						if($color->coco_isallorg=='Y'){echo "Active";}
							else{echo "Inactive";} ?>
				</td>
				<td ><?php echo $color->coco_tablename; ?></td>
			</tr>

			<?php
					$i++;
					endforeach;
				endif;
			?>
		</tbody>
	</table>
</div>

<!-- <link href="<?php echo base_url().PLUGIN_DIR; ?>bootstrap-colorpicker/bootstrap-colorpicker.css" rel="stylesheet" type="text/css" /> -->

<script src="<?php echo base_url().PLUGIN_DIR; ?>bootstrap-colorpicker/bootstrap-colorpicker.js"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.3/css/bootstrap-colorpicker.min.css" rel="stylesheet">

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.3/js/bootstrap-colorpicker.min.js"></script>   -->

<script>
	$(document).ready(function(){
		$(document).off('click mouseover','.colorbtn')
		$(document).on('click mouseover','.colorbtn',function(){
				// console.log('colorbtn');
	   	 	var id=$(this).data('id');  
	   	 	setTimeout(function(){
	   	 		console.log(id);
	   	 		$('#color_'+id).colorpicker();
	   	 	},100);	    	
	  	});
		
		$(document).off('click mouseover','.bgcolotbtn')
		$(document).on('click mouseover','.bgcolotbtn',function(){
			var id=$(this).data('id');  
			setTimeout(function(){
				console.log(id);
	   	 		$('#colorbg_'+id).colorpicker();
	   	 	},100);
		});
	});
</script>