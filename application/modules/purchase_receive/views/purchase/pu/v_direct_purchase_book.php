<style>
    .table-striped tbody tr.directreceived td {
        color: #FF8C00;
    }

    .table-striped tbody tr.cancel td {
        color: #e65555;
    }

    .table-striped tbody tr.returno td {
        color: #0174df;
    }

    .chart_tab li.directreceived {
        background: #FF8C00 !important;
        color: #fff;
    }

    .index_chart li.cancel {
        background: #e65555 !important;
        color: #fff;
    }

    .chart_tab li.returno {
        background: #0174df !important;
        color: #fff;
    }

    .chart_tab li {
        padding: 0 !important;
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
</style>

<div class="searchWrapper">
    <div class="pull-right" style="margin-top:22px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="purchase_receive/direct_purchase/direct_purchase_summary_list" data-location="purchase_receive/direct_purchase/exportToExcelDirect" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="purchase_receive/direct_purchase/direct_purchase_summary_list" data-location="purchase_receive/direct_purchase/generate_pdfDirect" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>

    <div class="row clearfix">
        <form class="col-sm-12">
            <?php echo $this->general->location_option(2, 'locationid'); ?>
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
                <input type="text" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>" />
            </div>
            <div class="col-md-2">
                <label><?php echo $this->lang->line('to_date'); ?></label>
                <input type="text" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>" />
            </div>
            </div>

             <div class="col-md-1">
                <label>Filter</label>
                <input type="text" class="form-control" placeholder="Preq No" 
                 name="srchtext" id="srchtext">
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
        <div class="col-sm-12">
            <div class="white-box pad-5 noborder">

                <ul class="index_chart chart_tab">
                    <li class="directreceived">
                        <a href="javascript:void(0)" data-approvedtype='directreceived' class="approvetype"><em class="directreceived"> </em><?php echo $this->lang->line('direct_purchase'); ?>
                            <span id="directreceived"> <?php echo !empty($status_count[0]->directreceived) ? $status_count[0]->directreceived : 0; ?></span></a>
                    </li>

                    <li class="cancel">
                        <a href="javascript:void(0)" data-approvedtype='cancel' class="approvetype"><em class="cancel"> </em><?php echo $this->lang->line('canceled'); ?>
                            <span id="cancel"> <?php echo !empty($status_count[0]->cancel) ? $status_count[0]->cancel : 0; ?></span></a>
                    </li>

                    <li class="returno">
                        <a href="javascript:void(0)" data-approvedtype='returno' class="approvetype"><em class="returno"> </em><?php echo $this->lang->line('return'); ?>
                            <span id="returno"> <?php echo !empty($return_count[0]->total) ? $return_count[0]->total : 0; ?></span></a>
                    </li>

                    <div class="clearfix"></div>

                </ul>

            </div>
        </div>

    </div>
    <div id="FormDiv_orderDetails" class="formdiv frm_bdy">
        <div class="pad-5">
            <div class="table-responsive">
                <table id="myTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                            <th width="9%"><?php echo $this->lang->line('receive_date_bs'); ?> </th>
                            <th width="9%"><?php echo $this->lang->line('receive_date_ad'); ?> </th>
                            <th width="7%"><?php echo $this->lang->line('invoice_no'); ?></th>
                            <th width="3%"><?php echo $this->lang->line('no'); ?>.</th>
                            <th width="20%"><?php echo $this->lang->line('supplier_name'); ?></th>
                            <th width="6%"><?php echo $this->lang->line('fiscal_year'); ?></th>
                            <th width="5%"><?php echo $this->lang->line('discount'); ?></th>
                            <th width="5%"><?php echo $this->lang->line('tax'); ?></th>
                            <th width="5%"><?php echo $this->lang->line('clearance_amt'); ?></th>
                            <th width="5%"><?php echo $this->lang->line('time'); ?></th>
                            <th width="5%"><?php echo $this->lang->line('amount'); ?></th>
                            <th width="5%"><?php echo $this->lang->line('action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
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
        var srchtext = $('#srchtext').val();
        var frmDate = $('#frmDate').val();
        var toDate = $('#toDate').val();
        var supplier = $('#supplier').val();
        var item = $('#item').val();
        var locationid = $('#locationid').val();
        var searchDateType = $('#searchDateType').val();

        if (searchDateType == 'date_all') {
            frmDate = '';
            toDate = '';
        }
        var apptype = '<?php echo $apptype; ?>';

        var dataurl = base_url + "purchase_receive/direct_purchase/direct_purchase_summary_list";
        var message = '';
        var showview = '<?php echo MODULES_VIEW; ?>';
        // alert(showview);
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
                "aTargets": [0, 8, 9, 10]
            }],
            "aoColumns": [{
                    "data": "sno"
                },
                {
                    "data": "recm_receiveddatebs"
                },
                {
                    "data": "recm_receiveddatead"
                },
                {
                    "data": "recm_invoiceno"
                },
                {
                    "data": "orderno"
                },
                {
                    "data": "dist_distributor"
                },
                {
                    "data": "recm_fyear"
                },
                {
                    "data": "recm_discount"
                },
                {
                    "data": "recm_taxamount"
                },
                {
                    "data": "recm_clearanceamount"
                },
                {
                    "data": "recm_posttime"
                },
                {
                    "data": "recm_amount"
                },
                {
                    "data": "action"
                },
            ],
            "fnServerParams": function(aoData) {
                  aoData.push({
                    "name": "srchtext",
                    "value": srchtext
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
                    "name": "apptype",
                    "value": apptype
                });
                aoData.push({
                    "name": "supplier",
                    "value": supplier
                });
                aoData.push({
                    "name": "locationid",
                    "value": locationid
                });
            },
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                var oSettings = dtablelist.fnSettings();
                $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
                return nRow;
            },
            "fnCreatedRow": function(nRow, aData, iDisplayIndex) {
                var appclass = aData.approvedclass;
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
                    type: null
                },
                {
                    type: null
                },
            ]
        });
        var otherlinkdata = base_url + 'purchase_receive/direct_purchase/purchased_summary';

        var otherdata = get_other_ajax_data(otherlinkdata, frmDate, toDate);

        $(document).off('change', '#searchByType')
        $(document).on('click', '#searchByDate', function() {
           srchtext = $('#srchtext').val();
            frmDate = $('#frmDate').val();
            toDate = $('#toDate').val();
            supplier = $('#supplier').val();
            locationid = $('#locationid').val();

             var searchDateType = $('#searchDateType').val();

            if (searchDateType == 'date_all') {
                frmDate = '';
                toDate = '';
            }
            
            item = $('#item').val();
            dtablelist.fnDraw();
            get_other_ajax_data(otherlinkdata, frmDate, toDate, false, false, locationid);
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

        $(document).off('click', '.approvetype');
        $(document).on('click', '.approvetype', function() {
            apptype = $(this).data('approvedtype');

            if (apptype == 'returno') {
                // $(dtablelist.api().column(1).header()).text('Return Date');
            }

            srchtext = $('#srchtext').val();
            frmDate = $('#frmDate').val();
            toDate = $('#toDate').val();
            type = $('#searchByType').val();
            locationid = $('#locationid').val();
            dtablelist.fnDraw();
            get_other_ajax_data(otherlinkdata, frmDate, toDate, apptype, type, locationid);
        });

        function get_other_ajax_data(action, frmdate = false, todate = false, apptype = false, type = false, locationid = false) {
            var returndata = [];
            $.ajax({
                type: "POST",
                url: action,
                // data:$('form#'+formid).serialize(),
                dataType: 'html',
                data: {
                    srchtext: srchtext,
                    frmdate: frmdate,
                    todate: todate,
                    apptype: apptype,
                    type: type,
                    locationid: locationid
                },
                success: function(jsons) //we're calling the response json array 'cities'
                {
                    // console.log(jsons);
                    data = jQuery.parseJSON(jsons);
                    var directreceived = 0;
                    var returno = 0;
                    var cancel = 0;
                    // console.log(data);
                    $('#returno').html('');
                    $('#directreceived').html('');
                    $('#cancel').html('');
                    if (data.status == 'success') {
                        issuedata = data.status_count;
                        returndata = data.return_count;

                        // console.log(issuedata);
                        // console.log(issuedata[0].cancel)
                        returno = returndata[0].total;
                        directreceived = issuedata[0].directreceived;
                        cancel = issuedata[0].cancel;
                    }
                    $('#returno').html(returno);
                    $('#directreceived').html(directreceived);
                    $('#cancel').html(cancel);

                    return false;
                }
            });
        }
    });
</script>