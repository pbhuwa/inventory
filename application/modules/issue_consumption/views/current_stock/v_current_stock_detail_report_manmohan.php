<div class="white-box pad-5 mtop_10 pdf-wrapper ">
	<div class="jo_form organizationInfo" id="printrpt">
		
		<?php $this->load->view('common/v_report_header');?>

		<!-- issue list -->
		<?php 
		$cat_tamt=0;
		if(!empty($distinct_cat)):
			$all_cat_tamt=0;
			$this->current_stock_mdl->stock_generate_by_date('generate_table');
			foreach ($distinct_cat as $kcat => $cat):
			?>
			<?php 
			// $current_stock = $this->current_stock_mdl->get_current_stock_detail($cat->eqca_equipmentcategoryid);
			$current_stock = $this->current_stock_mdl->stock_generate_by_date('get_stock_data',$cat->eqca_equipmentcategoryid);
			// echo "<pre>";
			// print_r($current_stock);
			// die();
			if(!empty($current_stock)):
			 ?>
			 <strong><?php echo $cat->eqca_category; ?></strong>
			<table class="alt_table">
			<thead>
				<tr>
					<th width="5%">S.n</th>
					<th width="10%">Items Code</th>
					<th width="15%">Items Name</th>
					<th width="10%">Stock</th>
					<th width="10%">Rate</th>
					<th width="10%">VAT(%)</th>
					<th width="10%"align="right">V.Rate</th>
					<th width="10%">T.Amount</th>
				</tr>
            </thead>
            <tbody>
            <?php
            $i=1;
            $cat_tamt=0;
            foreach ($current_stock as $kcs => $curstk):
            ?>
            <tr>
            	<td><?php echo $i; ?></td>
            	<td><?php echo $curstk->itli_itemcode; ?></td>
            	<td><?php echo $curstk->itli_itemname; ?></td>
            	<td align="right"><?php echo $curstk->trde_issueqty; ?></td>
            	<td align="right"><?php echo $curstk->trde_unitprice; ?></td>
            	<td align="right"><?php $vat=$curstk->recd_vatpc; if($vat>0) echo $vat; ?></td>
            <td align="right"><?php if($vat >0) { $withvatamt =(1+($vat)/100)*$curstk->trde_unitprice;} else{ $withvatamt=$curstk->trde_unitprice; } echo $withvatamt; ?></td>
            	<td align="right"><?php $gtotal=$curstk->trde_issueqty*$withvatamt; echo number_format($gtotal,2); ?></td><!-- <td align="right"><?php echo $curstk->trde_issueqty; ?></td>
            	<td align="right"><?php echo $curstk->trde_unitprice; ?></td>
            	<td align="right"><?php $vat=$curstk->recd_vatpc; if($vat>0) echo $vat; ?></td>
            <td align="right"><?php if($vat >0) { $withvatamt =(1+($vat)/100)*$curstk->trde_unitprice;} else{ $withvatamt=$curstk->trde_unitprice; } echo $withvatamt; ?></td>
            	<td align="right"><?php $gtotal=$curstk->trde_issueqty*$withvatamt; echo number_format($gtotal,2); ?></td> -->
            </tr>
            <?php
            $i++;
            $cat_tamt +=$gtotal;
            endforeach;
             ?>
             <tr>
             	<td colspan="7" align="right"><strong>Total</strong></td>
             	<td align="right"> <strong><?php echo number_format($cat_tamt,2); ?></strong></td>
             </tr>
            	
            </tbody>

		</table>
		<?php
	endif;
		$all_cat_tamt +=$cat_tamt;
			endforeach;
		?>
		<table class="alt_table">
			<tr>
				<th colspan="7" align="right"><strong><?php echo $this->lang->line('grand_total'); ?></strong></th>
				<th align="right"><strong><?php echo number_format($all_cat_tamt,2);?></strong></th>			
			</tr>
			<tr>
				<th colspan="8">
					<?php echo $this->lang->line('in_words'); ?>:<?php echo $this->general->number_to_word($all_cat_tamt); ?>
				</th>
			</tr>
		</table>
		<?php
		endif;
		 ?>
		
		<br/>
		<br/>
		<table class="" style="width: 100%;border-collapse: collapse;margin-top: 70px;">
                <tbody><tr>
                    <td width="33.333333333%" style="text-align: left;white-space: nowrap;">
                         <div style="display: inline-block;text-align: left;border-top: 1px solid black;padding: 2px;">
                         Prepared By<br>
                           <br>
                           
                        </div>
                    </td>
                    <td width="33.333333333%" style="text-align: center;white-space: nowrap;">
                        <div style="display: inline-block;text-align: left;border-top: 1px solid black;padding: 2px;">
                           Checked By<br>
                           <br>
                           
                        </div>
                    </td>
                    <td width="33.333333333%" style="text-align: right;white-space: nowrap;">
                        <div style="display: inline-block;text-align: left;border-top: 1px solid black;padding: 2px;">
                          Approved By<br>
                           <br>
                           
                        </div>
                    </td>
                </tr>
              
            </tbody></table>
	</div>

	</div>

	</div>