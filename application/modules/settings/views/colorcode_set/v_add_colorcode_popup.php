<form method="post" id="FormColorcodesetpopup" action="<?php echo base_url('settings/colorcode_set/save_colorcode_set'); ?>" class="form-material form-horizontal form" >
	<div class="form-group ">
		<div class="col-md-4">
			<label>Status Name : </label>
			<input type="text" name="coco_statusname" value="" class="form-control">
		</div>

		<div class="col-md-4">
			<label>Display Status : </label>
			<input type="text" name="coco_displaystatus" value="" class="form-control">
		</div>
		<div class="col-md-4">
			<label>Status Value: </label>
			<input type="text" name="coco_statusval" value="" class="form-control">
		</div>
	</div>
	<div class="form-group ">
		

		<div class="col-md-4">
			<label>List Name: </label>
			<input type="text" name="coco_listname" value="" class="form-control">
		</div>
		<div class="col-md-4">
			<label>Color Code : </label>
			<input type="text" name="coco_color" value="" class="form-control">
		</div>
		<div class="col-md-4">
			<label>Background Color : </label>
			<input type="text" name="coco_bgcolor" value="" class="form-control">
		</div>

		
	</div>
	<div class="form-group ">
		

		
		<div class="col-md-4">
			<label>Button Name: </label>
			<input type="text" name="coco_button" value="" class="form-control">
		</div>

		<div class="col-md-4">
			<label class="d-block">Isfield?</label>
			<input type="radio" name="coco_isfield" value="Y" >Active
			<input type="radio" name="coco_isfield" value="N" >Inactive
		</div>
		<div class="col-md-4">
			<label class="d-block">Isactive?</label>
			<input type="radio" name="coco_isactive" value="Y" >Active
			<input type="radio" name="coco_isactive" value="N" >Inactive
		</div>
	</div>
	<div class="form-group ">
		<div class="col-md-4">
			<label class="d-block">Isallorg?</label>
			<input type="radio" name="coco_isallorg" value="Y" >Active
			<input type="radio" name="coco_isallorg" value="N" >Inactive
		</div>

		<div class="col-md-4">
			<label>Group : </label>
			<input type="text" name="coco_group" value="" class="form-control">
		</div>
		<div class="col-md-4">
			<label>Database Table Name : </label>
			<input type="text" name="coco_tablename" value="" class="form-control">
		</div>

		
	</div>
	<div class="form-group">
		<div class="col-md-12">
		   	<button type="submit" class="btn btn-info  savelist refreshTable" data-operation='<?php echo !empty($constant_list)?'update':'save' ?>' id="btnSubmit" data-isdismiss='Y' >Save</button>
		</div>
		 <div class="col-sm-12">
                <div  class="alert-success success"></div>
                <div class="alert-danger error"></div>
		 </div>
	</div>
</form>

