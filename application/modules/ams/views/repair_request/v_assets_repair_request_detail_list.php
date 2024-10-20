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
             <?php echo $this->general->location_option(2); ?>
            <div class="col-md-2">
                <label>Department:</label>
                <select name="departmentid" class="form-control select2 depselect" id="departmentid">
                <option value="">--All--</option>
                <?php
                 if(!empty($department_list)):
                  foreach ($department_list as $ks => $dlist):
                    ?>
                    <option value="<?php echo $dlist->dept_depid; ?>"><?php echo $dlist->dept_depname; ?></option>
                    <?php
                  endforeach;
                endif;
                ?>
            </select>
            </div>
            <div class="col-md-2">
            <label>Filter Type</label>
            <select name="filtertype" class="form-control" id="filtertype">
                <option value="range">Range</option>
                <option value="all">All</option>
            </select>
        </div>

            <div class="col-md-2 daterange">
                <label><?php echo $this->lang->line('from_date'); ?> :</label>
                <input type="text" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
            </div>
            <div class="col-md-2 daterange">
                <label><?php echo $this->lang->line('to_date'); ?>:</label>
                <input type="text" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
            </div>
        
            <div class="col-md-2">
                <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
            </div>
            <div class="sm-clear"></div>
          
            <div class="clearfix"></div>
        </form> 
    </div>
    <div class="pull-right">
        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="ams/repair_request/list_asset_repair_request_detail" data-location="ams/repair_request/exportToExcelDirect" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>

<a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="ams/repair_request/list_asset_repair_request_detail" data-location="ams/repair_request/generate_pdfDirect" data-tableid="#myTable"><i class="fa fa-print"></i></a>
    </div>
    <div class="clear"></div>
</div>

<div class="pad-5">
    <div class="table-responsive">
        <table id="myTable" class="table table-striped serverDatatable keypresstable"  data-tableid="#myTable">
            <thead>
                <tr>
                    <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                    <th width="7%">Date(AD)</th>
                    <th width="7%">Date(BS)</th>
                    <th width="10%">Req.No.</th>
                    <th width="10%">Department</th>
                    <th width="8%"><?php echo $this->lang->line('fiscal_year'); ?></th>
                    <th width="5%">Assets Code</th>
                    <th width="10%">Description</th>
                    <th width="10%">Problem</th>
                    
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
    var departmentid =$('#departmentid').val();
    var filtertype =$('#filtertype').val();

    var dataurl = base_url+"ams/repair_request/get_repair_request_detail_list";
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
    "aTargets": [ 0, 8]
    }
    ],
    "aoColumns": [
    { "data": null},
    { "data": "datead"},
    { "data": "datebs"},
    { "data": "requestno"},
    { "data": "depname" },
    { "data": "fiscalyrs"},
    { "data": "assets_code"},
    { "data": "description"},
    { "data": "problem"},
   


    ],
    "fnServerParams": function (aoData) {
        aoData.push({ "name": "frmDate", "value": frmDate });
        aoData.push({ "name": "toDate", "value": toDate });
        aoData.push({ "name": "locationid", "value": locationid });
        aoData.push({ "name": "departmentid", "value": departmentid });
        aoData.push({ "name": "filtertype", "value": filtertype });
      
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
        aoColumns: [ { type: null },
        {type: "text"},
        { type: "text" },
        { type: "text" },
        { type: "text" },
        { type: null },
        { type: null },
        { type: null },
        { type: null },
       
        ]
    });

  
   
    $(document).off('click','#searchByDate')
    $(document).on('click','#searchByDate',function(){
        frmDate=$('#frmDate').val();
        toDate=$('#toDate').val();
        locationid=$('#locationid').val();
        departmentid =$('#departmentid').val();
        filtertype =$('#filtertype').val();
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
</script>


<script type="text/javascript">
    $(document).off('change','#transfertypeid');
    $(document).on('change','#transfertypeid',function(){
        var search_date_val = $(this).val();

        if(search_date_val == 'D'){
            $('.branchWrapper').hide();
        }else{
            $('.branchWrapper').show();
        }

        if(search_date_val == 'B'){
            $('.departmentWrapper').hide();
        }else{
            $('.departmentWrapper').show();
        }
    });
    
    $(document).off('change','#filtertype');
    $(document).on('change','#filtertype',function(e){
        var ftype=$(this).val();
        if(ftype=='range'){
            $('.daterange').show();
        }else{
            $('.daterange').hide();
        }
    });

</script>