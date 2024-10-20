    <div class="searchWrapper">
    <div class="">
        <form>
             <?php echo $this->general->location_option(2,'locationid'); ?>
            <div class="col-md-2">
                <label><?php echo $this->lang->line('material_type'); ?></label>
                <select class="form-control" id="material_type">
                    <option value="">All</option>
                    <?php 
                        if(!empty($material_type)):
                            foreach($material_type as $type):
                    ?>
                    <option value="<?php echo !empty($type->maty_materialtypeid)?$type->maty_materialtypeid:'';?>"><?php echo !empty($type->maty_material)?$type->maty_material:'';?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </select>
            </div>

            <div class="col-md-2">
                <label><?php echo $this->lang->line('category_type'); ?></label>
                <select class="form-control" id="category_type">
                    <option value="">All</option>
                    <?php 
                        if(!empty($category)):
                            foreach($category as $type):
                    ?>
                    <option value="<?php echo !empty($type->eqca_equipmentcategoryid)?$type->eqca_equipmentcategoryid:'';?>"><?php echo !empty($type->eqca_category)?$type->eqca_category:'';?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </select>
            </div>

            <div class="col-md-2">
                <label><?php echo $this->lang->line('counter'); ?></label>
                <select class="form-control" id="counter">
                    <option value="">All</option>
                    <?php 
                        if(!empty($store_type)):
                            foreach($store_type as $type):
                    ?>
                    <option value="<?php echo !empty($type->eqty_equipmenttypeid)?$type->eqty_equipmenttypeid:'';?>"><?php echo !empty($type->eqty_equipmenttype)?$type->eqty_equipmenttype:'';?></option>
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
            <div class="col-md-2">
                <label><?php echo $this->lang->line('from_date'); ?></label>
                <input type="text" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
            </div>

            <div class="col-md-2">
                <label><?php echo $this->lang->line('to_date'); ?></label>
                <input type="text" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
            </div>
          </div>
            <div class="col-md-2">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
        </form>
    </div>
    <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="stock_inventory/non_exp_and_exp_items/non_exp_and_exp_items_list" data-location="stock_inventory/non_exp_and_exp_items/exportToExcel" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="stock_inventory/non_exp_and_exp_items/non_exp_and_exp_items_list" data-location="stock_inventory/non_exp_and_exp_items/generate_pdf" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>

   

    <div class="clear"></div>
</div>

<div class="clearfix"></div>
<div class="">
<!-- <div class="pad-5 mtop_10">
 -->    <!-- <h3 class="box-title">Stock Check List</h3> -->
    <div class="table-responsive">
        <table id="myTable" class="table table-striped serverDatatable" data-tableid="#myTable">
            <thead>
                <tr>
                    <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('receipt_no'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('date'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('fiscal_year'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('item_code'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('item_name'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('category'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('supplier_name'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('location'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('qty'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('rate'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('remarks'); ?></th>
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
         var searchDateType = $('#searchDateType').val();

        if (searchDateType == 'date_all') {
            frmDate = '';
            toDate = '';
        }


        var material_type = '';
        var category_type ='';
        var counter = '';

        var tableid = $('.serverDatatable').data('tableid');

        var dataurl = base_url + "stock_inventory/non_exp_and_exp_items/non_exp_and_exp_items_list";
        var message = '';
        var showview = '<?php echo MODULES_VIEW; ?>';
        // alert(showview);
        if (showview == 'N') {
            message = "<p class='text-danger'>Permission Denial</p>";
        } else {
            message = "<p class='text-danger'>No Record Found!! </p>";
        }

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
                "aTargets": [0, 11]
            }],
            "aoColumns": [
                { "data": "sno" },
                { "data": "receiptno" },
                { "data": "date" },
                { "data": "fyear" },
                { "data": "itemcode" },
                { "data": "itemname" },
                { "data": "categoryname" },
                { "data": "distributorname" },
                { "data": "location" },
                { "data": "qty" },
                { "data": "rate" },
                { "data": "remarks" },
            ],
            "fnServerParams": function(aoData) {
                    aoData.push({"name": "frmDate","value": frmDate});
                    aoData.push({"name": "toDate","value": toDate});
                     aoData.push({"name": "locationid","value": locationid});
                    aoData.push({"name": "material_type","value": material_type});
                    aoData.push({"name": "category_type","value": category_type});
                    aoData.push({"name": "counter","value": counter});
            },
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                var oSettings = dtablelist.fnSettings();
                $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
                return nRow;
            },
            "fnCreatedRow": function(nRow, aData, iDisplayIndex) {
                var viewurl =aData.viewurl;
                var prime_id=aData.prime_id;
                var heading=aData.itemname;

                var oSettings = dtablelist.fnSettings();
                var tblid = oSettings._iDisplayStart + iDisplayIndex + 1;

                var tbl_id = iDisplayIndex + 1;

                $(nRow).attr('id', 'listid_' + tblid);

                // $(nRow).attr('data-rowid',tbl_id);
                // $(nRow).attr('data-viewurl',viewurl);
                // $(nRow).attr('data-id',prime_id);
                // $(nRow).attr('data-heading',heading);
                // $(nRow).addClass('view');
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
            ]
        });

        $(document).on('click', '#searchByDate', function() {
            frmDate = $('#frmDate').val();
            toDate = $('#toDate').val();
             locationid = $('#locationid').val();
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

        $(document).on('change','#material_type',function(){
            material_type = $('#material_type').val()
            dtablelist.fnDraw();
        });

        $(document).on('change','#category_type',function(){
            category_type = $('#category_type').val()
            dtablelist.fnDraw();
        });

        $(document).on('change','#counter',function(){
            counter = $('#counter').val()
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
