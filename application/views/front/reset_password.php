<!DOCTYPE html>
<html lang="en">
<?php if(array_key_exists('site_meta_title',$this->settings) && $this->settings['site_meta_title'] != ''){ 
            $title = $this->settings['site_meta_title'];
        } else {
            $title = 'Dashboard | Dashboard';
        } ?>
<head>
    <!-- Required meta tags -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
    <meta name="viewport" content="width=1000" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="IE=Edge">
    <meta name="description" content="Page Description" />
    <!-- Chrome, Firefox OS, Opera and Vivaldi test-->
    <meta name="theme-color" content="#000">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#000">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#000">

    <meta property="og:title" content="<?php echo $this->settings['site_title'];?>" />
    <meta property="og:site_name" content="<?php echo $this->settings['site_title'];?>" />
    <meta property="og:url" content="<?php echo base_url();?>" />
    <meta property="og:description" content="<?php echo $this->settings['site_title'];?>" />    
    <meta property="og:image" content="<?php echo base_url(); ?>uploads/front/images/screenshot.png">

    <title><?php echo $title;?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/ico" href="<?php echo base_url(); ?>uploads/front/images/favicon.ico" />
    <link rel="mask-icon" href="<?php echo base_url(); ?>uploads/front/images/favicon.ico" color="white" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;300;400;500;600;700;800;900&family=Work+Sans:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>uploads/front/css/screen.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>uploads/front/css/responsive.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>uploads/front/css/color.css">

    <!--[if IE]> <script src="js/html5shiv.js"></script> <![endif]-->
</head>

<body>
    <div class="loader" id="loadingDiv">
        <div class="loader_wrapper">
            <div class="left_side">
                <img src="<?php echo base_url(); ?>uploads/front/images/logo-white-icon.png" alt="logo">
            </div>
        </div>
    </div>

    <main>
        <section class="loginPages animatable">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-6 leftSide">
                        <div class="leftbg"></div>
                        <div class="logoIcon">
                            <a href="#"><img src="<?php echo base_url(); ?>uploads/front/images/logo-white-icon.png"
                                    alt=""></a>
                        </div>
                        <div class="leftContent">
                            <h2>Book your reservation(s) today!</h2>
                        </div>
                    </div>
                    <div class="col-6 rightSide">
                        <div class="rightbg"></div>
                        <div class="siteTitle"><?php echo $this->settings['site_title'];?></div>
                        <div class="rightContent">
                            <div class="loginForm">
                                <form id="form_email_check" method="post">
                                    <div id="step-login1">
                                        <div class="titleIcon">
                                            <img src="<?php echo base_url(); ?>uploads/front/images/login-icon.svg" alt="">
                                        </div>
                                        <h2>Reset Password</h2>
                                        <div class="form-inline">
                                            <span class="input-group-text"><i class="fas fa-eye-slash" id="eye"></i></span>
                                            <input type="email" name="username" id="email" class="form-control"
                                                placeholder="Enter New Password Here...">
                                                
                                            <button type="button" id="reset_psw_btn" class="btn">Submit</button>
                                        </div>
                                        <div class="error_authenticate error text-danger"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- JavaScript -->
    <script src="<?php echo base_url(); ?>uploads/front/js/jquery-3.6.0.min.js"></script>
    <script src="<?php echo base_url(); ?>uploads/front/js/swiper-bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>uploads/front/js/select2.min.js"></script>
    <script src="<?php echo base_url(); ?>uploads/front/js/script.js"></script>
    <script>
        <?php if(isset($_REQUEST['invite_cookie'])){ ?>
            document.cookie = "invite_cookie=<?php echo $_REQUEST['invite_cookie'];?>; max-age=" + 30*24*60*60;
        <?php } ?>
    // function timer_set_resend_otp(){
    //     var counter = 60;
    //     var interval = setInterval(function() {
    //         counter--;
    //         // Display 'counter' wherever you want to display it.
    //         if (counter <= 0) {
    //                 clearInterval(interval);
    //                 $('span#timer').hide();
    //                 $('#resend_code_btn').show();
    //             return;
    //         }else{
    //             $('#time').text(counter);
    //         console.log("Timer --> " + counter);
    //         }
    //     }, 1000);
    // }
    jQuery(document).ready(function() {
        // $(document).on('click', '#resend_code_btn', function(e) {
        //     e.preventDefault();
        //     $('#resend_code_btn').hide();
        //     $('span#timer').show();
        //     timer_set_resend_otp();
        //     var form = $("#form_email_check");
        //     var ajax_url = "<?= site_url('user/');?>";
        //     $.ajax({
        //         url: ajax_url + 'check_email_address',
        //         type: 'post',
        //         data: form.serialize(),
        //         beforeSend: function(res) {
        //             $('#verify_code_error').text('');
        //             $('.btn').addClass('loading');
        //             $('a#resend_code_btn').prop('disabled', true);
        //         },
        //         success: function(response) {
        //             $('a#resend_code_btn').prop('disabled', false);
        //             $('.btn').removeClass('loading');
        //         }
        //     });
        // });
        // $(document).on('click', '#send_code_btn', function(e) {
        //     e.preventDefault();
        //     var form = $("#form_email_check");
        //     var email = $('#email').val();
        //     if (email == '') {
        //         $(".error_authenticate").html('Please enter email.');
        //         return false;
        //     }
        //     $(".error_authenticate").html('');
        //     var ajax_url = "<?= site_url('user/');?>";
        //     $.ajax({
        //         url: ajax_url + 'check_email_address',
        //         type: 'post',
        //         data: form.serialize(),
        //         beforeSend: function(res) {
        //             $('#verify_code_error').text('');
        //             $('.error_authenticate.error').html();
        //             $('.btn').addClass('loading');
        //             $('.btn').prop('disabled', true);
        //         },
        //         success: function(response) {
        //             $('.btn').removeClass('loading');
        //             $('.btn').prop('disabled', false);
        //             var result = jQuery.parseJSON(response);
        //             if (result.response == 'failure') {
        //                 $('#step-login2').show();
        //                 $('#step-login1').hide();
        //             }
        //             if (result.response == 'closed') {
        //                 $('.error_authenticate.error').html(result.message);
        //             }
        //             if (result.response == 'success') {
        //                 $('#step-login1').hide();
        //                 $('#step-login3').show();
        //                 // location.reload();
        //             }
        //         }
        //     });
        // });
        // $(document).on('submit', '#form_email_check', function(e) {
        //     e.preventDefault();
        //     var form = $(this);
        //     var password = $('input#password').val();
        //     var ajax_url = "<?= site_url('user/');?>";
        //     if (!$('#step-login1').is(':visible') && password == '') {
        //         $("#verify_code_error").html('Please enter Code.');
        //         return false;
        //     }
        //     if (password == '') {
        //         var checkstep = 2;
        //         var _url = ajax_url + 'check_email_address';
        //     } else {
        //         var checkstep = 3;
        //         var _url = ajax_url + 'check_login';
        //     }
        //     $.ajax({
        //         url: _url,
        //         type: 'post',
        //         data: form.serialize(),
        //         beforeSend: function(res) {
        //             $('#verify_code_error').text('');
        //             $('.btn').addClass('loading');
        //             $('.error_authenticate.error').html('');
        //             $('.btn').prop('disabled', true);
        //         },
        //         success: function(response) {
        //             $('.btn').prop('disabled', false);
        //             $('.btn').removeClass('loading');
        //             var result = jQuery.parseJSON(response);
        //             if (checkstep == 2) {
        //                 if (result.response == 'failure') {
        //                     $('#step-login2').show();
        //                     $('#step-login1').hide();
        //                 }
        //                 if (result.response == 'closed') {
        //                     $('.error_authenticate.error').html(result.message);
        //                     $('#verify_code_error').html(result.message);
        //                 }
        //                 if (result.response == 'success') {
        //                     $('#step-login1').hide();
        //                     $('#step-login3').show();
        //                     // location.reload();
        //                 }
        //             } else {
        //                 if (result.response == 'failure') {
        //                     $('#step-login2').hide();
        //                     $('#step-login3').show();
        //                     $('#step-login1').hide();
        //                     $('#verify_code_error').text(result.message);
        //                 }
        //                 if (result.response == 'closed') {
        //                     $('.error_authenticate.error').html(result.message);
        //                     $('#verify_code_error').html(result.message);
        //                 }
        //                 if (result.response == 'success') {
        //                     console.log(result);
        //                     var cookieValue = document.cookie.replace(/(?:(?:^|.*;\s*)invite_cookie\s*\=\s*([^;]*).*$)|^.*$/, "$1");
                            
        //                     if(result.notify_id != ''){
        //                         window.location.href = '<?php echo site_url('user/check_invitation/');?>'+result.notify_id;
        //                     }
        //                     else if(cookieValue){
        //                         window.location.href = '<?php echo site_url('user/check_invitation/');?>'+cookieValue;
        //                     }
        //                     else{
        //                     location.reload();
        //                     }
        //                 }
        //             }
        //         }
        //     });
        // });
        jQuery('#reset_psw_btn').click(function(){
            console.log('pasw btn clicked');
        });
    });
    </script>
</body>

</html>