<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo $title;?></title>
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/plugins/node-waves/waves.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/plugins/animate-css/animate.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
    <style>
        .red
        {
            color: red !important;
            font-size: 16px;
        }
    </style>
</head>
<body class="login-page">
    <div class="login-box">
        <div class="logo">
            <a href="javascript:void(0);">Admin</a>
            <small>Admin Reseller</small>
        </div>
        <div class="card">
            <div class="body">
                <form id="signin" method="POST" action="<?php echo base_url() ?>admin/signin">
                    <div class="msg">Sign in to start your session</div>
                    <?php 
                    if($this->session->flashdata('error'))
                    { ?>
                        <div class="msg red"><?php echo $this->session->flashdata('error'); ?></div>
                    <?php
                    }
                    ?>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo set_value('email') ?>"  >                            
                        </div>
                        <span class="red" id="password_error"> <?php echo form_error('email'); ?></span>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo set_value('password') ?>" >                            
                        </div>
                        <span class="red" id="password_error"> <?php echo form_error('password'); ?></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 p-t-5">
                            <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-pink">
                            <label for="rememberme">Remember Me</label>
                        </div>
                        <div class="col-xs-4">
                            <button class="btn btn-block bg-pink waves-effect" type="submit" name="Submit"> SIGN IN</button>
                        </div>
                    </div>
                    <div class="row m-t-15 m-b--20">
                        <div class="col-xs-6">
                        </div>
                        <div class="col-xs-6 align-right">
                            <a href="forgot-password.html">Forgot Password?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/node-waves/waves.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/jquery.validate.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/admin.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/pages/examples/sign-in.js"></script>
</body>

</html>