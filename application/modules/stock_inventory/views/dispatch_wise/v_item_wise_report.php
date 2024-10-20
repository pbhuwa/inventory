
<div class="clearfix"></div>
<div class="row">
<div class="col-sm-12">
	<div class="white-box mtop_10 pdf-wrapper">
		<div class="jo_form organizationInfo" id="printrpt">
			
			<?php $this->load->view('common/v_report_header');?>
			

		        <style>
					.dbl_table { width:80%; margin:0 auto; font-size:12px; }
					.dbl_table, .dbl_table thead tr th, .dbl_table tr td { border:1px solid #000; border-collapse: collapse;padding: 3px;}
					.under_table { width:100%; font-size: 12px;  }
					.under_table tr td { border:0; width:33.33333333%; }
					.under_table tr td label { font-weight:bold; }
					.dbl_table .grand_ttl td, .dbl_table .ttl_row td { text-align:right; border:none; border-bottom:1px solid #000; }
					.dbl_table td b { display:block; }

				</style>
				<table class="dbl_table">
					<thead>
						<tr>
							<th><?php echo $this->lang->line('sn'); ?></th>
							<th><?php echo $this->lang->line('code'); ?> </th>
							<th><?php echo $this->lang->line('name'); ?></th>
							<th><?php echo $this->lang->line('remarks'); ?></th>
							<th><?php echo $this->lang->line('req_qty'); ?></th>
							<th><?php echo $this->lang->line('unit'); ?></th>
							<th><?php echo $this->lang->line('rate'); ?></th>
							<th><?php echo $this->lang->line('amount'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php if($items){ 
							$grandtotal =0;
							foreach ($items as $key => $value) { ?>
						<tr>
							<td colspan="8">
								<table class="under_table">
									<tr>
										<td>
											<label><?php echo $this->lang->line('issue_no'); ?> :</label><?php echo $value->issueno;?>
										</td>
										<td>
											<label><?php echo $this->lang->line('req_no'); ?> :</label> <?php echo $value->requisitionno;?>
										</td>
										<td>
											<label><?php echo $this->lang->line('from_counter'); ?> :</label>
											<?php 
											if(!empty($equipmenttype[0]->eqty_equipmenttype))
											{
												echo $equipmenttype[0]->eqty_equipmenttype;
											}else{
												echo " | ".$this->lang->line('general_store')." | ".$this->lang->line('medical_store');
											} ?>
										</td>
									</tr>
									<tr>
										<td>
											<label><?php echo $this->lang->line('received_date'); ?> :</label> 
										</td>
										<td>
											<?php echo $value->trma_receiveddatebs;?>
										</td>
										<td>
											<label><?php echo $this->lang->line('received_by'); ?> :</label> <?php echo $value->trma_receivedby;?>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<?php 
						$details = $this->receive_analysis_mdl->get_item_wise_search(array('mt.trma_issueno'=>$value->issueno));

						// echo "<pre>";
						// echo "Hello";
						// print_r($details);
						// die();
						$sumtotal =0;
						if(!empty($details)):
						foreach ($details as $key => $det) { ?>
						<tr> 
				<!-- 			[trma_issueno] => 2
					            [requisitionno] => 704
					            [trma_receiveddatebs] => 2074/03/23
					            [eqty_equipmenttype] => General Store
					            [itli_itemname] => ECG CHART PAPER
					            [itli_itemcode] => SUR0055
					            [trde_requiredqty] => 10.00
					            [trde_unitprice] => 2825
					            [batchno] => 1
            	[trma_receivedby] => SUDEEP -->
							<td><?php echo $key+1; ?></td>
							<td><?php echo $det->itli_itemcode;?></td>
							<td><?php echo $det->itli_itemname;?></td>
							<td><?php echo $det->trma_issueno;?></td>
							<td><?php echo round($det->trde_requiredqty,2);?></td>
							<td><?php echo $det->trde_unitprice;?>pcs</td>
							<td><?php echo $det->trde_unitprice;?></td>
							<td align="right"><?php echo number_format($det->trde_requiredqty * $det->trde_unitprice) ;?></td>
							<?php $amnt = ($det->trde_requiredqty * $det->trde_unitprice); 
							      $sumtotal += $amnt;?>
						</tr>
						<?php } endif;  ?>
						<tr class="ttl_row">
							<td colspan="7"><b><?php echo $this->lang->line('total'); ?> : </b></td>
							<td><b><?php echo $sumtotal; ?></b></td>
						</tr>
						<?php $grandtotal += $sumtotal; } ?>
						<tr class="grand_ttl">
							<td colspan="6"><b><?php echo $this->lang->line('grand_total'); ?> :</b></td>
							<td colspan="2"> <b><?php echo $grandtotal;?></b></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
		</div>
	</div>
</div>
</div>