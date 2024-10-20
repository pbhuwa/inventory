<div class="row wb_form">
    <div class="col-sm-7">
        <div class="white-box">
            <h3 class="box-title">PM Data</h3>
            <div id="FormDiv" class="formdiv frm_bdy">
            <?php $this->load->view('repair_information/v_repairinformationform');?>
            </div>
        </div>
    </div>
    <div class="col-sm-5">
     <div class="white-box">
            <h3 class="box-title">List of PM Data <i class="fa fa-refresh pull-right"></i></h3>
            <div class="pad-5">
                <div class="table-responsive scroll">
                    <table id="myTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th width="15%">Manu.Id</th>
                                <th width="20%">Description:</th>
                                <th width="20%">Department</th>
                                <th width="15%">Technician</th>
                                <th width="15%">Explain Other Costs</th>
                                <th width="15%">Action</th>
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
    $(document).ready(function() {
    
        var frmDate=$('#frmDate').val();
        var toDate=$('#toDate').val();  
        var dataurl = base_url+"biomedical/pm_data/get_pm_data";
     
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
            "sEmptyTable":   "<p class='text-danger'>No Record Found!! </p>"
          }, 
          "aoColumnDefs": [
          {
            "bSortable": false,
            "aTargets": [ 4 ]
          }
          ],      
          "aoColumns": [
           { "data": "riva_riskid" },
           { "data": "risk" },
           { "data": "comments" },
           { "data": "postdatebs" },
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
        }).columnFilter(
        {
          sPlaceHolder: "head:after",
          aoColumns: [ {type: "text"},
          { type: "text" },
          { type: "text" },
          { type: "text" },
          { type: null },
         
          ]
        });

    });
</script>

                    


                    


                    



                    


                   
                    

