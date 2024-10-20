<table id="Dtable" class="table table-striped dataTable">
	<tr>
		<th width="5%">S.No.</th>
		<th width="20%">User Name</th>
		<th width="25%">Action Status</th>
		<th width="20%">Comment</th>
		<th width="20%">Action Date/ Time</th>
		<th width="10%">Action IP</th>
		<!-- <th>Action Mac Add.</th> -->
	</tr>
	<?php
		if(!empty($history_data)):
			foreach($history_data as $khd=>$vhd):
	?>
		<tr>
			<td><?php echo $khd+1;?></td>
			<td><?php echo $vhd->usma_username;?></td>
			<td><?php echo $vhd->inst_comment;?></td>
			<td><?php echo (!empty($vhd->aclo_comment) || $vhd->aclo_comment != 0)?$vhd->aclo_comment:'';?></td>
			<td><?php echo $vhd->aclo_actiondatebs;?> <?php echo $vhd->aclo_actiontime;?></td>
			<td><?php echo $vhd->aclo_actionip;?></td>
			<!-- <td><?php echo $vhd->aclo_actionmac;?></td> -->
		</tr>
	<?php
			endforeach;
		endif;
	?>
</table>

<?php
	// echo "<pre>";
	// print_r($last_action);
	$last_action_userid = !empty($last_action->usma_userid)?$last_action->usma_userid:0;
	$last_action_tablename = !empty($last_action->aclo_tablename)?$last_action->aclo_tablename:'';
	$last_action_masterid = !empty($last_action->aclo_masterid)?$last_action->aclo_masterid:0;
	$last_action_fieldname = !empty($last_action->aclo_fieldname)?$last_action->aclo_fieldname:0;
	$last_action_status = !empty($last_action->aclo_status)?$last_action->aclo_status:0;

	$last_action_array = array(
		'userid'=>$last_action_userid,
		'masterid'=>$last_action_masterid,
		'tablename' => $last_action_tablename,
		'fieldname'=>$last_action_fieldname,
		'status' => $last_action_status
	);

	$last_action_val = json_encode($last_action_array);

	$prev_action_userid = !empty($prev_action->usma_userid)?$prev_action->usma_userid:0;
	$prev_action_tablename = !empty($prev_action->aclo_tablename)?$prev_action->aclo_tablename:'';
	$prev_action_masterid = !empty($prev_action->aclo_masterid)?$prev_action->aclo_masterid:0;
	$prev_action_fieldname = !empty($prev_action->aclo_fieldname)?$prev_action->aclo_fieldname:0;
	$prev_action_status = !empty($prev_action->aclo_status)?$prev_action->aclo_status:0;

	$prev_action_array = array(
		'userid'=>$prev_action_userid,
		'masterid'=>$prev_action_masterid,
		'tablename' => $prev_action_tablename,
		'fieldname'=>$prev_action_fieldname,
		'status' => $prev_action_status
	);

	$prev_action_val = json_encode($prev_action_array);


	if($last_action_userid == $this->userid){
?>
<a id="undoLastAction" class="btn btn-warning" data-lastaction='<?php echo $last_action_val;?>' data-prevaction='<?php echo $prev_action_val;?>' >Undo Last Action</a>
<?php
	}
?>

<script type="text/javascript">
	$(document).off('click','#undoLastAction');
    $(document).on('click','#undoLastAction',function(e){
      
		var lastaction=$(this).data('lastaction');
		var prevaction = $(this).data('prevaction');

		var conf = confirm("Are you sure?");
		if(conf){
			var action=base_url+'issue_consumption/stock_requisition/undo_last_action';

			$.ajax({
			 	type: "POST",
			 	url: action,
			 	data:{lastaction:lastaction, prevaction:prevaction },
			 	dataType: 'html',
			 	beforeSend: function() {
			    	$('.overlay').modal('show');
			 	},
			 	success: function(jsons) 
			 	{
			    	data = jQuery.parseJSON(jsons);   
			 		if(data.status=='success'){
                        $('.success').html(data.message);
                        $('.success').show();
                    }else{
                        $('.error').html(data.message);
                        $('.error').show();
                    }
                    $('.overlay').modal('hide');
                    setTimeout(function(){
                        $('.success').hide();
                    },1000);
			 	}
			});
			return false;
		}

		
	});
</script>