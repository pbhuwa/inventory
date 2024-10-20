
<div class="searchWrapper">
  <div class="pad-5">
    <form id="asset_disposal_form">
      <div class="form-group"> 
        <div class="row"> 
          <div class="col-md-2">
           <label>Disposal Type:</label>
           <select name="disposal_type" class="form-control select2" id="disposal_type">
              <option value="">All</option>
               <?php
                if($desposal):
                    foreach ($desposal as $ks => $de):
                        ?>
                        <option value="<?php echo $de->dety_detyid; ?>"><?php echo $de->dety_name; ?></option>
                        <?php
                    endforeach;
                endif;
                ?>
           </select>
          </div>
             <div class="col-md-1">
                <label for="range">Range</label>
                <select name="range" id="range" class="form-control">
                    <option value="all">All</option>
                    <option value="range">Range</option>
                </select>    
            </div> 
              <div id="date_range"  style="display: none">
                <div class="col-md-1">
                    <label>From Date:</label>
                    <input type="text" name="from_date" id="des_from_date" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
                </div>

                <div class="col-md-1">
                    <label>To Date</label>
                    <input type="text" name="to_date" id="des_to_date" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
                </div>
            </div>
          <div class="col-md-2">
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
              <label for="search_text">Search</label>
              <input type="text" name="search_text" id="search_text" placeHolder="Search Customer|Manual No.|Disposal No" class="form-control">
            </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="ams/assets_report/search_disposal" data-displayid="disposalReportDiv"><?php echo $this->lang->line('search'); ?></button> 
        </div>
       
        </div>
      
       </div>
    </form>
  </div>
</div>
<div class="clearfix"></div> 
<div id="disposalReportDiv"></div>

<script>
  $(document).off('change','#range');
    $(document).on('change','#range',function() {
        let value = $(this).val();
        if(value == 'range'){
            $('#date_range').show();
        }else{
            $('#date_range').hide();
        }
    });
</script>
