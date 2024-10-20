<form action="" method="post" id="PmCompleteForm" class="mbtm_10">
    <div class="row">
    <div class="col-md-2 col-sm-3 col-xs-3 mtop_5 ">
        <label for="example-text">Equipment ID: </label>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-6">
        <input type="text" id="id" autocomplete="off" name="equid" value="" class="form-control searchText" placeholder="Enter Equipment ID" data-srchurl="<?php echo base_url(); ?>/biomedical/bio_medical_inventory/list_of_equipment_inv">
        <div class="DisplayBlock" id="DisplayBlock_id"></div>

    </div>
    <div class="col-md-4 col-sm-3 col-xs-3">
        <div>
            <button type="button" id="searchPmdata" data-viewurl='<?php echo base_url('biomedical/pm_completed/get_equdata') ?>' class="btn btn-success btnEdit mtop_0" data-displaydiv='PmCompleteForm'>Search</button>
        </div>
    </div>
  </div>
</form>
<form method="post" id="FormMenufacturer" action="<?php echo base_url('biomedical/pm_completed/save_pm_completed'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('biomedical/pm_completed/form_pm_completed'); ?>'>
    <div class="clearfix"></div>
    <div class="pm_data_body">
        <div id="FormDiv_PmCompleteForm" class="search_pm_data">
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-3">
            <label for="example-text">Result :
            </label>
            <select name="pmco_amccontractor" class="form-control">
                <option value="">---select---</option>
                <option value="pass">Pass</option>
                <option value="fail">Fail</option>
                <option value="Comment">See Comment</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-3">
         <label for="example-text">Amc:
            </label>
             <input type="text" name="pmco_amc" class="form-control" placeholder="Number " value="<?php echo !empty($pm_completed_data[0]->pmco_amc)?$pm_completed_data[0]->pmco_amc:''; ?>">
        </div>
        <div class="col-md-3">
            <label for="example-text">Amccontractor:
            </label>
            <input type="text" name="pmco_amccontractor" class="form-control" placeholder="Amccontractor " value="<?php echo !empty($pm_completed_data[0]->pmco_amccontractor)?$pm_completed_data[0]->pmco_amccontractor:''; ?>">
        </div>  

        <div class="col-md-6">
            <label>Commets</label>
            <textarea style="width: 100%" name="pmco_comments"  ><?php echo !empty($equip_data[0]->pmco_comments)?$equip_data[0]->pmco_comments:''; ?></textarea>
        </div>
    </div>    
    <div class="clearfix"></div>
    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 save" data-operation='<?php echo !empty($pm_completed_data)?'update':'save' ?>'  ><?php echo !empty($pm_completed_data)?'Update':'Save' ?></button>
    <div  class="waves-effect waves-light m-r-10 text-success success"></div>
   <div class="waves-effect waves-light m-r-10 text-danger error"></div>
</form>

