<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="pt-br" itemscope itemtype="https://schema.org/WebSite">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="content-language" content="pt-br">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="theme-color" content="#">
    <meta name="msapplication-navbutton-color" content="#">
    <title><?php echo $title_page; ?></title>

    <link rel="shortcut icon" href="<?php echo base_url('assets/img/' . FAVICON) ?>">

    <meta name="robots" content="index, follow" />

    <meta content="<?php echo AUTHOR; ?>" name="author" />
    <link rel="base" href="<?php echo base_url('admin/') ?>" />

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.min.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/plugins/font-awesome/css/fontawesome-all.min.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/plugins/animate/animate.min.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/plugins/toastr/toastr.min.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/plugins/sweetalert/sweetalert.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/admin/css/style.min.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/admin/css/style-responsive.min.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/admin/css/default.css'); ?>" rel="stylesheet" id="theme" />
    <link href="<?php echo base_url('assets/admin/css/styles.css'); ?>" rel="stylesheet" />
    <!-- ================== END BASE CSS STYLE ================== -->

    <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <!-- begin #page-loader -->
    <div id="page-loader" class="fade show"><span class="spinner"></span></div>
    <!-- end #page-loader -->

    <!-- begin #page-container -->
    <div id="page-container" class="fade page-sidebar-fixed page-header-fixed page-with-wide-sidebar">
        <!-- begin #header -->
        <?php $this->load->view('admin/template/tpl-navbar'); ?>
        <!-- end #header -->

        <!-- begin #sidebar -->
        <?php $this->load->view('admin/template/tpl-sidebar'); ?>
        <!-- end #sidebar -->

        <!-- begin #content -->
        <?php echo $contents; ?>
        <!-- end #content -->

        <!-- begin #footer -->
        <?php $this->load->view('admin/template/tpl-footer'); ?>
        <!-- end #footer -->

        <!-- begin scroll to top btn -->
        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
        <!-- end scroll to top btn -->
    </div>
    <!-- end page container -->

    <!--[if lt IE 9]>
        <script src="<?php echo base_url('assets/admin/crossbrowserjs/html5shiv.js'); ?>"></script>
        <script src="<?php echo base_url('assets/admin/crossbrowserjs/respond.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/admin/crossbrowserjs/excanvas.min.js'); ?>"></script>
    <![endif]-->

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/jquery/jquery-form.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/jquery/jquery.maskedinput.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/jquery/jquery.maskMoney.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/slimscroll/jquery.slimscroll.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/js-cookie/js.cookie.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/toastr/toastr.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/sweetalert/sweetalert.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/admin/js/default.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/admin/js/apps.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/boot.js'); ?>"></script>
    <script src="<?php echo base_url('assets/admin/js/function.js'); ?>"></script>
    <!-- ================== END BASE JS ================== -->

    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
</body>

</html>