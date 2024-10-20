<div class="searchWrapper">
    <form id="issueBookSearch">
        <?php echo $this->general->location_option(2,'locationid'); ?>
        
        <div class="col-md-2 col-sm-3">
            <label for="example-text"><?php echo $this->lang->line('store_type'); ?> <span class="required">*</span>:</label>
            <select id="store_id" name="store_id"  class="form-control required_field" >
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
        <div class="col-md-1 col-sm-1">
            <label><?php echo $this->lang->line('from_date'); ?></label>
            <input type="text" id="fromdate" name="fromdate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
        </div>
         <div class="col-md-1 col-sm-1">
            <label><?php echo $this->lang->line('to_date'); ?></label>
            <input type="text" id="todate" name="todate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
        </div> 
        </div>
         <div class="col-md-2 col-sm-3">
            <label for="example-text"><?php echo $this->lang->line('material_type'); ?> <span class="required">*</span>:</label>
            <select id="materialtypeid" name="materialtypeid" class="form-control required_field" >
                <?php 
                    if($materialstypecategory):
                        foreach ($materialstypecategory as $km => $matcat):  
                ?>
                 <option value="<?php echo $matcat->maty_materialtypeid; ?>"><?php echo $matcat->maty_material; ?></option>
                <?php
                        endforeach;
                    endif;
                ?>
            </select>
        </div>
     
        <div class="col-md-3 col-sm-2 col-xs-12">
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
        <div class="col-md-1">
            <a class="btn btn-info searchReport" style="margin-top: 18px;" data-url="stock_inventory/items_ledger/get_expendable_items_ledger"><?php echo $this->lang->line('search'); ?></a>
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
 <script type="text/javascript">
            $(document).off('change','#materialtypeid');
            $(document).on('change','#materialtypeid',function(){
            var material_typeid = $('#materialtypeid').val();
            var action=base_url+'/stock_inventory/item/get_item_by_materialid';
            $.ajax({
                type: "POST",
                url: action,
                data:{material_typeid:material_typeid},
                dataType: 'json',
                success: function(datas) 
                {
                    $('#itemid').select2("val", "");
                    $('#itemid').html(datas);
                }
            });
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