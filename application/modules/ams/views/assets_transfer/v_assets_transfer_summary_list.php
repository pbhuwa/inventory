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

             <?php $transfertypeid=!empty($transfer_data_rec[0]->astm_transfertypeid)?$transfer_data_rec[0]->astm_transfertypeid:'' ?>

                <label>Transfer Type<span class="required">*</span>:</label>

                <select name="astm_transfertypeid" id="transfertypeid" class="form-control">

                    <option value="D" <?php if($transfertypeid=='D') echo "selected=selected"; ?>>Department</option>

                    <option value="B" <?php if($transfertypeid=='B') echo "selected=selected"; ?>>Branch</option>

                    

                </select>

            </div>

          <div class="departmentWrapper" >

            <div class="col-md-2">

                <label>Department From:</label>

                <select name="fromdepid" class="form-control select2 depselect" id="fromDepid">

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

                <label>Department To:</label>

                <select name="todepid" class="form-control select2 depselect" id="toDepid">

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

        </div>

         <div class="branchWrapper" style="display:none">

          <?php echo $this->general->location_option(2,'locationfrom','locationfrom',false,'From'); ?>

          <?php echo $this->general->location_option(2,'locationto','locationto',false,'To'); ?>

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

        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="ams/assets_transfer/list_asset_transfer_summary" data-location="ams/assets_transfer/exportToExcelDirectSummary" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>



<a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="ams/assets_transfer/list_asset_transfer_summary" data-location="ams/assets_transfer/generatesummary_pdfDirect" data-tableid="#myTable"><i class="fa fa-print"></i></a>

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

                    <th width="5%">Tra.No.</th>

                    <th width="5%">Tra. Type</th>

                    <th width="10%">Transfer From </th>

                    <th width="10%">Transfer To</th>

                    <th width="8%"><?php echo $this->lang->line('manual_no'); ?></th>

                    <th width="8%"><?php echo $this->lang->line('fiscal_year'); ?></th>

                    <th width="5">Assets Cnt</th>

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

    var frmDate=$('#frmDate').val();

    var toDate=$('#toDate').val();

    var locationid=$('#locationid').val();

    var fromDepid =$('#fromDepid').val();

    var toDepid =$('#toDepid').val();

    var transfertypeid=$('#transfertypeid').val();

    var locationfrom =$('#locationfrom').val();

    var locationto=$('#locationto').val();



    var dataurl = base_url+"ams/assets_transfer/get_assets_transfer_summary_list";

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

    "aTargets": [ 0, 9]

    }

    ],

    "aoColumns": [

    { "data": null},

    { "data": "datead"},

    { "data": "datebs"},

    { "data": "transferno" },

    { "data": "transfertype" },

    { "data": "from" },

    { "data": "to" },

    { "data": "manualno" },

    { "data": "fiscalyrs" },

    { "data": "noofassets" },

    { "data": "action" },

    ],

    "fnServerParams": function (aoData) {

        aoData.push({ "name": "frmDate", "value": frmDate });

        aoData.push({ "name": "toDate", "value": toDate });

        aoData.push({ "name": "locationid", "value": locationid });

        aoData.push({ "name": "fromDepid", "value": fromDepid });

        aoData.push({ "name": "toDepid", "value": toDepid });

        aoData.push({"name": "transfertypeid", "value":transfertypeid});

        aoData.push({"name": "locationfrom", "value":locationfrom});

        aoData.push({"name": "locationto", "value":locationto});

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

        { type: null },

        { type: "text" },

        { type: null },

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

         fromDepid =$('#fromDepid').val();

        toDepid =$('#toDepid').val();

        transfertypeid =$('#transfertypeid').val();

        locationfrom =$('#locationfrom').val();

        locationto =$('#locationto').val();

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