<?php 
$this->locationid = $this->session->userdata(LOCATION_ID);
$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
?>
<div class="searchWrapper">
    <form id="job_head_expenses_report_search_form">
        <div class="form-group">
            <div class="row">
                <?php echo $this->general->location_option(2, 'locationid'); ?>

               <!--  <div class="col-md-2">
                    <label><?php echo $this->lang->line('date_search'); ?> :</label>
                    <select name="searchDateType" id="searchDateType" class="form-control">
                        <option value="date_range">By Date Range</option>
                        <option value="date_all">All</option>
                    </select>
                </div> -->

                <!-- <div class="dateRangeWrapper"> -->
                    <div class="col-md-1">
                        <label><?php echo $this->lang->line('from_date'); ?> :</label>
                        <input type="text" name="frmDate" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>" />
                    </div>

                    <div class="col-md-1">
                        <label><?php echo $this->lang->line('to_date'); ?>:</label>
                        <input type="text" id="toDate" name="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>" />
                    </div>
                <!-- </div> -->
                
                <div class="col-md-2">
                    <label for="budget_headid">Budget Head: </label><br>
                    <select name="budgetheadid" id="budget_headid" class="form-control">
                        <option value="">--All--</option>
                        <?php
                        if (!empty($budget_head)) :
                            foreach ($budget_head as $bh) :
                                ?>
                                <option value="<?php echo $bh->buhe_bugetheadid; ?>"> <?php echo $bh->buhe_headtitle; ?></option>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="categoryid">Category:</label>
                    <select name="categoryid" id="categoryid" class="form-control select2" >
                        <option value="">---All---</option>
                        <?php
                        if(!empty($category_type)):
                            foreach ($category_type as $key => $ct):
                                ?>
                                <option value="<?php echo $ct->catid; ?>"><?php echo $ct->eqca_category; ?></option>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <label>Print Orientation</label>
                    <select name="page_orientation" class="form-control">
                        <option value="P">Portrait </option>
                        <option value="L">Landscape</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="reports/JobHeadExpensesReport/get_report"><?php echo $this->lang->line('search'); ?></button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="clearfix"></div>

<div id="displayReportDiv"></div>
<script type="text/javascript">
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