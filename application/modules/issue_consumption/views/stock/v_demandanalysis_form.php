<style>
    .table-striped tbody tr.pending td{
        color:#ffb122;
    }
    .table-striped tbody tr.approved td{
        color:#0ab960;
    }
    .table-striped tbody tr.unapproved td{
        color:#03a9f3;
    }
    .table-striped tbody tr.cancel td{
        color:#e65555;
    }
</style>
<div class="searchWrapper">

    <div class="row">
        <form class="col-sm-12">

             <?php echo $this->general->location_option(2); ?>
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
                <label><?php echo $this->lang->line('status'); ?></label>
                <select class="form-control" name="status" id="status">
                <option value="">All</option>
                 <option value="pending">Pending</option>
                 <option value="approved">Approved</option>
                </select>
            </div>
            
            <div id="transferData"></div>
            
            <div class="col-md-2">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
            <div class="clearfix"></div>
        </form> 
    </div>
 
    <div class="clear"></div>
</div>

<div class="pad-5">
    <div class="table-responsive">
        <table id="myTable" class="table table-striped serverDatatable" data-tableid="#myTable">
            <thead>
                <tr>
                    <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('item_code'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('item_name'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('demand_count'); ?></th>
                    <th width="5%"><?php echo $this->lang->line('demand_quantity'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('stock_quantity'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('diff'); ?></th>
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
    var status=$('#status').val();
    var storeid=$('#storeid').val();
    var type =$('#searchByType').val();
      var locationid=$('#locationid').val();
      var searchDateType = $('#searchDateType').val();

        if (searchDateType == 'date_all') {
            frmDate = '';
            toDate = '';
        }

// alert(depid);
// alert(store_id);
    var tableid = $('.serverDatatable').data('tableid');

    var firstTR = $(tableid+' tbody tr:first');
    firstTR.addClass('selected');

    var apptype='';
    var dataurl = base_url+"issue_consumption/stock_requisition/demand_analysis_lists";
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
    "aTargets": [ 0,5,6]
    }
    ],
    "aoColumns": [
    { "data": null},
    { "data": "itli_itemcode"},
    { "data": "itli_itemname"},
    { "data": "demand_cnt"},
    { "data": "demandqty" },
    { "data": "stockqty" },
    { "data": "diff" }
    ],
    "fnServerParams": function (aoData) {
        aoData.push({ "name": "frmDate", "value": frmDate });
        aoData.push({ "name": "toDate", "value": toDate });
         aoData.push({ "name": "locationid", "value": locationid });
         aoData.push({ "name": "status", "value": status });
        aoData.push({ "name": "storeid", "value": storeid });
    },
    "fnRowCallback" : function(nRow, aData, iDisplayIndex){
        // console.log(aData);

        var oSettings = dtablelist.fnSettings();
        $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
        return nRow;
    },
    // "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {
    //     var viewurl =aData.viewurl;
    //     var prime_id=aData.prime_id;
    //     var heading=aData.reqby;

    //     var appclass=aData.approvedclass;
    //     var oSettings = dtablelist.fnSettings();
    //     var tblid = oSettings._iDisplayStart+iDisplayIndex +1
    //     $(nRow).attr('id', 'listid_'+tblid);
    //     $(nRow).attr('class', appclass);

    //     var tbl_id = iDisplayIndex + 1;

    //     $(nRow).attr('data-rowid',tbl_id);
    //     $(nRow).attr('data-viewurl',viewurl);
    //     $(nRow).attr('data-id',prime_id);
    //     $(nRow).attr('data-heading',heading);
    //     $(nRow).addClass('view');
    // },
    }).columnFilter(
    {
        sPlaceHolder: "head:after",
        aoColumns: [ { type: null },
        { type: "text" },
        { type: "text" },
        { type: null },
        { type: null },
        { type: null },
       
        ]
    });

    $(document).off('click','#searchByDate')
    $(document).on('click','#searchByDate',function(){
        frmDate=$('#frmDate').val();
        toDate=$('#toDate').val();
        depid=$('#depid').val();
        storeid=$('#storeid').val();  
        type=$('#searchByType').val(); 
         locationid=$('#locationid').val();
         searchDateType = $('#searchDateType').val();

            if (searchDateType == 'date_all') {
                frmDate = '';
                toDate = '';
            }
         status=$('#status').val();
        dtablelist.fnDraw();  
       // get_other_ajax_data(otherlinkdata,frmDate,toDate,type);   
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