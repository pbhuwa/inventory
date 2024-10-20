<?php
$recommend_qty_view_group = array('SA', 'DM', 'DS');
?>
<?php
// $color_codeclass=$this->general->get_color_code('*','coco_colorcode',array('coco_isactive'=>'Y','coco_listname'=>'req_demandsummary','coco_isallorg'=>'Y'));
foreach ($status_count as $key => $color)
// print_r($color_codeclass);
//die;
{
    $statusname = $color->coco_statusname;
    $colors = $color->coco_color;
    $bgcolor = $color->coco_bgcolor;
?>
    <style>
        .table-striped tbody tr.<?php echo $statusname; ?> td {
            color: <?php echo $colors;  ?>;
        }

        .index_chart li div.<?php echo $statusname; ?> {
            background-color: <?php echo $bgcolor; ?>
        }

        .white-box.noborder ul li.<?php echo $statusname; ?> {
            background-color: <?php echo $bgcolor; ?>
        }
    </style>
<?php
}
?>
<style>
    .table-striped tbody tr.cntissue td {
        color: #55e655;
    }

    .approvetype.tab_active {
        color: #f00;
    }

    .white-box.noborder ul li.tab_active {}

    .white-box.noborder ul li {
        padding: 0px;
    }

    .index_chart li a {
        display: block;
        padding: 11px;
        color: #fff;
    }

    .index_chart li a em {
        float: left;
        margin-right: 5px;
        display: inline-block;
        height: 15px;
        width: 15px;
        border-radius: 20px;
    }

    /*   .index_chart li a em.unapproved{background-color: #be4cd2;}
 .index_chart li a em.verified{background-color: #0174DF;} */
</style>
<div class="searchWrapper">
    <div class="pull-right">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="issue_consumption/stock_requisition/requisition_lists" data-location="issue_consumption/stock_requisition/exportToExcelReqlist" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="issue_consumption/stock_requisition/requisition_lists" data-location="issue_consumption/stock_requisition/generate_pdfReqlist" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>

    <div class="row">
        <form class="col-sm-12">
            <div class="col-md-2">
                <label>Department/Section/Division
                    <!-- span class="required">*</span> : -->
                </label>
                <?php
                $deptmnt = $this->session->userdata(USER_DEPT);
                ?>
                <select class="form-control select2 " name="departmentid" id="departmentid" style="height: auto;width: 100%;">
                    <option value="">----All-----</option>

                    <?php
                    if ($department) :
                        foreach ($department as $kd => $dep) :
                    ?>
                            <option value="<?php echo $dep->dept_depid; ?>" <?php if ($deptmnt == $dep->dept_depid) echo "selected=selected"; ?>><?php echo $dep->dept_depname; ?></option>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </select>
            </div>
            <?php echo $this->general->location_option(); ?>

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

            <div class="col-md-1">
                <label><?php echo $this->lang->line('filter'); ?> Filter Type:</label>
                <select name="searchByType" id="searchByType" class="form-control">
                    <option value="all">All</option>
                    <option value="self">Self</option>
                    <option value="others">Others</option>
                </select>
            </div>

             <div class="col-md-1">
                <label>Filter</label>
                <input type="text" class="form-control enterinput" placeholder="Dem./Manual No." name="srchtext" id="srchtext" data-targetbtn="searchByDate">
            </div>
            <div class="col-md-1">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>

            <div class="sm-clear"></div>
            <!--  <div class="col-md-2">
                <label><?php echo $this->lang->line('select_type'); ?></label>
                <select class="form-control" id="searchByType">
                    <option value="">All</option>
                    <option value="Y">Issue</option>
                    <option value="N">Transfer</option>
                </select>
            </div> -->
            <div class="clearfix"></div>
        </form>

        <div class="col-sm-12">
            <div class="white-box pad-5 noborder">
                <ul class="index_chart">
                    <!--  <li  class="" >
                    <a href="javascript:void(0)" data-approvedtype='all' class="approvetype"><?php echo $this->lang->line('all'); ?></a>
                </li> -->
                    <?php

                    if (!empty($status_count)) :
                        foreach ($status_count as $key => $color) :
                    ?>
                            <li class="<?php echo $color->coco_statusname; ?>">
                                <!-- <div class="<?php echo $color->coco_statusname; ?>"></div> -->
                                <a href="javascript:void(0)" data-approvedtype='<?php echo $color->coco_statusname; ?>' class="approvetype">
                                    <em class="<?php echo $color->coco_statusname; ?>"></em>
                                    <?php echo $color->coco_displaystatus; ?>
                                    <span id="<?php echo $color->coco_statusname; ?>"><?php echo !empty($color->statuscount) ? $color->statuscount : ''; ?>
                                    </span>
                                </a>

                            </li>
                    <?php
                        endforeach;
                    endif;
                    ?>
                    <li>
                        <!-- <div class="cntissue"></div>  -->
                        <a href="javascript:void(0)" data-approvedtype='cntissue' class="approvetype">
                            <em class="cntissue"></em>
                            <?php echo $this->lang->line('total_rem_item'); ?>
                            <span id="cntissue"><?php echo !empty($total_count[0]->cntissue) ? $total_count[0]->cntissue : ''; ?></span>
                        </a>

                    </li>
                    <div class="clearfix"></div>
                </ul>
            </div>
        </div>
    </div>

    <div class="clear"></div>
</div>

<div class="pad-5">
    <div class="table-responsive">
        <table id="myTable" class="table table-striped serverDatatable keypresstable" data-tableid="#myTable">
            <thead>
                <tr>
                    <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('req_date_ad'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('req_date_bs'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('req_no'); ?></th>
                    <th width="8%"><?php echo $this->lang->line('from'); ?></th>
                    <th width="8%"><?php echo $this->lang->line('store'); ?></th>
                    <th width="8%"><?php echo $this->lang->line('username'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('is_issue'); ?></th>
                    <th width="8%"><?php echo $this->lang->line('req_by'); ?></th>
                    <th width="8%"><?php echo $this->lang->line('approved_by'); ?></th>
                    <th width="8%"><?php echo $this->lang->line('manual_no'); ?></th>
                    <th width="6%"><?php echo $this->lang->line('item_rem'); ?></th>
                    <th width="8%"><?php echo $this->lang->line('fiscal_year'); ?></th>
                    <th width="5%">P.Dem</th>
                    <?php
                    if (in_array($this->usergroup, $recommend_qty_view_group)) :
                    ?>
                        <th width="1%"><?php echo $this->lang->line('recommend_status'); ?></th>
                    <?php
                    endif;
                    ?>
                    <th width="9%" style="text-align: center"><?php echo $this->lang->line('action'); ?></th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>

<?php
$apptype = $this->input->post('dashboard_data');
if ($apptype) {
    $apptype = $apptype;
} else {
    $apptype = "";
}
?>

<?php
if (in_array($this->usergroup, $recommend_qty_view_group)) :
    $ao_group = '[
    { "data": null},
    { "data": "postdatead"},
    { "data": "postdatebs"},
    { "data": "reqno" },
    { "data": "fromdep" },
    { "data": "todep" },
    { "data": "username" },
    { "data": "isdep" },
    { "data": "reqby" },
    { "data": "approvedby" },
    { "data": "manualno" },
    { "data": "cntitem" },
    { "data": "fyear" },
    { "data": "prev_demand_no" },
    { "data": "recommend_status" },
    { "data": "action" },
]';
else :
    $ao_group = '[
    { "data": null},
    { "data": "postdatead"},
    { "data": "postdatebs"},
    { "data": "reqno" },
    { "data": "fromdep" },
    { "data": "todep" },
    { "data": "username" },
    { "data": "isdep" },
    { "data": "reqby" },
    { "data": "approvedby" },
    { "data": "manualno" },
    { "data": "cntitem" },
    { "data": "fyear" },
    { "data": "prev_demand_no" },
    { "data": "action" },
]';
endif;
?>

<script type="text/javascript">
    function get_other_ajax_data(action, frmdate = false, todate = false, othertype = false, locationid = false, departmentid = false) {

        var returndata = [];
        $.ajax({
            type: "POST",
            url: action,
            // data:$('form#'+formid).serialize(),
            dataType: 'html',
            data: {
                frmdate: frmdate,
                todate: todate,
                othertype: othertype,
                locationid: locationid,
                departmentid: departmentid
            },

            success: function(jsons) //we're calling the response json array 'cities'
            {
                // console.log(jsons);

                data = jQuery.parseJSON(jsons);
                var pending = 0;
                var approved = 0;
                var unapproved = 0;
                var cancel = 0;
                var cntissue = 0;
                var verified = 0;
                // console.log(data);
                $('#pending').html('');
                $('#approved').html('');
                $('#unapproved').html('');
                $('#cancel').html('');
                $('#cntissue').html('');
                $('#verified').html('');

                if (data.status == 'success') {
                    req_data = data.status_count;
                    req_total_data = data.total_count;
                    // console.log(req_data);
                    // console.log(req_data[0].pending)
                    pending = req_data[0].pending;
                    approved = req_data[0].approved;
                    unapproved = req_data[0].unapproved;
                    cancel = req_data[0].cancel;
                    verified = req_data[0].verified;
                    cntissue = req_total_data[0].cntissue;
                }
                $('#pending').html(pending);
                $('#approved').html(approved);
                $('#unapproved').html(unapproved);
                $('#cancel').html(cancel);
                $('#verified').html(verified);
                $('#cntissue').html(cntissue);
                return false;
            }
        });
    }

    $(document).ready(function() {
         var srchtext = $('#srchtext').val();
        var departmentid = $('#departmentid').val();
        var frmDate = $('#frmDate').val();
        var toDate = $('#toDate').val();

        var searchDateType = $('#searchDateType').val();

        if (searchDateType == 'date_all') {
            frmDate = '';
            toDate = '';
        }

        var locationid = $('#locationid').val();
        var fiscalyear = $('#fiscalyear').val();
        var type = $('#searchByType').val();
        var apptype = '<?php echo $apptype; ?>';
        var dataurl = base_url + "issue_consumption/stock_requisition/requisition_lists";
        var message = '';
        var showview = '<?php echo MODULES_VIEW; ?>';
        if (showview == 'N') {
            message = "<p class='text-danger'>Permission Denial</p>";
        } else {
            message = "<p class='text-danger'>No Record Found!! </p>";
        }

        var tableid = $('.serverDatatable').data('tableid');

        var firstTR = $('#myTable tbody tr:first');
        firstTR.addClass('selected');

        // console.log(formdata);

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
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [0, 7, 11, 12,13,14]
            }],
            "aoColumns": <?php echo $ao_group; ?>,
            "fnServerParams": function(aoData) {
                 aoData.push({
                    "name": "srchtext",
                    "value": srchtext
                });

                aoData.push({
                    "name": "departmentid",
                    "value": departmentid
                });
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
                    "name": "type",
                    "value": type
                });
                aoData.push({
                    "name": "fiscalyear",
                    "value": fiscalyear
                });
                aoData.push({
                    "name": "apptype",
                    "value": apptype
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
        }).columnFilter({
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
        var otherlinkdata = base_url + 'issue_consumption/stock_requisition/requisition_summary';
        // var formdata=[];
        //  formdata= [{frmDate:frmDate,toDate:toDate,type:type}];
        // // formdata['frmDate'] = frmDate;
        // formdata['toDate'] = toDate;
        // var postdata=$.serialize(formdata);
        var otherdata = get_other_ajax_data(otherlinkdata, frmDate, toDate, type, locationid);
        // alert(otherdata);
        // console.log(otherdata);
        // var pending=otherdata.pending;
        // console.log(pending);


        $(document).off('click', '#searchByDate')
        $(document).on('click', '#searchByDate', function() {
             srchtext = $('#srchtext').val();
            frmDate = $('#frmDate').val();
            toDate = $('#toDate').val();
            departmentid = $('#departmentid').val();
            locationid = $('#locationid').val();
            type = $('#searchByType').val();
            searchDateType = $('#searchDateType').val();

            if (searchDateType == 'date_all') {
                frmDate = '';
                toDate = '';
            }

            dtablelist.fnDraw();
            get_other_ajax_data(otherlinkdata, frmDate, toDate, type, locationid, departmentid);
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
             srchtext = $('#srchtext').val();
            frmDate = $('#frmDate').val();
            toDate = $('#toDate').val();
            type = $('#searchByType').val();
            fiscalyear = $('#fiscalyear').val();
            departmentid = $('#departmentid').val();
            locationid = $('#locationid').val();

            searchDateType = $('#searchDateType').val();

            if (searchDateType == 'date_all') {
                frmDate = '';
                toDate = '';
            }

            dtablelist.fnDraw();
            // $('.approvetype.tab_active').removeClass('tab_active'); 
            // $(this).addClass('tab_active');

            $('.white-box.noborder ul li').removeClass('tab_active');
            $(this).parent().addClass('tab_active');

            // $('.white-box.noborder ul li').removeClass('tab_active'); 
            // $('.white-box.noborder ul li').addClass('tab_active');
            // alert(dtablelist);
            // get_other_ajax_data(otherlinkdata,frmDate,toDate,type);   
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
            // alert(prime_id);
        });

        $(document).off('keydown');
        $(document).bind('keydown', function() {
            // alert('test');    
            selectedTR = $(tableid).find('.selected');

            var rowid = selectedTR.data('rowid');
            var numRow = selectedTR.data('numRow');
            var numTR = $(tableid + ' tr').length - 1;

            var keypressed = event.keyCode;
            // console.log(keypressed);

            if (keypressed == '40' && rowid < numTR) {
                selectedTR.removeClass('selected');
                nextTR = selectedTR.next('tr');

                nextTR.addClass('selected');
                req_masterid = nextTR.data('masterid');
                setTimeout(function() {
                    nextTR.focus();
                }, 100);
            }

            if (keypressed == '38' && rowid != '1') {
                selectedTR.removeClass('selected');
                prevTR = selectedTR.prev('tr');

                prevTR.addClass('selected');
                req_masterid = prevTR.data('masterid');
                setTimeout(function() {
                    prevTR.focus();
                }, 100);
            }

            if (keypressed == '13') {
                selectedTR.click();
                // console.log( $(this).closest('tr').attr('id'));
                selectedTR.addClass('selected');
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