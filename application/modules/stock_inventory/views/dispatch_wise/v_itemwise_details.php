

<div class="searchWrapper">
<div class="row">
<form id="ItemWise" action="" class="form-material form-horizontal form">
  
      
      <?php echo $this->general->location_option(2,'locationid'); ?>

        <div class="col-md-3 col-sm-3 col-xs-12">
            <label for="example-text"><?php echo $this->lang->line('from_date'); ?>: </label>
            <input type="text" name="fromdate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Dispatch Date" value="<?php echo CURMONTH_DAY1;?>" id="fromdate">
            <span class="errmsg"></span>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12">
            <label for="example-text"><?php echo $this->lang->line('to_date'); ?> : </label>
            <input type="text" name="todate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Dispatch To" value="<?php echo DISPLAY_DATE;?>" id="todate">
            <span class="errmsg"></span>
        </div>
    <div class="col-md-2 col-sm-4 col-xs-12">
      <label for="example-text"><?php echo $this->lang->line('select_category'); ?> <span class="required">*</span>:</label>
      <select name="eqty_equipmenttypeid" class="form-control select2" id="store_id">
        <option value="">---All---</option>
        <?php
        if($equipmenttype):
        foreach ($equipmenttype as $km => $eq):
        ?>
        <option value="<?php echo $eq->eqty_equipmenttypeid; ?>"><?php echo $eq->eqty_equipmenttype; ?></option>
        <?php
        endforeach;
        endif;
        ?>
      </select>
    </div>
        <div class="col-md-2 col-sm-4 col-xs-12">
            
            <button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="stock_inventory/receive_analysis/item_wise_search"><?php echo $this->lang->line('search'); ?></button>
        </div>
    
 </div>
        
 </div>

  <div id="displayReportDiv"></div>  

</form>




</div><div class="clearfix"></div>
