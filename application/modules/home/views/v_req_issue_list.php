<style type="text/css">
	.dropdown-table tbody tr{
		cursor: pointer;
	}
	.data_detail table tr th,
	.data_detail table tr td{
		font-size: 12px;
	}
	.data_detail thead tr{
		background: #f5f5f5 !important;

	}
	.data_detail 
	{
		border: 1px solid #bcb3b3;
	}
</style>
<?php $pmcat=$this->input->post('pmcat'); 

?>
 <ul class="nav nav-pills">
    <li <?php if($pmcat=='req') echo "class='active'"; ?>><a data-toggle="pill" href="#req_list"><?php echo $this->lang->line('requisition'); ?></a></li>
    <li <?php if($pmcat=='issue') echo "class='active'"; ?>><a data-toggle="pill" href="#issue_list"><?php echo $this->lang->line('issue'); ?></a></li>
    
</ul>
  
<div class="tab-content">
    <div id="req_list" class="tab-pane fade in <?php if($pmcat=='req') echo 'active'; ?>">
        <div class="table-responsive">
        	<table class="dropdown-table table table-striped dataTable" width="100%">
					<thead>
						<tr>
							<th width="5%"><?php echo $this->lang->line('sn'); ?></th>
		                    
		                    <th width="5%"><?php echo $this->lang->line('req_no'); ?></th>
		                    <th width="8%"><?php echo $this->lang->line('from'); ?></th>
		                    <th width="8%"><?php echo $this->lang->line('store'); ?></th>
		                    <th width="8%"><?php echo $this->lang->line('username'); ?></th>
		                    <th width="5%"><?php echo $this->lang->line('is_issue'); ?></th>
		                    <th width="8%"><?php echo $this->lang->line('req_by'); ?></th>
		                    <th width="8%"><?php echo $this->lang->line('approved_by'); ?></th>
		                    <th width="8%"><?php echo $this->lang->line('manual_no'); ?></th>
		                   	<th width="7%"><?php echo $this->lang->line('req_date_ad'); ?></th>
		                    <th width="7%"><?php echo $this->lang->line('req_date_bs'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
							if(!empty($requisition)){
								// echo "<pre>"; print_r($requisition); die;
							foreach ($requisition as $key => $req) 
							{ ?>

							<tr>

								<td><?php echo $key+1; ?></td>
								<td><?php echo !empty($req->rema_reqno)?$req->rema_reqno:''; ?></td>
								<td><?php echo !empty($req->dept_depname)?$req->dept_depname:''; ?></td>
								<td><?php echo !empty($req->eqty_equipmenttype)?$req->eqty_equipmenttype:''; ?></td>
								<td><?php echo !empty($req->rema_username)?$req->rema_username:''; ?></td>
								<td><?php echo !empty($req->rema_isdep)?$req->rema_isdep:''; ?></td>
								<td><?php echo !empty($req->rema_reqby)?$req->rema_reqby:''; ?></td>
								<td><?php echo !empty($req->rema_approvedby)?$req->rema_approvedby:''; ?></td>
								<td><?php echo !empty($req->rema_manualno)?$req->rema_manualno:''; ?></td>
								<td><?php echo !empty($req->rema_reqdatebs)?$req->rema_reqdatebs:''; ?></td>
								<td><?php echo !empty($req->rema_reqdatead)?$req->rema_reqdatead:''; ?></td>

							</tr>
							
							<tr style="display: none;">
								<td colspan="11">
									 <div class="data_detail">
						        	<table width="100%">
						        		 <thead>
						        		 	<tr>
												<td width="5%"><?php echo $this->lang->line('sn'); ?></td>
						        		 		<td width="7%"><?php echo $this->lang->line('item_code'); ?></td>
							                    <td width="15%"><?php echo $this->lang->line('item_name'); ?></td>
							                    <td width="15%"><?php echo $this->lang->line('item_name_np'); ?></td>
							        		 	<td width="7%"><?php echo $this->lang->line('qty'); ?></td>
							                    <td width="15%"><?php echo $this->lang->line('rem_qty'); ?></td>
							                    <td width="15%"><?php echo $this->lang->line('remarks'); ?></td>
						        		 	</tr>
						        		 	
						        		 </thead>
						        		 <tbody>
						        		 	<?php $req_list=$this->home_mdl->get_req_iss_detail(false,$req->rema_reqno); 
						        				//echo "<pre>"; print_r($req_list); 
							        			foreach ($req_list as $key => $list) {?>
						        		 	<tr>
												<td><?php echo $key+1; ?></td>
												<td><?php echo !empty($list->itli_itemcode)?$list->itli_itemcode:''; ?></td>
							        			<td><?php echo !empty($list->itli_itemname)?$list->itli_itemname:''; ?></td>
							        			<td><?php echo !empty($list->itli_itemnamenp)?$list->itli_itemnamenp:''; ?></td>
							        			<td><?php echo !empty($list->rede_qty)?$list->rede_qty:''; ?></td>
							        			<td><?php echo !empty($list->rede_remqty)?$list->rede_remqty:''; ?></td>
							        			<td><?php echo !empty($list->rede_remarks)?$list->rede_remarks:''; ?></td>
							        		</tr>
						        		 	<?php } ?>
						        		 </tbody>
						        		

        	</table>
        </div>
								</td>
							</tr>
							<?php } } ?>
					</tbody>
			</table>
        </div>
       
    </div>
    <div id="issue_list" class="tab-pane fade <?php if($pmcat=='issue') echo 'active in';?>">
        <div class="table-responsive">
        	<table class="dropdown-table table table-striped dataTable" width="100%">
					<thead>
						<tr>
							<th width="5%"><?php echo $this->lang->line('sn'); ?></th>
							<th width="10%"><?php echo $this->lang->line('issue_no'); ?></th>
							<th width="5%"><?php echo $this->lang->line('requisition_no'); ?></th>
							<th width="15%"><?php echo $this->lang->line('department'); ?></th>
							<th width="20%"><?php echo $this->lang->line('total_amount'); ?></th>
							<th width="20%"><?php echo $this->lang->line('issued_by'); ?></th>
							<th width="20%"><?php echo $this->lang->line('received_by'); ?></th>
							<th width="20%"><?php echo $this->lang->line('bill_no'); ?></th>
							<th width="20%"><?php echo $this->lang->line('issue_time'); ?></th>
							<th width="15%"><?php echo $this->lang->line('issue_date'); ?>(B.S.)</th>
							<th width="15%"><?php echo $this->lang->line('issue_date'); ?>(A.D.)</th>
							
						</tr>
					</thead>
					<tbody>
						<?php
							if(!empty($issue)){
								// echo "<pre>"; print_r($issue); die;
							foreach ($issue as $key => $iss) 
							{ ?>

							<tr>
								<td><?php echo $key+1; ?></td>
								<td><?php echo !empty($iss->sama_invoiceno)?$iss->sama_invoiceno:''; ?></td>
								<td><?php echo !empty($iss->sama_requisitionno)?$iss->sama_requisitionno:''; ?></td>
								<td><?php echo !empty($iss->sama_depname)?$iss->sama_depname:''; ?></td>
								<td><?php echo !empty($iss->sama_totalamount)?$iss->sama_totalamount:''; ?></td>
								<td><?php echo !empty($iss->sama_username)?$iss->sama_username:''; ?></td>
								<td><?php echo !empty($iss->sama_receivedby)?$iss->sama_receivedby:''; ?></td>
								<td><?php echo !empty($iss->sama_billno)?$iss->sama_billno:''; ?></td>
								<td><?php echo !empty($iss->sama_billtime)?$iss->sama_billtime:''; ?></td>
								<td><?php echo !empty($iss->sama_billdatebs)?$iss->sama_billdatebs:''; ?></td>
								<td><?php echo !empty($iss->sama_billdatead)?$iss->sama_billdatead:''; ?></td>
								
								
							</tr>
							
							<tr style="display: none;">
								<td colspan="11">
									 <div class="data_detail">
						        	<table width="100%">
						        		 <thead>
						        		 	<tr>
												<td width="5%"><?php echo $this->lang->line('sn'); ?></td>
												<td width="7%"><?php echo $this->lang->line('item_code'); ?></td>
							                    <td width="15%"><?php echo $this->lang->line('item_name'); ?></td>
							                    <td width="15%"><?php echo $this->lang->line('item_name_np'); ?></td>
							        		 	<td width="7%"><?php echo $this->lang->line('qty'); ?></td>
							        		 	<td width="7%"><?php echo $this->lang->line('rate'); ?></td>
							        		 	<td width="7%"><?php echo $this->lang->line('amount'); ?></td>
							        		 	
						        		 	</tr>
						        		 	
						        		 </thead>
						        		 <tbody>
						        		 	<?php $iss_list=$this->home_mdl->get_issue_detail(false,$iss->sama_invoiceno); 
						        				//echo "<pre>"; print_r($req_list); 
							        			foreach ($iss_list as $key => $list) {?>
						        		 	<tr>
						        		 		<td><?php echo $key+1; ?></td>
						        		 		<td><?php echo !empty($list->itli_itemcode)?$list->itli_itemcode:''; ?></td>
							        			<td><?php echo !empty($list->itli_itemname)?$list->itli_itemname:''; ?></td>
							        			<td><?php echo !empty($list->itli_itemnamenp)?$list->itli_itemnamenp:''; ?></td>
							        			<td><?php echo !empty($list->sade_qty)?$list->sade_qty:''; ?></td>
							        			<td><?php echo !empty($list->sade_unitrate)?$list->sade_unitrate:''; ?></td>
							        			<td><?php echo $list->sade_qty*$list->sade_unitrate; ?></td>
							        		</tr>
						        		 	<?php } ?>
						        		 </tbody>
						        		

						        	</table>
						        </div>
								</td>
							</tr>
							
							<?php } } ?>
					</tbody>
			</table>
        </div>
    </div>
</div>

<script type="text/javascript">
	$( document ).ready(function() {
    	$(".dropdown-table tbody tr").click(function(){

    		$(this).next(".dropdown-table tbody tr").slideToggle("data_detail");
    	});
	});
</script>