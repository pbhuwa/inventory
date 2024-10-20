<form method="post" id="FormUsersReg" action="<?php echo base_url('home/registers/save_user_reg'); ?>" class="form-material form-horizontal form"  data-reloadurl='<?php echo base_url('settings/user_register/form_user_reg'); ?>'>
                  <div class="row">
                   <div class="col-sm-6">
                     <div class="form-group">
                      <label for="example-text">Emp.Id:</label>
                      <input type="text"  name="usre_empid" class="form-control" placeholder="Employee Id" value="" autofocus="true">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="example-text"><?php echo $this->lang->line('signature'); ?> : </label>
                      <input type="file" name="usre_signaturepath" class="form-control" >
                    </div>
                  </div>
                  
                </div>
                <div class="row">
                 <div class="col-sm-6">
                   <div class="form-group">
                    <label for="example-text"><?php echo $this->lang->line('username'); ?><span class="required">*</span>:</label>
                    <input type="text"  name="usre_username" class="form-control" placeholder="Username" value="" autofocus="true">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="example-text"><?php echo $this->lang->line('email'); ?>:</label>
                    <input type="email"  name="usre_email" class="form-control" placeholder="Email" value="">
                  </div>
                </div>
              </div>
              <div class="row">
               <div class="col-sm-6">
                <div class="form-group">
                  <label for="example-text"><?php echo $this->lang->line('password'); ?><span class="required">*</span>:</label>
                  <input type="password"  name="usre_userpassword" class="form-control" placeholder="Password " value="">
                </div>
              </div>
              <div class="col-sm-6">
               <div class="form-group">
                <label for="example-text"><?php echo $this->lang->line('full_name'); ?>:</label>
                <input type="text"  name="usre_fullname" class="form-control" placeholder="Full Name" value="">
              </div>
            </div>
          </div>
          <div class="row">
           <div class="col-sm-6">
            <div class="form-group">
              <label for="example-text"><?php echo $this->lang->line('designation'); ?>:</label>
              <select name="usre_desiid" class="form-control select2" id="usre_desiid" >
                <option value="">---select---</option>
                <?php
                if($designation):
                  foreach ($designation as $km => $desi):
                    ?> 
                    <option value="<?php echo $desi->desi_designationid; ?>" ><?php echo $desi->desi_designationname; ?></option>
                    <?php 
                  endforeach;
                endif;
                ?>
              </select>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
             <label><?php echo $this->lang->line('phone_no'); ?></label>
             <input type="text" name="usre_phoneno" class="form-control number " value="" placeholder="Phone No">
           </div>
         </div>
       </div>
       <div class="row"> 
        <div class="col-sm-6">
          <div class="form-group">
            <label><?php echo $this->lang->line('department'); ?><!-- span class="required">*</span> : --></label>
            <select class="form-control " name="usre_departmentid[]"   style="height: auto;width: 100%;">
             <?php 
             if($department_all):
              foreach ($department_all as $kd => $dep):
                ?>
                <option value="<?php echo $dep->dept_depid; ?>" ><?php echo $dep->dept_depname; ?></option>
                <?php
              endforeach;
            endif;
            ?>
          </select>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="form-group">
          <label><?php echo $this->lang->line('location'); ?>:</label>

          <select class="form-control select2" name="usre_locationid">
            <?php   
            if($location_all):
              foreach ($location_all as $km => $loca):
                ?>
                <option value="<?php echo $loca->loca_locationid; ?>" ><?php echo $loca->loca_name ?></option>
                <?php
              endforeach;
            endif;
            ?>
          </select>
        </div>
      </div>
    </div>
    
    <div class="btn-wrapper">
     <button type="submit" class=" btn btn-default  btn-primary save" data-operation='save'>Save</button>
     <div class="alert-success success"></div>
     <div class="alert-danger error"></div>
   </div>
 </form>