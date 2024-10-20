<style type="text/css">
    .table>tbody>tr>td:not(:last-child),
    .table>tbody>tr>th {

        vertical-align: middle !important;

        white-space: normal !important;

    }
</style>

<div class="searchWrapper">

    <div class="row">

        <form class="col-sm-12">

           

            <div class="col-md-2">

                <label>Date Search:</label>

                <select name="searchDateType" id="searchDateType" class="form-control">

                    <option value="date_all">All</option>

                    <option value="date_range">By Synch Date</option>

                </select>

            </div>

            <div class="dateRangeWrapper" style="display:none">

                <div class="col-md-1">

                    <label><?php echo $this->lang->line('from_date'); ?> :</label>

                    <input type="text" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>" />

                </div>

                <div class="col-md-1">

                    <label><?php echo $this->lang->line('to_date'); ?>:</label>

                    <input type="text" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>" />

                </div>

            </div>

            <div class="col-md-3">

                <label><?php echo $this->lang->line('category'); ?>:</label>

                <select name="eqca_equipmentcategoryid" class="form-control select2" id="categoryid">

                    <option value=''>ALL</option>

                    <?php

                    if (!empty($equipmentcategory)) :

                        foreach ($equipmentcategory as $ky => $cat) {

                    ?>

                            <option value="<?php echo $cat->eqca_equipmentcategoryid; ?>"><?php echo $cat->eqca_code . ' | ' . $cat->eqca_category; ?></option>

                    <?php

                        }

                    endif; ?>

                </select>

            </div>

            <div class="col-md-3">

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

                <label>Branch<span class="required">*</span>:</label>

                <?php
                $select_option = '<option value="">All</option>';
                if ($this->location_ismain == 'Y' && in_array($this->usergroup, $this->show_location_group)) {
                    $loca_cond = array(
                        'loca_isactive' => 'Y',
                    );
                } else {
                    $loca_cond = array(
                        'loca_isactive' => 'Y',
                        'loca_locationid' => $this->locationid
                    );
                    $select_option = '';
                }

                $locationlist = $this->general->get_tbl_data('*', 'loca_location', $loca_cond);

                $school = $this->locationid;

                ?>

                <select class="form-control required_field" name="school" id="schoolid">



                    <?php
                    echo $select_option;
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

                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>

            </div>

            <div class="sm-clear"></div>

        </form>

    </div>

    <div class="clear"></div>

</div>

<div class="pad-5">

    <div class="table-responsive">

        <table id="myTable" class="table table-striped serverDatatable keypresstable" data-tableid="#myTable" width="100%">

            <thead>

                <tr>

                    <th width="2%"><?php echo $this->lang->line('sn'); ?></th>

                    <th width="7%">Sync Date AD</th>

                    <th width="7%">Sync Date BS</th>

                    <th width="7%">Purchase Date AD</th>

                    <th width="7%">Purchase Date BS</th>

                    <th width="4%"><?php echo $this->lang->line('item_code'); ?></th>

                    <th width="10%"><?php echo $this->lang->line('item_name'); ?></th>

                    <th width="5%"><?php echo $this->lang->line('category'); ?></th>

                    <th width="10%"><?php echo $this->lang->line('supplier'); ?></th>

                    <th width="5%"><?php echo $this->lang->line('qty'); ?></th>

                    <th width="5%"><?php echo $this->lang->line('rate'); ?></th>

                    <th width="7%"><?php echo $this->lang->line('amount'); ?></th>

                    <th width="7%">Branch</th>

                    <th width="7%">Department</th>

                    <th width="10%">Receiver</th>

                    <th width="5%"><?php echo $this->lang->line('action'); ?></th>

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



        var searchDateType = $('#searchDateType').val();

        if (searchDateType == 'date_all') {

            var frmDate = '';

            var toDate = '';

        }


        var locationid = $('#locationid').val();

        var fiscalyear = $('#fiscalyear').val();

        var type = $('#searchByType').val();

        var categoryid = $('#categoryid').val();

        var schoolid = $('#schoolid').val();

        var departmentid = $('#departmentid').val();

        var subdepid = $('#subdepid').val();

        var supplierid = $('#supplierid').val();
        // alert(categoryid);

        var apptype = '';

        var dataurl = base_url + "ams/asset_sync/synclist_asset_summary";

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

                    "aTargets": [0, 9, 10, 11, 15]

                }

            ],

            "aoColumns": [

                {
                    "data": null
                },

                {
                    "data": "sync_date_ad"
                },

                {
                    "data": "sync_date_bs"
                },

                {
                    "data": "purchase_date_ad"
                },
                {
                    "data": "purchase_date_bs"
                },

                {
                    "data": "item_code"
                },

                {
                    "data": "item_name"
                },

                {
                    "data": "category"
                },

                {
                    "data": "supplier"
                },

                {
                    "data": "qty"
                },

                {
                    "data": "rate"
                },

                {
                    "data": "amount"
                },

                {
                    "data": "school"
                },

                {
                    "data": "department"
                },

                {
                    "data": "received_by"
                },

                {
                    "data": "action"
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
                    "name": "categoryid",
                    "value": categoryid
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
                    "name": "supplierid",
                    "value": supplierid
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
                        type: null
                    },

                ]

            });

        $(document).off('click', '#searchByDate')

        $(document).on('click', '#searchByDate', function() {

            frmDate = $('#frmDate').val();

            toDate = $('#toDate').val();

            searchDateType = $('#searchDateType').val();



            if (searchDateType == 'date_all') {

                frmDate = '';

                toDate = '';

            }

            categoryid = $('#categoryid').val();

            fiscalyear = $('#fiscalyear').val();

            locationid = $('#locationid').val();

            type = $('#searchByType').val();

            schoolid = $('#schoolid').val();

            departmentid = $('#departmentid').val();

            subdepid = $('#subdepid').val();

            supplierid = $('#supplierid').val();

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