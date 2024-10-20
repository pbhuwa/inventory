   <form method="post" id="reportGeneration" action="" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('settings/scheme/form_scheme'); ?>'>
      <div class="clearfix"></div>
      <div class="white-box">
        <!--  <h3 class="box-title">Biomedical PM Report</h3> -->
         <div class="pad-10">
            <div class="form-group">
              <div class="col-sm-10">
                <div class="col-sm-3">
                  <div class="col-md-4 mtop_5 ">
                    <label for="example-text">From Date: </label>
                  </div>
                  <div class="col-sm-8">
                    <input type="text" name="frmDate" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>"  value="<?php echo DISPLAY_DATE; ?>">
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="col-md-4 mtop_5 ">
                    <label for="example-text">To Date: </label>
                  </div>
                  <div class="col-sm-8">
                    <input type="text" name="toDate" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>">
                  </div>
               </div>
              <div class="col-sm-3">
                <div class="col-md-7 mtop_5 ">
                    <label for="example-text">Days(Before): </label>
                </div>
                <div class="col-sm-5">
                  <input type="number" class="form-control" name="" id="searchByDays"  placeholder="Days(Before)">
                </div>
              </div>
              <div class="col-sm-3">
                <div class="col-md-5 mtop_5 ">
                    <label for="example-text">Equip.ID: </label>
                </div>
                <div class="col-sm-7">
                 <input type="text" id="id" autocomplete="off" name="equid" value="" class="form-control searchText" placeholder="Equipment ID" data-srchurl="<?php echo base_url(); ?>/biomedical/bio_medical_inventory/list_of_equipment_inv">
                  <div class="DisplayBlock" id="DisplayBlock_id"></div>
                </div>
              </div>
              
              </div>
              <div class="col-sm-2">
                <button type="submit" class="btn btn-info btnSearch">Search</button>
              </div>

              </div>
                <div class="clearfix"></div>
                <div id="InventoryRpt">
             
                </div>
               </div>
            </div>
            <div class="clearfix"></div>
         </div>
      </div>
      <div id="ResponseSuccess" class="waves-effect waves-light m-r-Y0 text-success"></div>
      <div id="ResponseError" class="waves-effect waves-light m-r-Y0 text-danger"></div>
   </form>
<script type="text/javascript">
    $(document).on('click','.btnSearch',function() {
      var rpttype=$(this).val();
      var action=base_url+'biomedical/reports/generate_allpmreport';
      $.ajax({
      type: "POST",
      url: action,
      data:$('#reportGeneration').serialize(),
       dataType: 'html',
       beforeSend: function() {
        $('.overlay').modal('show');
      },
     success: function(jsons) //we're calling the response json array 'cities'
      {
        console.log(jsons);

          data = jQuery.parseJSON(jsons);   
          // alert(data.status);
          if(data.status=='success')
          {
            // $('#Subtype').html(data.template);
            $('#InventoryRpt').html(data.template);
             $('.overlay').modal('hide');
              
          }
          else
          {
             // alert(data.message);
          }
          

         }
      });
      return false;
      })
    $(document).off('click','.btn_print');
     $(document).on('click','.btn_print',function(){
      $('#printrpt').printThis();
     })

    $(document).off('click','.btn_pdf');
     $(document).on('click','.btn_pdf',function(){
      // $('#printrpt').printThis();
      var id = $(this).data('id');
      var toDate=$('#toDate').val();
      var frmDate=$('#frmDate').val();//alert(todate); alert(fromdate);
      
       var redirecturl=base_url+'biomedical/reports/download_pmdatareport'+'?=1';
         $.redirectPost(redirecturl, {id:id,frmDate:frmDate,toDate:toDate});
     })
</script>
<script>
    $(document).off('change, hover, keyup','#searchByDays');
    $(document).on('change, hover, keyup','#searchByDays',function(){
        var day = $('#searchByDays').val();

        var days = parseInt(day);

        if(days < 0){
            alert('Please enter days above 0');
        }

        if(day == ""){
            days = 0;
        }

        var startdate = $('#toDate').val().split("/");
        var sd = new Date(startdate[0], startdate[1]-1,startdate[2]);

        var newdate = new Date(sd);

        newdate.setDate(newdate.getDate() - days);

        var nd = new Date(newdate);

        var testnd =  new Date(nd),
                month = '' + (testnd.getMonth() + 1),
                day = '' + testnd.getDate(),
                year = testnd.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;
        
        var newStartDate = [year, month, day].join('/')

        console.log(newStartDate);

        $('#frmDate').val(newStartDate);

    });
</script>
