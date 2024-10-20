<div class="searchWrapper">
    <form id="purchase_receive_report_search_form">
        <div class="form-group">
            <div class="row">
                <?php echo $this->general->location_option(2, 'locationid'); ?>

                <div class="col-md-2">
                    <label><?php echo $this->lang->line('date_search'); ?> :</label>
                    <select name="searchDateType" id="searchDateType" class="form-control">
                        <option value="date_range">By Date Range</option>
                        <option value="date_all">All</option>
                    </select>
                </div>

                <div class="dateRangeWrapper">
                    <div class="col-md-2">
                        <label><?php echo $this->lang->line('from_date'); ?> :</label>
                        <input type="text" name="frmDate" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>" />
                    </div>

                    <div class="col-md-2">
                        <label><?php echo $this->lang->line('to_date'); ?>:</label>
                        <input type="text" id="toDate" name="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>" />
                    </div>
                </div>
                <div class="col-md-2 col-sm-4">
                    <label for="example-text"><?php echo $this->lang->line('store_type'); ?> <span class="required"> * </span>:</label>
                    <select id="store_id" name="store_id" class="form-control required_field">
                        <option value="">---All---</option>
                        <?php
                        if ($store_type) :
                            foreach ($store_type as $km => $dep) :  //print_r($store_type);die;
                        ?>
                                <option value="<?php echo $dep->eqty_equipmenttypeid; ?>"><?php echo $dep->eqty_equipmenttype; ?></option>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <label><?php echo $this->lang->line('supplier_name'); ?></label>
                    <select class="form-control select2" name="supplierid" id="supplierid">
                        <option value="">All</option>
                        <?php
                        if ($supplier_all) :
                            foreach ($supplier_all as $ks => $supp) :
                        ?>
                                <option value="<?php echo $supp->dist_distributorid; ?>"><?php echo $supp->dist_distributor; ?></option>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="example-text">Choose Material Type : </label><br>
                    <select name="recm_mattypeid" id="mattypeid" class="form-control chooseMatType required_field">
                        <option value="">---All---</option>
                        <?php
                        if (!empty($material_type)) :
                            foreach ($material_type as $mat) :
                        ?>
                                <option value="<?php echo $mat->maty_materialtypeid; ?>"> <?php echo $mat->maty_material; ?></option>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>
                <div class="col-md-3 col-sm-3" style="display: none" id="received_by_div">
                    <label>Received By</label>
                    <select class="form-control select2" name="recm_receivedby">
                        <option value="">---All---</option>
                        <?php
                        $staff_info = $this->general->get_tbl_data('*', 'stin_staffinfo');
                        if (!empty($staff_info)) :
                            foreach ($staff_info as $ks => $sta) {
                        ?>
                                <option value="<?php echo $sta->stin_staffinfoid . ',' . $sta->stin_fname . ' ' . $sta->stin_mname . ' ' . $sta->stin_lname ?>"><?php echo $sta->stin_fname . ' ' . $sta->stin_mname . ' ' . $sta->stin_lname ?></option>
                        <?php
                            }
                        endif
                        ?>
                    </select>
                </div>


                <div class="col-md-2">
                    <label>Report Type</label>
                    <select name="rpt_type" class="form-control">
                        <option value="summary">Summary</option>
                        <option value="detail">Detail</option>
                    </select>
                </div>


                <div class="col-md-2">
                    <label>Report Wise</label>
                    <select name="rpt_wise" class="form-control" id="rpt_wise">
                        <option value="default">Default</option>
                        <option value="invoice_wise">Invoice Wise</option>
                        <option value="receiver">Receiver</option>
                        <option value="supplier">Supplier</option>
                        <option value="item">Item </option>
                        <option value="department">Department/Subdep</option>
                        <option value="received_date">Received Date</option>
                        <option value="bill_date">Bill Date</option>
                        <option value="material_type">Material Type</option>

                    </select>
                </div>
                <div class="col-md-2" id="itemdiv" style="display: none;">
                    <label>Item</label>
                    <div class="dis_tab">   
                    <input type="text" class="form-control" name="itemname" id="itemname" value="">
                    <input type="hidden" name="itemid" id="itemid" value="">
                    <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view btnitem" data-heading="Item List" data-viewurl="<?php echo base_url('stock_inventory/item_life_cycle/list_of_item'); ?>"><strong>...</strong></a>
                     <a href="javascript:void(0)" class="table-cell width_30" style="font-size: 16px;font-weight: bold;color: #ea2d2d;" title="Clear" id="clear"> X </a>
                    </div>
                </div>


                <div class="col-md-2">
                    <label>Print Orientation</label>
                    <select name="page_orientation" class="form-control">
                        <option value="P">Portrait </option>
                        <option value="L">Landscape</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="reports/purchase_received_report/get_search_purchase_received_report"><?php echo $this->lang->line('search'); ?></button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="clearfix"></div>

<div id="displayReportDiv"></div>



<script type="text/javascript">
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
 
    $(document).ready(function(e) {
        var matType = $("#mattypeid").val();
        var materialtypeid = parseInt(matType);
        if (materialtypeid == '2') {
            $('#received_by_div').show();
        } else {
            $('#received_by_div').hide();
        }
        $('#orderload').attr('data-id', matType);
        $('#orderload').data('id', matType);

    })

    $(document).off('change', '.chooseMatType,#fiscalyear');
    $(document).on('change', '.chooseMatType,#fiscalyear', function() {
        var matType = $('.chooseMatType').val();
        var materialtypeid = parseInt(matType);
        if (matType == '2') {
            $('#received_by_div').show();
        } else {
            $('#received_by_div').hide();
        }
    });
</script>


<script type="text/javascript">
    $(document).off('change','#rpt_wise');
    $(document).on('change','#rpt_wise',function(e){
        var rpt_wise=$(this).val();
        // alert(rpt_wise);
        // return false;
        if(rpt_wise=='item'){
            $('#itemdiv').show();
        }else{
            $('#itemdiv').hide();
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
</script>