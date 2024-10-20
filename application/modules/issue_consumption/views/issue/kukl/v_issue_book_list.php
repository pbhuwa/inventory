<style type="text/css">

    <?php 

    foreach ($status_count as $key => $color) 
        
    {
        $statusname=$color->coco_statusname;
        $colors=$color->coco_color;
        $bgcolor=$color->coco_bgcolor;
        ?>
        <style>
        .table-striped tbody tr.<?php echo $statusname;?> td{
            color:<?php echo $colors;  ?>;
        }
        .white-box.noborder ul li.<?php echo $statusname; ?>{
            background-color:<?php echo $bgcolor; ?>
        }
        <?php
    } 
    ?>
    <?php 
    foreach ($return_count as $key => $return) 
    {
        $statusname=$return->coco_statusname;
        $colors=$return->coco_color;
        $bgcolor=$return->coco_bgcolor;
        ?>
        <style>
        .table-striped tbody tr.<?php echo $statusname;?> td{
            color:<?php echo $colors;  ?>;
        }
        .white-box.noborder ul li.<?php echo $statusname; ?>{
            background-color:<?php echo $bgcolor; ?>
        }
        <?php
    } 
    ?>
</style>
<style>
    .table-striped tbody tr.cntissue td{
        color:#55e655;
    }
    .approvetype.tab_active{
        color: #f00;
    }

    .white-box.noborder ul li.tab_active{
     
    }

    .white-box.noborder ul li{padding: 0px;}
    .index_chart li a{display: block; padding: 11px; color: #fff;}
    .index_chart li a em{
        float: left;
        margin-right: 5px;
        display: inline-block;
        height: 15px;
        width: 15px;
        border-radius: 20px;
    } 
 /*   .index_chart li a em.unapproved{background-color: #be4cd2;}
 .index_chart li a em.verified{background-color: #0174DF;}*/
</style>


<div class="searchWrapper">
    <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="issue_consumption/new_issue/issuebook" data-location="issue_consumption/new_issue/exportToExcelIssueBookList" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="issue_consumption/new_issue/issuebook" data-location="issue_consumption/new_issue/generate_pdfIssueBookList" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>

    <div class="">
        <form class="col-sm-12">
            <?php echo $this->general->location_option(2,'locationid'); ?>
            <div class="col-md-2">
                <label>Date Search:</label>
                <select name="searchDateType" id="searchDateType" class="form-control">
                    <option value="date_range">By Date Range</option>
                    <option value="date_all">All</option>
                </select>
            </div>

            <div class="dateRangeWrapper">
                <div class="col-md-1">
                    <label><?php echo $this->lang->line('from_date'); ?> :</label>
                    <input type="text" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
                </div>
                
                <div class="col-md-1">
                    <label><?php echo $this->lang->line('to_date'); ?>:</label>
                    <input type="text" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
                </div>
            </div>

             <div class="col-md-1">
                <label>Filter</label>
                <input type="text" class="form-control" placeholder="PR. No/Dem. No/Manual No." 
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
            <div class="sm-clear"></div>
        </form>

        <div class="col-sm-12">
            <div class="white-box pad-5 noborder">
                <ul class="index_chart">
                    <?php 
                    if(!empty($status_count)):
                        foreach ($status_count as $key => $color):
                          ?>
                          
                          <li  class="<?php echo $color->coco_statusname; ?>">
                            <a href="javascript:void(0)" data-approvedtype='<?php echo $color->coco_statusname; ?>' class="approvetype">
                                <em class="<?php echo $color->coco_statusname; ?>"></em>
                                <?php echo $color->coco_displaystatus; ?> 
                                <span id="<?php echo $color->coco_statusname; ?>"><?php echo !empty($color->issuestatuscount)?$color->issuestatuscount:'';?>
                            </span>
                        </a> 
                        
                    </li>
                <?php endforeach;
            endif; ?>
            <?php 
            if(!empty($return_count)):
                foreach ($return_count as $key => $return):
                  ?>
                  
                  <li  class="<?php echo $return->coco_statusname; ?>">
                    <a href="javascript:void(0)" data-approvedtype='<?php echo $return->coco_statusname; ?>' class="approvetype">
                        <em class="<?php echo $return->coco_statusname; ?>"></em>
                        <?php echo $return->coco_displaystatus; ?> 
                        <span id="<?php echo $return->coco_statusname; ?>"><?php echo !empty($return->issuestatuscount)?$return->issuestatuscount:'';?>
                    </span>
                </a> 
                
            </li>
        <?php endforeach;
    endif; ?>
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
         var srchtext = $('#srchtext').val();
        var frmDate=$('#frmDate').val();
        var toDate=$('#toDate').val();
        var locationid=$('#locationid').val();
        var apptype='<?php echo $apptype; ?>';
        var searchDateType = $('#searchDateType').val();

        if(searchDateType == 'date_all'){
            var frmDate = '';
            var toDate = '';
        }

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
              aoData.push({ "name": "srchtext","value": srchtext });
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

$(document).off('change','#searchByType')
$(document).on('click', '#searchByDate', function() {
      srchtext = $('#srchtext').val();
    frmDate = $('#frmDate').val();
    toDate = $('#toDate').val();
    locationid=$('#locationid').val();
    searchDateType = $('#searchDateType').val();

    if(searchDateType == 'date_all'){
        frmDate = '';
        toDate = '';
    }

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
          srchtext = $('#srchtext').val();
        frmDate=$('#frmDate').val();
        toDate=$('#toDate').val();  
        type=$('#searchByType').val();
        locationid=$('#locationid').val(); 
        searchDateType = $('#searchDateType').val();

        if(searchDateType == 'date_all'){
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
                // console.log(jsons);
                data = jQuery.parseJSON(jsons);  
                var cancel=0;
                var issuereturn=0;
                var returncancel=0;
                var cancel=0; 
                // console.log(data);
                $('#issue').html('');
                $('#cancel').html('');
                $('#issuereturn').html('');
                $('#returncancel').html('');
                if(data.status=='success'){
                    issuedata=data.status_count;
                    issue=issuedata.issue;
                    cancel=issuedata.cancel;
                    issuereturn=returndata.issue_ret;
                    returncancel=returndata.ret_cancel;        
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
    $(document).off('change','#searchDateType');
    $(document).on('change','#searchDateType',function(){
        var search_date_val = $(this).val();

        if(search_date_val == 'date_all'){
            $('.dateRangeWrapper').hide();
        }else{
            $('.dateRangeWrapper').show();
        }
    });
</script>