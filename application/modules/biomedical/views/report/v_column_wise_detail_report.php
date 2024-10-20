	<div class="pad-10">
		<div class="form-group">
			<div class="col-sm-6">
				<label class="dttable_ttl">Department Wise</label>
				<div class="scroll h200">
					<table class="table table-striped dataTable tbl_pdf">
						<thead>
							<tr>
								<th>S.n</th>
								<th>Department Name</th>
								<th>Count</th>
							</tr>
						</thead>
						<tbody>
							<?php if($departmentwise):
							$i=1;
							foreach ($departmentwise as $kd => $dep):
							?>

							<tr>
								<td><?php echo $i ?>.</td>
								<td><?php echo $dep->dept_depname; ?></td>
								<td><?php echo $dep->cnt; ?></td>
							</tr>

							<?php
							$i++;
							endforeach;
							endif;
							?>
						</tbody>					
					</table> 
				</div> 
			</div>
			<div class="col-sm-6">
				<label class="dttable_ttl">Equipment Description Wise</label>
				<div class="scroll h200">
					<table class="table table-striped dataTable tbl_pdf">
						<thead>
							<tr>
								<th>S.n</th>
								<th>Description Name</th>
								<th>Count</th>
							</tr>
						</thead>
						<tbody>
							<?php if($descriptionwise):
							$i=1;
							foreach ($descriptionwise as $kd => $desc):
							?>

							<tr>
								<td><?php echo $i ?>.</td>
								<td><?php echo $desc->eqli_description; ?></td>
								<td><?php echo $desc->cnt; ?></td>
							</tr>

							<?php
							$i++;
							endforeach;
							endif;
							?>
						</tbody>					
					</table>  
				</div>
			</div>

			<div class="col-sm-6">
				<label class="dttable_ttl">Distributor Wise</label>
				<div class="scroll h200">
					<table class="table table-striped dataTable tbl_pdf">
						<thead>
							<tr>
								<th>S.n</th>
								<th>Distributor Name</th>
								<th>Count</th>
							</tr>
						</thead>
						<tbody>
							<?php if($distributor_wise):
							$i=1;
							foreach ($distributor_wise as $kd => $dist):
							?>

							<tr>
								<td><?php echo $i ?>.</td>
								<td><?php echo $dist->dist_distributor; ?></td>
								<td><?php echo $dist->cnt; ?></td>
							</tr>

							<?php
							$i++;
							endforeach;
							endif;
							?>
						</tbody>					
					</table>  
				</div>
			</div>

			<div class="col-sm-6">
				<label class="dttable_ttl">AMC Wise</label>
				<div class="scroll h200">
					<table class="table table-striped dataTable tbl_pdf">
						<thead>
							<tr>
								<th>S.n</th>
								<th>AMC(Y/N)</th>
								<th>Count</th>
							</tr>
						</thead>
						<tbody>
							<?php if($amcwise):
							$i=1;
							foreach ($amcwise as $kd => $amc):
							?>

							<tr>
								<td><?php echo $i ?>.</td>
								<td><?php echo $amc->bmin_amc; ?></td>
								<td><?php echo $amc->cnt; ?></td>
							</tr>

							<?php
							$i++;
							endforeach;
							endif;
							?>
						</tbody>					
					</table>  
				</div>

				<label class="dttable_ttl">Operation Wise</label>
				<div class="scroll h200">
					<table class="table table-striped dataTable tbl_pdf">
						<thead>
							<tr>
								<th>S.n</th>
								<th>Operation</th>
								<th>Count</th>
							</tr>
						</thead>
						<tbody>
							<?php if($operationwise):
							$i=1;
							foreach ($operationwise as $kd => $opr):
							?>

							<tr>
								<td><?php echo $i ?>.</td>
								<td><?php echo $opr->bmin_equip_oper; ?></td>
								<td><?php echo $opr->cnt; ?></td>
							</tr>

							<?php
							$i++;
							endforeach;
							endif;
							?>
						</tbody>					
					</table>  
				</div>
			</div>

			<div class="col-sm-6">
				<label class="dttable_ttl">Equipment Wise Warranty</label>
				<div class="scroll h200">
					<table class="table table-striped dataTable tbl_pdf">
						<thead>
							<tr>
								<th>S.n</th>
								<th>Equipment</th>
								<th>In Warranty</th>
								<th>Out of Warranty</th>
							</tr>
						</thead>
						<tbody>

							<?php
								$in_sum=0;
								$out_sum=0;
							 if($warranty_status):
							$i=1;
							foreach ($warranty_status as $kd => $opr):
							?>
							<!-- echo "<pre>";print_r($a[0]->eqli_description);die; -->
							<tr>
								<td><?php echo $i ?>.</td>
								<td><?php echo $opr->eqli_description; ?></td>
								<td><?php echo $opr->inwarr; $in_sum=$in_sum+$opr->inwarr ; ?></td>
								<td><?php echo $opr->outwarr; $out_sum=$out_sum+$opr->outwarr ; ?></td>
							</tr>

							<?php
							$i++;
							endforeach;
							endif;
							?>


	
						</tbody>	
						<tbody>
							<tr>
								<td colspan="2" style="text-align: center">Total</td>
								<td><?php echo $in_sum;?></td>
								<td><?php echo $out_sum;?></td>
							</tr>
						</tbody>				
					</table> 
				</div> 
			</div>
 			



			<div class="col-sm-6">
				<label class="dttable_ttl">Warrenty Wise</label>
				<div class="scroll h200">
					<table class="table table-striped dataTable tbl_pdf">
						<thead>
							<tr>
								<th>S.n</th>
								<th>Equipments Warrenty status</th>
								<th>Count</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1.</td>
								<td>In Warrenty</td>
								<td><?php echo $in_sum; ?></td>
							</tr>
							<tr>
								<td>2.</td>
								<td>Out Warrenty</td>
								<td><?php echo $out_sum; ?></td>
							</tr>
							<tr>
								<td>3.</td>
								<td>Missing Warranty Date</td>
								<td><?php echo (($in_warrenty[0]->cnt+$out_warrenty[0]->cnt)-($in_sum+$out_sum)); ?></td>
							</tr>
						</tbody>					
					</table> 
				</div> 
			</div>
			



		</div>
	</div>
</div>

