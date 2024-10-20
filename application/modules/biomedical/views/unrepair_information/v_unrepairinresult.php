
<ul class="pm_data">
	<li>
		<input type="hidden" name="ureq_equipid" value="<?php echo $rere_data[0]->bmin_equipid?>">
		<label>Description </label>
		<?php echo $rere_data[0]->eqli_description;?>
	</li>
	<li>
		<label>Serial Number</label>
		<?php echo $rere_data[0]->bmin_modelno?>
	</li>
	<li>
		<label> Accessories</label>
		<?php echo $rere_data[0]->bmin_accessories;?>
	</li>
	<li>
		<label> Comments</label>
		<?php echo $rere_data[0]->bmin_comments;?>
	</li>
	<li>
		<label>Service Start Date</label>
		<?php echo $rere_data[0]->bmin_servicedatead;?>
	</li>
	<li>
		<label>End Warrenty Date</label>
		<?php echo $rere_data[0]->bmin_endwarrantydatead;?>
	</li>

	<li>
		<label>Department</label>
		<?php echo $rere_data[0]->dein_department;?>
	</li>
	<li>
		<label>Risk</label>
		<?php echo $rere_data[0]->riva_risk;?>
	</li>
	<li>
		<label>Distributers</label>
		<?php echo $rere_data[0]->dist_distributor;?>
	</li>
</ul>
