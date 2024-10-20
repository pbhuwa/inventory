<form action="" method="post" id="PmData" class="mbtm_10">
    <div class="row">
    <div class="col-md-2 col-sm-3 mtop_5 ">
        <label for="example-text">Equipment ID: </label>
    </div>
    <div class="col-md-8 col-sm-6">
        <input type="text" id="id" autocomplete="off" name="equid" value="" class="form-control searchText" placeholder="Enter Equipment ID" data-srchurl="<?php echo base_url(); ?>/biomedical/bio_medical_inventory/list_of_equipment_inv">
        <div class="DisplayBlock" id="DisplayBlock_id"></div>

        </div>

    <div class="col-md-2 col-sm-3">
        <div>
            <button type="button" id="searchPmdata" data-viewurl='<?php echo base_url('biomedical/assign_equipement/get_equdata_handover') ?>' class="btn btn-success btnEdit mtop_0" data-displaydiv='PmData'>Search</button>
        </div>
    </div>
  </div>
</form>

<form method="post" id="Formpmdata" action="<?php echo base_url('biomedical/pm_data/save_pm_data'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('biomedical/pm_data/form_pm_data'); ?>'>
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