
<?php 
if(!empty($issue_detail)):
	$i=1;
?>

<?php
foreach ($issue_detail as $kid => $isdd):
	// echo "<pre>";
	// print_r($issue_detail);
	// die();

				if(ITEM_DISPLAY_TYPE=='NP'){
                	$req_itemname = !empty($isdd->itli_itemnamenp)?$isdd->itli_itemnamenp:$isdd->itli_itemname;
                }else{ 
                    $req_itemname = !empty($isdd->itli_itemname)?$isdd->itli_itemname:'';
                }


?>

<tr id="row_<?php echo $i; ?>">
	<td>
		<?php echo $i; ?>.
		<input type="hidden" name="mattransdetailid[]" value="<?php echo $isdd->itli_itemlistid;?>" />
	</td>
	<td>
		<?php echo $isdd->itli_itemcode ?>
		<input type="hidden" name="itemsid[]" value="<?php echo $isdd->itli_itemlistid;?>" />
	</td>
	<td><?php echo $req_itemname ?></td>
	<td>
		<?php echo $isdd->totalcurqty ?>
		<input type="hidden" name="qty[]" value="<?php echo $isdd->totalcurqty; ?>" />
	</td>
	<!-- <td><?php echo 0; ?></td> -->
	<td><?php echo $isdd->sade_unitrate ?>
		<input type="hidden" name="unit_rate[]" id="unite_rate_<?php echo $i; ?>" value="<?php echo $isdd->sade_unitrate; ?>">
		<input type="hidden" name="issueqty[]" id="issueqty_<?php echo $i; ?>" value="<?php echo $isdd->totalcurqty; ?>">
		<input type="hidden" name="reqdetailid[]" id="reqdetailid_<?php echo $i; ?>" value="<?php echo $isdd->sade_reqdetailid; ?>">
	</td>
	<td><input type="text" class="form-control number calculatamt" name="returnqty[]" data-id='<?php echo $i; ?>' value="0" id="returnqty_<?php echo $i; ?>"></td>
	<td><span id="returnAmt_<?php echo $i; ?>"></span>
		<input type="hidden" class="retamttotal" name="retamt_total[]" id="retamt_total_<?php echo $i; ?>" value="" >
	</td>
	<td><input type="text" class="form-control" name="remarks[]" data-id='<?php echo $i; ?>' value="" id="remarks_<?php echo $i; ?>"></td>
	<td>
		<a href="javascript:void(0)" class="btn btn-danger btnRemove" data-id="1"  id="addRequistion_1"><span class="btnChange" id="btnChange_1"><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>
	</td>
	
</tr>
<?php
$i++;
endforeach;
?>
<input type="hidden" name="salesmasterid" value="<?php echo !empty($issuemasterid)?$issuemasterid:''; ?>">
<?php
endif;
?>


<script type="text/javascript">
	$(document).off('click','.btnRemove');
    $(document).on('click','.btnRemove',function(){
        var id=$(this).data('id');
         var whichtr = $(this).closest("tr");
         var conf = confirm('Are Your Want to Sure to remove?');
          if(conf)
          {
            var trplusOne = $('.orderrow').length+1;
            
             whichtr.remove(); 
           
          }
     });
</script>