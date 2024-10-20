<style type="text/css">
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
            <div class="col-md-2 col-sm-4">
                <label for="example-text"><?php echo $this->lang->line('store_type'); ?> :<span class="required">*</span>:</label>
                <select id="store_id" name="store_id" class="form-control required_field">
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
                <div class="col-md-2 col-sm-3 col-xs-12">
                    <label for="example-text"><?php echo $this->lang->line('from_date'); ?> : </label>
                    <input type="text" name="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?> date" placeholder="Dispatch Date" value="<?php echo CURMONTH_DAY1; ?>" id="frmDate">
                    <span class="errmsg"></span>
                </div>

                <div class="col-md-2 col-sm-3 col-xs-12">
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
                    <div class="col-md-2">
                <label>Print Orientation</label>
                <select name="page_orientation" id="page_orientation" class="form-control">
                    <option value="P">Portrait </option>
                    <option value="L">Landscape</option>
                </select>
            </div>


            <div class="col-md-3">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
        </form>
    </div>
    <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="purchase_receive/receive_against_order/received_order_item_details" data-location="purchase_receive/receive_against_order/exportToExcelDetails" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="purchase_receive/receive_against_order/received_order_item_details" data-location="purchase_receive/receive_against_order/generate_pdfDetails" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>
    <div class="clear"></div>
</div>

<div class="clearfix"></div>

<div class="pad-5 mtop_10">

    <div class="table-responsive">
        <table id="myTable" class="table table-striped ">
            <thead>
                <tr>
                    <th width="2%" style="text-align: center"><?php echo $this->lang->line('sn'); ?>
                    </th>
                    <th width="6%" style="text-align: center"><?php echo $this->lang->line('received_date'); ?>
                    <th width="6%" style="text-align: center"><?php echo $this->lang->line('bill_date'); ?>
                    <th width="4%" style="text-align: center"><?php echo $this->lang->line('order_no'); ?>
                    </th>
                    <th width="10%" style="text-align: center"><?php echo $this->lang->line('supplier'); ?>
                    </th>

                    <th width="10%" style="text-align: center"><?php echo $this->lang->line('item_name'); ?>
                    </th>

                    <th>Description</th>

                    <th width="6%" style="text-align: center"><?php echo $this->lang->line('fiscal_year'); ?>
                    </th>

                    <th width="6%" style="text-align: center"><?php echo $this->lang->line('unit'); ?>
                    </th>

                    <th width="5%" style="text-align: center"><?php echo $this->lang->line('qty'); ?>
                    </th>
                    <th width="5%" style="text-align: center"><?php echo $this->lang->line('rate'); ?>
                    </th>
                    <th width="5%" style="text-align: center"><?php echo $this->lang->line('total'); ?>
                    </th>
                    <th width="6%" style="text-align: center"><?php echo $this->lang->line('dis_amt'); ?>
                    </th>

                    <th width="5%" style="text-align: center"><?php echo $this->lang->line('tax_amount'); ?>
                    </th>

                    <th width="7%" style="text-align: center"><?php echo $this->lang->line('grand_total'); ?>
                    </th>
                    <th width="10%">Material Type</th>
                    <th width="25%">Department</th>

                    <th width="5%">Received By</th>


                    </th>

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

<script type="text/javascript">
    $(document).ready(function() {
        var frmDate = $('#frmDate').val();
        var toDate = $('#toDate').val();
        var fyear = $('#fyear').val();
        var store_id = $('#store_id').val();
        var locationid = $('#locationid').val();
        var supplierid = $('#supplierid').val();
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

        var dataurl = base_url + "purchase_receive/receive_against_order/received_order_item_details_lists";
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
                "aTargets": [0, 7, 8, 9, 10, 11, 12]
            }],
            "aoColumns": [{
                    "data": "sno"
                },
                {
                    "data": "recm_receiveddatebs"
                },
                {
                    "data": "recm_supbilldatebs"
                },
                {
                    "data": "orderno"
                },
                {
                    "data": "supplier"
                },
                {
                    "data": "itli_itemname"
                },
                {
                    "data": "description"
                },
                {
                    "data": "recm_fyear"
                },
                {
                    "data": "unit_unitname"
                },
                {
                    "data": "recd_purchasedqty"
                },
                {
                    "data": "rate"
                },
                {
                    "data": "total"
                },
                {
                    "data": "recd_discount"
                },
                {
                    "data": "recd_vatamt"
                },
                {
                    "data": "recd_amount"
                },
                {
                    "data": "mattype"
                },
                {
                    "data": "department"
                },
                {
                    "data": "receivedby"
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
                var oSettings = dtablelist.fnSettings();
                var tblid = oSettings._iDisplayStart + iDisplayIndex + 1

                $(nRow).attr('id', 'listid_' + tblid);
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
                {
                    type: null
                },

            ]

        });

        $(document).on('click', '#searchByDate', function() {
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