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
        <link href="https://fonts.googleapis.com/css?family=<?= @urlencode(@$settings['google_font_name']) ?>:<?= @$settings['google_font_size'] ?>" rel="stylesheet">
        <style type="text/css">
						:root {
							--theme-color: <?=@$settings['site_theme_color'] ?>;
							--theme-text: <?=@$settings['site_theme_text'] ?>;
							--theme-variant: <?=@$settings['site_theme_variant'] ?>;
							--toggle-off-color: #e7e7e7;
							--toggle-color: springgreen;
							--font-family: '<?=@$settings['google_font_name'] ?>';
						}

						::placeholder {
						  transition: opacity 0.5s ease-in-out;
						  transition-delay: 1s;
						  color: #f8f8f8;
						}

						/* 1. Standards-based styling (Firefox and future browsers) */
						* {
						  scrollbar-width: thin; /* Options: auto, thin, none */
						  scrollbar-color: #888 #f1f1f1; /* thumb-color track-color */
						}        	
            html, body { 
                font-family: var(--font-family), Verdana, Arial, Sans-Serif!important;
                line-height: 1;
                font-size: 15px; 
                color: #a5a5a5;
                font-weight: 300;
                min-height: 100dvh;
                background-color: #333;
            }
        </style>
    </head>

    <!--
        Add the class 'no-animation' to body element for no animation

        In PHP version, if there was an error with the login data the user added, you can pass a GET variable
        with the value 'error' to the url for no animation (page_login.php?mode=error)
    -->
    <body class="login">
    		<?=$this->Session->flash();?>
        <!-- Login Intro -->
        <a href="javascript:void(0)" class="login-btn bg-variant animation-fadeIn animation-both delay3">
            <span class="login-logo">
                <span class="square"><i class="gi gi-lock fa-lg text-white"></i></span>
                <div class="name">
                    <img src="/img/chatelet_blanco.png" class="image-responsive" width="90%" title="<?php echo $template['name'] ?> <?php echo $version['text'] ?>"/>
                </div>
            </span>
        </a>
        <div class="left-door animation-fadeIn animation-both delay1"></div>
        <div class="right-door animation-fadeIn animation-both delay2"></div>
        <!-- END Login Intro -->
        <div class="printable-version animation-fadeIn animation-both delay3">v<?=$version['count']?></div>
        <!-- Login Container -->
        <div id="login-container" class="display-none">
            <!-- Login Block -->
            <div class="block-tabs">
                <!--ul id="login-tabs" class="nav nav-tabs" data-toggle="tabs">
                    <li class="active text-center">
                        <a href="#login-form-tab">
                            <i class="fa fa-user"></i> Login
                        </a>
                    </li>
                </ul-->
                <h3 class="text-center text-white mt-0">ADMINISTRADOR</h3>
                <p class="notification text-white">Ingresa tus credenciales para continuar</p>
                <div class="tab-content is-rounded bg-translucid">
                    <div class="tab-pane pane-index active" id="login-form-tab">
                        <!-- Login Form -->
                        <?php echo $this->Form->create('User', array(
                            'class' => 'form-horizontal',
                            'id' => 'login_form',
                        )); ?>
                            <input type="hidden" name="redirect" value="/admin"/>
                            <input type="hidden" name="ajax" value="1"/>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="input-group p-0">
                                        <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
                                        <input type="email" id="login-email" name="data[User][email]" class="form-control" placeholder="Tu Email" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="position-relative">
                                        <div class="input-group p-0">
                                            <span class="input-group-addon"><i class="fa fa-asterisk fa-fw"></i></span>
                                            <input type="password" id="login-password" name="data[User][password]" class="form-control" placeholder="Tu contraseña" required>
                                        </div>
                                        <i class="form-pass-icon fa fa-eye-slash is-clickable" data-target="#login-password"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-4">
                                <div class="col-xs-12">
                                    <span class="text-link">
                                			<a href="/shop/recuperar_acceso"><i class="fa fa-hand-stop-o mr-1"></i> Olvidé mi contraseña</a>
                                		</span>
                                </div>
                            </div>
                            <div class="form-group mt-8">
                                <div class="col-xs-12 clearfix">
                                    <div class="pull-left">
                                        <a href="/" class="btn btn-info remove-margin" target="_blank" title="Volver a la tienda"><i class="gi gi-shop"></i></a>
                                    </div>
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-success remove-margin">Iniciar sesión</button>
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
        <style type="text/css">

.left-door, .right-door {
  width: 100%;
  height: 50%;
  position: absolute;
  bottom: 0;
  background-color: #151515;
  transition: all 1s ease-in-out;
}

.left-door {
  top: 0;
  border-bottom: 3px solid #222;
}

.right-door {
  bottom: 0;
  border-top: 3px solid #222;
}

.left-door.login-animate,
.right-door.login-animate {
  height: 0;
  border-height: 0;
}

@media(min-width: 767px) {
	.left-door, .right-door {
	  width: 50%;
	  height: 100%;
	}
	.left-door {
	  left: 0;
	  bottom: auto;
	  border: none;
	  border-right: 3px solid #222;
	}
	.right-door {
	  right: 0;
	  top: auto;
	  border: none;
	  border-left: 3px solid #222;
	}	
	.left-door.login-animate,
	.right-door.login-animate {
	  width: 0;
	  height: 100%;
	  border-width: 0;
	}
}

.login-btn {
  z-index: 1000;
  position: absolute;
  top: 250px;
  left: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 160px;
  height: 160px;
  line-height: 150px;
  font-size: 26px;
  text-align: center;
  color: #fff;
  border: 5px solid #fff;
  margin-left: -80px;
  border-radius: 80px;
  transition: all 1.25s ease-in-out;
}

.login-logo .name {
  display: none;
}

.login-btn:hover,
.login-btn:focus {
  text-decoration: none;
  color: #fff;
  box-shadow: 0 0 20px 0 #fff;
}

.login-btn:focus {
  outline:none;
}

.login-btn::-moz-focus-inner {
  border:0;
}

.login-btn.login-animate {
  top: 75px;
  box-shadow: none;
  transform: rotateY(360deg);
}

#login-container {
  width: 300px;
  margin: 0 auto 0;
  padding: 275px 0 0;
}

/*.login .block-tabs {
  box-shadow: 0 0 100px 0 #000;
}*/

.login .tab-content {
  padding-bottom: 10px !important;
}

#login-tabs li {
  width: 50%;
}

#login-buttons button {
  display: block;
  width: 100%;
  margin-bottom: 10px;
  text-align: left;
}

#login-buttons i {
  float: right;
}

.printable-version {
    position: fixed;
    bottom: 1rem;
    right: 1rem;
    color: #666;
}

body.login {
    background: linear-gradient(45deg, <?=$settings['site_theme_color']?>, <?=$settings['site_theme_variant']?>);
    min-height: 100dvh;
}
body.login .form-group {
  margin-bottom: 10px;
}

.login-extra-check {
  margin: 5px 0 0;
}

/* No animation on login page */
.no-animation #login-container,
.no-animation .login-logo .square1,
.no-animation .login-logo .square2 {
  display: block !important;
}

.no-animation .left-door,
.no-animation .right-door,
.no-animation .login-logo .name {
  display: none !important;
}

.no-animation .login-btn {
  top: 75px !important;
  box-shadow: none !important;
}            
        </style>
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
                            $('.login-btn .square').fadeOut(250, function(){
                                $('.login-btn .name').fadeIn(750);
                                $('#login-email').focus();
                            });
                        }, timeout);
                    });
                }
            });
        </script>

        <script type="text/javascript">
            $(function(){
                $('button[type="submit"]').prop('disabled', false)
                var timeout = 0
            $('#login_form').submit(function(e) {
            	 	$('button[type="submit"]').text('Espere...')
                $('button[type="submit"]').prop('disabled', true)

                e.preventDefault();
                if($('#password').length){
                    if($('#password').val().trim() != $('#password2').val().trim()) {
                        return onWarningAlert('Error de validación', 'Las contraseñas no coinciden. Asegúrate de que sean la misma en ambos campos')
                    }
                }
                // const formData = new FormData(e.target);
                clearTimeout(timeout)
                timeout = setTimeout(() => {
                var me = $(this),
                data = me.serialize(),
                url = me.attr('action');
                $.post(url, data)
                  .success(function(res) {
                    if (!res.success) {
                      $.growl.error({
                          title: 'Error al iniciar sesión',
                          message: res.errors
                      });

                      $('button[type="submit"]').prop('disabled',false)
                      return false;
                    } else {
                      $.growl.notice({
                          title: 'Se inició sesión con éxito',
                          message: res.message
                      });

                      const redirect = $('input[name="redirect"]').val() || '/shop'
                        setTimeout(() => {
                            location.href = redirect
                        }, 1000)
                    }
                  })
                  .fail(function() {
                        $('button[type="submit"]').prop('disabled', false)
                        $('button[type="submit"]').text('Iniciar sesión')
                      $.growl.error({
                          title: 'Error al inciar sesión',
                          message: 'Por favor verifica los datos introducidos e intenta de nuevo'
                      });
                  });

              }, 500)
              return false;
            });
            // $("#registro_form").bootstrapValidator('validate');      
            })
        </script>        
    </body>
</html>