
<table class="table" width="100%" >
 <thead class="thead-dark">
  <tr>
    <th scope="col">Coupen NO</th>
    <th scope="col">Fuel</th>
    <th scope="col">Exp Date</th>
    <th scope="col">Gen Date</th>
    <th scope="col">Fiscal Year</th>

    
  </tr>
</thead>
<tbody>
 
  <?php foreach ($details as $key => $value) {
   
   ?>
   <tr>
    <td ><?php echo !empty($value->fude_coupenno)?$value->fude_coupenno:''; ?></td>
    <td><?php echo  !empty($value->futy_name)?$value->futy_name:''; ?></td>
    <td><?php echo !empty($value->fuel_expdatebs)?$value->fuel_expdatebs:''; ?></td>
    <td><?php echo !empty($value->fuel_gendatebs)?$value->fuel_gendatebs:''; ?></td>
    <td><?php echo !empty($value->fuel_fyear)?$value->fuel_fyear:''; ?></td>
    <td>   
     <!--  <a href="javascript:void(0)" data-id='<?php echo $value->fude_fuelcoupendetailsid; ?>'  data-viewurl='<?php echo base_url('fuel/fuel/user_assign_popup')?>' class="view  btn-xxs" data-heading=" Coupen Assigned to User" ><i class="fa fa-book" aria-hidden="true" ></i></a> -->
   </td>
 </tr>
<?php } ?>


</tbody>
</table>
