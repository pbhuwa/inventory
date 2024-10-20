<style type="text/css">
     table.dataTable tr td:nth-child(3) {font-weight: bold}
</style>
<div class="searchWrapper">
    <div class="">
        <form>
            <?php 
            $curlocid=$this->session->userdata(LOCATION_ID);
            echo $this->general->location_option(2,'locationname','locationid',$curlocid); ?>
            <div class="col-md-2 col-sm-4">
                <label for="example-text"><?php echo $this->lang->line('store_type'); ?>:<span class="required">*</span>:</label>
                <select id="store_id" name="store"  class="form-control" >
                    <option value="">---select---</option>
                    <?php 
                    $curstore=$this->session->userdata(STORE_ID);
                        if($store):
                            foreach ($store as $km => $dep):
                    ?>
                    <option value="<?php echo $dep->eqty_equipmenttypeid; ?>" <?php if($curstore==$dep->eqty_equipmenttypeid) echo "selected=selected"; ?> ><?php echo $dep->eqty_equipmenttype; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </select>
            </div>
            <div class="col-md-2 col-sm-4">
                <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?>:<span class="required">*</span>:</label>
                <select id="fiscal_year" name="fiscal_year"  class="form-control required_field" >
                    <?php 
                        if($fiscalyear):
                            foreach ($fiscalyear as $km => $dep):
                    ?>
                     <option value="<?php echo $dep->fiye_name; ?>" <?php if($dep->fiye_status=='I') echo "selected='selected'"; ?>><?php echo $dep->fiye_name; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </select>
            </div>
            <div class="col-md-2 col-sm-4">
                <label for="example-text">Status:<span class="required">*</span>:</label>
               <select class="form-control" id="appstatus">
                   <option value="4">---All---</option>
                    <option value="5">Pending</option>  <!-- 0 is not working 5 is for zero-->
                   <option value="1">Approved</option>
                   <option value="2">Unapproved</option>
                   <option value="3">Cancel</option>
               </select>
            </div>
            <div class="col-md-3">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
        </form>
    </div>
    <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="issue_consumption/stock_requisition/monthlywise_dep_req_lists" data-location="issue_consumption/stock_requisition/exportToExcelRequisitionMonthly" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>
        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="issue_consumption/stock_requisition/monthlywise_dep_req_lists" data-location="issue_consumption/stock_requisition/generate_pdfRequisitionMonthly" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>
    <div class="clear"></div>
</div>
<div class="clearfix"></div>
<div class="pad-5 mtop_10">
    <h3 class="box-title"><?php echo $this->lang->line('monthly_department_requisition'); ?></h3>
    <div class="table-responsive">
        <table id="myTable" class="table table-striped ">
            <thead>
                <tr>
                	<th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <th><?php echo $this->lang->line('department'); ?></th>
                    <th><?php echo $this->lang->line('total_requisition'); ?></th>
                    <th><?php echo $this->lang->line('shrawan'); ?></th>
                    <th><?php echo $this->lang->line('bhadra'); ?></th>
                    <th><?php echo $this->lang->line('aaswin'); ?></th>
                    <th><?php echo $this->lang->line('kartik'); ?></th>
                    <th><?php echo $this->lang->line('mangsir'); ?></th>
                    <th><?php echo $this->lang->line('poush'); ?></th>
                    <th><?php echo $this->lang->line('magh'); ?></th>
                    <th><?php echo $this->lang->line('falgun'); ?></th>
                    <th><?php echo $this->lang->line('chaitra'); ?></th>
                    <th><?php echo $this->lang->line('baishak'); ?></th>
                    <th><?php echo $this->lang->line('jesth'); ?></th>
                    <th><?php echo $this->lang->line('ashadh'); ?></th>              
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
        var locationid = $('#locationid').val();
        var fiscal_year = $('#fiscal_year').val();
        var appstatus = $('#appstatus').val();
        var dataurl = base_url + "issue_consumption/stock_requisition/monthlywise_dep_req_lists";
        var message = '';
        var showview = '<?php echo MODULES_VIEW; ?>';
        if(showview=='N')
        {
            message="<p class='text-danger'>Permission Denial</p>";
        }
        else
        {
            message="<p class='text-danger'>No Record Found!!</p>";
        }
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
                "bSortable": true,
                "aTargets": [1, 2]
            }],
            "aoColumns": [
        { "data": null},
        { "data": "dept_depname"},
        { "data": "total_all"},
        { "data": "mdr4"},
        { "data": "mdr5"},
        { "data": "mdr6"},
        { "data": "mdr7"},
        { "data": "mdr8"},
        { "data": "mdr9"},
        { "data": "mdr10"},
        { "data": "mdr11"},
        { "data": "mdr12"},
        { "data": "mdr1"},
        { "data": "mdr2"},
        { "data": "mdr3"}
        ],
        
        "fnServerParams": function(aoData) {
            aoData.push({"name": "store_id","value": store_id});
            aoData.push({"name": "locationid","value": locationid});
            aoData.push({"name": "appstatus","value": appstatus});
            aoData.push({"name": "fiscal_year","value": fiscal_year});
            },
        "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                var oSettings = dtablelist.fnSettings();
                $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
                return nRow;
            },
         "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {
                var viewurl =aData.viewurl;
                var prime_id=aData.prime_id;
                var heading=aData.reqby;

                var appclass=aData.approvedclass;
                var oSettings = dtablelist.fnSettings();
                var tblid = oSettings._iDisplayStart+iDisplayIndex +1
                $(nRow).attr('id', 'listid_'+tblid);
                $(nRow).attr('class', appclass);

                var tbl_id = iDisplayIndex + 1;

                $(nRow).attr('data-rowid',tbl_id);
                $(nRow).attr('data-viewurl',viewurl);
                $(nRow).attr('data-id',prime_id);
                $(nRow).attr('data-heading',heading);
                // $(nRow).addClass('btnredirect');
            },
        }).columnFilter({
            sPlaceHolder: "head:after",
            aoColumns: [
                { type: null },
                { type: "text" },
                { type: null },
                { type: null },
                { type: null },
                 { type: null },
                { type: null },
                { type: null },
                 { type: null },
                { type: null },
                { type: null },
                { type: null },
                { type: null },
            ]
        });

        $(document).on('click', '#searchByDate', function() {
            store_id = $('#store_id').val();
            fiscal_year = $('#fiscal_year').val();
            appstatus = $('#appstatus').val();
            locationid = $('#locationid').val();
            dtablelist.fnDraw();
        });

        $(document).on('change', '#searchBySupplier', function() {
            supplier = $('#searchBySupplier').val();
            dtablelist.fnDraw();
        });

        $(document).on('change', '#searchByItems', function() {
            store_id = $('#store_id').val();
            fiscal_year = $('#fiscal_year').val();
            appstatus = $('#appstatus').val();
            locationid = $('#locationid').val();
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
