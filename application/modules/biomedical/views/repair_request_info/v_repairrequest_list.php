<input type="hidden" id="ListUrl" value="<?php if(!empty($listurl)) echo $listurl; ?>" >
<input type="hidden" id="rrType" value="<?php if(!empty($rrtype)) echo $rrtype; ?>"/>
<?php
  $sess_orgid = $this->session->userdata('org_id');
?>
<div class="row">
  <div class="col-sm-12">
  <div id="TableDiv">
  <div class="white-box">
      <?php
        $rrtitle = (!empty($rrtype) && ($rrtype == 'completed'))?"Completed":"Information";
      ?>
      <h3 class="box-title">Repair Request <?php echo $rrtitle; ?> <a href="javascript:void(0)" class="btnRefresh"><i class="fa fa-refresh pull-right"></i></a></h3>
      <div class="pad-5">
          <div class="table-responsive scroll">
               <table id="repairTableInfo" class="table table-striped dataTable">
                  <thead>
                      <tr>
                          <th width="3%">S.n.</th>
                          <th width="5%">Date(AD)</th>
                          <th width="5%">Date(BS)</th>
                          <th width="5%">Time</th>
                          <th width="8%">Equip.ID</th>
                          <th width="8%">Department</th>
                          <th width="8%">Room</th>
                          <th width="8%">Prob.Type</th>
                          <th width="20%">Problem</th>
                          <th width="30%">Action Taken</th>
                          <th width="5%">Status</th>
                          <th width="5%">Action</th>

                      </tr>
                  </thead>
                  <tbody>
                            
                  </tbody>
              </table>
          </div>
      </div>
  </div>
</div>
</div>
</div>
</div>
</div>

<div id="myModal1" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Repair Request Confirmation Box</h4>
            </div>
            <form id="reoairInformationComment" action="<?php echo base_url('home/save_reopair_infromation_comment')?>" method="POST">
                <div class="modal-body pad-10">
                   <div id="confirmData"></div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="myModal2" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Repair Request Completed</h4>
            </div>
              <div id="CompletedData"></div>
        </div>
    </div>
</div>

<script>
	$(document).ready(function(){

    var frmDate=$('#frmDate').val();
    var toDate=$('#toDate').val();  
    var rslt='<?php echo !empty($result)?$result:'all'; ?>';
    var org_id='<?php echo !empty($org_id)?$org_id:$sess_orgid; ?>';
    var rrtype = $('#rrType').val();
    // alert(rrtype);
    if(rrtype){
      var dataurl = base_url+"biomedical/repair_request_info/lists/"+rslt+'/'+org_id+'/'+rrtype;
    }else{
      var dataurl = base_url+"biomedical/repair_request_info/lists/"+rslt+'/'+org_id;
    }
    var showview='<?php echo MODULES_VIEW; ?>';
    if(showview=='N')
    {
      message="<p class='text-danger'>Permission Denial</p>";
    }
    else
    {
      message="<p class='text-danger'>No Record Found!! </p>";
    }
    
    // alert(dataurl);
    var dtablelist = $('#repairTableInfo').dataTable({
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
        "sEmptyTable":   message,
      }, 
      "aoColumnDefs": [
      {
        "bSortable": false,
        "aTargets": [ 6 ]
      }
      ],      
      "aoColumns": [
       { "data": "id"},
       { "data": "postdatead"},
       { "data": "postdatebs"},
       { "data": "posttime"},
       { "data": "equipmentkey"},
       { "data": "department"},
       { "data": "room"},
       { "data": "problemtype"},
       { "data": "problem"},
       { "data": "action_taken"},
       { "data": "status"},
       { "data": "action"}

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
     
      ]
    });
  });
</script>

<script>
    $(document).off('click','#repairStatus');
    $(document).on('click','#repairStatus', function(){
        var commentid = $(this).data('commentid');
        var requestid = $(this).data('requestid');
        var status = $(this).data('status');
        // alert(commentid);
        if(status == '0'){
          $('#myModal1').modal('show');
          $.ajax({
              type: "POST",
              url: base_url+'biomedical/repair_request_info/viewRepairStatus',
              data:{commentid:commentid, requestid:requestid},
              dataType: 'json',
              success: function(datas) {
                  // alert(datas.message);
                  if(datas.status=='success')
                  {
                      $('#confirmData').html(datas.repairdata);
                  }
              }
          });
        }else{
          $('#myModal2').modal('show');
          $.ajax({
              type: "POST",
              url: base_url+'biomedical/repair_request_info/repairRequestCompleted',
              data:{commentid:commentid, requestid:requestid},
              dataType: 'json',
              success: function(datas) {
                  // alert(datas.message);
                  if(datas.status=='success')
                  {
                      $('#CompletedData').html(datas.completeData);
                  }
              }
          });
        }
    });
</script>