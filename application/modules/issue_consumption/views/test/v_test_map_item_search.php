<div class="white-box">
    <div class="searchWrapper">
        <div class="pad-5">
            <form id="asset_search_form">

                <div class="form-group">

                    <div class="row">
                        
                    <div id="datediv">
                            <div class="col-md-3">
                                <label><?php echo $this->lang->line('from_date'); ?></label>
                                <input type="text" name="frmDate" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
                            </div>

                            <div class="col-md-3">
                                <label><?php echo $this->lang->line('to_date'); ?></label>
                                <input type="text" name="toDate" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
                            </div>
                     </div>
                     <div class="col-md-3">
                           <label>Test </label>
                           <select name="item_name" class="form-control select2" id="item_name">
                            <option value="">All</option>
                            <?php
                            if($item_name):
                                foreach ($item_name as $key =>$mat):
                                    ?>
                                    <option value="<?php echo $mat->tena_id; ?>"><?php echo $mat->itemname; ?></option>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div> 

    <div class="col-md-2">
        <button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="issue_consumption/test/search_test_item"><?php echo $this->lang->line('search'); ?></button>
    </div>
</div>
</div>
</form>
</div></div>
<div class="clearfix"></div>
<div id="displayReportDiv"></div>
</div>
</div>
</div>
</div>

