<div class="col-md-2 col-sm-4 col-xs-12">
	<label for="example-text"><?php echo $this->lang->line('date_range'); ?> <span class="required">*</span>:</label>
	<select name="clsm_csmasterid" class="form-control select2" id="masterid" data-action="<?php echo base_url('stock_inventory/stock_check/change_data');?>">
		  	<option value="">---All---</option>
			<?php
			  if($purchase):
			  foreach ($purchase as $km => $eq):
			  ?>
			<option value="<?php echo $eq->clsm_csmasterid.':'.$eq->clsm_fromdatebs.'-'.$eq->clsm_todatebs; ?>"><?php echo $eq->clsm_fromdatebs; ?> - <?php echo $eq->clsm_todatebs; ?></option>
			<?php
		  	endforeach;
		  	endif; ?>
	</select>
</div>