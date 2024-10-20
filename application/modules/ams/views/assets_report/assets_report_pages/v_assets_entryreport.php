<div class="searchWrapper">
    <div class="pad-5">
        <form id="asset_search_form">
            <div class="form-group">
                <div class="row"> 
                <div class="col-md-2">
                    <label> Assets Category:</label>
                    <select name="asset_category" class="form-control" id="asset_category">
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
                <label> Department:</label>
                <select name="department" class="form-control select2" id="department">
                <option value="">All</option>
                <?php
                if($department_list):
                    foreach ($department_list as $ks => $dety):
                        ?>
                        <option value="<?php echo $dety->dept_depid; ?>">
                            <?php echo $dety->dept_depname; ?>
                            </option>
                        <?php
                    endforeach;
                endif;
                ?>
                </select>
                </div>

                <div class="col-md-2">
                    <label>Purchase Date</label>
                    <select class="form-control" name="purdatetype" id="purdatetype">
                        <option value="all">All</option>
                        <option value="range">Range</option>
                    </select>
                </div>
                <div class="col-md-1 purdatediv" style="display: none" >
                    <label>From</label>
                    <input type="text" name="fromdate" class="form-control  <?php echo DATEPICKER_CLASS; ?>" id="fromdate" value="<?php echo CURMONTH_DAY1; ?>" >
                </div>
                <div class="col-md-1 purdatediv" style="display: none">
                    <label>To</label>
                    <input type="text" name="todate" class="form-control  <?php echo DATEPICKER_CLASS; ?>" id="todate" value="<?php echo CURDATE_NP; ?>">
                </div>

                <div class="col-md-2">
                   <label><?php echo $this->lang->line('assets_status'); ?></label>
                   <select name="asset_status" class="form-control " id="asset_status">
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
               <select name="asset_condition" class="form-control " id="asen_condition">
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
            <label>Report Wise </label>
            <select name="wise_type" class="form-control" id="wise_type">
            <option value="department">Department</option>
            <option value="category">Category Wise</option>
            <option value="status">Status Wise</option>
            <option value="condition">Condition Wise</option>
            </select>
        </div> 
        <div class="col-md-2">
            <button type="submit" class="btn btn-info searchReport" style="margin-top: 18px;" data-url="ams/assets_report/search_assets"><?php echo $this->lang->line('search'); ?></button>
        </div>
        </div>
       </div>
    </form>
  </div>
</div>
<div class="clearfix"></div> 
<div id="displayReportDiv"></div>

<script type="text/javascript">
$(document).off('change','#purdatetype');
$(document).on('change','#purdatetype',function(e){
var ptype=$(this).val();
if(ptype=='range'){
    $('.purdatediv').show();
}else{
    $('.purdatediv').hide();
}
});
</script>