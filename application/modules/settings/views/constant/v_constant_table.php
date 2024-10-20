
<table class="table table-striped dataTable" id="Dtable" width="100%">
	<thead>
		<tr>
			<th width="5%"><?php echo $this->lang->line('sn'); ?></th>
			<th width="20%"><?php echo $this->lang->line('display_text'); ?></th>
			<th width="25%"><?php echo $this->lang->line('name'); ?></th>
			<th width="20%"><?php echo $this->lang->line('value'); ?></th>
			<th width="15%"><?php echo $this->lang->line('description'); ?></th>
			<th width="10%"><?php echo $this->lang->line('status'); ?></th>
			<th width="5%"><?php echo $this->lang->line('action'); ?></th>
          
            
		</tr>
	</thead>
	<tbody>	
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
				<td><a href="javascript:void(0)" data-id="<?php echo $con->cons_id;?>" data-displaydiv="editConstant" data-viewurl="<?php echo base_url('settings/constant/constant_popup'); ?>" class="view btn-primary btn-xxs" data-heading="Edit Constant"><i class="fa fa-edit" aria-hidden="true"></i></a></td>

			</tr>
			<?php } } ?>
	</tbody>
</table>

