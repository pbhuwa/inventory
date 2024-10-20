<div class="searchWrapper">
    <div class="row">
        <form class="col-sm-8">
        <div class="col-md-2">
                <label><?php echo $this->lang->line('date_search'); ?> :</label>
                <select name="searchDateType" id="searchDateType" class="form-control">
                    <option value="date_range">By Date Range</option>
                    <option value="date_all">All</option>
                </select>
            </div>
         <div class="dateRangeWrapper">
            <div class="col-md-2">
               <label><?php echo $this->lang->line('from_date'); ?> :</label>
               <input type="text" name="fromDate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  value="<?php echo DISPLAY_DATE; ?>" id="fromDate">
            </div>
            <div class="col-md-2">
                <label><?php echo $this->lang->line('to_date'); ?>:</label>
                <input type="text" name="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"   value="<?php echo DISPLAY_DATE; ?>" id="toDate">
            </div>
            </div>
            
            <div class="col-md-2">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
            <div class="sm-clear"></div>
        </form> 
    </div>
<div class="pull-right" >
        <!-- <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="issue_consumption/stock_requisition/requisition_details_lists" data-location="issue_consumption/stock_requisition/exportToExcelReqlistDetails" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a> -->
         <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="access_log/access_log/access_details_lists" data-location="access_log/access_log/exportToExcelAccessDetails" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <!-- <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="issue_consumption/stock_requisition/requisition_details_lists" data-location="issue_consumption/stock_requisition/generate_pdfReqlist_details" data-tableid="#myTable"><i class="fa fa-print"></i></a> -->
        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="access_log/access_log/access_details_lists" data-location="access_log/access_log/generate_pdfAccess_details" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>
    <div class="clear"></div>
</div>
<div class="pad-5">
    <div class="table-responsive">
        <table id="myTable" class="table table-striped serverDatatable keypresstable"  data-tableid="#myTable">
            <thead>
                <tr>
                    <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('login_date_bs'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('login_date_ad'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('login_time'); ?></th>
                     <th width="15%"><?php echo $this->lang->line('username'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('login_ip'); ?></th>
                    <th width="13%"><?php echo $this->lang->line('login_isvalidlogin'); ?></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var frmDate=$('#fromDate').val();
        var toDate=$('#toDate').val();
        //frmDate=$('#fromDate').val();
        //alert(frmDate);
        //var locationid=$('#locationid').val();
        //var apptype='';
        var dataurl = base_url+"access_log/access_log/access_details_lists";
        var message='';
        var showview='<?php echo MODULES_VIEW; ?>';
        if(showview=='N')
        {
        message="<p class='text-danger'>Permission Denial</p>";
        }
        else
        {
        message="<p class='text-danger'>No Record Found!! </p>";
        }
        var dtablelist = $('#myTable').dataTable({
        "sPaginationType": "full_numbers"  ,
        "bSearchable": false,
        "lengthMenu": [[15, 30, 45, 60,100,200,500, -1], [15, 30, 45, 60,100,200,500, "All"]],
        'iDisplayLength': 20,
        "sDom": 'ltipr',
        "bAutoWidth":false,

        "autoWidth": true,
        "aaSorting": [[0,'desc']],
        "bProcessing":true,
        "bServerSide":true,
        "sAjaxSource":dataurl,
        "oLanguage": {
        "sEmptyTable":message
        },
        "aoColumnDefs": [
        {
        "bSortable": true,
        "aTargets": [ 0, 6]
        }
        ],
     
        "aoColumns": [
        { "data": null},
        { "data": "login_date_bs"},
        { "data": "login_date_ad" },
        { "data": "login_time" },
        { "data": "username" },
        { "data": "login_ip" },
        { "data": "login_isvalidlogin" },
        
        ],
        "fnServerParams": function (aoData) {
            aoData.push({ "name": "frmDate", "value": frmDate });
            aoData.push({ "name": "toDate", "value": toDate });
            // aoData.push({ "name": "locationid", "value": locationid });
            // // aoData.push({ "name": "type", "value": type });
            // aoData.push({ "name": "apptype", "value": apptype });
        },
        "fnRowCallback" : function(nRow, aData, iDisplayIndex){
            var oSettings = dtablelist.fnSettings();
            $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
            return nRow;
        },
        "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {
            var viewurl =aData.viewurl;
            var prime_id=aData.prime_id;
            var heading=aData.reqby;

            var appclass=aData.approvedclass;
            //alert(appclass);
            var oSettings = dtablelist.fnSettings();
            var tblid = oSettings._iDisplayStart+iDisplayIndex +1
            $(nRow).attr('id', 'listid_'+tblid);
            $(nRow).attr('class', appclass);

            var tbl_id = iDisplayIndex + 1;

        $(nRow).attr('data-rowid',tbl_id);
        $(nRow).attr('data-viewurl',viewurl);
        $(nRow).attr('data-id',prime_id);
        $(nRow).attr('data-heading',heading);
        },
        }).columnFilter(
        {
            sPlaceHolder: "head:after",
            aoColumns: [ { type: null },
            {type: "text"},
        { type: "text" },
        { type: "text" },
        { type: "text" },
        { type: "text" },
        { type: "text" },
            ]
        });
        


    $(document).off('click','#searchByDate')
    $(document).on('click','#searchByDate',function(){
        frmDate = $('#fromDate').val();
        toDate = $('#toDate').val();
        //alert(toDate);
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


    });
</script>



