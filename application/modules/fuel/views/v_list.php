
<div class="row">


    <div class="col-sm-12">
        <a href="javascript:void(0)" class="pull-right btn btn-sm btn-success btnRefresh"><i class="fa fa-refresh" aria-hidden="true"></i></a>
        <div class="white-box">
            <h3 class="box-title">Generate Coupen List</h3>
            <div class="table-responsive dtable_pad scroll">


                <div id="TableDiv">

                  <div class="searchWrapper">

                    <div class="row">
                      <form >

                        <div class="col-md-3">
                          <label for="example-text">Fuel Type:</label>

                          <select class="form-control" name="fuel_typeid" id="typeid">
                           <option value="">---select---</option>
                           <?php
                           foreach ($fuel_list as $value) { ?>
                            <option value="<?php echo $value->futy_typeid ?>" ><?php echo $value->futy_name ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="example-text">Month:</label>
                    <select class="form-control" name="fule_month" id="monthid">
                        <option value="">---select---</option>
                        <?php
                        foreach ($month as $value) { ?>
                            <option value="<?php echo $value->mona_monthid ?>" ><?php echo $value->mona_namenp ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                  <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?> :</label>
                  
                  <select name="fuel_fyear" class="form-control required_field" id="fyear">
                    <?php
                    if($fiscal_year): 
                        foreach ($fiscal_year as $kf => $fyrs):
                            ?>
                            <option value="<?php echo $fyrs->fiye_name; ?>" <?php if($fyrs->fiye_status=='I') echo "selected=selected"; ?> ><?php echo $fyrs->fiye_name; ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <a class="btn btn-info" id="searchByDate" style="margin-top: 18px;"><?php echo $this->lang->line('search'); ?></a>
                </div>

                <div class="sm-clear"></div>

                <div class="clearfix"></div>
            </form> 
        </div>
        <div class="clear"></div>
    </div>



    <div class="table-responsive">
     <table id="myTable" class="table table-striped ">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('sn'); ?></th>
          <th>Coupen NO </th>
          <th>Fuel Type</th>
          <th>Month</th>
          <th>Fyear</th>
          <th>Valid Date</th>
          <th>Staff Name</th>
          <th>Is Assigned</th>
          <th><?php echo $this->lang->line('action'); ?></th>
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
<script type="text/javascript">
  $(document).ready(function(){
    var fyear=$('#fyear').val();
    var typeid=$('#typeid').val(); 
    var monthid=$('#monthid').val();
    var dataurl = base_url+"fuel/fuel/get_fuel_coupen_list_details";
    var message='';
    var showview='<?php echo MODULES_VIEW; ?>';
    // alert(showview);
    
    if(showview=='N')
    {
      message="<p class='text-danger'>Permission Denial</p>";
  }
  else
  {
      message="<p class='text-danger'>No Record Found!! </p>";
  }
  var dtablelist = $('#myTable').dataTable({
      "sPaginationType": "full_numbers"  ,

      "bSearchable": false,
      "lengthMenu": [[15, 30, 45, 60,100,200,500, -1], [15, 30, 45, 60,100,200,500, "All"]],
      'iDisplayLength': 10,
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
      "aTargets": [ 0,8]
  }
  ],      
  "aoColumns": [
  { "data": "sno" },
  { "data": "coupenno" },
  { "data": "type" },
  { "data": "month" },
  { "data": "fyear" },
  { "data": "validdate" },
  { "data": "staffname" },
  {"data":"isassigned"},
  { "data": "action" }
  ],
  "fnServerParams": function (aoData) {

      aoData.push({ "name": "typeid", "value": typeid });
      aoData.push({ "name": "monthid", "value": monthid });
      aoData.push({ "name": "fyear", "value": fyear });
  },
  "fnRowCallback" : function(nRow, aData, iDisplayIndex){
   var oSettings = dtablelist.fnSettings();
   $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
   return nRow;
},
"fnCreatedRow": function( nRow, aData, iDisplayIndex ) {
   var oSettings = dtablelist.fnSettings();
   var tblid= oSettings._iDisplayStart+iDisplayIndex +1

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
  { type: null },

  ]
});

$(document).off('click','#searchByDate')
$(document).on('click','#searchByDate',function(){
    // alert(asdf);
    monthid=$('#monthid').val();  
    typeid=$('#typeid').val();
    fyear=$('#fyear').val();
    type=$('#searchByType').val(); 
    dtablelist.fnDraw();  
});


});

</script>
<script type="text/javascript">

    $(document).on('change','#staffid',function() {

       var staffid = $(this).val(); 

       var action = base_url+'/fuel/fuel/staffDetails';

       $.ajax({

        type: "POST",

        url: action,

        data:{staffid:staffid},

        dataType: 'html',

        beforeSend: function() {

      // $('.overlay').modal('show');

  },

  success: function(jsons)

  {

      console.log(jsons);

      data = jQuery.parseJSON(jsons);   

        // alert(data.status);

        if(data.status=='success')

        {

          $('#detailsStaff').html(data.tempform);

      }

      else

      {

         alert(data.message);

     }

 }

});

   })

</script>