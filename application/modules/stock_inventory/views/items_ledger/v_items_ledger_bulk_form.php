<div class="searchWrapper">
    <form id="issueBookSearch">
        <?php echo $this->general->location_option(2,'locationid'); ?>
        
        <div class="col-md-2 col-sm-3">
            <label for="example-text"><?php echo $this->lang->line('store_type'); ?> <span class="required">*</span>:</label>
            <select id="store_id" name="store_id" name="store_id" class="form-control required_field" >
                <option value="">---All---</option>
                <?php 
                    if($store):
                        foreach ($store as $km => $dep):  
                ?>
                 <option value="<?php echo $dep->eqty_equipmenttypeid; ?>"><?php echo $dep->eqty_equipmenttype; ?></option>
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
        <div class="col-md-2 col-sm-2">
            <label><?php echo $this->lang->line('from_date'); ?></label>
            <input type="text" id="fromdate" name="fromdate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
        </div>
         <div class="col-md-2 col-sm-2">
            <label><?php echo $this->lang->line('to_date'); ?></label>
            <input type="text" id="todate" name="todate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
        </div>
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
        <div class="col-md-2">
            <a class="btn btn-info searchReport" style="margin-top: 18px;" data-url="stock_inventory/items_ledger/get_items_ledger"><?php echo $this->lang->line('search'); ?></a>
        </div>
    </form>
    <div class="clear"></div>
</div>

<div id="displayReportDiv"></div>

<script type="text/javascript">
    $('.engdatepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    });
    $('.nepdatepicker').nepaliDatePicker();
</script>
