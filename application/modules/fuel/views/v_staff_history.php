<div class="clear-fix"></div>
<h3><?php echo $staff_data[0]->stin_fname.' '.$staff_data[0]->stin_lname; ?> Currently Used  This Fuel Coupen.</h3>
<table class="table table-striped menulist dataTable">
	<thead>
		<tr>
			<th>#</th>
			<th>Coupen NO</th>
			<th>Type</th>
			<th>Val Date(BS)</th>
			<th>Fiscal Year</th>
			<th>Month</th>
			
		</tr>
	</thead>

	<tbody>
    <?php if(!empty($Cur_staff_data)): ?>
      <tr>
        <td></td>
        <td><?php echo !empty($Cur_staff_data[0]->fude_coupenno)?$Cur_staff_data[0]->fude_coupenno:''; ?></td>
        <td><?php echo !empty($Cur_staff_data[0]->futy_name)?$Cur_staff_data[0]->futy_name:''; ?></td>
        <td><?php echo !empty($Cur_staff_data[0]->fuel_expdatebs)?$Cur_staff_data[0]->fuel_expdatebs:''; ?></td>
        <td><?php echo !empty($Cur_staff_data[0]->fuel_fyear)?$Cur_staff_data[0]->fuel_fyear:''; ?></td>
        <td><?php echo !empty($Cur_staff_data[0]->mona_namenp)?$Cur_staff_data[0]->mona_namenp:''; ?></td>
        
      </tr>
    <?php endif; ?>
  </tbody>

</table>

<h3> <?php echo $staff_data[0]->stin_fname.' '.$staff_data[0]->stin_lname; ?> Previous Used Following  Coupens .</h3>
<table class="table table-striped menulist dataTable">
  <thead>
    <tr>
      <th>#</th>
      <th>Coupen NO</th>
      <th>Type</th>
      <th>Val Date(BS)</th>
      <th>Fiscal Year</th>
      <th>Month</th>
      
    </tr>
  </thead>

  <tbody>
    <?php if($pre_staff_data):
      foreach ($pre_staff_data as $kph => $pre):
       ?>
       <tr>
        <td></td>
        <td><?php echo !empty($pre->fude_coupenno)?$pre->fude_coupenno:''; ?></td>
        <td><?php echo !empty($pre->futy_name)?$pre->futy_name:''; ?></td>
        <td><?php echo !empty($pre->fuel_expdatebs)?$pre->fuel_expdatebs:''; ?></td>
        <td><?php echo !empty($pre->fuel_fyear)?$pre->fuel_fyear:''; ?></td>
        <td><?php echo !empty($pre->mona_namenp)?$pre->mona_namenp:''; ?></td>
        
        <td></td>
      </tr>
    <?php endforeach; endif; ?>
    
    

  </tbody>

</table>


