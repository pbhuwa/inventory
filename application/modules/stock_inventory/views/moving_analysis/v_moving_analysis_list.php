<div class="searchWrapper">
    <div class="">
        <form>
            <?php echo $this->general->location_option(2,'locationid'); ?>
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

            <div class="col-md-3">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
        </form>
    </div>
    <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="stock_inventory/moving_analysis/get_moving_analysis_list" data-location="stock_inventory/moving_analysis/exportToExcel" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="stock_inventory/moving_analysis/get_moving_analysis_list" data-location="stock_inventory/moving_analysis/generate_pdf" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>

    <div class="clear"></div>
</div>

<div class="clearfix"></div>

<div class="pad-5 mtop_10">
    <!-- <h3 class="box-title">Stock Check List</h3> -->
    <div class="table-responsive">
        <table id="myTable" class="table table-striped serverDatatable dataTable" data-tableid="#myTable">
            <thead>
                <tr>
                    <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('item_code'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('item_name'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('category'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('issue_qty'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('issue_value'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('moving_type'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('value_type'); ?></th>
                </tr>
            </thead>
            <!-- <tbody>
                <?php
                    $i = 1;
                    if(!empty($issue_list_array)):
                        foreach($issue_list_array as $issue):
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo ($issue['itli_itemcode'])?$issue['itli_itemcode']:''; ?></td>
                    <td><?php echo ($issue['itli_itemname'])?$issue['itli_itemname']:''; ?></td>
                    <td><?php echo ($issue['eqca_category'])?$issue['eqca_category']:''; ?></td>
                    <td><?php echo ($issue['total_issue_qty'])?$issue['total_issue_qty']:''; ?></td>
                    <td><?php echo ($issue['salesrate'])?$issue['salesrate']:''; ?></td>
                    <td><?php echo ($issue['moving_type'])?$issue['moving_type']:''; ?></td>
                    <td><?php echo ($issue['value_type'])?$issue['value_type']:''; ?></td>
                </tr>
                <?php
                        $i++;
                        endforeach;
                    endif;
                ?>
            </tbody> -->
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
    $('.engdatepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    });
    $('.nepdatepicker').nepaliDatePicker();
</script>

<script type="text/javascript">
    $(document).ready(function() {
        var frmDate = $('#frmDate').val();
        var toDate = $('#toDate').val();
        var locationid=$('#locationid').val();

        var material_type = '';
        var category_type ='';
        var counter = '';

        var tableid = $('.serverDatatable').data('tableid');

        var dataurl = base_url + "stock_inventory/moving_analysis/moving_analysis_list";
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
                "aTargets": [0, 7]
            }],
            "aoColumns": [
                { "data": "sno" },
                { "data": "itli_itemcode" },
                { "data": "itli_itemname" },
                { "data": "eqca_category" },
                { "data": "total_issue_qty" },
                { "data": "salesrate" },
                { "data": "moving_type" },
                { "data": "value_type" },
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
                { type: null },
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