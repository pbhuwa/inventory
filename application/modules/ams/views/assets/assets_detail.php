
<div class="search_pm_data">
    <ul class="pm_data pm_data_body">
     <li>
        <label><?php echo $this->lang->line('assets_code'); ?></label>
        <?php echo !empty($eqli_data[0]->asen_assetcode)?$eqli_data[0]->asen_assetcode:'';?>
    </li>

    <li>
        <input type="hidden" name="pmta_equipid" value="<?php echo !empty($eqli_data[0]->asen_asenid)?$eqli_data[0]->asen_asenid:'';?>">
        <label><?php echo $this->lang->line('description'); ?></label>
        <?php echo !empty($eqli_data[0]->asen_description)?$eqli_data[0]->asen_description:'';?>
    </li>
    <li>
        <label><?php echo $this->lang->line('model_no'); ?></label>
        <?php echo !empty($eqli_data[0]->asen_modelno)?$eqli_data[0]->asen_modelno:'';?>
    </li>
    <li>
        <label><?php echo $this->lang->line('serial_no'); ?></label>
        <?php echo !empty($eqli_data[0]->asen_serialno)?$eqli_data[0]->asen_serialno:'';?>
    </li>
    

     <li>
        <label><?php echo $this->lang->line('assets_status'); ?></label>
        <?php echo !empty($eqli_data[0]->asst_statusname)?$eqli_data[0]->asst_statusname:'';?>
    </li>

     <li>
        <label><?php echo $this->lang->line('assets_condition'); ?></label>
        <?php echo !empty($eqli_data[0]->asco_conditionname)?$eqli_data[0]->asco_conditionname:'';?>
    </li>
</ul>
</div>
