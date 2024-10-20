  <h3 class="box-title">List of Pipezone Type<a href="javascript:void(0)" class="btnRefresh"><i class="fa fa-refresh pull-right"></i></a></h3>

            <div class="pad-5">

                <div class="table-responsive">

                    <table id="myTable" class="table table-striped dataTable">

                        <thead>

                            <tr>

                              <th width="10%"><?php echo $this->lang->line('sn'); ?> </th>

                                <th width="30%">Pipezone Type</th>
                                <th width="30%">Pipezone Category</th>
                                <th width="20%">Is active ?</th>
                                <th width="10%"><?php echo $this->lang->line('action'); ?></th>

                            </tr>

                        </thead>

                        <tbody>

                                  

                        </tbody>

                    </table>

                </div>

            </div>





<script type="text/javascript">

 $(document).ready(function()

  {

    var frmDate=$('#frmDate').val();

    var toDate=$('#toDate').val();  

    var dataurl = base_url+"settings/pipezone_type/get_pipezone_list";

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

        "aTargets": [ 4 ]

      }

      ],      

      "aoColumns": [

      { "data": null},

       { "data": "pipezone"},
       { "data": "pizo_parentid"},

       { "data": "pizo_isactive"},

       { "data": "action" }

      ],

      "fnServerParams": function (aoData) {

        aoData.push({ "name": "frmDate", "value": frmDate });

        aoData.push({ "name": "toDate", "value": toDate });

      },

      "fnRowCallback" : function(nRow, aData, iDisplayIndex){

             var oSettings = dtablelist.fnSettings();

            $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);

            return nRow;

        },

        "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {

             var oSettings = dtablelist.fnSettings();

            var tblid = oSettings._iDisplayStart+iDisplayIndex +1



        $(nRow).attr('id', 'listid_'+tblid);

      },

    }).columnFilter(

    {

      sPlaceHolder: "head:after",

      aoColumns: [ { type: null },

      {type: null},

      { type: null },

     

      ]

    });



  });

</script>