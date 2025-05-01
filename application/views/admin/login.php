<!DOCTYPE html>
<html>
<?php if(array_key_exists('site_meta_title',$this->settings) && $this->settings['site_meta_title'] != ''){ 
            $title = $this->settings['site_meta_title'];
        } else {
            $title = 'Dashboard | Dashboard';
        } ?>
<head>
    <meta charset="utf-8">
    <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
    <meta http-equiv="x-ua-compatible" content="IE=Edge">
    <meta name="description" content="Page Description" />
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
    
    <!-- CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300;400;800;900&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="<?php echo base_url(); ?>uploads/assets/css/animation.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>uploads/assets/css/style.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>uploads/assets/css/responsive.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>uploads/assets/css/color.css" rel="stylesheet" />
<!--Sweet alert-->
<link href="<?php echo base_url(); ?>uploads/assets/css/sweetalert2.min.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>uploads/assets/js/sweetalert2.all.min.js"></script>
<!--Sweet alert END-->
    <script src="<?php echo base_url(); ?>uploads/assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>uploads/assets/js/utility.js"></script>
</head>

<body class="light">
    <div id="full_wrapper">
        <main>
            <div class="auth_screen">
                <div class="bg_wrap f-width"
                    style="background-image: url('<?php echo base_url(); ?>uploads/assets/images/login-screen.jpg');">

                    <div class="row">
                        <div class="col-6 bg_white fit_content">
                            <div class="float_element">
                                <div class="top_img"><img
                                        src="<?php echo base_url(); ?>uploads/assets/images/lp_top_img.svg"
                                        alt="lp_top_img"></div>
                                <div class="star_img"><img
                                        src="<?php echo base_url(); ?>uploads/assets/images/lp_star_img.png"
                                        alt="lp_star_img"></div>
                                <div class="bottom_img"><img
                                        src="<?php echo base_url(); ?>uploads/assets/images/lp_bottom_img.svg"
                                        alt="lp_bottom_img">
                                </div>
                            </div>
                            <div class="logoRow">
                                <a href="javascript:;" class="logo"><img
                                    src="<?php echo base_url(); ?>uploads/assets/images/header_logo.png"
                                    alt="header_logo"></a>
                                    <?php if(array_key_exists('site_title',$this->settings) && $this->settings['site_title'] != ''){ ?>
                                    <div class="siteTitle"><?php echo $this->settings['site_title'];?></div>
                                    <?php } ?>
                            </div>
                            <div class="auth_box">
                                <div class="bg_wrap-mobile">
                                    <img src="<?php echo base_url(); ?>uploads/assets/images/login-screen.jpg"
                                        alt="login-screen">
                                </div>
                                <form id="form_email_check" method="post" autocomplete="off">
                                    <div class="first-step-login">
                                        <h1 style="background-image: url('<?php echo base_url(); ?>uploads/assets/images/login-screen.jpg');"
                                            class="bg_img">
                                            Admin login</h1>
                                        <div class="error_authenticate"></div>

                                        <div class="form_group d-flex">
                                            <input type="email" name="username" id="email" placeholder="Please enter email">
                                            <button type="button" id="send_code_btn" class="btn">login</button>
                                        </div>
                                    </div>
                                    <!--Reset password-->
                                    <div id="password-reset" style="display:none;">
                                        <p class="small-text">As you have logged-in via your temporary password, please create a new password here:</p>
                                        <p class="small-notes">Note: Temporary password was only for one-time-use. Once you set the new password, you can not use the temporary password anymore.</p>
                                        <h1 style="background-image: url('<?php echo base_url(); ?>uploads/assets/images/login-screen.jpg');"
                                            class="bg_img">
                                            Reset password</h1>
                                        <div class="error_authenticate"></div>
                                        <!-- <h2>Rest password</h2> -->
                                        <div class="form_group">
                                            <div class="d-flex position-relative reset-password-section admin-panel-login">
                                                <div class="psw-1">
                                                    <span class="input-group-text"><i class="fas fa-eye"></i></span>
                                                    <input type="password" name="new-password" id="new-password" placeholder="Enter new password" autocomplete="new-password">
                                                </div>
                                                <div class="psw-2">
                                                    <span class="input-group-text"><i class="fas fa-eye"></i></span>
                                                    <input type="password" name="new-password-confirm" id="new-password-confirm" class="form-control"
                                                    placeholder="Confirm your new password" autocomplete="new-password">
                                                </div>
                                                <button type="button" id="reset-password-btn" class="btn">Set</button>

                                                <!-- <input type="text" name="new-password" id="new-password" class="form-control"
                                                    placeholder="Enter New Password">
                                                <button type="button" id="reset-password-btn" class="btn">Reset</button> -->
                                            </div>
                                            
                                            <p id="verify_new_code_error" class="error text-danger "></p>
                                            <br><br>
                                                <a href="javascript:location.reload()" id="" class="">Login via different email?</a>
                                            <br> 
                                            
                                            <p>It is required for the password to be at least 8 characters long and must have one special character.</p>

                                            

                                        </div>
                                        <!-- <p class="nots mb-15">Enter your verification code from your registered email.</p> -->
                                        <!-- <div class="resend_code_div mb-15">
                                            <a href="javascript:void(0)" id="resend_code_btn" class="resend_code">Resend
                                                Code</a>
                                            <span id="timer" style="display:none;"><span
                                                    id="time">10</span> Seconds (Wait for the resend)</span>
                                        </div> -->
                                    </div>
                                    <!--Reset password END-->


                                    <div class="second-step-login" style="display:none;">
                                        <p class="small-notes">Note: temporary password is for one-time use only. Once you create a new password, you can no longer use the temporary password.</p>
                                        <h1 style="background-image: url('<?php echo base_url(); ?>uploads/assets/images/login-screen.jpg');" class="bg_img">ENTER YOUR PASSWORD HERE</h1>
                                        <!-- <div class="error_authenticate"></div> -->
                                        <div class="form_group">
                                            <div class="d-flex">
                                                <span class="input-group-text"><i class="fas fa-eye"></i></span>
                                                <input type="password" name="password" id="password" placeholder="Enter password" autocomplete="new-password">
                                                <button type="submit" class="btn">Verify</button>
                                            </div> 
                                            <p id="verify_code_error" style="margin-top:10px;color:red;"></p>

                                            <div class="resend_code_div">
                                            <input type="hidden" value="0" name="for_forgot_psw" id="for_forgot_psw">
                                                <!-- <a href="javascript:void(0)" id="resend_code_btn" class="resend_code">Resend Code</a> -->
                                                <div class="remember_me_wraper">
                                                    <input type="checkbox" id="remember_me" class="login_remember_me" name="remember_me" value="1">
                                                    <label for="remember_me">Remember Me</label>
                                                </div>
                                                <a href="javascript:void(0)" id="resend_code_btn" class="resend_code">Forgot Password</a><br><br>
                                                <a href="javascript:location.reload()" id="" class="">Login via different email?</a>
                                                <span id="timer" style="display:none;"><span id="time">15:00</span> Seconds (Wait for the resend)</span>
                                                <p class="verifica_nots" style="display:none">We have sent a temporary password to your email.</p>
                                            </div>
                                            <!-- <p class="verifica_nots">Enter your verification code from your registered email.</p> -->
                                        </div>
                                    </div>

                                    <p id="verify_new_code_success" class="error text-success "></p>

                                </form>
                                <div class="copyright">
                                <?php if(array_key_exists('copyright_text',$this->settings) && $this->settings['copyright_text'] != ''){ ?>
                                <p><?php echo $this->settings['copyright_text'];?></p>
                                <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="<?php echo base_url(); ?>uploads/assets/js/jquery.dataTables.min.js"></script>
    <!-- <script src="<?php echo base_url(); ?>uploads/assets/js/script.js"></script> -->
    <script>
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
    //     jQuery('.resend_code_div .verifica_nots').toggle();
    // }


    function timer_set_resend_otp() {
        var counter = 15 * 60; // 15 minutes in seconds
        var interval = setInterval(function () {
            counter--;

            // Calculate minutes and seconds
            var minutes = Math.floor(counter / 60);
            var seconds = counter % 60;

            // Format minutes and seconds as MM:SS
            var formattedTime = minutes.toString().padStart(2, '0') + ':' + seconds.toString().padStart(2, '0');

            // Display formatted time
            $('#time').text(formattedTime);

            console.log("Timer --> " + formattedTime);

            if (counter <= 0) {
                clearInterval(interval);
                $('span#timer').hide();
                $('#resend_code_btn').show();
                return;
            }
        }, 1000);

        jQuery('.resend_code_div .verifica_nots').toggle();
    }


    jQuery(document).ready(function() {
        $(document).on('click', '#resend_code_btn', function(e) {
            console.log('resend_code_btn');
            e.preventDefault();
            $('#resend_code_btn').hide();
            $('span#timer').show();
            $('#for_forgot_psw').val(1);
            timer_set_resend_otp();
            var form = $("#form_email_check");
            var ajax_url = "<?= site_url('admin/');?>";
            $.ajax({
                url: ajax_url + 'check_email_address',
                type: 'post',
                data: form.serialize(),
                beforeSend: function(res) {
                    $('#verify_code_error').text('');
                    $('.btn').addClass('loading');
                    $('a#resend_code_btn').prop('disabled', true);
                },
                success: function(response) {
                    $('a#resend_code_btn').prop('disabled', false);
                    $('.btn').removeClass('loading');
                }
            });
            
        });

        //Focus on Email field on page load
        jQuery("#email").focus();

        $(document).on('click', '#send_code_btn', function(e) {


            e.preventDefault();
            var form = $("#form_email_check");
            $(".error_authenticate").html('');
            $(".form_group input#email").removeClass('required');
            var ajax_url = "<?= site_url('admin/');?>";
            $.ajax({
                url: ajax_url + 'check_email_address',
                type: 'post',
                data: form.serialize(),
                beforeSend: function(res) {
                    $('#verify_code_error').text('');
                    $('.btn').addClass('loading');
                    $('.btn').prop('disabled', true);
                },
                success: function(response) {
                    $('.btn').removeClass('loading');
                    $('.btn').prop('disabled', false);
                    var result = jQuery.parseJSON(response);
                    if (result.response == 'failure') {
                        var msg = '<p class="alert alert-danger">' + result.message +
                            '</p>';
                        $(".error_authenticate").html(msg);
                        $(".form_group input#email").addClass('required');
                    }
                    if (result.response == 'success') {
                        $('.first-step-login').hide();
                        $('.second-step-login').show();
                        jQuery("#password").focus();
                        // location.reload();
                    }
                }
            });
        });
        $(document).on('submit', '#form_email_check', function(e) {
            console.log('form_email_check');
            $("#verify_code_error").html('');
            e.preventDefault();
            $('#for_forgot_psw').val(0);
            var form = $(this);
            
            $(".error_authenticate").html('');
            $(".form_group input#password").removeClass('required');
            var ajax_url = "<?= site_url('admin/');?>";
            var password = $('input#password').val();
            if (password == '' && $('input#email').val()!= '') {
                // var checkstep = 2;
                // var _url = ajax_url + 'check_email_address';
                console.log('in email block')

                jQuery('#send_code_btn').trigger('click');

            }else if($('input#new-password').val()!= ''){
                console.log('in reset block')
                jQuery('#reset-password-btn').trigger('click');

            }else if (password != '' && $('input#email').val()!= '' && $('input#new-password').val()== ''){
                console.log('in login attp block')

                $.ajax({
                    url: ajax_url + 'check_login',
                    type: 'post',
                    data: form.serialize(),
                    beforeSend: function(res) {
                        $('#verify_code_error').text('');
                        $('.btn').addClass('loading');
                        $('.btn').prop('disabled', true);
                    },
                    success: function(response) {
                        $('.btn').removeClass('loading');
                        $('.btn').prop('disabled', false);
                        var result = jQuery.parseJSON(response);
                        if (result.response == 'failure') {
                            $(".form_group input#password").addClass('required');
                            var msg = '<p class="alert alert-danger">' + result.message +
                                '</p>';
                            $(".error_authenticate").html(msg);
                            $("#verify_code_error").html(result.message);
                            
                        }
                        if (result.response == 'success') {
                            location.reload();
                        }else if(result.response == 'resetpassword'){
                                // $('#step-login2').hide();
                                // $('#step-login3').hide();
                                $('.second-step-login').hide();
                                $('#password-reset').show();
                        }
                    }
                });
            }
            // $.ajax({
            //     url: ajax_url + 'check_login',
            //     type: 'post',
            //     data: form.serialize(),
            //     beforeSend: function(res) {
            //         $('#verify_code_error').text('');
            //         $('.btn').addClass('loading');
            //         $('.btn').prop('disabled', true);
            //     },
            //     success: function(response) {
            //         $('.btn').removeClass('loading');
            //         $('.btn').prop('disabled', false);
            //         var result = jQuery.parseJSON(response);
            //         if (result.response == 'failure') {
            //             $(".form_group input#password").addClass('required');
            //             var msg = '<p class="alert alert-danger">' + result.message +
            //                 '</p>';
            //             $(".error_authenticate").html(msg);
            //         }
            //         if (result.response == 'success') {
            //             location.reload();
            //         }else if(result.response == 'resetpassword'){
            //                 // $('#step-login2').hide();
            //                 // $('#step-login3').hide();
            //                 $('.second-step-login').hide();
            //                 $('#password-reset').show();
            //         }
            //     }
            // });
        });

        /**On reset password button click */
        $(document).on('click', '#reset-password-btn', function(e) {
            //console.log('reset-password-btn');

            e.preventDefault();
            console.log('reset my psw ADMIN');
            var form = $("#form_email_check");
            var email = $('#email').val();
            var newpassword = $('#new-password').val();
            var cnfPassword = $('#new-password-confirm').val();
            if (newpassword == '') {
                $("#verify_new_code_error").html('Please enter password.');
                return false;
            }
            // Check if the password is at least 8 characters long
            if(newpassword.length < 8){
                //alert("Password should be at least 8 characters long");
                jQuery("#verify_new_code_error").html("Password should be at least 8 characters long");
                return false;
            }
            if (newpassword != cnfPassword) {
                $("#verify_new_code_error").html('Password and confirm password are not the same.');
                return false;
            }
            // Check if the password contains any special characters
            var validPassword  = /^[a-zA-Z0-9]+$/.test(newpassword);//Avoid special characters
            var specialCharacterRegex = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
            if (!specialCharacterRegex.test(newpassword)) {
                //alert("Password should not contain any special characters");
                jQuery("#verify_new_code_error").html("Password should  contain atleast one special character");
                return false;
            }
            //return false;
            $(".error_authenticate").html('');
            var ajax_url = "<?= site_url('admin/');?>";
            $.ajax({
                url: ajax_url + 'admin_front_form_reset_password',
                type: 'post',
                data: form.serialize(),
                beforeSend: function(res) {
                    $('#verify_new_code_error').html();
                    $('#verify_new_code_success').html();
                    $('.btn').addClass('loading');
                    $('.btn').prop('disabled', true);
                },
                success: function(response) {
                    $('.btn').removeClass('loading');
                    $('.btn').prop('disabled', false);
                    var result = jQuery.parseJSON(response);
                    if (result.response == 'failure') {
                        jQuery("#verify_new_code_error").html(result.message);

                    }

                    if (result.response == 'success') {
                        Swal.fire("Password Reset Successful!", '', 'success').then(function(){location.reload();});

                        //location.reload();
                        //$('#password-reset').hide();
                        //jQuery("#verify_new_code_success").html(result.message+' Click <a href="javascript:location.reload()">here</a> to login');
                    }
                }
            });
        });
        /**On reset password button click END*/
    });
    $(function(){          
        $(document).on('click','.fa-eye, .fa-eye-slash', function(){       
            var inputFields = $(this).closest('.input-group-text').siblings('input[type="text"], input[type="password"]');
            if($(this).hasClass('fa-eye-slash')){           
                $(this).removeClass('fa-eye-slash');          
                $(this).addClass('fa-eye');          
                inputFields.attr('type','password');            
            } else {         
                $(this).removeClass('fa-eye');          
                $(this).addClass('fa-eye-slash');            
                inputFields.attr('type','text');
            }
        });
    });
    </script>
</body>

</html>