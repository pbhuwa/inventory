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

    <div class="clear"></div>
</div>
<div class="pad-5">
    <div class="table-responsive">
        <table id="myTable" class="table table-striped">
            <thead>
                <tr class="tr_issue">
                    <th width="3%" style="text-align: center"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="6%"><?php echo $this->lang->line('test_item_id'); ?></th> 
                    <th width="6%"><?php echo $this->lang->line('item_code'); ?></th>
                     <th width="10%"><?php echo $this->lang->line('item_name'); ?></th>
                    <th width="6%"><?php echo $this->lang->line('date').'('.$this->lang->line('bs').')'; ?></th>
                    <th width="6%"><?php echo $this->lang->line('date').'('.$this->lang->line('ad').')'; ?></th>
                     <th width="7%"><?php echo $this->lang->line('status'); ?></th>
                   
                    <th width="7%"><?php echo $this->lang->line('action'); ?></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<!-- <?php
    $apptype = $this->input->post('dashboard_data');
    if($apptype){
        $apptype = $apptype; 
    }else{
        $apptype = "";
    }
?> -->
<script type="text/javascript">
$(document).ready(function(){
    var frmDate=$('#frmDate').val();
    var toDate=$('#toDate').val();
    // var locationid=$('#locationid').val();
    //  var sama_depid=$('#sama_depid').val();
    // var apptype='<?php echo $apptype; ?>';
    // var apptype='';
    var dataurl = base_url+"issue_consumption/test/test_item_list";
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
    "aTargets": [ 0,5]
    }
    ],
 
    "aoColumns": [
    { "data": null },
    { "data": "id" }, 
    { "data": "code" },
    { "data": "name" },
    { "data": "postdatebs" }, 
    { "data": "postdatead" }, 
    { "data": "status" },
    { "data": "action" }
    ],
    "fnServerParams": function (aoData) {
        aoData.push({ "name": "frmDate", "value": frmDate });
        aoData.push({ "name": "toDate", "value": toDate });
        // aoData.push({ "name": "locationid", "value": locationid });
        // aoData.push({ "name": "apptype", "value": apptype });
        // aoData.push({ "name": "sama_depid", "value": sama_depid });
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
        { type: "text" },
        { type: "text" },
        { type: null },
        ]
    });
var otherlinkdata=base_url+'issue_consumption/new_issue/issue_summary';

    var otherdata=get_other_ajax_data(otherlinkdata,frmDate,toDate,locationid,sama_depid);

    $(document).off('change','#searchByDate')
    $(document).on('click', '#searchByDate', function() {
        frmDate = $('#frmDate').val();
        toDate = $('#toDate').val();
        locationid=$('#locationid').val();
        sama_depid=$('#sama_depid').val();
        dtablelist.fnDraw();
         get_other_ajax_data(otherlinkdata,frmDate,toDate,locationid,sama_depid);  
    });

    $(document).off('click','.approvetype');
    $(document).on('click','.approvetype',function(){
        apptype= $(this).data('approvedtype');
        // alert(apptype);
        if(apptype == 'cancel' || apptype == 'issue' || !apptype){
            $('.tr_return').hide();
            $('.tr_issue').show();
        }else if(apptype == 'issuereturn' || apptype == 'returncancel'){
            $('.tr_return').show();
            $('.tr_issue').hide();
        }
        frmDate=$('#frmDate').val();
        toDate=$('#toDate').val();
        locationid=$('#locationid').val();   
        sama_depid=$('#sama_depid').val();   
        type=$('#searchByType').val(); 
        dtablelist.fnDraw();  
         get_other_ajax_data(otherlinkdata,frmDate,toDate,type);   
    });

    function get_other_ajax_data(action,frmdate=false,todate=false,othertype=false){
        var returndata=[];   
        $.ajax({
            type: "POST",
            url: action,
            // data:$('form#'+formid).serialize(),
            dataType: 'html',
            data:{frmdate:frmdate,todate:todate,othertype:othertype} ,
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