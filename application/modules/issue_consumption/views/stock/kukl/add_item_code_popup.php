
<div class="list_c2 label_mw125">
  <div class="form-group row resp_xs">
    <div class="clearfix"></div>
    <br>
    <div class="list_c2 label_mw125">
      <form id="FormChangeStatus" action="<?php echo base_url('issue_consumption/stock_requisition/update_itemcode');?>" method="POST">
        <input type="hidden" name="id" value="<?php echo !empty($reqdetail_data[0]->rede_reqdetailid)?$reqdetail_data[0]->rede_reqdetailid:'';  ?>">
        <div class="form-group">
          <div class="col-ms-12">
            <div class="row">
             <div class="col-md-3">
               
               <label for="example-text"><?php echo $this->lang->line('item_code'); ?> <span class="required">*</span>: </label>
               <input type="text" class="form-control required_field itemcode" name="itli_itemcode"  value="" id="item_codeid">
             </div>
             <div class="col-md-3">
               <?php $remarks=!empty($reqdetail_data[0]->rede_remarks)?$reqdetail_data[0]->rede_remarks:''; ?>
               <label for="example-text"><?php echo $this->lang->line('remarks'); ?> :</label>
               <input type="text" class="form-control required_field remarks" name="remarks"  value="<?php echo $remarks; ?>" readonly >
             </div>
           



             <!-- <button type="button" id="myBtn" value="1">Show Value</button> -->

             
             <div class="col-md-2">
              <label for="example-text"></label>
              
              <button href="javascript:void(0)" class=" form-control favorite  btn btn-sm btn-warning table-cell width_30 view" data-heading='Item Entry' data-viewurl='<?php echo base_url('stock_inventory/item/item_entry/modal'); ?>'
                type="button">
                Add New Item
              </button>

            </div>
            <div class="clear-fix"> </div>


            <div class="col-md-12">
              <!-- <label>&nbsp;</label> -->
              <button type="submit" class="btn btn-info  savelist" data-operation="save" id="btnDeptment" data-isdismiss="Y" data-isrefresh="Y">Update Unknown Item</button>
            </div>

            <div class="col-sm-12">
              <div  class="alert-success success"></div>
              <div class="alert-danger error"></div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>  
</div>


<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$("#myBtn").click(function(){
var str = $(this).val();
$('#item_codeid').val(str);
});
});
</script> -->


