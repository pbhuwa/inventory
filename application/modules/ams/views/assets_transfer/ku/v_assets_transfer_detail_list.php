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
<style type="text/css">

  .table>tbody>tr>td:not(:last-child), .table>tbody>tr>th {

    vertical-align: middle !important;

    white-space: normal !important;

}

</style>

<div class="searchWrapper">

    

    <div class="row">

        <div class="row">

        <form class="col-sm-12">
              <div class="departmentWrapper" >
            <?php 
             $locationlist=$this->general->get_tbl_data('*','loca_location',array('loca_status'=>'O')); 
            // $this->general->location_option(3,'from_schoolid','from_schoolid',false,'/ School From'); ?>
             <div class="col-md-3">
              <label>From School</label>
            <select name="from_schoolid" id="from_schoolid" class="form-control">
            <option value="0">All</option>
            <?php
            // echo "<pre>";
            // print_r($locationlist);
            // die();
            if(!empty($locationlist)):
              foreach($locationlist as $loc):
              ?>
              <option value="<?php echo $loc->loca_locationid; ?>" <?php if($loc->loca_locationid==$locationid) echo "selected=selected"; ?>  ><?php echo $loc->loca_name; ?></option>
              <?php
              endforeach;
            endif;
             ?>
             </select>
           </div>

            <div class="col-md-3">

                <label>Department From:</label>

                <select name="fromdepid" class="form-control select2 depselect" id="fromdepid">

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

            <?php 

             $subdepid=''; 

             if(!empty($sub_department)):

                $displayblock='display:block';

             else:

                $displayblock='display:none';

             endif;

             ?>

            <div class="col-md-3" id="fromsubdepdiv" style="<?php echo $displayblock; ?>" >

                 <label for="example-text">From Sub Department:</label>

                  <select name="from_subdepid" id="from_subdepid" class="form-control" >

                    <?php if(!empty($sub_department)): ?>

                          <option value="">--All--</option>

                          <?php foreach ($sub_department as $ksd => $sdep):

                            ?>

                            <option value="<?php echo $sdep->dept_depid; ?>" <?php if($sdep->dept_depid==$subdepid) echo "selected=selected"; ?> ><?php echo $sdep->dept_depname; ?></option>

                    <?php endforeach; endif; ?>

                  </select>

            </div>
<div class="col-md-3">
  <label>To School</label>
    <select name="to_schoolid" id="to_schoolid" class="form-control">
 <option value="0">All</option>
            <?php
            // echo "<pre>";
            // print_r($locationlist);
            // die();

            if(!empty($locationlist)):
              foreach($locationlist as $loc):
              ?>
              <option value="<?php echo $loc->loca_locationid; ?>" ><?php echo $loc->loca_name; ?></option>
              <?php
              endforeach;
            endif;
             ?>
             </select>
</div>
            <div class="col-md-3">

                <label>Department To:</label>

                <select name="todepid" class="form-control select2 depselect" id="todepid">

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

            <?php 

             $subdepid=''; 

             if(!empty($sub_department)):

                $displayblock='display:block';

             else:

                $displayblock='display:none';

             endif;

             ?>

            <div class="col-md-3" id="tosubdepdiv" style="<?php echo $displayblock; ?>" >

                 <label for="example-text">To Sub Department:</label>

                  <select name="to_subdepid" id="to_subdepid" class="form-control" >

                    <?php if(!empty($sub_department)): ?>

                          <option value="">--All--</option>

                          <?php foreach ($sub_department as $ksd => $sdep):

                            ?>

                            <option value="<?php echo $sdep->dept_depid; ?>" <?php if($sdep->dept_depid==$subdepid) echo "selected=selected"; ?> ><?php echo $sdep->dept_depname; ?></option>

                    <?php endforeach; endif; ?>

                  </select>

            </div>

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

        <a class="btn btn-success btn_excel generate_export_file" id="excel" data-type="excel" data-dataurl="ams/assets_transfer/list_asset_transfer_detail" data-location="ams/assets_transfer/exportToExcelDirect" data-tableid="#myTable"><i class="fa fa-file-excel-o"></i></a>



<a class="btn btn-info btn_pdf generate_export_file" id="print" data-type="pdf" target="_blank" data-dataurl="ams/assets_transfer/list_asset_transfer_detail" data-location="ams/assets_transfer/generate_pdfDirect" data-tableid="#myTable"><i class="fa fa-print"></i></a>

    </div>

    <div class="clear"></div>

</div>



<div class="pad-5">

    <div class="table-responsive">

        <table id="myTable" class="table table-striped serverDatatable keypresstable"  data-tableid="#myTable">

            <thead>

                <tr>

                   <th width="3%">S.N</th>
                   <th width="5%">Trans.Date(AD)</th>
                   <th width="5%">Trans.Date(BS)</th>
                   <th width="5%">Trans.No</th>
                   <th width="10%">Assets Code</th>
                   <th width="15%">Item Name</th>
                    <th width="25%">Description</th>
                   <th width="25%">From</th>
                   <th width="25%">To</th>
                   <th width="25%">Previous Owner</th>
                   <th width="25%">Received By</th>
                   <th width="8%" align="right">Cost</th>
                   <th width="8%" align="right">Remarks</th>
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
    var from_schoolid=$('#from_schoolid').val();
    var fromDepid =$('#fromdepid').val();
    var subdepid=$('#from_subdepid').val();
    var to_schoolid=$('#to_schoolid').val();
    var toDepid =$('#todepid').val();
    var to_subdepid =$('#to_subdepid').val();



    var dataurl = base_url+"ams/assets_transfer/get_assets_transfer_detail_list";

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

        // rowsNext.addClass("selected");

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

    "aTargets": [ 0, 6,7,8,9,10,11,12]

    }

    ],

    "aoColumns": [

    { "data": null},

    { "data": "astm_transferdatead"},
    { "data": "astm_transferdatebs"},
    { "data": "astm_transferno"},
    { "data": "astd_assetsid"},
    { "data": "itemname" },
    { "data": "astd_assetsdesc" },
    { "data": "from" },
    { "data": "to" },
    { "data": "previous_staffname" },
    { "data": "received_by" },
    { "data": "astd_originalamt" },
    { "data": "astd_remark" },
    ],

    "fnServerParams": function (aoData) {
        aoData.push({ "name": "frmDate", "value": frmDate });
        aoData.push({ "name": "toDate", "value": toDate });
        aoData.push({ "name": "from_schoolid", "value": from_schoolid });
        aoData.push({ "name": "fromDepid", "value": fromDepid });
        aoData.push({ "name": "subdepid", "value": subdepid });
        aoData.push({ "name": "to_schoolid", "value": to_schoolid });
        aoData.push({ "name": "toDepid", "value": toDepid });
        aoData.push({ "name": "to_subdepid", "value": to_subdepid });   
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
        { type: "text" },

        { type: null },

        { type: null },

         { type: null },

        { type: null },

        { type: null },

        ]

    })
    $(document).off('click','#searchByDate')

    $(document).on('click','#searchByDate',function(){
        frmDate=$('#frmDate').val();
        toDate=$('#toDate').val();
        from_schoolid=$('#from_schoolid').val();
        fromDepid =$('#fromdepid').val();
        subdepid=$('#from_subdepid').val();
        to_schoolid=$('#to_schoolid').val();
        toDepid =$('#todepid').val();
        to_subdepid =$('#to_subdepid').val();
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

$(document).off('change','#from_schoolid,#to_schoolid');

    $(document).on('change','#from_schoolid,#to_schoolid',function(e){

        var id = $(this).attr('id');

        var schoolid=$(this).val();

        var submitdata = {schoolid:schoolid};

        var submiturl = base_url+'issue_consumption/stock_requisition/get_department_by_schoolid';


        ajaxPostSubmit(submiturl,submitdata,beforeSend,onSuccess);

        function beforeSend(){

          };

         function onSuccess(jsons){

                    data = jQuery.parseJSON(jsons);

                    if(data.status=='success'){

                      if(id == 'from_schoolid'){

                        $('#fromsubdepdiv').hide();

                       $('#fromdepid').html(data.dept_list);     
                      }else{
                        $('#tosubdepdiv').hide();

                        $('#todepid').html(data.dept_list);
                      }


                    }

                    else{
                      if(id == 'from_schoolid'){

                        $('#fromdepid').html(' <option value="">--All--</option>');

                        $("#fromdepid").select2("val", "");

                        $("#from_subdepid").select2("val", "");
                      }else{
                        $('#todepid').html(' <option value="">--All--</option>');

                        $("#todepid").select2("val", "");

                        $("#to_subdepid").select2("val", "");
                      }

                    }
                }
    });



    


    $(document).off('change','#fromdepid,#todepid');

    $(document).on('change','#fromdepid,#todepid',function(e){

        var id = $(this).attr('id');

        var depid=$(this).val();

        var submitdata = {schoolid:depid};

        var submiturl = base_url+'issue_consumption/stock_requisition/get_department_by_schoolid';

        // aletr(schoolid);

         // $("#to_subdepid").select2("val", "");

         // $('#to_subdepid').html('');

         ajaxPostSubmit(submiturl,submitdata,beforeSend,onSuccess);

        function beforeSend(){

                
          };

         function onSuccess(jsons){

                    data = jQuery.parseJSON(jsons);

                     if(data.status=='success'){

                      if (id == 'fromdepid') {

                        $('#fromsubdepdiv').show();

                         $('#from_subdepid').html(data.dept_list);
                      }else{
                        $('#tosubdepdiv').show();

                         $('#to_subdepid').html(data.dept_list);
                      }


                     }else{
                      if (id == 'fromdepid') {
                         $('#fromsubdepdiv').hide();

                        $('#from_subdepdiv').html();

                      }else{
                        $('#tosubdepdiv').hide();

                        $('#to_subdepdiv').html();
                      }
                     }
                }
              });

</script>
