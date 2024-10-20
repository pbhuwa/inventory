<style>
    .table-striped tbody tr.pending td{
        color:#FF8C00;
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
    .table-striped tbody tr.cntissue td{  
        color:#e65555;
    }
</style>    
<div class="searchWrapper">       
     
    <div class="row"> 
        <form class="col-sm-12"> 
            <?php echo $this->general->location_option(3); ?>
            <div class="col-md-2">
            <label for="example-text">Disposal Type:</label>
                <select name="disposal_type" id="disposal_type" class="form-control select2" >
                <option value="">---All---</option>
                <?php
                    if(!empty($desposaltype)):
                        foreach ($desposaltype as $key => $dety):
                ?>
                <option value="<?php echo $dety->dety_detyid; ?>"><?php echo $dety->dety_name; ?></option>
                <?php
                        endforeach;
                    endif;
                ?>
                </select>
            </div>
            <div class="col-md-2">
            <label for="example-text">Department:</label>
                <select name="department_id" id="department_id" class="form-control select2" >
                <option value="">---All---</option>
                <?php
                    if(!empty($department_list)):
                        foreach ($department_list as $key => $dep):
                ?>
                <option value="<?php echo $dep->dept_depid; ?>"><?php echo $dep->dept_depname; ?></option>
                <?php
                        endforeach; 
                    endif;
                ?>
                </select>
            </div>
            <div class="col-md-1">
                <label for="range">Range</label>
                <select name="range" id="range" class="form-control">
                    <option value="all">All</option>
                    <option value="range">Range</option>
                </select>    
            </div>
            <div id="date_range" style="display: none">
            <div class="col-md-1">
                <label><?php echo $this->lang->line('from_date'); ?> :</label>
                <input type="text" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
            </div>
            <div class="col-md-1">
                <label><?php echo $this->lang->line('to_date'); ?>:</label>
                <input type="text" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
            </div>    
            </div>
            <div class="col-md-2">
            <label for="search_text">Search</label>
            <input type="text" name="search_text" id="search_text" placeHolder="Search Customer|Manual No.|Disposal No" class="form-control">
            </div>
         
            <div class="col-md-2">
                <a class="btn btn-info" id="searchSalesDisposalSummary" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
            <div class="sm-clear"></div>
          
            <div class="clearfix"></div>
        </form> 
    </div>
    <div class="pull-right">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="ams/assets_sales_desposal/get_detail_list" data-location="ams/assets_sales_desposal/excel_export_detail" data-tableid="#disposalSummaryTable"><i class="fa fa-file-excel-o"></i></a>

        <a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="ams/assets_sales_desposal/get_detail_list" data-location="ams/assets_sales_desposal/pdf_export_detail" data-tableid="#disposalSummaryTable"><i class="fa fa-print"></i></a> 
    </div>
    <div class="clear"></div> 
</div>

<div class="pad-5">
    <div class="table-responsive">
        <table id="disposalSummaryTable" class="table table-striped serverDatatable keypresstable"  data-tableid="#disposalSummaryTable">
            <thead>
                <tr>
                    <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <!-- <th width="7%">Date(AD)</th>
                    <th width="7%">Date(BS)</th>
                    <th width="5%">Disposal Type</th>
                    <th width="5%">Disposal No.</th>
                    <th width="10%">Customer Name</th> -->
                    <th width="7%">Asset Code</th>
                    <th width="7%">Asset Desc.</th>
                    <th width="5%">Department Name</th>
                    <th width="5%">Room No.</th>
                    <th width="8%">Original Cost</th>
                    <th width="8%">Current Cost</th>
                    <th width="8%">Sales Cost</th>
                    <th width="8%">Remarks</th>
                    <th width="3%" style="text-align: center"><?php echo $this->lang->line('action'); ?></th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">

$(document).ready(function(){    
    let locationid=$('#locationid').val();
    let disposal_type=$('#disposal_type').val();
    let department_id=$('#department_id').val();
    let range =$('#range').val();
    let frmDate=$('#frmDate').val();
    let toDate=$('#toDate').val();
    let search_text =$('#search_text').val();

    var dataurl = base_url+"ams/assets_sales_desposal/get_detail_list";
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
    
    var firstTR = $('#disposalSummaryTable tbody tr:first');
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
    "aTargets": [ 0, 9]
    }
    ],
    "aoColumns": [
    { "data": null},
    { "data": "asset_code"},
    { "data": "asset_description"},
    { "data": "department_name" },
    { "data": "room_no" },
    { "data": "original_cost" },
    { "data": "current_cost" },
    { "data": "sales_cost" },
    { "data": "remarks" },
    { "data": "action" },
    ],
    "fnServerParams": function (aoData) {
        aoData.push({ "name": "locationid", "value": locationid });
        aoData.push({ "name": "disposal_type", "value": disposal_type });
        aoData.push({ "name": "department_id", "value": department_id });
        aoData.push({ "name": "range", "value": range });
        aoData.push({ "name": "frmDate", "value": frmDate });
        aoData.push({ "name": "toDate", "value": toDate });
        aoData.push({ "name": "search_text", "value": search_text });
      
    },
    "fnRowCallback" : function(nRow, aData, iDisplayIndex){
        // console.log(aData);

        var oSettings = dtablelist.fnSettings();
        $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
        return nRow;
    },
    "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {
        var viewurl =aData.viewurl;
        var oSettings = dtablelist.fnSettings();
        var tblid = oSettings._iDisplayStart+iDisplayIndex +1
        $(nRow).attr('id', 'listid_'+tblid);
        var tbl_id = iDisplayIndex + 1;
        $(nRow).attr('data-rowid',tbl_id);
    },
    }).columnFilter(
    {
        sPlaceHolder: "head:after",
        aoColumns: [ 
        { type: null },
        { type: "text"},
        { type: "text" },
        { type: "text" },
        { type: "text" },
        { type: "text" },
        { type: "text" },
        { type: "text" },
        { type: "text" },
        { type: null }, 
        ]
    });
   
    $(document).off('click','#searchSalesDisposalSummary')
    $(document).on('click','#searchSalesDisposalSummary',function(){
        locationid=$('#locationid').val();
        disposal_type=$('#disposal_type').val();
        department_id=$('#department_id').val();
        range =$('#range').val();
        frmDate=$('#frmDate').val();
        toDate=$('#toDate').val();
        search_text =$('#search_text').val();
        dtablelist.fnDraw();  
       
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

    $(document).off('change','#range');
    $(document).on('change','#range',function() {
        let value = $(this).val();
        if(value == 'range'){
            $('#date_range').show();
        }else{
            $('#date_range').hide();
        }
    });
</script>