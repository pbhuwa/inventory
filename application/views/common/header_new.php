<!DOCTYPE html>
<html lang="en">
   <?php 
      ?>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url().PLUGIN_DIR; ?>images/favicon.png">
      <title><?php echo !empty($this->page_title)?$this->page_title:ORGA_NAME; ?></title>
      <!-- Bootstrap Core CSS -->
      <link href="<?php echo base_url().TEMPLATE_CSS ?>bootstrap.min.css" rel="stylesheet">
      <link href="<?php echo base_url().PLUGIN_DIR; ?>/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
      <!-- Menu CSS -->
      <link href="<?php echo base_url().PLUGIN_DIR; ?>sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
      <!-- morris CSS -->
      <link href="<?php echo base_url().PLUGIN_DIR; ?>morrisjs/morris.css" rel="stylesheet">
      <!-- animation CSS -->
      <link href="<?php echo base_url().TEMPLATE_CSS ?>animate.css" rel="stylesheet">
      <!-- Custom CSS -->
      <link href="<?php echo base_url().TEMPLATE_CSS ?>style.css" rel="stylesheet">
      <link href="<?php echo base_url().PLUGIN_DIR; ?>bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet">
      <link href="<?php echo base_url().PLUGIN_DIR; ?>bootstrap-datepicker/nepali.datepicker.v2.2.min.css" rel="stylesheet">
      <link href="<?php echo base_url().PLUGIN_DIR; ?>autocomplete/tautocomplete.css" rel="stylesheet">
      <link href="<?php echo base_url().PLUGIN_DIR; ?>select2/select2.css" rel="stylesheet">
      <!-- color CSS -->
      <!--  <link href="<?php echo base_url().TEMPLATE_CSS ?>colors/megna.css" id="theme" rel="stylesheet"> -->
      <link rel="stylesheet" href="<?php echo site_url(TEMPLATE_CSS).'/'; ?>font-awesome.css?v=0.1.1" />
      <link href="<?php echo base_url().TEMPLATE_CSS ?>common.css" rel="stylesheet">
      <link href="<?php echo base_url().TEMPLATE_CSS ?>custom.css" rel="stylesheet">
      <link href="<?php echo base_url().TEMPLATE_CSS ?>custom_sidemenu.css" rel="stylesheet">
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
       /*  li ul.dropdown-menu
         {
                margin-top: -41px !important;
                    margin-bottom: 33px !important;
         }*/
      </style>
     
   </head>
   <body class="small">
      <!-- Preloader -->
      <div class="overlay">
         <div class="text-center">
            <!-- <i class="fa fa-spinner fa-spin"></i> -->
            <!-- <div class="onePlusContainer">
               <div class="onePlusLoader"></div> -->
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
      <!-- <div class="header margin20">
         <div class="container-fluid">
            <div class="row bg-title">
               <div class="col-sm-4 col-xs-12"></div>
               <div class="col-sm-4 col-xs-12 text-center">
                  <div class="web_ttl">
                     <h2><?php echo ORGA_NAME; ?></h2>
                     <ul class="title_sub ">
                        <li><?php echo ORGA_ADDRESS1.','.ORGA_ADDRESS2;?>, Phone:<?php echo ORGA_PHONE;?></li>
                        <li>
                           <h5><?php echo ORGA_SOFTWARENAME; ?></h5>
                        </li>
                     </ul>
                  </div>
               </div>
               <div class="col-sm-4 col-xs-12 pull-right">
                  <ul class="nav navbar-top-links navbar-right pull-right">
                   
                     <li class="dropdown">
                        <div class="select-box" style="display: inline-block;">
                           <ul class="list-inline select-language">
                              <li><a href="javascript:void(0)" class="btn_language <?php if($this->session->userdata('lang')=='en') echo 'active'; ?>" data-language="en">EN</a></li>
                              <li><a href="javascript:void(0)" class="btn_language <?php if($this->session->userdata('lang')=='np') echo 'active'; ?> " data-language="np">NP</a></li>
                           </ul>
                        </div>
                      
                        <div class="notification-box">
                           <a href="#" class="notifications-bell">
                           <i class="fa fa-bell"></i><span class="countbadge">3</span>
                           </a>
                           <ul class="notification-ul show-notifications">
                              <li>
                                 <h5>Notifications<i class="fa fa-cog"></i></h5>
                              </li>
                              <li>
                                 <p>User also commented on a post</p>
                                 <span> <i class="fa fa-clock-o"></i>8 minute ago</span>
                              </li>
                              <li>
                                 <p>User also commented on a post</p>
                                 <span> <i class="fa fa-clock-o"></i>8 minute ago</span>
                              </li>
                              <li>
                                 <p>User also commented on a post</p>
                                 <span> <i class="fa fa-clock-o"></i>8 minute ago</span>
                              </li>
                              <li>
                                 <p>User also commented on a post</p>
                                 <span> <i class="fa fa-clock-o"></i>8 minute ago</span>
                              </li>
                              <li>
                                 <p>User also commented on a post</p>
                                 <span> <i class="fa fa-clock-o"></i>8 minute ago</span>
                              </li>
                              <li><a href="#">See All<i class="fa fa-angle-right"></i></a></li>
                           </ul>
                        </div>
                     </li>
                     <li class="dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#">
                          
                           Welcome, <b><?php echo $this->session->userdata(USER_NAME); ?> <i class="fa fa-caret-down"></i></b> 
                        </a>
                        <span><b>Last Login:</b> <?php echo $this->session->userdata(LOGINDATETIME); ?></span>
                        <ul class="dropdown-menu dropdown-user animated fadeInUp">
                           <li>
                              <?php $id= $this->session->userdata(USER_ID); ?> 
                              <a href="<?php echo base_url('settings/users/user_profile').'/'.$id; ?>"><i class="fa fa-user"></i> Profile</a>
                           </li>
                           <li>
                              <a href="<?php echo base_url('settings/users/change_password_user'); ?>"><i class="fa fa-key"></i> Change Password</a>
                           </li>
                           <li>
                              <a href="<?php echo base_url('login/logout'); ?>"><i class="fa fa-power-off"></i> Logout</a>
                           </li>
                        </ul>
                       
                     </li>
                   
                  </ul>
               </div>
            </div>
         </div>
         </div> -->
      <div class="des-header header margin20">
         <div class="container-fluid">
          <div class="row">
            <div class="col-md-6">
              <div class="header-left">
                <ul class="des-header-ul list-inline">
                   <li><div class="web_ttl"><h2><?php echo ORGA_NAME; ?></h2></div></li>
                     <li class="place"><?php echo ORGA_ADDRESS1.','.ORGA_ADDRESS2;?>, Phone:<?php echo ORGA_PHONE;?></li>
                </ul>
              </div>
            </div>
           
            <div class="col-md-6">
              <div class="header-right">
                <ul class="des-header-ul list-inline">
                  <li><div id="MyClockDisplay" class="clock"></div></li>
                     <li class="profile-li">
                  <a class=" profile-pic" href="javascript:void(0)">Welcome, <b><?php echo ucfirst($this->session->userdata(USER_NAME)); ?> <i class="fa fa-caret-down"></i></b> </a>
                  <<ul class="dropdown-menu dropdown-user">
                           <li>
                              <?php $id= $this->session->userdata(USER_ID); ?> 
                              <a href="<?php echo base_url('login/user_profile').'/'.$id; ?>"><i class="fa fa-user"></i> Profile</a>
                           </li>
                           <li>
                              <a href="<?php echo base_url('login/change_password'); ?>"><i class="fa fa-lock"></i> Change Password</a>
                           </li>
                           <li>
                              <a href="<?php echo base_url('login/logout'); ?>"><i class="fa fa-power-off"></i> Logout</a>
                           </li>
                        </ul>
                 
               </li>
                       <li>
                  <div class="notification-box">
                     <?php
                   
                     $srchcol=array('mess_userid'=>$this->session->userdata(USER_ID));
                        $message_list = $this->general->get_message($srchcol,10,0,'mess_messageid','DESC');
                        // echo "<pre>";
                        // print_r($message_list);
                        // die();

                        if(!empty($message_list)):
                           $message_count = count($message_list);
                        else:
                           $message_count = 0;
                        endif;
                     ?>
                     <a href="#" class="notifications-bell">
                     <i class="fa fa-bell"></i><span class="countbadge"><?php echo $message_count; ?></span>
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
                                 <li>
                                   
                                    <p style="<?php echo $read_style; ?>">
                                        <a href="<?php echo base_url('settings/notification/user_notification_detail').'/'.$mval->mess_messageid;?>"><?php echo $mval->mess_title; ?></a>
                                    </p>
                                    
                                    <span>
                                       <i class="fa fa-clock-o"></i>
                                       <?php echo $mval->mess_postdatead.' '.$mval->mess_posttime;?>
                                    </span>
                                 </li>
                              <?php
                                 endforeach;
                              else:
                              ?>
                              <li><p>You have no notification.</p></li>
                              <?php
                              endif;
                              ?>  
                        <!-- <li>
                           <p>User also commented on a post</p>
                           <span> <i class="fa fa-clock-o"></i>8 minute ago</span>
                        </li>
                        <li>
                           <p>User also commented on a post</p>
                           <span> <i class="fa fa-clock-o"></i>8 minute ago</span>
                        </li>
                        <li>
                           <p>User also commented on a post</p>
                           <span> <i class="fa fa-clock-o"></i>8 minute ago</span>
                        </li>
                        <li>
                           <p>User also commented on a post</p>
                           <span> <i class="fa fa-clock-o"></i>8 minute ago</span>
                        </li>
                        <li>
                           <p>User also commented on a post</p>
                           <span> <i class="fa fa-clock-o"></i>8 minute ago</span>
                        </li> -->
                        <li><a href="#">See All<i class="fa fa-angle-right"></i></a></li>
                     </ul>
                  </div>
               </li>
               <li>
                  <div class="select-box">
                     <ul class="list-inline select-language">
                        <li><a href="javascript:void(0)" class="btn_language <?php if($this->session->userdata('lang')=='en') echo 'active'; ?>" data-language="en">EN</a></li>
                        <li><a href="javascript:void(0)" class="btn_language <?php if($this->session->userdata('lang')=='np') echo 'active'; ?> " data-language="np">NP</a></li>
                     </ul>
                  </div>
               </li>
                </ul>
              </div>
            </div>
      
          </div>
         </div>
      </div>
      <!-- Left navbar-header -->

      <div class="navbar-default sidebar menu green sidebar_menu" role="navigation">
         <a href="javascript:void(0)" class="side_panel_toggle"><i class="fa fa-outdent"></i></a>
          <div class="slimscroll-menu">
         <div class="container-fluid">
            <div class="navbar-header">
               <div class="top-left-part">
                  <a class="logo hidden-xs" href="<?php echo base_url('home'); ?>">
                     <b>
                        <img src="<?php echo base_url('assets/template/images').'/'. ORGA_IMAGE; ?>" alt="home" >
                          <!-- <i class="fa fa-angle-down"></i>  -->
                     </b>
                      <!-- <span class="hidden-xs" style="display: inline;"><strong>elite</strong>hospital</span>  -->
                  </a>
                  <a href="#" class="mobile-header visible-xs">
                  <i class="fa fa-angle-down"></i>
                  </a>
               </div>
               <a class="home_link" href="<?php echo base_url()?>"><i class="fa fa-home"></i></a>
            </div>
            <div class="sidebar-nav" >
               <?php echo $this->general->menu_adjacency_main(0,0,false); ?>
               
            </div>
         </div>
      </div>
   </div>
   
      <!-- Left navbar-header end -->
      <div class="bread-crumb margin20">
         <div class="container-fluid">
            <ul class="breadcrumb">
               <li><a href="<?php echo base_url('home'); ?>"><?php echo $this->lang->line('home')?></a></li>
               <?php if(!empty(BREADCRUMB_1)):?>
               <li><a><?php echo BREADCRUMB_1; ?></a></li>
               <?php 
                  endif;  
                  if(!empty(BREADCRUMB_2)):
                  ?>
               <li><a><?php echo BREADCRUMB_2; ?></a></li>
               <?php endif; ?>
            </ul>
         </div>
      </div>
      <!-- Page Content -->
      <div id="page-wrapper" class="margin20">
      <div class="container-fluid">
      <div class="row bg-title">
      <div class="col-md-12">
         <h4 class="page-title">
         </h4>
      </div>
      <!-- <div class="col-md-6"> 
         </div> -->
      <div class="col-md-1 pull-right">
         <!--   <a href="javascript:void(0)" class="btn btn-sm btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-search-plus" aria-hidden="true"></i></a>-->
      </div>
      <!-- /.col-lg-12 -->
      <script>
         $(document).ready(function(){
            
         $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
           event.preventDefault(); 
           event.stopPropagation(); 
           $(this).parent().siblings().removeClass('open');
           $(this).parent().toggleClass('open');
         });
        
         $('.h-btn').click(function(){
           $('.header').slideToggle('slow');
           $('.h-btn').toggleClass('up');
         
         });
         $('.notification-box a').click(function(event){
           // event.preventDefault();
           $('.show-notifications').slideToggle('open');
         });
           $('.profile-li a').click(function(){
           $('.dropdown-user').slideToggle('open');
         });
          });
      </script>