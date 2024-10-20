<div style="margin: 10">
<a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="ams/asset_decommission/reload_decom" data-location="ams/asset_decommission/exportToExcelDirect" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

<a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="ams/asset_decommission/reload_decom" data-location="ams/asset_decommission/generate_pdfDirect" data-tableid="#myTable"><i class="fa fa-print"></i></a>
</div>
<div class="clear"></div>
</div>
<div class="pad-5">
    <div class="table-responsive">
        <table id="myTable" class="table table-striped serverDatatable keypresstable"  data-tableid="#myTable" width="100%">
            <thead>
                <tr>
                    <th width="2%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="7%"><?php echo $this->lang->line('asset_docommission_code'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('asset_date_AD'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('asset_date_BS'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('asset_docommission_time'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('asset_docommission_reason'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('asset_docommission_method'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('asset_docommission_distype'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('action'); ?></th>
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
    var type =$('#searchByType').val();
    var apptype='';
    var dataurl = base_url+"ams/asset_decommission/decommission_from_inventory";
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

     $(tableid).on("draw.dt", function(){
        var rowsNext = $(tableid).dataTable().$("tr:first");
        rowsNext.addClass("selected");
    });

    var dtablelist = $(tableid).dataTable({
    "sPaginationType": "full_numbers"  ,

    "bSearchable": false,
    "lengthMenu": [[10, 20, 30, 40,50,100,200, -1], [10, 20, 30, 40,50,100,500, "All"]],
    'iDisplayLength': 10,
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
    "aTargets": [ 0, 8]
    }
    ],
    "aoColumns": [
    { "data": null},
    { "data": "asen_assetcode"},
    { "data": "deeq_postdatead"},
    { "data": "deeq_postdatebs"},
    { "data": "deeq_posttime"},
    {"data":"deeq_reason"},
    { "data": "deme_decomname" },
    { "data": "deeq_disposition" },
    { "data": "action" },
    ],
    "fnServerParams": function (aoData) {
        aoData.push({ "name": "frmDate", "value": frmDate });
        aoData.push({ "name": "toDate", "value": toDate });
        //aoData.push({ "name": "locationid", "value": locationid });
        //aoData.push({ "name": "fiscalyear", "value": fiscalyear });
        aoData.push({ "name": "type", "value": type });
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
         { type: null },
        { type: "text" },
        { type: null },
        { type: null },
        { type: null },
        // { type: null },
        // { type: null },
        // { type: null },
        ]
    });
    $(document).off('click','#searchByDate')
    $(document).on('click','#searchByDate',function(){
        frmDate=$('#frmDate').val();
        toDate=$('#toDate').val();
      //  fiscalyear=$('#fiscalyear').val();
        locationid=$('#locationid').val();
        type=$('#searchByType').val(); 
        dtablelist.fnDraw();
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
        locationid=$('#locationid').val();
        //fiscalyear=$('#fiscalyear').val();
        dtablelist.fnDraw();  
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

