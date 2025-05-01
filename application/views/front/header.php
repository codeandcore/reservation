<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE">
    <meta name="viewport" content="width=1000">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="x-ua-compatible" content="IE=Edge">
    <meta name="description" content="<?php echo $this->settings['site_title'];?>">
    <!-- Chrome, Firefox OS, Opera and Vivaldi -->
    <meta name="theme-color" content="#000">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#000">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#000">

    <meta property="og:title" content="<?php echo $this->settings['site_title'];?>" >
    <meta property="og:site_name" content="<?php echo $this->settings['site_title'];?>" >
    <meta property="og:url" content="<?php echo base_url();?>" >
    <meta property="og:description" content="<?php echo $this->settings['site_title'];?>" >    
    <meta property="og:image" content="<?php echo base_url(); ?>uploads/front/images/screenshot.png">
    <?php if(array_key_exists('site_meta_title',$this->settings) && $this->settings['site_meta_title'] != ''){ 
            $title = $this->settings['site_meta_title'];
        } else {
            $title = 'Dashboard | Dashboard';
        } ?>
    <title><?php echo $title;?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/ico" href="<?php echo base_url(); ?>uploads/front/images/favicon.ico"> 
    <link rel="mask-icon" href="<?php echo base_url(); ?>uploads/front/images/favicon.ico" color="white" >
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;300;400;500;600;700;800;900&family=Work+Sans:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>uploads/front/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>uploads/front/css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>uploads/front/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>uploads/front/css/animation.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>uploads/front/css/screen.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>uploads/front/css/responsive.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>uploads/front/css/color.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>uploads/front/css/custom.css">
    <script src="<?php echo base_url(); ?>uploads/front/js/jquery-3.6.0.min.js"></script>
    <!--[if IE]> <script src="<?php echo base_url(); ?>uploads/front/js/html5shiv.js"></script> <![endif]-->
  </head>
  
  <body>
    <?php date_default_timezone_set('America/New_York');?>
    <!-- <div class="loader" id="loadingDiv">
      <div class="loader_wrapper">
          <div class="left_side">
              <img src="<?php echo base_url(); ?>uploads/front/images/logo-white-icon.png" alt="logo">
          </div>
      </div>
    </div> -->
<input type="hidden" name="global_base_url" id="global_base_url" value="<?php echo base_url();?>">
    <header class="header">
      <div class="headerInner">
        <div class="logoCol"> 
          <div class="logoBox">
          <?php if(array_key_exists('theme_logo',$this->settings) && $this->settings['theme_logo'] != ''){ ?>
                    <a href="<?php echo base_url(); ?>" class="logo">
                        <img src="<?php echo base_url(); ?>uploads/assets/images/<?php echo $this->settings['theme_logo'];?>" alt="">
                    </a>
                    <?php } ?>
          </div>
        </div>
        <?php if(array_key_exists('site_title',$this->settings) && $this->settings['site_title'] != ''){ ?>
                    <div class="topSiteTitle"><?php echo $this->settings['site_title'];?></div>
                    <?php } ?>
        <div class="userSetting">
          <div class="userNotification dropdown">
          <?php 
            $user_id = $this->session->userdata('mes_user_id');
            $notis = $this->user_model->get_notification_list($user_id);
            if(!empty($notis)):
            ?>
            <a href="javascript:void(0);" class="notificationBtn dropdownClick">
              <img src="<?php echo base_url(); ?>uploads/front/images/ball-icon.svg" alt="">
              <span class="badge"></span>
            </a>
           
            <div class="dropdown-list">
              <ul class="list-unstyled">
              <?php foreach($notis as $li){
                $user_data = $this->user_model->get_user_detail_byuserid($li['from_id']);
                $to_user_data = $this->user_model->get_user_detail_byuserid($li['to_id']);
                $to_id = $li['to_id'];
                $noti_status = $li['status'];
                if($to_id == $user_id){
                  if($noti_status == 'accept'){
                    $msg_status = 'Invitation Accepted';
                  }
                  else if($noti_status == 'decline'){
                    $msg_status = 'Invitation Declined';
                  }
                  else{
                    $msg_status = 'Invited';
                  }
                ?>
                    <li><a href="<?php echo site_url('user/check_invitation/'.$li['id']);?>"><?php echo $user_data['full_name'];?>‘s <?php echo $msg_status;?></a></li>
                <?php } else{ 
                  if($noti_status == 'accept'){
                    $msg_status = 'Invitation Accepted';
                  }
                  else if($noti_status == 'decline'){
                    $msg_status = 'Invitation Declined';
                  }
                  else{
                    $msg_status = 'Invited';
                  }
                  ?>
                  <li><a href="javascript:void(0)"><?php echo $to_user_data['full_name'].' '.$msg_status;?></a></li>
                <?php } ?>
              <?php } ?>

              </ul>
            </div>
            <?php endif; ?>
          </div>
          <div class="userMenu-dropdown dropdown">
             <div class="userDropdown dropdownClick">
              <span class="userProfile"><img src="<?php echo base_url(); ?>uploads/front/images/no-user.jpg" alt=""></span>
              <span class="userFullName"><?php echo $this->session->userdata('user_full_name');?></span>
             </div>
             <div class="dropdown-list">
              <ul class="list-unstyled">
                <?php
                $today = date('Y-m-d h:m:s');
                $modify_date = $this->settings['modify_end_date'];
                $modify_time = $this->settings['modify_end_time'];
                $booking_end = date('Y-m-d H:i:s', strtotime($modify_date . ' ' . $modify_time));
                if($today < $booking_end){
                ?>
                <li><a href="<?php echo site_url('reservation_confirmed');?>"><i><img src="<?php echo base_url(); ?>uploads/front/images/reservations-icon.svg" alt=""></i> Reservations</a></li>
                <?php } ?>
                <li><a href="<?php echo site_url('logout');?>"><i><img src="<?php echo base_url(); ?>uploads/front/images/logout-icon.svg" alt=""></i> Log out</a></li>
              </ul>
             </div>
          </div>
        </div>
      </div>
    </header>