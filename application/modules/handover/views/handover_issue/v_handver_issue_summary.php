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
        <form class="col-sm-8">
            <?php echo $this->general->location_option(2,'locationid'); ?>
            <div class="col-md-2">

                <label><?php echo $this->lang->line('from_date'); ?></label>
                <input type="text" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
            </div>
             <div class="col-md-2">
                <label><?php echo $this->lang->line('to_date'); ?></label>
                <input type="text" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
            </div>

            <div class="col-md-2">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
            <div class="sm-clear"></div>
        </form>

        <div class="col-sm-4">
            <div class="white-box pad-5 noborder">
                <ul class="index_chart">
                    <li>
                        <div class="issue"></div> <a href="javascript:void(0)" data-approvedtype='issue' class="approvetype"><?php echo $this->lang->line('all_issue'); ?></a>
                        <span id="issue"><?php echo !empty($status_count[0]->issue)?$status_count[0]->issue:'';?></span>
                    </li>

                    <li>
                        <div class="cancel"></div><a href="javascript:void(0)" data-approvedtype='cancel' class="approvetype"> <?php echo $this->lang->line('canceled'); ?></a> 
                        <span id="cancel"><?php echo !empty($status_count[0]->cancel)?$status_count[0]->cancel:'';?></span>
                    </li>
                    
                    <li>
                        <div class="issuereturn"></div> <a href="javascript:void(0)" data-approvedtype='issuereturn' class="approvetype" ><?php echo $this->lang->line('return'); ?> </a>
                        <span id="issuereturn"><?php echo !empty($return_count[0]->issuereturn)?$return_count[0]->issuereturn:'';?></span>
                    </li>
                    
                    <li>
                        <div class="returncancel"></div> <a href="javascript:void(0)" data-approvedtype='returncancel' class="approvetype"><?php echo $this->lang->line('return_cancel'); ?> </a>
                        <span id="returncancel"><?php echo !empty($return_count[0]->returncancel)?$return_count[0]->returncancel:'';?></span>
                    </li>
                    <div class="clearfix"></div>
                    
                </ul>
            </div>
        </div>
         <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="handover/handover_issue/issuebook" data-location="handover/handover_issue/exportToExcelIssueBookList" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="handover/handover_issue/issuebook" data-location="handover/handover_issue/generate_pdfIssueBookList" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>
    </div>
  
    <div class="clear"></div>
</div>
<div class="pad-5">
    <div class="table-responsive">
        <table id="myTable" class="table table-striped">
            <thead>
                <tr class="tr_issue">
                    <th width="3%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="8%" ><?php echo $this->lang->line('handover_issue_date').'('.$this->lang->line('bs').')'; ?>
                    <th width="8%" ><?php echo $this->lang->line('issue_date').'('.$this->lang->line('ad').')'; ?>
                    <th width="5%"><?php echo $this->lang->line('issue_no'); ?></th>
                    </th>
                    <th width="10%"><?php echo $this->lang->line('department'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('total_amount'); ?></th>
                    <th width="6%"><?php echo $this->lang->line('issued_by'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('received_by'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('req_no'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('issue_time'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('bill_no'); ?> </th>
                    <th width="6%"><?php echo $this->lang->line('fiscal_year'); ?> </th>
                    <th width="7%"><?php echo $this->lang->line('action'); ?></th>
                </tr>
                
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    var frmDate=$('#frmDate').val();
    var toDate=$('#toDate').val();
    var locationid=$('#locationid').val();
    var apptype='';
    var dataurl = base_url+"handover/handover_issue/issue_book_list";
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
    "bSortable": false,
    "aTargets": [ 0, 8,10]
    }
    ],
 
    "aoColumns": [
    { "data": null},
    { "data": "billdatebs" },
     { "data": "billdatead" },
    { "data": "invoiceno"},
    { "data": "depname" },
    { "data": "totalamount" },
    { "data": "username" },
    { "data": "memno" },
    { "data": "requisitionno" },
    { "data": "billtime" },
    { "data": "billno" },
    { "data": "fyear" },
    { "data": "action" }
    ],
    "fnServerParams": function (aoData) {
        aoData.push({ "name": "frmDate", "value": frmDate });
        aoData.push({ "name": "toDate", "value": toDate });
        aoData.push({ "name": "locationid", "value": locationid });
        aoData.push({ "name": "apptype", "value": apptype });
    },
    "fnRowCallback" : function(nRow, aData, iDisplayIndex){
        var oSettings = dtablelist.fnSettings();
        $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
        return nRow;
    },
    "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {
        var appclass=aData.approvedclass;
        //alert(appclass);
        var oSettings = dtablelist.fnSettings();
        var tblid = oSettings._iDisplayStart+iDisplayIndex +1
        $(nRow).attr('id', 'listid_'+tblid);
        $(nRow).attr('class', appclass);
    },
    }).columnFilter(
    {
        sPlaceHolder: "head:after",
        aoColumns: [ { type: null },
        {type: "text"},
        { type: "text" },
        { type: "text" },
         { type: "text" },
        { type: null },
        { type: "text" },
        { type: "text" },
        { type: "text" },
        { type: "text" },
        { type: "text" },
        { type: "text" },
        { type: null },
        ]
    });

    var otherlinkdata=base_url+'handover/handover_issue/issue_summary';

    var otherdata=get_other_ajax_data(otherlinkdata,frmDate,toDate,false,locationid);

    $(document).off('change','#searchByType')
    $(document).on('click', '#searchByDate', function() {
        frmDate = $('#frmDate').val();
        toDate = $('#toDate').val();
        locationid=$('#locationid').val();
        dtablelist.fnDraw();
        get_other_ajax_data(otherlinkdata,frmDate,toDate,false,locationid);  
    });

    $(document).off('click','.approvetype');
    $(document).on('click','.approvetype',function(){
        apptype= $(this).data('approvedtype');
        $('#returnDate').html('<span class="filter_column filter_text"><input type="text" class="search_init text_filter" value="Return Date"></span>');
        // alert(apptype);
        // if(apptype == 'cancel' || apptype == 'issue' || !apptype){
        //     $('.tr_return').hide();
        //     $('.tr_issue').show();
        // }else if(apptype == 'issuereturn' || apptype == 'returncancel'){
        //     $('.tr_return').show();
        //     $('.tr_issue').hide();
        // }
        frmDate=$('#frmDate').val();
        toDate=$('#toDate').val();  
        type=$('#searchByType').val();
        locationid=$('#locationid').val(); 
        dtablelist.fnDraw();  
        // get_other_ajax_data(otherlinkdata,frmDate,toDate,type);   
    });

    function get_other_ajax_data(action,frmdate=false,todate=false,othertype=false,locid=false){
        var returndata=[];   
        $.ajax({
            type: "POST",
            url: action,
            // data:$('form#'+formid).serialize(),
            dataType: 'html',
            data:{frmdate:frmdate,todate:todate,othertype:othertype,locid:locid} ,
            success: function(jsons) //we're calling the response json array 'cities'
            {
                // console.log(jsons);
                data = jQuery.parseJSON(jsons);  
                var cancel=0;
                var  issuereturn=0;
                var returncancel=0;
                var cancel=0; 
                // console.log(data);
                $('#issue').html('');
                $('#cancel').html('');
                $('#issuereturn').html('');
                $('#returncancel').html('');
                if(data.status=='success'){
                    issuedata=data.status_count;
                    returndata = data.return_count;

                    // console.log(issuedata);
                    // console.log(issuedata[0].cancel)
                    issue=issuedata[0].issue;
                    cancel=issuedata[0].cancel;
                    issuereturn=returndata[0].issuereturn;
                    returncancel=returndata[0].returncancel;        
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