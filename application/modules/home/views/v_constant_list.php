<div class="white-box chart-box">
    <div class="row">
        <div class="pad-5">
        <div class="col-lg-12 col-sx-12">
            <h3 class="box-title">Constant List</h3>
  		<table class="table table-striped dataTable" width="100%">
					<thead>
						<tr>
							<th width="5%"><?php echo $this->lang->line('sn'); ?></th>
							<th width="20%"><?php echo $this->lang->line('display_text'); ?></th>

							<th width="20%"><?php echo $this->lang->line('name'); ?></th>
							<th width="20%"><?php echo $this->lang->line('value'); ?></th>
							<th width="25%"><?php echo $this->lang->line('description'); ?></th>
							<th width="10%"><?php echo $this->lang->line('status'); ?></th>
		                  
		                    
						</tr>
					</thead>
					<tbody>	<!-- <a href="javascript:void(0)" data-id="4" data-displaydiv="orderDetails" data-viewurl="http://inventory.molmac.gov.np/issue_consumption/stock_requisition/stock_requisition_views_details" class="view btn-primary btn-xxs" data-heading="Stock Requisition details"><i class="fa fa-eye" aria-hidden="true"></i></a> -->
						<?php
							if(!empty($const)){
								// echo "<pre>"; print_r($const); die;
							foreach ($const as $key => $con) 
							{ ?>

							<tr>
								<td><?php echo $key+1; ?></td>
								<td><?php echo !empty($con->cons_display)?$con->cons_display:''; ?></td>
								<td><?php echo !empty($con->cons_name)?$con->cons_name:''; ?></td>
								<td><?php echo !empty($con->cons_value)?$con->cons_value:''; ?></td>
								<td><?php echo !empty($con->cons_description)?$con->cons_description:''; ?></td>
								<td><?php if($con->cons_isactive=='Y'){echo "Active";}
								else{echo "Inactive";} ?></td>
								

							</tr>
							<?php } } ?>
					</tbody>
			</table>
		</div>
	</div>
   </div>
</div>
