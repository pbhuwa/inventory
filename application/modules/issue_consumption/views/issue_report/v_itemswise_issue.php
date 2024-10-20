<div class="searchWrapper">
	<form id="FormIssueAnalysisItemWise"  action=""  class="form-material form-horizontal form">
	<div class="row">
	<div class="form-group">
	<?php echo $this->general->location_option(2,'locationid'); ?>
	<div class="col-md-2">
			<label for="example-text"><?php echo $this->lang->line('store'); ?><span class="required">*</span>:</label>
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
		<div class="col-md-2">
                <label><?php echo $this->lang->line('date_search'); ?> :</label>
                <select name="searchDateType" id="searchDateType" class="form-control">
                    <option value="date_range">By Date Range</option>
                    <option value="date_all">All</option>
                </select>
            </div>
       <div class="dateRangeWrapper">
		<div class="col-md-2">
			<label for="example-text"><?php echo $this->lang->line('from_date'); ?>: </label>
			<input type="text" name="fromdate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Dispatch Date" value="<?php echo CURMONTH_DAY1;?>" id="fromdate">
			<span class="errmsg"></span>
		</div>
		<div class="col-md-2">
			<label for="example-text"><?php echo $this->lang->line('to_date'); ?> : </label>
			<input type="text" name="todate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Dispatch To" value="<?php echo DISPLAY_DATE;?>" id="todate">
			<span class="errmsg"></span>
		</div>
		</div>
		<div class="col-md-2">
        <button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="/issue_consumption/issue_analysis/search_issue_wise_item"><?php echo $this->lang->line('search'); ?></button>
    </div>
  </div>
</div>
</form>
</div>
<div class="clearfix"></div>

<div id="displayReportDiv"></div>


<script type="text/javascript">

 $(document).off('click','#searchByDate')
    $(document).on('click','#searchByDate',function(){
        frmDate=$('#frmDate').val();
        toDate=$('#toDate').val();
        fiscalyear=$('#fiscalyear').val();
        locationid=$('#locationid').val();
        type=$('#searchByType').val(); 
         searchDateType=$('$searchDateType').val();
        if (searchDateType == 'date_all') {
            frmDate = '';
            toDate = '';
        }
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

