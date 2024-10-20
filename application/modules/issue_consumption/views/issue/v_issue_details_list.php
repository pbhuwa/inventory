<style type="text/css">
    table.dataTable tbody tr.selected {
        background-color: #B0BED9;
    }

    table.dataTable tbody tr.active {
        background-color: #B0BED9 !important;
    }

    /*table.dataTable tbody tr.issue {
        color: #00FF00 !important;
    }*/
    table.dataTable tbody tr.cancel {
        color: #e65555 !important;
    }

    table.dataTable tbody tr.issuereturn {
        color: #0174DF !important;
    }

    table.dataTable tbody tr.returncancel {
        color: #FF8000 !important;
    }
</style>
<!-- <h3 class="box-title">Issue Book List </h3> -->

<div class="searchWrapper">
    <div class="">
        <form class="col-sm-10">
            <?php echo $this->general->location_option(2, 'locationid'); ?>
             <div class="col-md-2">
                <label><?php echo $this->lang->line('date_search'); ?> :</label>
                <select name="searchDateType" id="searchDateType" class="form-control">
                    <option value="date_range">By Date Range</option>
                    <option value="date_all">All</option>
                </select>
            </div>

            <div class="dateRangeWrapper">
                <div class="col-md-1">
                    <label><?php echo $this->lang->line('from_date'); ?></label>
                    <input type="text" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>" />
                </div>
                <div class="col-md-1">
                    <label><?php echo $this->lang->line('to_date'); ?></label>
                    <input type="text" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>" />
                </div>
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
            <div class="sm-clear"></div>
        </form>


    </div>
    <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="issue_consumption/new_issue/issuedetails" data-location="issue_consumption/new_issue/exportToExcelIssueDetails" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="issue_consumption/new_issue/issuedetails" data-location="issue_consumption/new_issue/generate_pdfIssueDetails" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>
    <div class="clear"></div>
</div>
<div class="pad-5">
    <div class="table-responsive">
        <table id="myTable" class="table table-striped">
            <thead>
                <tr class="tr_issue">
                    <th width="3%" style="text-align: center"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="6%"><?php echo $this->lang->line('issue_no'); ?></th>
                    <th width="6%"><?php echo $this->lang->line('date'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('req_no'); ?></th>
                    <th width="6%"><?php echo $this->lang->line('item_code'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('item_name'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('department'); ?></th>
                    <th width="6%"><?php echo $this->lang->line('issued_by'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('received_by'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('issue_time'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('qty'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('rate'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('amount'); ?></th>
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
<script type="text/javascript">
    $(document).ready(function() {
        var frmDate = $('#frmDate').val();
        var toDate = $('#toDate').val();
        var locationid = $('#locationid').val();
        var apptype = '<?php echo $apptype; ?>';

        var searchDateType = $('#searchDateType').val();

        if (searchDateType == 'date_all') {
            frmDate = '';
            toDate = '';
        }
        // var apptype='';
        var dataurl = base_url + "issue_consumption/new_issue/issue_book_details_list";
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
                "aTargets": [0, 9]
            }],

            "aoColumns": [{
                    "data": null
                },
                {
                    "data": "invoiceno"
                },
                {
                    "data": "billdatebs"
                },
                {
                    "data": "requisitionno"
                },
                {
                    "data": "itli_itemcode"
                },
                {
                    "data": "itli_itemname"
                },
                {
                    "data": "depname"
                },
                {
                    "data": "username"
                },
                {
                    "data": "memno"
                },
                {
                    "data": "billtime"
                },
                {
                    "data": "sade_qty"
                },
                {
                    "data": "sade_unitrate"
                },
                {
                    "data": "issueamt"
                },
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
                // aoData.push({ "name": "type", "value": type });
                aoData.push({
                    "name": "apptype",
                    "value": apptype
                });
            },
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                var oSettings = dtablelist.fnSettings();
                $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
                return nRow;
            },
            "fnCreatedRow": function(nRow, aData, iDisplayIndex) {
                var appclass = aData.approvedclass;
                //alert(appclass);
                var oSettings = dtablelist.fnSettings();
                var tblid = oSettings._iDisplayStart + iDisplayIndex + 1
                $(nRow).attr('id', 'listid_' + tblid);
                $(nRow).attr('class', appclass);
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
                    type: null
                },
                {
                    type: null
                },
            ]
        });

        var otherlinkdata = base_url + 'issue_consumption/new_issue/issue_summary';

        var otherdata = get_other_ajax_data(otherlinkdata, frmDate, toDate, locationid);

        $(document).off('change', '#searchByType')
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
            get_other_ajax_data(otherlinkdata, frmDate, toDate, locationid);
        });

        $(document).off('click', '.approvetype');
        $(document).on('click', '.approvetype', function() {
            apptype = $(this).data('approvedtype');
            // alert(apptype);
            if (apptype == 'cancel' || apptype == 'issue' || !apptype) {
                $('.tr_return').hide();
                $('.tr_issue').show();
            } else if (apptype == 'issuereturn' || apptype == 'returncancel') {
                $('.tr_return').show();
                $('.tr_issue').hide();
            }
            frmDate = $('#frmDate').val();
            toDate = $('#toDate').val();
            locationid = $('#locationid').val();
            
            type = $('#searchByType').val();
            dtablelist.fnDraw();
            // get_other_ajax_data(otherlinkdata,frmDate,toDate,type);   
        });

        function get_other_ajax_data(action, frmdate = false, todate = false, othertype = false) {
            var returndata = [];
            $.ajax({
                type: "POST",
                url: action,
                // data:$('form#'+formid).serialize(),
                dataType: 'html',
                data: {
                    frmdate: frmdate,
                    todate: todate,
                    othertype: othertype
                },
                success: function(jsons) //we're calling the response json array 'cities'
                {
                    // console.log(jsons);
                    data = jQuery.parseJSON(jsons);
                    var cancel = 0;
                    var issuereturn = 0;
                    var returncancel = 0;
                    var cancel = 0;
                    // console.log(data);
                    $('#issue').html('');
                    $('#cancel').html('');
                    $('#issuereturn').html('');
                    $('#returncancel').html('');
                    if (data.status == 'success') {
                        issuedata = data.status_count;
                        issue = issuedata.issue;
                        cancel = issuedata.cancel;
                        issuereturn = returndata.issue_ret;
                        returncancel = returndata.ret_cancel;
                    }
                    $('#issue').html(issue);
                    $('#cancel').html(cancel);
                    $('#issuereturn').html(issuereturn);
                    $('#returncancel').html(returncancel);

                    return false;
                }
            });
        }
    });
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