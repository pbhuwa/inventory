	<div class="pad-10">
		<div class="form-group">
			<div class="col-sm-6">
				<label class="dttable_ttl"><center>Branch Wise</center></label>
				<div class="scroll h200">
					<table class="table table-striped dataTable tbl_pdf">
						<thead>
							<tr>
								<th><?php echo $this->lang->line('sn'); ?></th>
								<th><?php echo $this->lang->line('location'); ?></th>
								<th>Count</th>
							</tr>
						</thead>
						<tbody>
							<?php if($location_wise):
							$i=1;
							foreach ($location_wise as $kd => $loc):
							?>

							<tr>
								<td><?php echo $i ?>.</td>
								<td><?php echo $loc->loca_name; ?></td>
								<td><?php echo $loc->cnt; ?></td>
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
				<label class="dttable_ttl"><center><?php echo $this->lang->line('assets_condition_wise'); ?></center></label>
				<div class="scroll h200">
					<table class="table table-striped dataTable tbl_pdf">
						<thead>
							<tr>
								<th><?php echo $this->lang->line('sn'); ?></th>
								<th><?php echo $this->lang->line('condition'); ?></th>
								<th>Count</th>
							</tr>
						</thead>
						<tbody>
							<?php if($conditionwise):
							$i=1;
							foreach ($conditionwise as $kd => $con):
							?>

							<tr>
								<td><?php echo $i ?>.</td>
								<td><?php echo $con->asco_conditionname; ?></td>
								<td><?php echo $con->cnt; ?></td>
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
				<label class="dttable_ttl"><center><?php echo $this->lang->line('assets_status_wise'); ?> </center></label>
				<div class="scroll h200">
					<table class="table table-striped dataTable tbl_pdf">
						<thead>
							<tr>
								<th><?php echo $this->lang->line('sn'); ?></th>
								<th><?php echo $this->lang->line('status'); ?></th>
								<th>Count</th>
							</tr>
						</thead>
						<tbody>
							<?php if($statuswise):
							$i=1;
							foreach ($statuswise as $kd => $desc):
							?>

							<tr>
								<td><?php echo $i ?>.</td>
								<td><?php echo $desc->asst_statusname; ?></td>
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
				<label class="dttable_ttl"><center><?php echo $this->lang->line('manufacture_wise'); ?></center></label>
				<div class="scroll h200">
					<table class="table table-striped dataTable tbl_pdf">
						<thead>
							<tr>
								<th><?php echo $this->lang->line('sn'); ?></th>
								<th><?php echo $this->lang->line('manufacture'); ?> <?php echo $this->lang->line('name'); ?></th>
								<th>Count</th>
							</tr>
						</thead>
						<tbody>
							<?php if($manufacture_wise):
							$i=1;
							foreach ($manufacture_wise as $kd => $dist):
							?>

							<tr>
								<td><?php echo $i ?>.</td>
								<td><?php echo $dist->manu_manlst; ?></td>
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
				<label class="dttable_ttl"><center><?php echo $this->lang->line('category_wise'); ?></center></label>
				<div class="scroll h200">
					<table class="table table-striped dataTable tbl_pdf">
						<thead>
							<tr>
								<th><?php echo $this->lang->line('sn'); ?></th>
								<th><?php echo $this->lang->line('category'); ?></th>
								<th>Count</th>
							</tr>
						</thead>
						<tbody>
							<?php if($category_wise):
							$i=1;
							foreach ($category_wise as $kd => $amc):
							?>

							<tr>
								<td><?php echo $i ?>.</td>
								<td><?php echo $amc->eqca_category; ?></td>
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

		<label class="dttable_ttl"><center><?php echo $this->lang->line('assets_warranty_wise'); ?></center></label>
				<div class="scroll h200">
					<table class="table table-striped dataTable tbl_pdf">
						<thead>
							<tr>
								<th><?php echo $this->lang->line('sn'); ?></th>
								<th><?php echo $this->lang->line('assets'); ?> <?php echo $this->lang->line('warrenty'); ?> <?php echo $this->lang->line('status'); ?></th>
								<th>Count</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1.</td>
								<td>In Warrenty</td>
								<td><?php echo $in_warrenty[0]->cnt; ?></td>
							</tr>
							<tr>
								<td>2.</td>
								<td>Out Warrenty</td>
								<td><?php echo $out_warrenty[0]->cnt; ?></td>
							</tr>
						</tbody>					
					</table>  
				</div>
			</div> 

			
		</div>
	</div>
</div>
</div>
</div>
</div>
</div>
