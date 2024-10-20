

      <form method="post" id="FormStaff" action="<?php echo base_url('biomedical/staff_manager/save_staff_manager'); ?>" class="form-material form-horizontal form" data-reloadurl='<?php echo base_url('biomedical/staff_manager/form_staff_manager'); ?>'>

          <input type="hidden" name="id" value="<?php echo!empty($staff_manager_data[0]->stin_staffinfoid)?$staff_manager_data[0]->stin_staffinfoid:'';  ?>">

      <div class="form-group">

          <div class="col-md-4 col-sm-4">

          <label for="example-text">Staff Code<span class="required">*</span>:

          </label>

          <input type="text" id="example-text" name="stin_code" class="form-control" placeholder="Staff Code" value="<?php echo !empty($staff_manager_data[0]->stin_code)?$staff_manager_data[0]->stin_code:''; ?>">



          </div>

          <div class="col-md-4 col-sm-4">

          <label for="example-text">First Name<span class="required">*</span>:

          </label>

          <input type="text" id="example-text" name="stin_fname" class="form-control" placeholder="First Name" value="<?php echo !empty($staff_manager_data[0]->stin_fname)?$staff_manager_data[0]->stin_fname:''; ?>">



          </div>

          <div class="col-md-4 col-sm-4">

          <label for="example-text">Middle Name:

          </label>

          <input type="text" id="example-text" name="stin_mname" class="form-control" placeholder="Middle Name" value="<?php echo !empty($staff_manager_data[0]->stin_mname)?$staff_manager_data[0]->stin_mname:''; ?>">

        </div>



          <div class="col-md-4 col-sm-4">

          <label for="example-text">Last Name<span class="required">*</span>:

          </label>

          <input type="text" id="example-text" name="stin_lname" class="form-control" placeholder="Last Name" value="<?php echo !empty($staff_manager_data[0]->stin_lname)?$staff_manager_data[0]->stin_lname:''; ?>">



          </div>

            <div class="col-md-4 col-sm-4">

            <label for="example-text">Position:</label>



            <?php 

            $stin_positionid=!empty($staff_manager_data[0]->stin_positionid)?$staff_manager_data[0]->stin_positionid:'';

         

            ?>



            <select name="stin_positionid" class="form-control " id="departmentid">

              <option value="">---select---</option>



              <?php if($staff_position):

              foreach ($staff_position as $kdi => $posi):?>



              <option value="<?php echo $posi->stpo_staffpositionid; ?>" <?php if($stin_positionid==$posi->stpo_staffpositionid) echo 'selected=selected'; ?>><?php echo $posi->stpo_staffposition; ?></option>



              <?php endforeach; endif; ?>

            </select>

          </div>

      

           <div class="col-md-4 col-sm-4 ">

            <label for="example-text">Department:</label>



            <?php 

            $stin_departmentid=!empty($staff_manager_data[0]->stin_departmentid)?$staff_manager_data[0]->stin_departmentid:'';

            // echo $deptype;

            // die();

            ?>



            <select name="stin_departmentid" class="form-control " id="departmentid">

              <option value="">---select---</option>



              <?php if($dep_information):

              foreach ($dep_information as $kdi => $depin):?>



              <option value="<?php echo $depin->dept_depid; ?>" <?php if($stin_departmentid==$depin->dept_depid) echo 'selected=selected'; ?>><?php echo $depin->dept_depname; ?></option>



              <?php endforeach; endif; ?>

            </select>

          </div>



          <div class="col-md-4 col-sm-4">

            <label for="example-text">Room:</label>

            <select name="stin_roomid" class="form-control" id="bmin_roomid">

              <option value="">---select---</option>

            </select>

          </div>

       

           <div class="col-md-4 col-sm-4">

          <label for="example-text">Date Of Birth: </label>

          <input type="text" name="stin_dobbs" class="form-control <?php echo DATEPICKER_CLASS; ?>"  placeholder="DOB BS" value="<?php echo !empty($staff_manager_data[0]->stin_dobbs)?$staff_manager_data[0]->stin_dobbs:DISPLAY_DATE; ?>" id="ServiceStart">

          </div>

    

   



          <div class="col-md-4 col-sm-4">

          <label for="example-text">Address 1:

          </label>

             <input type="text" id="example-text" name="stin_address1" class="form-control" placeholder="Address 1" value="<?php echo !empty($staff_manager_data[0]->stin_address1)?$staff_manager_data[0]->stin_address1:''; ?>">



          </div>







          <div class="col-md-4 col-sm-4">

          <label for="example-text">Address 2:

          </label> <input type="text" id="example-text" name="stin_address2" class="form-control" placeholder="Address 2 " value="<?php echo !empty($staff_manager_data[0]->stin_address2)?$staff_manager_data[0]->stin_address2:''; ?>">



          </div>

        

          <div class="col-md-4 col-sm-4">

          <label for="example-text">Phone No: 

          </label>

          <input type="text" id="example-text" name="stin_phone" class="form-control number" placeholder="Phone NO" value="<?php echo !empty($staff_manager_data[0]->stin_phone)?$staff_manager_data[0]->stin_phone:''; ?>">



          </div>

         

     



          <div class="col-md-4 col-sm-4">

          <label for="example-text">Mobile No:

          </label>

          <input type="text" id="example-text" name="stin_mobile" class="form-control number" placeholder="Mobile No" value="<?php echo !empty($staff_manager_data[0]->stin_mobile)?$staff_manager_data[0]->stin_mobile:''; ?>">



          </div>



          <div class="col-md-4 col-sm-4">

          <label for="example-text">Email Address:

          </label>

          <input type="text" id="example-text" name="stin_email" class="form-control email" placeholder="Email Address" value="<?php echo !empty($staff_manager_data[0]->stin_email)?$staff_manager_data[0]->stin_email:''; ?>">



          </div>





          <div class="col-md-4 col-sm-4">

          <label for="example-text">Join Date: </label>

          <input type="text" name="stin_joindatead" class="form-control <?php echo DATEPICKER_CLASS; ?>"  placeholder="Join Date" value="<?php echo !empty($staff_manager_data[0]->stin_joindatead)?$staff_manager_data[0]->stin_joindatead:DISPLAY_DATE; ?>" id="ServiceStart">

          </div>



      <!--     <div class="col-md-4 col-sm-4">

          <label for="example-text">Is Doctor:

          </label>

          <div class="radio-group">

            <?php $is_doctor=!empty($staff_manager_data[0]->stin_isdoctor)?$staff_manager_data[0]->stin_isdoctor:''; ?>

            <input type="radio" name="stin_isdoctor" value="Y" <?php if($is_doctor=='Y') echo "checked=checked";?>>Yes

            <input type="radio" name="stin_isdoctor" value="N" <?php if($is_doctor=='N') echo "checked=checked";?>>No

          </div>

          </div> -->

         

        



           <div class="col-md-4 col-sm-4">

          <label for="example-text">Gender:

          </label>

          <div class="radio-group">

          <?php $gender=!empty($staff_manager_data[0]->stin_gender)?$staff_manager_data[0]->stin_gender:''; ?>

          <input type="radio" name="stin_gender" value="m" <?php if($gender=='m') echo "checked=checked";?>>Male

          <input type="radio" name="stin_gender" value="f" <?php if($gender=='f') echo "checked=checked";?>>Female

          </div>





          </div>



        



          <div class="col-md-4 col-sm-4">

          <label for="example-text">Marital status :

          </label>

          <div class="radio-group">

          <?php $maritalstatus=!empty($staff_manager_data[0]->stin_maritalstatus)?$staff_manager_data[0]->stin_maritalstatus:''; ?>

          <input type="radio" name="stin_maritalstatus" value="Y" <?php if($maritalstatus=='Y') echo "checked=checked";?>>Married

          <input type="radio" name="stin_maritalstatus" value="N" <?php if($maritalstatus=='N') echo "checked=checked";?>>Unmarried

        </div>

          </div>

           <div class="col-md-4 col-sm-4">

          <label for="example-text">Job status :

          </label>

          <div class="radio-group">

          <?php $Jobstatus=!empty($staff_manager_data[0]->stin_jobstatus)?$staff_manager_data[0]->stin_jobstatus:''; ?>

          <input type="radio" name="stin_jobstatus" value="Y" <?php if($Jobstatus=='Y') echo "checked=checked";?>>Working

          <input type="radio" name="stin_jobstatus" value="N" <?php if($Jobstatus=='N') echo "checked=checked";?>>Left

        </div>

          </div>

        </div>





        

<div class="col-md-6 col-sm-4">

          <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 save"  data-operation='<?php echo !empty($staff_manager_data)?'update':'save' ?>'  ><?php echo !empty($staff_manager_data)?'Update':'Save' ?></button>

           </div>

             <div  class="alert-success success"></div>

    <div class="alert-danger error"></div>

<div class="clearfix"></div>

          </form>







          