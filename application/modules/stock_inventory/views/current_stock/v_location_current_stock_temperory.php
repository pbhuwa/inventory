<?php 
$ismain=$this->session->userdata(ISMAIN_LOCATION); 
$locationid=$this->session->userdata(LOCATION_ID);
?>
<style type="text/css">
	.reject{
		background: #fff4f1 !important;;
	}
</style>
<div class="table-responsive col-sm-12">
	<input type="hidden" id="handovermasterid" value="<?php echo !empty($handovermasterid)?$handovermasterid:''; ?>" >
	<table style="width:100%;" class="table purs_table dataTable con_ttl" >
	<thead>
		<tr>
		<th>S.n</th>
		<th>Item Code</th>
		<th>Item Name</th>
		<?php
		if(!empty($location)):
		foreach ($location as $key => $loca) {
			if($locationid!=$loca->loca_locationid){
			?>
			<th><?php echo $loca->loca_name; ?></th>
		<?php
		} 
			}
		endif;
		?>
	</tr>
	</thead>
	<tbody>
	<?php 
	// echo "<pre>";
	// print_r($stock_list_item);
	// die();
	if(!empty($stock_list_item)):
		$i=1;
		foreach ($stock_list_item as $st => $val):

	?>
	<tr>
		<td><?php echo $i ?>.</td>
		<td><?php echo $val->tels_itemcode; ?></td>
		<td><?php echo $val->tels_itemname; ?></td>
		<?php
		$totalallloc=0;

		foreach ($location as $key => $locat) {
			   			$rwloc=('location_'.$locat->loca_locationid);
				   		$row_locstkval= !empty($val->{$rwloc})?$val->{$rwloc}:'0'; 
				   		$totalloc= !empty($val->{$rwloc})?$val->{$rwloc}:0;
				   		$totalallloc +=$totalloc;
				   		if($locationid!=$locat->loca_locationid){
				   	?>
				   	<td><?php 
				   	if($ismain=='Y'):
				   		if($row_locstkval==0): 
				   		$shwclass='<span class="text text-danger">'.$row_locstkval.'</span>'; 
				   		else: $shwclass='<span class="text text-success"><input type="radio" class="itemloc" name="itemloc_'.$val->tels_itemid.'" value="'.$val->tels_itemid.'|'.$locat->loca_locationid.'"> '.$row_locstkval.'</span>'; 
				   		endif; 
				   	else:
				   		if($row_locstkval==0): 
				   		$shwclass='<span class="text text-danger">N</span>'; 
				   	else: $shwclass='<span class="text text-success">Y</span>'; 
				   	endif;
				   endif;
				   
				   		echo $shwclass ?></td>
				   	<?php
				   	} 
				   	}
		?>
	</tr>
	<?php
	$i++;
		endforeach;
	endif;
	?>
	</tbody>

</table>
</div>

<div id="divprocess">
	<?php 	if($ismain=='Y'): ?>
	<a href="javascript:void(0)" class="btn btn-sm btn-primary btnrequest"><i class="fa fa-check"></i> Request </a>
	  <?php endif; ?>
	  <div class="col-sm-12">
                <div  class="alert-success successs"></div>
                <div class="alert-danger errors"></div>
  </div>
	
	<!-- <div id="remarks" style="display: none">
		<textarea id="reject_reason" style="padding: 15px;margin-left: 152px;"></textarea>
		<a href="javascript:void(0)" class="btn btn-sm btn-success" id="btn_save_reject" style="margin-top: -23px;">Send</a><a href="javascript:void(0)" class="btn btn-sm btn-danger" id="btn_close_btn" style="margin-top: -23px;">Close</a>
	</div> -->
	
	
</div>

<script type="text/javascript">
	// $(document).off('click','.btnreject');
	// $(document).on('click','.btnreject',function(e){
	// $('#remarks').show();
	// return false;
	// });

	$(document).off('click','.btnrequest');
	$(document).on('click','.btnrequest',function(e){
	var itemlist = [];
	var handovermasterid=$('#handovermasterid').val();
	$.each($("input:radio.itemloc:checked"), function(){            
	    itemlist.push($(this).val());
	 });
	// console.log(itemlist);
	var action=base_url+'handover/handover_req/handover_req_to_branch';
	 $.ajax({
          type: "POST",
          url: action,
          data:{itemlist:itemlist,handovermasterid:handovermasterid},
          dataType: 'html',
          beforeSend: function() {
            $('.overlay').modal('show');
          },
         success: function(jsons) {
            data = jQuery.parseJSON(jsons);   
        // alert(data.status);
            if(data.status=='success'){
              console.log(data.tempform);
              $('.displyblock2').html(data.tempform);
               $('.successs').html(data.message);
            }

              
           else{
            alert(data.message);
            $('.errors').html(data.message);
           }
          $('.overlay').modal('hide');
        }
       });


	});


	
</script>