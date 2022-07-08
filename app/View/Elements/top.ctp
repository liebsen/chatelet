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
    <meta property="og:image" itemprop="image primaryImageOfPage" content="https://chatelet.com.ar/images/share-080722.jpg" />
    <meta name="facebook-domain-verification" content="mz62jgu2bv7lu4new0t9pno88ekmxx" />
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <?php if(isset($product)):?>
    <!-- FB OpenGraph -->
    <meta property="og:title" content="<?= ucwords(strtolower($product['name'])) ?>">
    <meta property="og:description" content="<?= ucwords(strtolower($product['name'])) ?>">
    <meta property="og:url" content="<?= $this->Html->url(['controller' => 'shop', 'action' => 'detalle', $product['id'], $product['category_id'], strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $product['name'])))], true) ?>">
    <meta property="og:image" content="<?= Configure::read('imageUrlBase') . $product['img_url'] ?>">
    <meta property="product:brand" content="Chatelet">
    <meta property="product:availability" content="<?= intval($product['stock_total']) ? 'in stock' : 'out of stock' ?>">
    <meta property="product:condition" content="new">
    <meta property="product:price:amount" content="<?= $product['price'] ?>">
    <meta property="product:price:currency" content="ARS">
    <meta property="product:retailer_item_id" content="<?= $product['article'] ?>">
    <meta property="product:item_group_id" content="<?= $product['category_id'] ?>">
    <meta property="product:google_product_category" content="<?= $product['category_id'] ?>">
    <?php endif ?>

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
      // echo $this->Html->css('bootstrap.min');
      echo $this->Html->css('bootstrap.css?' . Configure::read('DIST_VERSION'));
      echo $this->Html->css('bootstrapValidator.min');

      echo $this->Html->css('jquery.growl.css?' . Configure::read('DIST_VERSION'));
      echo $this->Html->css('chatelet.css?' . Configure::read('DIST_VERSION'));
      echo $this->Html->css('custom.css?' . Configure::read('DIST_VERSION'));
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
      echo $this->Html->script('main.js?' . Configure::read('DIST_VERSION'));

//      echo $this->fetch('script');
    ?>


  </head>
  <body>
