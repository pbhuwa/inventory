<form method="post" id="FormrepairInformation" action="<?php echo base_url('settings/scheme/save_scheme'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('settings/scheme/form_scheme'); ?>'>
    <input type="hidden" name="id" value="<?php echo!empty($comm_data[0]->rere_repairrequestid)?$comm_data[0]->rere_repairrequestid:'';  ?>">
    <div class="clearfix"></div>
    <div class="pm_data_body">
        <div id="FormDiv_RepairInformationForm" class="search_pm_data">
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-3">
            <label for="example-text">Code: </label>
               <input type="text" name="sche_schemecode" class="form-control number" placeholder="Code" value="<?php echo !empty($comm_data[0]->sche_schemecode)?$comm_data[0]->sche_schemecode:''; ?>">
        </div>
        <div class="col-md-3">
            <label for="example-text">Scheme Name:</label>
             <input type="text" name="sche_scheme" class="form-control" placeholder="Department" value="<?php echo !empty($comm_data[0]->sche_scheme)?$comm_data[0]->sche_scheme:''; ?>">
        </div>
        <div class="col-md-3">
            <label for="example-text">Community  :
            </label>
            <?php $pmenu = !empty($comm_data[0]->sche_communityid)?$comm_data[0]->sche_communityid:'';?>

            <select name="sche_communityid" class="form-control">
                <option>---select---</option>
                <?php 
                if($community_list):
                    foreach ($community_list as $kcl => $community): 
                    ?>
                    <option value="<?php echo $community->comm_communityid; ?>" <?php if($pmenu==$community->comm_communityid) echo 'selected=selected'; ?>><?php echo $community->comm_community; ?></option>
                    <?php
                    endforeach;
                endif;
                ?>
            </select>
        </div>
        <div class="col-md-3">
            <label for="example-text">Community:</label>
            <input type="text" name="sche_validtodatead" class="form-control" placeholder="Reported By" value="<?php echo !empty($comm_data[0]->sche_validtodatead)?$comm_data[0]->sche_validtodatead:''; ?>">
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-4">
            <label class="checkbox-inline">
                <?php $isdefaultschemeopbill = !empty($comm_data[0]->sche_isdefaultschemeopbill)?$comm_data[0]->sche_isdefaultschemeopbill:'';?>
                <input type="checkbox" value="Y" name="sche_isdefaultschemeopbill" <?php echo ($isdefaultschemeopbill == 'Y' ? 'checked' : null); ?>>
                Default Schema For OP Bill
            </label>
        </div>
        <div class="col-md-4">
            <?php $isdisplayforcommrefund = !empty($comm_data[0]->sche_isdisplayforcommrefund)?$comm_data[0]->sche_isdisplayforcommrefund:'';?>
            <label class="checkbox-inline">
                <input type="checkbox" value="Y" name="sche_isdisplayforcommrefund"  <?php echo ($isdisplayforcommrefund == 'Y' ? 'checked' : null); ?>>Is Schema Disaplay For Community Refund
            </label>
        </div><div class="col-md-4">
            <?php $isbipanna = !empty($comm_data[0]->sche_isbipanna)?$comm_data[0]->sche_isbipanna:'';?>
            <label class="checkbox-inline">
                <input type="checkbox" value="Y" name="sche_isbipanna" <?php echo ($isbipanna == 'Y' ? 'checked' : null); ?>>Is Bipanna Schema
            </label>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-4">
            <?php $isactive = !empty($comm_data[0]->sche_isactive)?$comm_data[0]->sche_isactive:'';?>

            <label class="checkbox-inline">
                <input type="checkbox" value="Y" name="sche_isactive" <?php echo ($isactive == 'Y' ? 'checked' : null); ?>>Is Active Scheme
            </label>
        </div>
        <div class="col-md-4">
            <label for="example-text">Valid From Date:</label>
            <input type="text" name="sche_validfromdatead" class="form-control" placeholder="Reported By " value="<?php echo !empty($comm_data[0]->sche_validfromdatead)?$comm_data[0]->sche_validfromdatead:''; ?>" >
        </div>
        <div class="col-md-4">
            <label for="example-text">Valid To Date:</label>
            <input type="text" name="sche_validtodatead" class="form-control" placeholder="Reported By " value="<?php echo !empty($comm_data[0]->sche_validtodatead)?$comm_data[0]->sche_validtodatead:''; ?>" >
            
        </div>
    </div>
    <div class="form-group">    
        <div class="col-md-4">
            <label for="example-text">Registration Discount :</label>
            <input type="text" name="sche_regdisper" class="form-control number" placeholder="Notes " value="<?php echo !empty($comm_data[0]->sche_regdisper)?$comm_data[0]->sche_regdisper:''; ?>">
        </div>
        <div class="col-md-4">
            <div><label>&nbsp;</label></div>
            <label class="checkbox-inline">
                <?php $scher = !empty($comm_data[0]->sche_isregdiseditable)?$comm_data[0]->sche_isregdiseditable:'';?>  
                <input type="checkbox" value="Y" name="sche_isregdiseditable" <?php echo ($scher == 'Y' ? 'checked' : null); ?>>Is Discount (%) Editable in Reg
            </label>
        </div>
        <div class="col-md-4"> 
            <div><label>&nbsp;</label></div>
            <label class="checkbox-inline">
           <?php $pmenu = !empty($comm_data[0]->sche_isregcrfacility)?$comm_data[0]->sche_isregcrfacility:'';?>    
            <input type="checkbox" value="Y" name="sche_isregcrfacility" <?php echo ($pmenu == 'Y' ? 'checked' : null); ?>>Is Reg. (%) Credit Facility
            </label>
        </div>
    </div>

    <div class="form-group">    
        <div class="col-md-4">
            <label for="example-text">Out Patitnet Billing Discount :</label>
            <input type="text" name="sche_opbilldisper" class="form-control number" placeholder="Notes " value="<?php echo !empty($comm_data[0]->sche_opbilldisper)?$comm_data[0]->sche_opbilldisper:''; ?>">
        </div>
        <div class="col-md-4">
            <div><label>&nbsp;</label></div>
            <label class="checkbox-inline">
                <?php $isopbill = !empty($comm_data[0]->sche_isopbilldiseditable)?$comm_data[0]->sche_isopbilldiseditable:'';?> 

                <input type="checkbox" value="Y" name="sche_isopbilldiseditable" <?php echo ($isopbill == 'Y' ? 'checked' : null); ?>>Is Discount (%) Editable in OP Bill
            </label>
        </div>
         <div class="col-md-4">
            <div><label>&nbsp;</label></div>
            <?php $isopbillcr = !empty($comm_data[0]->sche_isopbillcrfacility)?$comm_data[0]->sche_isopbillcrfacility:'';?> 
            <label class="checkbox-inline">
                <input type="checkbox" value="Y" name="sche_isopbillcrfacility" <?php echo ($isopbillcr == 'Y' ? 'checked' : null); ?>>Is OP Bill (%) Credit Facility
            </label>
        </div>
    </div>
    <div class="form-group">    
        <div class="col-md-4">
            <label for="example-text">Is Patitnet Billing Discount :</label>
            <input type="text" name="sche_ipbilldisper" class="form-control number" placeholder="Notes " value="<?php echo !empty($comm_data[0]->sche_ipbilldisper)?$comm_data[0]->sche_ipbilldisper:''; ?>">
        </div>
        <div class="col-md-4">
            <div><label>&nbsp;</label></div>
            <?php $isipbilldiseditable = !empty($comm_data[0]->sche_isipbilldiseditable)?$comm_data[0]->sche_isipbilldiseditable:'';?> 
            <label class="checkbox-inline">
                <input type="checkbox" value="Y" name="sche_isipbilldiseditable" <?php echo ($isipbilldiseditable == 'Y' ? 'checked' : null); ?>>Is Discount (%) Editable in Ip Billing
            </label>
        </div>
         <div class="col-md-4">
            <div><label>&nbsp;</label></div>
            <?php $isipbillcrfacility = !empty($comm_data[0]->sche_isipbillcrfacility)?$comm_data[0]->sche_isipbillcrfacility:'';?> 
            <label class="checkbox-inline">
                <input type="checkbox" value="Y" name="sche_isipbillcrfacility" <?php echo ($isipbillcrfacility == 'Y' ? 'checked' : null); ?>>Is IP Bill Credit Facility
            </label>
        </div>
    </div>

    <h5>Admission & bed Charge Discount</h5> <hr>
    <div class="form-group">    
        <div class="col-md-4">
            <label for="example-text">Admission  :</label>
            <input type="text" name="sche_admndisper" class="form-control number" placeholder="Admission" value="<?php echo !empty($comm_data[0]->sche_admndisper)?$comm_data[0]->sche_admndisper:''; ?>">
        </div>
        <div class="col-md-6">
            <div><label>&nbsp;</label></div>
            <?php $isadmndiseditable = !empty($comm_data[0]->sche_isadmndiseditable)?$comm_data[0]->sche_isadmndiseditable:'';?> 
            <label class="checkbox-inline">
            <label class="checkbox-inline">
                <input type="checkbox" value="Y" name="sche_isadmndiseditable" <?php echo ($isadmndiseditable == 'Y' ? 'checked' : null); ?>>Is Discount (%) Editable in Admission
            </label>
        </div>
    </div>
    <div class="form-group">    
        <div class="col-md-4">
            <label for="example-text">Bed Charge  :</label>
            <input type="text" name="sche_beddisper" class="form-control number" placeholder="Bed Charge " value="<?php echo !empty($comm_data[0]->sche_beddisper)?$comm_data[0]->sche_beddisper:''; ?>">
        </div>
        <div class="col-md-4">
            <div><label>&nbsp;</label></div>
            <?php $isbeddiseditable = !empty($comm_data[0]->sche_isbeddiseditable)?$comm_data[0]->sche_isbeddiseditable:'';?> 
            <label class="checkbox-inline">
                <input type="checkbox" value="Y" name="sche_isbeddiseditable" <?php echo ($isbeddiseditable == 'Y' ? 'checked' : null); ?>>Is Discount (%) Editable in Bed
            </label>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <div class="col-md-Y2">
            <div><label>&nbsp;</label></div>
            <?php $ispharmacydiscountscheme = !empty($comm_data[0]->sche_ispharmacydiscountscheme)?$comm_data[0]->sche_ispharmacydiscountscheme:'';?>
            <label class="checkbox-inline">
                <input type="checkbox" value="Y" name="sche_ispharmacydiscountscheme" <?php echo ($ispharmacydiscountscheme == 'Y' ? 'checked' : null); ?>>Is Aplied For pharmacy Discount $ Credit Policy
            </label>
        </div>
    </div><hr>
    <div class="form-group">    
        <div class="col-md-4">
            <label for="example-text">Pharmacy Out Patient Discount :</label>
            <input type="text" name="sche_phopdisper" class="form-control" placeholder="Notes " value="<?php echo !empty($comm_data[0]->sche_phopdisper)?$comm_data[0]->sche_phopdisper:''; ?>">
        </div>
        <div class="col-md-4">
            <div><label>&nbsp;</label></div>
            <?php $isphopdiseditable = !empty($comm_data[0]->sche_isphopdiseditable)?$comm_data[0]->sche_isphopdiseditable:'';?>
            <label class="checkbox-inline">
                <input type="checkbox" value="Y" name="sche_isphopdiseditable" <?php echo ($isphopdiseditable == 'Y' ? 'checked' : null); ?>>Is Discount (%) Editable in Op Pharmacy
            </label>
        </div>
         <div class="col-md-4">
            <div><label>&nbsp;</label></div>
            <?php $isphopcrfacility = !empty($comm_data[0]->sche_isphopcrfacility)?$comm_data[0]->sche_isphopcrfacility:'';?>
            <label class="checkbox-inline">
                <input type="checkbox" value="Y" name="sche_isphopcrfacility" <?php echo ($isphopcrfacility == 'Y' ? 'checked' : null); ?>>Is OP Ph. (%) Credit Facility
            </label>
        </div>
    </div>
    <div class="form-group">    
        <div class="col-md-4">
            <label for="example-text">Pharmacy In Patient Discount :</label>
            <input type="text" name="sche_phipdisper" class="form-control" placeholder="Pharmacy In Patient Discount " value="<?php echo !empty($comm_data[0]->sche_phipdisper)?$comm_data[0]->sche_phipdisper:''; ?>">
        </div>
        <div class="col-md-4">
            <div><label>&nbsp;</label></div>
            <?php $isphipdiseditable = !empty($comm_data[0]->sche_isphipdiseditable)?$comm_data[0]->sche_isphipdiseditable:'';?>
            <label class="checkbox-inline">
                <input type="checkbox" value="Y" name="sche_isphipdiseditable" <?php echo ($isphipdiseditable == 'Y' ? 'checked' : null); ?>>Is Discount (%) Editable in Pharmacy
            </label>
        </div>
         <div class="col-md-4">
            <div><label>&nbsp;</label></div>
            <?php $isphipcrfacility = !empty($comm_data[0]->sche_isphipcrfacility)?$comm_data[0]->sche_isphipcrfacility:'';?>
            <label class="checkbox-inline">
                <input type="checkbox" value="Y" name="sche_isphipcrfacility" <?php echo ($isphipcrfacility == 'Y' ? 'checked' : null); ?>>Is IP Ph. Credit Facility
            </label>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-4">
            <label for="example-text">Remarks:
            </label>
             <input type="text" name="sche_remarks" class="form-control" placeholder="Remarks" value="<?php echo !empty($comm_data[0]->sche_remarks)?$comm_data[0]->sche_remarks:''; ?>">
        </div>
        <div class="col-md-4">
            <label for="example-text">Account head  :
            </label>
             <input type="text" name="sche_accountheaddis" class="form-control" placeholder="Account head " value="<?php echo !empty($comm_data[0]->sche_accountheaddis)?$comm_data[0]->sche_accountheaddis:''; ?>">
        </div>
        <div class="col-md-4">
            <label for="example-text">Account Head:
            </label>
            <input type="text" name="sche_accountheadid" class="form-control" placeholder="Account Head" value="<?php echo !empty($comm_data[0]->sche_accountheadid)?$comm_data[0]->sche_accountheadid:''; ?>">
        </div>
    </div>
    <div class="clearfix"></div>
    <button type="submit" class="btn btn-info waves-effect waves-light m-r-Y0 save" data-operation='<?php echo !empty($comm_data)?'update':'save' ?>'  ><?php echo !empty($comm_data)?'Update':'Save' ?></button>
    <div id="ResponseSuccess" class="waves-effect waves-light m-r-Y0 text-success"></div>
    <div id="ResponseError" class="waves-effect waves-light m-r-Y0 text-danger"></div>
</form>
