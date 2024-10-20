<!DOCTYPE html>

<html lang="en">

   <?php 
   $this->username=$this->session->userdata(USER_NAME);
   $this->location_name=$this->session->userdata(LOCATION_NAME);
   $this->login_time=$this->session->userdata(LOGINDATETIME);
   $this->userid=$this->session->userdata(USER_ID);
   $this->orgid=$this->session->userdata(ORG_ID);

   // echo "sujan";
   // die();

   ?>


   <head>

      <meta charset="utf-8">

      <meta http-equiv="X-UA-Compatible" content="IE=edge">

      <meta name="viewport" content="width=device-width, initial-scale=1">

      <meta name="description" content="">

      <meta name="author" content="">

      <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url('assets/template/images').'/'. ORGA_IMAGE; ?>">

      <title><?php echo !empty($this->page_title)?$this->page_title:ORGA_NAME; ?></title>

      <!-- Bootstrap Core CSS -->

      <link href="<?php echo base_url().TEMPLATE_CSS ?>bootstrap.min.css" rel="stylesheet">

      <link href="<?php echo base_url().PLUGIN_DIR; ?>/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />

      <link href="<?php echo base_url().PLUGIN_DIR; ?>morrisjs/morris.css" rel="stylesheet">

      <!-- animation CSS -->
      <link href="<?php echo base_url().TEMPLATE_CSS ?>animate.css" rel="stylesheet">
      <!-- Custom CSS -->
      <link href="<?php echo base_url().TEMPLATE_CSS ?>style.css" rel="stylesheet">
      <link href="<?php echo base_url().PLUGIN_DIR; ?>bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet">

      <link href="<?php echo base_url().PLUGIN_DIR; ?>bootstrap-datepicker/nepali.datepicker.v2.2.min.css" rel="stylesheet">

      <link href="<?php echo base_url().PLUGIN_DIR; ?>autocomplete/tautocomplete.css" rel="stylesheet">

      <link href="<?php echo base_url().PLUGIN_DIR; ?>select2/select2.css" rel="stylesheet">

      <!-- <link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> -->

      <!-- color CSS -->

      <!--  <link href="<?php echo base_url().TEMPLATE_CSS ?>colors/megna.css" id="theme" rel="stylesheet"> -->

      <link rel="stylesheet" href="<?php echo site_url(TEMPLATE_CSS).'/'; ?>font-awesome.css?v=0.1.1" />

      <link href="<?php echo base_url().TEMPLATE_CSS ?>common.css" rel="stylesheet">

      <link href="<?php echo base_url().TEMPLATE_CSS ?>custom.css" rel="stylesheet">

      <link href="<?php echo base_url().TEMPLATE_CSS ?>responsive.css" rel="stylesheet">

      <script src="<?php echo base_url().PLUGIN_DIR.'/'; ?>jquery/dist/jquery.min.js"></script>

      <script src="<?php echo base_url().PLUGIN_DIR.'/'; ?>bootstrap-datepicker/bootstrap-datepicker.min.js"></script>

      <script src="<?php echo base_url().PLUGIN_DIR.'/'; ?>bootstrap-datepicker/nepali.datepicker.v2.2.min.js"></script>

      <script src="<?php echo base_url().PLUGIN_DIR.'/'; ?>autocomplete/tautocomplete.js"></script>

      <script src="<?php echo base_url().PLUGIN_DIR; ?>select2/select2.min.js"></script>

      <script src="<?php echo base_url().PLUGIN_DIR; ?>printthis/printthis.js"></script>

      <script src="<?php echo base_url().TEMPLATE_JS; ?>jquery.form.js"></script>

      <script src="<?php echo base_url().TEMPLATE_JS; ?>jquery.validate.min.js"></script>

      <script src="<?php echo base_url().TEMPLATE_JS; ?>validation.error.messages.js"></script>

      <script src="<?php echo base_url().PLUGIN_DIR.'/'; ?>bootstrap-confirm/bootstrap-confirm.min.js"></script>

    

      <script type="text/javascript">

         var base_url='<?php echo base_url(); ?>';

      </script>

      <script src="<?php echo base_url().TEMPLATE_JS; ?>donetyping.js"></script>

      <style type="text/css">

         body { padding-right: 0 !important }

      </style>

   </head>

   <body>

      <!-- Preloader -->

      <div class="overlay">

         <div class="text-center">

            <div class="spinner">

               <div class="rect1"></div>

               <div class="rect2"></div>

               <div class="rect3"></div>

               <div class="rect4"></div>

               <div class="rect5"></div>

            </div>

         </div>

      </div>

      </div>

      <div id="wrapper">

      <!-- Navigation -->

      <div class="header" id="header">

         <div class="container-fluid">

            <div class="row bg-title">

               <!-- <a href="<?php echo base_url()?>" class="stat_home"><i class="fa fa-home"></i></a> -->

               <div class="col-sm-4 col-xs-12">

                  <a href="<?php echo base_url('home')?>">

                  <img class="logo" src="<?php echo base_url('assets/template/images').'/'. ORGA_IMAGE; ?>">

                  <?php if(!empty($this->location_name)): ?>

                  <a href="#" class="location"><?php echo $this->location_name; ?></a>

                  </a>

                  <?php endif; ?>

               </div>

               <div class="col-sm-4 col-xs-12 text-center">

                  <div class="web_ttl">

                     <h5><?php echo ORGA_NAME; ?></h5>

                     <ul class="title_sub ">

                        <li><?php echo ORGA_ADDRESS1.','.ORGA_ADDRESS2;?>, Phone:<?php echo ORGA_PHONE;?></li>

                        <li>

                           <h5><?php echo ORGA_SOFTWARENAME; ?></h5>

                        </li>

                     </ul>

                  </div>

               </div>

               <div class="col-sm-4 col-xs-3 pull-right">

                  <ul class="nav navbar-top-links navbar-right pull-right">

                     <!-- /.dropdown -->

                     <li class="dropdown">

                        <div class="select-box" style="display: inline-block;">

                           <ul class="list-inline select-language">

                              <li><a href="javascript:void(0)" class="btn_language <?php if($this->session->userdata('lang')=='en') echo 'active'; ?>" data-language="en">EN</a></li>

                              <li><a href="javascript:void(0)" class="btn_language <?php if($this->session->userdata('lang')=='np') echo 'active'; ?> " data-language="np">NP</a></li>

                           </ul>

                        </div>

                        <div class="notification-box">

                              <?php
                              $message_list=array();
                              if(!empty($this->userid)):
                                 $srchcol=array('mess_status'=>'U','mess_userid'=>$this->userid);

                                 $message_list = $this->general->get_message($srchcol,4,0,'mess_messageid','DESC');
                                 // echo $this->db->last_query();
                                 // die();

                                  $messagecount = $this->general->get_tbl_data('COUNT("*") as cnt','mess_message',$srchcol);

                                // echo $this->db->last_query();
                                //  die();



                                 if(!empty($messagecount)):

                                    $message_count = !empty($messagecount[0]->cnt)?$messagecount[0]->cnt:0;

                                    $blinking = 'blinking';

                                    $no_notification='';

                                 else:

                                    $message_count = 0;

                                    $blinking = '';

                                    $no_notification='no_notification';

                                 endif;

                              ?>

                           <a href="#" class="notifications-bell <?php echo $no_notification; ?>">

                           

                           <i class="fa fa-bell"></i><span class="countbadge <?php echo $blinking;?> <?php echo $no_notification; ?>"><?php echo $message_count; ?></span>

                           </a>

                           <ul class="notification-ul show-notifications">

                              <li>

                                 <h5>Notifications<i class="fa fa-cog"></i></h5>

                              </li>

                               <?php
                              
                              if(!empty($message_list)):


                                 foreach($message_list as $mkey=>$mval):
                                    if($mval->mess_status == 'U'):
                                       $read_style = 'font-weight:bold;';
                                    else:
                                       $read_style = '';
                                    endif;
                                   

                              ?>

                                 <li class="<?php if($mval->mess_status=='R')echo 'seen'; ?>">

                                     <p style="<?php echo $read_style; ?>">

                                        <a class="" href="<?php echo base_url('settings/notification/user_notification_detail').'/'.$mval->mess_messageid;?>" ><?php echo $mval->mess_title; ?></a>

                                        <span>

                                       <i class="fa fa-clock-o">

                                       <?php echo $mval->mess_postdatead.' ('.$mval->mess_posttime.')';?></i>

                                    </span>

                                    </p>

                                 </li>

                           



                                 

                              <?php

                                 endforeach;

                              else:

                              ?>

                              <li><p>You have no notification.</p></li>

                              <?php

                              endif;

                              ?> 

                          

                              <li><a href="<?php echo base_url('settings/notification/user_notification_all') ?>">See All<i class="fa fa-angle-right"></i></a></li>

                           </ul>
                              <?php endif; ?>
                        </div>

                     </li>

                     <li class="dropdown">

                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#">

                           <!-- <img src="<?php echo base_url(); ?>assets/template/images/d1.jpg" alt="user-img" width="36" class="img-circle"> -->

                           Welcome, <b><?php echo $this->username; ?> <i class="fa fa-caret-down"></i></b> 

                        </a>

                        <span><b>Last Login:</b> <?php echo $this->login_time; ?></span>

                        <ul class="dropdown-menu dropdown-user animated fadeInUp">

                           <li>

                              <?php $id= $this->userid; ?> 

                              <a href="<?php echo base_url('login/user_profile').'/'.$id; ?>"><i class="fa fa-power-off"></i> Profile</a>

                           </li>

                           <li>

                              <a href="<?php echo base_url('login/change_password'); ?>"><i class="fa fa-power-off"></i> Change Password</a>

                           </li>

                           <li>

                              <a href="<?php echo base_url('login/logout'); ?>"><i class="fa fa-power-off"></i> Logout</a>

                           </li>

                        </ul>

                        <!-- /.dropdown-user -->

                     </li>

                     <!-- /.dropdown -->

                  </ul>

               </div>
             

            </div>

         </div>

      </div>

      <!-- Left navbar-header -->

      <div class="navbar-default sidebar menu green header-old" role="navigation">

         <div class="container-fluid">

            <div class="row bg-title">

               <div class="navbar-header">

                  <a class="home_link" href="<?php echo base_url()?>"><i class="fa fa-home"></i></a>

                  <a href="#" class="h-btn"><i class="fa fa-angle-down"></i></a>

                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">

                  <span class="icon-bar"></span>

                  <span class="icon-bar"></span>

                  <span class="icon-bar"></span>                        

                  </button>

               </div>

               <div class="sidebar-nav navbar-collapse collapse" id="myNavbar">

                  <?php 
                    
               

                  // echo $this->general->menu_adjacency_main(0,0,false);
                 $menu_template=$this->general->get_menulink(); 
                 // echo 'sd'.$menu_template;
                 // die();

                 if(empty($menu_template)){
                  echo $this->general->menu_adjacency_main(0,0,false);
               }else{
                  echo $menu_template;
               }
                  // echo $this->db->last_query();
                  // echo "asd";
                  //   die();
                  ?>

                  <!-- </ul> -->

               </div>

            </div>

         </div>

      </div>

      <!-- Left navbar-header end -->

      <div class="bread-crumb">

         <div class="container-fluid">

            <ul class="breadcrumb">

               <li><a href="<?php echo base_url();?>"><?php echo $this->lang->line('home')?></a></li>

               <li><?php echo !empty($breadcrumb)?$breadcrumb:''; ?></li>

            </ul>

         </div>

      </div>

      <!-- Page Content -->

      <?php $orgid= $this->orgid; ?>

      <div id="page-wrapper">

      <div class="container-fluid">

      <div class="row bg-title">

      <div class="col-md-12">

         <h4 class="page-title home-title">

            <?php //echo !empty($module_title)?$module_title:''; ?>

            <?php /*if(($this->uri->segment(1)!='settings') && ($this->uri->segment(1)!='access_log') &&($this->uri->segment(1)!='' ) && ($this->uri->segment(1)!='biomedical') && ($this->uri->segment(1)!='permission_denial') && ($this->uri->segment(1)!='home') && ($this->uri->segment(1)!='audit_trial') && ($this->uri->segment(1)!='stock_inventory') && $orgid!=3  ): ?>

            <button type="button" class="btn btn_site btn_p_search pull-right" data-toggle="modal" ><i class="fa fa-search"></i> Patient Search</button>

            <?php endif; */ ?>

         </h4>

      </div>

      <div class="col-md-1 pull-right">

      </div>

      <script>

         $(document).ready(function(){

         $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {

           event.preventDefault(); 

           event.stopPropagation(); 

           $(this).parent().siblings().removeClass('open');

           $(this).parent().toggleClass('open');

         });

         });

         $('.h-btn').click(function(){

           $('.header').slideToggle('slow');

           $('.h-btn').toggleClass('up');

         

         });

         $('.notification-box a').click(function(event){

           // event.preventDefault();

           $('.show-notifications').slideToggle('open');

         });

         

         

      </script>

      <script>

         $(document).ready(function(){

       

         $('.view_notification').click(function(){

            var id=$(this).data('msgid');

            var url=$(this).data('url');

            alert(url);

         });

      });

       

         

         

      </script>

