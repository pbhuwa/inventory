
<div class="clearfix"></div>
<div class="row">
<div class="col-sm-12">
	<div class="white-box mtop_10 pdf-wrapper">
		<div class="jo_form organizationInfo" id="printrpt">
			
		<?php $this->load->view('common/v_report_header');?>

				<table class="table_jo_header purchaseInfo">

					<tr>
						<td class="text-center">
							<h4>
								<u>
									<?php echo $this->lang->line('stock_aging'); ?>
									<?php 
									if(!empty($equipmenttype[0]->eqty_equipmenttype))
									{
										echo $equipmenttype[0]->eqty_equipmenttype;
									}else{
										echo " | ".$this->lang->line('general_store')." | ".$this->lang->line('medical_store');
									}
									?>
								</u>
							</h4>
						</td>
					</tr>
				</table>
				
		        <style>
					.alt_table {  border-collapse:collapse; border:1px solid #000; margin: 0 auto;}
					.alt_table thead tr th, .alt_table tbody tr td { border:1px solid #000; padding:2px 5px; font-size:13px; }
					.alt_table tbody tr td { padding:5px; font-size:12px; }
					.alt_table tbody tr.alter td { border:0; text-align:center; }
					.alt_table tbody tr td.noboder { border-right:0; text-align:center; }
					.alt_table tbody tr td.noboder+td{ border-left: 0px; }


				</style>
				<table class="alt_table">
					<thead>
						<tr>
							<th><?php echo $this->lang->line('sn'); ?></th>
							<th style="text-align: center"><?php echo $this->lang->line('name'); ?> </th>
							<th><?php echo $this->lang->line('stock_quantity'); ?></th>
							<th><?php echo $this->lang->line('stock_value'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php
					if(!empty($purchase)):
					$totalstockvalue = $totalstoc = 0;
					foreach($purchase as $key=>$iue):
					?>
						<tr>
							<td><?php echo $key+1; ?></td>
							<td><?php echo $iue->itli_itemname; ?></td>
							<td align="center"><?php echo round($iue->stock,2);?></td>
							<td align="right"><?php echo number_format($iue->stockvalue,2);?></td>
							<?php
							$totalstoc += $iue->stock;
							$totalstockvalue += $iue->stockvalue;
							 ?>
						</tr>
						
					<?php
						endforeach;
						endif;
					?>
						<tr class="alter">
							<td></td>
							<td><b><?php echo $this->lang->line('total'); ?> : </b></td>
							<td><b><?php echo round($totalstoc,2);?></b></td>
							<td align="right"><b><?php echo number_format($totalstockvalue,2);?></b></td>
						</tr>
					</tbody>
				</table>
		    <?php //} ?>
		</div>
	</div>
</div>
</div>