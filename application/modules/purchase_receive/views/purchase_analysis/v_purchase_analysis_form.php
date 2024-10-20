<div class="searchWrapper">
    <form id="purchase_supplier_search_form">
        <div class="form-group">
            <div class="row">
                <?php echo $this->general->location_option(1,'locationid'); ?>
            <div class="col-md-2">
                <label><?php echo $this->lang->line('date_search'); ?> :</label>
                <select name="searchDateType" id="searchDateType" class="form-control">
                    <option value="date_range">By Date Range</option>
                    <option value="date_all">All</option>
                </select>
            </div>
            <div class="dateRangeWrapper">
                <div class="col-md-1">
                    <label><?php echo $this->lang->line('from'); ?></label>
                    <input type="text" id="fromdate" name="fromdate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
                </div>

                <div class="col-md-1">
                    <label><?php echo $this->lang->line('to'); ?></label>
                    <input type="text" id="todate" name="todate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
                </div>
                </div>

           <!--      <div class="col-md-2">
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
                 </div> -->

                <div class="col-md-2">
                    <label><?php echo $this->lang->line('choose');?></label>
                    <select name="summary_type" class="form-control" id="summary_type">
                        <option value="">All</option>
                        <option value="supplier_wise">Supplier Wise</option>
                        <option value="date_wise">Date Wise</option>
                        <option value="item_wise">Item Wise</option>
                        <option value="category_wise">Category Wise</option>
                    </select>
                </div>

                    <div class="col-md-2">
                <label>Print Orientation</label>
                <select name="page_orientation" id="page_orientation" class="form-control">
                    <option value="P">Portrait </option>
                    <option value="L">Landscape</option>
                </select>
            </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="purchase_receive/purchase_analysis/purchase_analysis_report"><?php echo $this->lang->line('search'); ?></button>
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