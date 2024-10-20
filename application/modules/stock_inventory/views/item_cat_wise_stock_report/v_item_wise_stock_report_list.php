<div class="searchWrapper">
    <div class="">
        <form>
            <!-- <?php //echo $this->general->location_option(2,'locationid'); ?> -->
              <div class="col-md-2">
                <label><?php echo $this->lang->line('date_search'); ?> :</label>
                <select name="searchDateType" id="searchDateType" class="form-control">
                    <option value="date_range">By Date Range</option>
                    <option value="date_all">All</option>
                </select>
            </div>
         <div class="dateRangeWrapper">
            <div class="col-md-2">
                <label><?php echo $this->lang->line('from'); ?></label>
                <input type="text" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
            </div>

            <div class="col-md-2">
                <label><?php echo $this->lang->line('to'); ?></label>
                <input type="text" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
            </div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-12">
                <label for="example-text"><?php echo $this->lang->line('select_category'); ?> <span class="required">*</span>:</label>
                <select name="material_id" class="form-control select2" id="material_id">
                    <option value="">---All---</option>
                    <?php
                    if($report_type):
                    foreach ($report_type as $km => $dep):
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
                <select name="store_id" class="form-control select2" id="store_id">
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
          
            <div class="col-md-3">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
        </form>
    </div>
    <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="stock_inventory/item_catwise_stock_report/exportToExcel" data-location="stock_inventory/item_catwise_stock_report/exportToExcel" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="stock_inventory/item_catwise_stock_report/generate_pdf" data-location="stock_inventory/item_catwise_stock_report/generate_pdf" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>

   

    <div class="clear"></div>
</div>

<div class="pull-right">
   
   <a class="btn btn-info generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="stock_inventory/item_catwise_stock_report/generate_pdf_form" data-location="stock_inventory/item_catwise_stock_report/generate_pdf_form" data-tableid="#myTable">निरिक्षण फारम </a>

       <a class="btn btn-info generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="stock_inventory/item_catwise_stock_report/generate_pdf_bibaran" data-location="stock_inventory/item_catwise_stock_report/generate_pdf_bibaran" data-tableid="#myTable">मौज्दात को वार्षिक विवरण </a>
    </div>

  

<div class="clearfix"></div>

<div class="pad-5">
    <div class="table-responsive">
        <table id="myTable" class="table table-striped serverDatatable" data-tableid="#myTable">
            <thead>
                <tr>
                    <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="10%"><?php echo $this->lang->line('code'); ?></th>
            <th width="15%"><?php echo $this->lang->line('item_name'); ?></th>
            <th width="10%"><?php echo $this->lang->line('unit'); ?></th>
            <th width="5%">Op. Qty</th>
            <th width="5%">Op. Amt</th>
            <th width="5%"><?php echo $this->lang->line('rec_qty'); ?></th>
            <th width="5%"><?php echo $this->lang->line('rec_amt'); ?></th>
            <th width="5%"><?php echo $this->lang->line('issue_qty'); ?> </th>
            <th width="5%"><?php echo $this->lang->line('issue_amt'); ?></th>
            <th width="10%"><?php echo $this->lang->line('bal_qty'); ?></th>
            <th width="10%"><?php echo $this->lang->line('bal_amt'); ?></th>


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
        var store_id = $('#store_id').val();
        var material_id = $('#material_id').val();
        var searchDateType = $('#searchDateType').val();

        if (searchDateType == 'date_all') {
            frmDate = '';
            toDate = '';
        }

        //var locationid = $('#locationid').val();
        // var frmDate = '';
        // var toDate = '';

        var tableid = $('.serverDatatable').data('tableid');

        // var firstTR = $(tableid+' tbody tr:first');
        // firstTR.addClass('selected');

        var dataurl = base_url + "stock_inventory/item_catwise_stock_report/item_cat_wise_report";
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
                "aTargets": [0]
            }],
            "aoColumns": [
                { "data": "sno" },
                { "data": "itli_itemcode" },
                { "data": "itli_itemname" },
                { "data": "unit_unitname" },
                { "data": "opqty" },
                { "data": "opamount" },
                { "data": "rec_qty" },
                { "data": "recamount" },
                { "data": "issQty" },
                { "data": "isstamt" },
                
                { "data": "balanceqty" },
                //{ "data": "rate" },
                { "data": "balanceamt" },
                
            ],
            "fnServerParams": function(aoData) {
                    aoData.push({"name": "frmDate","value": frmDate});
                    aoData.push({"name": "toDate","value": toDate});
                    //aoData.push({"name": "locationid","value": locationid});
                    aoData.push({"name": "store_id","value": store_id});
                    aoData.push({"name": "material_id","value": material_id});


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
                // $(nRow).addClass('view');
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
            store_id = $('#store_id').val();
            material_id = $('#material_id').val();
             searchDateType = $('#searchDateType').val();

            if (searchDateType == 'date_all') {
                frmDate = '';
                toDate = '';
            }


            //locationid = $('#locationid').val();
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

          $(document).off('change', '#searchDateType');
       $(document).on('change', '#searchDateType', function() {
        var search_date_val = $(this).val();

        if (search_date_val == 'date_all') {
            $('.dateRangeWrapper').hide();
        } else {
            $('.dateRangeWrapper').show();
        }
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
