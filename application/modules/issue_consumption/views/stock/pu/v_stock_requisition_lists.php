<?php
 if (defined('SHOW_MATERIAL_OPTION_TYPE')) :
                $show_material_type=SHOW_MATERIAL_OPTION_TYPE;
                else:
                    $show_material_type='N';
                endif;

?>
<div class="searchWrapper">

    <div class="row">

        <form class="col-sm-11">

            <?php echo $this->general->location_option(2); ?>

            <div class="col-md-2">
                <label><?php echo $this->lang->line('date_search'); ?> :</label>
                <select name="searchDateType" id="searchDateType" class="form-control">
                    <option value="date_range">By Date Range</option>
                    <option value="date_all">All</option>
                </select>
            </div>

            <div class="dateRangeWrapper">
                <div class="col-md-1">
                    <label><?php echo $this->lang->line('from_date'); ?> :</label>
                    <input type="text" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>" />
                </div>

                <div class="col-md-1">
                    <label><?php echo $this->lang->line('to_date'); ?>:</label>
                    <input type="text" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>" />
                </div>
            </div>


            <?php if($show_material_type=='Y'): ?>
            <div class="col-md-2">

                <label><?php echo $this->lang->line('select_type'); ?></label>

                <select class="form-control" id="searchByMatType">

                    <option value="">All</option>

                    <?php

                    if (!empty($material_type)) :

                        foreach ($material_type as $mat) :

                    ?>

                            <option value="<?php echo $mat->maty_materialtypeid; ?>"><?php echo $mat->maty_material; ?></option>

                    <?php

                        endforeach;

                    endif;

                    ?>

                </select>

            </div>
        <?php endif; ?>
            <div class="col-md-2">
                <label>Print Orientation</label>
                <select name="page_orientation" id="page_orientation" class="form-control">
                    <option value="P">Portrait </option>
                    <option value="L">Landscape</option>
                </select>
            </div>

            <div class="col-md-1">

                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>

            </div>

            <div class="sm-clear"></div>

        </form>
        <div class="col-sm-1">
               <div class="pull-right" style="
    margin-top: 15px;
" >

        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="issue_consumption/stock_requisition/requisition_details_lists" data-location="issue_consumption/stock_requisition/exportToExcelReqlistDetails" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>



        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="issue_consumption/stock_requisition/requisition_details_lists" data-location="issue_consumption/stock_requisition/generate_pdfReqlist_details" data-tableid="#myTable"><i class="fa fa-print"></i></a>

    </div>
        </div>

    </div>

 

    <div class="clear"></div>

</div>

<div class="pad-5">

    <div class="table-responsive">

        <table id="myTable" class="table table-striped serverDatatable keypresstable" data-tableid="#myTable" width="100%">

            <thead>

                <tr>

                    <th width="5%"><?php echo $this->lang->line('sn'); ?></th>

                    <th width="7%"><?php echo $this->lang->line('req_date_ad'); ?></th>

                    <th width="7%"><?php echo $this->lang->line('req_date_bs'); ?></th>

                    <th width="7%"><?php echo $this->lang->line('req_no'); ?></th>

                    <th width="7%"><?php echo $this->lang->line('item_code'); ?></th>

                    <th width="15%"><?php echo $this->lang->line('item_name'); ?></th>

                    <th width="15%"><?php echo $this->lang->line('item_name_np'); ?></th>

                    <th width="5%"><?php echo $this->lang->line('fiscal_year'); ?></th>

                    <th width="8%"><?php echo $this->lang->line('qty'); ?></th>

                    <th width="8%"><?php echo $this->lang->line('issue_qty'); ?></th>

                    <th width="8%"><?php echo $this->lang->line('rem_qty'); ?></th>

                    <th width="8%"><?php echo $this->lang->line('remarks'); ?></th>

                </tr>

            </thead>

            <tbody>

            </tbody>

        </table>

    </div>

</div>

<script type="text/javascript">
    $(document).ready(function() {



        var frmDate = $('#frmDate').val();

        var toDate = $('#toDate').val();

        var locationid = $('#locationid').val();

        var fiscalyear = $('#fiscalyear').val();

        var type = $('#searchByType').val();

        var mattype = $('#searchByMatType').val();

        var apptype = '';
        var searchDateType = $('#searchDateType').val();

        if (searchDateType == 'date_all') {
            frmDate = '';
            toDate = '';
        }

        var dataurl = base_url + "issue_consumption/stock_requisition/requisition_details_lists";

        var message = '';

        var showview = '<?php echo MODULES_VIEW; ?>';

        if (showview == 'N')

        {

            message = "<p class='text-danger'>Permission Denial</p>";

        } else

        {

            message = "<p class='text-danger'>No Record Found!! </p>";

        }



        var tableid = $('.serverDatatable').data('tableid');



        var firstTR = $('#myTable tbody tr:first');

        firstTR.addClass('selected');



        $(tableid).on("draw.dt", function() {

            var rowsNext = $(tableid).dataTable().$("tr:first");

            rowsNext.addClass("selected");

        });



        var dtablelist = $(tableid).dataTable({

            "sPaginationType": "full_numbers",



            "bSearchable": false,

            "lengthMenu": [
                [15, 30, 45, 60, 100, 200, 500, -1],
                [15, 30, 45, 60, 100, 200, 500, "All"]
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

            "aoColumnDefs": [

                {

                    "bSortable": false,

                    "aTargets": [0, 9, 11]

                }

            ],

            "aoColumns": [

                {
                    "data": null
                },

                //{ "data": "rede_reqdetailid"},

                {
                    "data": "postdatead"
                },

                {
                    "data": "postdatebs"
                },

                {
                    "data": "rema_reqno"
                },

                {
                    "data": "itli_itemcode"
                },

                {
                    "data": "itli_itemname"
                },

                {
                    "data": "itli_itemnamenp"
                },

                {
                    "data": "rema_fyear"
                },

                {
                    "data": "rede_qty"
                },

                {
                    "data": "issueqty"
                },

                {
                    "data": "rede_remqty"
                },

                {
                    "data": "rede_remarks"
                },
                // {
                //     "data": "maty_material"
                // },

                // { "data": "reqby" },

                // { "data": "approvedby" },

                // { "data": "remarks" },

                // { "data": "manualno" },

                // { "data": "action" },

            ],

            "fnServerParams": function(aoData) {

                aoData.push({
                    "name": "frmDate",
                    "value": frmDate
                });

                aoData.push({
                    "name": "toDate",
                    "value": toDate
                });

                aoData.push({
                    "name": "locationid",
                    "value": locationid
                });

                aoData.push({
                    "name": "fiscalyear",
                    "value": fiscalyear
                });

                aoData.push({
                    "name": "type",
                    "value": type
                });

                aoData.push({
                    "name": "apptype",
                    "value": apptype
                });

                aoData.push({
                    "name": "mattype",
                    "value": mattype
                });

            },

            "fnRowCallback": function(nRow, aData, iDisplayIndex) {

                // console.log(aData);



                var oSettings = dtablelist.fnSettings();

                $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);

                return nRow;

            },

            "fnCreatedRow": function(nRow, aData, iDisplayIndex) {

                var viewurl = aData.viewurl;

                var prime_id = aData.prime_id;

                var heading = aData.reqby;



                var appclass = aData.approvedclass;

                var oSettings = dtablelist.fnSettings();

                var tblid = oSettings._iDisplayStart + iDisplayIndex + 1

                $(nRow).attr('id', 'listid_' + tblid);

                $(nRow).attr('class', appclass);



                var tbl_id = iDisplayIndex + 1;



                $(nRow).attr('data-rowid', tbl_id);

                $(nRow).attr('data-viewurl', viewurl);

                $(nRow).attr('data-id', prime_id);

                $(nRow).attr('data-heading', heading);

                // $(nRow).addClass('btnredirect');

            },

        }).columnFilter(

            {

                sPlaceHolder: "head:after",

                aoColumns: [{
                        type: null
                    },

                    {
                        type: "text"
                    },

                    {
                        type: "text"
                    },

                    {
                        type: "text"
                    },

                    {
                        type: "text"
                    },

                    {
                        type: "text"
                    },

                    {
                        type: "text"
                    },

                    {
                        type: "text"
                    },

                    {
                        type: "text"
                    },

                    {
                        type: null
                    },

                    {
                        type: "text"
                    },

                    {
                        type: null
                    },

                ]

            });

        $(document).off('click', '#searchByDate')

        $(document).on('click', '#searchByDate', function() {

            frmDate = $('#frmDate').val();

            toDate = $('#toDate').val();

            fiscalyear = $('#fiscalyear').val();

            locationid = $('#locationid').val();

            type = $('#searchByType').val();

            mattype = $('#searchByMatType').val();

            searchDateType = $('#searchDateType').val();

            if (searchDateType == 'date_all') {
                frmDate = '';
                toDate = '';
            }

            dtablelist.fnDraw();

        });



        $(document).off('change', '#searchByType')

        $(document).on('change', '#searchByType', function() {

            type = $('#searchByType').val();

            dtablelist.fnDraw();

        });



        $(document).off('click', '.approvetype');

        $(document).on('click', '.approvetype', function() {

            apptype = $(this).data('approvedtype');

            // alert(apptype);

            frmDate = $('#frmDate').val();

            toDate = $('#toDate').val();

            type = $('#searchByType').val();

            locationid = $('#locationid').val();

            fiscalyear = $('#fiscalyear').val();

            searchDateType = $('#searchDateType').val();

            if (searchDateType == 'date_all') {
                frmDate = '';
                toDate = '';
            }

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

        });

    });
</script>

<script type="text/javascript">
    $(document).off('click', '.btnredirect');

    $(document).on('click', '.btnredirect', function() {

        var id = $(this).data('id');

        var url = $(this).data('viewurl');

        var redirecturl = url;

        $.redirectPost(redirecturl, {
            id: id
        });

    })
</script>

<script type="text/javascript">
    $(document).off('change', '#searchDateType');
    $(document).on('change', '#searchDateType', function() {
        var search_date_val = $(this).val();

        if (search_date_val == 'date_all') {
            $('.dateRangeWrapper').hide();
        } else {
            $('.dateRangeWrapper').show();
        }
    });
</script>