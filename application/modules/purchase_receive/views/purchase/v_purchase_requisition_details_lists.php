<style type="text/css">
    table.dataTable tbody tr.selected {
        background-color: #B0BED9;
    }
    table.dataTable tbody tr.pending {
        color: #ff8c00 !important;
    }
    table.dataTable tbody tr.approved {
        color: #0ab960 !important;
    }
</style>
<div class="searchWrapper">
    <div class="pull-right" style="margin-top:15px;">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="purchase_receive/purchase_requisition/purchase_requisition_details_list" data-location="purchase_receive/purchase_requisition/exportToExcelReqDetail" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="purchase_receive/purchase_requisition/purchase_requisition_details_list" data-location="purchase_receive/purchase_requisition/generate_pdfReqDetail" data-tableid="#myTable"><i class="fa fa-print"></i></a>
        <div class="sm-clear"></div>
    </div>
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
        <div class="col-sm-4">
          <!--   <div class="white-box pad-5">
                <ul class="index_chart">
                    <li>
                        <div class="approved"></div> <a href="javascript:void(0)" data-approvedtype='approved' class="approvetype"><?php echo $this->lang->line('approved_requisition'); ?></a>
                        <span id="approved"><?php echo !empty($status_count[0]->approved)?$status_count[0]->approved:'';?></span>
                    </li>
                    <li>
                        <div class="pending"></div><a href="javascript:void(0)" data-approvedtype='pending' class="approvetype"><?php echo $this->lang->line('pending_requisition'); ?></a> 
                        <span id="pending"><?php echo !empty($status_count[0]->pending)?$status_count[0]->pending:'';?></span>
                    </li>

                    <li>
                        <div class="cancel"></div><a href="javascript:void(0)" data-approvedtype='cancel' class="approvetype"><?php echo $this->lang->line('cancel_requisition'); ?></a> 
                        <span id="cancel"><?php echo !empty($status_count[0]->cancel)?$status_count[0]->cancel:'';?></span>
                    </li>
                    <div class="clearfix"></div>
                </ul>
            </div> -->
        </div>
    </div>
    <div class="clear"></div>
</div>
<div class="pad-5">
    <div class="table-responsive">
        <table id="myTable" class="table table-striped">
            <thead>
                <tr class="tr_issue">
                    <th width="2%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="6%"><?php echo $this->lang->line('req_no'); ?></th>
                    <th width="17%"><?php echo $this->lang->line('item_name'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('qty'); ?> </th>
                    <th width="6%"><?php echo $this->lang->line('unit'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('requisition_date'); ?></th>
                    <th width="3%"><?php echo $this->lang->line('time'); ?> </th>
                    <th width="10%"><?php echo $this->lang->line('fiscal_year'); ?></th>
                    <th width="9%"><?php echo $this->lang->line('approved_user'); ?></th>
                    <th width="9%"><?php echo $this->lang->line('approved_date'); ?></th>
                    <th width="6%"><?php echo $this->lang->line('issue_time'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('requisted_by'); ?></th>
                    <th width="14%"><?php echo $this->lang->line('remarks'); ?></th>
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
    var locationid = $('#locationid').val();
    var apptype='';
    var dataurl = base_url+"/purchase_receive/purchase_requisition/purchase_requisition_details_list";
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
    "sPaginationType": "full_numbers" ,
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
    "aTargets": [ 0,6,10, 12]
    }
    ],
    "aoColumns": [
    { "data": null},
    { "data": "pure_reqno"},
    { "data": "itli_itemname"},
    { "data": "purd_qty" },
    { "data": "purd_unit" },
    { "data": "pure_reqdatebs" },
    { "data": "pure_posttime" },
    { "data": "pure_fyear" },
    { "data": "approvaluser" },
    { "data": "pure_approveddatebs" },
    { "data": "issuetime" },
    { "data": "pure_appliedby" },
    { "data": "purd_remarks" },
    ],
    "fnServerParams": function (aoData) {
        aoData.push({ "name": "frmDate", "value": frmDate });
        aoData.push({ "name": "toDate", "value": toDate });
        // aoData.push({ "name": "type", "value": type });
        aoData.push({"name": "locationid","value": locationid});
        aoData.push({ "name": "apptype", "value": apptype });
    },
    "fnRowCallback" : function(nRow, aData, iDisplayIndex){
        var oSettings = dtablelist.fnSettings();
        $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
        return nRow;
    },
    "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {
        var appclass=aData.approvedclass;
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
        { type: null },
        { type: "text" },
        { type: "text" },
        { type: "text" },
        { type: null },
        { type: "text" },
        { type: null },
        
        ]
    });
    var otherlinkdata=base_url+'/purchase_receive/purchase_requisition/purchase_requisition_summary';

    var otherdata=get_other_ajax_data(otherlinkdata,frmDate,toDate);

    $(document).off('change','#searchByType')
    $(document).on('click', '#searchByDate', function() {
        frmDate = $('#frmDate').val();
        toDate = $('#toDate').val();
        locationid = $('#locationid').val();
        dtablelist.fnDraw();
        get_other_ajax_data(otherlinkdata,frmDate,toDate);  
    });

    $(document).off('click','.approvetype');
    $(document).on('click','.approvetype',function(){
        apptype= $(this).data('approvedtype'); //alert(apptype);
        frmDate=$('#frmDate').val();
        toDate=$('#toDate').val();  
        type=$('#searchByType').val(); 
        dtablelist.fnDraw();  
        get_other_ajax_data(otherlinkdata,frmDate,toDate,type,apptype);   
    });

    function get_other_ajax_data(action,frmdate=false,todate=false,othertype=false, apptype=false){
        var reqdata=[];   
        $.ajax({
            type: "POST",
            url: action,
            dataType: 'html',
            data:{frmdate:frmdate,todate:todate,othertype:othertype,apptype:apptype} ,
            success: function(jsons) 
            {
                data = jQuery.parseJSON(jsons);  
                var pending=0;
                var approved=0; 
                var cancel = 0;
                $('#approved').html('');
                $('#pending').html('');
                if(data.status=='success'){
                    issuedata=data.status_count;
                    //reqdata = data.return_count;
                    approved=issuedata[0].approved;
                    pending=issuedata[0].pending; 
                    cancel = issuedata[0].cancel;    
                }
                $('#approved').html(approved);
                $('#pending').html(pending);
                $('#cancel').html(cancel);
                return false;
            }   
        });
    }
});
</script>
