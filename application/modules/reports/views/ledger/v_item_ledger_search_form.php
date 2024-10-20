<div class="searchWrapper">
    <form id="purchase_mrn_search_form">
        <div class="form-group">
            <div class="row">
                  <?php echo $this->general->location_option(2,'locationid'); ?>

             <div class="col-md-1">
                <label for="example-text"><?php echo $this->lang->line('store'); ?><span class="required"></span>:</label>
                <select name="store_id" class="form-control required_field" id="store_id">
                    <option value="">---All---</option>
                    <?php
                    if($store):
                    foreach ($store as $km => $st):
                    ?>
                    <option value="<?php echo $st->eqty_equipmenttypeid; ?>"><?php echo $st->eqty_equipmenttype; ?></option>
                    <?php
                    endforeach;
                    endif;
                    ?>
                </select>
            </div>
               <div class="col-md-2">
                <label for="example-text">Category : </label><br>
                <select name="categoryid" id="categoryid" class="form-control select2 required_field">
                    <option value="">--All--</option>
                    <?php
                    if (!empty($category)) :
                        foreach ($category as $cat) :
                    ?>
                        <option value="<?php echo $cat->eqca_equipmentcategoryid; ?>" > <?php echo $cat->eqca_category; ?></option>
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
                <div class="col-md-1">
                    <label><?php echo $this->lang->line('from_date'); ?> :</label>
                    <input type="text" name="frmDate" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
                </div>
                
                <div class="col-md-1">
                    <label><?php echo $this->lang->line('to_date'); ?>:</label>
                    <input type="text" id="toDate" name="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
                </div>
            </div>
            <div class="col-md-1">
                <label>Ledger Type:</label>
                <select name="ledger_type" id="ledger_type" class="form-control">
                    <option value="single">Single</option>
                    <option value="bulk">Bulk</option>
                </select>
            </div>

            <div id="bulk_div">    
            <div class="col-md-1">
                <label>Start</label>
                <input type="number" name="start" value="1" class="form-control">
            </div>
            <div class="col-md-1">
                <label>Limit</label>
                <input type="number" name="limit" value="50" class="form-control">
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
          
            <div class="col-md-1">
                <button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="reports/ledger/get_search_ledger_report"><?php echo $this->lang->line('search'); ?>
                </button>
            </div>
            </div>
        </div>
    </form>
</div>

<div class="clearfix"></div>

<div id="displayReportDiv"></div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#ledger_type").change();    
    });
    $(document).off('change','#searchDateType');
    $(document).on('change','#searchDateType',function(){
        var search_date_val = $(this).val();

        if(search_date_val == 'date_all'){
            $('.dateRangeWrapper').hide();
        }else{
            $('.dateRangeWrapper').show();
        }
    });

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

    $(document).off('change','#ledger_type');
    $(document).on('change','#ledger_type',function(){
        var type = $(this).val();

        if(type == 'bulk'){
            $('#itemdiv').hide();
            $('#bulk_div').show();
            $('#searchDateType').val('date_range').change();
            $('#searchDateType').attr('readonly','readonly');
        }else{
            $('#itemdiv').show();
            $('#bulk_div').hide();
            $('#searchDateType').removeAttr('readonly');
        }
    });
</script>