<form method="post" id="formitem" action="<?php echo base_url('stock_inventory/item/save_otheritem'); ?>" class="form-material form-horizontal form">

  <div class="row">
    <div class="form-group">
      <div class="col-sm-4">
         <label>Items Name</label>
         <input type="text" name="teit_itemname" class="form-control">
      </div>
    </div>
    <div class="form-group">
       <div class="col-sm-4">
      <button type="submit" class="btn-sm btn-success savelist" data-isdismiss='Y'>Save</button>
    </div>
      <div class="col-sm-12">
          <div  class="alert-success success"></div>
          <div class="alert-danger error"></div>
  </div>
    </div>
  </div>

</form>
 