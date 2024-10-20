<style type="text/css">
    table.dataTable tbody tr.selected {
        background-color: #B0BED9;
    }
    table.dataTable tbody tr.active {
        background-color: #B0BED9 !important;
    }
    table.dataTable tbody tr.pending  {
        color: #e65555 !important;
    }
    table.dataTable tbody tr.issuereturn {
        color: #0174DF !important;
    }
    table.dataTable tbody tr.returncancel {
        color: #FF8000 !important;
    }
</style>
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
            <div class="white-box pad-5">
                <ul class="index_chart">
                    <li>
                        <div class="primary"></div> <a href="javascript:void(0)" data-approvedtype='pending' class="approvetype"><?php echo $this->lang->line('pending'); ?></a>
                        <span id="pending"><?php echo !empty($status_count[0]->pending)?$status_count[0]->pending:'';?></span>
                    </li>
                    <li>
                        <div class="warning"></div><a href="javascript:void(0)" data-approvedtype='approved' class="approvetype"> <?php echo $this->lang->line('approved'); ?></a> 
                        <span id="approved"><?php echo !empty($status_count[0]->approved)?$status_count[0]->approved:'';?></span>
                    </li>
                  <!--   <li>
                        <div class="success"></div><a href="javascript:void(0)" data-approvedtype='received' class="approvetype"> <?php echo $this->lang->line('received'); ?></a> 
                        <span id="received"><?php echo !empty($status_count[0]->received)?$status_count[0]->received:'';?></span>
                    </li> -->
                    <div class="clearfix"></div>
                </ul>
            </div>
        </div>
        <div class="pull-right" style="margin-top:15px;">
        <!-- 
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="issue_consumption/stock_transfer/stock_transfer_details_list" data-location="issue_consumption/stock_transfer/exportToExcelTransferDetail" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="issue_consumption/stock_transfer/stock_transfer_details_list" data-location="issue_consumption/stock_transfer/generate_pdfTransferDetail" data-tableid="#myTable"><i class="fa fa-print"></i></a> 
        -->
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="issue_consumption/stock_transfer/stock_transfer_details_list" data-location="issue_consumption/stock_transfer/search_stock_transfer_detail_excel" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="issue_consumption/stock_transfer/stock_transfer_details_list" data-location="issue_consumption/stock_transfer/search_stock_transfer_detail_pdf" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>
    </div>
    <div class="clear"></div>
</div>
<div class="pad-5">
    <div class="table-responsive">
        <table id="myTable" class="table table-striped">
            <thead>
                <tr class="tr_issue">
                    <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('transfer_number'); ?></th>
                    <th width="8%"><?php echo $this->lang->line('transfer_date'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('fiscal_year'); ?></th>
                    <th width="8%"><?php echo $this->lang->line('location_from'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('location_to'); ?></th>
                    <th width="8%"><?php echo $this->lang->line('requested_by'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('item_code'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('item_name'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('unit'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('request_qty'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('remarks'); ?></th>
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
        var dataurl = base_url+"issue_consumption/stock_transfer/stock_transfer_details_list";
        var message='';
        var showview='<?php echo MODULES_VIEW; ?>';
        
 if (showview == 'N') {
            message = "<p class='text-danger'>Permission Denial</p>";
        } else {
            message = "<p class='text-danger'>No Record Found!! </p>";
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
        "aTargets": [ 0, 11]
        }
        ],
     
        "aoColumns": [
        { "data": null},
        { "data": "tfma_transferno"},
        { "data": "transferdate" },
        { "data": "tfma_fiscalyear" },
        { "data": "fromlocation" },
        { "data": "tolocation" },
        { "data": "tfma_transferby" },
        { "data": "itli_itemcode" },
        { "data": "itli_itemname" },
        { "data": "unit_unitname" },
        { "data": "tfde_reqtransferqty"},
        { "data": "tfde_remarks"}
        ],
        "fnServerParams": function (aoData) {
            aoData.push({ "name": "frmDate", "value": frmDate });
            aoData.push({ "name": "toDate", "value": toDate });
            aoData.push({ "name": "locationid", "value": locationid });
            // aoData.push({ "name": "type", "value": type });
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
            { type: "text" },
            { type: "text" },
            { type: "text" },
            { type: "text" },
            { type: "text" },
            { type: "text" }
            ]
        });
        var otherlinkdata=base_url+'issue_consumption/stock_transfer/stock_transfer_summary';

        var otherdata=get_other_ajax_data(otherlinkdata,frmDate,toDate,locationid);

        $(document).off('change','#searchByType')
        $(document).on('click', '#searchByDate', function() {
            frmDate = $('#frmDate').val();
            toDate = $('#toDate').val();
            locationid=$('#locationid').val();
            dtablelist.fnDraw();
            get_other_ajax_data(otherlinkdata,frmDate,toDate,locationid);  
        });

        $(document).off('click','.approvetype');
        $(document).on('click','.approvetype',function(){
            apptype= $(this).data('approvedtype');
            $('#returnDate').html('<span class="filter_column filter_text"><input type="text" class="search_init text_filter" value="Return Date"></span>');
            frmDate=$('#frmDate').val();
            toDate=$('#toDate').val();  
            type=$('#searchByType').val();
            locationid=$('#locationid').val(); 
            dtablelist.fnDraw();  
            // get_other_ajax_data(otherlinkdata,frmDate,toDate,type);   
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
                    var approved=0;
                    var  issuereturn=0;
                    // var returncancel=0;
                    var cancel=0; 
                    console.log(data);
                    $('#pending').html('');
                    $('#approved').html('');
                    $('#received').html('');
                    if(data.status=='success'){
                        scount = data.status_count[0];
                        pending=scount.pending;
                        approved=scount.approved;
                        received=scount.received;      
                    }
                    $('#pending').html(pending);
                    $('#approved').html(approved);
                    $('#received').html(received);
                    return false;
                }   
            });
        }
    });
</script>