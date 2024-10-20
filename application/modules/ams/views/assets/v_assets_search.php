<?php $this->load->view('assets/v_assets_common');?>
<div class="white-box">
    <label class="dttable_ttl box-title"><center><?php echo $this->lang->line('assets_search'); ?></center></label></div>
    <div class="searchWrapper">
        <div class="pad-5">
            <form id="asset_search_form">

                <div class="form-group">

                    <div class="row">
                          <div class="col-md-2">
                            <label>Type:<span class="required"></span></label>
                            <select name="Datatype" class="form-control" id="Datatype">
                                <option value="">All</option>
                                <option value="N">Inventory Assets</option>
                                <option value="Y">Component</option>
                            </select>
                        </div>

                           <div class="col-md-2">
                           <label><?php echo $this->lang->line('assets_type'); ?></label>
                           <select name="asen_assettypeid" class="form-control" id="asen_assettypeid">
                            <option value="">All</option>
                            <?php
                            if($assets_type):
                                foreach ($assets_type as $ks => $type):
                                    ?>
                                    <option value="<?php echo $type->asty_astyid; ?>"><?php echo $type->asty_typename; ?></option>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>

                        <div class="col-md-2">
                            <label><?php echo $this->lang->line('date_selection'); ?>:<span class="required">*</span>:</label>
                            <select name="dateSearch" class="form-control required_field" name="dateSearch" id="dateSearch">
                                <option value="">All</option>
                                <option value="purchasedate">Purchase Date</option>
                                <option value="inservicedate">Inservice Date</option>
                                <option value="warrentydate">Warrenty Date</option>
                            </select>
                        </div>
                        <div id="datediv" style="display:none">
                            <div class="col-md-2">
                                <label><?php echo $this->lang->line('from_date'); ?></label>
                                <input type="text" name="frmDate" id="frmDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo CURMONTH_DAY1; ?>"/>
                            </div>

                            <div class="col-md-2">
                                <label><?php echo $this->lang->line('to_date'); ?></label>
                                <input type="text" naem="toDate" id="toDate" class="form-control <?php echo DATEPICKER_CLASS; ?>" value="<?php echo DISPLAY_DATE; ?>"/>
                            </div>
                        </div>
                        <div class="col-md-2">
                           <label><?php echo $this->lang->line('category'); ?></label>
                           <select name="asen_assettype" class="form-control select2" id="asen_assettype">
                            <option value="">All</option>
                            <?php
                            if($material):
                                foreach ($material as $ks => $mat):
                                    ?>
                                    <option value="<?php echo $mat->eqca_equipmentcategoryid; ?>"><?php echo $mat->eqca_category; ?></option>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                     <label><?php echo $this->lang->line('manufacture'); ?></label>
                     <select name="asen_manufacture" class="form-control select2" id="asen_manufacture">
                        <option value="">All</option>
                        <?php
                        if($manufacturers):
                            foreach ($manufacturers as $ks => $manu):
                                ?>
                                <option value="<?php echo $manu->manu_manlistid; ?>"><?php echo $manu->manu_manlst; ?></option>
                                <?php
                            endforeach;
                        endif;
                        ?>
                     </select>
                 </div>

                <div class="col-md-2">
                   <label><?php echo $this->lang->line('assets_status'); ?></label>
                   <select name="asen_status" class="form-control select2" id="asen_status">
                    <option value="">All</option>
                    <?php
                    if($status):
                        foreach ($status as $ks => $stat):
                            ?>
                            <option value="<?php echo $stat->asst_asstid; ?>"><?php echo $stat->asst_statusname; ?></option>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </select>
            </div>


            <div class="col-md-2">
               <label><?php echo $this->lang->line('assets_condition'); ?></label>
               <select name="asen_condition" class="form-control select2" id="asen_condition">
                <option value="">All</option>
                <?php
                if($condition):
                    foreach ($condition as $ks => $cond):
                        ?>
                        <option value="<?php echo $cond->asco_ascoid; ?>"><?php echo $cond->asco_conditionname; ?></option>
                        <?php
                    endforeach;
                endif;
                ?>
            </select>
        </div>

        <div class="col-md-2">
           <label><?php echo $this->lang->line('depreciation_method'); ?></label>
           <select name="asen_depreciation" class="form-control select2" id="asen_depreciation">
            <option value="">All</option>
            <?php
            if($depreciation):
                foreach ($depreciation as $ks => $dep):
                    ?>
                    <option value="<?php echo $dep->dety_depreciationid; ?>"><?php echo $dep->dety_depreciation; ?></option>
                    <?php
                endforeach;
            endif;
            ?>
        </select>
    </div>


    <div class="col-md-2">
        <button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="ams/assets/search_assets"><?php echo $this->lang->line('search'); ?></button>
    </div>
</div>
</div>
</form>
</div>
</div>
<div class="clearfix"></div>

<div id="displayReportDiv"></div>
</div>
</div>
</div>
</div>
<script type="text/javascript">
  $(document).on('change', '#dateSearch', function() {
     var dateSearch = $('#dateSearch').val();
     if(dateSearch!=''){
      $('#datediv').show();

  }else{
    $('#datediv').hide();
}
});
</script>
