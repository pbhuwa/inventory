   <form method="post" id="reportGeneration" action="" class="form-material form-horizontal form" >
      <div class="clearfix"></div>
      <div class="white-box">
          <h3 class="box-title">Load Assets From Inventory </h3>
         <div class="pad-10">
            <div class="form-group resp_xs">
               
             
              
               <div id="datediv" style="">
                 <div class="col-sm-2 col-xs-6">
                  <label for="">From :</label>
                  <input type="text" name="fromdate" class="form-control <?php echo DATEPICKER_CLASS; ?>"  value="<?php echo DISPLAY_DATE; ?>" id="fromdate">
               </div>
               <div class="col-sm-2 col-xs-6">
                  <label for="">To :</label>
                  <input type="text" name="todate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>" id="todate">
               </div>
               </div>
              

              <!--  <div class="col-md-3">
                  <div id="showmore">

                  </div>
               </div> -->

               <div class="col-sm-2 col-xs-6">
                  <label for="">&nbsp;</label>
                  <div>
                     <button type="submit" class="btn btn-info btnSearch">Search</button>
                  </div>
               </div>
                <div class="clearfix"></div>
                
                <div id="ItemRpt">
                 
             
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
        var reportType = $('#rpttype option:selected').text();

        var rptSelected = $('.rptSelected option:selected').text();
        var rptChecked = $('.rptChecked:checked').next('label').text();

        var action=base_url+'/ams/assets/get_purchase_item';
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
          // $('#Subtype').html(data.tempform);
          $('#ItemRpt').html(data.tempform);
          if(rptSelected != null){
            $('#rptTypeSelect').html(rptSelected);
          }
          if(rptChecked != null){
            $('#rptTypeCheck').html(rptChecked);
          }

          $('#rptType').html(reportType);
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

     $(document).on('change','#date',function()
      {
        var datetype=$(this).val();
        // alert(datetype);
        if(datetype)
        {
          $('#datediv').show();
        }
        else
        {
           $('#datediv').hide();
        }
      });

    $(document).off('click','.btn_print');
     $(document).on('click','.btn_print',function(){
      $('#printrpt').printThis();
     })

    $(document).off('click','.btn_pdf');
     $(document).on('click','.btn_pdf',function(){
      // $('#printrpt').printThis();
      var rpttype =$('#rpttype').val();
      var date =$('#date').val();
      var fromdate=$('#fromdate').val();
      var todate=$('#todate').val();
      var bmin_descriptionid =$('#bmin_descriptionid').val();
      var bmin_distributorid =$('#bmin_distributorid').val();
      var bmin_departmentid =$('#bmin_departmentid').val();
      var bmin_amc =$('#bmin_amc').val();
      var bmin_purch_donatedid =$('#bmin_purch_donatedid').val();
      var bmin_isoperation =$('#bmin_isoperation').val();
      var bmin_ismaintenance =$('#bmin_ismaintenance').val();
      var status=$('#status').val();
      var redirecturl=base_url+'biomedical/reports/download_bio_medical_rpt';
         $.redirectPost(redirecturl, {rpttype:rpttype,date:date,fromdate:fromdate,todate:todate,bmin_descriptionid:bmin_descriptionid,bmin_distributorid:bmin_distributorid,bmin_departmentid:bmin_departmentid,bmin_amc:bmin_amc,bmin_purch_donatedid:bmin_purch_donatedid,bmin_isoperation:bmin_isoperation,bmin_ismaintenance:bmin_ismaintenance,status:status });
     })
</script>

<script>
    $(document).off('click','.btn_excel');
    $(document).on('click','.btn_excel',function(){
        var rpttype =$('#rpttype').val();
        var distributorid = $('#distributortype option:selected').val();
        var fromdate=$('#fromdate').val();
        var todate=$('#todate').val();
        var reportType = $('#rpttype option:selected').text();
        var descriptiontype = $('#rptSelected option:selected').text(); 
        var bmin_descriptionid =$('#bmin_descriptionid').val();
        var bmin_distributorid =$('#bmin_distributorid').val();
        var bmin_departmentid =$('#bmin_departmentid').val();
        var bmin_amc =$('#bmin_amc').val();
        var bmin_purch_donatedid =$('#bmin_purch_donatedid').val();
        var bmin_isoperation =$('#bmin_isoperation').val();
        var bmin_ismaintenance =$('#bmin_ismaintenance').val();
        var status=$('#status').val();
        var redirecturl=base_url+'biomedical/reports/generate_excel_biomedical';
        $.redirectPost(redirecturl, {rpttype:rpttype,coin_distributorid:distributorid,fromdate:fromdate,todate:todate, reportType:reportType, descriptiontype:descriptiontype, bmin_descriptionid:bmin_descriptionid,bmin_distributorid:bmin_distributorid,bmin_departmentid:bmin_departmentid,bmin_amc:bmin_amc,bmin_purch_donatedid:bmin_purch_donatedid,bmin_isoperation:bmin_isoperation,bmin_ismaintenance:bmin_ismaintenance,status:status });
    });
</script>