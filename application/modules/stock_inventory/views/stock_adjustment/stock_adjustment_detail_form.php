 <style>
        .purs_table tbody tr td{
            border: none;
            vertical-align: center;
        }
    </style>
   <!--  data-reloadurl='<?php //echo base_url('stock_inventory/stock_adjustment/formchange_stock/'.$masterid);?>' -->
        <div  id="FormDiv_item" class="formdiv frm_bdy">
           <form method="post" id="FormStockAdjustmentDetails" action="<?php echo base_url('stock_inventory/stock_adjustment/save_details'); ?>"  class="form-material form-horizontal form">
            <input type="hidden" name="stde_stockmasterid" value="<?php echo $masterid; ?>" id="stde_stockmasterid">
                <div class="form-group">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <label for="example-text"><?php echo $this->lang->line('date'); ?> : </label>
                        <input type="text" name="adjustdate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Dispatch Date" value="<?php echo DISPLAY_DATE;?>" id="adjustdate">
                        <span class="errmsg"></span>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <label for="example-text"><?php echo $this->lang->line('physical_stock'); ?> <span class="required">*</span>:</label>
                        <input type="text" class="form-control required_field" name="physical_stock"  value="" placeholder="Physical Stock">
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <label for="example-text"><?php echo $this->lang->line('book_stock'); ?> <span class="required">*</span>:</label>
                        <input type="text" class="form-control required_field" name="bookstock"  value="" placeholder="Book Stock" id="itemstock_1">
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <label for="example-text"><?php echo $this->lang->line('enter_by'); ?> <span class="required">*</span>:</label>
                        <input type="text" class="form-control required_field" name="stock"  value="" placeholder="Enter By">
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <label for="example-text"><?php echo $this->lang->line('reason'); ?> :</label>
                        <input type="text" class="form-control" name="reason"  value="" placeholder="Enter Reason">
                    </div>
                    <div class="col-md-4 col-sm-3 col-xs-12">
                        <label for="example-text"><?php echo $this->lang->line('expiry_date'); ?> : </label>
                        <input type="text" name="expire" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Dispatch To" value="<?php echo DISPLAY_DATE;?>" id="expiredate">
                        <span class="errmsg"></span>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <label for="example-text"><?php echo $this->lang->line('select_items'); ?> </label>
                        <div class="dis_tab"> 
                            <input type="text" class="form-control itemcode enterinput " id="itemname_1" name="itemid"  data-id='1' data-targetbtn='view'>
                            <input type="hidden" class="item" name="item" data-id='1' value="" id="itemid_1">
                            <a href="javascript:void(0)" class="btn btn-sm btn-default table-cell width_30 view" data-heading='Item List' data-viewurl='<?php echo base_url('stock_inventory/item/list_item_with_stock'); ?>' data-id='1' id="view"><strong>...</strong></a>
                        </div> 
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <label for="example-text"><?php echo $this->lang->line('adjustment_amount'); ?> <span class="required">*</span>:</label>
                        <input type="text" class="form-control required_field number" name="amount"  value="" placeholder="Adjustment Amt">
                    </div>
                    <div class="col-md-12 " style="margin-top:.5rem">
                        <?php 

                        $save_var=$this->lang->line('save'); 
                        $update_var=$this->lang->line('update'); 

                        ?>
                        <button type="submit" class="btn btn-info  save" data-operation='<?php echo !empty($item_data)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($item_data)?$update_var:$save_var ?></button>
                    </div>
                      <div class="col-sm-12">
                        <div  class="alert-success success"></div>
                        <div class="alert-danger error"></div>
                      </div>
                </div>
            </form>
        </div>


<script type="text/javascript">
    $(document).on('click','.itemDetail',function(){
        var rowno=$(this).data('rowno');
        var itemname=$(this).data('itemname');
        var itemid=$(this).data('itemid');
    var itemname_display=$(this).data('itemname_display');

        var stockqty=$(this).data('stockqty');
        
        $('#itemid_'+rowno).val(itemid);
        // $('#itemname_'+rowno).val(itemname);
    $('#itemname_'+rowno).val(itemname_display);
        
        $('#itemstock_'+rowno).val(stockqty);
            $('#myView').modal('hide');
            $('#itemqty_'+rowno).focus();
    })
</script>




