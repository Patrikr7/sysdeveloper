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
    <?php
    echo assets_css('plugins/jquery-ui', 'jquery-ui.min.css');
    echo assets_css('plugins/bootstrap/css', 'bootstrap.min.css');
    echo assets_css('plugins/font-awesome/css', 'fontawesome-all.min.css');
    echo assets_css('plugins/animate', 'animate.min.css');
    echo assets_css('plugins/toastr', 'toastr.min.css');
    echo assets_css('plugins/sweetalert', 'sweetalert.css');

    if(!empty($styles) || isset($styles)):
        foreach($styles as $style => $value) :
            echo assets_js($value['dir'], $value['file']);
        endforeach;
    endif;

    echo assets_css('admin/css', [
        'style.min.css',
        'style-responsive.min.css',
        'default.css',
        'styles.css',
    ]);
    ?>
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
        <?php echo assets_js('admin/crossbrowserjs', [
            'html5shiv.js',
            'respond.min.js',
            'excanvas.min.js'
        ]); ?>
    <![endif]-->

    <!-- ================== BEGIN BASE JS ================== -->
    <?php 
        echo assets_js('plugins', [
            'jquery/jquery.min.js',
            'jquery/jquery-form.js',
            'bootstrap/js/bootstrap.bundle.min.js',
            'jquery/jquery.maskedinput.min.js',
            'jquery/jquery.maskMoney.min.js',
            'slimscroll/jquery.slimscroll.min.js',
            'js-cookie/js.cookie.js',
            'toastr/toastr.min.js',
            'sweetalert/sweetalert.min.js'    
        ]);

        if(!empty($scripts) || isset($scripts)):
            foreach($scripts as $script => $value) :
                echo assets_js($value['dir'], $value['file']);
            endforeach;
        endif;
        
        echo assets_js('admin/js', [
            'default.min.js',
            'apps.js'
        ]);
        
        echo assets_js('js', 'boot.js');

        echo assets_js('admin/js', [
            'function.js',
            'send.js'
        ]);
    ?>    
    <!-- ================== END BASE JS ================== -->

    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
</body>

</html>