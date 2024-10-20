<div class="searchWrapper">
    <div class="">
        <form>
            <?php echo $this->general->location_option(2,'locationid'); ?>
            <div class="col-md-2 col-sm-4">
                <label for="example-text"><?php echo $this->lang->line('store_type'); ?>:<span class="required">*</span>:</label>
                <select id="store_id" name="store_id"  class="form-control " >
                    <option value="">---All---</option>
                    <?php 
                        if($store_type):
                            foreach ($store_type as $km => $dep):  //print_r($store_type);die;
                    ?>
                     <option value="<?php echo $dep->eqty_equipmenttypeid; ?>"><?php echo $dep->eqty_equipmenttype; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
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

            <div class="col-md-3 col-sm-4">
                <label><?php echo $this->lang->line('from_date'); ?></label>
                <input type="text" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
            </div>
            <div class="col-md-3 col-sm-4">
                <label><?php echo $this->lang->line('to_date'); ?></label>
                <input type="text" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
            </div>
            </div>

            <div class="col-md-2 col-sm-4">
               <label for="example-text"><?php echo $this->lang->line('item_name'); ?>:<span class="required">*</span>:</label>
                <select id="code_id" name="code_id"  class="form-control select2" >
                    <option value="">---select---</option>
                    <?php 
                        if($code):
                            foreach ($code as $km => $dep):  //print_r($store_type);die;
                    ?>
                     <option value="<?php echo $dep->itli_itemlistid; ?>"><?php echo $dep->itli_itemname; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </select>
            </div>

             <div class="col-md-2">
                <label>Print Orientation</label>
                <select name="page_orientation" id="page_orientation" class="form-control">
                    <option value="P">Portrait </option>
                    <option value="L">Landscape</option>
                </select>
            </div>
            <div class="col-md-2">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
        </form>
    </div>
    <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="stock_inventory/current_stock/search_current_stock_detail_list" data-location="stock_inventory/current_stock/exportToExcel" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="stock_inventory/current_stock/search_current_stock_detail_list" data-location="stock_inventory/current_stock/generate_details_pdf" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>

   

    <div class="clear"></div>
</div>

<div class="clearfix"></div>

<div class="pad-5 mtop_10">
    <h3 class="box-title"><?php echo $this->lang->line('current_stock_list'); ?></h3>
    <div class="table-responsive">
        <table id="myTable" class="table table-striped ">
            <thead>
                <tr>
                	<th width="5%"><?php echo $this->lang->line('sn'); ?></th>
					<th width="5%"><?php echo $this->lang->line('code'); ?></th>
					<th width="10%"><?php echo $this->lang->line('name'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('unit'); ?></th> 
					<th width="10%"><?php echo $this->lang->line('category'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('type'); ?></th>
					<th width="5%"><?php echo $this->lang->line('at_stock'); ?> </th>
                    <th width="5%"><?php echo $this->lang->line('unit_price'); ?> </th>
					<th width="5%"><?php echo $this->lang->line('total_amount'); ?> </th>
                    <th width="5%"><?php echo $this->lang->line('date'); ?> </th>
                    <th width="5%"><?php echo $this->lang->line('location'); ?> </th>
                    <th width="5%"><?php echo $this->lang->line('transaction_type'); ?> </th> 
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
        var store_id = $('#store_id').val();
        var frmDate=$('#frmDate').val();
        var toDate=$('#toDate').val();
        var locationid = $('#locationid').val();
        var searchDateType = $('#searchDateType').val();

        if (searchDateType == 'date_all') {
            frmDate = '';
            toDate = '';
        }
        var code_id = $('#code_id').val();
        var supplier = '';
        var items = '';

        var dataurl = base_url + "stock_inventory/current_stock/search_current_stock_detail_list";
        var message = '';
        var showview = '<?php echo MODULES_VIEW; ?>';
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
                [0, 'asc']
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
                { "data": "itemcode" },
                { "data": "itemname" },
                { "data": "unit" },
                { "data": "category" },
                { "data": "material" },
                { "data": "stock_qty" },
                { "data": "trde_unitprice" },
                { "data": "toal_amount" },
                { "data": "tran_date" },
                { "data": "location" },
                { "data": "trans_type" }
               
            ],
            "fnServerParams": function(aoData) {
                    aoData.push({"name": "store_id","value": store_id});
                    aoData.push({ "name": "frmDate", "value": frmDate });
                    aoData.push({ "name": "toDate", "value": toDate });
                    aoData.push({"name": "locationid","value": locationid});
                    aoData.push({"name": "code_id","value": code_id});
                    aoData.push({"name": "supplier","value": supplier});
                    aoData.push({"name": "items","value": items});
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
                { type: null },
                { type: "text" },
                { type: "text" },
                { type: "text" }
               
            ]
        });

        $(document).on('click', '#searchByDate', function() {
            store_id = $('#store_id').val();
            frmDate = $('#frmDate').val();
            toDate = $('#toDate').val();
            locationid = $('#locationid').val();
             searchDateType = $('#searchDateType').val();

            if (searchDateType == 'date_all') {
                frmDate = '';
                toDate = '';
            }
            code_id=$('#code_id').val();
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
