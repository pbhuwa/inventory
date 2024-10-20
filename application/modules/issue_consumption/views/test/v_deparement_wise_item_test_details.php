<div class="white-box pad-5 mtop_10 pdf-wrapper">
	<div class="jo_form organizationInfo" id="printrpt">
		<?php  $this->load->view('common/v_report_header',$this->data); ?> 
		<?php if(!empty($dept_data)): 
			
			foreach ($dept_data as $ki => $dept): ?>
				<br>
				<table class="jo_tbl_head">
					<tr>
						<td>
							<strong><?php echo $dept->apde_departmentname; ?></strong>
						</td>
					</tr>
				</table>

				<?php

				$con1=array();
				$con2=array();

				if(!empty($testitem_name )){
					$con1=array('tv.tema_testnameid' =>$testitem_name);
				}
				

				$details_data=$this->test_mdl->get_all_department_wise_item(array('tv.tema_invdepid'=>$dept->apde_invdepid,'tv.telo_datadatebs >='=>$frmDate, 'tv.telo_datadatebs <='=>$toDate),false,false,false,'ASC',false,$con1,false); 
		            // echo $this->db->last_query(); die;
				if(!empty($details_data)):
					foreach ($details_data as $ki => $data):

				if(!empty($invitem_name)){
					$con2=array('tv.tema_invitemid' =>$invitem_name);
					
				    }
				?>


				   <?php
						$details_data_all=$this->test_mdl->get_all_department_wise_item_details(array('tv.telo_itemid'=>$data->testid,'tv.tema_invdepid'=>$data->tema_invdepid,'tv.telo_datadatebs >='=>$frmDate, 'tv.telo_datadatebs <='=>$toDate),false,false,false,'ASC',false,$con1,$con2);
						if(!empty($details_data_all)): 
							?>
							<br>
							<table class="jo_tbl_head">
								<tr>
									<td>
										<strong><?php echo $data->telo_testname; ?></strong>
									</td>
								</tr>
							</table>


							<table class="alt_table">
								<thead>
									<tr>
										<th> <?php echo $this->lang->line('sn'); ?>. </th>
										<th> <?php echo $this->lang->line('particular'); ?> </th>
										<th>Unit</th>
										<th>Amount</th>
										<th>Min Test Count </th>
										<th> Max Test Count </th>
										
									</tr>
								</thead>
								<tbody>
									<?php 
									$i=1;
									$gtotal=0;

									foreach ($details_data_all as $keys => $mapitem ) :
										?>
										<tr>
											<td><?php echo $i;?></td>
											<td >  
												<?php echo !empty($mapitem->itli_itemname)?$mapitem->itli_itemname:''; ?>
											</td>
											<td > 
												<?php echo !empty($mapitem->tema_unit)?$mapitem->tema_unit:''; ?>
											</td>
											<td > 
												<?php 
												$a=$data->cnt;
												$b=$mapitem->tema_perml;
												 echo $b; ?>
											</td>
											<td > 
												<?php  
												$q=$mapitem->tema_mintestcount;
												 echo $q; ?>
											</td>
											<td > 
												<?php    
												
												$y=$mapitem->tema_maxtestcount;
												 echo $y; ?>
												<!-- <?php $total=$q+$y;?> -->
											</td>
											
										</tr>
										<?php
										$i++;
										$gtotal+=$b;
									endforeach;
								endif; endforeach;
								?>
							</tbody>
							<!-- <tfoot>
								<tr>
									<td class="td_cell" colspan="5"> Total</td>

									<td align="right"><?php echo $gtotal; ?></td>
									<td></td>
								</tr>
							</tfoot> -->
						</table>
						<?php 
					endif; endforeach; ?>
				<?php
				   endif; ?>