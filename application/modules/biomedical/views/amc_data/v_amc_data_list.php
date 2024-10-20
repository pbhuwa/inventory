<h3 class="box-title">List of AMC Detail  <a href="javascript:void(0)" class="btnRefresh"><i class="fa fa-refresh pull-right"></i></a></h3>
  <div class="pad-5">
      <div class="table-responsive scroll">
           <table id="pmdatatable" class="table table-striped dataTable">
              <thead>
                  <tr>
                      <th width="10%"><?php echo $this->lang->line('sn'); ?></th>
                      <th width="10%"><?php echo $this->lang->line('equipment_id'); ?></th>
                       <th width="10%"><?php echo $this->lang->line('description'); ?></th>
                      <th width="15%"><?php echo $this->lang->line('department'); ?></th>
                      <th width="15%"><?php echo $this->lang->line('room'); ?></th>
                      <th width="15%"><?php echo $this->lang->line('risk'); ?></th>
                      <th width="15%"><?php echo $this->lang->line('manufacture'); ?></th>
                      <th width="15%"><?php echo $this->lang->line('distributor'); ?></th>
                    
                  </tr>
              </thead>
              <tbody>
                        
              </tbody>
          </table>
      </div>
  </div> 
<script type="text/javascript">
$(document).ready(function(){
    var frmDate=$('#frmDate').val();
    var toDate=$('#toDate').val();  
    var dataurl = base_url+"biomedical/amc_data/get_amc_alert";//alert(dataurl);
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