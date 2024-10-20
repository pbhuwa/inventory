<div class="search_pm_data">
    <ul class="pm_data pm_data_body">
     <li>
        <label><?php echo $this->lang->line('equipment_code'); ?></label>
        <?php echo !empty($eqli_data[0]->bmin_equipmentkey)?$eqli_data[0]->bmin_equipmentkey:'';?>
    </li>

    <li>
        <input type="hidden" name="pmta_equipid" value="<?php echo !empty($eqli_data[0]->bmin_equipid)?$eqli_data[0]->bmin_equipid:'';?>">
        <label><?php echo $this->lang->line('description'); ?></label>
        <?php echo !empty($eqli_data[0]->eqli_description)?$eqli_data[0]->eqli_description:'';?>
    </li>
    <li>
        <label><?php echo $this->lang->line('model_no'); ?></label>
        <?php echo !empty($eqli_data[0]->bmin_modelno)?$eqli_data[0]->bmin_modelno:'';?>
    </li>
    <li>
        <label><?php echo $this->lang->line('serial_no'); ?></label>
        <?php echo !empty($eqli_data[0]->bmin_serialno)?$eqli_data[0]->bmin_serialno:'';?>
    </li>
    
     <li>
        <label><?php echo $this->lang->line('department'); ?></label>
        <?php echo !empty($eqli_data[0]->dein_department)?$eqli_data[0]->dein_department:'';?>
    </li>

     <li>
        <label><?php echo $this->lang->line('room'); ?></label>
        <?php echo !empty($eqli_data[0]->rode_roomname)?$eqli_data[0]->rode_roomname:'';?>
    </li>

     <li>
        <label><?php echo $this->lang->line('equipment'); ?> <?php echo $this->lang->line('operation'); ?></label>
        <?php 
        $eqopr= !empty($eqli_data[0]->bmin_equip_oper)?$eqli_data[0]->bmin_equip_oper:'';
        if($eqopr=='Yes'):
            ?>
            <label class="label label-success">Yes</label>
            <?php
        endif;
        if($eqopr=='No'):
            ?>
             <label class="label label-danger">No</label>
            <?php 
        endif;
        ?>
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
        <?php echo !empty($eqli_data[0]->bmin_amc)?$eqli_data[0]->bmin_amc:'';?>
    </li>
     <li>
       <label><?php echo $this->lang->line('service'); ?> <?php echo $this->lang->line('start_date'); ?></label>
        
<?php echo !empty($eqli_data[0]->bmin_servicedatead)?$eqli_data[0]->bmin_servicedatead:''; ?>(AD)/
   <?php echo !empty($eqli_data[0]->bmin_servicedatebs)?$eqli_data[0]->bmin_servicedatebs:''; ?>(BS)    

        
    </li>
    <li>
        <label><?php echo $this->lang->line('warrenty'); ?> <?php echo $this->lang->line('end_date'); ?></label>
        <?php echo !empty($eqli_data[0]->bmin_endwarrantydatead)?$eqli_data[0]->bmin_endwarrantydatead:'';?>(AD)/
         <?php echo !empty($eqli_data[0]->bmin_endwarrantydatebs)?$eqli_data[0]->bmin_endwarrantydatebs:''; ?>(BS)    
    </li>
   <li>
       <label><?php echo $this->lang->line('risk');?> <?php echo $this->lang->line('value'); ?></label>
        <?php echo !empty($eqli_data[0]->riva_risk)?$eqli_data[0]->riva_risk:'';?>
    </li>
   
    
     <li>
        <label><?php echo $this->lang->line('repairable_condition'); ?></label>
        <?php 
        $isunreap= !empty($eqli_data[0]->bmin_isunrepairable)?$eqli_data[0]->bmin_isunrepairable:'';
        if($isunreap=='Y'):
        ?>
        <label class="label label-danger" >Unrepairable</label>
        <?php
        endif;
        if($isunreap=='N'):
        ?>
        <label class="label label-success" >Repairable</label>
        <?php
        endif;
        ?>
    </li>
    <li>
        <label> <?php echo $this->lang->line('accessories'); ?></label>
        <?php echo !empty($eqli_data[0]->bmin_accessories)?$eqli_data[0]->bmin_accessories:'';?>
    </li>
    <li>
        <label><?php echo $this->lang->line('comments'); ?> </label>
        <?php echo !empty($eqli_data[0]->bmin_comments)?$eqli_data[0]->bmin_comments:'';?>
    </li>

   
    
</ul>
</div>
