<!DOCTYPE html>
<html>

<head>
    <title><?php echo ORGA_NAME; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url().PLUGIN_DIR; ?>images/favicon.png">

    <link href="<?php echo base_url().TEMPLATE_CSS ?>bootstrap.css" rel="stylesheet">
     <!-- <link href="<?php echo base_url().TEMPLATE_CSS ?>bootstrap.min.css" rel="stylesheet"> -->
    <link href="<?php echo base_url().TEMPLATE_CSS ?>login_style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i" rel="stylesheet">
</head>
<script type="application/javascript">
/** After windod Load */
$(window).bind("load", function() {
  window.setTimeout(function() {
    $(".register").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove();
    });
}, 4000);
});
</script>

<body>
    <div class="form-wrapper" style="background-image: url(<?php echo base_url(); ?>/assets/template/images/form_mini.jpg);">
        <div class="container pos-vertical-center">
            <div class="form-inner">
              <div class="form-header text-center">
                <div class="main-logo">
                 
                </div>
                <h1 class="logintitle"><span class="title_wrap">Inventory/Assets Management System <span class="subtitle"></span></span></h1>
              <?php
              if($this->session->flashdata('message_name')) {
              $message = $this->session->flashdata('message_name');
              ?>
              <div class="alert-success alert success register"><?php echo $message; ?>

              </div>
              <?php
              }
              ?>
                
              </div>
                <div class="row v-border">
                    <div class="col-md-6">
                        <div class="company-info">
                            <div class="pos-center">
                                <div class="branch-logo">
                                    <img src="<?php echo base_url('assets/template/images').'/'. ORGA_IMAGE; ?>" alt="">
                                </div>
                                <p><?php echo ORGA_NAME; ?></p>
                                <p><?php echo ORGA_ADDRESS1.','.ORGA_ADDRESS2;?></p>
                                <p>Phone: <?php echo ORGA_PHONE;?></p>
                                <p>Website: <a href="<?php echo ORGA_WEBSITE;?>" target="_blank"><?php echo ORGA_WEBSITE;?></p></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="login-form">
                            <!--  <div class="logo-img text-center">
                                <img src="images/xelwel.png" alt="">
                            </div> -->
                            <h5>Welcome. Please Login.<a href="<?php echo base_url('/register') ?>">New User Register.</a></h5>
                            <form id="loginform" action="" method="post">
                                <div class="form-group">
                                    <select class="form-control softwareType" name="usgr_accesssystemid">
                                     <?php
                                      if($org_list):
                                      foreach ($org_list as $kl => $org):
                                      ?>
                                      <option value="<?php echo $org->orga_orgid; ?>"><?php echo $org->orga_software; ?></option>
                                    <?php
                                    endforeach;
                                    endif; 
                                      ?>
                                    </select>
                                    <?=form_error('usgr_accesssystemid')?>
                                </div>
                               <!--  <div class="form-group">
                                <select class="form-control select2" name="usma_locationid">
                                  <?php   
                                  $locationid=!empty($this->input->post('usma_locationid'))?$this->input->post('usma_locationid'):'';
                                  if($location_all):
                                      foreach ($location_all as $km => $loca):
                                      ?>
                                      <option value="<?php echo $loca->loca_locationid; ?>" <?php if($locationid==$loca->loca_locationid) echo "selected=selected"; ?>><?php echo $loca->loca_name ?></option>
                                      <?php
                                      endforeach;
                                      endif;
                                  ?>
                                </select>
                                    <?=form_error('usma_locationid')?>
                                </div> -->
                                <div class="form-group">
                                    <input type="text" id="username" name="username" value="<?php echo set_value('username'); ?>" placeholder="Username" class="form-control">
                                    <?=form_error('username')?>
                                </div>
                                <div class="form-group">
                                    <input type="password" id="password" name="password" placeholder="Password" class="form-control">
                                    <?=form_error('password');?>
                                </div>
                                <div>
                                        <p class="animate4 bounceIn">
                                          <select class="form-control" name="eqty_equipmenttypeid" id="storeType">
                                            <?php
                                              if($store):
                                              foreach ($store as $kl => $st):
                                              ?>
                                              <option value="<?php echo $st->eqty_equipmenttypeid; ?>"><?php echo $st->eqty_equipmenttype; ?></option>
                                            <?php
                                            endforeach;
                                            endif; 
                                              ?>
                                          </select>
                                            <?=form_error('eqty_equipmenttypeid')?>
                                        </p>   
                                        <p>
                                            <?php if($this->session->flashdata('message')) { ?></p>
                                          
                                      <div  class="message_admin"> <?php echo validation_errors(); ?>
                                        <p>
                                          <?php if($this->session->flashdata('message')) echo $this->session->flashdata('message');?>
                                          <?php } ?>
                                        </p>
                                </div>
                                <div class="btn-wrapper">
                                    <button id="button" type="submit" class=" btn btn-default btn-block btn-primary submit-btn">Submit</button>
                                </div>
                            </form>
                        </div>
                         <style>#storeType{display: none;}</style>
                    </div>
                </div>
            </div>
            <!-- <div class="btm_txt" style="text-align: center; margin-top: 7%"><font color="white"><i>Powered By</i></font><font color="cream"> <span>Xelwel Innovation Pvt.Ltd.</span></font><font color="silver">™</font></div> -->
        </div>

    </div>

     <script src="<?php echo base_url().PLUGIN_DIR.'/'; ?>jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url().TEMPLATE_JS.'/'; ?>tether.min.js"></script>
    <script src="<?php echo base_url().TEMPLATE_JS.'/'; ?>bootstrap.min.js"></script>

    <script>  
  $(document).off('change','.softwareType');
  $(document).on('change','.softwareType',function(){
    var utype=$(this).val();
    if(utype== "3")
    {
      $('#storeType').show();
    }else{
      $('#storeType').hide();
    }
  });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $('.softwareType').change();
  })
</script>
</body>

</html>