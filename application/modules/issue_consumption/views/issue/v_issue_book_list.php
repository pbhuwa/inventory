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
 .table-striped tbody tr.issue td{
        color:#00FF00;
    }
    .table-striped tbody tr.cancel td{
        color:#e65555;
    }
    .table-striped tbody tr.issuereturn td{
        color:#0174DF;
    }
    .table-striped tbody tr.returncancel td{
        color:#FF8000;
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
    .index_chart li a{display: block; padding: 11px; color: #fff;}
    .index_chart li a em{
        float: left;
        margin-right: 5px;
        display: inline-block;
        height: 15px;
        width: 15px;
        border-radius: 20px;
    }

</style>
<!-- <h3 class="box-title">Issue Book List </h3> -->

<div class="searchWrapper">
     <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="issue_consumption/new_issue/issuebook" data-location="issue_consumption/new_issue/exportToExcelIssueBookList" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="issue_consumption/new_issue/issuebook" data-location="issue_consumption/new_issue/generate_pdfIssueBookList" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>
   
    <div class="">
        <form class="col-sm-12">
            <?php echo $this->general->location_option(2,'locationid'); ?>
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
                <input type="text" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
            </div>
             <div class="col-md-2">
                <label><?php echo $this->lang->line('to_date'); ?></label>
                <input type="text" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
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

        <div class="col-sm-12">
            <div class="white-box pad-5 noborder">
               <ul class="index_chart chart_tab">
                    <li class="issue">
                         <a href="javascript:void(0)" data-approvedtype='issue' class="approvetype"><em class="issue">  </em><?php echo $this->lang->line('all_issue'); ?>
                        <span id="issue"><?php echo !empty($status_count[0]->issue)?$status_count[0]->issue:'';?></span></a> 
                    </li>

                    <li class="cancel">
                        <a href="javascript:void(0)" data-approvedtype='cancel' class="approvetype"><em class="cancel"> </em> <?php echo $this->lang->line('canceled'); ?>
                        <span id="cancel"><?php echo !empty($status_count[0]->cancel)?$status_count[0]->cancel:'';?></span></a> 
                    </li>
                    
                    <li class="issuereturn">
                         <a href="javascript:void(0)" data-approvedtype='issuereturn' class="approvetype" ><em class="issuereturn">   </em><?php echo $this->lang->line('return'); ?> 
                        <span id="issuereturn"><?php echo !empty($return_count[0]->issuereturn)?$return_count[0]->issuereturn:'';?></span></a> 
                    </li>
                    
                    <li class="returncancel">
                       <a href="javascript:void(0)" data-approvedtype='returncancel' class="approvetype"><em class="returncancel">   </em><?php echo $this->lang->line('return_cancel'); ?> 
                        <span id="returncancel"><?php echo !empty($return_count[0]->returncancel)?$return_count[0]->returncancel:'';?></span></a> 
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
        <table id="myTable" class="table table-striped">
            <thead>
                <tr class="tr_issue">
                    <th width="3%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="8%" ><?php echo $this->lang->line('issue_date').'('.$this->lang->line('bs').')'; ?>
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
                    <th width="5%"><?php echo $this->lang->line('fiscal_year'); ?> </th>
                    <th width="10%"><?php echo $this->lang->line('action'); ?></th>
                </tr>
                
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<?php
    $apptype = $this->input->post('dashboard_data');
    if($apptype){
        $apptype = $apptype; 
    }else{
        $apptype = "";
    }
?>
<script type="text/javascript">
$(document).ready(function(){
    var searchDateType =$('#searchDateType').val();
    var frmDate=$('#frmDate').val();
    var toDate=$('#toDate').val();
    var locationid=$('#locationid').val();
        var apptype='<?php echo $apptype; ?>';

    // var apptype='';
    var dataurl = base_url+"issue_consumption/new_issue/issue_book_list";
     // alert(dataurl);
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
        aoData.push({ "name": "searchDateType", "value":searchDateType});
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

    var otherlinkdata=base_url+'issue_consumption/new_issue/issue_summary';

    var otherdata=get_other_ajax_data(otherlinkdata,frmDate,toDate,false,locationid);

    
    $(document).on('click', '#searchByDate', function() {
        frmDate = $('#frmDate').val();
        toDate = $('#toDate').val();
        locationid=$('#locationid').val();
        searchDateType = $('#searchDateType').val();

        if (searchDateType == 'date_all') {
            frmDate = '';
            toDate = '';
        }
        status=$('#status').val();
        dtablelist.fnDraw();
        get_other_ajax_data(otherlinkdata,frmDate,toDate,false,locationid);  
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
        searchDateType=$('#searchDateType').val();
        if (searchDateType == 'date_all') {
            frmDate = '';
            toDate = '';
        }
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

                console.log(jsons);
                data = jQuery.parseJSON(jsons);

                var issue=0;
                var cancel=0;
                var  issuereturn=0;
                var returncancel=0;
                var cancel=0; 

                 console.log(issue);
                $('#issue').html('');
                $('#cancel').html('');
                $('#issuereturn').html('');
                $('#returncancel').html('');
                // if(data.status=='success'){
                //     issuedata=data.status_count;
                //     returndata = data.return_count;

                //     // console.log(issuedata);
                //     // console.log(issuedata[0].cancel)
                //     issue=issuedata[0].issue;
                //     cancel=issuedata[0].cancel;
                //     issuereturn=returndata[0].issuereturn;
                //     returncancel=returndata[0].returncancel;        
                // }
                  if(data.status=='success'){

                    issuedata=data.status_count;
                   

                    issue=issuedata.issue;

                    cancel=issuedata.cancel;

                    issuereturn=issuedata.issue_ret;

                    returncancel=issuedata.ret_cancel;        

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