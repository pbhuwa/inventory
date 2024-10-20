<?php 
	if(!empty($received_details)):
		$i=1;
		foreach ($received_details as $kid => $isdd):

			if(ITEM_DISPLAY_TYPE=='NP'){
                	$req_itemname = !empty($isdd->itli_itemnamenp)?$isdd->itli_itemnamenp:$isdd->itli_itemname;
                }else{ 
                    $req_itemname = !empty($isdd->itli_itemname)?$isdd->itli_itemname:'';
                }


			$cls='';
			$cancel_status=$isdd->recd_iscancel;
			if($cancel_status=='Y')
			{
				$cls='text-danger';
			}
			$purchaseqty = !empty($isdd->recd_purchasedqty)?$isdd->recd_purchasedqty:0;

			if($purchaseqty > 0):
?>
	<tr id="row_<?php echo $i; ?>" class="<?php echo $cls; ?> trclass" >
		<td><?php echo $i; ?>.</td>
		<td><?php echo $isdd->itli_itemcode ?></td>
		<td><?php echo  $req_itemname ?></td>
		<td><?php echo (int)$isdd->recd_purchasedqty; ?></td>
		<td><?php echo $isdd->recd_arate; ?></td>
		<td><?php echo ($isdd->recd_purchasedqty)*($isdd->recd_arate); ?></td>
	</tr>

	<tr>
		<td colspan="5" class="text-right"><strong>Discount: </strong></td>
		<td><?php echo $isdd->recm_discount;?></td>
	</tr>
	<tr>
		<td colspan="5" class="text-right"><strong>VAT: </strong></td>
		<td><?php echo $isdd->recm_taxamount;?></td>
	</tr>
	<tr>
		<td colspan="5" class="text-right"><strong>Total Amount: </strong></td>
		<td><?php echo $isdd->recm_amount;?></td>
	</tr>
	<?php
		$i++;
			endif;
		endforeach;
	endif;
?>


