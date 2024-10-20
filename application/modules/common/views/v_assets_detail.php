<div class="search_pm_data">
    <ul class="pm_data pm_data_body">
     <li>
        <label><?php echo $this->lang->line('assets_code'); ?></label>
        <?php echo !empty($eqli_data[0]->asen_assetcode)?$eqli_data[0]->asen_assetcode:'';?>
    </li>

    <li>
        <input type="hidden" name="amta_equipid" value="<?php echo !empty($eqli_data[0]->asen_asenid)?$eqli_data[0]->asen_asenid:'';?>">
        <label><?php echo $this->lang->line('description'); ?></label>
        <?php echo !empty($eqli_data[0]->itli_itemname)?$eqli_data[0]->itli_itemname:'';?>
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
        <label><?php echo $this->lang->line('department'); ?></label>
        <?php echo !empty($eqli_data[0]->dept_depname)?$eqli_data[0]->dept_depname:'';?>
    </li>

     <li>
        <label><?php echo $this->lang->line('brand'); ?></label>
        <?php echo !empty($eqli_data[0]->asen_brand)?$eqli_data[0]->asen_brand:'';?>
    </li>

     <li>
        <label><?php echo $this->lang->line('type'); ?></label>
        <?php 
        echo  !empty($eqli_data[0]->eqca_category)?$eqli_data[0]->eqca_category:'';
        
        ?>
    </li>

    <li>
        <label><?php echo $this->lang->line('status'); ?></label>
        <?php echo !empty($eqli_data[0]->asst_statusname)?$eqli_data[0]->asst_statusname:'';?>
    </li>

    <li>
        <label><?php echo $this->lang->line('condition'); ?></label>
        <?php echo !empty($eqli_data[0]->asco_conditionname)?$eqli_data[0]->asco_conditionname:'';?>
    </li>

     <li>
        <label><?php echo $this->lang->line('manufacturer'); ?></label>
        <?php echo !empty($eqli_data[0]->manu_manlst)?$eqli_data[0]->manu_manlst:'';?>
    </li>

     <li>
        <label><?php echo $this->lang->line('distributor'); ?></label>
        <?php echo !empty($eqli_data[0]->dist_distributor)?$eqli_data[0]->dist_distributor:'';?>
    </li>
     <li>
        <label><?php echo $this->lang->line('amc'); ?></label>
        <?php echo !empty($eqli_data[0]->asen_amc)?$eqli_data[0]->asen_amc:'';?>
    </li>
     <li>
        <label><?php echo $this->lang->line('service'); ?> <?php echo $this->lang->line('start_date'); ?></label>
        
<?php echo !empty($eqli_data[0]->asen_inservicedatead)?$eqli_data[0]->asen_inservicedatead:''; ?>(AD)/
   <?php echo !empty($eqli_data[0]->asen_inservicedatebs)?$eqli_data[0]->asen_inservicedatebs:''; ?>(BS)    

        
    </li>
    <li>
        <label><?php echo $this->lang->line('warrenty'); ?> <?php echo $this->lang->line('end_date'); ?></label>
        <?php echo !empty($eqli_data[0]->asen_warrentydatead)?$eqli_data[0]->asen_warrentydatead:'';?>(AD)/
         <?php echo !empty($eqli_data[0]->asen_warrentydatebs)?$eqli_data[0]->asen_warrentydatebs:''; ?>(BS)    
    </li>
   <li>
        <label><?php echo $this->lang->line('expected_life'); ?></label>
        <?php echo !empty($eqli_data[0]->asen_expectedlife)?$eqli_data[0]->asen_expectedlife:'';?>
    </li>
   
    <li>
        <label> <?php echo $this->lang->line('notes'); ?></label>
        <?php echo !empty($eqli_data[0]->asen_notes)?$eqli_data[0]->asen_notes:'';?>
    </li>

   
    
</ul>
</div>
