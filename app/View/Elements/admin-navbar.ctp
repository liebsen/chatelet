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
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
        <meta name="description" content="<?php echo $template['description'] ?>">
        <meta name="author" content="<?php echo $template['author'] ?>">
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">
        <link rel="shortcut icon" href="/img/favicon.ico">

        <!-- Stylesheets -->
        <?php
            echo $this->Html->css('bootstrap');
            echo $this->Html->css('jquery.growl.css?v=' . $version['ver']);
            echo $this->Html->css('main.css?v=' . $version['ver']);
            echo $this->Html->css('plugins');

            // echo $this->Html->css('animate.css?v=' . $version['ver']);
            // echo $this->Html->css('font-awesome.min');

            if ($template['theme']) {
                // echo $this->Html->css('themes/'.$template['theme']);
            }
            
            //echo $this->Html->css('themes');
            echo $this->fetch('css');
            echo $this->Html->script('vendor/modernizr-2.7.1-respond-1.4.2.min.js');
        ?>
        
        <link href="https://fonts.googleapis.com/css?family=<?= @urlencode(@$settings['google_font_name']) ?>:<?= @$settings['google_font_size'] ?>" rel="stylesheet">
        <style type="text/css">
            html, body { 
                font-family: '<?=@$settings['google_font_name'] ?>', Verdana, Arial, Sans-Serif!important;
                line-height: 1.25;
                font-size: 14px; 
                font-weight: 600;
                text-transform: uppercase;
                color: #a5a5a5;
                font-weight: 300;                
            }
        </style>

        <script>
        window.baseUrl  = "<?=Router::url('/',true)?>";
        </script>
    </head>

    <!-- Body -->
    <!-- In the PHP version you can set the following options from the config file -->
    <!-- Add the class .hide-side-content to <body> to hide side content by default -->
    <?php
    $body_classes = '';

    if ($template['header'] == 'fixed-top') {
        $body_classes = 'loading header-fixed-top';
    } else if ($template['header'] == 'fixed-bottom') {
        $body_classes = 'loading header-fixed-bottom';
    }

    if ($template['side_content']) {
        $body_classes .= ' ' . $template['side_content'];
    }
    ?>
    <body<?php if ($body_classes) { echo ' class="' . $body_classes . '"'; } ?>>

        <?php echo $this->Session->flash() ?>

        <div id="page-loader"></div>
        <div id="page-container"<?php if ($template['page'] == 'full-width') { echo ' class="full-width"'; } ?>>
            <header class="navbar navbar-inverse<?php if ($template['header'] == 'fixed-top') { echo ' navbar-fixed-top'; } else if ($template['header'] == 'fixed-bottom') { echo ' navbar-fixed-bottom'; } ?>">
                <!-- div#row -->
                <div class="row">
                    <!-- Sidebar Toggle Buttons (Desktop & Tablet) -->
                    <div class="col-sm-12 is-flex-center">
                        <ul class="navbar-nav-custom pull-left">
                            <!-- Desktop Button (Visible only on desktop resolutions) -->
                            <li class="mini-profile">
                                <!-- Mini Profile -->
                                <a href="/" target="_blank" title="<?=@$version['count'] ?> - <?=@$version['date'] ?>">
                                    <?php echo $this->Html->image('chatelet_blanco.png', array('class' => 'img-responsive')); ?>
                                </a>
                                <!-- END Mini Profile -->                                
                            </li>
                            <!-- END Desktop Button -->
                        </ul>
                        <ul class="nav navbar-nav navbar-right" style="margin-right: 5px!important;">
                            <!-- Divider -->

                            <!--li class="dropdown dropdown-theme-options pull-right">
                                <a href="<?=$this->Html->url(array('controller'=>'admin','action'=>'logout'))?>" class="dropdown-toggle">
                                    <i class="gi gi-exit"></i> 
                                    Salir
                                </a>
                            </li>

                            <li class="dropdown dropdown-theme-options">
                                <a href="/" target="_blank">
                                    <i class="gi gi-home"></i> 
                                    Tienda
                                </a>
                            </li-->
                            <?php if (!empty($h1)): ?>
                            <li class="section-indicator">
                                <a href="#" class="text-white">
                                    <i class="<?php echo $h1['icon'] ?>"></i> <span><?php echo $h1['name']; ?></span>
                                </a>
                            </li>
                                <?php endif ?>
                            <li class="divider-vertical"></li>                                
                            <li>
                                <a href="javascript:void(0)" id="toggle-side-content" class="collapsed text-white" data-target="#navbar" data-toggle="collapse" aria-expanded="false" aria-controls="navbar">
                                    <i class="fa fa-bars"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- END Sidebar Toggle Buttons -->
                </div>
                <!-- END div#row -->
                <!--div id="navbar" class="visible-sm visible-xs collapse" aria-expanded="false" style="height: 0px;">
                  <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                      <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">Nav header</li>
                        <li><a href="#">Separated link</a></li>
                        <li><a href="#">One more separated link</a></li>
                      </ul>
                    </li>
                  </ul>
                </div-->
            </header>
            <!-- END Header -->
