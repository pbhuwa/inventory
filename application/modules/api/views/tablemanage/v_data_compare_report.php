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
			<?php 
				if(!empty($source) && is_array($source)){
					$no_of_src_tbl=sizeof($source);
				}else{
					$no_of_src_tbl=0;
				}
				if(!empty($destination) && is_array($destination)){
					$no_of_dest_tbl=sizeof($destination);
				}else{
					$no_of_dest_tbl=0;
				}
				$cnt_missing=$no_of_src_tbl-$no_of_dest_tbl;

			 ?>
			 <span class="alert alert-danger"><?php if($cnt_missing>0) echo '<strong>'.$cnt_missing.'</strong> Table is missing in destination Database'; else echo '<strong>'.$cnt_missing.'</strong> Table is missing in Source Database'; ?></span>
			<table class="table table-bordered table-hover table-condensed">
				<thead>
					<th width="5%">S.No.</th>
					<th width="10%">Table Name</th>
					<th width="5%">Source (<?php echo $no_of_src_tbl; ?>)</th>
					<th width="5%">S.Rows</th>
					<th width="5%">Destination (<?php echo $no_of_dest_tbl; ?>)</th>
					<th width="5%">D.Rows</th>
					<th width="10%">Action <a href="javascript:void(0)" data-table_name="all" class="pull-right btn btn-xs btn-primary btn_synch_all">All Synch Data</a></th>
				</thead>
				<tbody>
				<?php
				// echo "<pre>";
				// print_r($destination);
				// die();
				$destarr=array();
				if(!empty($destination)){
					foreach($destination as $dest){
						$destarr[]=$dest->destination_tablename;
						$destrow_cnt[$dest->destination_tablename]=$dest->destination_table_rows;

					}
				}
				// echo "<pre>";
				// print_r($destrow_cnt);
				// die();
				$i=1;
				if(!empty($source)):
					foreach ($source as $ks => $sdata):
						$destination_tbl=!empty($destination[$ks]->destination_tablename)?$destination[$ks]->destination_tablename:'';
						$destination_row=!empty($destination[$ks]->destination_table_rows)?$destination[$ks]->destination_table_rows:'0';
				?>
				<?php if(in_array($sdata->source_tablename,$destarr)): 
						$class="alert alert-success";
					else:
						$class="alert alert-danger";
					  endif;
				?>
				<tr class="<?php echo $class; ?>">
					<td><?php echo $i; ?></td>
					<td><?php echo $sdata->source_tablename; ?></td>
					<td><?php if(!empty($sdata->source_tablename)) echo '<i class="fa fa-check" aria-hidden="true"></i>'; else echo '<i class="fa fa-times" aria-hidden="true"></i>'; ?></td>
					<td><?php echo $sdata->source_table_rows; ?></td>
					<td><?php if(in_array($sdata->source_tablename,$destarr)):
					echo '<i class="fa fa-check" aria-hidden="true"></i>'; else: echo '<i class="fa fa-times" aria-hidden="true"></i>'; endif; ?></td> 
					<!-- <td><?php echo $destination_tbl;  ?></td> -->
					<td><span id="destination_row_<?php echo $sdata->source_tablename; ?>"><?php echo !empty($destrow_cnt[$sdata->source_tablename])?$destrow_cnt[$sdata->source_tablename]:0; ?></span> </td>
					<td><span id="synch_progress_<?php echo $sdata->source_tablename; ?>"></span>

						<?php if($sdata->source_table_rows==$destination_tbl && $sdata->source_table_rows!='0'): ?>
						<a href="javascript:void(0)" data-table_name="<?php echo $sdata->source_tablename; ?>" class="pull-right btn btn-sm btn-primary btn_synch">Re-synch</a>
						<?php else: ?>
							<a href="javascript:void(0)" data-table_name="<?php echo $sdata->source_tablename; ?>" class="pull-right btn btn-sm btn-warning btn_synch">Synch Data</a>
						<?php endif; ?>
					</td>
					

				</tr>
			<?php $i++; endforeach; endif; ?>
				</tbody>
				
					<tr>
						<td colspan="8">Alter Query To Destination Database</td></tr>
					<tr>
						<td colspan="8">
							<textarea style="width: 100%"><?php echo $alter_query; ?></textarea>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>


<script type="text/javascript">
	$(document).off('click','.btn_synch');
	$(document).on('click','.btn_synch',function(e){
		// alert('ewat');
		var tblname=$(this).data('table_name');
		var dbsourceid=$('#source').val();
		var dbdestinationid=$('#destination').val();
		var synch_url=base_url+'api/api_tablemanage/data_synch_process';
		  $.ajax({
		    type: "POST",
		    url: synch_url,
		    data:{tblname:tblname,dbsourceid:dbsourceid,dbdestinationid:dbdestinationid},
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