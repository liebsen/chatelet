<?php
/**
 * top.php
 *
 * Author: pixelcave
 *
 * The first block of code used in every page of the template
 * Start of html, <head> tag, as well as the header of the page are included here
 *
 */
?>
<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title><?php echo $template['title'] ?></title>

        <meta name="description" content="<?php echo $template['description'] ?>">
        <meta name="author" content="<?php echo $template['author'] ?>">
        <meta name="robots" content="noindex, nofollow">

        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="img/favicon.ico">
        <link rel="apple-touch-icon" href="img/icon57.png" sizes="57x57">
        <link rel="apple-touch-icon" href="img/icon72.png" sizes="72x72">
        <link rel="apple-touch-icon" href="img/icon76.png" sizes="76x76">
        <link rel="apple-touch-icon" href="img/icon114.png" sizes="114x114">
        <link rel="apple-touch-icon" href="img/icon120.png" sizes="120x120">
        <link rel="apple-touch-icon" href="img/icon144.png" sizes="144x144">
        <link rel="apple-touch-icon" href="img/icon152.png" sizes="152x152">
        <!-- END Icons -->

        <!-- Stylesheets -->
        <?php
            echo $this->Html->css('bootstrap');
            echo $this->Html->css('plugins');
            echo $this->Html->css('main');

            if ($template['theme']) {
                echo $this->Html->css('themes/'.$template['theme']);
            }
            
            echo $this->Html->css('themes');
            echo $this->fetch('css');

            echo $this->Html->script('vendor/modernizr-2.7.1-respond-1.4.2.min.js');
        ?>
    </head>

    <!-- Body -->
    <!-- In the PHP version you can set the following options from the config file -->
    <!-- Add the class .hide-side-content to <body> to hide side content by default -->
    <?php
    $body_classes = '';

    if ($template['header'] == 'fixed-top') {
        $body_classes = 'header-fixed-top';
    } else if ($template['header'] == 'fixed-bottom') {
        $body_classes = 'header-fixed-bottom';
    }

    if ($template['side_content']) {
        $body_classes .= ' ' . $template['side_content'];
    }
    ?>
    <body<?php if ($body_classes) { echo ' class="' . $body_classes . '"'; } ?>>
        <!-- Page Container -->
        <!-- In the PHP version you can set the following options from the config file -->
        <!-- Add the class .full-width for a full width page -->
        <div id="page-container"<?php if ($template['page'] == 'full-width') { echo ' class="full-width"'; } ?>>
            <!-- Header -->
            <!-- In the PHP version you can set the following options from the config file -->
            <!-- Add the class .navbar-fixed-top or .navbar-fixed-bottom for a fixed header on top or bottom respectively -->
            <!-- If you add the class .navbar-fixed-top remember to add the class .header-fixed-top to <body> element! -->
            <!-- If you add the class .navbar-fixed-bottom remember to add the class .header-fixed-bottom to <body> element! -->
            <!-- <header class="navbar navbar-inverse navbar-fixed-top"> -->
            <!-- <header class="navbar navbar-inverse navbar-fixed-bottom"> -->
            <header class="navbar navbar-inverse<?php if ($template['header'] == 'fixed-top') { echo ' navbar-fixed-top'; } else if ($template['header'] == 'fixed-bottom') { echo ' navbar-fixed-bottom'; } ?>">
                <!-- div#row -->
                <div class="row">
                    <!-- Sidebar Toggle Buttons (Desktop & Tablet) -->
                    <div class="col-sm-4 hidden-xs">
                        <ul class="navbar-nav-custom pull-left">
                            <!-- Desktop Button (Visible only on desktop resolutions) -->
                            <li class="visible-md visible-lg">
                                <a href="javascript:void(0)" id="toggle-side-content">
                                    <i class="fa fa-bars"></i>
                                </a>
                            </li>
                            <!-- END Desktop Button -->

                            <!-- Divider -->
                            <li class="divider-vertical"></li>
                            <li class="dropdown dropdown-theme-options pull-right">
                                <a href="<?=$this->Html->url(array('controller'=>'admin','action'=>'logout'))?>" class="dropdown-toggle">Salir</a>
                            </li>
                        </ul>
                    </div>
                    <!-- END Sidebar Toggle Buttons -->
                </div>
                <!-- END div#row -->
            </header>
            <!-- END Header -->
