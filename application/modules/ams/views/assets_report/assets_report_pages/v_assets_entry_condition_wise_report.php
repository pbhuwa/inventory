<? if(!empty($condition_wise_data)) : ?>
<div class="white-box pad-5 mtop_10 pdf-wrapper">
	<div class="jo_form organizationInfo" id="printrpt">
		<?php  $this->load->view('common/v_report_header',$this->data); ?>

    <?php    
			foreach ($condition_wise_data as $ki => $cwd): ?>
      	<?php
        $total_purchase_rate = 0; 

        $cond_array = array('asen_condition'=>$cwd->asco_ascoid);

        if(!empty($this->input->post('department'))){
          $cond_array['asen_depid'] = $this->input->post('department'); 
        } 
        if(!empty($this->input->post('asset_status'))){
          $cond_array['asen_status'] = $this->input->post('asset_status');
        }
        if(!empty($this->input->post('asset_category'))){ 
          $cond_array['asen_assettype'] = $this->input->post('asset_category');
        }
        $ass_details=$this->assets_report_mdl->get_asset_entry_list_data($cond_array);
        
				if(!empty($ass_details)):		  
        ?>
				<br>
				<table class="jo_tbl_head">
					<tr>
						<td>
							<strong><?php echo $cwd->asco_conditionname; ?></strong>
						</td>
					</tr>
				</table> 
 
			

				<table id="" class="format_pdf" width="100%">
        <thead>
        <tr>
            <th width="2%"><?php echo $this->lang->line('sn'); ?></th>
            <th width="10%"><?php echo $this->lang->line('ass_code'); ?></th>
            <th width="10%">Description</th>
            <th width="8%">Make</th>
            <th width="8%">Model</th>
            <th width="8%">Serial No</th>
            <th width="8%">Purchase Date</th>
            <th width="8%">Purchase Rate</th>
            <th width="8%">Depreciation Method</th>
            <th width="8%">Department</th> 
            <th width="8%">Room No</th> 
        </tr>
    </thead>
    <tbody>
        <?php 
          $i=1;
          foreach ($ass_details as $key => $result): 
            $total_purchase_rate += $result->asen_purchaserate;
        ?>
        <tr>
            <td><?php echo $key+1;?></td>
            <td><?php echo $result->asen_assetcode; ?></td>
            <td><?php echo $result->asen_desc; ?></td>
      			<td><?php echo $result->asen_make; ?></td>
      			<td><?php echo $result->asen_modelno; ?></td>
      			<td><?php echo $result->asen_serialno; ?></td> 
      		  <td><?php echo $result->asen_purchasedatebs; ?></td>
          	<td><?php echo $result->asen_purchaserate; ?></td>
      			<td><?php echo $result->depreciation; ?></td>
      			<td><?php echo $result->dept_depname; ?></td>
      			<td><?php echo $result->asen_room; ?></td>
      			
        </tr>
        <?php
        $i++;
        endforeach;
        ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="7">Total:</th>
        <th class="text-right"><?php echo $total_purchase_rate; ?></th>
      </tr>
    </tfoot>
<?php 
endif; 
endforeach; ?>
</table>
<?php endif;?>