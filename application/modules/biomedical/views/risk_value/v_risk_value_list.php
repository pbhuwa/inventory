<h3 class="box-title">List of Risk Values <a href="javascript:void(0)" class="btnRefresh"><i class="fa fa-refresh pull-right"></i></a></h3>
<div class="pad-5">
    <div class="table-responsive">
        <table id="myTable" class="table table-striped">
            <thead>
                <tr>
                    <th width="10%">S.n.</th>
                    <th width="25%">Risk </th>
                    <th width="10%">Risk Times </th>
                    <th width="20%">Comments</th>
                    <th width="15%">P.Date(AD)</th>
                      <th width="15%">P.Date(BS)</th>
                    <th width="15%">Action</th>
                </tr>
            </thead>
            <tbody>
                      
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
    
        var frmDate=$('#frmDate').val();
        var toDate=$('#toDate').val();  
        var dataurl = base_url+"biomedical/risk_value/get_risk_value";
        var showview='<?php echo MODULES_VIEW; ?>';
    // alert(showview);
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
            "aTargets": [6 ]
          }
          ],      
          "aoColumns": [
           { "data": "riva_riskid" },
           { "data": "risk" },
            { "data": "riva_times" },
           { "data": "comments" },
           { "data": "postdatead" },
           { "data": "postdatebs" },
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
          aoColumns: [ {type: null},
          { type: "text" },
          { type: "text" },
          { type: "text" },
          { type: "text" },
          { type: "text" },
          { type: null },
         
          ]
        });

    });
</script>
