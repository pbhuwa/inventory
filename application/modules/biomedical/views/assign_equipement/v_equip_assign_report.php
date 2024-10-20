   <form method="post" id="reportGeneration" action="" class="form-material form-horizontal form" >
      <div class="clearfix"></div>
      <div class="white-box">
         <h3 class="box-title">Equipment Assign Report</h3>
         <div class="pad-10">
            <div class="form-group resp_xs">
               <div class="col-sm-2 col-xs-6">
                  <label for="example-text">Report Type :</label>
                  <select name="rpttype" class="form-control reporttype" id="rpttype">
                     <option value="all">All</option>
                     <option value="desc">Description</option>
                     <option value="dist">Distributer</option>

                     <?php
                        if(($this->sess_usercode == 'SA') || ($this->sess_usercode == 'AD')){
                      ?>
                      <option value="dept">Department</option>
                      <?php 
                      }
                      ?>
                     
                     <option value="amc">AMC</option>
                     <option value="pur_don">Pur/Don</option>
                     <option value="assign_to">Assign To</option>
                   </select>
               </div>
               <div class="col-sm-2 col-xs-6" id="Subtype">
              
               </div>
               <div class="col-sm-2 col-xs-6">
                <label>Date</label>
                <select class="form-control" name="date" id="date">
                   <option value="">----All---</option>
                  <option value="as_date">Assign Date</option>
                  <option value="post_date">Entry Date</option>
          
        
                </select>
               </div>
               <div id="datediv" style="display: none">
                 <div class="col-sm-2 col-xs-6">
                  <label for="">From :</label>
                  <input type="text" name="fromdate" class="form-control <?php echo DATEPICKER_CLASS; ?>"  value="<?php echo DISPLAY_DATE; ?>" id="fromdate">
               </div>
               <div class="col-sm-2 col-xs-6">
                  <label for="">To :</label>
                  <input type="text" name="todate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>" id="todate">
               </div>
               </div> 
               <div class="col-sm-2 col-xs-6">
                  <label for="">&nbsp;</label>
                  <div>
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
   
    // $(.)var optionSelected = $("option:selected", this);
    //var valueSelected = this.value;

    $(document).on('change','.reporttype',function() {
        var rpttype=$(this).val();
        var action=base_url+'/biomedical/assign_equipement/get_assign_report_type';
    $.ajax({
    type: "POST",
    url: action,
    data:{rpttype:rpttype},
     dataType: 'html',
     beforeSend: function() {

      // $('.overlay').modal('show');
    },
   success: function(jsons) //we're calling the response json array 'cities'
    {
      // console.log(jsons);

        data = jQuery.parseJSON(jsons);   
        // alert(data.status);
        if(data.status=='success')
        {
          $('#Subtype').html(data.template);
            
        }
        else
        {
           alert(data.message);
        }
        

       }
    });
    })

     $(document).on('click','.btnSearch',function() {
        var rpttype=$(this).val();
        var reportType = $('#rpttype option:selected').text();

        var rptSelected = $('.rptSelected option:selected').text();
        var rptChecked = $('.rptChecked:checked').next('label').text();

        var action=base_url+'biomedical/assign_equipement/generate_assign_report';
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
      var stin_staffinfoid =$('#stin_staffinfoid').val();
      var usma_userid =$('#usma_userid').val();
      
       var redirecturl=base_url+'biomedical/assign_equipement/download_assign_report';
         $.redirectPost(redirecturl, {rpttype:rpttype,date:date,fromdate:fromdate,todate:todate,bmin_descriptionid:bmin_descriptionid,bmin_distributorid:bmin_distributorid,bmin_departmentid:bmin_departmentid,bmin_amc:bmin_amc,bmin_purch_donatedid:bmin_purch_donatedid,stin_staffinfoid:stin_staffinfoid,usma_userid:usma_userid});
     })

      $(document).off('click','.btn_excel');
    $(document).on('click','.btn_excel',function(){
         var rpttype =$('#rpttype').val();
      var date =$('#date').val();
      var fromdate=$('#fromdate').val();
      var todate=$('#todate').val();

      var bmin_descriptionid =$('#bmin_descriptionid').val();
      var bmin_distributorid =$('#bmin_distributorid').val();
      var bmin_departmentid =$('#bmin_departmentid').val();
      var bmin_amc =$('#bmin_amc').val();
      var bmin_purch_donatedid =$('#bmin_purch_donatedid').val();
      var stin_staffinfoid =$('#stin_staffinfoid').val();
      var usma_userid =$('#usma_userid').val();
      
       var redirecturl=base_url+'biomedical/assign_equipement/download_assign_report_excel';
         $.redirectPost(redirecturl, {rpttype:rpttype,date:date,fromdate:fromdate,todate:todate,bmin_descriptionid:bmin_descriptionid,bmin_distributorid:bmin_distributorid,bmin_departmentid:bmin_departmentid,bmin_amc:bmin_amc,bmin_purch_donatedid:bmin_purch_donatedid,stin_staffinfoid:stin_staffinfoid,usma_userid:usma_userid});
     })
</script>
