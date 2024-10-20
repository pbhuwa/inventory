<div class="row wb_form">
  <div class="col-sm-12">
    <div class="white-box">
      <h3 class="box-title"><?php echo $this->lang->line('issue_analysis_report'); ?></h3>
      <div class="clearfix"></div>
<div class="white-box pad-5 mtop_10 pdf-wrapper">
  <div class="jo_form organizationInfo" id="printrpt">

    <h3 class="box-title">
  <center><?php echo $this->lang->line('list_of_maintenance_logs');?> </center> <a href="javascript:void(0)" class="btnRefresh"><i class="fa fa-refresh pull-right"></i></a></h3>
  <div class="pad-5">
      <div class="table-responsive scroll">
           <table id="amcdatatable" class="table table-striped dataTable">
              <thead>
                  <tr>
                      <th width="5%">S.N.</th>
                      <th width="8%">Equip. ID</th>
                      <th width="13%">Equip. Description</th>
                      <th width="13%">Department</th>
                      <th width="8%">Room</th>
                      <th width="17%">Problem</th>
                      <th width="18%">Solution</th>
                      <th width="10%">Maintained By</th>
                      <th width="17%">Posted Time</th>
                      <th width="15%">Posted Date</th>

                    
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

<script type="text/javascript">
$(document).ready(function(){

    var frmDate=$('#frmDate').val();
    var toDate=$('#toDate').val();
    var dataurl = base_url+"biomedical/maintenance_log/get_mlog_summary";
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
    var dtablelist = $('#amcdatatable').dataTable({
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
    { "data": "equipid"}, 
    { "data": "equipmentkey"}, 
    { "data": "equidesc" },
    { "data": "department" },
    { "data": "problem" },
    { "data": "solution" },
    { "data": "maintained_by" },
    { "data": "posted_time" },
    { "data": "posted_date" },
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
        {type: "text"},
        { type: "text" },
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