
</style>
<div class="clearfix"></div>
<div class="row">
<div class="col-sm-12">
	<div class="white-box mtop_10 pdf-wrapper">
		<div class="jo_form organizationInfo" id="printrpt">
			

			<?php $this->load->view('common/v_report_header');?>

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
							<th><?php echo $this->lang->line('counter_code'); ?></th>
							<th><?php echo $this->lang->line('counter_name'); ?></th>
							<th><?php echo $this->lang->line('receive_amount'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php
					if(!empty($purchase)):
					$totalstockvalue = 0;
					foreach($purchase as $key=>$iue):
					?>
						<tr>
							<td><?php echo $key+1; ?></td>
							<td><?php echo $iue->eqty_equipmenttype; ?></td>
							<td><?php echo $iue->eqty_equipmenttype; ?></td>
							<td align="right"><?php echo number_format($iue->stockvalue,2);?></td>
							<?php
							$totalstockvalue += $iue->stockvalue;
							 ?>
						</tr>
						
					<?php
						endforeach;
						endif;
					?>
						<tr class="alter">
							<td></td>
							<td></td>
							<td><b><?php echo $this->lang->line('total'); ?> : </b></td>
							<td style="text-align: right;"><b><?php echo number_format($totalstockvalue,2);?></b></td>
						</tr>
					</tbody>
				</table>
		    <?php //} ?>
		</div>
	</div>
</div>
</div>