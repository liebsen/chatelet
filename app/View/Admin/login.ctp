<?php 
$this->layout = ''; 
echo $this->Session->flash();
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
        <link rel="shortcut icon" href="/img/favicon.ico">
        <!--link rel="apple-touch-icon" href="/img/icon57.png" sizes="57x57">
        <link rel="apple-touch-icon" href="/img/icon72.png" sizes="72x72">
        <link rel="apple-touch-icon" href="/img/icon76.png" sizes="76x76">
        <link rel="apple-touch-icon" href="/img/icon114.png" sizes="114x114">
        <link rel="apple-touch-icon" href="/img/icon120.png" sizes="120x120">
        <link rel="apple-touch-icon" href="/img/icon144.png" sizes="144x144">
        <link rel="apple-touch-icon" href="/img/icon152.png" sizes="152x152"-->
        <!-- END Icons -->

        <!-- Stylesheets -->
        <!-- Bootstrap is included in its original form, unaltered -->
        <link rel="stylesheet" href="../css/bootstrap.css">

        <!-- Related styles of various icon packs and javascript plugins -->
        <link rel="stylesheet" href="../css/plugins.css">

        <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->
        <link rel="stylesheet" href="../css/main.css">

        <!-- Load a specific file here from css/themes/ folder to alter the default theme of the template -->
        <?php if ($template['theme']) { ?>
        <link id="theme-link" rel="stylesheet" href="css/themes/<?php echo $template['theme']; ?>.css">
        <?php } ?>

        <!-- The themes stylesheet of this template (for using specific theme color in individual elements - must included last) -->
        <link rel="stylesheet" href="../css/themes.css">
        <link rel="stylesheet" href="../css/jquery.growl.css">
        <!-- END Stylesheets -->

        <!-- Modernizr (browser feature detection library) & Respond.js (Enable responsive CSS code on browsers that don't support it, eg IE8) -->
        <script src="../js/vendor/modernizr-2.7.1-respond-1.4.2.min.js"></script>

        <style type="text/css">
            body {
                background-color: #494949!important;
            }
        </style>
    </head>

    <!--
        Add the class 'no-animation' to body element for no animation

        In PHP version, if there was an error with the login data the user added, you can pass a GET variable
        with the value 'error' to the url for no animation (page_login.php?mode=error)
    -->
    <body class="login">

        <!-- Login Intro -->
        <a href="javascript:void(0)" class="login-btn themed-background-default">
            <span class="login-logo">
                <span class="square1 themed-border-default"></span>
                <span class="square2"></span>
                <span class="name"><?php echo $template['name']; ?></span>
            </span>
        </a>
        <div class="left-door"></div>
        <div class="right-door"></div>
        <!-- END Login Intro -->

        <!-- Login Container -->
        <div id="login-container" class="display-none">
            <!-- Login Block -->
            <div class="block-tabs block-themed">
                <ul id="login-tabs" class="nav nav-tabs" data-toggle="tabs">
                    <li class="active text-center">
                        <a href="#login-form-tab">
                            <i class="fa fa-user"></i> Login
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="login-form-tab">
                        <!-- Login Form -->
                        <?php echo $this->Form->create('User', array('class' => 'form-horizontal')); ?>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
                                        <input type="email" id="login-email" name="data[User][email]" class="form-control" placeholder="Email..">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-asterisk fa-fw"></i></span>
                                        <input type="password" id="login-password" name="data[User][password]" class="form-control" placeholder="Password..">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12 clearfix">
                                    <div class="pull-left">
                                        <a href="/" class="btn btn-info remove-margin">Go to site</a>
                                    </div>
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-success remove-margin">Login</button>
                                    </div>
                                    <!--<div class="pull-left login-extra-check">
                                        <label for="login-remember-me">
                                            <input type="checkbox" id="login-remember-me" name="login-remember-me" class="input-themed">
                                            Remember me
                                        </label>
                                    </div>-->
                                </div>
                            </div>
                        <?php echo $this->Form->end(); ?>
                        <!-- END Login Form -->
                    </div>
                </div>
            </div>
            <!-- END Login Block -->
        </div>
        <!-- END Login Container -->

        <!-- Get Jquery library from Google but if something goes wrong get Jquery from local file - Remove 'http:' if you have SSL -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script>!window.jQuery && document.write(unescape('%3Cscript src="../js/jquery-1.11.0.min.js"%3E%3C/script%3E'));</script>

        <!-- Bootstrap.js -->
        <script src="../js/bootstrap.min.js"></script>

        <!-- Jquery plugins and custom javascript code -->
        <script src="../js/plugins.js"></script>
        <script src="../js/jquery.growl.js"></script>
        <script src="../js/chatelet.js"></script>

        <!-- Javascript code only for this page -->
        <script>
            $(function(){
                if ( ! $('body').hasClass('no-animation') ) {
                    var timeout = 0;

                    // If our browser support transitions (class will be added with the help of modernizr library) add a timeout of 750ms
                    // Nice fallback for our animation on older browser (such as IE8-9)
                    if ($('html').hasClass('csstransitions')) timeout = 750;

                    // On button hover or touch reveal the login form
                    $('.login-btn').click(function(){
                        $('.left-door, .right-door, .login-btn').addClass('login-animate');

                        setTimeout(function(){
                            $('#login-container').fadeIn(1500);
                            $('.login-btn .name').fadeOut(250, function(){
                                $('.login-btn .square1, .login-btn .square2').fadeIn(750);
                                $('#login-email').focus();
                            });
                        }, timeout);
                    });
                }
            });
        </script>
    </body>
</html>