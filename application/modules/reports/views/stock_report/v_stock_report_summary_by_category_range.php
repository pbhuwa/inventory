 <style>
	.table>tbody>tr>td, .table>tbody>tr>th {
    vertical-align: middle !important;
    white-space: normal !important; 
}
</style>
<div class="white-box pad-5 mtop_10 pdf-wrapper ">
    <div class="jo_form organizationInfo" id="printrpt">
        <?php $this->load->view('common/v_report_header');?>
 <div class="table-responsive">
           		<?php 
           		// echo "<pre>";
           		// print_r($stock_result);
           		// die();
			$all_cat_tamt=0;
			$cat_tamt=0;
			if(!empty($stock_result)):
				foreach ($stock_result as $kcat => $cat):

			?>

			<?php 

			$current_stock = $this->stock_report_mdl->stock_report_data_range_detail(true,$cat->catid);
			// echo $this->db->last_query();
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

					<th width="25%">Items Name</th>
					<th width="20%">Unit</th>

					<th width="10%">Qty</th>

					<th width="15%">Rate</th>

					<th width="20%" align="right">Amount</th>

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
            	<td><?php echo $curstk->unit_unitname; ?></td>

            	<td align="right"><?php echo $curstk->balanceqtys; ?></td>

            	<td align="right"><?php if($curstk->balanceqty>0) $unit_rate=$curstk->balanceamt/$curstk->balanceqty; echo sprintf('%0.2f', $unit_rate); ?></td>

            	<td align="right"><?php echo sprintf('%0.2f',$curstk->balanceamt); ?></td>

            </tr>

            <?php

            $i++;

            $cat_tamt +=$curstk->balanceamt;

            endforeach;

             ?>

             <tr>

             	<td colspan="6" align="right"><strong>Total</strong></td>

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

				<th colspan="6" align="right"><strong><?php echo $this->lang->line('grand_total'); ?>:</strong></th>

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

	



	
        </div>
    </div>
</div>
