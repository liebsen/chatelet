<!doctype html>
<html class="no-js" lang="">
  <head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="X-UA-Compatible" content="IE=10">
    <meta http-equiv="X-UA-Compatible" content="IE=11">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <title>Châtelet</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Châtelet" />
    <meta property="og:description" content="Sé tu propio modelo de mujer" />
    <meta property="og:image" itemprop="image primaryImageOfPage" content="https://chatelet-dev.space-servers.com/img/share-image.jpg" />
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?=Configure::read('GA_CODE')?>"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '<?=Configure::read('GA_CODE')?>');
    </script>


    <!-- Bootstrap -->
    <?php

      echo $this->Html->css('font-awesome.min');
      echo $this->Html->css('bootstrap-select');
      echo $this->Html->css('bootstrap.min');
      echo $this->Html->css('bootstrap');
      echo $this->Html->css('bootstrapValidator.min');

      echo $this->Html->css('jquery.growl');
      echo $this->Html->css('chatelet');
      echo $this->Html->css('custom.css?3nov1');
      echo $this->Html->css('animate');


      echo $this->fetch('meta');
      echo $this->fetch('css');
      echo $this->Html->script('jquery-1.11.1.min');

      echo $this->Html->script('vendor/modernizr-2.8.3.min.js');
      echo $this->Html->script('bootstrap');

      echo $this->Html->script('jquery.growl');
      echo $this->Html->script('bootstrap-select.min');
      echo $this->Html->script('bootstrapValidator.min');
      echo $this->Html->script('wow.min');
      echo $this->Html->script('plugins');
      echo $this->Html->script('main.js?sjdh38hd2');

//      echo $this->fetch('script');
    ?>


  </head>
  <body>
