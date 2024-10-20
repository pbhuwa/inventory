<style type="text/css">
	.table-header thead tr td {
		padding: 10px 0;
	}
	.table-header tbody td {
		padding: 0px 0 28px 0;
	}

	.main-table {
		width: 100%;
		border: 1px solid;
	}
	.main-table tbody tr th {
		border: 1px solid;
		border-top: none;
		border-left: none;
		text-align: center;
	}
	td.empty {
		height: 40vh;
		border: 1px solid;
		border-top: none;
		border-left: none;
	}
	.bottom-table {
		border: 1px solid;
		margin: 40px 0 0 0;
	}
	.bottom-table tr td {
		padding: 15px 7px;
	}
	.table-header tr .thead_td-01 {
		padding-bottom: 28px;
	}
	.main-table th {
		border: 1px solid;
		padding: 4px;
	}
	.main-table tr td {
		border: 1px solid;
		padding: 4px;
	}
</style>
<?php 
			$header['report_no'] = '';
			$header['report_title'] = '';
			$this->load->view('common/v_print_report_header',$header);
		?>

<table class="main" style="width: 100%;">

	<table style="width: 100%;" class="table-header">
		<thead>
			<tr>
				<h1 style="text-align: center; font-weight: 600;">Stores Credit Note </h1>
			</tr>
			<tr>
				<td colspan="15" width="75%" style="margin-top: 15px;">Name of Stores:  <?php echo !empty($store[0]->eqty_equipmenttype)?$store[0]->eqty_equipmenttype:''; ?></td>

				<td colspan="3" style="">Credit Note No:<?php echo !empty($return_master[0]->rema_receiveno)?$return_master[0]->rema_receiveno:''; ?></td>
			</tr>
			<tr>
				<td class="thead_td-01" colspan="15" width="75%">Work Description and Location:<?php echo !empty($return_master[0]->rema_workplace)?$return_master[0]->rema_workplace:''.'/'.!empty($return_master[0]->rema_workdesc)?$return_master[0]->rema_workdesc:''; ?></td>
				<td class="thead_td-01" colspan="3">Date :<?php echo !empty($return_master[0]->rema_returndatebs)?$return_master[0]->rema_returndatebs:''; ?></td>
			</tr>
		</thead>

		<tbody>

			<tr style="" width="100%">
				<td>Supply Section :</td>
			</tr>
		</tbody>
	</table>

	<table class="main-table">
		<thead>
			<tr>
				<th rowspan="2">Folio No</th>
				<th rowspan="2">Qty</th>
				<th rowspan="2">Descriptions of materials</th>
				<th rowspan="2">Rate</th>
				<th colspan="2" style="text-align: center;">Amount</th>
			</tr>

			<tr>
				<th>Rs</th>
				<th>Paisa</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$gtotal=0;
			if($return_details){ 
				foreach($return_details as $key=>$products):
					?>
					<tr>
						<!-- <td class="td_cell" style="text-align: center">
							<?php echo $key+1; ?>
						</td> -->
						<td class="td_cell" style="text-align: center">
							<?php echo $products->itli_itemcode;?>
						</td>
						<td class="td_cell" style="text-align: center">
							<?php $rede_qty=!empty($products->rede_qty)?$products->rede_qty:'';?>
							<?php echo $rede_qty;?>
						</td>
						<td class="td_cell" style="text-align: center">
							<?php
							if(ITEM_DISPLAY_TYPE=='NP'){
								echo !empty($products->itli_itemnamenp)?$products->itli_itemnamenp:$products->itli_itemname;
							}else{ 
								echo !empty($products->itli_itemname)?$products->itli_itemname:'';
							}

							?>
						</td>
						
						<td class="td_cell" style="text-align: center">
							<?php $rede_qty=!empty($products->rede_qty)?$products->rede_qty:'';?>
							<?php echo $rede_qty;?>
						</td>
						

						<td class="td_cell" style="text-align: center">
							<?php $rede_unitprice=!empty($products->rede_unitprice)?$products->rede_unitprice:'';?> 
							<?php echo $rede_unitprice;?> 
						</td>


	                    <td class="td_cell" style="text-align: center">
	                    	<?php $total=!empty($products->rede_total)?$products->rede_total:'';?>
	                    	<?php echo $total;?>
	                    </td>


	                </tr>
	                <?php 
	                $gtotal+=$total; 
	            endforeach;
	           }
	        ?>
	        <?php

	        $row_count = is_array($products)?count($products):0;

	        if($row_count < 12):
	        	?>
	        	<tr>
	        		<td class="empty"></td>
	        		<td class="empty"></td>
	        		<td class="empty"></td>
	        		<td class="empty"></td>
	        		<td class="empty"></td>
	        		<td class="empty"></td>
	        	</tr>
	        <?php endif ;

	        ?>
	    </tbody>


	    <tr>
	    	<th colspan="4" style="text-align: right; border-right: 1px solid">Total</th>
	    	<th colspan="2" style="border-bottom: 1px solid; border-right: 1px solid"><?php echo $gtotal; ?></th>
	    </tr>

	</table>


	<table width="100%" class="bottom-table">
		<tr>
			<td style="width: 30%; border-bottom: 1px solid; border-right: 1px solid;">Materials Returned By:<?php// echo !empty($user_signature)?$user_signature:'' ?></td>
			<td style="border-bottom: 1px solid;">Returned Accepted By:<?php //echo !empty($approver_signature)?$approver_signature:'' ?></td>
		</tr>

		<tr>
			<td style="width: 30%;  border-right: 1px solid;"></td>
			<td>Ledger evaluated by:</td>
		</tr>
	</table>

	
</table>