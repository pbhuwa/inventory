<div class="pad-5 mtop_10">
    <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="purchase_receive/debit_note/cancel_order_list" data-location="purchase_receive/debit_note/exportToExcel" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="purchase_receive/debit_note/debit_order_list" data-location="purchase_receive/debit_note/generate_pdf" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>
    <div class="clearfix"></div>
    <div class="table-responsive">
        <table id="myTable" class="table table-striped ">
            <thead>
                <tr>
                    <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('return_no'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('date'); ?></th>
                    <th width="15%"><?php echo $this->lang->line('supplier_name'); ?></th>
                    <th width="15%"><?php echo $this->lang->line('sub_total'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('discount'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('vat_amount'); ?></th> 
                    <th width="15%"><?php echo $this->lang->line('return_by'); ?></th>
                     <th width="10%"><?php echo $this->lang->line('net_amount'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('time'); ?></th>
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
        var frmDate = $('#frmDate').val();
        var toDate = $('#toDate').val();
        var fyear = $('#fyear').val();
        var store_id = $('#store_id').val();


        // var frmDate = '';
        // var toDate = '';

        var supplier = '';
        var items = '';

        var dataurl = base_url + "purchase_receive/debit_note/debit_order_list";
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
                "aTargets": [0, 9]
            }],
            "aoColumns": [
                { "data": "sno" },
                { "data": "purr_returnno" },
                { "data": "purr_returndatebs" },
                { "data": "dist_distributor" },
                { "data": "purr_returnamount" },
                { "data": "purr_discount" },
                { "data": "purr_vatamount" },
                { "data": "purr_returnby" },
                { "data": "netamount" },
                { "data": "purr_returntime" },
                // { "data": "recm_posttime" } 
                
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
                { type: null },
                { type: null },
            ]
        });

        $(document).on('click', '#searchByDate', function() {
            frmDate = $('#frmDate').val();
            toDate = $('#toDate').val();
            fyear = $('#fyear').val();
            store_id = $('#store_id').val();
            dtablelist.fnDraw();
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
