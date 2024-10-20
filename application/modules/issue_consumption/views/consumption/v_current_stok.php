<div class="searchWrapper">
<form id="FormCurrentStock"  action="" class="form-material form-horizontal form">
	<div class="row">
	<div class="form-group">
		<?php echo $this->general->location_option(2,'locationid'); ?>
        

		<div class="col-md-2">
			<label for="example-text"><?php echo $this->lang->line('from_date'); ?> : </label>
			<input type="text" name="fromdate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Dispatch Date" value="<?php echo CURMONTH_DAY1;?>" id="fromdate">
			<span class="errmsg"></span>
		</div>
		<div class="col-md-2">
			<label for="example-text"><?php echo $this->lang->line('to_date'); ?> : </label>
			<input type="text" name="todate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Dispatch To" value="<?php echo DISPLAY_DATE;?>" id="todate">
			<span class="errmsg"></span>
		</div>
		<div class="col-md-3">
			<label for="example-text"><?php echo $this->lang->line('store'); ?> :<span class="required">*</span>:</label>
			<select name="store_id" class="form-control select2" id="store_id">
				<option value="">---All---</option>
				<?php
				if($store):
				foreach ($store as $km => $st):
				?>
				<option value="<?php echo $st->eqty_equipmenttypeid; ?>"><?php echo $st->eqty_equipmenttype; ?></option>
				<?php
				endforeach;
				endif;
				?>
			</select>
		</div>
		<div class="col-md-1">
			<div>
				<label for="">&nbsp;</label>
			</div>
			<button type="submit" class="btn btn-info searchReport mtop_0" data-url="issue_consumption/consumption_report/search_current_stock"><?php echo $this->lang->line('search'); ?></button>
		</div>
		<div id="ResponseSuccess" class="waves-effect waves-light m-r-Y0 text-success"></div>
        <div id="ResponseError" class="waves-effect waves-light m-r-Y0 text-danger"></div>
	</div>
</div>
</form>
</div>
<div class="clearfix"></div>
<div id="displayReportDiv"></div>
