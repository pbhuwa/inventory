<form method="post" id="FormItem" action="<?php echo base_url('stock_inventory/item/save_item'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('stock_inventory/item/form_item'); ?>' >
<input type="hidden" name="id" value="<?php echo!empty($item_data[0]->itli_itemlistid)?$item_data[0]->itli_itemlistid:'';  ?>">

<?php
// echo "<pre>";
// print_r($item_data);
// die();

?>
  <div class="form-group">

   <div class="col-md-4"> 
      <?php $matetypeid=!empty($item_data[0]->itli_materialtypeid)?$item_data[0]->itli_materialtypeid:''; ?>
<label for="example-text">Matetial Type <span class="required">*</span>:</label>
<select name="itli_materialtypeid" class="form-control select2" >
          <option value="">---select---</option>
          <?php
          if($material_type):
            foreach ($material_type as $km => $mat):
              ?> 
          <option value="<?php echo $mat->maty_materialtypeid; ?>" <?php if($matetypeid==$mat->maty_materialtypeid) echo "selected=selected"; ?>><?php echo $mat->maty_material; ?></option>
              <?php 
            endforeach;
          endif;
           ?>
</select>
</div>
<div class="col-md-4"> 
   <?php $catid=!empty($item_data[0]->itli_catid)?$item_data[0]->itli_catid:''; ?>
<label for="example-text">Sub Category <span class="required">*</span>:</label>
<select name="itli_catid" class="form-control select2" >
          <option value="">---select---</option>
          <?php
          if($subcategory):
            foreach ($subcategory as $km => $cat):
              ?> 
  <!-- subcategory id -->  <option value="<?php echo $cat->eqca_equipmentcategoryid; ?>"  <?php if($catid==$cat->eqca_equipmentcategoryid) echo "selected=selected"; ?>><?php echo $cat->eqca_category; ?></option>
              <?php 
            endforeach;
          endif;
           ?>
        </select>
  </div>

<div class="col-md-4">
     <?php $itemname=!empty($item_data[0]->itli_itemname)?$item_data[0]->itli_itemname:''; ?>
<label for="example-text">Item Name <span class="required">*</span>:</label>
<input type="text" name="itli_itemname" class="form-control" value="<?php echo $itemname; ?>">
</div>
</div>
<div class="clear-fix"></div>
<div class="form-group">

<div class="col-md-4">
   <?php $itemcode=!empty($item_data[0]->itli_itemcode)?$item_data[0]->itli_itemcode:''; ?>
<label for="example-text">Item Code <span class="required">*</span>:</label>
<input type="text" class="form-control" name="itli_itemcode"  value="<?php echo $itemcode; ?>">
</div>

<div class="col-md-4">
  <?php $reorderlevel=!empty($item_data[0]->itli_reorderlevel)?$item_data[0]->itli_reorderlevel:''; ?>
<label for="example-text">Reorder Level :</label>
<input type="text" class="form-control" name="itli_reorderlevel" value="<?php echo $reorderlevel; ?>" >
</div>

<div class="col-md-4">
    <?php $maxlimit=!empty($item_data[0]->itli_maxlimit)?$item_data[0]->itli_maxlimit:''; ?>
<label for="example-text">Max Limit :</label>
<input type="text" class="form-control" name="itli_maxlimit"  value="<?php echo $maxlimit; ?>" >
</div>
</div>
<div class="form-group">

<div class="col-md-4">
    <?php $purchaserate=!empty($item_data[0]->itli_purchaserate)?$item_data[0]->itli_purchaserate:''; ?>
<label for="example-text">Purchase Rate :</label>
<input type="text" class="form-control" name="itli_purchaserate" value="<?php echo $purchaserate; ?>" >
</div>

<div class="col-md-4">
<label for="example-text">Units:</label>
 <?php $unitid=!empty($item_data[0]->itli_unitid)?$item_data[0]->itli_unitid:''; ?>
<select name="itli_unitid" class="form-control select2" >
        <option value="">---select---</option>
        <?php
            if($unit):
          foreach ($unit as $km => $un):
            ?> 
            <option value="<?php echo $un->unit_unitid; ?>" <?php if($unitid==$un->unit_unitid) echo "selected=selected"; ?>><?php echo $un->unit_unitname; ?></option>
            <?php 
          endforeach;
        endif;
         ?>
</select>
</div>

<div class="col-md-4">
    <?php $typeid=!empty($item_data[0]->itli_typeid)?$item_data[0]->itli_typeid:''; ?>
        <label for="example-text">Items Type <span class="required">*</span>:</label>
        <select name="itli_typeid" class="form-control select2" >
        <option value="">---select---</option>
        <?php
           if($equipmenttype):
          foreach ($equipmenttype as $km => $eq):
            ?> 
          <option value="<?php echo $eq->eqty_equipmenttypeid; ?>" <?php if($typeid==$eq->eqty_equipmenttypeid) echo "selected=selected"; ?> ><?php echo $eq->eqty_equipmenttype; ?></option>
            <?php 
          endforeach;
        endif;
         ?>
        </select>
</div>
</div>
<div class="form-group">
<div class="col-md-12">
   <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($item_data)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($item_data)?'Update':'Save' ?></button>
</div>
  <div class="col-sm-12">
                <div  class="alert-success success"></div>
                <div class="alert-danger error"></div>
  </div>
</div>


 
    





  