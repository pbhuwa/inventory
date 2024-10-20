<div class="white-box pad-5 mtop_10 pdf-wrapper">
    <div class="jo_form organizationInfo" id="printrpt">
        <?php 
        //print_r($pdf_url);die;
        $this->load->view('common/v_report_header');?>
				<?php if(!empty($current_stock)): ?>
					<table class="alt_table">
					<thead>
						<tr>
							<th>Item Code</th>
							<th>Item Name</th>
							<th>Cat </th>
							<th>Sub Cat</th>
							<th>Unit</th>
							<th>At Stock</th>
							<th>Max Limit</th>
							<th>Exp Date</th>
							<th>Batch Number</th>
							<th>Rate</th>
							<th>Amount</th>
							<th>Description</th>
						</tr>
					</thead>
					<tbody>
					<?php
					$sum =0; 
					foreach($current_stock as $iue): //echo"<pre>"; print_r($current_stock);die;
					?>
					<tr>
							<td> <?php echo $iue->itli_itemcode;?></td>
							<td> <?php echo $iue->itli_itemname;?></td>
							<td> <?php echo $iue->trde_expdatebs; ?></td>
							<td> <?php echo $iue->trde_unitprice; ?></td>
							<td> <?php echo $iue->trde_selprice;?></td>
							
							<td> <?php echo $iue->trde_stripqty;?></td>
							<td> <?php echo $iue->trde_expdatebs;?></td>
							<td> <?php echo $iue->batchno;?></td> 
							<td> <?php echo $iue->unit_unitname;?></td> 
							<td class="text-right"> <?php echo number_format($iue->trde_unitprice,2);?></td>
							<td class="text-right"> <?php echo number_format($iue->total,2);?></td>
							<td><?php echo $iue->trde_description;?></td>
							<?php $sum+= $iue->total;?>
						</tr>
					<?php endforeach; ?>
					<tr>
						<td colspan="10"  style="font-size:14px;" class="text-right"><b>Grand Total :</b>   </td>
						<td class="text-right"  style="font-size:14px;" ><b><?php  echo number_format($sum,2);?></b></td>
					</tr>
					</tbody>
				</table>
			<?php endif; ?>
		</div>
	</div>

</div>
</div>
