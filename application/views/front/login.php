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
    <!-- Chrome, Firefox OS, Opera and Vivaldi -->
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
<!--Sweet alert-->
<link href="<?php echo base_url(); ?>uploads/assets/css/sweetalert2.min.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>uploads/assets/js/sweetalert2.all.min.js"></script>
<!--Sweet alert END-->
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
                                <form id="form_email_check" method="post" autocomplete="off">
                                    <div id="step-login1">
                                        <div class="titleIcon">
                                            <img src="<?php echo base_url(); ?>uploads/front/images/login-icon.svg"
                                                alt="">
                                        </div>
                                        <h2>User Login</h2>
                                        <div class="form-inline">
                                            <input type="email" name="username" id="email" class="form-control"
                                                placeholder="Enter Email Here...">
                                            <button type="button" id="send_code_btn" class="btn">Login</button>
                                        </div>
                                        <div class="error_authenticate error text-danger"></div>
                                    </div>
                                    <div id="step-login2" style="display:none;">
                                        <div class="titleIcon">
                                            <img src="<?php echo base_url(); ?>uploads/front/images/user-not-icon.svg"
                                                alt="">
                                        </div>
                                        <h2>User Not Found</h2>
                                        <p>Your provided email doesn't match our list record. Please try with the email which was used during registration or contact Award Headquarters for further assistance.</p>
                                        <a href="<?php echo base_url(); ?>" class="btn">back to Login</a>
                                    </div>
                                    <div id="step-login3" style="display:none;">
                                        <div class="titleIcon">
                                            <img src="<?php echo base_url(); ?>uploads/front/images/verify-icon.svg"
                                                alt="">
                                        </div>
                                        <p class="small-notes">Note: temporary password is for one-time use only. Once you create a new password, you can no longer use the temporary password.</p>
                                        <h2>Enter your Password Here</h2>
                                        <div class="form-inline mb-15">
                                            <span class="input-group-text"><i class="fas fa-eye"></i></span>
                                            <input type="password" name="password" id="password" class="form-control"
                                                placeholder="Enter Password" autocomplete="new-passwordd">
                                            <button type="submit" class="btn">verify</button>
                                        </div>
                                        <p id="verify_code_error" class="error text-danger "></p>

                                        <!-- <p class="nots mb-15">Enter your verification code from your registered email.</p> -->
                                        <div class="resend_code_div mb-15">
                                            <input type="hidden" value="0" name="for_forgot_psw" id="for_forgot_psw">
                                            <div class="remember_me_wraper">
                                                <input type="checkbox" id="remember_me" class="login_remember_me" name="remember_me" value="1">
                                                <label for="remember_me">Remember Me</label>
                                            </div>
                                            <a href="javascript:void(0)" id="resend_code_btn" class="resend_code">Forgot Password?</a><br><br>
                                            <a href="javascript:location.reload()" id="" class="">Login via different email?</a>
                                            <span id="timer" style="display:none;"><span
                                                    id="time">15:00</span> Minutes (Wait for the resend)</span>
                                                    <p class="verifica_nots" style="display:none">We have sent a temporary password to your email.</p>
                                        </div>

                                    </div>
                                    <div id="password-reset" style="display:none;">
                                        <div class="titleIcon">
                                            <img src="<?php echo base_url(); ?>uploads/front/images/verify-icon.svg"
                                                alt="">
                                        </div>
                                        <p class="small-text">As you have logged-in via your temporary password, please create a new password here:</p>
                                        <p class="small-notes">Note: Temporary password was only for one-time-use. Once you set the new password, you can not use the temporary password anymore.</p>
                                        <h2>Reset password</h2>
                                        <div class="form-inline mb-15 reset-password-section user-panel-login">
                                            <div class="psw-1">
                                                <span class="input-group-text"><i class="fas fa-eye"></i></span>
                                                <input type="password" name="new-password" id="new-password" class="form-control"
                                                    placeholder="Enter new password" autocomplete="new-password">
                                            </div>
                                            <div class="psw-2">
                                                <span class="input-group-text"><i class="fas fa-eye"></i></span>
                                                <input type="password" name="new-password-confirm" id="new-password-confirm" class="form-control"
                                                    placeholder="Confirm your new password" autocomplete="new-password">
                                                
                                            </div>
                                            <button type="button" id="reset-password-btn" class="btn">Reset</button>
                                        </div>
                                        <p id="verify_new_code_error" class="error text-danger "></p>
                                        <p>It is required for the password to be at least 8 characters long and must have one special character.</p>
                                        <!-- <p class="nots mb-15">Enter your verification code from your registered email.</p> -->
                                        <!-- <div class="resend_code_div mb-15">
                                            <a href="javascript:void(0)" id="resend_code_btn" class="resend_code">Resend
                                                Code</a>
                                            <span id="timer" style="display:none;"><span
                                                    id="time">10</span> Seconds (Wait for the resend)</span>
                                        </div> -->
                                        <br>
                                        <a href="javascript:location.reload()" id="" class="">Login via different email?</a>
                                    </div>
                                    <p id="verify_new_code_success" class="error text-success "></p>
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
            e.preventDefault();
            $('#resend_code_btn').hide();
            $('span#timer').show();
            $('#for_forgot_psw').val(1);

            timer_set_resend_otp();
            var form = $("#form_email_check");
            
            var ajax_url = "<?= site_url('user/');?>";
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
            var email = $('#email').val();
            if (email == '') {
                $(".error_authenticate").html('Please enter email.');
                return false;
            }
            $(".error_authenticate").html('');
            var ajax_url = "<?= site_url('user/');?>";
            $.ajax({
                url: ajax_url + 'check_email_address',
                type: 'post',
                data: form.serialize(),
                beforeSend: function(res) {
                    $('#verify_code_error').text('');
                    $('.error_authenticate.error').html();
                    $('.btn').addClass('loading');
                    $('.btn').prop('disabled', true);
                },
                success: function(response) {
                    $('.btn').removeClass('loading');
                    $('.btn').prop('disabled', false);
                    var result = jQuery.parseJSON(response);
                    if (result.response == 'failure') {
                        $('#step-login2').show();
                        $('#step-login1').hide();
                    }
                    if (result.response == 'closed') {
                        $('.error_authenticate.error').html(result.message);
                    }
                    if (result.response == 'success') {
                        $('#step-login1').hide();
                        $('#step-login3').show();
                        jQuery("#step-login3 input#password").focus();
                        // location.reload();
                    }
                }
            });
        });
        $(document).on('click', '#reset-password-btn', function(e) {
            e.preventDefault();
            console.log('reset my psw');
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
            // var validPassword  = /^[a-zA-Z0-9]+$/.test(newpassword);//Avoid special characters
            var specialCharacterRegex = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
            var validPassword  = /^[a-zA-Z0-9]+$/.test(newpassword);
            if (!specialCharacterRegex.test(newpassword)) {
                //alert("Password should not contain any special characters");
                jQuery("#verify_new_code_error").html("Password should  contain atleast one special character");
                return false;
            }
            //return false;
            $(".error_authenticate").html('');
            var ajax_url = "<?= site_url('user/');?>";
            $.ajax({
                url: ajax_url + 'reset_password',
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
                        //Swal.fire('Password Reset Successful!', '', 'success');
                        Swal.fire("Password Reset Successful!", '', 'success').then(function(){location.reload();});

                        // location.reload();
                        // $('#password-reset').hide();
                        // jQuery("#verify_new_code_success").html(result.message+' Click <a href="javascript:location.reload()">here</a> to login');
                    }
                }
            });
        });
        $(document).on('submit', '#form_email_check', function(e) {
            e.preventDefault();
            var checkstep = 0;
            $('#for_forgot_psw').val(0);
            var form = $(this);
            var password = $('input#password').val();
            var ajax_url = "<?= site_url('user/');?>";
            if (!$('#step-login1').is(':visible') && password == '') {
                $("#verify_code_error").html('Please enter Password.');
                return false;
            }
            if (password == '' && $('input#email').val()!= '') {
                 checkstep = 2;
                var _url = ajax_url + 'check_email_address';
            } else if($('input#new-password').val()!= '') {
                console.log('verify code');
                //return false;
                 checkstep = 4;
                var _url = ajax_url + 'check_login';
            } else if (password != '' && $('input#email').val()!= '' && $('input#new-password').val()== ''){
                checkstep = 3;
                var _url = ajax_url + 'check_login';
            }
            // } else {
            //     console.log('verify code');
            //     //return false;
            //      checkstep = 3;
            //     var _url = ajax_url + 'check_login';
            // }
            if(checkstep == 2 || checkstep == 3){
                $.ajax({
                    url: _url,
                    type: 'post',
                    data: form.serialize(),
                    beforeSend: function(res) {
                        $('#verify_code_error').text('');
                        $('.btn').addClass('loading');
                        $('.error_authenticate.error').html('');
                        $('.btn').prop('disabled', true);
                    },
                    success: function(response) {
                        $('.btn').prop('disabled', false);
                        $('.btn').removeClass('loading');
                        var result = jQuery.parseJSON(response);
                        if (checkstep == 2) {
                            if (result.response == 'failure') {
                                $('#step-login2').show();
                                $('#step-login1').hide();
                            }
                            if (result.response == 'closed') {
                                $('.error_authenticate.error').html(result.message);
                                $('#verify_code_error').html(result.message);
                            }
                            if (result.response == 'success') {
                                $('#step-login1').hide();
                                $('#step-login3').show();
                                jQuery("#step-login3 input#password").focus();
                                // location.reload();
                            }
                        } else {
                            if (result.response == 'resetpassword') {
                                console.log('need to rest password');
                                $('#step-login2').hide();
                                $('#step-login3').hide();
                                $('#step-login1').hide();
                                $('#password-reset').show();
                                // $('#verify_code_error').text(result.message);
                            }
                            if (result.response == 'failure') {
                                $('#step-login2').hide();
                                $('#step-login3').show();
                                $('#step-login1').hide();
                                $('#verify_code_error').text(result.message);
                            }
                            if (result.response == 'closed') {
                                $('.error_authenticate.error').html(result.message);
                                $('#verify_code_error').html(result.message);
                            }
                            if (result.response == 'success') {
                                //console.log(result);
                                var cookieValue = document.cookie.replace(/(?:(?:^|.*;\s*)invite_cookie\s*\=\s*([^;]*).*$)|^.*$/, "$1");
                                
                                if(result.notify_id != ''){
                                    window.location.href = '<?php echo site_url('user/check_invitation/');?>'+result.notify_id;
                                }
                                else if(cookieValue){
                                    window.location.href = '<?php echo site_url('user/check_invitation/');?>'+cookieValue;
                                }
                                else{
                                location.reload();
                                }
                            }
                        }
                    }
                });
            }else if (checkstep == 4){
                jQuery('#reset-password-btn').trigger('click');

            }

        });
    });
    </script>
</body>

</html>