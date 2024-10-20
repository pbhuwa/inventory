<div class="searchWrapper">
    <form id="issueBookSearch">
     <?php echo $this->general->location_option(2,'locationid'); ?> 
          <div class="col-md-2">
                <label><?php echo $this->lang->line('date_search'); ?> :</label>
                <select name="searchDateType" id="searchDateType" class="form-control">
                    <option value="date_range">By Date Range</option>
                    <option value="date_all">All</option>
                </select>
            </div>
      <div class="dateRangeWrapper">
        <div class="col-md-1 col-sm-2">
            <label><?php echo $this->lang->line('from_date'); ?></label>
            <input type="text" id="fromdate" name="fromdate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
        </div>
         <div class="col-md-1 col-sm-2">
            <label><?php echo $this->lang->line('to_date'); ?></label>
            <input type="text" id="todate" name="todate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
        </div> 
        </div>
        <div class="col-md-2 col-sm-3">
            <label for="example-text"><?php echo $this->lang->line('received_by'); ?> <span class="required">*</span>:</label>
            <select id="receiverid" name="receiverid" class="form-control" >
                <option value="">---All---</option>
                <?php 
                    if($received_by):
                        foreach ($received_by as $km => $dep):  
                ?>
                 <option value="<?php echo $dep->sama_receivedby; ?>"><?php echo $dep->sama_receivedby; ?></option>
                <?php
                        endforeach;
                    endif;
                ?>
            </select>
        </div>
        <div class="col-md-2">
            <a class="btn btn-info searchReport" style="margin-top: 18px;" data-url="issue_consumption/issue_by_receiver/get_issue_by_receiver"><?php echo $this->lang->line('search'); ?></a>
        </div>
    </form>
    <div class="clear"></div>
</div>

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