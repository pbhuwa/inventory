    <div class="searchWrapper">
        <div class="pad-5">
            <form id="insurance_search_form">

                <div class="form-group">

                    <div class="row">
                        
	                    <div class="col-md-3">
	                     <label> Insurance Company:</label>
	                     <select name="insurance_company" class="form-control select2" id="insurance_company">
	                        <option value="">All</option>
                          <?php
                            if($insurance_company):
                                foreach ($insurance_company as $ks => $in):
                                    ?>
                                    <option value="<?php echo $in->inco_id; ?>">
                                      <?php echo $in->inco_name; ?>
                                        
                                      </option>
                                    <?php
                                endforeach;
                            endif;
                            ?>
	                     </select>
	                    </div>
                        
                         <div id="datediv" >
                            <div class="col-md-3">
                                <label>From Date:</label>
                                <input type="text" name="from_date" id="from_date" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
                            </div>

                            <div class="col-md-3">
                                <label>To Date</label>
                                <input type="text" name="to_date" id="to_date" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
                            </div>
                        </div>

                    <div class="col-md-3">
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
            <button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="ams/assets_report/search_insurance" data-displayid="insuranceReportDiv"><?php echo $this->lang->line('search'); ?></button>
        </div>
        </div>
       </div>
    </form>
  </div>
</div>
<div class="clearfix"></div> 
<div id="insuranceReportDiv"></div>
