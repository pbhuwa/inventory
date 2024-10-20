
        <div class="row">
            <div class="col-md-6">
              <div class="white-box">
                <h3 class="box-title">Maintenance Log Entry</h3>
                <div id="FormDiv" class="formdiv frm_bdy">
                <form method="post" id="FormMaintenance" action="<?php echo base_url('biomedical/Bio_medical_inventory/save_maintenance'); ?>"  class="form-material form-horizontal form">
                    <div class="form-group mbtm_0">

              	 <?php $this->load->view('common/equipment_detail'); ?>
                  <div class="clear"></div>
                   <div class="col-md-12">
                      <label>Problem: </label>
                      <textarea style="width: 100%;height: 50px;" name="malo_comment" class="form-control" autofocus="true"></textarea>
                            
                        </div>
                         <div class="col-md-12">
                            <label>Tentative Solution: </label>
                            <textarea style="width: 100%;height: 50px;" name="malo_remark" class="form-control" autofocus="true"></textarea>
                       </div>

                          <div class="col-md-4">



                              <label for="example-text"> Time: </label>

                              <?php $a=$this->general->get_currenttime();

                                   $time=date("h:i a",strtotime($a));?>

                              <input  name="malo_time" class="form-control time"  value="<?php echo !empty($customer_query_data[0]->malo_time)?$customer_query_data[0]->malo_time:$time; ?>" id="cuqu_time">
                            </div>
                         <div class="col-md-4">
                        <label>Maintained Date: </label>
                        <input type="text" name="malo_commentdatebs" id="malo_commentdatead" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE ?>"/>
                    </div>
                    
                    <input type="hidden" value="<?php echo !empty($eqli_data[0]->bmin_equipid)?$eqli_data[0]->bmin_equipid:''; ?>" name="malo_equipid" id="eqco_eqid"/>


                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-info save mtop_10"  >Save</button>
                            <div  class="alert-success success"></div>
                            <div class="alert-danger error"></div>
                        </div>
                    </div>
                </form>
            </div>
          </div>
        </div>

           <div class="col-sm-6">
            <a href="javascript:void(0)" class="pull-right btn btn-sm btn-success btnRefresh"><i class="fa fa-refresh" aria-hidden="true"></i></a>
            <div class="white-box">
                <h3 class="box-title">Previous Log</h3>
                <div class="table-responsive dtable_pad scroll">
                       <input type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >
                      <input type="hidden" id="DeleteUrl" value="<?php echo $deleteurl; ?>" >
                    <div id="TableDiv">
                        <?php echo $this->load->view('maintenance_log/v_maintenancelog_list'); ?>
                    </div>
                </div>
            </div>
        </div>

        
	
  </div>



<script type="text/javascript">
		$(document).off('click','.maintainanceModel');
	$(document).on('click','.maintainanceModel',function(){
		//alert('hello');
		$('#maintenanceModal').modal('show');
	});

  
</script>

<!-- <script>
  $(document).off('click','.btn_Reload');
  $(document).on('click','.btn_Reload',function(){
 
    //var listurl=$('#ListUrl').val();  //alert(listurl);
    var listurl=base_url().'biomedical/maintenance_log/list_mlog_comments';
    alert(listurl);

    $.ajax({
    type: "POST",
    url: listurl,
    
     dataType: 'html',
     beforeSend: function() {
      $('.overlay').modal('show');
    },
   success: function(jsons) //we're calling the response json array 'cities'
    {
       data = jQuery.parseJSON(jsons);   
        // alert(data.status);
        if(data.status=='success')
        {
           $('#TableDiv').html(data.template);
         var table= $('#Dtable').DataTable();
        }
        else
        {
          alert(data.message);
        }
        $('.overlay').modal('hide');
    }
  });



  });
</script>
 -->

