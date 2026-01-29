<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="robots" content="noindex, nofollow" />
  <!-- Required meta tags -->
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE">
  <meta name="viewport" content="width=1000">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta http-equiv="x-ua-compatible" content="IE=Edge">
  <meta name="description" content="<?php echo $this->settings['site_title']; ?>">
  <!-- Chrome, Firefox OS, Opera and Vivaldi -->
  <meta name="theme-color" content="#000">
  <!-- Windows Phone -->
  <meta name="msapplication-navbutton-color" content="#000">
  <!-- iOS Safari -->
  <meta name="apple-mobile-web-app-status-bar-style" content="#000">

  <meta property="og:title" content="<?php echo $this->settings['site_title']; ?>">
  <meta property="og:site_name" content="<?php echo $this->settings['site_title']; ?>">
  <meta property="og:url" content="<?php echo base_url(); ?>">
  <meta property="og:description" content="<?php echo $this->settings['site_title']; ?>">
  <meta property="og:image" content="<?php echo base_url(); ?>uploads/front/images/screenshot.png">
  <?php if (array_key_exists('site_meta_title', $this->settings) && $this->settings['site_meta_title'] != '') {
    $title = $this->settings['site_meta_title'];
  } else {
    $title = 'Dashboard | Dashboard';
  } ?>
  <title><?php echo $title; ?></title>

  <!-- Favicon -->
  <link rel="icon" type="image/ico" href="<?php echo base_url(); ?>uploads/front/images/favicon.ico">
  <link rel="mask-icon" href="<?php echo base_url(); ?>uploads/front/images/favicon.ico" color="white">

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
  <?php date_default_timezone_set('America/New_York'); ?>
  <!-- <div class="loader" id="loadingDiv">
      <div class="loader_wrapper">
          <div class="left_side">
              <img src="<?php echo base_url(); ?>uploads/front/images/logo-white-icon.png" alt="logo">
          </div>
      </div>
    </div> -->
  <input type="hidden" name="global_base_url" id="global_base_url" value="<?php echo base_url(); ?>">
  <header class="header">
    <div class="headerInner">
      <div class="logoCol">
        <div class="logoBox">
          <?php if (array_key_exists('theme_logo', $this->settings) && $this->settings['theme_logo'] != '') { ?>
            <a href="<?php echo base_url(); ?>" class="logo">
              <img src="<?php echo base_url(); ?>uploads/assets/images/<?php echo $this->settings['theme_logo']; ?>" alt="">
            </a>
          <?php } ?>
        </div>
      </div>
      <?php if (array_key_exists('site_title', $this->settings) && $this->settings['site_title'] != '') { ?>
        <div class="topSiteTitle"><?php echo $this->settings['site_title']; ?></div>
      <?php } ?>
      <div class="userSetting">
        <div class="userNotification dropdown">
          <?php

          /**
           * Read visited notices from cookie and show only unvisited ones
           */
          $viewed_invites = [];

          if (!empty($_COOKIE['viewed_invites'])) {
              $decoded = json_decode($_COOKIE['viewed_invites'], true);
              if (is_array($decoded)) {
                  // normalize types
                  $viewed_invites = array_map('intval', $decoded);
              }
          }
          /**
           * Read cookies end
           */


          $user_id = $this->session->userdata('mes_user_id');
          $notis = $this->user_model->get_notification_list($user_id);

          if (!empty($notis) && !empty($viewed_invites)) {

              $notis = array_values(array_filter($notis, function ($li) use ($viewed_invites) {

                  $id = (int) $li['id'];

                  if (!isset($viewed_invites[$id])) {
                      return true; // not viewed
                  }

                  // Convert DB time to timestamp (same value as stored)
                  $createdTs = strtotime($li['created_at']);

                  // Exclude only if viewed timestamp >= created timestamp
                  return $createdTs > (int) $viewed_invites[$id];
              }));
          }




          $notis_count = 0;
          if (!empty($notis)):

            foreach ($notis as $li) {
              $booking_list_id = $li['booking_list_id'];
              $booking_list_data = $this->user_model->get_booking_date_detail($booking_list_id);
              $booking_restid = $booking_list_data['booking_restid'];
              $booking_rest_data = $this->user_model->get_restaurant_detail($booking_restid);
              $restaurant_name = $booking_rest_data['restaurant_name'];
              if($restaurant_name){
                $notis_count++;
              }
            }
          ?>
            <a href="javascript:void(0);" class="notificationBtn dropdownClick">
              <img src="<?php echo base_url(); ?>uploads/front/images/ball-icon.svg" alt="">
              <span class="badge"> <?php echo $notis_count; ?></span>
            </a>

            <div class="dropdown-list">
              <h5>notification</h5>
              <ul class="list-unstyled">
                <?php
                // echo "<pre>";
                // print_r($notis);
                // echo "</pre>";
                ?>
                <?php
                foreach ($notis as $li) {
                  $user_data = $this->user_model->get_user_detail_byuserid($li['from_id']);
                  $to_user_data = $this->user_model->get_user_detail_byuserid($li['to_id']);
                  $to_id = $li['to_id'];
                  $booking_list_id = $li['booking_list_id'];
                  $booking_list_data = $this->user_model->get_booking_date_detail($booking_list_id);
                  $booking_restid = $booking_list_data['booking_restid'];
                  $booking_rest_data = $this->user_model->get_restaurant_detail($booking_restid);
                  $restaurant_name = $booking_rest_data['restaurant_name'];
                  
                  $feature_image = $booking_rest_data['feature_image'];
                  $created_at = $li['created_at'];
                  // echo $created_at;
                  // die;
                  $day_ago = $this->user_model->compact_time_ago($created_at, "America/New_York");
                  // $day_ago = "Sun, May 11, 2025";
                  $bookingdate = new DateTime($booking_list_data['booking_date'], new DateTimeZone("America/New_York"));
                  $bookingtime = $booking_list_data['booking_time'];
                  // Get "date: Sun, May 11, 2025"
                  $date_formatted = $bookingdate->format('D, M d, Y');
                  
                  // echo "<pre>";
                  // print_r($booking_list_data);
                  // echo "</pre>";
                  $noti_status = $li['status'];
                  if($restaurant_name):
                    if ($to_id == $user_id) {
                      if ($noti_status == 'accept') {
                        $msg_status = '<span class="invite-accept"> accepted </span>';
                      } else if ($noti_status == 'decline') {
                        $msg_status = ' <span class="invite-decline"> declined </span>';
                      } else if ($noti_status == 'cancel') {
                        $msg_status = ' <span class="invite-decline"> cancelled </span>';
                      } else {
                        $msg_status = 'Invited';
                      }
                  ?>
                      <li class="invitedata" data-inviteid="<?php echo($li['id']); ?>">
                        <div class="two-column difference dddoo <?php echo($li['id']); ?>" data-inviteid="<?php echo($li['id']); ?>">
                          <div class="action">
                            <?php 
                            if($noti_status == 'cancel'){
                              ?>
                            <p>You have <?php echo $msg_status; ?> the invite from <span class="user-name"><?php echo $user_data['full_name'] . "'s"; ?></span>  for
                              <?php echo $restaurant_name; ?>
                            </p>
                              <?php
                            }else if($noti_status == 'invite'){
                              ?>
                            <p>You have received an invite from <span class="user-name"><?php echo $user_data['full_name']; ?></span> for
                              <?php echo $restaurant_name; ?>
                            </p>
                              <?php
                            }else{
                              ?>
                            <p>You have <?php echo $msg_status; ?> the <span class="user-name"><?php echo $user_data['full_name'] . "'s"; ?></span> invitation to
                              <?php echo $restaurant_name; ?>
                            </p>
                              <?php
                            }
                            ?>

                          </div>
                          <div class="hour-ago">
                            <span><?php echo $day_ago; ?></span>
                          </div>
                        </div>
                        <div class="gray-line"></div>
                        <div class="two-column difference <?php echo($li['id']); ?>">
                          <div class="two-column restaurant-data">
                            <div class="img">
                                <?php
                                  if($feature_image):
                                ?>
                                <img src="<?php echo base_url(); ?>/uploads/assets/images/<?php echo $feature_image;?>" alt="">
                                <?php
                                  else:
                                ?>
                                  <img src="<?php echo base_url(); ?>/uploads/front/images/no-image.jpg" alt="">
                                  <?php
                                endif;
                                ?>
                            </div>
                            <div class="notification-head">
                              <h5><?php echo $restaurant_name; ?></h5>
                              <div class="two-column restaurant-data">
                                <div class="noti-calendar">
                                  <div class="two-column difference restaurant-data">
                                    <img src="<?php echo base_url(); ?>uploads/front/images/invite-calendar.svg" alt="">
                                    <span><?php echo $date_formatted; ?></span>
                                  </div>
                                </div>
                                <div class="noti-time">
                                  <div class="two-column difference restaurant-data">
                                    <img src="<?php echo base_url(); ?>uploads/front/images/invite-time.svg" alt="">
                                    <span><?php echo $bookingtime; ?></span>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="view-btn">
                            <a href="<?php echo site_url('user/check_invitation/' . $li['id']); ?>" class="view view-invite-notice-btn" data-inviteid="<?php echo($li['id']); ?>" data-created-ts="<?php echo strtotime($li['created_at']); ?>">View</a>
                          </div>
                        </div>
                      </li>
                    <?php
                    } else {
                      if ($noti_status == 'accept') {
                        $msg_status = '<span class="invite-accept">accepted </span> the Invitation ';
                      } else if ($noti_status == 'decline') {
                        $msg_status = '<span class="invite-decline">declined </span> the Invitation ';
                      } else if ($noti_status == 'cancel') {
                        $msg_status = ' <span class="invite-decline"> cancelled </span>';
                      } else {
                        $msg_status = 'Invited';
                      }
                    ?>
                      <!-- <li><a href="javascript:void(0)"><?php echo $to_user_data['full_name'] . ' ' . $msg_status; ?></a></li> -->
                      <li class="invitedata" data-inviteid="<?php echo($li['id']); ?>">
                        <div class="two-column difference sdsd <?php echo($li['id']); ?>">
                          <div class="action">
                            <p><span class="user-name"><?php echo $to_user_data['full_name']; ?></span>         has <?php echo $msg_status; ?> to
                              <?php echo $restaurant_name; ?>
                            </p>
                          </div>
                          <div class="hour-ago">
                            <span><?php echo $day_ago; ?></span>
                          </div>
                        </div>
                        <div class="gray-line"></div>
                        <div class="two-column difference ">
                          <div class="two-column restaurant-data">
                            <div class="img">
                                <?php
                                  if($feature_image):
                                ?>
                                <img src="<?php echo base_url(); ?>/uploads/assets/images/<?php echo $feature_image;?>" alt="">
                                <?php
                                  else:
                                ?>
                                  <img src="<?php echo base_url(); ?>/uploads/front/images/no-image.jpg" alt="">
                                  <?php
                                endif;
                                ?>
                            </div>
                            <div class="notification-head">
                              <h5><?php echo $restaurant_name; ?></h5>
                              <div class="two-column restaurant-data">
                                <div class="noti-calendar">
                                  <div class="two-column difference restaurant-data">
                                    <img src="<?php echo base_url(); ?>uploads/front/images/invite-calendar.svg" alt="">
                                    <span><?php echo $date_formatted; ?></span>
                                  </div>
                                </div>
                                <div class="noti-time">
                                  <div class="two-column difference restaurant-data">
                                    <img src="<?php echo base_url(); ?>uploads/front/images/invite-time.svg" alt="">
                                    <span><?php echo $bookingtime; ?></span>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="view-btn">
                            <a href="<?php echo site_url('reservation_confirmed/'); ?>" class="view view-invite-notice-btn" data-inviteid="<?php echo($li['id']); ?>" data-created-ts="<?php echo strtotime($li['created_at']); ?>">View</a>
                            <?php 
                            // echo('<pre>');
                            // print_r($to_user_data);
                            // echo('</pre>');
                            if ($li['to_id'] != $user_id && $li['status'] == 'invite'){
                              ?>
<a href="javascript:void(0)" class="view modal-button invitation_decline_btn" data-username="<?php echo $to_user_data['full_name']; ?>"
                                                                                            data-user_id="<?php echo($to_user_data['id']); ?>"
                                                                                            data-listid="<?php echo $booking_list_id; ?>"
                                                                                            data-target="cancleInvite"
                                                                                            data-invite-id="<?php echo($li['id']); ?>">Cancel invitation</a>
                              <?php
                            }elseif ($li['to_id'] != $user_id && $li['status'] == 'accept'){
                              ?>
<a href="javascript:void(0)" class="view modal-button removeConfirmedGuest remove_guest_btn"
data-username="<?php echo $to_user_data['full_name']; ?>"
                                                                                            data-user_id="<?php echo($to_user_data['id']); ?>"
                                                                                            data-listid="<?php echo $booking_list_id; ?>"
                                                                                            data-target="deleteInvite">Remove guest</a>
                                                                                            
                              <?php
                            } ?>
                          </div>
                        </div>
                      </li>
                    <?php
                    }
                  endif;
                  ?>

                <?php
                }
                ?>
                <?php foreach ($notis as $li) {
                  /*
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
              <?php */
                } ?>

              </ul>
            </div>
          <?php endif; ?>
        </div>
        <div class="userMenu-dropdown dropdown">
          <div class="userDropdown dropdownClick">
            <span class="userProfile"><img src="<?php echo base_url(); ?>uploads/front/images/no-user.jpg" alt=""></span>
            <span class="userFullName"><?php echo $this->session->userdata('user_full_name'); ?></span>
          </div>
          <div class="dropdown-list">
            <ul class="list-unstyled">
              <?php
              $today = date('Y-m-d h:m:s');
              $modify_date = $this->settings['modify_end_date'];
              $modify_time = $this->settings['modify_end_time'];
              $booking_end = date('Y-m-d H:i:s', strtotime($modify_date . ' ' . $modify_time));
              if ($today < $booking_end) {
              ?>
                <li><a href="<?php echo site_url('reservation_confirmed'); ?>"><i><img src="<?php echo base_url(); ?>uploads/front/images/reservations-icon.svg" alt=""></i> Reservations</a></li>
              <?php } ?>
              <li><a href="<?php echo site_url('logout'); ?>"><i><img src="<?php echo base_url(); ?>uploads/front/images/logout-icon.svg" alt=""></i> Log out</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </header>