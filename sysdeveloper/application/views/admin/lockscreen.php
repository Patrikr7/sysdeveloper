<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="pt-br" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="pt-br">
<!--<![endif]-->

<head>
    <meta charset="utf-8" />
    <title><?php echo $title_page; ?></title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="<?php echo AUTHOR; ?>" name="author" />

    <link rel="shortcut icon" href="<?php echo base_url('assets/img/' . FAVICON) ?>">
    <link rel="base" href="<?php echo base_url(); ?>" />

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.min.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/plugins/font-awesome/5.0/css/fontawesome-all.min.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/plugins/toastr/toastr.min.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/plugins/sweetalert/sweetalert.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/plugins/animate/animate.min.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/admin/css/style.min.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/admin/css/style-responsive.min.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/admin/css/default.css'); ?>" rel="stylesheet" id="theme" />
    <link href="<?php echo base_url('assets/admin/css/styles.css'); ?>" rel="stylesheet" id="theme" />
    <!-- ================== END BASE CSS STYLE ================== -->

</head>

<body class="pace-top bg-white">
    <!-- begin #page-loader -->
    <div id="page-loader" class="fade show"><span class="spinner"></span></div>
    <!-- end #page-loader -->

    <!-- begin #page-container -->
    <div id="page-container" class="fade">
        <!-- begin login -->
        <div class="login login-with-news-feed">
            <!-- begin news-feed -->
            <div class="news-feed">
                <div class="news-image" style="background-image: url(<?php echo base_url('assets/admin/img/login-bg-7.jpg'); ?>)"></div>
                <div class="news-caption">
                    <h4 class="caption-title"><?php echo getenv('SIS_NAME'); ?></h4>
                    <p>
                        <?php echo getenv('SIS_INICIAL'); ?>
                    </p>
                </div>
            </div>
            <!-- end news-feed -->
            <!-- begin right-content -->
            <div class="right-content">
                <!-- begin login-header -->
                <div class="login-header">
                    <div class="brand text-center">
                        <figure>
                            <img class="img-fluid img-thumbnail" src="<?php echo (empty($this->session->userOnline['user_img']) ? base_url('assets/admin/img/system.png') : base_url('assets/uploads/users/' . $this->session->userOnline['user_img'])); ?>" />
                        </figure>
                    </div>
                </div>
                <!-- end login-header -->
                <!-- begin login-content -->
                <div class="login-content">
                    <form id="form_login" name="form_login" method="post" action="unlock" enctype="multipart/form-data">
                        <p><strong><?php echo $this->session->userOnline['user_name']; ?></strong>, você está na tela de bloqueio. O sistema principal foi encerrado e você precisa digitar sua senha para voltar.</p>
                        <div class="form-group m-b-15">
                            <input type="password" class="form-control" id="user_pass" name="user_pass" placeholder="******">
                        </div>
                        <div class="login-buttons">
                            <button type="submit" class="btn btn-info btn-block btn-lg" title="Desbloquear">Desbloquear <i class="fa fa-spinner fa-spin fa-fw form_load" style="display:none;"></i></button>
                        </div>
                        <div class="m-t-20 m-b-40 p-b-40 text-center">
                            Esqueceu a senha? Clique <a href="<?php echo base_url('admin/forgot-password'); ?>" class="text-success">aqui</a> para redefinir sua senha.
                        </div>
                        <hr />
                        <p class="text-center text-grey-darker">
                            &copy; Sistema Administrativo 2020
                        </p>
                    </form>
                </div>
                <!-- end login-content -->
            </div>
            <!-- end right-container -->
        </div>
        <!-- end login -->
    </div>
    <!-- end page container -->

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/jquery/jquery-form.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <!--[if lt IE 9]>
		<script src="<?php echo base_url('assets/admin/crossbrowserjs/html5shiv.js'); ?>"></script>
		<script src="<?php echo base_url('assets/admin/crossbrowserjs/respond.min.js'); ?>"></script>
		<script src="<?php echo base_url('assets/admin/crossbrowserjs/excanvas.min.js'); ?>"></script>
	<![endif]-->
    <script src="<?php echo base_url('assets/plugins/slimscroll/jquery.slimscroll.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/js-cookie/js.cookie.js'); ?>"></script>
    <script src="<?php echo base_url('assets/admin/js/default.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/admin/js/apps.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/toastr/toastr.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/admin/js/send.js'); ?>"></script>
    <!-- ================== END BASE JS ================== -->

    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
</body>

</html>