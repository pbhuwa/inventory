<style type="text/css">
.text_filter{
    width: 100px !important;
}
</style>
<div class="row">
  <div class="col-sm-12">
      <div class="white-box list">
          <h3 class="box-title m-b-0"><?php echo $this->page_title; ?></h3>
          <p class="text-muted m-b-10"></p>
          <div class="table-responsive">
            <div class="col-sm-8 pull-right search_list sm-form">
              <div class="col-sm-3"><input type="text" name="" class="form-control"></div>
              <div class="col-sm-3"><input type="text" name="" class="form-control"></div>
              <div class="col-sm-2"><button class="btn btn-sm btn-success">Search</button></div>
              </div>
           
              <table id="myTable" class="table table-striped ">
                  <thead>
                      <tr>
                          <th width="5%">S.n</th>
                          <th width="15%">Patient.Id</th>
                          <th width="15%">Patient Name</th>
                          <th width="15%">Gender</th>
                          <th width="5%">Age</th>
                          <th width="15%">Address</th>
                          <th width="15%">Contact.No.</th>
                          <th width="15%">Reg.Date</th>
                          <th width="15%">Actions</th>
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
    // var frmDate = '';
    // var toDate = '';
    var frmDate=$('#frmDate').val();
    var toDate=$('#toDate').val();  
     var dataurl = base_url+"patients/get_patients_list";

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
        "aTargets": [ 0,4 ]
      }
      ],      
      "aoColumns": [
      { "data": null },
      { "data": "patientid" },
      { "data": "patientname" },
      { "data": "gender" },
      { "data": "age" },
      { "data": "districtname" },
      { "data": "contactno" },
      { "data": "regdate" },
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
      { type: null },
     
      ]
    });

});


    $(document).off('click','.patlist');
    $(document).on('click','.patlist',function(){
        var patientid=$(this).data('patientid');

        // alert(patientid);
        var redirecturl=base_url+'nurse_triage';
         $.redirectPost(redirecturl, {patientid:patientid });


    })
</script>