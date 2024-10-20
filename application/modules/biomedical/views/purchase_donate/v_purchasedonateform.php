<form method="post" id="FormPurchase" action="<?php echo base_url('biomedical/purchase_donate/save_purchase_donate'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('biomedical/purchase_donate/form_purchase_donate'); ?>'>
    <input type="hidden" name="id" value="<?php echo!empty($pudo_data[0]->pudo_purdonatedid)?$pudo_data[0]->pudo_purdonatedid:'';  ?>">
    <div class="form-group">
        <div class="col-md-4">
         <label for="example-text">Purchase Donate <span class="required">*</span> :
            </label>
               <input type="text"  name="pudo_purdonated" class="form-control" placeholder="Purchase Donate" value="<?php echo !empty($pudo_data[0]->pudo_purdonated)?$pudo_data[0]->pudo_purdonated:''; ?>" autofocus="true">

        </div>
    </div>

    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 save" data-operation='<?php echo !empty($pudo_data)?'update':'save' ?>'><?php echo !empty($pudo_data)?'Update':'Save' ?></button>
      
       <div  class="alert-success success"></div>
        <div class="alert-danger error"></div>
</form>