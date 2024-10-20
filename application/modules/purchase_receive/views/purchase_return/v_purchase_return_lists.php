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
            <div class="col-md-2 col-sm-3 col-xs-12">
                <label for="example-text"><?php echo $this->lang->line('from_date'); ?> : </label>
                <input type="text" name="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Dispatch Date" value="<?php echo CURMONTH_DAY1;?>" id="frmDate">
                <span class="errmsg"></span>
            </div>

            <div class="col-md-2 col-sm-3 col-xs-12">
                <label for="example-text"><?php echo $this->lang->line('to_date'); ?> : </label>
                <input type="text" name="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Dispatch To" value="<?php echo DISPLAY_DATE;?>" id="toDate">
                <span class="errmsg"></span>
            </div>
            </div>

             <div class="col-md-2">
                <label>Print Orientation</label>
                <select name="page_orientation" id="page_orientation" class="form-control">
                    <option value="P">Portrait </option>
                    <option value="L">Landscape</option>
                </select>
            </div>

            <div class="col-md-3">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
        </form>
    </div>
    
    <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="purchase_receive/purchase_return/get_purchase_return_item_list" data-location="purchase_receive/purchase_return/exportToExcelDetails" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="purchase_receive/purchase_return/get_purchase_return_item_list" data-location="purchase_receive/purchase_return/generate_pdfDetails" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>
    <div class="clear"></div>
</div>

<div class="clearfix"></div>

<div class="pad-5 mtop_10">
    <div class="table-responsive">
        <table id="myTable" class="table table-striped ">
            <thead>
                <tr>
                    <th width="3%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('receive_no'); ?></th>
                    <th width="3%"><?php echo $this->lang->line('fiscal_year'); ?></th>
                    <th width="20%"><?php echo $this->lang->line('supplier'); ?></th>
                    <th width="6%"><?php echo $this->lang->line('return_date_bs'); ?></th>
                    <th width="6%"><?php echo $this->lang->line('return_date_ad'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('invoice_no'); ?></th> 
                    <th width="5%"><?php echo $this->lang->line('return_no'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('discount'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('vat_amount'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('amount'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('return_by'); ?></th>
                </tr>
            </thead>
            <tbody>   
            </tbody>
        </table>
    </div>
</div>

<div class="clearfix"></div>

<div class="col-sm-12">
    <div  class="alert-success success"></div>
    <div class="alert-danger error"></div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var frmDate=$('#frmDate').val();
        var toDate=$('#toDate').val();
        var fyear = $('#fyear').val();
        var store_id = $('#store_id').val();
        var searchDateType = $('#searchDateType').val();

        if (searchDateType == 'date_all') {
            frmDate = '';
            toDate = '';
        }


        var supplier = '';
        var items = '';

        var dataurl = base_url + "purchase_receive/purchase_return/get_purchase_return_item_list";
        var message = '';
        var showview = '<?php echo MODULES_VIEW; ?>';
        // alert(showview);
        if (showview == 'N') {
            message = "<p class='text-danger'>Permission Denial</p>";
        } else {
            message = "<p class='text-danger'>No Record Found!! </p>";
        }


        var dtablelist = $('#myTable').dataTable({
            "sPaginationType": "full_numbers",

            "bSearchable": false,
            "lengthMenu": [
                [15, 30, 45, 60, 100, 200, 500, -1],[15, 30, 45, 60, 100, 200, 500, "All"]
            ],
            'iDisplayLength': 20,
            "sDom": 'ltipr',
            "bAutoWidth": false,

            "autoWidth": true,
            "aaSorting": [
                [0, 'desc']
            ],
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": dataurl,
            "oLanguage": {
                "sEmptyTable": message
            },
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [ 0,10 ]
            }],
            "aoColumns": [
                { "data": "sno" },
                { "data": "purr_receiptno" },
                { "data": "purr_fyear" },
                { "data": "dist_distributor" },
                { "data": "purr_returndatebs" },
                { "data": "purr_returndatead" },
                { "data": "purr_invoiceno" },  
                { "data": "purr_returnno" },
                { "data": "purr_discount" },
                { "data": "purr_vatamount" },
                { "data": "purr_returnamount" }, 
                { "data": "purr_returnby" },       
            ],

            "fnServerParams": function(aoData) {
                    aoData.push({"name": "frmDate","value": frmDate});
                    aoData.push({"name": "toDate","value": toDate});
                    aoData.push({"name": "store_id","value": store_id});
                    aoData.push({"name": "fyear","value": fyear});
            },
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                var oSettings = dtablelist.fnSettings();
                $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
                return nRow;
            },
            "fnCreatedRow": function(nRow, aData, iDisplayIndex) {
                var oSettings = dtablelist.fnSettings();
                var tblid = oSettings._iDisplayStart + iDisplayIndex + 1

                $(nRow).attr('id', 'listid_' + tblid);
            },

        }).columnFilter({
            sPlaceHolder: "head:after",
            aoColumns: [
                { type: null },
                { type: "text" },
                { type: "text" },
                { type: "text" },
                { type: "text" },
                { type: "text" },
                { type: "text" },
                { type: "text" },
                { type: "text" },
                { type: "text" },
                { type: "text" },
                { type: "text" }
            ]

        });

        $(document).on('click', '#searchByDate', function() {
             frmDate = $('#frmDate').val();
            toDate = $('#toDate').val();
            fyear = $('#fyear').val();
            store_id = $('#store_id').val();
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


        $(document).on('change', '#searchBySupplier', function() {
            supplier = $('#searchBySupplier').val();
            dtablelist.fnDraw();
        });

        $(document).on('change', '#searchByItems', function() {
            items = $('#searchByItems').val();
            dtablelist.fnDraw();
        });
    });
</script>

<script type="text/javascript">
    $('.engdatepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    });
    $('.nepdatepicker').nepaliDatePicker();
</script>