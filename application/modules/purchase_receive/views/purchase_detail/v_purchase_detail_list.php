<div class="searchWrapper">
    <div class="">
        <form>
             <?php echo $this->general->location_option(2,'locationid'); ?>
         <div class="col-md-2">
                <label><?php echo $this->lang->line('from'); ?></label>
                <input type="text" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
            </div>

            <div class="col-md-2">
                <label><?php echo $this->lang->line('to'); ?></label>
                <input type="text" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
            </div>

            <div class="col-md-3">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
        </form>
    </div>
    <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="purchase_receive/purchase_detail" data-location="purchase_receive/purchase_detail/exportToExcelList" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="purchase_receive/purchase_detail" data-location="purchase_receive/purchase_detail/generate_pdfList" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>
    <div class="clear"></div>
</div>
<div class="clearfix"></div>
<div class="pad-5 mtop_10">
    <!-- <h3 class="box-title"><?php // echo $this->lang->line('purchase_detail_list'); ?></h3> -->
    <div class="table-responsive">
        <table id="myTable" class="table table-striped ">
            <thead>
                <tr>
                    <th width="3%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('date'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('invoice_no'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('bill_no'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('item_code'); ?></th>
                    <th width="20%" style="min-width: 200px;"><?php echo $this->lang->line('item_name'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('material_type'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('category'); ?></th>
                    <th width="15%" style="min-width: 180px;"><?php echo $this->lang->line('supplier_name'); ?></th>
                    <th width="3%"><?php echo $this->lang->line('order_no'); ?></th>
                    <th width="3%"><?php echo $this->lang->line('qty'); ?></th>
                    <th width="3%"><?php echo $this->lang->line('unit'); ?></th>
                    <th width="3%"><?php echo $this->lang->line('rate'); ?></th>
                    <th width="3%"><?php echo $this->lang->line('dis'); ?></th>
                    <th width="3%"><?php echo $this->lang->line('vat'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('net_rate'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('net_amount'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('description'); ?></th>
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
         var locationid=$('#locationid').val();

        var searchByStore = '';
        var above_maxlimit = '';
        var below_reorder = '';

        var dataurl = base_url + "purchase_receive/purchase_detail/purchase_detail_list";
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
                "aTargets": [0, 15,17]
            }],
            "aoColumns": [
                { "data": "sno" },
                { "data": "date" },
                { "data": "inv_no" },
                { "data": "bill_no" },
                { "data": "item_code" },
                { "data": "item_name" },
                { "data": "mat_type" },
                { "data": "category" },
                { "data": "supplier" },
                { "data": "order_no" },
                { "data": "qty" },
                { "data": "unit" },
                { "data": "rate" },
                { "data": "discount_pc" },
                { "data": "vat_pc" },
                { "data": "net_rate" },
                { "data": "net_amt" },
                { "data": "desc" },
            ],
            "fnServerParams": function(aoData) {
                    aoData.push({"name": "frmDate","value": frmDate});
                    aoData.push({"name": "toDate","value": toDate});
                     aoData.push({"name": "locationid","value": locationid});
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
                
                { type: null },
                { type: null },
            ]
        });

        $(document).on('click', '#searchByDate', function() {
            frmDate = $('#frmDate').val();
            toDate = $('#toDate').val();
             locationid=$('#locationid').val();
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
