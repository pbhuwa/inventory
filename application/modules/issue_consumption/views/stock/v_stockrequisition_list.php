<style>
    .table-striped tbody tr.pending td{
        color:#FF8C00;
    }
    .table-striped tbody tr.approved td{
        color:#0ab960;
    }
    .table-striped tbody tr.unapproved td{
        color:#337ab7;
    }
    .table-striped tbody tr.cancel td{
        color:#e65555;
    }
    
    .table-striped tbody tr.verified td{
        color:#0174DF;
    }
    .table-striped tbody tr.cntissue td{
        color:#46433e !important;;
    }


 .chart_tab li.pending {
    background: darkorange !important;
    color: #fff;
}
.index_chart li.approved {
    background: #0ab960 !important;
    color: #fff;
}
.chart_tab li.n_approved {
    background: #0174df !important;
    color: #fff;
}
.chart_tab li.cancel {
    background: #e65555 !important;
    color: #fff;
}

.chart_tab li.verified {
    background: #03a9f3 !important;
    color: #fff;
}
.chart_tab li.cntissue {
    background:#46433e !important;
    color: #fff;
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
<div class="searchWrapper">
      <div class="pull-right">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="issue_consumption/stock_requisition/requisition_lists" data-location="issue_consumption/stock_requisition/exportToExcelReqlist" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="issue_consumption/stock_requisition/requisition_lists" data-location="issue_consumption/stock_requisition/generate_pdfReqlist" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>
    
    <div class="row clearfix">
        <form class="col-sm-12">
            <?php echo $this->general->location_option(); ?>
            <div class="col-md-2">
                <label><?php echo $this->lang->line('from_date'); ?> :</label>
                <input type="text" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
            </div>
            <div class="col-md-2">
                <label><?php echo $this->lang->line('to_date'); ?>:</label>
                <input type="text" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
            </div>
          
            <div class="col-md-2">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
            <div class="sm-clear"></div>
            <div class="col-md-2">
                <label><?php echo $this->lang->line('select_type'); ?></label>
                <select class="form-control" id="searchByType">
                    <option value="">All</option>
                    <option value="Y">Issue</option>
                    <option value="N">Transfer</option>
                </select>
            </div>
            <div class="clearfix"></div>
        </form> 
        <div class="col-sm-12">
            <div class="white-box pad-5 noborder">
                <?php if($this->session->userdata(USER_GROUPCODE)!='DM'): ?>
                <ul class="index_chart chart_tab">
                    <li class="pending">
                       <a href="javascript:void(0)" data-approvedtype='pending' class="approvetype"><em class="pending"> </em> <?php echo $this->lang->line('pending'); ?> 
                        <span id="pending"><?php echo !empty($status_count[0]->pending)?$status_count[0]->pending:'';?></span></a>
                    </li>
                    
                    <li class="approved">
                         <a href="javascript:void(0)" data-approvedtype='approved' class="approvetype" ><em class="approved"> </em><?php echo $this->lang->line('approved'); ?>
                        <span id="approved"><?php echo !empty($status_count[0]->approved)?$status_count[0]->approved:'';?></span></a>
                    </a>
                    </li>
                    
                    <li class="n_approved">
                        <a href="javascript:void(0)" data-approvedtype='unapproved' class="approvetype"><?php echo $this->lang->line('unapproved'); ?> 
                        <span id="unapproved"><em class="n_approved"> </em><?php echo !empty($status_count[0]->unapproved)?$status_count[0]->unapproved:'';?></span></a>
                    </li>
                    
                    <li class="cancel">
                         <a href="javascript:void(0)" data-approvedtype='cancel' class="approvetype" ><em class="cancel"> </em><?php echo $this->lang->line('canceled'); ?> 
                        <span id="cancel"><?php echo !empty($status_count[0]->cancel)?$status_count[0]->cancel:'';?></span></a>
                    </li>

                    <li class="verified">
                        <a href="javascript:void(0)" data-approvedtype='verified' class="approvetype" ><em class="verified"> </em><?php echo $this->lang->line('verified'); ?> 
                        <span id="verified"><?php echo !empty($status_count[0]->verified)?$status_count[0]->verified:'';?></span></a>
                    </li>

                    <li class="cntissue">
                        <a href="javascript:void(0)" data-approvedtype='cntissue' class="approvetype" ><em class="cntissue"> </em><?php echo $this->lang->line('total_rem_item'); ?> 
                        <span id="cntissue"><?php echo !empty($total_count[0]->cntissue)?$total_count[0]->cntissue:'';?></span></a>
                    </li>
                    <div class="clearfix"></div>
                    
                </ul>
            <?php endif; ?>
            </div>
        </div>
    </div>
  
    <div class="clear"></div>
</div>

<div class="pad-5">
    <div class="table-responsive">
        <table id="myTable" class="table table-striped serverDatatable keypresstable"  data-tableid="#myTable">
            <thead>
                <tr>
                    <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('req_date_ad'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('req_date_bs'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('req_no'); ?></th>
                    <th width="8%"><?php echo $this->lang->line('from'); ?></th>
                    <th width="8%"><?php echo $this->lang->line('store'); ?></th>
                    <th width="8%"><?php echo $this->lang->line('username'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('is_issue'); ?></th>
                    <th width="8%"><?php echo $this->lang->line('req_by'); ?></th>
                    <th width="8%"><?php echo $this->lang->line('approved_by'); ?></th>
                    <th width="8%"><?php echo $this->lang->line('manual_no'); ?></th>
                    <th width="6%"><?php echo $this->lang->line('item_rem'); ?></th>
                    <th width="8%"><?php echo $this->lang->line('fiscal_year'); ?></th>
                    <th width="9%" style="text-align: center"><?php echo $this->lang->line('action'); ?></th>
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
    function get_other_ajax_data(action,frmdate=false,todate=false,othertype=false,locationid=false){
 
        var returndata=[];   
        $.ajax({
            type: "POST",
            url: action,
            // data:$('form#'+formid).serialize(),
            dataType: 'html',
            data:{frmdate:frmdate,todate:todate,othertype:othertype,locationid:locationid} ,
            
            success: function(jsons) //we're calling the response json array 'cities'
            {
                // console.log(jsons);

                data = jQuery.parseJSON(jsons);  
                var pending=0;
                var  approved=0;
                var unapproved=0;
                var cancel=0;
                var cntissue=0; 
                var verified = 0; 
                // console.log(data);
                $('#pending').html('');
                $('#approved').html('');
                $('#unapproved').html('');
                $('#cancel').html('');
                $('#cntissue').html('');
                $('#verified').html('');
        
                if(data.status=='success')
                {
                    req_data=data.status_count;
                    req_total_data=data.total_count;
                    // console.log(req_data);
                    // console.log(req_data[0].pending)
                    pending=req_data[0].pending;
                    approved=req_data[0].approved;
                    unapproved=req_data[0].unapproved;
                    cancel=req_data[0].cancel;
                    verified = req_data[0].verified;
                    cntissue=req_total_data[0].cntissue;
                }
                $('#pending').html(pending);
                $('#approved').html(approved);
                $('#unapproved').html(unapproved);
                $('#cancel').html(cancel);
                $('#verified').html(verified);
                $('#cntissue').html(cntissue);
                return false;
            }
        });
    }

$(document).ready(function(){
     
    var frmDate=$('#frmDate').val();
    var toDate=$('#toDate').val();
    var locationid=$('#locationid').val();
    var fiscalyear=$('#fiscalyear').val();
    var type =$('#searchByType').val();
    // var apptype='';
    var apptype='<?php echo $apptype; ?>';
    var dataurl = base_url+"issue_consumption/stock_requisition/requisition_lists";
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

    var tableid = $('.serverDatatable').data('tableid');
    
    var firstTR = $('#myTable tbody tr:first');
    firstTR.addClass('selected');

    // console.log(formdata);

     $(tableid).on("draw.dt", function(){
        var rowsNext = $(tableid).dataTable().$("tr:first");
        rowsNext.addClass("selected");
    });

    var dtablelist = $(tableid).dataTable({
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
    "aTargets": [ 0, 7,11,12]
    }
    ],
    "aoColumns": [
    { "data": null},
    { "data": "postdatead"},
    { "data": "postdatebs"},
    { "data": "reqno" },
    { "data": "fromdep" },
    { "data": "todep" },
    { "data": "username" },
    { "data": "isdep" },
    { "data": "reqby" },
    { "data": "approvedby" },
    { "data": "manualno" },
    { "data": "cntitem" },
    { "data": "fyear" },
    { "data": "action" },
    ],
    "fnServerParams": function (aoData) {
        aoData.push({ "name": "frmDate", "value": frmDate });
        aoData.push({ "name": "toDate", "value": toDate });
        aoData.push({ "name": "locationid", "value": locationid });
        aoData.push({ "name": "type", "value": type });
        aoData.push({ "name": "fiscalyear", "value": fiscalyear });
        aoData.push({ "name": "apptype", "value": apptype });
    },
    "fnRowCallback" : function(nRow, aData, iDisplayIndex){
        // console.log(aData);

        var oSettings = dtablelist.fnSettings();
        $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
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
        { type: "text" },
        { type: "text" },
        { type: "text" },
        { type: "text" },
        { type: null },
        { type: "text" },
        { type: null },
        ]
    });
    var otherlinkdata=base_url+'issue_consumption/stock_requisition/requisition_summary';
    // var formdata=[];
    //  formdata= [{frmDate:frmDate,toDate:toDate,type:type}];
    // // formdata['frmDate'] = frmDate;
    // formdata['toDate'] = toDate;
    // var postdata=$.serialize(formdata);
    var otherdata=get_other_ajax_data(otherlinkdata,frmDate,toDate,type,locationid);
    // console.log(otherdata);
    // var pending=otherdata.pending;
    // console.log(pending);


    $(document).off('click','#searchByDate')
    $(document).on('click','#searchByDate',function(){
        frmDate=$('#frmDate').val();
        toDate=$('#toDate').val();  
        locationid=$('#locationid').val();
        type=$('#searchByType').val(); 
        dtablelist.fnDraw();  
        get_other_ajax_data(otherlinkdata,frmDate,toDate,type,locationid);   
    });

    $(document).off('change','#searchByType')
    $(document).on('change','#searchByType',function(){
        type=$('#searchByType').val();
        dtablelist.fnDraw();  
    });

    $(document).off('click','.approvetype');
    $(document).on('click','.approvetype',function(){
       apptype= $(this).data('approvedtype');
        // alert(apptype);
        frmDate=$('#frmDate').val();
        toDate=$('#toDate').val();  
        type=$('#searchByType').val();
        fiscalyear=$('#fiscalyear').val(); 
        locationid=$('#locationid').val();
        dtablelist.fnDraw();  
        // get_other_ajax_data(otherlinkdata,frmDate,toDate,type);   
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
            // alert(prime_id);
        });

        $(document).off('keydown');
        $(document).bind('keydown',function(){   
            // alert('test');    
            selectedTR = $(tableid).find('.selected');
           
            var rowid = selectedTR.data('rowid');
            var numRow = selectedTR.data('numRow');
            var numTR = $(tableid+' tr').length-1;

            var keypressed = event.keyCode;
            // console.log(keypressed);

            if(keypressed == '40' && rowid < numTR){
                selectedTR.removeClass('selected');
                nextTR = selectedTR.next('tr');

                nextTR.addClass('selected');
                req_masterid = nextTR.data('masterid');
                setTimeout(function(){
                    nextTR.focus();
                }, 100);
            }

            if(keypressed == '38' && rowid != '1'){
                selectedTR.removeClass('selected');
                prevTR = selectedTR.prev('tr');

                prevTR.addClass('selected');
                req_masterid = prevTR.data('masterid');
                setTimeout(function(){
                    prevTR.focus();
                }, 100);
            }

            if(keypressed == '13'){
                selectedTR.click();
                // console.log( $(this).closest('tr').attr('id'));
                selectedTR.addClass('selected');
            }
        });

});

</script>

<script type="text/javascript">
    $(document).off('click','.btnredirect');
    $(document).on('click','.btnredirect',function(){
        var id=$(this).data('id');
        var url=$(this).data('viewurl');
        var redirecturl=url;
        $.redirectPost(redirecturl, {id:id });
    })
</script>