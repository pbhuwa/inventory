<h3 class="box-title">List of Services Techs  <a href="javascript:void(0)" class="btnRefresh"><i class="fa fa-refresh pull-right"></i></a></h3>
  <div class="pad-5">
    <div class="table-responsive">
        <table id="myTable" class="table table-striped">
            <thead>
                <tr>
                    <th width="10%">Tech.ID</th>
                    <th width="20%">Name </th>
                    <th width="20%">WorkPhone</th>
                    <th width="15%">Email</th>
                    <th width="15%">Address1</th>
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
        var rslt='<?php echo !empty($result)?$result:''; ?>';
        var org_id='<?php echo !empty($org_id)?$org_id:''; ?>';
        var dataurl = base_url+"biomedical/service_techs/get_servicetech/"+rslt+'/'+org_id;
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
          "sPaginationType": "full_numbers" ,
          
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
            "aTargets": [ 5 ]
          }
          ],      
          "aoColumns": [
           { "data": "sete_techid" },
           { "data": "name" },
           { "data": "workphone" },
           { "data": "email" },
           { "data": "address1" },
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
          aoColumns: [ {type: "text"},
          { type: "text" },
          { type: "text" },
          { type: "text" },
          { type: "text" },
          { type: null },
         
          ]
        });

    });
</script>