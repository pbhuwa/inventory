<div class="searchWrapper">
    <form id="purchase_mrn_search_form">
        <div class="form-group">
            <div class="row">
                  <?php echo $this->general->location_option(1,'locationid'); ?>

            <div class="col-md-2 col-md-3 col-xs-12">
                <label><?php echo $this->lang->line('fiscal_year'); ?></label>
                    <select name="fiscalyrs" class="form-control">
                        <?php 
                        if(!empty($fiscalyrs)):
                            foreach ($fiscalyrs as $kfy => $fyrs):
                        ?>
                        <option value="<?php echo $fyrs->fiye_name; ?>"><?php echo $fyrs->fiye_name ?></option>
                        <?php
                            endforeach;
                        endif; 
                        ?>
                    </select>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-12">
            <label for="example-text"><?php echo $this->lang->line('month'); ?>:</label>
                <select id="month" name="month"  class="form-control required_field select2" >
                    <option value="">All</option>
                    <?php 
                        if($month):
                            foreach ($month as $km => $mon):
                    ?>
                    <option value="<?php echo $mon->mona_monthid; ?>" <?php if(CURMONTH==$mon->mona_monthid) echo "selected=selected" ?> ><?php echo $mon->mona_namenp; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </select>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-12">
                <label for="example-text"><?php echo $this->lang->line('select_items'); ?><span class="required">*</span>:</label>
                <select name="itemid" id="itemid" class="form-control required_field select2" >
                    <option value="">---All---</option>
                    <?php
                    if($items):
                    foreach ($items as $km => $dep):
                    ?>
                    <option value="<?php echo $dep->itli_itemlistid; ?>"><?php echo $dep->itli_itemcode.' | '.$dep->itli_itemname; ?></option>
                    <?php
                    endforeach;
                    endif;
                    ?>
                </select>
            </div>

                <!-- <div class="col-md-1">
                    <label><?php echo $this->lang->line('year'); ?>:</label>
                    <input type="number" id="year" name="year" class="form-control" value="<?php echo CURYEAR; ?>"/>
                </div> -->

                <div class="col-md-2">
                    <!-- <button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="reports/handover_expenses_report/handover_expenses_report_details"><?php echo $this->lang->line('search'); ?></button> -->
                     <a class="btn btn-info searchReport" style="margin-top: 18px;" data-url="stock_inventory/items_ledger/get_items_ledger_typei"><?php echo $this->lang->line('search'); ?></a>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="clearfix"></div>

<div id="displayReportDiv"></div>


