<?php
/**
 * Header for Help Center
 */
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
        <meta http-equiv="x-ua-compatible" content="IE=Edge">
        <meta name="description" content="<?php echo $this->settings['site_title'];?>" /> 
        <!-- Chrome, Firefox OS, Opera and Vivaldi -->
        <meta name="theme-color" content="#F4B223">
        <!-- Windows Phone -->
        <meta name="msapplication-navbutton-color" content="#F4B223">
        <!-- iOS Safari -->
        <meta name="apple-mobile-web-app-status-bar-style" content="#F4B223">
        <link rel="mask-icon" href="<?php echo base_url(); ?>uploads/assets/images/favicon.ico">    
        <link rel="mask-icon" href="<?php echo base_url(); ?>uploads/assets/images/favicon.ico" color="#1A73E8"> 
        <link rel="icon" type="images/ico" href="<?php echo base_url(); ?>uploads/assets/images/favicon.ico" />    
        
        <!-- Social Meta tags -->
        <meta property="og:type" content="website" />
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
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300;400;800;900&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Serif:ital,opsz,wght@0,8..144,100..900;1,8..144,100..900&display=swap" rel="stylesheet">

        <link href="<?php echo base_url(); ?>uploads/assets/css/animation.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>uploads/assets/css/dataTables.responsive.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>uploads/assets/css/jquery.timepicker.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>uploads/assets/css/select2.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>uploads/assets/css/swiper-bundle.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>uploads/assets/css/style.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>uploads/assets/css/responsive.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>uploads/assets/css/color.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>uploads/assets/css/sweetalert2.min.css" rel="stylesheet" />
        <script src="<?php echo base_url(); ?>uploads/assets/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>uploads/assets/js/utility.js"></script>
        <script src="<?php echo base_url(); ?>uploads/assets/js//moment.min.js"></script>
        <script src="<?php echo base_url(); ?>uploads/assets/js/jquery.validate.min.js"></script>
        <script src="<?php echo base_url(); ?>uploads/assets/js/sweetalert2.all.min.js"></script>
        <script src="<?php echo base_url(); ?>uploads/assets/js/jquery-ui.min.js"></script>
        <script src="<?php echo base_url(); ?>uploads/assets/js/select2.min.js"></script>
        <script src="<?php echo base_url(); ?>uploads/assets/js/swiper-bundle.min.js"></script>
        <script src="<?php echo base_url(); ?>uploads/assets/js/jquery.timepicker.min.js"></script>
        <script src="<?php echo base_url(); ?>uploads/assets/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url(); ?>uploads/assets/js/dataTables.responsive.js"></script>
        <script src="<?php echo base_url(); ?>uploads/assets/js/dataTables.fixedColumns.min.js"></script>
        <script src="<?php echo base_url(); ?>uploads/assets/js/ckeditor.js"></script>
		<script src="<?php echo base_url(); ?>uploads/assets/js/suneditor.js"></script>
        <script src="<?php echo base_url(); ?>uploads/assets/js/script.js"></script>
        <script src="<?php echo base_url(); ?>uploads/assets/js/help_center.js"></script>
    </head>
    <body>
    <input type="hidden" name="global_base_url" id="global_base_url" value="<?php echo site_url();?>">
        <div id="full_wrapper">
            <div id="layout-wrapper">
                <header class="top_bar">
                    <div class="wrap_container">
                    <?php if(array_key_exists('theme_logo',$this->settings) && $this->settings['theme_logo'] != ''){ ?>
                        <div class="logoBlock">
                            <a href="<?php echo base_url('admin'); ?>" class="logo">
                                <img src="<?php echo base_url(); ?>uploads/assets/images/<?php echo $this->settings['theme_logo'];?>" alt="">
                            </a>
                        </div>
                        <?php } ?>
                        <?php if(array_key_exists('site_title',$this->settings) && $this->settings['site_title'] != ''){ ?>
                        <div class="siteTitle"><?php echo $this->settings['site_title'];?></div>
                        <?php } ?>
                        <div class="right_top_bar">
                            <!-- <div class="dropdown topbar-head-dropdown">
                                <a href="javascript:void(0)" class="rounded-circle">
                                    <img src="<?php echo base_url(); ?>uploads/assets/images/bel.svg" alt="">
                                    <span class="badge"></span>
                                </a>
                            </div> -->
                            <div class="topbar-user dropdown">
                                <div class="user_dropdown dropdownClick">
                                    <span class="header-profile-user">
                                        <?php 
                                            $profile_url = base_url().'/uploads/assets/images/no-user.jpg';
                                        ?>
                                        <img src="<?php echo $profile_url;?>" alt="">
                                    </span>
                                    <span class="header-profile-user-name">
                                        <?php echo $this->session->userdata('admin_full_name');
                                        $current_route = $this->uri->segment(2); ?>
                                    </span>
                                </div>
                                <div class="dropdown-list">
                                    <ul class="user-sub-menu list-unstyled">
                                        <li><a href="<?php echo site_url('admin/logout');?>"><i><img src="<?php echo base_url(); ?>uploads/assets/images/logout-icon.svg" alt=""></i> Logout</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="hidden_upload_dir" id="hidden_upload_dir" value="<?php echo base_url(); ?>uploads/">
                </header>
    