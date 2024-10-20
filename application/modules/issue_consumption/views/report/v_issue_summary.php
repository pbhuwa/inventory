
<div class="searchWrapper">
<form id="issueIssueAndValue" action="" class="form-material form-horizontal form">
	<div class="form-group">
          <?php echo $this->general->location_option(2,'locationid'); ?>
           <div class="col-md-2">
                <label><?php echo $this->lang->line('date_search'); ?> :</label>
                <select name="searchDateType" id="searchDateType" class="form-control">
                    <option value="date_range">By Date Range</option>
                    <option value="date_all">All</option>
                </select>
            </div>

         <div class="dateRangeWrapper">
		<div class="col-md-2 col-sm-4 col-xs-12">
			<label for="example-text"><?php echo $this->lang->line('from_date'); ?>: </label>
			<input type="text" name="fromdate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Dispatch Date" value="<?php echo CURMONTH_DAY1;?>" id="fromdate">
			<span class="errmsg"></span>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-12">
			<label for="example-text"><?php echo $this->lang->line('to_date'); ?> : </label>
			<input type="text" name="todate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Dispatch To" value="<?php echo DISPLAY_DATE;?>" id="todate">
			<span class="errmsg"></span>
		</div>
		</div>
		<!-- <div class="col-md-3 col-sm-4 col-xs-12">
			<div class="hidden-xs">
				<label for="">&nbsp;</label>
			</div>
			<div class="sgl_line_check slc_right">
				<label for="example-text">Issue Summary : </label>
				<input type="checkbox" id="issue_summary" value="issue_summary" name="issue_summary">
			</div>
		</div> -->
		<div class="col-md-3 col-sm-4 col-xs-12">
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
                <label>Print Orientation</label>
                <select name="page_orientation" id="page_orientation" class="form-control">
                    <option value="P">Portrait </option>
                    <option value="L">Landscape</option>
                </select>
            </div>

		<div class="col-md-2 col-sm-4 col-xs-12">
			<div>
				<label for="">&nbsp;</label>
			</div>
			 <button type="submit" class="btn btn-info searchReport" data-url="issue_consumption/report/issue_summary_search"><?php echo $this->lang->line('search'); ?></button>
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
