   <form method="post" id="reportGeneration" action="" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('settings/scheme/form_scheme'); ?>'>
      <div class="clearfix"></div>
      <div class="white-box">
         <h3 class="box-title">PM Completed Reports</h3>
         <div class="pad-10">
            <div class="form-group resp_xs">
               <div class="col-sm-2 col-xs-6">
                  <label for="example-text">Report Type :</label>
                  <select name="rpttype" class="form-control reporttype" id="rpttype">
                     <option value="">---select---</option>
                     <option value="desc">Description</option>
                     <option value="dist">Distributer</option>
                     <option value="dept">Department</option>
                     <option value="amc">AMC</option>
                     <option value="pur_don">Purchase Donate</option>
                     <option value="manual">Manual</option>
                  </select>
               </div>
               <div class="col-sm-2 col-xs-6" id="Subtype">
              
               </div>
               <div class="col-sm-2 col-xs-6">
                  <label for="example-text">From Date: </label>
                  <input type="text" name="frmDate" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>"  value="<?php echo DISPLAY_DATE; ?>">
                  </div>
               
               <div class="col-sm-2 col-xs-6">
                <label for="example-text">To Date: </label>
                    <input type="text" name="toDate" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>">
              </div>
               
              <div class="col-sm-1 col-xs-6">
                <label for="example-text">Days(Before): </label>
                  <input type="number" class="form-control" name="" id="searchByDays"  placeholder="Days(Before)">
                </div>
             
              <!-- <div class="col-sm-2 col-xs-6">
                <label for="example-text">Equip.ID: </label>
                <input type="text" id="id" autocomplete="off" name="equid" value="" class="form-control searchText" placeholder="Equipment ID" data-srchurl="<?php echo base_url(); ?>/biomedical/bio_medical_inventory/list_of_equipment_inv">
                  <div class="DisplayBlock" id="DisplayBlock_id">
                  </div>
              </div> -->
                <div class="col-sm-1">
                  <label for="">&nbsp;</label>
                  <div>
                     <button type="submit" class="btn btn-info btnSearch">Search</button>
                  </div>
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
      <div id="ResponseSuccess" class="alert-success"></div>
      <div id="ResponseError" class="alert-danger"></div>
   </form>
<script type="text/javascript">
   
    // $(.)var optionSelected = $("option:selected", this);
    //var valueSelected = this.value;

    $(document).on('change','.reporttype',function() {
        var rpttype=$(this).val();
        var action=base_url+'/biomedical/reports/getreport_type';
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
      console.log(jsons);

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

    $(document).off('click','.btnSearch');
    $(document).on('click','.btnSearch',function() {
    var rpttype=$(this).val();
    var action=base_url+'/biomedical/reports/generate_pmcompleted_report';
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
       

       var redirecturl=base_url+'biomedical/reports/pmcompleted_report_pd'+'?=1';
         $.redirectPost(redirecturl, {rpttype:rpttype,date:date,fromdate:fromdate,todate:todate,bmin_descriptionid:bmin_descriptionid,bmin_distributorid:bmin_distributorid,bmin_departmentid:bmin_departmentid,bmin_amc:bmin_amc,bmin_purch_donatedid:bmin_purch_donatedid,bmin_isoperation:bmin_isoperation,bmin_ismaintenance:bmin_ismaintenance });
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
