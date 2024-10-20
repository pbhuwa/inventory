<?php 

if(!empty($return_detail)):
	$i=1;

foreach ($return_detail as $kid => $isdd):

if(ITEM_DISPLAY_TYPE=='NP'){
                	$req_itemname = !empty($isdd->itli_itemnamenp)?$isdd->itli_itemnamenp:$isdd->itli_itemname;
                }else{ 
                    $req_itemname = !empty($isdd->itli_itemname)?$isdd->itli_itemname:'';
                }
	
$cls='';
$cancel_status=$isdd->rede_iscancel;
	if($cancel_status=='Y')
	{
		$cls='text-danger';
	}
?>
<tr id="row_<?php echo $i; ?>" class="<?php echo $cls; ?> trclass" >
	<td><?php echo $i; ?>.</td>
	<td><?php echo $isdd->itli_itemcode ?></td>
	<td><?php echo $req_itemname ?></td>
	<td><?php echo ""; ?></td>
	<td><?php echo (DEFAULT_DATEPICKER == 'NP')?$isdd->rede_expdatebs:$isdd->rede_expdatead; ?></td>
	<td><?php echo $isdd->rede_qty ?></td>
	<td><?php echo $isdd->rede_unitprice ?></td>
	<td><?php echo ($isdd->rede_qty)*($isdd->rede_unitprice) ?></td>
	<td></td>

</tr>
<?php
$i++;
endforeach;
endif;
?>


