
<div class="searchWrapper">
        <form id="FormreqAnalysis"  action="<?php echo base_url('stock_inventory/current_stock/current_stock_search');?>" method="post">
            <div class="row">
            <div class="col-sm-12">
              <?php echo $this->general->location_option(2,'locationid'); ?>
                <div id="transferData"></div>
                
        <div class="col-md-2 col-sm-4 col-xs-12">
            <label for="example-text"><?php echo $this->lang->line('store'); ?><span class="required">*</span>:</label>
            <select name="store_id" class="form-control select2" id="store_id">
                <option value="">---All---</option>
                <?php
                if($store):
                foreach ($store as $km => $st):
                ?>
                <option value="<?php echo $st->eqty_equipmenttypeid; ?>"><?php echo $st->eqty_equipmenttype; ?></option>
                <?php
                endforeach;
                endif;
                ?>
            </select>
        </div>
        <div class="col-md-2">
            <label for="example-text"><?php echo $this->lang->line('category'); ?><span class="required">*</span>:</label>
            <select name="catid" class="form-control select2" id="catid">
                <option value="">---All---</option>
                <?php
                if($materialstypecategory):
                foreach ($materialstypecategory as $km => $mt):
                ?>
                <option value="<?php echo $mt->eqca_equipmentcategoryid; ?>"><?php echo $mt->eqca_category; ?></option>
                <?php
                endforeach;
                endif;
                ?>
            </select>
        </div>

         <div class="col-md-3">

                <label for="example-text">Choose Material Type   : </label><br>

                <select name="mattypeid" id="mattypeid" class="form-control chooseMatType required_field">

                 <?php 

                 if(!empty($material_type)):

                    foreach($material_type as $mat):

                 ?>

                 <option value="<?php echo $mat->maty_materialtypeid; ?>" >  <?php echo $mat->maty_material; ?></option>

                 <?php

                    endforeach;

                 endif;

                 ?>

                </select>

            </div>

        <div class="col-md-2">
                <label><?php echo $this->lang->line('date_search'); ?> :</label>
                <select name="searchDateType" id="searchDateType" class="form-control">
                    <option value="date_range">By Date Range</option>
                    <option value="date_all">All</option>
                </select>
            </div>

         <div class="dateRangeWrapper">
         <div class="col-md-2">
                <label><?php echo $this->lang->line('from_date'); ?></label>
                <input type="text" name="fromdate" id="fromdate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
            </div>
            <div class="col-md-2">
                <label><?php echo $this->lang->line('to_date'); ?></label>
                <input type="text"  name="todate" id="todate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
            </div>
            </div>
            <div class="col-md-2">
                <label>Report :</label>
                <select name="report_type" id="report_type" class="form-control">
                    <option value="old">Old</option>
                    <option value="new">New</option>
                </select>
            </div>
                
                <div class="col-md-2">
                    <button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="stock_inventory/current_stock/current_stock_search"><?php echo $this->lang->line('search'); ?></button>
                </div>
                
           </div>
       </div>
        </form> 
    </div>

<div class="clearfix"></div>
 <div id="displayReportDiv"></div>

 <script type="text/javascript">

 $(document).off('click','#searchByDate')
    $(document).on('click','#searchByDate',function(){
        frmDate=$('#frmDate').val();
        toDate=$('#toDate').val();
        fiscalyear=$('#fiscalyear').val();
        locationid=$('#locationid').val();
        type=$('#searchByType').val(); 
        dtablelist.fnDraw();
    });

        $(document).off('change', '#searchDateType');
       $(document).on('change', '#searchDateType', function() {
        var search_date_val = $(this).val();

        if (search_date_val == 'date_all') {
            $('.dateRangeWrapper').hide();
        } else {
            $('.dateRangeWrapper').show();
        }
    });

</script>
