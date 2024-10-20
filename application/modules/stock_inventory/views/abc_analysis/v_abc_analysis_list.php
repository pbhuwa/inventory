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
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="stock_inventory/abc_analysis/abc_analysis_list" data-location="stock_inventory/abc_analysis/exportToExcel" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="stock_inventory/abc_analysis/abc_analysis_list" data-location="stock_inventory/abc_analysis/generate_pdf" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>

   

    <div class="clear"></div>
</div>

<div class="clearfix"></div>

<div class="pad-5 mtop_10">
    <!-- <h3 class="box-title">Stock Check List</h3> -->
    <div class="table-responsive">
        <table id="myTable" class="table table-striped serverDatatable" data-tableid="#myTable">
            <thead>
                <tr>
                    <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('item_code'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('item_name'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('category'); ?></th>
                    <!--  <th width="10%">Sale Rate</th> -->
                    <th width="10%"><?php echo $this->lang->line('sold_quantity'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('total_amount'); ?></th>
                    <!-- <th width="10%">Class </th> -->
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
        // var frmDate = '';
        // var toDate = '';

        var tableid = $('.serverDatatable').data('tableid');

        // var firstTR = $(tableid+' tbody tr:first');
        // firstTR.addClass('selected');

        var dataurl = base_url + "stock_inventory/abc_analysis/abc_analysis_list";
        var message = '';
        var showview = '<?php echo MODULES_VIEW; ?>';
        // alert(showview);
        if (showview == 'N') {
            message = "<p class='text-danger'>Permission Denial</p>";
        } else {
            message = "<p class='text-danger'>No Record Found!! </p>";
        }

        // $(tableid).on("draw.dt", function(){
        //     var rowsNext = $(tableid).dataTable().$("tr:first");
        //     rowsNext.addClass("selected");
        // });

        var dtablelist = $(tableid).dataTable({
            "sPaginationType": "full_numbers",

            "bSearchable": false,
            "lengthMenu": [
                [20, 30, 45, 60, 100, 200, 500, -1],[20, 30, 45, 60, 100, 200, 500, "All"]
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
                "aTargets": [0, 5]
            }],
            "aoColumns": [
                { "data": "sno" },
                { "data": "itli_itemcode" },
                { "data": "itli_itemname" },
                { "data": "eqca_category" },
                { "data": "total_issue_qty" },
                { "data": "TotalIsseAmt" }
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
                var viewurl =aData.viewurl;
                var prime_id=aData.prime_id;
                var heading=aData.departmentname;

                var oSettings = dtablelist.fnSettings();
                var tblid = oSettings._iDisplayStart + iDisplayIndex + 1;

                var tbl_id = iDisplayIndex + 1;

                $(nRow).attr('id', 'listid_' + tblid);

                $(nRow).attr('data-rowid',tbl_id);
                $(nRow).attr('data-viewurl',viewurl);
                $(nRow).attr('data-id',prime_id);
                $(nRow).attr('data-heading',heading);
                //$(nRow).addClass('view');
            },
            // initComplete:function(){
            //     $(tableid+' tbody tr:eq(0)').addClass('selected');
            // },
        }).columnFilter({
            sPlaceHolder: "head:after",
            aoColumns: [
                { type: null },
                { type: "text" },
                { type: "text" },
                { type: "text" },
                { type: null },
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

        $(document).on('click', '.serverDatatable tbody tr', function() {
            // console.log(tableid);
            var selectedTR = $(tableid).find('.selected');

            var dtablelist = $(tableid).dataTable();
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
                prime_id = 0;
            } else {
                dtablelist.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                prime_id = dtablelist.api().row(this).data().prime_id;
            }
            // console.log(prime_id);
        });

        $(document).off('keydown');
        $(document).on('keydown',function(){        
            selectedTR = $(tableid).find('.selected');
           
            var rowid = selectedTR.data('rowid');
            var numRow = selectedTR.data('numRow');
            var numTR = $(tableid+' tr').length-1;

            var keypressed = event.keyCode;
            // console.log(keypressed);

            if(keypressed == '40' && rowid < numTR){
                selectedTR.removeClass('selected');
                nextTR = selectedTR.next('tr');

                nextTR.addClass('selected');
                req_masterid = nextTR.data('masterid');
                setTimeout(function(){
                    nextTR.focus();
                }, 100);
            }

            if(keypressed == '38' && rowid != '1'){
                selectedTR.removeClass('selected');
                prevTR = selectedTR.prev('tr');

                prevTR.addClass('selected');
                req_masterid = prevTR.data('masterid');
                setTimeout(function(){
                    prevTR.focus();
                }, 100);
            }

            if(keypressed == '13'){
                selectedTR.click();
                // console.log( $(this).closest('tr').attr('id'));
                selectedTR.addClass('selected');
            }
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
