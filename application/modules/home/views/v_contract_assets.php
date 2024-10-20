<div class="wb_form">
            <div class="white-box">
               <h3 class="box-title"> <?php echo $this->lang->line('contract_alert'); ?><a href="javascript:void(0)" class="commentRefresh" data-tableid="tblcontractor"><i class="fa fa-refresh pull-right"></i></a></h3>
               <div class="pad-5">
                  <div class="table-responsive">
                     <table id="tblcontractor"  class="table table-striped dataTable">
                        <thead>
                           <tr>
                              <th width="5%"> <?php echo $this->lang->line('sn'); ?></th>
                              <th width="10%"> <?php echo $this->lang->line('contractor_type'); ?></th>
                              <th width="20%"> <?php echo $this->lang->line('name'); ?></th>
                              <th width="15%"> <?php echo $this->lang->line('title'); ?></th>
                              <th width="15%"> <?php echo $this->lang->line('start_date'); ?></th>
                              <th width="15%"> <?php echo $this->lang->line('end_date'); ?></th>
                              <th width="10%"> <?php echo $this->lang->line('status'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
<script type="text/javascript">
   $(document).ready(function(){
     
     var frmDate=$('#frmDate').val();
     var toDate=$('#toDate').val(); 
  
     var dataurl_pma = base_url+"home/get_contractor/";
     //alert(dataurl);
         //$("#repairRequesttble").dataTable().fnDestroy();
     var dtablelist = $('#tblcontractor').dataTable({
       "sPaginationType": "full_numbers"  ,
       
       "bSearchable": false,
       "lengthMenu": [[15, 30, 45, 60,100,200,500, -1], [15, 30, 45, 60,100,200,500, "All"]],
       'iDisplayLength': 5,
       "sDom": 'ltipr',
       "bAutoWidth":false,
             "fnDestroy":true,
             "Destroy":true,
       "autoWidth": false,
       "aaSorting": [[0,'desc']],
       "bProcessing":true,
       "bServerSide":true,    
       "sAjaxSource":dataurl_pma,
       "oLanguage": {
         "sEmptyTable":   "<p class='text-danger'>No Record Found!! </p>"
       }, 
       "aoColumnDefs": [
       {
         "bSortable": false,
         "aTargets": [0,1,2,3,4,5, 6 ]
       }
       ],      
       "aoColumns": [
        { "data": "coin_contractinformationid"},
        { "data": "coin_contracttypeid"},
        { "data": "coin_distributorid" },
        { "data": "coin_contracttitle" },
        { "data": "coin_contractstartdatead" },
        { "data": "coin_contractenddatead" },
        { "data": "status" },
     
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
       { type: null },
       { type: null },
       { type: null },
       { type: null }, 
       { type: null },
        { type: null },
      
       ]
     });
   });
</script>