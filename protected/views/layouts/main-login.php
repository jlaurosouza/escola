<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

        <title> Escola - Escola de idiomas </title>
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Use the correct meta names below for your web application
                 Ref: http://davidbcalhoun.com/2010/viewport-metatag

        <meta name="HandheldFriendly" content="True">
        <meta name="MobileOptimized" content="320">-->

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <!-- Icone Title -->
        <link rel="icon" href="<?= Yii::app()->request->baseUrl; ?>/images/favicon.png" type="image/x-icon" />
        <link rel="shortcut icon" href="<?= Yii::app()->request->baseUrl; ?>/images/favicon.png" type="image/x-icon" />

        <!-- Basic Styles -->
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/font-awesome.min.css">

        <!-- SmartAdmin Styles : Please note (smartadmin-production.css) was created using LESS variables -->
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/smartadmin-production.css">
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/smartadmin-skins.css">

        <!-- SmartAdmin RTL Support is under construction
                <link rel="stylesheet" type="text/css" media="screen" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/smartadmin-rtl.css"> -->

        <!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/demo.css">

        <!-- login css -->
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo Yii::app()->request->baseUrl; ?>/css/login.css">

        <!-- FAVICONS -->
        <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/img/favicon/favicon.ico" type="image/x-icon">
        <link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/img/favicon/favicon.ico" type="image/x-icon">

        <!-- GOOGLE FONT
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">-->

        <!--================================================== -->

        <!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/plugin/pace/pace.min.js"></script>

        <!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
        <!--
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        
        <script> if (!window.jQuery) {
                document.write('<script src="js/libs/jquery-2.0.2.min.js"><\/script>');
            }</script>
        -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/libs/jquery-2.0.2.min.js"></script>

        <!--
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        
        <script> if (!window.jQuery.ui) {
                document.write('<script src="js/libs/jquery-ui-1.10.3.min.js"><\/script>');
            }</script>
        -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/libs/jquery-ui-1.10.3.min.js"></script>

        <!-- JS TOUCH : include this plugin for mobile drag / drop touch events
        <script src="js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script> -->

        <!-- BOOTSTRAP JS -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/bootstrap/bootstrap.min.js"></script>

        <!-- CUSTOM NOTIFICATION -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/notification/SmartNotification.min.js"></script>

        <!-- JARVIS WIDGETS -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/smartwidgets/jarvis.widget.min.js"></script>

        <!-- EASY PIE CHARTS -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js"></script>

        <!-- SPARKLINES -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/plugin/sparkline/jquery.sparkline.min.js"></script>

        <!-- JQUERY VALIDATE -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/plugin/jquery-validate/jquery.validate.min.js"></script>

        <!-- JQUERY MASKED INPUT -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/plugin/masked-input/jquery.maskedinput.min.js"></script>

        <!-- JQUERY SELECT2 INPUT -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/plugin/select2/select2.min.js"></script>

        <!-- JQUERY UI + Bootstrap Slider -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/plugin/bootstrap-slider/bootstrap-slider.min.js"></script>

        <!-- browser msie issue fix -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/plugin/msie-fix/jquery.mb.browser.min.js"></script>

        <!-- FastClick: For mobile devices -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/plugin/fastclick/fastclick.js"></script>

        <!--[if IE 7]>

                <h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

        <![endif]-->

        <!-- MAIN APP JS FILE -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/app.js"></script>       

    </head>
    <body id="login" class="animated fadeInDown">
        <!-- possible classes: minified, no-right-panel, fixed-ribbon, fixed-header, fixed-width-->       
        <header id="header">
                <!--<span id="logo"></span>-->

            <div id="logo-group">
                     <!-- END AJAX-DROPDOWN -->
            </div>                                    
            <span id="login-header-space"> 
            </span>
        </header>
        <div id="main" role="main">

            <!-- MAIN CONTENT -->
            <div id="content" class="container">
                <div class="row"> <br><br></div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4"></div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">                        
                        <?php echo $content; ?>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4"></div>
                </div>
            </div>

        </div>

    </body>
</html>