<form id="ReceiveAnalysis" action="" class="form-material form-horizontal form">
    <div class="form-group">
        <div class="col-md-3 col-sm-3 col-xs-12">
            <label for="example-text">From  Date : </label>
            <input type="text" name="fromdate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Dispatch Date" value="<?php echo DISPLAY_DATE;?>" id="fromdate">
            <span class="errmsg"></span>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12">
            <label for="example-text">To Date : </label>
            <input type="text" name="todate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Dispatch To" value="<?php echo DISPLAY_DATE;?>" id="todate">
            <span class="errmsg"></span>
        </div>
    <div class="col-md-2 col-sm-4 col-xs-12">
      <label for="example-text">Select Categories <span class="required">*</span>:</label>
      <select name="eqty_equipmenttypeid" class="form-control select2" id="store_id">
        <option value="">---All---</option>
        <?php
        if($equipmenttype):
        foreach ($equipmenttype as $km => $eq):
        ?>
        <option value="<?php echo $eq->eqty_equipmenttypeid; ?>"><?php echo $eq->eqty_equipmenttype; ?></option>
        <?php
        endforeach;
        endif;
        ?>
      </select>
    </div>
        <div class="col-md-2 col-sm-4 col-xs-12">
            <div>
                <label for="">&nbsp;</label>
            </div>
            <button type="submit" class="btn btn-info receiveAnalysisTest mtop_0" >Search</button>
        </div>
        <div class="clearfix"></div>
        <div id="ResponseSuccess" class="waves-effect waves-light m-r-Y0 text-success "></div>
        <div id="ResponseError" class="waves-effect waves-light m-r-Y0 text-danger"></div>
        <div id="receiveAnalysis"></div>   
    </div>
</form>
<script type="text/javascript">
    $(document).on('click','.receiveAnalysisTest',function() {
       var rpttype=$(this).val();
       // var formid=$('.searchRepoort').closest('form').attr('id');
       // var action=$('#'+formid).attr('action'); alert(action);
       var action=base_url+'stock_inventory/receive_analysis/receive_analysis_search';
       $.ajax({
       type: "POST",
           url: action,
           data:$('#ReceiveAnalysis').serialize(),
           dataType: 'html',
           beforeSend: function() {
            $('.overlay').modal('show');
      },
     success: function(jsons) //we're calling the response json array 'cities'
      {
        console.log(jsons);

          data = jQuery.parseJSON(jsons);   
            //alert(data.status);
          if(data.status=='success')
          {
            // $('#Subtype').html(data.template);
            $('#receiveAnalysis').html(data.template);
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

    $(document).off('click','.pdfstock_inpurchase');
    $(document).on('click','.pdfstock_inpurchase',function(){
        var todate=$('#todate').val();
        var fromdate=$('#fromdate').val(); 
        var eqty_equipmenttypeid= $('#eqty_equipmenttypeid').val(); 
        var redirecturl=base_url+'stock_inventory/receive_analysis/receive_pdf';
            $.redirectPost(redirecturl, {eqty_equipmenttypeid:eqty_equipmenttypeid,fromdate:fromdate,todate:todate});
    })

    $(document).off('click','.stockInpurchase');
    $(document).on('click','.stockInpurchase',function(){
        var todate=$('#todate').val();
        var fromdate=$('#fromdate').val(); 
        var eqty_equipmenttypeid= $('#eqty_equipmenttypeid').val(); 
        var redirecturl=base_url+'stock_inventory/receive_analysis/excel_receive';
            $.redirectPost(redirecturl, {eqty_equipmenttypeid:eqty_equipmenttypeid,fromdate:fromdate,todate:todate});
    })
</script>