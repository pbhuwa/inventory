 
  
<div class="searchWrapper" style="padding-left: 10px;">
  <div class="row">
  <div class="col-md-12">
   
  <form id="FormMaintenancelog" action="" class="form-material form-horizontal form">
  <div class="form-group">
          
          
    <div class="col-md-2 col-sm-4 col-xs-12">
      <label for="example-text"><?php echo $this->lang->line('from_date'); ?>: </label>
      <input type="text" name="fromdate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Dispatch Date" value="<?php echo CURMONTH_DAY1;?>" id="fromdate" autocomplete="off">
      <span class="errmsg"></span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-12">
      <label for="example-text"><?php echo $this->lang->line('to_date'); ?>: </label>
      <input type="text" name="todate" class="form-control <?php echo DATEPICKER_CLASS; ?> date"  placeholder="Dispatch To" value="<?php echo DISPLAY_DATE;?>" id="todate" autocomplete="off">
      <span class="errmsg"></span>
    </div>
    
    <div class="col-md-2 col-sm-4 col-xs-12">
      
      <button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="biomedical/maintenance_log/search_mlog"><?php echo $this->lang->line('search'); ?></button>
    </div>
    
  </div>
</form>
</div>
<div class="clearfix"></div>
        <div id="displayReportDiv"></div>

  </div>
</div>