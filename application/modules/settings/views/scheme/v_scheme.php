    <div class="row">
        <div class="col-sm-7">
            <div class="white-box">
                <h3 class="box-title">Add scheme</h3>
                <div id="FormDiv_scheme" class="formdiv frm_bdy">
                <?php $this->load->view('scheme/v_schemeform');?>
                </div>
            </div>
        </div>

        <div class="col-sm-5">
            <div class="white-box">
                <h3 class="box-title">scheme List</h3>
                <div class="table-responsive dtable_pad scroll">
                    <input type="hidden" id="EditUrl" value="<?php echo $editurl; ?>" >
                    <input type="hidden" id="DeleteUrl" value="<?php echo $deleteurl; ?>" >
                    <table id="myTable" class="table table-striped">
                        <thead>
                            <tr>
                              <th width="15%">Scheme Id</th>
                              <th width="20%">Schemecode</th>
                              <th width="20%">Scheme</th>
                              <th width="15%">validfromdatead</th>
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

    <script type="text/javascript">
    $(document).ready(function() {
    
        var frmDate=$('#frmDate').val();
        var toDate=$('#toDate').val();  
        var dataurl = base_url+"settings/scheme/get_schema_data";
     
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
           { "data": "sche_schemeid" },
           { "data": "schemecode" },
           { "data": "scheme" },
           { "data": "validfromdatead" },
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

                   
                    

