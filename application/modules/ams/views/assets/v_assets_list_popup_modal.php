<style type="text/css">
  .table>tbody>tr>td, .table>tbody>tr>th {
    vertical-align: middle !important;
    white-space: normal !important;
}
.table-striped tbody tr td:last-child {
  text-align: left;
}
</style>
<div class="table-responsive">

  <div class="row">

    <div class="form-group">

      <div class="col-sm-7">

         <input style="width:300px" type="text" name="srchtxt" class="form-control text_filter" id="srchtxt" placeholder="Assets Code/Item Name/Assets Description"  >

      </div>

    </div>

  </div>

  <div class="clear"></div>

 <div class="table-responsive">

                    <table id="myTable_assets" class="table table-striped keypresstable">

                        <thead>

                            <tr>
                                <th width="5%"><?php echo $this->lang->line('sn'); ?></th>
                                <th width="10%">Assets Code</th>
                                 <th width="15%">Item Name</th>
                                <th width="10%">Manual Code</th>
                                <th width="25%">Description</th>
                                <th width="8%">Category</th>
                                <th width="15%">Department</th>
                                <th width="5%">Purchase Date</th>
                                <th width="10%">Rate</th>
                                <th width="15%">Remarks</th>
                            </tr>

                        </thead>

                        <tbody>

                                  

                        </tbody>

                    </table>

                </div>

  





<script type="text/javascript">

     $(document).ready(function(e){

    var rowno='<?php echo $rowno; ?>';
    var frombranch=$('#from_schoolid').val();
    var fromdepid=$('#fromdepid').val();
    var fromsubdepid=$('#from_subdepid').val();   

    var srchtxt=$('#srchtxt').val();

    var dataurl = base_url+"ams/assets/get_list_of_assets_bypopup/<?php echo $rowno;?>";

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



    // need to check modules permission in general

    message="<p class='text-danger'>No Record Found!! </p>";

 

 // var dtable = $('#myTable_assets').dataTable();



 

    var dtablelist = $('#myTable_assets').dataTable({

      "sPaginationType": "full_numbers"  ,

      "bSearchable": false,

      "lengthMenu": [[15, 30, 45, 60,100,200,500, -1], [15, 30, 45, 60,100,200,500, "All"]],

      'iDisplayLength': 20,

      "sDom": 'ltipr',

      "bAutoWidth":false,

      "autoWidth": true,

      "aaSorting": [[0,'asc']],

      "bProcessing":true,

      "bServerSide":true,    

      "sAjaxSource":dataurl,

      "oLanguage": {

       "sEmptyTable":message   

      }, 

      "aoColumnDefs": [

      {

        "bSortable": false,

        "aTargets": [0,,4,5,6,7]

      }

      ],      

      "aoColumns": [

      {"data": null},

      {"data": "asen_assetcode"},
      {"data": "asen_item"},
      {"data": "asen_assestmanualcode"},
       {"data": "asen_desc"},
      {"data": "eqca_category"},
      {"data": "dept_depname" },
      {"data": "asen_purchasedate"},
      {"data": "asen_purchaserate"},
      {"data": "asen_remarks"},
      
      ],

     

      "fnServerParams": function (aoData) {
        aoData.push({ "name": "searchtext", "value": srchtxt });
        aoData.push({ "name": "frombranch", "value": frombranch });
        aoData.push({ "name": "fromdepid", "value": fromdepid });
        aoData.push({ "name": "fromsubdepid", "value": fromsubdepid });
      },

      "fnRowCallback" : function(nRow, aData, iDisplayIndex){

             var oSettings = dtablelist.fnSettings();

            $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);





            return nRow;

        },

        "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {

            var rowno=aData.rowno;

           // alert('A'+rowno);

            var asen_asenid=aData.asen_asenid;

            var asen_assetcode=aData.asen_assetcode;
            var asen_item=aData.asen_item;

            var asen_desc=aData.asen_desc;

            var purchaserate=aData.asen_purchaserate;

            var last_depdate=aData.asen_last_depdate;

            var last_depnetval=aData.asen_last_depnetval;

            var last_deprecid=aData.asen_last_deprecid;

          

            var oSettings = dtablelist.fnSettings();

            var tblid = oSettings._iDisplayStart+iDisplayIndex +1

            var statusclass=aData.statusClass;

            $(nRow).attr('class', statusclass);

            $(nRow).attr('id', 'listid_'+tblid);

            $(nRow).attr('data-rowid',tblid);

            $(nRow).attr('data-rowno',rowno);

            $(nRow).attr('data-asen_assetcode',asen_assetcode);

            $(nRow).attr('data-asen_item',asen_item);

            $(nRow).attr('data-asen_desc',asen_desc);

            $(nRow).attr('data-asen_asenid',asen_asenid);

            $(nRow).attr('data-purrate',purchaserate);

            $(nRow).attr('data-last_depdate',last_depdate);

            $(nRow).attr('data-last_depnetval',last_depnetval);

            $(nRow).attr('data-last_deprecid',last_deprecid);



            $(nRow).addClass('itemDetail');

            if(tblid==1)

            {



               $(nRow).addClass('selected');

                 // var keyevent=e.keyCode;

               

                 // setTimeout(function(){

                  // $('#modal-title').click();

                  // model_keypress();

                   // }, 1000);

               // $('#modal-title').click();

            }



             // model_keypress();

      },

       

    }).columnFilter(

    {

      sPlaceHolder: "head:after",

      aoColumns: [ { type: null },

      {type: "text"},

      { type: "text" },

      { type: "text" },

       { type: null },

      { type: null },

       { type: "text" },

    

      ]

    });



     $(document).on('keyup','#srchtxt',function(){

      srchtxt=$('#srchtxt').val();

       dtablelist.fnDraw();       

    })





});







</script>



<script type="text/javascript">

  // $(document).ready(function(){

    var dtablelist = $('#myTable_assets').dataTable();

     setTimeout(function(){

    model_keypress();

       }, 500);

  // })



$(document).ready(function(){

  setTimeout(function(){

  $('#srchtxt').focus();

    }, 700);

});

</script>





