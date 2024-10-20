<div class="searchWrapper">
    <div class="pad-5">
        <form id="asset_lease_form">  
            <div class="form-group">
            <div class="row">
            <div class="col-md-2">
                <label>Is Lease Access:</label>
                <select name="islease" id="islease" class="form-control">
                    <option value="Y">Yes</option>
                    <option value="N">No</option>
                </select> 
            </div> 
            <div class="col-md-2">
                <label> Lease Company:</label>
                <select name="lease_company" class="form-control select2" id="lease_company">
                <option value="">All</option>
                <?php
                    if($lease_company):
                        foreach ($lease_company as $ks => $mat):
                            ?>
                            <option value="<?php echo $mat->leco_leasecompanyid; ?>">
                                <?php echo $mat->leco_companyname; ?> 
                            </option>
                            <?php
                        endforeach;
                    endif;
                    ?>
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
            <div class="col-md-2">
                <label>Filter Type:</label>
            <select name="filter_type" id="filter_type" class="form-control">
                <option value="start">Start Date</option>
                <option value="end">End Date</option>
            </select>
            </div>
            <div id="datediv" >
                <div class="col-md-2">
                    <label>From Date:</label>
                    <input type="text" name="frmDate" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
                </div>
                <div class="col-md-2"> 
                    <label>To Date</label>
                    <input type="text" name="toDate" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
                </div>
            </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="ams/assets_report/search_lease" data-displayid="leaseReportDiv"><?php echo $this->lang->line('search'); ?></button> 
        </div>
        </div>
       </div>
    </form>
  </div> 
</div>
<div class="clearfix"></div> 
<div id="leaseReportDiv"></div>
