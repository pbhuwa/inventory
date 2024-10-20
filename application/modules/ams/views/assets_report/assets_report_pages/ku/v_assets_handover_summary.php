<?php 
$this->locationid = $this->session->userdata(LOCATION_ID);
$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
?>
<div class="searchWrapper">
    <div class="pad-5">
        <div class="form-group">
         <div class="row">  
      <div class="col-md-2">

           <label>Handover From</label>
           <select name="handoverfrom_staffid" class="form-control select2" id="handoverfrom_staffid">
             <option value="">--All--</option>
             <?php 
             if(!empty($receiver_list)):
                foreach($receiver_list as $recl ):
              ?>
              <option value="<?php echo $recl->stin_staffinfoid; ?>"><?php echo $recl->stin_fname.' '.$recl->stin_mname.' '.$recl->stin_lname ?></option>
              <?php
            endforeach;
             endif;
             ?>

           </select>

         </div>

           <div class="col-md-2">
           <label>Handover To</label>
           <select name="handoverto_staffid" class="form-control select2" id="handoverto_staffid">
             <option value="">--All--</option>
             <?php 
             if(!empty($receiver_list)):
                foreach($receiver_list as $recl ):
              ?>
              <option value="<?php echo $recl->stin_staffinfoid; ?>"><?php echo $recl->stin_fname.' '.$recl->stin_mname.' '.$recl->stin_lname ?></option>
              <?php
            endforeach;
             endif;
             ?>
           </select>

         </div>
           <div class="col-md-1">
            <label>Date Filter By</label>
            <select name="filtertype" class="form-control" id="filtertype">
                <option value="range">Range</option>
                <option value="all">All</option>
            </select>
        </div>
        <div class="col-md-1 daterange">
         <label><?php echo $this->lang->line('from_date'); ?> :</label>
         <input type="text" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
            </div>
            <div class="col-md-1 daterange">
                <label><?php echo $this->lang->line('to_date'); ?>:</label>

                <input type="text" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>

            </div>

           <div class="col-md-1">
            <label>Refno</label>
            <input type="text" name="refno" class="form-control" id="refno">
           </div>
            
        <div class="col-md-1">
            <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
        </div>
        </div>
        <div class="clearfix"></div> 

       
       </div>

  </div>
</div>
<div class="pad-5">

    <div class="table-responsive">

        <table id="myhandoversummary" class="table table-striped serverDatatable keypresstable"  data-tableid="#myhandoversummary">

            <thead>

                <tr>

                    <th width="5%">S.n</th>
                    <th width="7%">FYear</th>
                    <th width="7%">Refno.</th>
                    <th width="10%">Date (AD)</th>
                    <th width="10%">Date (Bs) </th>
                    <th width="20%">Handover From</th>
                    <th width="20%">Handover To</th>
                    <th width="5%">Assets Cnt</th>
                    <th width="10%">Entry Date</th>
                    <th width="10%">Action</th>

                </tr>
            </thead>

            <tbody>

                

            </tbody>

        </table>

    </div>

</div>


 

<script type="text/javascript">
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


<script type="text/javascript">

$(document).ready(function(){    
    var handoverfrom_staffid=$('#handoverfrom_staffid').val();
    var handoverto_staffid=$('#handoverto_staffid').val();
    var filtertype=$('#filtertype').val();
    var frmDate=$('#frmDate').val();
    var toDate=$('#toDate').val();
    var refno=$('#refno').val();

    var dataurl = base_url+"ams/assets_handover/get_assets_handover_summary";

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

    

    var firstTR = $('#myhandoversummary tbody tr:first');

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
    { "data": "fyear"},
    { "data": "refno"},
    { "data": "handoverdatead" },
     { "data": "handoverdatebs" },
    { "data": "fromstaffname" },
    { "data": "tostaffname" },
    { "data": "assetcount" }, 
    { "data": "entrydate"},
    { "data": "action" },
    

    ],

    "fnServerParams": function (aoData) {
        aoData.push({ "name": "handoverfrom_staffid", "value": handoverfrom_staffid });
        aoData.push({ "name": "handoverto_staffid", "value": handoverto_staffid });
        aoData.push({ "name": "filtertype", "value": filtertype });
        aoData.push({ "name": "frmDate", "value": frmDate });
        aoData.push({ "name": "toDate", "value": toDate });
        aoData.push({ "name": "refno", "value": refno });
     
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
        {type: "text"}, 
        { type: "text" },
        { type: "text" },
        {type: "text"}, 
        {type: "text"}, 
        { type: "text" },
        { type: null },
        { type: "text" }
        ]

    });

   

    $(document).off('click','#searchByDate')
    $(document).on('click','#searchByDate',function(e){
        handoverfrom_staffid=$('#handoverfrom_staffid').val();
        handoverto_staffid=$('#handoverto_staffid').val();
        filtertype=$('#filtertype').val();
        frmDate=$('#frmDate').val();
        toDate=$('#toDate').val();
        refno=$('#refno').val();
        dtablelist.fnDraw();  
    });

});



</script>