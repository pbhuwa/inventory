<form method="post" id="Formservicetech" action="<?php echo base_url('biomedical/service_techs/save_service_techs'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('biomedical/service_techs/form_service_tec'); ?>'>
    <input type="hidden" name="id" value="<?php echo!empty($sete_data[0]->sete_techid)?$sete_data[0]->sete_techid:'';  ?>">
    <div class="form-group">
        <div class="col-md-4">
         <label for="example-text">Full Name <span class="required">*</span>
            </label>
               <input type="text"  name="sete_name" class="form-control" placeholder="Name" value="<?php echo !empty($sete_data[0]->sete_name)?$sete_data[0]->sete_name:''; ?>" >

        </div>
        <div class="col-md-4">
         <label for="example-text"> Phone <span class="required">*</span>
            </label>
               <input type="text"  name="sete_workphone" class="form-control" placeholder=" Phone" value="<?php echo !empty($sete_data[0]->sete_workphone)?$sete_data[0]->sete_workphone:''; ?>" >

        </div>
        <div class="col-md-4">
         <label for="example-text">Mobile:
            </label>
               <input type="text"  name="sete_mobilephone" class="form-control" placeholder="Mobile " value="<?php echo !empty($sete_data[0]->sete_mobilephone)?$sete_data[0]->sete_mobilephone:''; ?>" >

        </div>
        <div class="clearfix"></div>
        <div class="col-md-4">
         <label for="example-text">Home Phone :
            </label>
               <input type="text"  name="sete_homephone" class="form-control" placeholder="Home Phone" value="<?php echo !empty($sete_data[0]->sete_homephone)?$sete_data[0]->sete_homephone:''; ?>" >

        </div>
        <div class="col-md-4">
         <label for="example-text">Email :
            </label>
               <input type="text"  name="sete_email" class="form-control" placeholder="Email" value="<?php echo !empty($sete_data[0]->sete_email)?$sete_data[0]->sete_email:''; ?>" >

        </div>
        <div class="col-md-4">
         <label for="example-text">Address1 :
            </label>
               <input type="text"  name="sete_address1" class="form-control" placeholder="Address1" value="<?php echo !empty($sete_data[0]->sete_address1)?$sete_data[0]->sete_address1:''; ?>" >

        </div>
         <div class="col-md-4">
         <label for="example-text">Address2 :
            </label>
               <input type="text"  name="sete_address2" class="form-control" placeholder="Address2" value="<?php echo !empty($sete_data[0]->sete_address2)?$sete_data[0]->sete_address2:''; ?>" >

        </div>
         <div class="col-md-4">
         <label for="example-text">Employer :
            </label>
               <input type="text"  name="sete_employer" class="form-control" placeholder="Employer" value="<?php echo !empty($sete_data[0]->sete_employer)?$sete_data[0]->sete_employer:''; ?>" >

        </div>
    </div>

    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 save" data-operation='<?php echo !empty($sete_data)?'update':'save' ?>'><?php echo !empty($sete_data)?'Update':'Save' ?></button>
       <div  class=" alert-success success"></div>
      <div class=" alert-danger error"></div>
</form>


 