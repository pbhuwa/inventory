<form method="post" id="formitem" action="<?php echo base_url('stock_inventory/item/save_item'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('stock_inventory/item/form_item'); ?>' >
    <input type="hidden" name="id" value="<?php echo !empty($item_data[0]->itli_itemlistid) ? $item_data[0]->itli_itemlistid : ''; ?>">

    <?php
// echo "<pre>";
// print_r($item_data);
// print_r($subcategory);
// die();
?>
    <div class="form-group">

        <div class="col-md-6">
            <?php $matetypeid = !empty($item_data[0]->itli_materialtypeid) ? $item_data[0]->itli_materialtypeid : '';?>
            <label for="example-text"><?php echo $this->lang->line('material_type'); ?> <span class="required">*</span>:</label>
            <div class="dis_tab">
                <select name="itli_materialtypeid" id="itli_materialtypeid" class="form-control required_field select2" >
                          <option value="">---select---</option>
                          <?php
if ($material_type):
	foreach ($material_type as $km => $mat):
	?>
	                          <option value="<?php echo $mat->maty_materialtypeid; ?>" <?php if ($matetypeid == $mat->maty_materialtypeid) {
		echo "selected=selected";
	}
	?>><?php echo $mat->maty_material; ?></option>
	                              <?php
endforeach;
endif;
?>
                </select>

                <!--
                <a href="javascript:void(0)" class="table-cell frm_add_btn width_30 view" data-viewurl='<?php // echo base_url('biomedical/equipments/equipment_cat_popup/'); ?>' data-heading="Item Category Entry" ><i class="fa fa-plus"></i></a>  -->

            </div>
        </div>

<div class="col-md-6">
     <?php $catid = !empty($item_data[0]->itli_catid) ? $item_data[0]->itli_catid : '';?>
    <label for="example-text"><?php echo $this->lang->line('category'); ?> <span class="required">*</span>:</label>
    <div class="dis_tab">

      <select name="itli_catid" class="form-control required_field select2" id="item_catid" >
          <option value="">---select---</option>
          <?php
if (!empty($subcategory)):
	foreach ($subcategory as $km => $cat):
	?>
	      <!-- subcategory id -->
	       <option value="<?php echo $cat->eqca_equipmentcategoryid; ?>"  <?php if ($catid == $cat->eqca_equipmentcategoryid) {
		echo "selected=selected";
	}
	?>><?php echo $cat->eqca_category; ?></option>
	              <?php
endforeach;
endif;
?>
        </select>

  <a href="javascript:void(0)" class="table-cell frm_add_btn width_30 refresh_element" data-targetid='item_catid' data-viewurl='<?php echo base_url('biomedical/equipments/equipment_reload/'); ?>' ><i class="fa fa-refresh"></i></a>

  <a href="javascript:void(0)" class="table-cell frm_add_btn width_30 view" data-viewurl='<?php echo base_url('biomedical/equipments/equipment_cat_popup/'); ?>' data-heading="Item Category Entry" ><i class="fa fa-plus"></i></a>  </div>
</div>

<!-- Brand -->
<div class="col-md-6">
     <?php $branid = !empty($item_data[0]->itli_branid) ? $item_data[0]->itli_branid : '';?>
    <label for="example-text"><?php echo $this->lang->line('brand'); ?> <span class="required">*</span>:</label>
     <div class="dis_tab">

        <select name="itli_branid" class="form-control select2 required_field" id="item_branid" >
          <option value="">---select---</option>
          <?php
if ($brand):
	foreach ($brand as $km => $bran):
	?>
	              <option value="<?php echo $bran->bran_brandid; ?>" <?php if ($branid == $bran->bran_brandid) {
		echo "selected=selected";
	}
	?>><?php echo $bran->bran_name; ?></option>
	              <?php
endforeach;
endif;
?>
  </select>

  <a href="javascript:void(0)" class="table-cell frm_add_btn width_30 refresh_brand" data-targetid='item_branid' data-viewurl='<?php echo base_url('biomedical/equipments/brand_reload/'); ?>' ><i class="fa fa-refresh"></i></a>

  <a href="javascript:void(0)" class="table-cell frm_add_btn width_30 view" data-viewurl='<?php echo base_url('settings/brand/brand_popup/'); ?>' data-heading="Item Brand Entry" ><i class="fa fa-plus"></i></a></div>
</div>

<div class="col-md-6">
    <?php $itli_quality = !empty($item_data[0]->itli_quality) ? $item_data[0]->itli_quality : '';?>
<label for="example-text"><?php echo $this->lang->line('quality'); ?>
  <span class="required"></span>:
</label>
<input type="text" class="form-control" name="itli_quality" value="<?php echo $itli_quality; ?>" >
</div>

<div class="clearfix"></div>

<div class="col-md-6">
     <?php $itemname = !empty($item_data[0]->itli_itemname) ? $item_data[0]->itli_itemname : '';?>
<label for="example-text"><?php echo $this->lang->line('item_name'); ?>
  <span class="required">*</span>:</label>
<input type="text" name="itli_itemname" class="form-control required_field" value="<?php echo $itemname; ?>" onkeyup="javascript:convert();" >
</div>

<div class="col-md-6">
     <?php $itemnamenp = !empty($item_data[0]->itli_itemnamenp) ? $item_data[0]->itli_itemnamenp : '';?>
<label for="example-text"><?php echo $this->lang->line('item_name_np'); ?>
  :</label>
<input type="text" name="" class="form-control preeti" value="<?php echo $itemnamenp; ?>" style="font-size: 17px;" id="legacy_text" onkeyup="javascript:convert_to_unicode();" >
<input type="hidden" name="itli_itemnamenp" class="form-control " value="<?php echo $itemnamenp; ?>" style="font-size: 17px;" id="unicode_text">

</div>

<div class="col-md-6">
   <?php $itemcode = !empty($item_data[0]->itli_itemcode) ? $item_data[0]->itli_itemcode : '';?>
<label for="example-text"><?php echo $this->lang->line('item_code'); ?> <span class="required">*</span>:</label>
<input type="text" class="form-control required_field itemcode" name="itli_itemcode"  value="<?php echo $itemcode; ?>">
</div>
<?php
if (ORGANIZATION_NAME == 'KUKL'): ?>

<div class="col-md-6">
    <?php $accode = !empty($item_data[0]->itli_accode) ? $item_data[0]->itli_accode : '';?>
<label for="example-text">AC Code:</label>
<input type="text" class="form-control  searchText" data-srchurl='<?php echo base_url('/stock_inventory/item/search_acc_code') ?>' name="itli_accode" value="<?php echo $accode; ?>" id="acc_code" >
<div id="DisplayBlock_acc_code"></div>
</div>
  <?php endif;?>

<div class="col-md-6">
  <?php $reorderlevel = !empty($item_data[0]->itli_reorderlevel) ? $item_data[0]->itli_reorderlevel : '10';?>
<label for="example-text"><?php echo $this->lang->line('reorder_level'); ?> :</label>
<input type="text" class="form-control number" name="itli_reorderlevel" value="<?php echo $reorderlevel; ?>" >
</div>

<div class="col-md-6">
    <?php $maxlimit = !empty($item_data[0]->itli_maxlimit) ? $item_data[0]->itli_maxlimit : '10';?>
<label for="example-text"><?php echo $this->lang->line('max_limit'); ?> :</label>
<input type="text" class="form-control number" name="itli_maxlimit"  value="<?php echo $maxlimit; ?>" >
</div>

<div class="col-md-6">
    <?php $purchaserate = !empty($item_data[0]->itli_purchaserate) ? $item_data[0]->itli_purchaserate : '';?>
<label for="example-text"><?php echo $this->lang->line('purchase_rate'); ?> :</label>
<input type="text" class="form-control float" name="itli_purchaserate" value="<?php echo $purchaserate; ?>" >
</div>

<div class="col-md-6">
  <label for="example-text"><?php echo $this->lang->line('unit'); ?>:</label>
  <div class="dis_tab">
  <?php $unitid = !empty($item_data[0]->itli_unitid) ? $item_data[0]->itli_unitid : '';?>
  <select name="itli_unitid" class="form-control select2" id="item_unitid" >
          <option value="">---select---</option>
          <?php
if ($unit):
	foreach ($unit as $km => $un):
	?>
	              <option value="<?php echo $un->unit_unitid; ?>" <?php if ($unitid == $un->unit_unitid) {
		echo "selected=selected";
	}
	?>><?php echo $un->unit_unitname; ?></option>
	              <?php
endforeach;
endif;
?>
  </select>
 <a href="javascript:void(0)" class="table-cell frm_add_btn width_30 refresh_element_unit" data-targetid='item_unitid' data-viewurl='<?php echo base_url('biomedical/equipments/unit_reload/'); ?>' ><i class="fa fa-refresh"></i></a>

  <a href="javascript:void(0)" class="table-cell frm_add_btn width_30 view" data-viewurl='<?php echo base_url('biomedical/equipments/equipment_unit_popup/'); ?>' data-heading="Unit Entry" ><i class="fa fa-plus"></i></a>
</div>
</div>

<div class="col-md-4">
    <?php $typeid = !empty($item_data[0]->itli_typeid) ? $item_data[0]->itli_typeid : '';?>
        <label for="example-text"><?php echo $this->lang->line('store_type'); ?> <span class="required">*</span>:</label>
        <select name="itli_typeid" class="form-control select2" >

        <?php
if ($equipmenttype):
	foreach ($equipmenttype as $km => $eq):
	?>
	          <option value="<?php echo $eq->eqty_equipmenttypeid; ?>" <?php if ($typeid == $eq->eqty_equipmenttypeid) {
		echo "selected=selected";
	}
	?> ><?php echo $eq->eqty_equipmenttype; ?></option>
	            <?php
endforeach;
endif;
?>
        </select>
</div>
</div>
<div class="form-group">
<div class="col-md-12">
  <?php
if (!empty($modal) && $modal == 'modal'):
	$saveclass = 'savelist';
else:
	$saveclass = 'savelist';
endif;
?>
  <button type="submit" class="btn btn-info <?php echo $saveclass; ?>" data-operation='<?php echo !empty($item_data) ? 'update' : 'save' ?>' id="btnSubmit" data-isdismiss='Y' ><?php echo !empty($item_data) ? 'Update' : 'Save' ?></button>

</div>
  <div class="col-sm-12">
                <div  class="alert-success success"></div>
                <div class="alert-danger error"></div>
  </div>
</div>

<script type="text/javascript">
  $(document).on('change','#item_catid',function()
  {
    var item_catid=$(this).val();
      var action=base_url+'/stock_inventory/item/getcat_code';
     $.ajax({
          type: "POST",
          url: action,
          data:{item_catid:item_catid},
          dataType: 'json',
         success: function(datas)
          {
            $('.itemcode').val(datas);
          }
      });
  })
</script>

<script type="text/javascript">
  $(document).off('click','.refresh_element');
  $(document).on('click','.refresh_element',function(e)
  {
    var targetid=$(this).data('targetid');
    var action=$(this).data('viewurl');
     $.ajax({
          type: "POST",
          url: action,
          data:{},
          dataType: 'json',
         success: function(datas)
          {
             // $('#'+targetid).html('');
            $('#'+targetid).html(datas);
          }
      });
  });

  $(document).off('click','.refresh_element_unit');
  $(document).on('click','.refresh_element_unit',function(e)
  {
    var targetid=$(this).data('targetid');
    var action=$(this).data('viewurl');
     $.ajax({
          type: "POST",
          url: action,
          data:{},
          dataType: 'json',
         success: function(datas)
          {
             // $('#'+targetid).html('');
            $('#'+targetid).html(datas);
          }
      });
  });

    $(document).off('click','.refresh_brand');
  $(document).on('click','.refresh_brand',function(e)
  {
    var targetid=$(this).data('targetid');
    var action=$(this).data('viewurl');
     $.ajax({
          type: "POST",
          url: action,
          data:{},
          dataType: 'json',
         success: function(datas)
          {
             // $('#'+targetid).html('');
            $('#'+targetid).html(datas);
          }
      });
  });


</script>

 <!-- <script type="text/javascript">
            $(document).on('change','#itli_materialtypeid',function(){
                var material_typeid = $('#itli_materialtypeid').val();

                var action=base_url+'/stock_inventory/item/get_category_by_materialid';

                $.ajax({
                    type: "POST",
                    url: action,
                    data:{material_typeid:material_typeid},
                    dataType: 'json',
                    success: function(datas)
                    {
                        $('#item_catid').select2("val", "");
                        $('#item_catid').html(datas);
                    }
                });

            });

            $(document).off('click','.refresh_category');
              $(document).on('click','.refresh_category',function(e)
              {
                var material_typeid = $('#itli_materialtypeid').val();

                  var targetid=$(this).data('targetid');
                  var action=$(this).data('viewurl');
                  $.ajax({
                      type: "POST",
                      url: action,
                      data:{material_typeid:material_typeid},
                      dataType: 'json',
                      success: function(datas)
                      {
                       // $('#'+targetid).html('');
                       $('#'+targetid).select2("val", "");
                      $('#'+targetid).html(datas);
                      }
                  });
              });

        </script> -->