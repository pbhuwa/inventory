<div class="searchWrapper">
    <form id="purchase_mrn_search_form">
        <div class="form-group">
            <div class="row">
                <?php echo $this->general->location_option(1,'locationid'); ?>

                <div class="col-md-1">
                    <label><?php echo $this->lang->line('from'); ?></label>
                    <input type="text" id="fromdate" name="fromdate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
                </div>

                <div class="col-md-1">
                    <label><?php echo $this->lang->line('to'); ?></label>
                    <input type="text" id="todate" name="todate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
                </div>

                <div class="col-md-2">
                     <label><?php echo $this->lang->line('supplier_name'); ?></label>
                      <select name="supplierid" class="form-control select2" id="supplierid">
                            <option value="">All</option>
                            <?php
                                if($supplier_all):
                                    foreach ($supplier_all as $ks => $supp):
                                ?>
                            <option value="<?php echo $supp->dist_distributorid; ?>"><?php echo $supp->dist_distributor; ?></option>
                            <?php
                                endforeach;
                                endif;
                                ?>
                        </select>
                 </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="purchase_receive/purchase_analysis/purchase_analysis_credit_report"><?php echo $this->lang->line('search'); ?></button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="clearfix"></div>

<div id="displayReportDiv"></div>