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
    /* table.dataTable tbody tr.cancel {
        color: #e65555 !important;
    }
    table.dataTable tbody tr.issuereturn {
        color: #0174DF !important;
    }
    table.dataTable tbody tr.returncancel {
        color: #FF8000 !important;
    }*/
    .table-striped tbody tr.issue td {
        color: #00FF00;
    }

    .table-striped tbody tr.cancel td {
        color: #e65555;
    }

    .table-striped tbody tr.issuereturn td {
        color: #0174DF;
    }

    .table-striped tbody tr.returncancel td {
        color: #FF8000;
    }




    .chart_tab li.issue {
        background: #00FF00 !important;
        color: #00FF00;
    }

    .index_chart li.cancel {
        background: #e65555 !important;
        color: #e65555;
    }

    .chart_tab li.issuereturn {
        background: #0174DF !important;
        color: #0174DF;
    }

    .chart_tab li.returncancel {
        background: #FF8000 !important;
        color: #FF8000;
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


    .table>tbody>tr>td:not(:last-child),
    .table>tbody>tr>th {
        vertical-align: middle !important;
        white-space: normal !important;
    }
</style>

<div class="searchWrapper">
    <div class="">
        <form>
            <?php echo $this->general->location_option(2, 'locationid'); ?>
            <div class="col-md-2 ">
                <label for="example-text"><?php echo $this->lang->line('store_type'); ?> :<span class="required">*</span>:</label>
                <select id="store_id" name="store_id" class="form-control">
                    <option value="">---All---</option>
                    <?php
                    if ($store_type) :
                        foreach ($store_type as $km => $dep) :  //print_r($store_type);die;
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

                <div class="col-md-2  col-xs-12">
                    <label for="example-text"><?php echo $this->lang->line('from_date'); ?> : </label>
                    <input type="text" name="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?> date" placeholder="Dispatch Date" value="<?php echo CURMONTH_DAY1; ?>" id="frmDate">
                    <span class="errmsg"></span>
                </div>

                <div class="col-md-2  col-xs-12">
                    <label for="example-text"><?php echo $this->lang->line('to_date'); ?> : </label>
                    <input type="text" name="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?> date" placeholder="Dispatch To" value="<?php echo DISPLAY_DATE; ?>" id="toDate">
                    <span class="errmsg"></span>
                </div>
            </div>


            <div class="col-md-2">
                <label><?php echo $this->lang->line('supplier_name'); ?></label>
                <select class="form-control select2" id="supplierid">
                    <option value="">All</option>
                    <?php
                    if ($supplier_all) :
                        foreach ($supplier_all as $ks => $supp) :
                    ?>
                            <option value="<?php echo $supp->dist_distributorid; ?>"><?php echo $supp->dist_distributor; ?></option>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </select>
            </div>
            <div class="col-md-2">
                <label>School<span class="required">*</span>:</label>
                <?php
                $location_option = ' <option value="">All</option>';
                if ($this->location_ismain == 'Y' && in_array($this->usergroup, $this->show_location_group)) {
                    $loca_cond = array(
                        'loca_isactive' => 'Y',
                    );
                } else {
                    $loca_cond = array(
                        'loca_isactive' => 'Y',
                        'loca_locationid' => $this->locationid
                    );
                    $location_option = '';
                }
                $locationlist = $this->general->get_tbl_data('*', 'loca_location', $loca_cond);
                $school = $this->locationid;
                ?>
                <select class="form-control required_field" name="school" id="schoolid">

                    <?php
                    echo $location_option;
                    if (!empty($locationlist)) :
                        foreach ($locationlist as $kl => $loc) {
                    ?>
                            <option value="<?php echo $loc->loca_locationid; ?>" <?php if ($school == $loc->loca_locationid) echo "selected=selected"; ?>><?php echo $loc->loca_name; ?></option>
                        <?php
                        }
                        ?>
                    <?php
                    endif;
                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <?php
                ?>
                <label for="example-text">Department <span class="required">*</span>:</label>
                <div class="dis_tab">
                    <select name="departmentid" id="departmentid" class="form-control required_field ">
                        <option value="">--All--</option>
                        <?php if (!empty($department)) :
                            foreach ($department as $kd => $dep) :
                        ?>
                                <option value="<?php echo $dep->dept_depid ?>"><?php echo $dep->dept_depname ?></option>

                        <?php endforeach;
                        endif; ?>
                    </select>
                </div>
            </div>
            <?php
            $subdepid = '';
            if (!empty($sub_department)) :
                $displayblock = 'display:block';
            else :
                $displayblock = 'display:none';
            endif;
            ?>
            <div class="col-md-3" id="subdepdiv" style="<?php echo $displayblock; ?>">
                <label for="example-text">Sub Department:</label>
                <select name="subdepid" id="subdepid" class="form-control">
                    <?php if (!empty($sub_department)) : ?>
                        <option value="">--All--</option>
                        <?php foreach ($sub_department as $ksd => $sdep) :
                        ?>
                            <option value="<?php echo $sdep->dept_depid; ?>" <?php if ($sdep->dept_depid == $subdepid) echo "selected=selected"; ?>><?php echo $sdep->dept_depname; ?></option>
                    <?php endforeach;
                    endif; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label for="example-text">Choose Material Type : </label><br>
                <select name="recm_mattypeid" id="mattypeid" class="form-control chooseMatType required_field">
                    <option value="">---All---</option>
                    <?php
                    if (!empty($material_type)) :
                        foreach ($material_type as $mat) :
                    ?>
                            <option value="<?php echo $mat->maty_materialtypeid; ?>"> <?php echo $mat->maty_material; ?></option>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </select>
            </div>
            <div class="col-md-2">
                <label>Purchase Type</label>
                <select class="form-control" name="pur_type" id="pur_type">
                    <option value="">All</option>
                    <option value="order_received">Received By Order</option>
                    <option value="direct_purchase">Direct</option>
                </select>
            </div>

                <div class="col-md-1">
                    <label>Filter</label>
                    <input type="text" class="form-control" placeholder="Invoice No/Order No." 
                     name="srchtext" id="srchtext">
               </div>
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
        </form>

        <div class="col-sm-12">
            <div class="white-box pad-5 noborder">
                <ul class="index_chart chart_tab">
                    <li class="total" style="    background: #807575;
    color: white;">
                        <a href="javascript:void(0)" data-approvedtype='total' class="approvetype"><em class="total"> </em><?php echo $this->lang->line('all'); ?>
                            <span id="total"><?php echo !empty($status_count[0]->total) ? $status_count[0]->total : ''; ?></span></a>
                    </li>

                    <li class="cancel">
                        <a href="javascript:void(0)" data-approvedtype='cancel' class="approvetype"><em class="cancel"> </em> <?php echo $this->lang->line('canceled'); ?>
                            <span id="cancel"><?php echo !empty($status_count[0]->cancel) ? $status_count[0]->cancel : ''; ?></span></a>
                    </li>

                    <div class="clearfix"></div>

                </ul>
            </div>
        </div>

    </div>
    <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="purchase_receive/receive_against_order/receive_against_order_list" data-location="purchase_receive/receive_against_order/exportToExcel" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="purchase_receive/receive_against_order/receive_against_order_list" data-location="purchase_receive/receive_against_order/generate_pdf" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>
    <div class="clear"></div>
</div>

<div class="clearfix"></div>

<div class="pad-5 mtop_10">

    <div class="table-responsive">
        <table id="myTable" class="table table-striped ">
            <thead>
                <tr>
                    <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('received_date'); ?> </th>
                    <th width="5%"><?php echo $this->lang->line('fiscal_year'); ?> </th>
                    <th width="5%"><?php echo $this->lang->line('invoice_no'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('order_no'); ?></th>
                    <th width="15%" style="white-space: -webkit-nowrap;"><?php echo $this->lang->line('supplier_name'); ?></th>
                    <th width="5%">Budget</th>
                    <th width="5%">S.Total</th>
                    <th width="5%">Discount</th>
                    <th width="5%">VAT</th>
                    <th width="5%">Extra Amt</th>
                    <th width="7%">GTotal</th>
                    <th width="5%">Entry Date</th>
                    <th width="5%">Received By</th>
                    <th width="10%">Material Type</th>
                    <th width="25%">Department</th>
                    <th width="15%">Post Date</th>
                    <th width="5%"><?php echo $this->lang->line('action'); ?></th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>

<div class="clearfix"></div>

<div class="col-sm-12">
    <div class="alert-success success"></div>
    <div class="alert-danger error"></div>
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
        var fyear = $('#fyear').val();
        var store_id = $('#store_id').val();
        var locationid = $('#locationid').val();
        var supplierid = $('#supplierid').val();
        var apptype = '<?php echo $apptype; ?>';
        var mattypeid = $('#mattypeid').val();
        var schoolid = $('#schoolid').val();
        var departmentid = $('#departmentid').val();
        var subdepid = $('#subdepid').val();
        var pur_type = $('#pur_type').val();

        var supplier = '';
        var items = '';
        var searchDateType = $('#searchDateType').val();

        if (searchDateType == 'date_all') {
            frmDate = '';
            toDate = '';
        }

        var dataurl = base_url + "purchase_receive/receive_against_order/received_against_order_list";
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
                "aTargets": [0, 10]
            }],
            "aoColumns": [{
                    "data": "sno"
                },
                {
                    "data": "recm_receiveddatebs"
                },
                {
                    "data": "recm_fyear"
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
                    "data": "budg_budgetname"
                },
                {
                    "data": "recm_amount"
                },
                {
                    "data": "recm_discount"
                },
                {
                    "data": "recm_taxamount"
                 },
                {
                    "data": "extra_amt"
                },
                {
                    "data": "recm_clearanceamount"
                },
                {
                    "data": "recm_posttime"
                },
                {
                    "data": "receivedby"
                },
                {
                    "data": "mattype"
                },
                {
                    "data": "department"
                },
                {
                    "data": "postdate"
                },
                {
                    "data": "action"
                }

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
                    "name": "store_id",
                    "value": store_id
                });
                aoData.push({
                    "name": "fyear",
                    "value": fyear
                });
                aoData.push({
                    "name": "locationid",
                    "value": locationid
                });
                aoData.push({
                    "name": "supplierid",
                    "value": supplierid
                });
                aoData.push({
                    "name": "apptype",
                    "value": apptype
                });
                aoData.push({
                    "name": "mattypeid",
                    "value": mattypeid
                });
                aoData.push({
                    "name": "schoolid",
                    "value": schoolid
                });
                aoData.push({
                    "name": "departmentid",
                    "value": departmentid
                });
                aoData.push({
                    "name": "subdepid",
                    "value": subdepid
                });
                aoData.push({
                    "name": "pur_type",
                    "value": pur_type
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
                {
                    type: null
                },
                {
                    type: null
                },
            ]
        });

        // after cancel function

        var otherlinkdata = base_url + 'purchase_receive/receive_against_order/receive_summary';

        var otherdata = get_other_ajax_data(otherlinkdata, frmDate, toDate, false, locationid);

        $(document).on('click', '#searchByDate', function() {
            srchtext = $('#srchtext').val();
            frmDate = $('#frmDate').val();
            toDate = $('#toDate').val();
            fyear = $('#fyear').val();
            store_id = $('#store_id').val();
            locationid = $('#locationid').val();
            supplierid = $('#supplierid').val();
            mattypeid = $('#mattypeid').val();
            schoolid = $('#schoolid').val();
            departmentid = $('#departmentid').val();
            subdepid = $('#subdepid').val();
            pur_type = $('#pur_type').val();
            searchDateType = $('#searchDateType').val();

            if (searchDateType == 'date_all') {
                frmDate = '';
                toDate = '';
            }


            dtablelist.fnDraw();
            get_other_ajax_data(otherlinkdata, frmDate, toDate, false, locationid, mattypeid, schoolid, departmentid, subdepid);
        });




        $('#searchByDate').click();



        $(document).off('click', '.approvetype');
        $(document).on('click', '.approvetype', function() {
            apptype = $(this).data('approvedtype');
            // alert(apptype);
            srchtext=$('#srchtext').val();
            frmDate = $('#frmDate').val();
            toDate = $('#toDate').val();
            type = $('#searchByType').val();
            locationid = $('#locationid').val();
            mattypeid = $('#mattypeid').val();
            searchDateType = $('#searchDateType').val();

            if (searchDateType == 'date_all') {
                frmDate = '';
                toDate = '';
            }
            dtablelist.fnDraw();
            // get_other_ajax_data(otherlinkdata,frmDate,toDate,type);   
        });

        function get_other_ajax_data(action, frmdate = false, todate = false, othertype = false, locid = false, mattypeid = false, schoolid = false, departmentid = false, subdepid = false, pur_type = false, srchtext = false) {
            var returndata = [];
            $.ajax({
                type: "POST",
                url: action,
                // data:$('form#'+formid).serialize(),
                dataType: 'html',
                data: {
                    srchtext:srchtext,
                    frmdate: frmdate,
                    todate: todate,
                    othertype: othertype,
                    locid: locid,
                    mattypeid: mattypeid,
                    schoolid: schoolid,
                    departmentid: departmentid,
                    subdepid: subdepid,
                    pur_type: pur_type
                },
                success: function(jsons) //we're calling the response json array 'cities'
                {
                    // console.log(jsons);
                    data = jQuery.parseJSON(jsons);
                    var cancel = 0;

                    console.log(data);

                    $('#cancel').html('');

                    if (data.status == 'success') {
                        cancel_data = data.status_count;

                        cancel_cnt = cancel_data.cancel;

                    }

                    $('#cancel').html(cancel_cnt);

                    return false;
                }
            });
        }
    });
</script>

<script type="text/javascript">
    $('.engdatepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    });
    $('.nepdatepicker').nepaliDatePicker();
</script>
<script type="text/javascript">
    $(document).off('change', '#schoolid');
    $(document).on('change', '#schoolid', function(e) {
        var schoolid = $(this).val();
        var submitdata = {
            schoolid: schoolid
        };
        var submiturl = base_url + 'issue_consumption/stock_requisition/get_department_by_schoolid';
        // aletr(schoolid);
        $('#departmentid').html('');


        ajaxPostSubmit(submiturl, submitdata, beforeSend, onSuccess);

        function beforeSend() {


        };

        function onSuccess(jsons) {
            data = jQuery.parseJSON(jsons);
            if (data.status == 'success') {
                $('#subdepdiv').hide();
                $('#departmentid').html(data.dept_list);
            } else {
                $('#departmentid').html(' <option value="">--All--</option>');
                $("#departmentid").select2("val", "");
                $("#subdepid").select2("val", "");


            }

        }
    });

    $(document).off('change', '#departmentid');
    $(document).on('change', '#departmentid', function(e) {
        var depid = $(this).val();
        var submitdata = {
            schoolid: depid
        };
        var submiturl = base_url + 'issue_consumption/stock_requisition/get_department_by_schoolid';
        // aletr(schoolid);
        $("#subdepid").select2("val", "");
        $('#subdepid').html('');
        ajaxPostSubmit(submiturl, submitdata, beforeSend, onSuccess);

        function beforeSend() {


        };

        function onSuccess(jsons) {
            data = jQuery.parseJSON(jsons);
            if (data.status == 'success') {
                $('#subdepdiv').show();
                $('#subdepid').html(data.dept_list);
            } else {
                $('#subdepdiv').hide();
                $('#subdepid').html();
            }


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