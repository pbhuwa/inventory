<div class="searchWrapper">
    <form id="purchase_mrn_search_form">
        <div class="form-group">
            <div class="row">
                  <?php echo $this->general->location_option(1,'locationid'); ?>

              <div class="col-md-2 col-sm-3 col-xs-12">
            <label for="example-text"><?php echo $this->lang->line('category'); ?>:<span class="required">*</span>:</label>
                <select id="catid" name="catid"  class="form-control required_field select2" >
                    <option value="">All</option>
                    <?php 
                        if($item_category):
                            foreach ($item_category as $km => $itmcat):
                    ?>
                    <option value="<?php echo $itmcat->eqca_equipmentcategoryid; ?>" ><?php echo $itmcat->eqca_category; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </select>
            </div>

                <div class="col-md-1">
                    <label><?php echo $this->lang->line('from'); ?></label>
                    <input type="text" id="fromdate" name="fromdate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
                </div>

                <div class="col-md-1">
                    <label><?php echo $this->lang->line('to'); ?></label>
                    <input type="text" id="todate" name="todate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
                </div>

        

                <div class="col-md-2">
                    <button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="issue_consumption/test/category_wise_report"><?php echo $this->lang->line('search'); ?></button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="clearfix"></div>

<div id="displayReportDiv"></div>


