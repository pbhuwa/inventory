
<div class="clearfix"></div>
<div class="row">
<div class="col-sm-12">
	<div class="white-box mtop_10 pdf-wrapper">
		<div class="jo_form organizationInfo" id="printrpt">
			

<?php $this->load->view('common/v_report_header');?>
		
<br>
				
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
							<th><?php echo $this->lang->line('counter'); ?> </th>
							<th><?php echo $this->lang->line('issue_no'); ?></th>
							<th><?php echo $this->lang->line('issue_date'); ?></th>
							<th><?php echo $this->lang->line('req_no'); ?></th>
							<th><?php echo $this->lang->line('bill_amount'); ?></th>
							<th><?php echo $this->lang->line('issued_by'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php if($purchase){ 
						$sumtotal =0;
						foreach ($purchase as $key => $det) { ?>
						<tr> 
							<td><?php echo $key+1; ?></td>
							<td><?php echo $det->itli_itemcode;?></td>
							<td><?php echo $det->itli_itemname;?></td>
							<td><?php echo $det->trma_transactiondatebs;?></td>
							<!-- <td><?php echo round($det->trde_requiredqty,2);?></td> -->
							<td><?php echo $det->trde_unitprice;?></td>
							<td align="right"><?php echo number_format($det->amount,2);?></td>
							<td><?php echo $det->trma_receivedby;?></td>

							<?php $amnt = ($det->amount); 
							      $sumtotal += $amnt;?>
						</tr>
						<?php } ?>
						<?php } ?>
						<tr class="grand_ttl">
							<td colspan="4"><b><?php echo $this->lang->line('grand_total'); ?> :</b></td>
							<td colspan="2"> <b><?php echo number_format($sumtotal,2);?></b></td>
							<td></td>
						</tr>
					</tbody>
				</table>
		</div>
	</div>
</div>
</div>