<?php 
	if(!empty($receive_detail)):
		$i=1;

		foreach ($receive_detail as $kid => $recdd):
			if(ITEM_DISPLAY_TYPE=='NP'){
                $req_itemname = !empty($recdd->itli_itemnamenp)?$recdd->itli_itemnamenp:$recdd->itli_itemname;
            }else{ 
                 $req_itemname = !empty($recdd->itli_itemname)?$recdd->itli_itemname:'';
            }

            $cls='';

   //          $cancel_status=$recdd->sade_iscancel;

   //          if($cancel_status=='Y')
   //          {
			// 	$cls='text-danger';
			// }
?>
	<tr id="row_<?php echo $i; ?>" class="<?php echo $cls; ?> trclass" >
		<td>
			<?php echo $i; ?>.
			<input type="hidden" name="recd_detailid" id="recd_detailid" value="<?php $recdd->recd_receiveddetailid; ?>"/>
			<input type="hidden" name="recm_masterid" id="recm_masterid" value="<?php $recdd->recm_receivedmasterid; ?>"/>
			<!-- <input type="hidden" name="mattransdetailid" id="mattransdetailid" value="<?php $recdd->sade_mattransdetailid; ?>"/> -->
			<!-- <input type="hidden" name="reqdetailid" id="reqdetailid" value="<?php $recdd->sade_reqdetailid; ?>"/> -->
			<!-- <input type="hidden" name="sno" id="sno" value="<?php $recdd->sade_sno; ?>"/> -->

		</td>
		<td>
			<?php echo $recdd->itli_itemcode ?>
			<input type="hidden" name="itemcode" id="itemcode" value="<?php $recdd->itli_itemcode; ?>"/> 
			<input type="hidden" name="itemsid" id="itemsid" value="<?php $recdd->itli_itemlistid; ?>"/> 
		</td>
		<td><?php echo $recdd->itli_itemname ?></td>
		<!-- <td><?php echo $recdd->sade_batchno ?></td>
		<td><?php echo $recdd->sade_expdate ?></td> -->
		<td>
			<?php echo $recdd->recd_purchasedqty ?>
			<input type="hidden" name="qty" id="qty" value="<?php $recdd->recd_purchasedqty; ?>"/> 
		</td>
		<td>
			<?php echo $recdd->recd_unitprice ?>
			<input type="hidden" name="unitrate" id="unitrate" value="<?php $recdd->recd_unitprice; ?>"/> 
		</td>
		<td><?php echo ($recdd->recd_purchasedqty)*($recdd->recd_unitprice) ?></td>
		<!-- <td class="trstatus">
			<?php if($cancel_status!='Y')
		{ ?>
			<a href="javascript:void(0)" class="btn btn-sm btn-danger btnConfirm" title='Cancel' data-url='<?php echo base_url('issue_consumption/new_issue/issue_cancel_item') ?>' data-id="<?php echo $recdd->recd_receiveddetailid; ?>" data-msg='Cancel This Item ?' data-rowid="<?php echo $i; ?>" ><i class="fa fa-remove" ></i> Cancel</a>
	<?php }?>
		</td> -->
	</tr>
<?php
$i++;
endforeach;
endif;
?>


