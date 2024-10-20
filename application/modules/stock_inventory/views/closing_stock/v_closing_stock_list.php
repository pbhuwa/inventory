<style type="text/css">
    table.dataTable tbody tr.selected {
        background-color: #B0BED9;
    }
    table.dataTable tbody tr.active {
        background-color: #B0BED9 !important;
    }
</style>
<div class="searchWrapper">
    <div class="">
        <form>
            <?php echo $this->general->location_option(2,'locationid'); ?>
            <div class="col-md-2">
                <label><?php echo $this->lang->line('store'); ?></label>
                <select class="form-control storeType" name="" autofocus="true" id="equipmenttypeid">
                    <option value="">-----All-----</option>
                    <?php
                    if($equipmnt_type): 
                    foreach ($equipmnt_type as $ket => $etype): ?>
                    <option value="<?php echo $etype->eqty_equipmenttypeid; ?>" ><?php echo $etype->eqty_equipmenttype; ?></option>
                    <?php endforeach; endif; ?>
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

            <div class="col-md-2">
                <label><?php echo $this->lang->line('date'); ?></label>
                <select class="form-control storeType" name="clsm_csmasterid" autofocus="true" id="masterid">
                    <option value="">----------All---------</option>
                    <?php
                    if($closing_details): 
                    foreach ($closing_details as $ket => $etype): ?>
                    <option value="<?php echo $etype->clsm_csmasterid; ?>" ><?php echo $etype->clsm_fromdatebs; ?>  - <?php echo $etype->clsm_todatead; ?></option>
                    <?php endforeach; endif; ?>
                </select>
            </div>
            </div>
          <!--   <div class="col-md-5">
                <label for="">&nbsp;</label>
                <select class="form-control" name="closingmaster" id="closingmasterid">
                </select>
            </div> -->
            <div class="col-md-3">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
        </form>
    </div>
     <div class="pull-right" style="margin-top:15px;">
        <!-- <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="stock_inventory/stock_transfer/" data-location="stock_inventory/closing_stock/closing_stock_details_pdf" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a> -->

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="stock_inventory/stock_transfer/" data-location="stock_inventory/closing_stock/closing_stock_details_pdf" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>
    <div class="clear"></div>
</div>
<div class="pad-5">
    <div class="table-responsive">
        <table id="myTable" class="table table-striped">
            <thead>
                <tr>
                    <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="5%">Itemcode</th>
                    <th width="5%">Equipmenttype</th>
                    <th width="10%">Item Name</th>
                    <th width="5%">Unit Name</th>
                    <th width="3%">Purchased Qty</th>
                    <th width="3%">Purchased Value</th>
                    <th width="3%">Purchase Ret. Value</th>
                    <th width="5%">Issue Qty</th>
                    <th width="5%">Issue Value</th>
                    <th width="5%">Issue Purchse Value</th>
                    <th width="5%">Sales Ret. Qty</th>
                    <th width="5%">Sales Ret. Value</th>
                    <th width="5%">Sales Ret. Pur. Val</th>
                    <th width="5%">Stock Qty</th>
                    <th width="5%">Stock Value</th>
                    <th width="5%">Issue Qty</th>
                    <th width="5%">Issue Amt</th>
                    <th width="5%">Received Qty</th>
                    <th width="5%">Received Amt</th>
                    <th width="5%">Opening Qty</th>
                    <th width="5%">Opening Amt</th>
                    <th width="5%">Current Opening Qty</th>
                    <th width="5%">Current Opening Amt</th>
                    <th width="5%">Transaction Qty</th>
                    <th width="5%">Transaction Value</th>
                    <th width="5%">Adj. Qty</th>
                    <th width="5%">Adj Value</th>
                    <th width="5%">Mtd. Qty</th>
                    <th width="5%">Con. Qty</th>
                    <th width="5%">Con. Value</th>
                    <th width="5%">Inc. Con. Qty</th>
                    <th width="5%">Return Qty</th>
                    <!-- <th width="5%">qty</th> -->
                    <th width="5%">Inc. Con. Value</th>
                    <th width="5%">Mtd. Value</th>
                    <th width="5%">Challan Qty</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    var frmDate=$('#frmDate').val();
    var toDate=$('#toDate').val();
    var locationid=$('#locationid').val();
    var masterid=$('#masterid').val();
    var equipmenttypeid=$('#equipmenttypeid').val();
     var searchDateType = $('#searchDateType').val();

        if (searchDateType == 'date_all') {
            frmDate = '';
            toDate = '';
        }

    var dataurl = base_url+"stock_inventory/closing_stock/closing_stock_lists";
    var message='';
    var showview='<?php echo MODULES_VIEW; ?>';

    
     if (showview == 'N') {
            message = "<p class='text-danger'>Permission Denial</p>";
        } else {
            message = "<p class='text-danger'>No Record Found!! </p>";
        }
    var dtablelist = $('#myTable').dataTable({
    "sPaginationType": "full_numbers"  ,

    "bSearchable": false,
    "lengthMenu": [[15, 30, 45, 60,100,200,500, -1], [15, 30, 45, 60,100,200,500, "All"]],
    'iDisplayLength': 20,
    "sDom": 'ltipr',
    "bAutoWidth":false,

    "autoWidth": true,
    "aaSorting": [[0,'desc']],
    "bProcessing":true,
    "bServerSide":true,
    "sAjaxSource":dataurl,
    "oLanguage": {
    "sEmptyTable":message
    },
    "aoColumnDefs": [
    {
    "bSortable": false,
    "aTargets": [ 0,35 ]
    }
    ],
    
    "aoColumns": [
        {"data":"sno"},
        {"data":"itli_itemcode"},
        {"data":"eqty_equipmenttype"},
        {"data":"itli_itemname"},
        {"data":"unit_unitname"},
        {"data":"csde_purchasedqty"},
        {"data":"csde_purchasedvalue"},
        {"data":"csde_preturnvalue"},
        {"data":"csde_soldqty"},
        {"data":"csde_soldvalue"},
        {"data":"csde_soldpurvalue"},
        {"data":"csde_sreturnqty"},
        {"data":"csde_sreturnvalue"},
        {"data":"csde_sreturnpvalue"},
        {"data":"csde_stockqty"},
        {"data":"csde_stockvalue"},
        {"data":"csde_issueqty"},
        {"data":"csde_issueamount"},
        {"data":"csde_receivedqty"},
        {"data":"csde_receivedamnt"},
        {"data":"csde_openingqty"},
        {"data":"csde_openingamt"},
        {"data":"csde_curopeningqty"},
        {"data":"csde_curopeningamt"},
        {"data":"csde_transactionqty"},
        {"data":"csde_transactionvalue"},
        {"data":"csde_adjqty"},
        {"data":"csde_adjvalue"},
        {"data":"csde_mtdqty"},
        {"data":"csde_conqty"},
        {"data":"csde_convalue"},
        {"data":"csde_incconqty"},
        {"data":"csde_returnqty"},
        //{"data":"purd_qty"},
        {"data":"csde_incconvalue"},
        {"data":"csde_mtdvalue"},
        {"data":"csde_challanqty"}
    ],
    "fnServerParams": function (aoData) {
        aoData.push({ "name": "frmDate", "value": frmDate });
        aoData.push({ "name": "toDate", "value": toDate });
         aoData.push({ "name": "locationid", "value": locationid });
         aoData.push({ "name": "equipmenttypeid", "value": equipmenttypeid });
         aoData.push({ "name": "masterid", "value": masterid });
         
    },
    "fnRowCallback" : function(nRow, aData, iDisplayIndex){
        var oSettings = dtablelist.fnSettings();
        $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
        return nRow;
    },
    "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {
        var oSettings = dtablelist.fnSettings();
        var tblid = oSettings._iDisplayStart+iDisplayIndex +1
        $(nRow).attr('id', 'listid_'+tblid);
    },
    }).columnFilter(
    {
        sPlaceHolder: "head:after",
        aoColumns: [ { type: null },
        {type: "text"},
        { type: "text" },
        { type: "text" },
        { type: null },
        { type: null },
        { type: null },
        { type: null },
        { type: null },
        ]
    });

        $(document).on('click', '#searchByDate', function() {
            frmDate = $('#frmDate').val();
            toDate = $('#toDate').val();
              locationid = $('#locationid').val();
              masterid=$('#masterid').val();
            equipmenttypeid=$('#equipmenttypeid').val();
               searchDateType = $('#searchDateType').val();

            if (searchDateType == 'date_all') {
                frmDate = '';
                toDate = '';
            }
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
         });


</script>