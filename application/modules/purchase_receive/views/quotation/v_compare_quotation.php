
<div class="searchWrapper">
        <form id="FormreqAnalysis"  action="<?php echo base_url('stock_inventory/current_stock/current_stock_search');?>" method="post">
            <input type="hidden" name="type" value="<?php echo $type ?>">
            <div class="row">
            <div class="col-sm-12">
              <?php echo $this->general->location_option(2,'locationid'); ?>
                <div id="transferData"></div>
                 <div class="col-md-2">
                    <label for="example-text"><?php echo $this->lang->line('fiscal_year'); ?><span class="required">*</span>:</label>
                    <select name="fiscalyear" class="form-control select2" id="fiscalyear" >
                        <option value="">---select---</option>
                            <?php
                                if($fiscal):
                                    foreach ($fiscal as $km => $fy):
                            ?>
                        <option value="<?php echo $fy->fiye_name; ?>" <?php if($fy->fiye_status=='I') echo "selected=selected"; ?>><?php echo $fy->fiye_name; ?></option>
                            <?php
                                    endforeach;
                                endif;
                            ?>
                    </select>
                 </div>
                
        <div class="col-md-2">
            <label for="example-text"><?php echo $this->lang->line('requisition_no'); ?><span class="required">*</span>:</label>
           <input type="text" name="req_no" class="form-control number enterinput required_field" placeholder="Enter Requistion Number" value="" id="requisitionNumber" data-targetbtn="searchReport">
        </div>
                
                <div class="col-md-2">
                    <button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="purchase_receive/quotation/quotation_comparitive_search" id="searchReport"><?php echo $this->lang->line('search'); ?></button>
                </div>
                
           </div>
       </div>
        </form> 
    </div>

<div class="clearfix"></div>
 <div id="displayReportDiv"></div>

