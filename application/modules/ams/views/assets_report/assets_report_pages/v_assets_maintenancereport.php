<div class="searchWrapper">
  <div class="pad-5">
  <form id="asset_maintenance_form">
    <div class="form-group">
    <div class="row">                    
      <div class="col-md-2">
        <label> Maintenance Type:</label>
        <select name="maintenance_type" class="form-control " id="maintenance_type">
        <option value="">All</option>
        <option value="PM">PM</option>
        <option value="AMC">AMC</option>                      
        </select>
      </div>                                     

      <div class="col-md-2">
        <label> Frequency:</label>
        <select name="frequency" class="form-control select2" id="frequency">
        <option value="">All</option>
        <?php
        if($frequency):
        foreach ($frequency as $ks => $fr):
        ?>
        <option value="<?php echo $fr->frty_frtyid; ?>"><?php echo $fr->frty_name; ?></option>
        <?php
        endforeach;
        endif;
        ?>
        </select>
      </div>

      <div class="col-md-3">
        <label> PM Company:</label>
        <select name="pm_company" class="form-control select2" id="pm_company">
        <option value="">All</option>
        <?php
        if($distributors):
        foreach ($distributors as $ks => $dist):
        ?>
        <option value="<?php echo $dist->dist_distributorid; ?>"><?php echo $dist->dist_distributor; ?></option>
        <?php
        endforeach;
        endif;
        ?>
        </select>
      </div>  

      <div class="col-md-3">
        <label> Assets Entry:</label>
        <select name="asset_id" class="form-control select2" id="asset_id">
        <option value="">All</option>
        <?php
        if($assetentry_list):
        foreach ($assetentry_list as $ks => $al):
        ?>
        <option value="<?php echo $al->asen_assettypeid; ?>"><?php echo $al->asen_assetcode; ?></option>
        <?php
        endforeach;
        endif;
        ?>
        </select>
      </div>          
      <div class="col-md-2">
        <button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="ams/assets_report/search_maintenance" data-displayId="maintenanceReportDiv"><?php echo $this->lang->line('search'); ?></button>
      </div>
    </div>
    </div>
  </form>
  </div>
</div>
<div class="clearfix"></div>
<div id="maintenanceReportDiv"></div>
