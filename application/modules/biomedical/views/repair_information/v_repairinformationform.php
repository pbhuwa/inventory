<form action="" method="post" id="RepairInformationForm" class="mbtm_10">
  <div class="row">
    <div class="col-md-2 mtop_5 ">
      <label for="example-text">Equipment ID: </label>
    </div>
    <div class="col-sm-4">
      <input type="text" id="id" name="equid" value="" class="form-control number" placeholder="Enter Equipment ID">
    </div>
    <div class="col-md-4">
      <div>
        <button type="button" id="searchRepair" data-viewurl='<?php echo base_url('biomedical/repair_information/get_repair_information') ?>' class="btn btn-success btnEdit mtop_0" data-displaydiv='RepairInformationForm'>Search</button>
      </div>
    </div>
  </div>
</form>
<form method="post" id="FormrepairInformation" action="<?php echo base_url('biomedical/repair_information/save_repair_information'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('biomedical/repair_information/form_repair_information'); ?>'>
    <input type="hidden" name="id" value="<?php echo!empty($repair_data[0]->rere_repairrequestid)?$repair_data[0]->rere_repairrequestid:'';  ?>">
    <div class="clearfix"></div>
    <div class="pm_data_body">
        <div id="FormDiv_RepairInformationForm" class="search_pm_data">
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-3">
            <label for="example-text">Description: </label>
               <input type="text" name="rere_description" class="form-control" placeholder="Description" value="<?php echo !empty($repair_data[0]->rere_description)?$repair_data[0]->rere_description:''; ?>">
        </div>
        <div class="col-md-3">
            <label for="example-text">Department:</label>
             <input type="text" name="rere_department" class="form-control" placeholder="Department" value="<?php echo !empty($repair_data[0]->rere_department)?$repair_data[0]->rere_department:''; ?>">
        </div>
        <div class="col-md-3">
            <label for="example-text">Repaired Request Date:</label>
             <input type="text" name="rere_repairdatead" class="form-control" placeholder="Repaired Request Date" value="<?php echo !empty($repair_data[0]->rere_repairdatead)?$repair_data[0]->rere_repairdatead:''; ?>" >
        </div>
        <div class="col-md-3">
            <label for="example-text">Reported By :</label>
            <input type="text" name="rere_reported_by" class="form-control" placeholder="Reported By " value="<?php echo !empty($repair_data[0]->rere_reported_by)?$repair_data[0]->rere_reported_by:''; ?>" >
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6">
            <label class="checkbox-inline">
                <input type="checkbox" value="1" name="rere_warranty">Under Warrenty
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" value="2" name="rere_cannotmove">Cannot Be Move
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" value="3" name="rere_onsite">Can be repair On Site
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" value="4" name="rere_moved">Move to BME Workshop
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" value="5" name="rere_manufcontacted">Distributer / Manufacture must be contaced
            </label>
             <label class="checkbox-inline">
                <input type="checkbox" value="6" name="rere_repairid">Under Maintantenence Contract
            </label>
        </div>
        <div class="col-md-3">
            <label for="example-text">Notes :</label>
            <input type="text" name="rere_notes" class="form-control" placeholder="Notes " value="<?php echo !empty($repair_data[0]->rere_notes)?$repair_data[0]->rere_notes:''; ?>">
        </div>
        <div class="col-md-3">
            <label for="example-text">Action Taken:
            </label>
            <input type="text" name="rere_action" class="form-control" placeholder="Action Taken" value="<?php echo !empty($repair_data[0]->rere_action)?$repair_data[0]->rere_action:''; ?>">
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-3">
            <label for="example-text">Parts:
            </label>
             <input type="text" name="rere_parts" class="form-control" placeholder="Fax" value="<?php echo !empty($repair_data[0]->rere_parts)?$repair_data[0]->rere_parts:''; ?>">
        </div>
        <div class="col-md-3">
            <label for="example-text">Explain Other Costs  :
            </label>
             <input type="text" name="rere_explain" class="form-control" placeholder="Email Address" value="<?php echo !empty($repair_data[0]->rere_explain)?$repair_data[0]->rere_explain:''; ?>">
        </div>
        <div class="col-md-3">
            <label for="example-text">Amc Hours:
            </label>
            <input type="text" name="rere_amchours" class="form-control" placeholder="Website" value="<?php echo !empty($repair_data[0]->rere_amchours)?$repair_data[0]->rere_amchours:''; ?>">
        </div>
        <div class="col-md-3">
            <label for="example-text">Tech Cost :
            </label>
            <input type="text" name="rere_techcost" class="form-control" placeholder="Tech Cost" value="<?php echo !empty($repair_data[0]->rere_techcost)?$repair_data[0]->rere_techcost:''; ?>">
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-3">
            <label for="example-text">Part Cost:
            </label>
             <input type="text" name="rere_partcost" class="form-control" placeholder="Part Cost" value="<?php echo !empty($repair_data[0]->rere_partcost)?$repair_data[0]->rere_partcost:''; ?>">
        </div>
        <div class="col-md-3">
            <label for="example-text">Other Cost:
            </label>
             <input type="text" name="rere_othercost" class="form-control" placeholder="Other Cost" value="<?php echo !empty($repair_data[0]->rere_othercost)?$repair_data[0]->rere_othercost:''; ?>">
        </div>
        <div class="col-md-3">
            <label for="example-text">Total Cost :
            </label>
            <input type="text" name="" class="form-control" placeholder="Total Cost" value="<?php //echo !empty($repair_data[0]->manu_conemail)?$repair_data[0]->manu_conemail:''; ?>">
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-3">
            <label for="example-text">Repair Completed Date :
            </label>
            <input type="text" name="rere_repairdatebs" class="form-control" placeholder="Repair Completed Date" value="<?php echo !empty($repair_data[0]->rere_repairdatebs)?$repair_data[0]->rere_repairdatebs:''; ?>">
        </div>
        <div class="col-md-3">
            <label for="example-text">Technician :</label>
            <input type="text" name="rere_technician" class="form-control" placeholder="Technician" value="<?php echo !empty($repair_data[0]->rere_technician)?$repair_data[0]->rere_technician:''; ?>">
        </div>
    </div>
    <div class="clearfix"></div>
    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 save" data-operation='<?php echo !empty($repair_data)?'update':'save' ?>'  ><?php echo !empty($repair_data)?'Update':'Save' ?></button>
        <!-- <button type="reset" class="btn btn-inverse waves-effect waves-light">Reset</button> -->
    <div  class="waves-effect waves-light m-r-10 text-success success"></div>
   <div class="waves-effect waves-light m-r-10 text-danger error"></div>
</form>

