<!DOCTYPE html>
<html lang="zxx" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo base_url(); ?>/uploads/assets/img/basic/favicon.ico" type="image/x-icon">
    <title>House Keeping</title>
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/uploads/assets/css/app.css">
    <style>
    .loader {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: #F5F8FA;
        z-index: 9998;
        text-align: center;
    }

    .plane-container {
        position: absolute;
        top: 50%;
        left: 50%;
    }
    </style>
    <!-- Js -->
    <!--
    --- Head Part - Use Jquery anywhere at page.
    --- http://writing.colin-gourlay.com/safely-using-ready-before-including-jquery/
    -->
    <script>
    (function(w, d, u) {
        w.readyQ = [];
        w.bindReadyQ = [];

        function p(x, y) {
            if (x == "ready") {
                w.bindReadyQ.push(y);
            } else {
                w.readyQ.push(x);
            }
        };
        var a = {
            ready: p,
            bind: p
        };
        w.$ = w.jQuery = function(f) {
            if (f === d || f === u) {
                return a
            } else {
                p(f)
            }
        }
    })(window, document)
    </script>
</head>

<body class="light">
    <!-- Pre loader -->
    <div id="loader" class="loader">
        <div class="plane-container">
            <div class="preloader-wrapper small active">
                <div class="spinner-layer spinner-blue">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
                <div class="spinner-layer spinner-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
                <div class="spinner-layer spinner-yellow">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
                <div class="spinner-layer spinner-green">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="app">
        <main>
            <div id="primary" class="p-t-b-100 height-full">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 mx-md-auto paper-card">
                            <?php  $errors = validation_errors();
                            if (!empty($errors)) {
                                echo '<div class="alert alert-danger">';
                                echo $errors;
                                echo '</div>';
                            }
                            if(isset($error)){ echo '<p class="alert alert-danger">שם משתמש / סיסמא שגויים.</p>';}
                            ?>
                            <div class="text-center">
                                <img src="<?php echo base_url(); ?>/uploads/assets/img/dummy/u4.png" alt="">
                                <h3 class="mt-2">לאפס את הסיסמה</h3>
                                <p class="p-t-b-20">הסיסמה חייבת להיות באורך של לפחות 6 תווים</p>
                            </div>
                            <section id="login-step-1">
                            <div class="error_authenticate"></div>
                                <form method="post" action="" id="reset_password_form">
                                <div class="error_login"></div>
                                <div class="form-group has-icon"><i class="icon-key"></i>
                                    <input type="password" id="new_password" name="new_password"
                                        class="form-control form-control-lg" placeholder="סיסמה חדשה" required>
                                    <input type="hidden" name="id" value="<?=$user_data['id']?>">
                                </div>
                                <div class="form-group has-icon"><i class="icon-key"></i>
                                    <input type="password" id="confirm_password" name="confirm_password"
                                        class="form-control form-control-lg" placeholder="כתוב את הסיסמא מחדש" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block">אפס סיסמה</button>
                                    </form>
                            </section>
                            
                        </div>
                    </div>
                </div>
            </div>
            <!-- #primary -->
        </main>
        <!-- Right Sidebar -->
        <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
        <div class="control-sidebar-bg shadow white fixed"></div>
    </div>
    <!--/#app -->
    <script src="<?php echo base_url(); ?>/uploads/assets/js/app.js"></script>
    <script>
    jQuery(document).ready(function() {
        $(document).on('submit', '#reset_password_form', function(e) {
            e.preventDefault();
            var form = $(this);
            var password = $('#new_password').val();
            if (password.length < 6) { 
                var msg = '<p class="alert alert-danger">הסיסמה צריכה להכיל לפחות שש אותיות</p>';
                $(".error_authenticate").html(msg);
                return false;
            }
            var confirm_password = $('#confirm_password').val();
            if (password != confirm_password) { 
                var msg = '<p class="alert alert-danger">הסיסמה לא תואמת</p>';
                $(".error_authenticate").html(msg);
                return false;
            }
            var ajax_url = "<?= site_url('admin/');?>";
            $.ajax({
                url: ajax_url + 'reset_password_form',
                type: 'post',
                data: form.serialize(),
                success: function(response) {
                    location.reload();
                }
            });
        });
    });
    </script>
    <!--
--- Footer Part - Use Jquery anywhere at page.
--- http://writing.colin-gourlay.com/safely-using-ready-before-including-jquery/
-->
    <script>
    (function($, d) {
        $.each(readyQ, function(i, f) {
            $(f)
        });
        $.each(bindReadyQ, function(i, f) {
            $(d).bind("ready", f)
        })
    })(jQuery, document)
    </script>
</body>

</html>