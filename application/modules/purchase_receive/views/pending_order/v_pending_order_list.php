<div class="searchWrapper">
    <div class="">
        <form>
            
        </form>
    </div>
    <div class="pull-left">
       <!--  <a href="<?php echo base_url('purchase_receive/pending_order_detail');?>" class="btn btn-primary"><?php echo $this->lang->line('pending_order_detail'); ?></a> -->
    </div>
    <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="purchase_receive/pending_order/pending_order_list" data-location="purchase_receive/pending_order/exportToExcel" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="purchase_receive/pending_order/pending_order_list" data-location="purchase_receive/pending_order/generate_pdf" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>

   

    <div class="clear"></div>
</div>

<div class="clearfix"></div>

<div class="pad-5 mtop_10">
    <!-- <h3 class="box-title">Pending Order List</h3> -->
    <div class="table-responsive">
        <table id="myTable" class="table table-striped serverDatatable" data-tableid="#myTable">
            <thead>
                <tr>
                    <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="30%"><?php echo $this->lang->line('supplier_name'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('delivery_date'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('order_no'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('order_date'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('delivery_site'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('order_amount'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('approved'); ?></th>
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
        var prime_id = '';
        var tableid = $('.serverDatatable').data('tableid');

        var dynamicColumn = <?php echo $dynamicColumn; ?>

        var dtable_url = "<?php echo $dtable_url; ?>";

        var a_targets = "<?php echo $a_targets;?>";

        var firstTR = $('#myTable tbody tr:first');
        firstTR.addClass('selected');

        // var frmDate = $('#frmDate').val();
        // var toDate = $('#toDate').val();
        var frmDate = '';
        var toDate = '';

        var searchByStore = '';
        var above_maxlimit = '';
        var below_reorder = '';

        var dataurl = base_url + dtable_url;
        var message = '';
        var showview = '<?php echo MODULES_VIEW; ?>';
        // alert(showview);
        if (showview == 'N') {
            message = "<p class='text-danger'>Permission Denial</p>";
        } else {
            message = "<p class='text-danger'>No Record Found!! </p>";
        }


        $(tableid).on("draw.dt", function(){
            var rowsNext = $(tableid).dataTable().$("tr:first");
            rowsNext.addClass("selected");
        });

        var dtablelist = $(tableid).dataTable({
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
                "aTargets": [0, a_targets]
            }],
            "aoColumns": dynamicColumn,
            "fnServerParams": function(aoData) {
                    aoData.push({"name": "frmDate","value": frmDate});
                    aoData.push({"name": "toDate","value": toDate});
            },
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                var oSettings = dtablelist.fnSettings();
                $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
                return nRow;
            },
            "fnCreatedRow": function(nRow, aData, iDisplayIndex) {
                // console.log(aData);
                var viewurl =aData.viewurl;
                var prime_id=aData.prime_id;
                var suppliers=aData.suppliers;
                var oSettings = dtablelist.fnSettings();
                var tblid = oSettings._iDisplayStart + iDisplayIndex + 1;

                var tbl_id = iDisplayIndex + 1;

                $(nRow).attr('id', 'listid_' + tblid);
                $(nRow).attr('data-rowid',tbl_id);
                $(nRow).attr('data-viewurl',viewurl);
                $(nRow).attr('data-id',prime_id);
                $(nRow).attr('data-heading',suppliers);
                $(nRow).addClass('view');
            },
            initComplete:function(){
                $(tableid+' tbody tr:eq(0)').addClass('selected');
            },
        }).columnFilter({
            sPlaceHolder: "head:after",
            aoColumns: [
                { type: null },
                { type: "text" },
                { type: "text" },
                { type: "text" },
                { type: "text" },
                { type: null },
                { type: null },
            ]
        });

        // var info = dtablelist.page.info();

        // console.log(info.page);
        // return false;

        $(document).on('click', '#searchByDate', function() {
            frmDate = $('#frmDate').val();
            toDate = $('#toDate').val();
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