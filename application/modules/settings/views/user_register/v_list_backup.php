    
    <div class="pad-5">
        <div class="table-responsive">
            <table id="myTable" class="table table-striped ">
                <thead>
                    <tr>
                 <th><?php echo $this->lang->line('sn'); ?></th>
                <th><?php echo $this->lang->line('username'); ?></th>
                <th><?php echo $this->lang->line('full_name'); ?></th>
                <th><?php echo $this->lang->line('department'); ?></th>
                <th><?php echo $this->lang->line('phone'); ?></th>
                <th>Post Date(BS)</th>
                <th>Post Date (AD)</th>
                <th>Status</th>
                <th>IsActive</th>
                <th><?php echo $this->lang->line('action'); ?></th>
                    </tr>
                </thead>
                <tbody>
                          
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="Applyresponse" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body">
           <div id="response_error" class="alert alert-danger" ></span>
            <div id="response_apply_success" class="alert alert-success" ></span>
         </div>
          <div class="text-right">
             <button type="button" id="btnEmailSend" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
   </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){

    var dataurl = base_url+"settings/user_register/reister_user_list";
    var message='';
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
        "aTargets": [ 0,7]
      }
      ],      
      "aoColumns": [
       { "data": "sno" },
       { "data": "usre_username" },
       { "data": "usre_fullname" },
       { "data": "usre_departmentid" },
       { "data": "usre_phoneno" },
       { "data": "usre_postdatebs" },
        { "data": "usre_postdatead" },
         { "data": "status" },
         { "data": "isactive" },
       { "data": "action" }
      ],
      "fnServerParams": function (aoData) {
        // aoData.push({ "name": "frmDate", "value": frmDate });
        // aoData.push({ "name": "toDate", "value": toDate });
      },
      "fnRowCallback" : function(nRow, aData, iDisplayIndex){
             var oSettings = dtablelist.fnSettings();
            $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
            return nRow;
        },
        "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {
             var oSettings = dtablelist.fnSettings();
            var tblid= oSettings._iDisplayStart+iDisplayIndex +1

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
      { type: "text" },
       { type: null },
       { type: null },
      { type: null },
     
      ]
    });

});
</script>
<script>
  
   $(document).off('click', '.bs_change_status');
    $(document).on('click','.bs_change_status',function(){ 
    var id=$(this).data('id');
    var current_status=$(this).data('status');
     var url=$(this).data('viewurl');
     
      if(current_status==1){
      var checkname='InActive';
    }
    if(current_status==0){
      var checkname='Active';
    }
 var conf = confirm('Are You Sure To '+checkname+' This User ?');
  if(conf){
    $.ajax({  
          url:url,  
          method:"post",
          data:{id:id,current_status:current_status},
           success: function(jsons)
            {
              console.log(jsons);
                data = jQuery.parseJSON(jsons);
                if(data.status=='success')
                {
                     $('#Applyresponse').modal('show');
                     $('#response_apply_success').html(data.message);
                     window.location.reload();
                }
                else
                {
                    $('#Applyresponse').modal('show');
                    $('#response_error').html(data.message);
                     window.location.reload();
                }
            }  
        });
     }
    });
</script>
