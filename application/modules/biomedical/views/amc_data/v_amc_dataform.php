
<form action="" method="post" id="PmData" class="mbtm_10">
    <div class="row">
    <div class="col-md-2 col-sm-3 mtop_5 ">
        <?php if($org_id=='2'){ ?>
        <label for="example-text"><?php echo $this->lang->line('assets_id'); ?>:</label>
        <?php }else{ ?>
        <label for="example-text"><?php echo $this->lang->line('equipment_id'); ?>Equipment ID: </label>
        <?php } ?>
    </div>
    <div class="col-md-8 col-sm-6">
        <?php if($org_id=='2'){ ?>
        <input type="text" id="id" autocomplete="off" name="equid" value="" class="form-control searchText" placeholder="Enter Assets ID" data-srchurl="<?php echo base_url(); ?>/ams/assets/list_of_assets_inv">
        <?php }else{ ?>
        <input type="text" id="id" autocomplete="off" name="equid" value="" class="form-control searchText" placeholder="Enter Equipment ID" data-srchurl="<?php echo base_url(); ?>/biomedical/bio_medical_inventory/list_of_equipment_inv">
        <?php } ?>
        <div class="DisplayBlock" id="DisplayBlock_id"></div>

    </div>

         
    <!-- </div> -->
    <div class="col-md-2 col-sm-3">
        <div>
            <button type="button" id="searchPmdata" data-viewurl='<?php echo base_url('biomedical/amc_data/get_equdata') ?>' class="btn btn-success btnEdit mtop_0" data-displaydiv='PmData'>Search</button>
        </div>
    </div>
  </div>
</form>

<form method="post" id="Formpmdata" action="<?php echo base_url('biomedical/amc_data/save_amc_data'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('biomedical/amc_data/form_amc_data'); ?>'>
  <input type="hidden" name="id" value="<?php echo!empty($pmdata[0]->riva_riskid)?$pmdata[0]->riva_riskid:'';  ?>">

  <div class="clearfix"></div>
  <div class="clearfix"></div>
    <div class="">
        <div id="FormDiv_PmData" class="search_pm_data">
        </div>
    </div>

  <div class="clearfix"></div>


  <div  class="text-success success"></div>
 <div class="text-danger error"></div>
</form>

