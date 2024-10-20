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
			$all_cat_tamt=0;
			$cat_tamt=0;
			if(!empty($stock_result)):
				// $this->stock_report_mdl->stock_generate_by_date('generate_table',false);
				foreach ($stock_result as $kcat => $cat):
			?>
			<?php 
			$current_stock = $this->stock_report_mdl->stock_report_current($cat->eqca_equipmentcategoryid);
			// $current_stock = $this->stock_report_mdl->stock_generate_by_date('get_stock_data',$cat->eqca_equipmentcategoryid);
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
            	<td align="right"><?php echo sprintf('%g',$curstk->balanceqty); ?></td>
            	<td align="right"><?php echo sprintf('%0.2f', $curstk->trde_unitprice); ?></td>
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