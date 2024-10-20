<form action="" method="post" id="UnRepairInformationForm" class="mbtm_10">
  <div class="row">
    <div class="col-md-2 mtop_5 ">
      <label for="example-text">Equipment ID: </label>
    </div>
    <div class="col-sm-4">
      <input type="text" id="id" name="equid" value="" class="form-control number" placeholder="Enter Equipment ID">
    </div>
    <div class="col-md-4">
      <div>
        <button type="button" id="searchRepair" data-viewurl='<?php echo base_url('biomedical/unrepair_information/get_repair_information') ?>' class="btn btn-success btnEdit mtop_0" data-displaydiv='UnRepairInformationForm'>Search</button>
      </div>
    </div>
  </div>
</form>
<form method="post" id="FormunrepairInformation" action="<?php echo base_url('biomedical/unrepair_information/save_unrepair_information'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('biomedical/repair_information/form_repair_information'); ?>'>
    <input type="hidden" name="id" value="<?php echo!empty($repair_data[0]->rere_repairrequestid)?$repair_data[0]->rere_repairrequestid:'';  ?>">
    <div class="clearfix"></div>
    <div class="pm_data_body">
        <div id="FormDiv_UnRepairInformationForm" class="search_pm_data">
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <label>Reson For Disconnect</label>
            <textarea style="width: 100%" name="ureq_resoan_disommission" placeholder="Reson For Discommission"><?php //echo empty($equip_data[0]->ureq_resoan_disommission)?$equip_data[0]->ureq_resoan_disommission:''; ?></textarea>
        </div>
    </div>
    <div class="clearfix"></div>
    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 save" data-operation='<?php echo !empty($repair_data)?'update':'save' ?>'  ><?php echo !empty($repair_data)?'Update':'Save' ?></button>
        <!-- <button type="reset" class="btn btn-inverse waves-effect waves-light">Reset</button> -->
    <div  class="waves-effect waves-light m-r-10 text-success success"></div>
   <div class="waves-effect waves-light m-r-10 text-danger error"></div>
</form>

