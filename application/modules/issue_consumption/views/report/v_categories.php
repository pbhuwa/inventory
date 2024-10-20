
<div class="searchWrapper">
<form id="FormCategorywise" action="<?php echo base_url('issue_consumption/report/search_result'); ?>" class="form-material form-horizontal form">
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
			<input type="text" name="fromdate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Dispatch Date" value="<?php echo CURMONTH_DAY1;?>" id="fromdate" autocomplete="off">
			<span class="errmsg"></span>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-12">
			<label for="example-text"><?php echo $this->lang->line('to_date'); ?>: </label>
			<input type="text" name="todate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Dispatch To" value="<?php echo DISPLAY_DATE;?>" id="todate" autocomplete="off">
			<span class="errmsg"></span>
		</div>
		</div>
     
		<div class="col-md-2 col-sm-4 col-xs-12">
			<label for="example-text"><?php echo $this->lang->line('select_category'); ?> <span class="required">*</span>:</label>
			<select name="maty_materialtypeid" class="form-control select2" id="materialtype">
				<option value="">---All---</option>
				<?php
				    if($materialstypecategory):
				        foreach ($materialstypecategory as $km => $dep):
				?>
				    <option value="<?php echo $dep->maty_materialtypeid; ?>"><?php echo $dep->maty_material; ?></option>
				<?php
				        endforeach;
				    endif;
				?>
			</select>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-12">
			
			<button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="issue_consumption/report/search_categorywise_issue"><?php echo $this->lang->line('search'); ?></button>
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

