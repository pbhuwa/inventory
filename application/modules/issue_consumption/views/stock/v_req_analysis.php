
<div class="clearfix"></div>
<!-- <div class="col-sm-12"> -->
	<div class="white-box pad-5 mtop_10 pdf-wrapper">
		<div class="jo_form organizationInfo" id="printrpt">
			
	
			<?php $this->load->view('common/v_report_header');?>

						       <style>
					.alt_table {  border-collapse:collapse; border:1px solid #000; margin: 0 auto; width:100%; }
					.alt_table.no_border { border-bottom:0; }
					.alt_table thead tr th, .alt_table tbody tr td { border:1px solid #000; padding:2px 5px; font-size:13px; }
					.alt_table tbody tr td { padding:5px; font-size:12px; }
					.alt_table tbody tr.alter td { border:0; text-align:center; }
					.alt_table tbody tr td.noboder { border-right:0; text-align:center; }
					.alt_table tbody tr td.noboder+td{ border-left: 0px; }
					.alt_table.no_border tbody tr td { border:0; }
					.alt_table.no_border tbody tr.bb { border-bottom:1px solid; }


				</style>
				
				<?php if($distinctdep) { ?>
					<?php 
					if(!empty($distinctdep)):
					foreach($distinctdep as $key=>$iue):

						$details = $this->stock_transfer_mdl->req_analysis_report(array('rd.rede_reqmasterid'=>$iue->rema_reqmasterid));
					?>
					<table class="alt_table no_border">
						<tbody>
							<tr class="bb">
								<td colspan="4"> <b><?php echo $iue->dept_depname; ?></b></td>
							</tr>
							<tr >
								<td>Manual No: <label ><?php echo $iue->rema_manualno; ?></label></td>
								<td>Req No: <label ><?php echo $iue->rema_reqno; ?></label></td>
									<td>Req Date :<label ><?php echo $iue->rema_reqdatebs; ?></label></td>
								<td>Department :<label ><?php echo $iue->dept_depname; ?></label></td>
							</tr>
					</tbody>
				</table>
					<table class="alt_table">
						<thead>
								<tr>
									<th><?php echo $this->lang->line('sn'); ?>Sno</th>
									<th><?php echo $this->lang->line('item_code'); ?></th>
									<th><?php echo $this->lang->line('item_name'); ?></th>
									<th><?php echo $this->lang->line('req_no'); ?></th>
									<th><?php echo $this->lang->line('date_bs'); ?></th>
									<th><?php echo $this->lang->line('request_qty'); ?></th>
									<th><?php echo $this->lang->line('rem_qty'); ?></th>
									
								</tr>
							</thead>
							 <?php if($details){
							 	foreach ($details as $key => $value) {  ?>
							<tr>
							 	<td><?php echo $key+1; ?></td>	
							 	<td><?php echo $value->itli_itemcode; ?></td>
							 	<td><?php echo $value->itli_itemname; ?></td>
								<td><?php echo $value->rema_reqno;?></td>
								<td><?php echo $value->rema_reqdatebs;?></td>
								<td><?php echo $value->reqqty;?></td>
								<td><?php echo $value->remqty;?></td>
							</tr>	
							<?php } } ?>
					</table>
					<br>
					<?php
						endforeach;
						endif; ?>
						<!-- <tr class="alter">
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td><b>Total</b></td>
							<td><b><?php echo round($issueqtysum,2);?></b></td>
							<td><b><?php echo round($returnqtysum,2);?></b></td>
							<td><b><?php echo round($issuesum,2);?></b></td>
							<td></td>
							<td></td>
						</tr> -->
					<!-- </tbody>
				</table> -->
				
				<?php } ?>
				
		    <?php //} ?>
		</div>
	</div>
</div>