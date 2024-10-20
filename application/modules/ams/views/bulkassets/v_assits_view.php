<div class="white-box pad-5">
  <div class="list_c2 label_mw125">
    <div class="form-group row resp_xs">
      <div class="col-md-6 col-xs-6">
        <label>Item Name</label>: 
        <?php echo $items_data[0]->ITEMSNAME;?>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-6">
        <label for="example-text">Description </label>: 
        <?php echo $items_data[0]->DESCRIPTIONFULL; ?>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-6">
        <label for="example-text">Store</label>: 
        <?php echo $items_data[0]->SUPPLIER; ?>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-6">
        <label for="example-text">Received Date</label>: 
        <?php echo $items_data[0]->TRANSACTION_DATE; ?>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-6">
        <label for="example-text">Break-down Qty </label>: 
        <?php echo $items_data[0]->REQUIRED_QTY;?>
      </div>
       <div class="col-md-6 col-sm-6 col-xs-6">
        <label for="example-text">Receive No. </label>: 
        <?php echo $items_data[0]->RECEIVENO;?>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-6">
        <label for="example-text">Unit Price </label>: 
        <?php echo $items_data[0]->UNITPRICE;?>
      </div>
     </div>
  </div>
</div>
<div class="table-responsive">
  <table class="table table-striped dataTable tbl_pdf">
  <thead>
    <tr>
      <th>S.n</th>
      <th>Model No.</th>
      <th>Serial No.</th>
      <th>Department</th>
      <th>Room</th>
      <th>Risk Value</th>
      <th>Equ.Oper.</th>
      <th>AMC</th>
      <th>Serv.Start</th>
      <th>End.War.</th>
    </tr>
  </thead>
<?php 
$qty=$items_data[0]->REQUIRED_QTY; 
for ($i=1; $i <=$qty ; $i++):
  ?>
  <tr>
    <td><?php echo $i; ?></td>
    <td><input type="text" name="bmin_serialno[]"></td>
    <td>
       <input type="text" name="bmin_modelno[]">
    <td>
      <select name="bmin_departmentid[]"   id="departmentid_<?php echo $i; ?>">
        <option value="">---select---</option>

        <?php if($dep_information):
        foreach ($dep_information as $kdi => $depin):?>

        <option value="<?php echo $depin->dept_depid; ?>" ><?php echo $depin->dept_depname; ?></option>

        <?php endforeach; endif; ?>
      </select>
    </td>
    
    <td><select name="bmin_roomid[]"   id="roomid_<?php echo $i; ?>">
        <option value="">---select---</option>
      </select></td>
    <td>
       <select name="bmin_riskid[]" >
        <option value="">---select---</option>

        <?php if($riskval_list):
        foreach ($riskval_list as $krv => $riskval):?>
        <option value="<?php echo $riskval->riva_riskid; ?>"><?php echo $riskval->riva_risk; ?></option>

        <?php endforeach; endif; ?>
      </select>
    </td>
    <td> 
      <select name="bmin_equip_oper[]"   >
       <option value="Yes" >Yes</option>
      <option value="No" >No</option>
      </select></td>
    <td>
      <select name="bmin_amc[]"   >
       <option value="Yes" >Yes</option>
      <option value="No" selected="selected" >No</option>
      </select>
    </td>
    <td><input type="text" name="bmin_servicedate[]" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Service Start Date" value="<?php echo DISPLAY_DATE; ?>" id="ServiceStart_<?php echo $i ?>">
      <span class="errmsg"></td>
    <td><input type="text" name="bmin_endwarranty[]" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Warrenty End Date"  value="<?php echo !empty($equip_data[0]->bmin_servicedate)?$equip_data[0]->bmin_servicedate:DISPLAY_DATE_NEXT_YR; ?>" id="WarrentyEnd"></td>
  </tr>
<?php 
endfor;
?>
</table>
</div>


<script type="text/javascript">
  $('.modal-dialog modal-md').addClass('modal-lg');
</script>