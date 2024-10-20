<form method="post" id="reportGeneration" action="" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('settings/scheme/form_scheme'); ?>'>
    <div class="clearfix"></div>
    <div class="white-box">
        <h3 class="box-title"><?php echo $this->lang->line('contractor_management_report'); ?></h3>
        <div class="pad-10">
            <div class="form-group resp_xs">
                <div class="col-sm-2 col-xs-6">
                    <label for="example-text"><?php echo $this->lang->line('renew_type'); ?>:</label>
                    <select name="rpttype" class="form-control reporttype" id="rpttype">
                        <option value="all">All</option>
                        <?php
                            if(!empty($renewType)):
                              foreach($renewType as $renew):
                            ?>
                        <option value="<?php echo $renew->rety_renewtypeid?>"><?php echo $renew->rety_renewtype;?></option>
                        <?php
                            endforeach;
                            endif;
                            ?>
                    </select>
                </div>
                <div class="col-sm-2 col-xs-6" >
                    <label for="example-text"><?php echo $this->lang->line('distributor'); ?> :</label>
                    <select class="form-control typeSelected" id="distributortype" data-id="distributors" name="coin_distributorid">
                        <option value="all">All</option>
                        <?php
                            if(!empty($distributors)):
                                foreach($distributors as $value):
                            ?>
                        <option value="<?php echo $value->dist_distributorid; ?>"><?php echo $value->dist_distributor; ?></option>
                        <?php
                            endforeach; 
                            endif;
                            ?>
                    </select>
                </div>
                <div id="datediv">
                    <div class="col-sm-2 col-xs-6">
                        <label for=""><?php echo $this->lang->line('from_date'); ?> :</label>
                        <input type="text" name="fromdate" class="form-control <?php echo DATEPICKER_CLASS; ?>"  value="<?php echo DISPLAY_DATE; ?>" id="fromdate">
                    </div>
                    <div class="col-sm-2 col-xs-6">
                        <label for=""><?php echo $this->lang->line('to_date'); ?> :</label>
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
    
     $(document).on('click','.btnSearch',function() {
        var rpttype=$(this).val();
        var reportType = $('#rpttype option:selected').text();
    
        var distributortype = $('#distributortype option:selected').text();
    
        var action=base_url+'/biomedical/contractmanagement/generate_report';
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
         
          if(distributortype != null){
            $('#distributorType').html(distributortype);
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
      var distributorid = $('#distributortype option:selected').val();
      var fromdate=$('#fromdate').val();
      var todate=$('#todate').val();

      var reportType = $('#rpttype option:selected').text();
    
      var distributortype = $('#distributortype option:selected').text(); 
    
      var redirecturl=base_url+'biomedical/contractmanagement/generate_pdf';
      $.redirectPost(redirecturl, {rpttype:rpttype,coin_distributorid:distributorid,fromdate:fromdate,todate:todate, reportType:reportType, distributortype:distributortype});
     })

     $(document).off('click','.btn_excel');
     $(document).on('click','.btn_excel',function(){
      var rpttype =$('#rpttype').val();
      var distributorid = $('#distributortype option:selected').val();
      var fromdate=$('#fromdate').val();
      var todate=$('#todate').val();

      var reportType = $('#rpttype option:selected').text();
    
      var distributortype = $('#distributortype option:selected').text(); 
    
      var redirecturl=base_url+'biomedical/contractmanagement/generate_excel';
      $.redirectPost(redirecturl, {rpttype:rpttype,coin_distributorid:distributorid,fromdate:fromdate,todate:todate, reportType:reportType, distributortype:distributortype});

     });
</script>