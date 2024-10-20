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
     
      <div class="col-md-2" id="itemdiv">
                    <label>Item</label>
                    <div class="dis_tab">   
                    <input type="text" class="form-control" name="itemname" id="itemname" value="">
                    <input type="hidden" name="itemid" id="itemid" value="">
                    <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading="Item List" data-viewurl="<?php echo base_url('stock_inventory/item_life_cycle/list_of_item'); ?>"><strong>...</strong></a>
                     <a href="javascript:void(0)" class="table-cell width_30" style="font-size: 16px;font-weight: bold;color: #ea2d2d;" title="Clear" id="clear"> X </a>
                    </div>
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


<script type="text/javascript">
   
    $(document).off('click','.itemDetail');
    $(document).on('click','.itemDetail',function(e){
        var itemid=$(this).data('itli_itemlistid');
        var itemname=$(this).data('itli_itemname');
        var itemcode=$(this).data('itli_itemcode');
        if(itemid){
          var item_merge=itemcode+'|'+itemname;
          $('#itemid').val(itemid);
          $('#itemname').val(item_merge);
          $('#myView').modal('hide');
        }
    });

    $(document).off('click','#clear');
    $(document).on('click','#clear',function(e){
         $('#itemid').val('');
        $('#itemname').val('');
    });

   
</script>