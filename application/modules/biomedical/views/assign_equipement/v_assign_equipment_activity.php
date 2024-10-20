<div class="white-box">
  <div class="pad-5">
    <div class="scroll">
      <table class="table table-border table-striped table-site-detail dataTable" id="assign_activity">
        <thead>
          <tr>
            <th>Equip.ID</th>
            <th>Assign To</th>
            <th>Assign By</th>
            <th>Date</th>
            <th>Department</th>
            <th>Room</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
         
        </tbody>
      </table>
    </div>
  </div>
</div>


<script type="text/javascript">
     $(document).ready(function(){
    
    var frmDate=$('#frmDate').val();
    var toDate=$('#toDate').val();  
    var rslt='<?php echo !empty($result)?$result:''; ?>';
     var org_id='<?php echo !empty($org_id)?$org_id:''; ?>';

    var dataurl = base_url+"biomedical/assign_equipement/assign_equipement_list/"+rslt+'/'+org_id;
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

 
    var dtablelist = $('#assign_activity').dataTable({
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
        "aTargets": [ 0,5 ]
      }
      ],
       "aoColumns": [
       { "data": "equipkey" },
       { "data": "assign_to" },
       { "data": "assign_by" },
       { "data": "assign_date" },
       { "data": "depname" },
       { "data": "roomname" },
        { "data": "action" }
      ],
      "fnServerParams": function (aoData) {
        aoData.push({ "name": "frmDate", "value": frmDate });
        aoData.push({ "name": "toDate", "value": toDate });
      },
      // "fnRowCallback" : function(nRow, aData, iDisplayIndex){
      //        var oSettings = dtablelist.fnSettings();
      //       $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
      //       return nRow;
      //   },
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