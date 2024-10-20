<
<?php 
if(!empty($issue_detail)):
	$i=1;

foreach ($issue_detail as $kid => $isdd):

	if(ITEM_DISPLAY_TYPE=='NP'){
                	$req_itemname = !empty($isdd->itli_itemnamenp)?$isdd->itli_itemnamenp:$isdd->itli_itemname;
                }else{ 
                    $req_itemname = !empty($isdd->itli_itemname)?$isdd->itli_itemname:'';
                }
$cls='';
$cancel_status=$isdd->sade_iscancel;
	if($cancel_status=='Y')
	{
		$cls='text-danger';
	}
?>
	<tr id="row_<?php echo $i; ?>" class="<?php echo $cls; ?> trclass" >
		<td>
			<?php echo $i; ?>.
			<input type="hidden" name="saledetailid" id="saledetailid" value="<?php $isdd->sade_saledetailid; ?>"/>
			<input type="hidden" name="salemasterid" id="salemasterid" value="<?php $isdd->sade_salemasterid; ?>"/>
			<input type="hidden" name="mattransdetailid" id="mattransdetailid" value="<?php $isdd->sade_mattransdetailid; ?>"/>
			<input type="hidden" name="reqdetailid" id="reqdetailid" value="<?php $isdd->sade_reqdetailid; ?>"/>
			<input type="hidden" name="sno" id="sno" value="<?php $isdd->sade_sno; ?>"/>

		</td>
		<td>
			<?php echo $isdd->itli_itemcode ?>
			<input type="hidden" name="itemcode" id="itemcode" value="<?php $isdd->itli_itemcode; ?>"/> 
			<input type="hidden" name="itemsid" id="itemsid" value="<?php $isdd->itli_itemlistid; ?>"/> 
		</td>
		<td><?php echo $req_itemname ?></td>
		<!-- <td><?php echo $isdd->sade_batchno ?></td>
		<td><?php echo $isdd->sade_expdate ?></td> -->
		<td>
			<?php echo $isdd->sade_qty ?>
			<input type="hidden" name="qty" id="qty" value="<?php $isdd->sade_qty; ?>"/> 
		</td>
		<td>
			<?php echo $isdd->sade_unitrate ?>
			<input type="hidden" name="unitrate" id="unitrate" value="<?php $isdd->sade_unitrate; ?>"/> 
		</td>
		<td><?php echo ($isdd->sade_qty)*($isdd->sade_unitrate) ?></td>
		<!-- <td class="trstatus">
			<?php if($cancel_status!='Y')
		{ ?>
			<a href="javascript:void(0)" class="btn btn-sm btn-danger btnConfirm" title='Cancel' data-url='<?php echo base_url('issue_consumption/new_issue/issue_cancel_item') ?>' data-id="<?php echo $isdd->sade_saledetailid; ?>" data-msg='Cancel This Item ?' data-rowid="<?php echo $i; ?>" ><i class="fa fa-remove" ></i> Cancel</a>
	<?php }?>
		</td> -->
	</tr>
<?php
$i++;
endforeach;
endif;
?>


