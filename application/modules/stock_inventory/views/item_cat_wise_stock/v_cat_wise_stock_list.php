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
            <div class="col-md-2 col-sm-4 col-xs-12">
                <label for="example-text"><?php echo $this->lang->line('select_category'); ?> <span class="required">*</span>:</label>
                <select name="maty_materialtypeid" class="form-control select2" id="store_id">
                    <option value="">---All---</option>
                    <?php
                    if($material_type):
                    foreach ($material_type as $km => $dep):
                    ?>
                    <option value="<?php echo $dep->maty_materialtypeid; ?>"><?php echo $dep->maty_material; ?></option>
                    <?php
                    endforeach;
                    endif;
                    ?>
                </select>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-12">
                <label for="example-text"><?php echo $this->lang->line('store'); ?> <span class="required">*</span>:</label>
                <select name="maty_materialtypeid" class="form-control select2" id="store_id">
                    <option value="">---All---</option>
                    <?php
                    if($store_type):
                    foreach ($store_type as $km => $dep):
                    ?>
                    <option value="<?php echo $dep->eqty_equipmenttypeid; ?>"><?php echo $dep->eqty_equipmenttype; ?></option>
                    <?php
                    endforeach;
                    endif;
                    ?>
                </select>
            </div>
            <!-- <div class="col-md-2 col-sm-4 col-xs-12">
                <label for="example-text">Select Categories <span class="required">*</span>:</label>
                <select name="maty_materialtypeid" class="form-control select2" id="store_id">
                    <option value="">---All---</option>
                    <?php
                    if($materialstypecategory):
                    foreach ($materialstypecategory as $km => $dep):
                    ?>
                    <option value="<?php echo $dep->maty_materialtypeid; ?>"><?php echo $dep->maty_material; ?></option>
                    <?php
                    endforeach;
                    endif;
                    ?>
                </select>
            </div> -->
            <div class="col-md-3">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
        </form>
    </div>
    <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="stock_inventory/item_catwise_stock/item_catwise_stock_list" data-location="stock_inventory/item_catwise_stock/exportToExcel" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="stock_inventory/item_catwise_stock/item_catwise_stock_list" data-location="stock_inventory/item_catwise_stock/generate_pdf" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>

   

    <div class="clear"></div>
</div>

<div class="clearfix"></div>

<div class="pad-5 mtop_10">
    <div class="table-responsive">
        <table id="myTable" class="table table-striped serverDatatable" data-tableid="#myTable">
            <thead>
                <tr>
                    <!-- <th width="5%">S.No.</th>
                    <th width="5%">Code </th>
                    <th width="10%">Name</th>
                    <th width="10%">Unit</th>
                    <th width="5%">Opt Qyt</th>
                    <th width="10%">Opt Amnt</th>
                    <th width="10%">Rec Qty </th>
                    <th width="10%">Rec Amnt</th>
                    <th width="5%">Issue Qty</th>
                    <th width="10%">Issue Amnt</th>
                    <th width="10%">Bal Qty</th>
                    <th width="10%">Bal Amnt</th> -->

                    <th><?php echo $this->lang->line('sn'); ?></th>
                    <th><?php echo $this->lang->line('issue_no'); ?></th>
                    <th><?php echo $this->lang->line('department'); ?></th>
                    <th><?php echo $this->lang->line('transaction_date_ad'); ?></th>
                    <th><?php echo $this->lang->line('transaction_date_bs'); ?></th>
                    <th><?php echo $this->lang->line('from_by'); ?></th>
                    <th><?php echo $this->lang->line('received_by'); ?></th>
                    <th><?php echo $this->lang->line('amount'); ?></th>
                    <th><?php echo $this->lang->line('req_no'); ?></th>
  


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
        var locationid = $('#locationid').val();
        // var frmDate = '';
        // var toDate = '';

        var tableid = $('.serverDatatable').data('tableid');

        // var firstTR = $(tableid+' tbody tr:first');
        // firstTR.addClass('selected');

        var dataurl = base_url + "stock_inventory/stock_received/stock_received_list";
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
                "aTargets": [0, 8]
            }],
            "aoColumns": [
                { "data": "sno" },
                { "data": "issueno" },
                { "data": "departmentname" },
                { "data": "transactiondatead" },
                { "data": "transactiondatebs" },
                { "data": "fromby" },
                { "data": "receivedby" },
                { "data": "amount" },
                { "data": "reqno" },
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
                $(nRow).addClass('view');
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
                { type: null },
                { type: null },
                { type: "text" },
                { type: "text" },
            ]
        });

        $(document).on('click', '#searchByDate', function() {
            frmDate = $('#frmDate').val();
            toDate = $('#toDate').val();
            locationid = $('#locationid').val();
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
