<form id="FormReportGeneration" action="<?php //echo base_url('issue_consumption/report/search_result'); ?>" class="form-material form-horizontal form">
	<div class="form-group">
		<div class="col-md-2">
			<label for="example-text"><?php echo $this->lang->line('from_date'); ?> </label>
			<input type="text" name="fromdate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Dispatch Date" value="<?php echo DISPLAY_DATE;?>" id="FromDate">
			<span class="errmsg"></span>
		</div>
		<div class="col-md-2">
			<label for="example-text">To Date : </label>
			<input type="text" name="todate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Dispatch To" value="<?php echo DISPLAY_DATE;?>" id="Todate">
			<span class="errmsg"></span>
		</div>
		<div class="col-md-2">
			<div>
				<label for="">&nbsp;</label>
			</div>
			<label for="example-text">Summaray  : </label>
			<input type="checkbox" value="summaray" name="summaray" class="checkbox-inline">
		</div>
		<div class="col-md-2 ">
			<div>
				<label for="">&nbsp;</label>
			</div>
			<label for="example-text">Details : </label>
			<input type="checkbox" value="Details" name="Details" class="checkbox-inline">
		</div>
		<div class="col-md-2">
			<label for="example-text">Store :<span class="required">*</span>:</label>
			<select name="store_id" class="form-control select2" id="ststore_id">
				<option value="">---select---</option>
				<?php
				if($store):
				foreach ($store as $km => $st):
				?>
				<option value="<?php echo $st->st_store_id; ?>"><?php echo $st->st_name; ?></option>
				<?php
				endforeach;
				endif;
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-4">
			<label for="example-text">Issue By : <span class="required">*</span>:</label>
			<select name="username" class="form-control select2" id="username">
				<option value="">---select---</option>
				<?php
				if($user):
				foreach ($user as $km => $u):
				?>
				<option value="<?php echo $u->usma_userid; ?>"><?php echo $u->usma_username; ?></option>
				<?php
				endforeach;
				endif; ?>
			</select>
		</div>
		<div class="col-md-4">
			<div>
				<label for="">&nbsp;</label>
			</div>
			<button type="submit" class="btn btn-info searchRepoort">Search</button>
		</div>
			<div id="ResponseSuccess" class="waves-effect waves-light m-r-Y0 text-success"></div>
	        <div id="ResponseError" class="waves-effect waves-light m-r-Y0 text-danger"></div>
		</div>
	</div>
</form>
<script type="text/javascript">
    $(document).on('click','.searchRepoort',function() {
      var rpttype=$(this).val();
      var action=base_url+'/issue_consumption/issue_value_report/search_issue_value';
       $.ajax({
       type: "POST",
	       url: action,
	       data:$('#FormReportGeneration').serialize(),
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
      
       var redirecturl=base_url+'biomedical/reports/download_pmdatareport';
         $.redirectPost(redirecturl, {id:id,frmDate:frmDate,toDate:toDate});
     })
</script>