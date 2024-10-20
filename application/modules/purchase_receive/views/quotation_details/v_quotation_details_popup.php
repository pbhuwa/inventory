<div class="form-group pad-5 white-box bg-gray clearfix">
    <!-- <div class="form-border clearfix"> -->
     <div class="col-md-3">
        <label><?php echo $this->lang->line('supplier_name'); ?>:</label>
        <span><?php echo !empty($quotation_master[0]->supp_suppliername)?$quotation_master[0]->supp_suppliername:'';  ?></span>
    </div>

    <div class="col-md-3">
        <label><?php echo $this->lang->line('quotation_date'); ?>:</label>
        <span>
            <?php 
                if(DEFAULT_DATEPICKER=='NP'){
                    echo $quotation_master[0]->quma_quotationdatebs;
                } else {
                    echo $quotation_master[0]->quma_quotationdatead;
                } 
            ?>
        </span>
    </div>
   
     <div class="col-md-3">
        <label><?php echo $this->lang->line('supplier_quotation_date'); ?>:</label>
          <span><?php if(DEFAULT_DATEPICKER=='NP'){
             echo $quotation_master[0]->quma_supplierquotationdatebs;
         } else {
            echo $quotation_master[0]->quma_supplierquotationdatead;
         } ?></span>
    </div>
      <div class="col-md-3">
        <label><?php echo $this->lang->line('quotation_no'); ?>:</label>
         <span><?php echo  !empty($quotation_master[0]->quma_quotationnumber)?$quotation_master[0]->quma_quotationnumber:''; ?></span>
    </div>
      <div class="col-md-3">
        <label><?php echo $this->lang->line('supplier_quotation_no'); ?>:</label>
         <span><?php echo  !empty($quotation_master[0]->quma_supplierquotationnumber)?$quotation_master[0]->quma_supplierquotationnumber:''; ?></span>
    </div>
    <div class="col-md-3">
        <label><?php echo $this->lang->line('valid_till'); ?>:</label>
       <span><?php if(DEFAULT_DATEPICKER=='NP'){
             echo $quotation_master[0]->quma_expdatebs;
         } else {
            echo $quotation_master[0]->quma_expdatead;
         } ?>
         </span>
    </div>
</div>
<!-- </div> -->
<div class="clearfix"></div> 
<div class="data-table">
    <?php if($quotation_detail_list) { ?>
        <table style="width:100%;" class="table dataTable con_ttl dt_alt purs_table">
            <thead>
                <tr>
                    <th width="5%"> <?php echo $this->lang->line('sn'); ?> </th>
                    <th width="10%"> <?php echo $this->lang->line('item_code'); ?> </th>
                    <th width="30%"> <?php echo $this->lang->line('item_name'); ?> </th>
                    <th width="5%"> <?php echo $this->lang->line('unit'); ?></th>
                    <th width="5%"> <?php echo $this->lang->line('qty'); ?></th>
                    <th width="10%"> <?php echo $this->lang->line('rate'); ?> </th>
                    <th width="10%"> <?php echo $this->lang->line('discount_percentage'); ?></th>
                    <th width="10%"> <?php echo $this->lang->line('vat'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('net_rate'); ?> </th>
                  
                </tr>
            </thead>
            <tbody>
              <?php foreach ($quotation_detail_list as $key => $value) { 
                if(ITEM_DISPLAY_TYPE=='NP'){
                  $quot_itemname = !empty($value->itli_itemnamenp)?$value->itli_itemnamenp:$value->itli_itemname;
                }else{ 
                    $quot_itemname = !empty($value->itli_itemname)?$value->itli_itemname:'';
                }?>
              <tr>
                <td><?php echo $key+1; ?></td>
                <td><?php echo $value->itli_itemcode ?></td>
                <td><?php echo $quot_itemname; ?></td>
                <td><?php echo $value->unit_unitname ?></td>
                <td><?php echo $value->qude_qty ?></td>
                <td><?php echo $value->qude_rate ?></td>
                <td><?php echo $value->qude_discountpc ?></td>
                <td><?php echo $value->qude_vatpc ?></td>
                <td><?php echo $value->qude_netrate ?></td>
              </tr>
              <?php } ?>

              <tr class="table-footer">
             
                <td colspan="8">
                        <span style="float: right">
                        <label><?php echo $this->lang->line('sub_total'); ?></label>
                        </span>
                    </td>
                    <td colspan="2">
                      <?php echo number_format($quotation_master[0]->quma_amount,2)?>
                    </td>

              </tr>
                <tr class="table-footer">
             
                <td colspan="8">
                        <span style="float: right">
                        <label><?php echo $this->lang->line('discount'); ?></label>
                        </span>
                    </td>
                    <td colspan="2">
                      <?php echo number_format($quotation_master[0]->quma_discount,2)?>
                    </td>

              </tr>
                <tr class="table-footer">
             
                <td colspan="8">
                        <span style="float: right">
                        <label><?php echo $this->lang->line('tax'); ?></label>
                        </span>
                    </td>
                    <td colspan="2">
                      <?php echo number_format($quotation_master[0]->quma_vat,2)?>
                    </td>

              </tr>
              <tr class="table-footer">
             
                <td colspan="8">
                        <span style="float: right">
                        <label><?php echo $this->lang->line('grand_total'); ?></label>
                        </span>
                    </td>
                    <td colspan="2">
                      <?php echo number_format($quotation_master[0]->quma_totalamount,2)?>
                    </td>

              </tr>
            </tbody>
          </table>
          <div class="form-group">
              <div class="col-md-12 col-sm-12">
                  <label for="quma_remarks"><?php echo $this->lang->line('remarks'); ?>:</label>
                 <span>
                   <?php echo !empty($quotation_master[0]->quma_remarks)?$quotation_master[0]->quma_remarks:''; ?>
                 </span>
              </div>
          </div>
    <?php } ?>
    </div>
<div class="clearfix"></div>

<div class="form-group">
	<form method="post" id="formChangeStatus" action="<?php echo base_url('purchase_receive/quotation_details/approved_status'); ?>" class="form-material form-horizontal form">
    	<input type="hidden" name="id" value="<?php echo !empty($quotation_detail_list[0]->qude_quotationdetailid)?$quotation_detail_list[0]->qude_quotationdetailid:'';?>">
		<?php 
            $approved_status = !empty($quotation_detail_list[0]->qude_approvestatus)?$quotation_detail_list[0]->qude_approvestatus:''; 
            
            if($approved_status != "FA"):
                if($approved_status == "A") { ?>
        		    <div class="col-md-3">
                        <label for="Supplier"><?php echo $this->lang->line('select_option'); ?> : </label> 
                        <select  class="form-control dateSearch" name="status">
                            <option value="FA">Final Approve</option>
                            <option value="C">Cancel</option>
                        </select>
                    </div>
                    
                    <div class="col-md-9" id="remarksUndo" style="display: none;">
                    	<label for="Supplier"><?php echo $this->lang->line('remarks_for_cancel'); ?></label> 
                    	<textarea name="remarks" cols="30" rows="4" class="form-control"></textarea>
                    </div>
    		<?php 
                }else{ 
            ?>
                <div class="col-md-3 col-sm-6">
                    <label for="radio1"><?php echo $this->lang->line('approve_status'); ?></label>
                    <input type="radio" name="status" id="radio1" value="A">
                </div>
    		<?php } ?>
            
            <div class="clearfix"></div>
            <div class="col-md-12">
                <div class="row">
               	    <label for="">&nbsp;</label>
                    <button type="submit" class="btn btn-info  savelist modalbtn" data-operation='<?php echo !empty($quotation_data)?'update':'save' ?>' id="btnSubmit" data-isdismiss="Y"  data-isrefresh="Y"><?php echo !empty($quotation_data)?'Update':'Approve' ?></button>
                </div>
        	</div>
    	    
            <div class="col-sm-12">
    	        <div  class="alert-success success"></div>
    	        <div class="alert-danger error"></div>
    	    </div>
        <?php else:?>
            <div class="col-sm-12">
                <div class="alert alert-info"><?php echo $this->lang->line('quotation_already_verified'); ?></div>
            </div>
        <?php endif; ?>
    </form>
</div>

<script>
	$(document).off('change','.dateSearch');
 	$(document).on('change','.dateSearch',function(){
   	 	var utype=$(this).val(); 
   	 	if(utype== "C")
   	 	{
   	 		$('#remarksUndo').show();
   	 		$('#formChangeStatus').addClass('remarksStatus');

   	 	}else{
   	 		$('#remarksUndo').hide();
   	 		$('#formChangeStatus').removeClass('remarksStatus');
   	 	}
   	})
</script>