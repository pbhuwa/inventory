<form action="" method="post" id="UnRepairInformationForm" class="mbtm_10">
  <div class="row">
    <div class="col-md-2 col-sm-3 col-xs-3 mtop_5 ">
      <label for="example-text">Equipment ID: </label>
    </div>
    <div class="col-sm-4 col-sm-6 col-xs-6">
      <!-- <input type="text" id="id" name="equid" value="" class="form-control number" placeholder="Enter Equipment ID"> -->
       <input type="text" id="id" autocomplete="off" name="equid" value="" class="form-control searchText" placeholder="Enter Equipment ID" data-srchurl="<?php echo base_url(); ?>/biomedical/bio_medical_inventory/list_of_equipment_inv">
        <div class="DisplayBlock" id="DisplayBlock_id"></div>
    </div>
    <div class="col-md-4 col-sm-3 col-xs-3">
      <div>
        <button type="button" id="searchRepair" data-viewurl='<?php echo base_url('biomedical/unrepair_information/get_repair_information') ?>' class="btn btn-success btnEdit mtop_0" data-displaydiv='UnRepairInformationForm'>Search</button>
      </div>
    </div>
  </div>
</form>
 
        <div id="FormDiv_UnRepairInformationForm" class="search_pm_data">
          <div class="pm_data_body">
        </div>
    </div>
