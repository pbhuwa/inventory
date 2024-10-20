<style>
	.table>tbody>tr>td, .table>thead>tr>th{
		padding: 5px;
	}
	.text-danger{
		font-size: 10px;
	}
</style>

<div class="container">
	<div class="col-md-12">
		<div class="table-responsive">
			<h5>Data Comparison</h5>
			<table class="table table-bordered table-hover table-condensed">
				<thead>
					<th width="5%">S.No.</th>
					<th width="10%">Table Name</th>
					<th width="5%">Source</th>
					<th width="5%">S.Rows</th>
					<th width="5%">Destination</th>
					<th width="5%">D.Rows</th>
					<th width="10%">Action <a href="javascript:void(0)" data-table_name="all" class="pull-right btn btn-sm btn-primary btn_synch_all">All Synch</a></th>
				</thead>
				<tbody>
				<?php
				$i=1;
				if(!empty($comparr_data)):
					foreach ($comparr_data as $kcd => $dat):
				?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo $dat->source_tablename; ?></td>
					<td><?php if(!empty($dat->source_tablename)) echo '<i class="fa fa-check" aria-hidden="true"></i>'; else echo '<i class="fa fa-times" aria-hidden="true"></i>'; ?></td>
					<td><?php echo $dat->source_table_rows; ?></td>
					<td><?php if(!empty($dat->destination_tablename)) echo '<i class="fa fa-check" aria-hidden="true"></i>'; else echo '<i class="fa fa-times" aria-hidden="true"></i>'; ?></td>
					<td><span id="destination_row_<?php echo $dat->source_tablename; ?>"><?php echo $dat->destination_table_rows; ?></span></td>
					<td><span id="synch_progress_<?php echo $dat->source_tablename; ?>"></span>

						<?php if($dat->source_table_rows==$dat->destination_table_rows && $dat->source_table_rows!='0'): ?>
						<a href="javascript:void(0)" data-table_name="<?php echo $dat->source_tablename; ?>" class="pull-right btn btn-sm btn-primary btn_synch">Re-synch</a>
						<?php else: ?>
							<a href="javascript:void(0)" data-table_name="<?php echo $dat->source_tablename; ?>" class="pull-right btn btn-sm btn-warning btn_synch">Synch</a>
						<?php endif; ?>
					</td>

				</tr>
			<?php $i++; endforeach; endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>


<script type="text/javascript">
	$(document).off('click','.btn_synch');
	$(document).on('click','.btn_synch',function(e){
		// alert('ewat');
		var tblname=$(this).data('table_name');
		var synch_url=base_url+'/data_migration/migration/table_synch_process';
		  $.ajax({
		    type: "POST",
		    url: synch_url,
		    data:{tblname:tblname},
		    dataType: 'html',
		    beforeSend: function() {
		     $('#synch_progress_'+tblname).html('Progress...');
		    },
		     success: function(jsons) //we're calling the response json array
		     {
		       data = jQuery.parseJSON(jsons);   
		          // alert(data.status);
		          if(data.status=='success'){
		          	$('#synch_progress_'+tblname).html('<label class="label label-success">Completed</label>');
		          	$('#destination_row_'+tblname).html(data.count_rws);
		          }
		          else
		          {
		            $('#synch_progress_'+tblname).html('<label class="label label-danger">Incompleted</label>');
		          }
		        }
		      });
	});
	

	$(document).off('click','.btn_synch_all');
	$(document).on('click','.btn_synch_all',function(e){
	   $(".btn_synch").each(function(i){
	    $(this).click();
	    // console.log('test');
	});
	});
</script>