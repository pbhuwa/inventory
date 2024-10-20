
   
<div class="searchWrapper">
        <form id="FormreqAnalysis"  action="<?php echo base_url('issue_consumption/stock_transfer/req_analysis_search');?>" method="post">
            <div class="row">
            <div class="col-sm-12">
              <?php echo $this->general->location_option(2,'locationid'); ?>
                   <div class="col-md-2">
                <label><?php echo $this->lang->line('date_search'); ?> :</label>
                <select name="searchDateType" id="searchDateType" class="form-control">
                    <option value="date_range">By Date Range</option>
                    <option value="date_all">All</option>
                </select>
            </div>
         <div class="dateRangeWrapper">

                <div class="col-md-2">
                    <label><?php echo $this->lang->line('from_date'); ?></label>
                    <input name="frmDate" type="text" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
                </div>
                <div class="col-md-2">
                    <label><?php echo $this->lang->line('to_date'); ?></label>
                    <input name="toDate" type="text" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
                </div>
                </div>
               
                <div id="transferData"></div>
                
                <div class="col-md-2">
                    <button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="issue_consumption/stock_transfer/req_analysis_search"><?php echo $this->lang->line('search'); ?></button>
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


