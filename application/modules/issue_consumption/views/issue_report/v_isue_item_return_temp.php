

	<div class="white-box pad-5 mtop_10 pdf-wrapper">
	<div class="jo_form organizationInfo" id="printrpt">
	 <?php  $this->load->view('common/v_report_header'); ?> 
				<?php 
					if(!empty($issue_return)){ ?> 
				<table class="alt_table" width="100%">
					<thead>
						<tr>
							<th width="5%"><?php echo $this->lang->line('sn'); ?></th>
							<th width="10%"><?php echo $this->lang->line('item_code'); ?></th>
							<th width="20%"><?php echo $this->lang->line('item_name'); ?></th>
							<th width="10%"><?php echo $this->lang->line('return_date'); ?></th> 
							<th width="10%"><?php echo $this->lang->line('return_qty'); ?> </th>
							<th width="15%"><?php echo $this->lang->line('return_from'); ?> </th>
							<th width="10%"><?php echo $this->lang->line('batch_no'); ?>  </th>
							<th width="15%"><?php echo $this->lang->line('user'); ?> </th> 
						</tr>
					</thead>
					<tbody>
					<?php
					foreach($issue_return as $key=>$iue): 
					?>
					<tr>
						<td><?php echo $key+1;?></td>
						<td><?php echo $iue->itli_itemcode; ?></td>
						<td><?php echo $iue->itli_itemname; ?></td>
						<td><?php echo $iue->rema_returndatebs; ?></td>
						<td><?php echo $iue->rede_qty; ?></td>
						<td><?php echo $iue->dept_depname; ?></td>
						<td><?php echo $iue->rede_controlno; ?></td>
						<td><?php echo $iue->rema_username; ?></td>
					</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
				<?php } ?>
		</div>
	</div>
</div>