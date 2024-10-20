
<div class="searchWrapper">
<form id="FormSubCategorywise" action="" class="form-material form-horizontal form">
	<div class="form-group">
		<div class="row">
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
			<label for="example-text"><?php echo $this->lang->line('select_category'); ?> :</label>
			<select name="catid" class="form-control select2" id="catid">
				<option value="">---All---</option>
				<?php
				if($equipment):
				foreach ($equipment as $km => $dep):
				?>
				<option value="<?php echo $dep->eqca_equipmentcategoryid; ?>"><?php echo $dep->eqca_category; ?></option>
				<?php
				endforeach;
				endif;
				?>
			</select>
		</div>

        <div class="col-md-2 col-sm-4 col-xs-12">
            <label for="example-text"><?php echo $this->lang->line('select_store'); ?> :</label>
            <select name="store_id" class="form-control select2" id="store_id">
                <option value="">---All---</option>
                <?php
                    if($store_type):
                        foreach ($store_type as $km => $st):
                        ?>
                        <option value="<?php echo $st->eqty_equipmenttypeid; ?>"><?php echo $st->eqty_equipmenttype; ?></option>
                        <?php
                        endforeach;
                    endif;
                ?>
            </select>
        </div>

		<div class="col-md-2 col-sm-4 col-xs-12">
			
			<button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="issue_consumption/report/search_sub_categorywise_issue"><?php echo $this->lang->line('search'); ?></button>
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

