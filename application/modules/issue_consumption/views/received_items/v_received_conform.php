<?php if(!empty($sama_receivedstatus) && $sama_receivedstatus=='RC' ): ?>
<a href="javascript:void(0)" class="btn btn-sm btn-success btnstatus" data-status='received' data-msg='Received'>Received</a>
<a href="javascript:void(0)" class="btn btn-sm btn-warning btnstatus"  data-status='not_received' data-msg='Not Received'>Not Received</a>
<a href="javascript:void(0)" class="btn btn-sm btn-primary btnstatus"  data-status='return' data-msg='Return '>Return</a>
<a href="javascript:void(0)" class="btn btn-sm btn-danger btnstatus" data-status='reject' data-msg='Reject'>Reject</a>
<input type="hidden" id="salesmasterid" value="<?php echo !empty($smid)?$smid:''; ?>">
<div class="clearfix"></div>
<?php endif; ?>
<label id="statusMsg" ></label>
<?php if($sama_receivedstatus=='AC' ): ?>
<label class="label label-success">You have already Received !!</label>
<?php endif; ?>
<?php if($sama_receivedstatus=='RE' ): ?>
<label class="label label-danger">You have already Rejected !!</label>
<?php endif; ?>
<?php if($sama_receivedstatus=='RE' ): ?>
<label class="label label-success">You have already Rejected !!</label>
<?php endif; ?>

<script type="text/javascript">
	$('#btnPrintNowBtn').remove();
</script>

<script type="text/javascript">
	$(document).off('click','.btnstatus');
	$(document).on('click','.btnstatus',function(e){
		var status=$(this).data('status');
		var msg=$(this).data('msg');
		var smid=$('#salesmasterid').val();
		 var conf = confirm('Are you Want to Sure to '+msg+' ?');
		  var change_status_url=base_url+'issue_consumption/received_items/change_received_status';
	 	if(conf)
	    {
		   $.ajax({
		    type: "POST",
		    url: change_status_url,
		    data:{smid:smid,inp_status:status},
		    dataType: 'html',
		    beforeSend: function() {
		      $('.overlay').modal('show');
		    },
	     success: function(jsons) 
	     {
	       data = jQuery.parseJSON(jsons);   
	          // alert(data.status);
	          if(data.status=='success')
	          {
	            $('#statusMsg').addClass('alert alert-success');
	            $('#statusMsg').html(data.message);

	          }
	          else
	          {
	            $('#statusMsg').addClass('alert alert-danger');
	            $('#statusMsg').html(data.message);
	          }
	          $('.overlay').modal('hide');

	          setTimeout(function(){
                    $('#myView').modal('hide');
                },1000);
	        }
	      });
	}
	})
</script>