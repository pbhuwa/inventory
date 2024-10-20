<div class="white-box pad-5 mtop_10 pdf-wrapper ">

	<div class="jo_form organizationInfo" id="printrpt">

		<?php $this->load->view('common/v_report_header');?>

		<?php // echo ORGANIZATION_NAME; ?>

		<?php if(ORGANIZATION_NAME=='MANMOHAN'): ?>

			<?php 

			$cat_tamt=0;
			$all_cat_tamt=0;
			if(!empty($distinct_cat)):

				foreach ($distinct_cat as $kcat => $cat):

			?>

			<?php 

			$current_stock = $this->current_stock_mdl->get_current_stock_detail_format2($cat->eqca_equipmentcategoryid);

			if(!empty($current_stock)):

			 ?>

			 <strong><?php echo $cat->eqca_category; ?></strong>

			 	<table class="alt_table">

			<thead>

				<tr>

					<th width="5%">S.n</th>
					<th width="15%">Items Name</th>
					<th width="10%">Opening Stock <?php echo $this->input->post('fromdate'); ?></th>
					<th width="10%">Range Stock</th>
					<th width="10%">Closing <?php echo $this->input->post('todate'); ?></th>
					<th width="10%">Current Stock</th>
					<th width="10%">Unit Rate</th>
					<th width="10%"align="right">Amount</th> 

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

            	<td><?php echo $curstk->itli_itemname; ?></td>

            	<td align="right"><?php echo $curstk->trde_opening_qty; ?></td>

            	<td align="right"><?php echo $curstk->trde_range_qty; ?></td>

            	<td align="right"><?php echo $curstk->trde_range_out_qty; ?></td>

            	<td align="right"><?php echo $curstk->trde_curqty; ?></td>

            	<td align="right"><?php echo sprintf('%0.2f', $curstk->trde_unitprice); ?></td>

            	<td align="right"><?php $tamount=$curstk->trde_curqty* $curstk->trde_unitprice;  echo sprintf('%0.2f',$tamount); ?></td> 

            </tr>

            <?php

            $i++;

            $cat_tamt +=$tamount;

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

		<?php else:  ?>

			<?php 
			$all_cat_tamt=0;
			$cat_tamt=0;
			if(!empty($distinct_cat)):

				foreach ($distinct_cat as $kcat => $cat):

			?>

			<?php 

			$current_stock = $this->current_stock_mdl->get_current_stock_detail($cat->eqca_equipmentcategoryid);

			// echo $this->db->last_query();

			// die();

			if(!empty($current_stock)):

			 ?>

			 <strong><?php echo $cat->eqca_category; ?></strong>

			 <table class="alt_table">

			<thead>

				<tr>

					<th width="5%">S.n</th>

					<th width="10%">Items Code</th>

					<th width="25%">Items Name</th>

					<th width="10%">Stock</th>

					<th width="20%">Rate</th>

					<th width="20%"align="right">Amount</th>

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

            	<td align="right">

            		<?php 
            		if (ORGANIZATION_NAME == 'KU') {
            		if($mattypeid == 1){
							echo $curstk->trde_issueqty;
            		}else{
            			echo 0;
            		}	
            		}else{
						echo $curstk->trde_issueqty;
            		}
            		 ?>	
            	</td>

            	<td align="right"><?php echo sprintf('%0.2f', $curstk->trde_unitprice); ?></td>

            	<td align="right"><?php echo sprintf('%0.2f',$curstk->tamount); ?></td>

            </tr>

            <?php

            $i++;

            $cat_tamt +=$curstk->tamount;

            endforeach;

             ?>

             <tr>

             	<td colspan="5" align="right"><strong>Total</strong></td>

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

				<th colspan="5" align="right"><strong><?php echo $this->lang->line('grand_total'); ?></strong></th>

				<th align="right"><strong><?php echo number_format($all_cat_tamt,2);?></strong></th>			

			</tr>

			<tr>

				<th colspan="6">

				<?php echo $this->lang->line('in_words'); ?>:<?php echo $this->general->number_to_word($all_cat_tamt); ?>

				</th>

			</tr>

		</table>

		<?php

		endif;

		 ?>

		<?php endif; ?>

		<br/>

	</div>

	</div>

</div>