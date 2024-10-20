<form method="post" action="" id="formAudittrial" >
    <div class="col-md-1">
                            <label>Table<span class="required">*</span> :</label>
                        </div>
                        <div class="col-md-1">
                            <select class="form-control" id="tablename" name="tablename">
                                <option value="">----All----</option>
                                <?php if($table_list):
                                foreach ($table_list as $ktl => $tlist):
                                    ?>
                                <option value="<?php echo $tlist->colt_tablename; ?>"><?php echo $tlist->tana_tabledisplay; ?></option>

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
                        <div class="col-md-1">From</div>
                        <div class="col-md-2">
                            <input type="text" name="fromDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>">
                        </div>
                        <div class="col-md-1">To</div>
                        <div class="col-md-2">
                            <input type="text" name="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>">
                        </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn_site btnSearch">Search</button>
                        </div>
                        <div class="clearfix"></div>

</form>
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
