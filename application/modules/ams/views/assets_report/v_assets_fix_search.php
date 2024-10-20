<div class="searchWrapper">
    <div class="row">
        <form class="col-sm-12">
            <?php echo $this->general->location_option(2); ?>
            <div class="col-md-2">
                <label>Date Search:</label>
                <select name="searchDateType" id="searchDateType" class="form-control">
                    <option value="date_all">All</option>
                    <option value="date_range">By Date Range</option>
                    
                </select>
            </div>
         <div class="dateRangeWrapper" style="display:none">
            <div class="col-md-1">
                <label><?php echo $this->lang->line('from_date'); ?> :</label>
                <input type="text" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
            </div>
            <div class="col-md-1">
                <label><?php echo $this->lang->line('to_date'); ?>:</label>
                <input type="text" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
            </div>
        </div>
            
        <div class="col-md-2">
        <button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="ams/assets_report/get_assets_fix_report"><?php echo $this->lang->line('search'); ?></button>
        </div>
            <div class="sm-clear"></div>
        </form> 
    </div>
   <div class="clearfix"></div>

<div id="displayReportDiv"></div>

</div>


<script type="text/javascript">
    $(document).off('change','#searchDateType');
    $(document).on('change','#searchDateType',function(){
        var search_date_val = $(this).val();

        if(search_date_val == 'date_all'){
            $('.dateRangeWrapper').hide();
        }else{
            $('.dateRangeWrapper').show();
        }
    });
</script>