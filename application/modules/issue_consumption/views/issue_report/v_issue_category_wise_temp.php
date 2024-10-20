<div class="white-box pad-5 mtop_10 pdf-wrapper">
	<div class="jo_form organizationInfo" id="printrpt">
	    <?php  $this->load->view('common/v_report_header'); ?>
	     
			<?php if(!empty($issue_report)){  //print_r($issue_report);die;?>
			
			<h4 class="text-center"><?php echo $this->lang->line('expandable'); ?></h4>
			<table class="alt_table" width="100%">
				<thead>
					<tr>
						<th width="5%"><?php echo $this->lang->line('sn'); ?></th>
						<th width="10%"><?php echo $this->lang->line('department_code'); ?></th>
						<th width="20%"><?php echo $this->lang->line('department_name'); ?> </th>
						<th width="10%"><?php echo $this->lang->line('issue_value'); ?></th> 
						<th width="10%"><?php echo $this->lang->line('return_value'); ?></th>
						<th width="10%"><?php echo $this->lang->line('net_value'); ?></th> 
					</tr>
				</thead>
				<tbody>
					
				<?php
				  $sum2 = 0;   $sum3 = 0;$sum4 = 0;
				foreach($issue_report as $key=>$iue): 
				?>
				<tr>
					<td><?php echo $key+1;?></td>
					<td><?php echo $iue->dept_depcode;?></td>
					<td><?php echo $iue->dept_depname; ?></td>
					<td align="right"><?php if(is_numeric($iue->issueval)){ echo number_format($iue->issueval,2); } ?></td>
					<td align="right"><?php if(is_numeric($iue->returnvalue)){  echo number_format($iue->returnvalue,2); } ?></td>
					<td align="right"><?php if(is_numeric($iue->netvalue)) { echo number_format($iue->netvalue,2); } ?></td>
					<?php 
					if(is_numeric($iue->issueval)) {
					$sum3 += !empty($iue->issueval)?$iue->issueval:0;
					}
					?>
					<?php
					if(is_numeric($iue->returnvalue)) {
					 $sum4 += !empty($iue->returnvalue)?$iue->returnvalue:0;
					}
					?>
					<?php 
					if(is_numeric($iue->returnvalue)) {
					$sum2 += !empty($iue->netvalue)?$iue->netvalue:0;
					}
					?>
				</tr>
				<?php endforeach; ?>
				<tr>
					<td colspan="3"  style="font-size:14px;" class="text-right"><b><?php echo $this->lang->line('grand_total'); ?> :</b>   </td>
					<td class="text-right"  style="font-size:14px; text-align: right;" ><b><?php  echo number_format($sum3,2);?></b></td>
					<td class="text-right"  style="font-size:14px; text-align: right;" ><b><?php  echo number_format($sum4,2);?></b></td>
					<td class="text-right"  style="font-size:14px; text-align: right;" ><b><?php  echo number_format($sum2,2);?></b></td>
				</tr>
				</tbody>
			</table>
		 <?php } 
		 	if($nonexp_issue_report){
		 ?><br><br>
		    <h4 class="text-center"><?php echo $this->lang->line('non_expandable'); ?></h4>
			<table class="alt_table">
				<thead>
					<tr>
						<th width="5%"><?php echo $this->lang->line('sn'); ?></th>
						<th width="10%"><?php echo $this->lang->line('department_code'); ?></th>
						<th width="20%"><?php echo $this->lang->line('department_name'); ?></th>
						<th width="10%"><?php echo $this->lang->line('issue_value'); ?> </th> 
						<th width="10%"><?php echo $this->lang->line('return_value'); ?> </th>
						<th width="10%"><?php echo $this->lang->line('net_value'); ?> </th> 
					</tr>
				</thead>
				<tbody>
					
				<?php
				  $sum2 =0;   $sum3 =0;$sum4 =0;
				foreach($nonexp_issue_report as $key=>$iue): 
				?>
				
				
				<tr>
					<td><?php echo $key+1;?></td>
					<td><?php echo $iue->dept_depcode;?></td>
					<td><?php echo $iue->dept_depname; ?></td>
					<td align="right"><?php echo number_format($iue->issueval,2);?></td>
					<td align="right"><?php echo number_format($iue->returnvalue,2); ?></td>
					<td align="right"><?php echo number_format($iue->netvalue,2);?></td>
					<?php 
				if(is_numeric($iue->issueval)) {
					$sum3+= $iue->issueval;
				}
				?>
				<?php 
				if(is_numeric($iue->returnvalue)) {
					$sum4+= $iue->returnvalue;
				}
				?>
				<?php 
				if(is_numeric($iue->netvalue)) {
					$sum2+= $iue->netvalue;
				}
					?>
				</tr>
				<?php endforeach; ?>
				<tr>
					<td colspan="3"  style="font-size:14px;" class="text-right"><b><?php echo $this->lang->line('grand_total'); ?> :</b>   </td>
					<td class="text-right"  style="font-size:14px; text-align: right;" ><b><?php  echo number_format($sum3,2);?></b></td>
					<td class="text-right"  style="font-size:14px; text-align: right;" ><b><?php  echo number_format($sum4,2);?></b></td>
					<td class="text-right"  style="font-size:14px; text-align: right;" ><b><?php  echo number_format($sum2,2);?></b></td>
				</tr>
				</tbody>
			</table>
			<?php  }  ?>
	</div>
</div>