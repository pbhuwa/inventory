<!DOCTYPE html>
<html>
<head>
  <title><?php echo ORGA_NAME; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url().PLUGIN_DIR; ?>images/favicon.png">

  <link href="<?php echo base_url().TEMPLATE_CSS ?>bootstrap.css" rel="stylesheet">
  <!-- <link href="<?php echo base_url().TEMPLATE_CSS ?>bootstrap.min.css" rel="stylesheet"> -->
  <link href="<?php echo base_url().TEMPLATE_CSS ?>login_style.css" rel="stylesheet">
  <link href="<?php echo base_url().TEMPLATE_CSS ?>common.css" rel="stylesheet">
  <link href="<?php echo base_url().TEMPLATE_CSS ?>custom.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i" rel="stylesheet">
  <style>
   .v-border::after {
    position: absolute;
    content: "";
    width: 100%;
    height: 2px;
    background: #ddd;
    top: 5%;
    left: 0%; 

  }

  
  .rr p {
    margin:0!important;
  }

  @media screen only and (min-width: 1440px){
    .form-wrapper {
      height: 200vh !important;
    }
  }
</style>
</head>
<body>
  <div class="form-wrapper" style="background-image: url(<?php echo base_url(); ?>/assets/template/images/form_mini.jpg);height: 150vh ;">
    <div class="container pos-vertical-center">
      <div class="form-inner">
        <div class="form-header text-center">
          <div class="main-logo">

          </div>
          

        </div>
        <div class="row">
          <div class="col-md-12 col-sm-12 text-center mb-5">
            <h3 class="logintitle"><span class="title_wrap">Inventory/Assets Management System <span class="subtitle"></span></span></h3>
          </div>
          <div class="col-md-7 col-sm-6">
            <div class="company-info">
              <div class="pos-center">
                <div class="branch-logo ">
                  <img src="<?php echo base_url('assets/template/images').'/'. ORGA_IMAGE; ?>" alt="">
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-5 col-sm-6 rr">
            <p><?php echo ORGA_NAME; ?></p>
            <p><?php echo ORGA_ADDRESS1.','.ORGA_ADDRESS2;?></p>
            <p>Phone: <?php echo ORGA_PHONE;?></p>
            <p>Website: <a href="<?php echo ORGA_WEBSITE;?>" target="_blank"><?php echo ORGA_WEBSITE;?></a></p>
          </div>
          
          
          <div class="col-md-12">
            <div class="login-form p-5  v-border ">
              <h5 >User Register Form.<a href="<?php echo base_url('/login') ?>">Back To Login </a></h5>
              <div id="FormDiv" class="formdiv frm_bdy pl-5 pr-5">
                <form method="post" id="FormUsersReg" action="" class="form-material form-horizontal form"  data-reloadurl='<?php echo base_url('settings/user_register/form_user_reg'); ?>'>
                  <div class="row">

                    <div class="col-sm-6">
                      <label for="example-text">Emp.Id:</label>
                      <input type="text"  name="usre_empid" class="form-control" placeholder="Employee Id" value="" autofocus="true">

                    </div>

                    <div class="col-sm-6">
                      <label for="example-text"><?php echo $this->lang->line('signature'); ?> : </label>
                      <input type="file" name="usre_signaturepath" class="form-control" >
                    </div>

                  </div>
                  <div class="row">
                   <div class="col-sm-6">
                    <label for="example-text"><?php echo $this->lang->line('username'); ?><span class="required">*</span>:</label>
                    <input type="text"  name="usre_username" class="form-control" placeholder="Username" value="" autofocus="true">
                    <?=form_error('usre_username')?>
                  </div>
                  <div class="col-sm-6">
                    <label for="example-text"><?php echo $this->lang->line('email'); ?>:</label>
                    <input type="email"  name="usre_email" class="form-control" placeholder="Email" value="">
                  </div>
                </div>
                <div class="row">
                 <div class="col-sm-6">
                  <label for="example-text"><?php echo $this->lang->line('password'); ?><span class="required">*</span>:</label>
                  <input type="password"  name="usre_userpassword" class="form-control" placeholder="Password " value="">
                  <?=form_error('usre_userpassword')?>
                </div>
                <div class="col-sm-6">
                  <label for="example-text"><?php echo $this->lang->line('full_name'); ?>:</label>
                  <input type="text"  name="usre_fullname" class="form-control" placeholder="Full Name" value="">
                </div>
              </div>
              <div class="row">
               <div class="col-sm-6">
                <label for="example-text"><?php echo $this->lang->line('designation'); ?>:</label>
                <select name="usre_desiid" class="form-control select2" id="usre_desiid"  style="height: auto;width: 100%;">
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
              <div class="col-sm-6">
               <label><?php echo $this->lang->line('phone_no'); ?></label>
               <input type="text" name="usre_phoneno" class="form-control number " value="" placeholder="Phone No">
             </div>
           </div>
           <div class="row"> 
            <div class="col-sm-6">
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

          <div class="col-sm-6">
            <label><?php echo $this->lang->line('location'); ?>:</label>

            <select class="form-control select2" name="usre_locationid"  style="height: auto;width: 100%;">
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
      <br><br>

        <div class="btn-wrapper">
         <button type="submit" data-register="Y" class=" btn btn-default  btn-primary " data-operation='save'>Save</button>
         
       </div>
     </form>
     <div class="alert-success success"></div>
      <div class="alert-danger error"></div>
   </div>
 </div>
 <style>#storeType{display: none;}</style>
</div>
</div>
</div>

</div>

</div>
<script src="<?php echo base_url().PLUGIN_DIR.'/'; ?>jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url().TEMPLATE_JS.'/'; ?>tether.min.js"></script>
<script src="<?php echo base_url().TEMPLATE_JS.'/'; ?>bootstrap.min.js"></script>

</body>
</html>
<script type="text/javascript">
  $('.select2').select2();
</script>

