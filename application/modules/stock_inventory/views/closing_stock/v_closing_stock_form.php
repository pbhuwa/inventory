 <style>
    .purs_table tbody tr td{
        border: none;
        vertical-align: center;
    }
    .marginto17{
      margin-top: 17px !important;
    }
</style>
<form method="post" id="FormStockRequisition" action="<?php echo base_url('stock_inventory/closing_stock/save_genreating_stock'); ?>" class="form-material form-horizontal form" >
        <div id="requisition">
        <div class="form-group">
            <div class="col-md-3">
                <label for="example-text"><?php echo $this->lang->line('store'); ?><span class="required">*</span>:</label>
                <?php $store=!empty($depart)?$depart:''; ?>
                <select name="store" class="form-control required_field" id="frmstore" >
                  <option value="">---All---</option>
                  <?php
                    if($equipmnt_type): 
                    foreach ($equipmnt_type as $ket => $etype):
                  ?>
                    <option value="<?php echo $etype->eqty_equipmenttypeid; ?>"><?php echo $etype->eqty_equipmenttype; ?></option>
                 <?php endforeach; endif; ?>
                </select>
            </div> 
            <div class="col-md-3">
              <label for="example-text"><?php echo $this->lang->line('from_date'); ?><span class="required">*</span>: </label>
              <input type="text" name="fromdate" class="form-control required_field <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Dispatch Date" value="<?php echo !empty($equip_data[0]->trma_dispatch_date)?$equip_data[0]->trma_dispatch_date:DISPLAY_DATE; ?>" id="Fromdate">
              <span class="errmsg"></span>
            </div>
            <div class="col-md-3">
              <label for="example-text"><?php echo $this->lang->line('to_date'); ?><span class="required">*</span>: </label>
              <input type="text" name="todate" class="form-control required_field <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Dispatch Date" value="<?php echo !empty($equip_data[0]->trma_dispatch_date)?$equip_data[0]->trma_dispatch_date:DISPLAY_DATE; ?>" id="toDate">
              <span class="errmsg"></span>
            </div>
            <div class="col-md-2">
              <label for="">&nbsp;</label>
                <button type="submit" class="btn btn-info  save marginto17" accesskey="n" data-operation='<?php echo !empty($item_data)?'update':'save' ?>' id="btnSubmit" ><?php echo !empty($item_data)?'Update':'Generate' ?></button>
            </div>
            <div  class="alert-success success"></div>
            <div class="alert-danger error"></div>
        </div>
      </div>
</form>
       
