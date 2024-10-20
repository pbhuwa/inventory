<body class="loginbody">

<div class="loginwrapper">
  <div class="loginwrap zindex100 animate2 bounceInDown">
  <h1 class="logintitle"><img class="logo_icon" src="<?php echo base_url('/assets/template/images/bio_ico.png')?>"> <span class="title_wrap"><?php echo ORGA_SOFTWARENAME; ?> <span class="subtitle"><?php echo ORGA_NAME; ?></span></span></h1>
        <div class="loginwrapperinner">
            <form id="loginform" action="" method="post">
                <p class="animate4 bounceIn">
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
                </p>
                 <p class="animate4 bounceIn">
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
                </p>

                <p class="animate4 bounceIn"><input type="text" id="username" name="username" value="<?php echo set_value('username'); ?>" placeholder="Username....." />
                    <?=form_error('username')?>
                </p>
                <p class="animate5 bounceIn"><input type="password" id="password" name="password" placeholder="Password"  />
                    <?=form_error('password');?>
                </p>
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
                <p class="animate6 bounceIn"><button class="btn btn-default btn-block" type="submit">Submit</button></p>
            </form>
               
                </p>
              </div>
          <style>#storeType{display: none;}</style>
        </div><!--loginwrapperinner-->
    </div>
    <div class="loginshadow animate3 fadeInUp"></div>
    <div class="btm_txt">Powered By <span>Xelwel Innovation Pvt.Ltd.</span></div>
</div><!--loginwrapper-->
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
