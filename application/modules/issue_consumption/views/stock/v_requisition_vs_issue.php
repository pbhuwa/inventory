<div class="searchWrapper">
    <form id="purchase_mrn_search_form">
        <div class="form-group">
            <div class="row">
                  <?php echo $this->general->location_option(1,'locationid'); ?>

              <div class="col-md-2">
                <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?> :<span class="required">*</span>:</label>
                <select name="fyear" class="form-control required_field" id="fyear">
                    <?php
                    if($fiscalyear):
                    foreach ($fiscalyear as $km => $dt): ?>
                    <option value="<?php echo $dt->fiye_name; ?>" <?php if(CUR_FISCALYEAR == $dt->fiye_name) echo "Selected = selected"; ?> ><?php echo $dt->fiye_name; ?></option>
                    <?php
                    endforeach;
                    endif;
                    ?>
                </select>
            </div>

        

                <div class="col-md-2">
                    <button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="issue_consumption/stock_requisition/requisition_vs_issue_report"><?php echo $this->lang->line('search'); ?></button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="clearfix"></div>

<div id="displayReportDiv"></div>


