<div class="searchWrapper">
    <form id="stock_report_searchForm">
        <div class="form-group">
            <div class="row">
                  <?php echo $this->general->location_option(2,'locationid'); ?>

             <div class="col-md-2">

                <label for="example-text">Material Type   : </label><br>

                <?php

                    $rema_mattype = !empty($req_data[0]->rema_mattypeid)?$req_data[0]->rema_mattypeid:1;   

                ?>

                <select name="mattypeid" id="mattypeid" class="form-control chooseMatType required_field">
                <option value="">All</option>
                 <?php 

                 if(!empty($material_type)):

                    foreach($material_type as $mat):

                 ?>

                 <option value="<?php echo $mat->maty_materialtypeid; ?>" <?php if($rema_mattype==$mat->maty_materialtypeid) echo "selected=selected"; ?>>  <?php echo $mat->maty_material; ?></option>

                 <?php

                    endforeach;

                 endif;

                 ?>

                </select>

            </div>

            <div class="col-md-2">
                <label for="example-text"><?php echo $this->lang->line('store'); ?><span class="required"></span>:</label>
                <select name="store_id" class="form-control required_field select2" id="store_id">
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

            <div class="col-md-3" id="itemdiv">
                    <label>Item</label>
                    <div class="dis_tab">   
                    <input type="text" class="form-control" name="itemname" id="itemname" value="">
                    <input type="hidden" name="itemid" id="itemid" value="">
                    <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading="Item List" data-viewurl="<?php echo base_url('stock_inventory/item_life_cycle/list_of_item'); ?>"><strong>...</strong></a>
                     <a href="javascript:void(0)" class="table-cell width_30" style="font-size: 16px;font-weight: bold;color: #ea2d2d;" title="Clear" id="clear"> X </a>
                    </div>
                </div>
          
            <div class="col-md-2">
                <label>Report Type</label>
                <select name="rpt_type" class="form-control" id="rpt_type"> 
                <option value="default">Default</option>
                <option value="stock_new">Stock New</option>
                <option value="stock_range">Stock Range</option>
                <option value="inspection">जिन्सी निरीक्षण फारम</option>
                <option value="stock">जिन्सी माैज्दातको वार्षिक विवरण</option>
                <option value="bin_card">Bin Card</option>
                <option value="stock_adjustment">Stock Adjustment</option>
                </select>
            </div>
             <div class="col-md-2" style="display: none;" id="stock_new_type">
                <label>Type</label>
                <select name="stock_new_type" class="form-control">
                    <option value="default">Default</option>
                    <option value="balance_only">Stock Only</option>
                    <option value="include_zero_stock">Include Empty Stock</option>
                    <!-- <option value="overall">Overall</option> -->
                </select>
            </div>

            <div class="col-md-2">
                <label>Print Orientation</label>
                <select name="page_orientation" class="form-control">
                    <option value="P">Portrait </option>
                    <option value="L">Landscape</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="reports/stock_report/get_search_stock_report"><?php echo $this->lang->line('search'); ?>
                </button>
            </div>
            </div>
        </div>
    </form>
</div>

<div class="clearfix"></div>

<div id="displayReportDiv"></div>
<script type="text/javascript">
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
      var item_marge=itemcode+'|'+itemname;
      $('#itemid').val(itemid);
      $('#itemname').val(item_marge);
      $('#myView').modal('hide');
    }
});

$(document).off('click','#clear');
$(document).on('click','#clear',function(e){
     $('#itemid').val('');
    $('#itemname').val('');
});

$(document).off('change','#rpt_type');
$(document).on('change','#rpt_type',function(e){
    let value =  $(this).val();
    if (value == 'stock_new') {
        $('#stock_new_type').show();
    }else{
        $('#stock_new_type').hide();
    }
});

</script>