
<ul class="pm_data">
	<li>
		<input type="hidden" name="pmco_equipid" value="<?php echo $eqli_data[0]->bmin_equipid?>">
		<label> Name</label>
		<?php echo $eqli_data[0]->eqli_description;?>
	</li>
	<li>
		<label> Accessories</label>
		<?php echo $eqli_data[0]->bmin_accessories;?>
	</li>
	<li>
		<label> Comments</label>
		<?php echo $eqli_data[0]->bmin_comments;?>
	</li>
	<li>
		<label> Postdatead</label>
		<?php echo $eqli_data[0]->bmin_postdatead;?>
	</li>
	<li>
		<label>Department</label>
		<?php echo $eqli_data[0]->dein_department;?>
	</li>
	<li>
		<label>&nbsp;</label>
		<?php echo $eqli_data[0]->riva_risk;?>
	</li>
</ul>

