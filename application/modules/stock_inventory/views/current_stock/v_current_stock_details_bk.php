<div class="searchWrapper">
    <div class="">
        <form>
            <?php echo $this->general->location_option(2,'locationid'); ?>
            <div class="col-md-3 col-sm-4">
                <label for="example-text"><?php echo $this->lang->line('store_type'); ?>:<span class="required">*</span>:</label>
                <select id="store_id" name="store_id"  class="form-control" >
                    <option value="">---select---</option>
                    <?php 
                        if($store_type):
                            foreach ($store_type as $km => $dep):  //print_r($store_type);die;
                    ?>
                     <option value="<?php echo $dep->st_store_id; ?>"><?php echo $dep->st_name; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </select>
            </div>
            <div class="col-md-3 col-sm-4">
                <label for="example-text"><?php echo $this->lang->line('level'); ?>:<span class="required">*</span>:</label>
                <select id="rrt" name="store_rrid"  class="form-control" >
                    <option value="">---select---</option>
                    <?php 
                        if($store_type):
                            foreach ($store_type as $km => $dep):  //print_r($store_type);die;
                    ?>
                     <option value="<?php echo $dep->st_store_id; ?>"><?php echo $dep->st_name; ?></option>
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
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="stock_inventory/current_stock/search_current_stock_list" data-location="stock_inventory/current_stock/exportToExcel/details" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="stock_inventory/current_stock/search_current_stock_list" data-location="stock_inventory/current_stock/generate_details_pdf/details" data-tableid="#myTable"><i class="fa fa-print"></i></a>
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
					<th width="10%"><?php echo $this->lang->line('category'); ?></th> 
					<th width="10%"><?php echo $this->lang->line('type'); ?> </th>
					<th width="10%"><?php echo $this->lang->line('max_limit'); ?> </th>
                    <th width="8%"><?php echo $this->lang->line('reorder_level'); ?> </th>
                    <th width="7%"><?php echo $this->lang->line('at_stock'); ?> </th>
                    <th width="7%"><?php echo $this->lang->line('unit_price'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('unit'); ?> </th>
                    <th width="8%"><?php echo $this->lang->line('batch_no'); ?></th>
					<th width="5%"><?php echo $this->lang->line('expiry_date'); ?></th>
					<th width="10%"><?php echo $this->lang->line('amount'); ?></th> 
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
        var toDate = $('#toDate').val();
         var locationid = $('#locationid').val();
        var supplier = '';
        var items = '';

        var dataurl = base_url + "stock_inventory/current_stock/search_current_stock_details_list";
        var message = '';
        var showview = '<?php echo MODULES_VIEW; ?>';
        // alert(showview);
        // if (showview == 'N') {
        //     message = "<p class='text-danger'>Permission Denial</p>";
        // } else {
        //     message = "<p class='text-danger'>No Record Found!! </p>";
        // }

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
                "aTargets": [0, 10,11,12]
            }],
            "aoColumns": [
                { "data": "sno" },
                { "data": "itli_itemcode" },
                { "data": "itli_itemname" },
                { "data": "eqca_category" },
                { "data": "maty_material" },
                { "data": "itli_maxlimit" },
                { "data": "itli_reorderlevel" },
                { "data": "atstock" },
                { "data": "trde_unitprice" },
                { "data": "unit_unitname" },
                { "data": "batchno" },
                { "data": "trde_expdatebs" },
                { "data": "amount" },
               
            ],
            "fnServerParams": function(aoData) {
                    aoData.push({"name": "store_id","value": store_id});
                    aoData.push({"name": "toDate","value": toDate});
                     aoData.push({"name": "locationid","value": locationid});
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
                { type: "text" },
                { type: "text" },
                { type: "text" },
                { type: "text" },
                { type: null },
               
            ]
        });

        $(document).on('click', '#searchByDate', function() {
            store_id = $('#store_id').val();
            toDate = $('#toDate').val();
             locationid = $('#locationid').val();
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
