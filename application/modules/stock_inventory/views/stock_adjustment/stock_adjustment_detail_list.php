<style type="text/css">
    table.dataTable tbody tr.selected {
        background-color: #B0BED9;
    }
    table.dataTable tbody tr.active {
        background-color: #B0BED9 !important;
    }
</style>
<!-- <h3 class="box-title">Stock Adjustment Detail List </h3> -->

<div class="searchWrapper">
    <div class="">
        <form>
             <div class="col-md-2">
                <label><?php echo $this->lang->line('date_search'); ?> :</label>
                <select name="searchDateType" id="searchDateType" class="form-control">
                    <option value="date_range">By Date Range</option>
                    <option value="date_all">All</option>
                </select>
            </div>
         <div class="dateRangeWrapper">
            <div class="col-md-2">
                <label><?php echo $this->lang->line('from_date'); ?></label>
                <input type="text" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
            </div>
             <div class="col-md-2">
                <label><?php echo $this->lang->line('to_date'); ?></label>
                <input type="text" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
            </div>
            </div>

            <div class="col-md-3">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
        </form>
    </div>
    <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="stock_inventory/stock_adjustment/stock_adjustment_details_list" data-location="stock_inventory/stock_adjustment/details_exportToExcel/<?php echo $masterid ?>" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="stock_inventory/stock_adjustment/stock_adjustment_details_list" data-location="stock_inventory/stock_adjustment/details_generate_pdf/<?php echo $masterid ?>" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>
    <div class="clear"></div>
</div>
<div class="pad-5">
    <div class="table-responsive">
        <table id="myTable" class="table table-striped">
            <thead>
                <tr>
                    <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('item_code'); ?></th>
                    <th width="15%"><?php echo $this->lang->line('item_name'); ?></th> 
                    <th width="10%"><?php echo $this->lang->line('stock_date_bs'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('stock_date_ad'); ?></th>
                    <th width="15%"><?php echo $this->lang->line('posted_by'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('remarks'); ?></th>
                    <th width="15%"><?php echo $this->lang->line('amount'); ?></th>
                    
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
    var stde_stockmasterid = $('#stde_stockmasterid').val();
    var dataurl = base_url+"stock_inventory/stock_adjustment/stock_adjustment_details_list/" + stde_stockmasterid ;
    var message='';
        var searchDateType = $('#searchDateType').val();

        if (searchDateType == 'date_all') {
            frmDate = '';
            toDate = '';
        }

    var showview='<?php echo MODULES_VIEW; ?>'; //alert(showview);
    if(showview=='N')
    {
    message="<p class='text-danger'>Permission Denial</p>";
    }
    else
    {
    message="<p class='text-danger'>No Record Found!! </p>";
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
    "aTargets": [ 0, 7]
    }
    ],
    "aoColumns": [
    { "data": "sn"},
    { "data": "itli_itemcode" },
    { "data": "itli_itemname" },
    { "data": "stde_adjustdatebs"},
    { "data": "stde_adjustdatead" },
    { "data": "remarks" }, 
    { "data": "stde_postby" },
    { "data": "stde_adjustamount" },
    ],
    "fnServerParams": function (aoData) {
        aoData.push({ "name": "frmDate", "value": frmDate });
        aoData.push({ "name": "toDate", "value": toDate });
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
        {type: null},
        { type: "text" },
        { type: "text" },
        { type: "text" },
        { type: "text" },
        { type: "text" },
        { type: "text" },
        ]
    });

        $(document).on('click', '#searchByDate', function() {
            frmDate = $('#frmDate').val();
            toDate = $('#toDate').val();
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