<div class="row wb_form">
    <div class="col-sm-6">
        <div class="white-box">
            <h3 class="box-title"><?php echo $this->lang->line('equipment_information'); ?></h3>
            <div id="FormDiv_equipments" class="formdiv frm_bdy">
            <?php $this->load->view('equipment_lists/v_equipment_listsform') ;?>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
     <div class="white-box">
        <input type="hidden" id="ListUrl" value="<?php echo $listurl; ?>" >
   <div id="TableDiv">
 <?php  $this->load->view('equipment_lists/v_equipment_lists_list') ?>
 </div>

          
        </div>
    </div>
</div>
</div>
</div>
