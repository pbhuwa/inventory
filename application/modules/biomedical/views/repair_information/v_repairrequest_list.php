<!-- <h4 class="modal-title">Repair Request Information</h4>
<div>
	<table class="table table-border table-striped table-site-detail dataTable">
		<tr>
			<td width="10%"><strong>Date(AD)</strong></td>
			<td width="10%"><strong>Date(BS)</strong></td>
			<td width="30%"><strong>Problem</strong></td>
			<td width="10%"><strong>Action</strong></td>
			<td width="15%"><strong>Technician</strong></td>
			<td width="15%"><strong>Report By</strong></td>
		</tr>
		
	<?php
		if(!empty($repair_information_list)):
			foreach($repair_information_list as $req):
				echo '<tr>';
				echo '<td>'.$req->rere_postdatead.'</td>';
				echo '<td>'.$req->rere_postdatebs.'</td>';
				echo '<td>'.$req->rere_problem.'</td>';
				echo '<td>'.$req->rere_action.'</td>';
				echo '<td>'.$req->rere_technician.'</td>';
				echo '<td>'.$req->rere_reported_by.'</td>';
				echo '</tr>';
			endforeach;
		endif;
	?>
	</table>
</div> -->

<div class="white-box">
    <h3 class="box-title">List of PM Data <a href="javascript:void(0)" class="btnRefresh"><i class="fa fa-refresh pull-right"></i></a></h3>
    <div class="pad-5">
        <div class="table-responsive scroll">
             <table id="pmdatatable" class="table table-striped dataTable">
                <thead>
                    <tr>
                        <th width="10%">Id</th>
                        <th width="10%">Date(AD)</th>
                        <th width="10%">Date(BS)</th>
                        <th width="15%">Problem</th>
                        <th width="15%">Action</th>
                    </tr>
                </thead>
                <tbody>
                          
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
	$(document).ready(function(){

    var frmDate=$('#frmDate').val();
    var toDate=$('#toDate').val();  
    var dataurl = base_url+"biomedical/pm_data/get_pm_alert";
    //alert(dataurl);
    var dtablelist = $('#pmdatatable').dataTable({
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
        "sEmptyTable":   "<p class='text-danger'>No Record Found!! </p>"
      }, 
      "aoColumnDefs": [
      {
        "bSortable": false,
        "aTargets": [ 7 ]
      }
      ],      
      "aoColumns": [
       { "data": "rere_repairrequestid"},
       { "data": "rere_postdatead"},
       { "data": "rere_postdatebs" },
       { "data": "rere_problem" },
       { "data": "action" },

    
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