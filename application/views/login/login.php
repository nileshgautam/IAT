<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="<?php echo base_url(); ?>assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/libs/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
   <!-- jQuery 3 -->
   <script src="<?php echo base_url('assets/vendor/jquery/jquery-3.3.1.min.js') ?>"></script>
    <!-- Alert Box -->
    <script src="  <?php echo base_url('assets/js/bootstrap-notify.min.js') ?>"></script>
    <script src="  <?php echo base_url('assets/js/MyScriptLibrary.js') ?>"></script>
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
        }
    </style>
    <script>
        let baseUrl="<?php echo base_url(); ?>"
        
    </script>
</head>

<body>
    <!-- ============================================================== -->
    <!-- login page  -->
    <!-- ============================================================== -->
    <div class="splash-container">
        <div class="card ">
            <div class="card-header text-center"><a href="../index.html"><img class="logo-img" src="<?php echo base_url(); ?>assets/images/icons/audit.svg" alt="logo" width="32"></a><span class="splash-description">Please enter your user information.</span></div>
            <div class="card-body">
            <!-- action="<?php echo base_url('Login/auth') ?>"  -->
                <form class="login-from" method="post">
                    <div class="form-group">
                        <input class="form-control form-control-lg" id="username" type="email" name="email" placeholder="Username" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" id="password" type="password" name="password" placeholder="Password" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="remember_me" name="remember_me"><span class="custom-control-label">Remember Me</span>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>
                </form>
            </div>
            <!-- <div class="card-footer bg-white p-0 ">
                <div class="card-footer-item card-footer-item-bordered float-right">
                    <a href="#" class="footer-link">Forgot Password</a>
                </div>
            </div> -->
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- end login page  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>

    <?php
    if ($this->session->flashdata('success')) {
    ?><script>
            showAlert("<?php echo $this->session->flashdata('success'); ?>", 'success');
        </script>
    <?php
    }
    ?>

    <?php
    if ($this->session->flashdata('error')) {
    ?>
        <script>
            showAlert("<?php echo $this->session->flashdata('error'); ?>", 'danger');
        </script>
    <?php
    }
    ?>
</body>


</html>