 <style type="text/css">
 	table{
 		font-size: 15px !important;	
 	}
 	

 </style>
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link href="<?php echo base_url(); ?>/assets/template/css/bootstrap.min.css" rel="stylesheet"> 

<table class="table table-striped table-bordered">
	<tr>
		<td><label> System ID:</label></td>
		<td>	<span><?php echo !empty($assets_rec_data[0]->asen_asenid) ? $assets_rec_data[0]->asen_asenid : ''; ?></span></td>
	</tr>
	<tr>
		<td><label> Asset Code:</label></td>
		<td><span><?php echo $ass_code = !empty($assets_rec_data[0]->asen_assetcode) ? $assets_rec_data[0]->asen_assetcode : ''; ?></span></td>
	</tr>
	<tr>
		<td><label>Item Name</label></td>
		<td><?php echo !empty($assets_rec_data[0]->itli_itemname) ? $assets_rec_data[0]->itli_itemname : ''; ?></td>
	</tr>
	<tr>
		<td><label> Asset Description:</label></td>
		<td><span>

			<?php echo $ass_desc = !empty($assets_rec_data[0]->asen_desc) ? $assets_rec_data[0]->asen_desc : ''; ?>

		</span></td>
	</tr>
	
	<tr>
		<td><label>Asset Category:</label></td>
		<td><span><?php echo !empty($assets_rec_data[0]->eqca_category) ? $assets_rec_data[0]->eqca_category : ''; ?></span></td>
	</tr>
	
	<tr>
		<td><label> Asset Manual Code:</label></td>
		<td>	<span><?php echo !empty($assets_rec_data[0]->asen_assestmanualcode) ? $assets_rec_data[0]->asen_assestmanualcode : ''; ?></span></td>
	</tr>
	<?php if(ORGANIZATION_NAME=='KU'): ?>
	<tr>
		<td><label> School:</label></td>
		<td><span><?php $schoolid= !empty($assets_rec_data[0]->asen_schoolid) ? $assets_rec_data[0]->asen_schoolid : '';   
			$school_result=$this->general->get_tbl_data('*','loca_location',array('loca_locationid'=>$schoolid),'loca_name','ASC'); 

               if(!empty($school_result)){

                echo !empty($school_result[0]->loca_name)?$school_result[0]->loca_name:'';

               }?></span></td>
	</tr>
<?php else:
?>
<tr>
		<td><label> Location:</label></td>
		<td><span><?php $locationid= !empty($assets_rec_data[0]->asen_locationid) ? $assets_rec_data[0]->asen_locationid : '';   
			$location_name=$this->general->get_tbl_data('*','loca_location',array('loca_locationid'=>$locationid),'loca_name','ASC'); 

               if(!empty($location_name)){

                echo !empty($location_name[0]->loca_name)?$location_name[0]->loca_name:'';

               }?></span></td>
	</tr>
<?php
endif; ?>
	<tr>
		<td><label>Department</label></td>
		<?php
		 	$parentdep=!empty($assets_rec_data[0]->depparen)?$assets_rec_data[0]->depparen:'';
			   	 if(!empty($parentdep)){
			   	 	 $depname = $assets_rec_data[0]->depparen.'/'.$assets_rec_data[0]->dept_depname;	
			   	 	}else{
			   	 		$depname = $assets_rec_data[0]->dept_depname;	
			   	 	}
		?>
		<td><span><?php echo $depname; ?></span></td>
	</tr>
	
	<tr>
		<td><label>Supplier:</label></td>
		<td>	<span><?php echo !empty($assets_rec_data[0]->dist_distributor) ? $assets_rec_data[0]->dist_distributor : ''; ?></span></td>
	</tr>
	<tr>
		<td><label>Purchase Date:</label></td>
		<td><span><?php echo !empty($assets_rec_data[0]->asen_purchasedatebs) ? $assets_rec_data[0]->asen_purchasedatebs : ''; ?></span></td>
	</tr>
	<tr>
		<td><label>Purchase Rate</label></td>
		<td><span><?php echo !empty($assets_rec_data[0]->asen_purchaserate) ? $assets_rec_data[0]->asen_purchaserate : ''; ?></span></td>
	</tr>
	<tr>
		<td><label>Received By</label></td>
		<td><span><?php echo $assets_rec_data[0]->stin_fname.' '.$assets_rec_data[0]->stin_mname.' '.$assets_rec_data[0]->stin_lname ?></span></td>
	</tr>

</table>





	




	