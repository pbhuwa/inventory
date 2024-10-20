<h3 class="box-title">List of Preventive Maintenance  <a href="javascript:void(0)" class="btnRefresh"><i class="fa fa-refresh pull-right"></i></a></h3>
<?php 
$segment=$this->uri->segment(4);
// echo $segment;
// die();
 ?>
<div class="site_modal_tab">
  <ul class="nav nav-tabs">
    <li <?php if($segment=='' && $segment!='prior') echo 'class="active"';  ?>><a  href="<?php echo base_url('biomedical/pm_data/pm_data_list'); ?>">Upcoming PM Data </a></li>
    <li  <?php if($segment=='prior') echo 'class="active"'; ?>><a  href="<?php echo base_url('biomedical/pm_data/pm_data_list/prior'); ?>">Prior PM Data</a></li>
  </ul>

  <div class="tab-content white-box pad-10">
    <button class="float_btn excel"><i class="fa fa-file-excel-o"></i></button>
    <?php if($segment==''): ?>
    <div id="upcoming_pm_data" class="tab-pane fade in <?php if($segment=='' && $segment!='prior') echo 'active'; ?>">
      <div class="table-responsive scroll">
             <table id="pmdatatable" class="table table-striped dataTable">
                <thead>
                    <tr>
                        <th width="3%">S.N.</th>
                        <th width="8%">Equip. ID</th>
                         <th width="12%">Description</th>
                        <th width="10%">Department</th>
                        <th width="10%">Room</th>
                        <th width="15%">Risk</th>
                        <th width="10%">Manufacture</th>
                        <th width="10%">Distributor</th>
                        <th width="10%">PM Date(AD)</th>
                        <th width="10%">PM Date(BS)</th>
                        <th width="15%">Remarks</th>
                        <th width="15%">Status</th>
                         <th width="15%">PM Complete</th>
                        
                    </tr>
                </thead>
                <tbody>
                          
                </tbody>
            </table>
        </div>
    </div>
  <?php endif; ?>
 <?php if($segment=='prior'): ?>
  
       <div id="priar" class="tab-pane fade in <?php if($segment=='prior') echo 'active'; ?>">
      <div class="table-responsive scroll">
             <table id="pmdatatable" class="table table-striped dataTable">
                <thead>
                    <tr>
                        <th width="3%">S.N.</th>
                        <th width="8%">Equip. ID</th>
                         <th width="12%">Description</th>
                        <th width="10%">Department</th>
                        <th width="10%">Room</th>
                        <th width="15%">Risk</th>
                        <th width="10%">Manufacture</th>
                        <th width="10%">Distributor</th>
                        <th width="10%">PM Date(AD)</th>
                        <th width="10%">PM Date(BS)</th>
                        <th width="15%">Remarks</th>
                        <th width="15%">Status</th>
                        <th width="15%">PM Complete</th>
                        
                    </tr>
                </thead>
                <tbody>
                          
                </tbody>
            </table>
        </div>
    </div>
   
 <?php endif; ?>

  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
  var status='<?php echo !empty($status)?$status:''; ?>'
    var frmDate=$('#frmDate').val();
    var toDate=$('#toDate').val();  
    var dataurl = base_url+"biomedical/pm_data/get_pm_record/"+status;//alert(dataurl);
    var dtablelist = $('#pmdatatable').dataTable({
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
      "type":"POST",   
      "sAjaxSource":dataurl,
      "oLanguage": {
        "sEmptyTable":   "<p class='text-danger'>No Record Found!! </p>"
      }, 
      "aoColumnDefs": [
      {
        "bSortable": false,
        "aTargets": [ 0,6 ]
      }
      ],      
      "aoColumns": [
      { "data": "equipid"},
      { "data": "equipmentkey"},
      { "data": "equidesc"},
      { "data": "department" },
       { "data": "room" },
      { "data": "risk_val" },
      { "data": "manufacture" },
      { "data": "distributor" },
      { "data": "pmta_pmdatead" },
      { "data": "pmta_pmdatebs" },
      { "data": "pmta_remarks" },
      { "data": "pmta_status" },
       { "data": "ispmcomplete" },
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
      { type: "text" },
      { type: "text" },
      ]
    });
  });
</script>