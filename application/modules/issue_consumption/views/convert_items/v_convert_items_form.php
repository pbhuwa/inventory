<div class="white-box">
	<h3 class="box-title"><?php echo $this->lang->line('convert_list'); ?></h3>

	<div  id="formdiv_convertitems" class="formdiv frm_bdy">

	<form method="post" id="formQuotataion" action="<?php echo base_url('issue_consumption/convert_items/save_convert_items'); ?>" class="form-material form-horizontal form" data-reloadurl="<?php echo base_url('issue_consumption/convert_items/form_convert_items'); ?>">
		<input type="hidden" name="id" value="">

		<input type="text" name="conv_parentmtdid" id="conv_parentmtdid"/>

		<input type="text" name="conv_childmtdid" id="conv_childmtdid"/>

		<input type="text" name="supplierid" id="supplierid"/>

		<input type="text" name="supplierbillno" id="supplierbillno"/>

		<input type="text" name="selprice" id="selprice"/>

		<input type="text" name="unitprice" id="unitprice"/>

		<input type="text" name="mfgdatead" id="mfgdatead"/>

		<input type="text" name="mfgdatebs" id="mfgdatebs"/>


		<div class="form-group">
			<div class="col-md-3">
				<label><?php echo $this->lang->line('item_to_convert'); ?></label>
				<!-- <input type="text" class="form-control" name="conv_parentid"/> -->

				<div class="dis_tab"> 
	                <input type="text" class="form-control itemcode enterinput " id="itemcode_parent" name=""  data-id='1'>
	                <input type="hidden" class="conv_parentid" name="conv_parentid" data-id='1' value="" id="conv_parentid">
	                <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading='Item List' data-viewurl='<?php echo base_url('issue_consumption/convert_items/load_item_lists_modal/1'); ?>' data-id='1'><strong>...</strong></a>
	            </div>
			</div>

			<div class="col-md-3">
				<label><?php echo $this->lang->line('new_items'); ?></label>
				<!-- <input type="text" class="form-control" name="conv_childid"/> -->

				<div class="dis_tab"> 
	                <input type="text" class="form-control itemcode enterinput " id="itemcode_child" name=""  data-id='2'>
	                <input type="hidden" class="conv_childid" name="conv_childid" data-id='2' value="" id="conv_childid">
	                <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading='Item List' data-viewurl='<?php echo base_url('issue_consumption/convert_items/load_item_lists_modal/2'); ?>' data-id='2'><strong>...</strong></a>
	            </div>
			</div>

			<div class="col-md-3">
				<label><?php echo $this->lang->line('qty_to_convert'); ?></label>
				<input type="text" class="form-control number" name="conv_childqty" id="conv_childqty"/>
			</div>

			<div class="col-md-3">
				<label><?php echo $this->lang->line('unit_factor'); ?></label>
				<input type="text" class="form-control number" name="conv_factor"/>
			</div>

			<div class="col-md-3">
				<label><?php echo $this->lang->line('stock_quantity'); ?></label>
				<input type="text" class="form-control" name="conv_parentqty" id="conv_parentqty" readonly="readonly" />
			</div>

			<div class="col-md-3">
				<label><?php echo $this->lang->line('date'); ?></label>
				<input type="text" name="conv_condate" class="form-control <?php echo DATEPICKER_CLASS; ?> date" placeholder="" id="conv_condate" value="" >
			</div>

			<div class="col-md-3">
				<label><?php echo $this->lang->line('batch_no'); ?></label>
				<input type="text" class="form-control" name="" readonly="readonly"/>
			</div>

			<div class="col-md-3">
				<label><?php echo $this->lang->line('expiry_date'); ?></label>
				<input type="text" class="form-control" name="" readonly="readonly"/>
			</div>
		</div>

		<div class="form-group">
		    <?php if(empty($convert_items_data)):?>
		    <div class="col-md-12">
		        <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($item_data)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($item_data)?'Update':'Save' ?></button>
		    </div>
		    <?php endif; ?>
		    <div class="col-sm-12">
		        <div  class="alert-success success"></div>
		        <div class="alert-danger error"></div>
		    </div>
		</div>
	</form>
	</div>
</div>

<script>
	$(document).off('keyup','#conv_childqty');
	$(document).on('keyup','#conv_childqty',function(){
		var stockqty = $('#conv_parentqty').val();
		
		var childqty = $('#conv_childqty').val();

		if(childqty > stockqty){
			alert('Qty to convert should not exceed stock qty');
			$('#conv_childqty').val(stockqty);
			return false;
		}
	});
</script>