

<div class="searchWrapper">
	<div class="row">
<form id="FormReportGeneration" action="" class="form-material form-horizontal form">
	
		  <?php echo $this->general->location_option(2,'locationid'); ?>
           <div class="col-md-2">
                <label><?php echo $this->lang->line('date_search'); ?> :</label>
                <select name="searchDateType" id="searchDateType" class="form-control">
                    <option value="date_range">By Date Range</option>
                    <option value="date_all">All</option>
                </select>
            </div>

         <div class="dateRangeWrapper">
		<div class="col-md-1 col-sm-3 col-xs-12">
			<label for="example-text"><?php echo $this->lang->line('from_date'); ?> : </label>
			<input type="text" name="fromdate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Dispatch Date" value="<?php echo CURMONTH_DAY1;?>" id="fromdate">
			<span class="errmsg"></span>
		</div>
		<div class="col-md-1 col-sm-3 col-xs-12">
			<label for="example-text"><?php echo $this->lang->line('to_date'); ?>: </label>
			<input type="text" name="todate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Dispatch To" value="<?php echo DISPLAY_DATE;?>" id="todate">
			<span class="errmsg"></span>
		</div>
		</div>
		<div class="col-md-2 col-sm-3 col-xs-6">
			<div class="hidden-xs">
				<label for="">&nbsp;</label>
			</div>
			<div class="sgl_line_check slc_right">
				<label for="example-text"><?php echo $this->lang->line('summary'); ?>  : </label>
				<input type="checkbox" value="summaray" name="is_summary" id="is_summary">
			</div>
		</div>
	
		<div class="col-md-2 col-sm-3 col-xs-12">
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

		<div class="col-md-2 col-sm-3 col-xs-12">
			<label for="example-text"><?php echo $this->lang->line('issued_by'); ?> : <span class="required">*</span>:</label>
			<select name="userid" class="form-control select2" id="userid">
				<option value="">---All---</option>
				<?php
				if($user):
				foreach ($user as $km => $u):
				?>
				<option value="<?php echo $u->usma_username; ?>"><?php echo $u->usma_username; ?></option>
				<?php
				endforeach;
				endif; ?>
			</select>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-12">
						
 <button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="issue_consumption/issue_value_report/search_issue_value"><?php echo $this->lang->line('search'); ?></button>
		</div>
			<div id="ResponseSuccess" class="waves-effect waves-light m-r-Y0 text-success"></div>
	        <div id="ResponseError" class="waves-effect waves-light m-r-Y0 text-danger"></div>
	
		</div>
		
 </div>

  <div id="displayReportDiv"></div>  

</form>




</div><div class="clearfix"></div>

<script type="text/javascript">

 $(document).off('click','#searchByDate')
    $(document).on('click','#searchByDate',function(){
        frmDate=$('#frmDate').val();
        toDate=$('#toDate').val();
        fiscalyear=$('#fiscalyear').val();
        locationid=$('#locationid').val();
        type=$('#searchByType').val(); 
        dtablelist.fnDraw();
    });

        $(document).off('change', '#searchDateType');
       $(document).on('change', '#searchDateType', function() {
        var search_date_val = $(this).val();

        if (search_date_val == 'date_all') {
            $('.dateRangeWrapper').hide();
        } else {
            $('.dateRangeWrapper').show();
        }
    });

</script>
