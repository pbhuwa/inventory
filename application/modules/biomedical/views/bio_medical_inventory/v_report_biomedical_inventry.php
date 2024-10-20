<style>
	h3.bio_equip_inv_ttl { margin:0; font-size:25px; font-weight:bold; text-align:center; background-color:#ddd; padding:5px 0;}
	.sub_group_ttl { font-size:14px; padding-top:10px; font-weight:bold; }
	
	.info_block	{ border:2px solid #ddd; }
	.info_block table{ border-collapse: collapse;  width:100%; font-siZe:12px; }
	.info_block table td { padding:2px 4px; }
	
	.title_block { padding-top: 20px; }
	.title_block table td.title { text-align:center; border:1px solid black; }
	
</style>


<h3 class="bio_equip_inv_ttl">Biomedical Equipment Inventory</h3>
<div class="sub_group_ttl">Department</div><hr>
<?php
foreach ($distinct_department as $kdep => $dep){
 ?>
	<div class="title_block">
		<table width="100%">
			<tr>
				<td>&nbsp;</td>
				<td width="20%" class="title"><?php echo $dep->dein_department; ?></td>
				<td>&nbsp;</td>
			</tr>
		</table>
	</div>
	<div class="info_block">
		<table>
			<tbody>
			<?php 
			  $depwisepatientrpt=$this->bio_medical_mdl->get_biomedical_inventry_report(array('bmin_departmentid'=>$dep->dein_departmentid));
			 if($depwisepatientrpt):
			 foreach ($depwisepatientrpt as $kdpr => $testrpt):
			 	?>
				<tr>
					<td width="30%"><b>Type</b></td>
					<td width="15%"><b>ID</b> 106</td>
					<td width="30%"><b>Manufacturer</b></td>
				</tr>
				<tr>
					<td><b>Model No : <?php echo $testrpt->bmin_modelno;?></b></td>
					<td><b>Serial No.</b> 10</td>
					<td><b>Distributor</b></td>
				</tr>
				<tr>
					<td><b>Put into Service</b></td>
					<td></td>
					<td><b>Equipment Operational</b> <input type="checkbox"></td>
				</tr>
				<tr>
					<td><b>Manuals:</b> Operation&nbsp;<input type="checkbox">&nbsp;&nbsp; Service&nbsp;<input type="checkbox"></td>
					<td><b>Risks: <?php echo $testrpt->riva_risk; ?></b></td>
					<td><b>Removed from Inventory</b> <input type="checkbox"></td>
				</tr>
				<tr>
					<td><b>Accessories : <?php echo $testrpt->bmin_accessories;?></b></td>
					<td></td>
					<td><b>AMC Contractor : <?php echo $testrpt->bmin_amc?></b></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td></td>
					<td> </td>
				</tr>
				<tr>
					<td colb="4"><b>Comments: <?php echo $testrpt->bmin_comments;?></b></td>
				</tr>
				<?php
				 endforeach;
				 endif;
				?>
			</tbody>
		</table>
	</div>
<?php } ?>




