 <script src="https://code.highcharts.com/highcharts.js"></script>
   <script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="<?php echo base_url().PLUGIN_DIR ?>highcharts/highcharts.js"></script>
<script src="<?php echo base_url().PLUGIN_DIR ?>highcharts/exporting.js"></script>
<div class="bio_dash">
   <div class="row">
      <div class="col-sm-6">
         <?php 
            $useraccess= $this->session->userdata(USER_ACCESS_TYPE);
            $orgid= $this->session->userdata(ORG_ID);
            if($useraccess=='S')
            {
                if($orgid==1)
                {
                  $this->load->view('v_bio_medical_dashboard');
                }
                if($orgid==2)
                {
                  $this->load->view('v_assets_dashboard');
                }
                if($orgid==3)
                {
                  $this->load->view('v_stock_dashboard');
                }
            }
            else if($useraccess=='B')
            {
                $this->load->view('v_bio_medical_dashboard');
                $this->load->view('v_assets_dashboard');
            } 
            ?>
         <div class="white-box displaydetail" >   
         </div>
         <div class="wb_form">
            <div class="white-box">
               <h3 class="box-title">PM Alert</h3>
               <div class="pad-5">
                  <div class="table-responsive">
                     <table id="pmalert"  class="table table-striped dataTable">
                        <thead>
                           <tr>
                              <th width="5%">S.n.</th>
                              <th width="10%">Equp No</th>
                              <th width="15%">PM D.(AD)</th>
                              <th width="15%">PM D.(BS)</th>
                              <th width="15%">Dept.</th>
                              <th width="15%">Risk</th>
                              <th width="5%">PM</th>
                              <th width="20%">Status</th>
                           </tr>
                        </thead>
                        <tbody>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <div class="wb_form">
            <div class="white-box">
               <h3 class="box-title">Warrenty Alert</h3>
               <div class="pad-5">
                  <div class="table-responsive">
                     <table id="warrentyalert"  class="table table-striped dataTable">
                        <thead>
                           <tr>
                              <th width="5%">S.n.</th>
                              <th width="10%">Equp No</th>
                              <th width="10%">Description</th>
                              <th width="15%">Department</th>
                              <th width="15%">Risk</th>
                              <th width="15%">End. War.(AD)</th>
                              <th width="15%">End. War.(BS)</th>
                              <th width="20%">Status</th>
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
      <div class="col-sm-6">
         <div class="wb_form">
        
            <?php $this->load->view('v_comment_lists');?>
       
         <div class="wb_form" style="margin-top: 53px;">
            <div class="white-box">
               <h3 class="box-title"> Contract Alert</h3>
               <div class="pad-5">
                  <div class="table-responsive">
                     <table id="tblcontractor"  class="table table-striped dataTable">
                        <thead>
                           <tr>
                              <th width="10%">S.N</th>
                              <th width="10%">Contractor Type</th>
                              <th width="10%">Name</th>
                              <th width="10%">Title</th>
                              <th width="15%">St.Date</th>
                              <th width="15%">End.Date</th>
                              <th width="10%">Value</th> 
                                                
                              <th width="10%">Status</th>
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
   <div class="row">
      <div class="col-sm-12">
         <div class="white-box">
            <h3 class="box-title">Preventive Maintenance</h3>
            <ul class="nav nav-tabs pre_main">
               <li class="active"><a data-toggle="tab" href="#weekly">Weekly PM</a></li>
               <li><a data-toggle="tab" href="#monthly">Last 5 Week PM</a></li>
               <li><a data-toggle="tab" href="#thisyear">This Year</a></li>
               <li><a data-toggle="tab" href="#year_wise">Year Wise</a></li>
            </ul>
            <div class="tab-content pad-5 mtop_5">
               <div id="weekly" class="tab-pane fade in active">
                  <h3 class="pre_main_title">This Week PM
                  </h3>
                  <div id="weekpm">
                     <?php $this->load->view('chart/weekly_pm_chart'); ?>
                  </div>
               </div>
               <div id="monthly" class="tab-pane fade">
                  <h3 class="pre_main_title">Last Five Week PM</h3>
                  <div id="monthpm">
                     <?php $this->load->view('chart/last5_pm_chart'); ?>
                  </div>
               </div>
               <div id="thisyear" class="tab-pane fade">
                  <h3 class="pre_main_title">This Year PM</h3>
                  <div id="yearpm">
                     <?php $this->load->view('chart/year_pm_chart'); ?>
                  </div>
               </div>
               <div id="year_wise" class="tab-pane fade">
                  <h3 class="pre_main_title">Yearwise PM</h3>
                  <div id="yearwisepm">
                     <?php $this->load->view('chart/year_wise_pm_chart'); ?>
                  </div>
               </div>
            </div>
                 </div>
      </div>
   </div>
</div>
<!-- Trigger the modal with a button -->
<div class="modal fade" id="modalPM" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
   <div class="modal-dialog modal-md">
      <div class="modal-content xyz-modal-123">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">PM History</h4>
         </div>
         <div class="modal-body scroll vh80">
            <div id="pmData"></div>
         </div>
      </div>
   </div>
</div>
</div>
<script type="text/javascript">
   $(document).off('click','.myModalRepair');
    $(document).on('click','.myModalRepair',function(){
      // alert('fasdf');
      var equipcommentid = $(this).data('id');
      var equipid = $(this).data('equipid');
        var statusid = $(this).data('statusid');
        $('.resultrRepairComment').html("");
        // alert(statusid);
      $.ajax({
        type: "POST",
        url: base_url+'home/get_repair_data',
        data:{equipcommentid:equipcommentid, equipid:equipid,statusid:statusid},
        dataType: 'json',
        beforeSend: function() {
          $('.overlay').modal('show');
        },
        success: function(datas) {
          $('#myModal1').modal('show');
          if(datas.status=='success') {
              $('.resultrRepairComment').html(datas.tempform);
          }
           $('.overlay').modal('hide');
        }
      })
    })
   $(document).off('click','.btnviewd');
   $(document).on('click','.btnviewd',function(){
      var urlload=$(this).data('viewurl');
      var result = $(this).data('resultval');
      var orgid=$(this).data('orgid');
      $('.displaydetail').load(urlload+'/'+result+'/'+orgid);
      //alert(urlload);alert(result);
   })
</script>
<script type="text/javascript">
   $(document).ready(function(){
     
     var frmDate=$('#frmDate').val();
     var toDate=$('#toDate').val();  
     var dataurl_pma = base_url+"home/get_pm_alert";
     //alert(dataurl);
         //$("#repairRequesttble").dataTable().fnDestroy();
     var dtablelist = $('#pmalert').dataTable({
       "sPaginationType": "full_numbers"  ,
       
       "bSearchable": false,
       "lengthMenu": [[15, 30, 45, 60,100,200,500, -1], [15, 30, 45, 60,100,200,500, "All"]],
       'iDisplayLength': 20,
       "sDom": 'ltipr',
       "bAutoWidth":false,
             "fnDestroy":true,
             "Destroy":true,
       "autoWidth": true,
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
         "aTargets": [0, 7 ]
       }
       ],      
       "aoColumns": [
        { "data": "equiid"},
        { "data": "equipmentkey"},
        { "data": "datead" },
        { "data": "datebs" },
        { "data": "department" },
        { "data": "risk_val" },
        { "data": "pmcount" },
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
<script type="text/javascript">
   $(document).ready(function(){
     var frmDate=$('#frmDate').val();
     var toDate=$('#toDate').val();  
     var dataurl_rr = base_url+"home/get_warrenty_alert";
     var dtablelist = $('#warrentyalert').dataTable({
       "sPaginationType": "full_numbers" ,
       "bSearchable": false,
       "lengthMenu": [[15, 30, 45, 60,100,200,500, -1], [15, 30, 45, 60,100,200,500, "All"]],
       'iDisplayLength': 20,
       "sDom": 'ltipr',
       "bAutoWidth":false,
             "fnDestroy":true,
             "Destroy":true,
       "autoWidth": true,
       "aaSorting": [[0,'desc']],
       "bProcessing":true,
       "bServerSide":true,    
       "sAjaxSource":dataurl_rr,
       "oLanguage": {
         "sEmptyTable":   "<p class='text-danger'>No Record Found!! </p>"
       }, 
       "aoColumnDefs": [
       {
         "bSortable": false,
         "aTargets": [ 0,7 ]
       }
       ],      
       "aoColumns": [
   
        { "data": null},
        { "data": "equipmentkey" },
        { "data": "description" },
        { "data": "department" },
        { "data": "risk_val" },
        { "data": "datead" },
        { "data": "datebs" },
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
   $(document).off('click','#approveRepair');
   $(document).on('click','#approveRepair',function(){
       var commentid = $(this).data('commentid');
       var commentStatus = $(this).data('status');
       if(commentStatus == 1){
           alert('Already Approved');
           return false;
       }else{
           $.ajax({
               type: "POST",
               url: base_url+'home/approveRepairRequest',
               data:{commentid:commentid},
               dataType: 'json',
               success: function(datas) {
                   alert(datas.message);
                   $('#myModal1').modal('hide');
               }
           });
       }
   });
</script>
<script>
   $(document).on('change mouseleave keyup','#rere_techcost, #rere_partcost, #rere_othercost, #rere_totalcost',function(){
       var techcost = $('#rere_techcost').val();
       var partcost = $('#rere_partcost').val();
       var othercost = $('#rere_othercost').val();
       var totalcost = parseInt(techcost) + parseInt(partcost) + parseInt(othercost);
       totalcost = isNaN(totalcost)?'0':totalcost;
       $('#rere_totalcost').val(totalcost);
   });
</script>
<script>
   $(document).off('click','.pmcount');
   $(document).on('click','.pmcount',function(){
       var equipid=$(this).data('equipid');
       $('#modalPM').modal('show');
       var dataurl = "<?php echo base_url() ?>home/pm_record";
       $.ajax({
           type: "POST",
           url: dataurl,
           data: {equipid:equipid},
           dataType: 'html',
           beforeSend: function() {
               $('.overlay').modal('show');
           },
           success: function(jsons)
           {
               data = jQuery.parseJSON(jsons);  
               if(data.status=='success')
               {
                   $('#pmData').html(data.hisDetail);
               }
               $('.overlay').modal('hide');
           }
       })
   });
   
   
</script>
<script type="text/javascript">
   $(document).ready(function(){
     
     var frmDate=$('#frmDate').val();
     var toDate=$('#toDate').val();  
     var dataurl_pma = base_url+"home/get_contractor";
     //alert(dataurl);
         //$("#repairRequesttble").dataTable().fnDestroy();
     var dtablelist = $('#tblcontractor').dataTable({
       "sPaginationType": "full_numbers"  ,
       
       "bSearchable": false,
       "lengthMenu": [[15, 30, 45, 60,100,200,500, -1], [15, 30, 45, 60,100,200,500, "All"]],
       'iDisplayLength': 20,
       "sDom": 'ltipr',
       "bAutoWidth":false,
             "fnDestroy":true,
             "Destroy":true,
       "autoWidth": true,
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
         "aTargets": [0, 6 ]
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

