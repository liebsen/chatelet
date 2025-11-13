<!doctype html>
<html class="no-js noscroll" lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="X-UA-Compatible" content="IE=10">
    <meta http-equiv="X-UA-Compatible" content="IE=11">
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <title>Châtelet</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="facebook-domain-verification" content="mz62jgu2bv7lu4new0t9pno88ekmxx" />
    <?php if(isset($product) && isset($product['name'])):?>
    <!-- FB OpenGraph -->
    <meta property="og:title" content="<?= ucwords(strtolower($product['name'])) ?>">
    <meta property="og:description" content="<?= ucwords(strtolower($product['name'])) ?>">
    <meta property="og:url" content="<?= $this->Html->url(['controller' => 'shop', 'action' => 'detalle', $product['id'], $product['category_id'], strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $product['name'])))], true) ?>">
    <meta property="og:image" content="<?= baseUrl() . Configure::read('uploadUrl') . $product['img_url'] ?>">
    <meta property="product:brand" content="Châtelet">
    <meta property="product:availability" content="<?= intval($product['stock_total']) ? 'in stock' : 'out of stock' ?>">
    <meta property="product:condition" content="new">
    <meta property="product:price:amount" content="<?= $product['price'] ?>">
    <meta property="product:price:currency" content="ARS">
    <meta property="product:retailer_item_id" content="<?= $product['article'] ?>">
    <meta property="product:item_group_id" content="<?= $product['category_id'] ?>">
    <meta property="product:google_product_category" content="<?= $product['category_id'] ?>">
    <?php else: ?>
    <meta property="og:type" content="<?= @$settings['opengraph_type'] ?>" />
    <meta property="og:url" content="<?= siteUrl() ?>" />
    <meta property="og:title" content="<?= @$settings['opengraph_title'] ?>" />
    <meta property="og:description" content="<?= @$settings['opengraph_text'] ?>" />
    <meta property="og:image" itemprop="image primaryImageOfPage" content="<?= siteUrl() . @$settings['opengraph_image'] ?>" />
    <?php endif ?>
    <link href="https://fonts.googleapis.com/css?family=<?= @urlencode(@$settings['google_font_name']) ?>:<?= @$settings['google_font_size'] ?>" rel="stylesheet">

    <?php echo $this->element('css_root') ?>

    <?php
      echo $this->Html->css('font-awesome.min');
      echo $this->Html->css('bootstrap-select');
      echo $this->Html->css('bootstrap.css?v=' . Configure::read('APP_VERSION'));
      echo $this->Html->css('bootstrapValidator.min');
      echo $this->Html->css('jquery.growl.css?v=' . Configure::read('APP_VERSION'));
      echo $this->Html->css('chatelet.css?v=' . Configure::read('APP_VERSION'));
      echo $this->Html->css('custom.css?v=' . Configure::read('APP_VERSION'));
      echo $this->Html->css('animate.css?v=' . Configure::read('APP_VERSION'));
      echo $this->Html->script('jquery-1.11.1.min');
      echo $this->Html->script('vendor/modernizr-2.8.3.min.js');
      echo $this->Html->script('bootstrap');
      echo $this->Html->script('jquery.growl');
      echo $this->Html->script('bootstrap-select.min');
      echo $this->Html->script('bootstrapValidator.min');
      //echo $this->Html->script('wow.min');
      echo $this->Html->script('plugins');
      // echo $this->Html->script('main.js?v=' . Configure::read('APP_VERSION'));
      echo $this->fetch('meta');
      echo $this->fetch('css');

    ?>
    <script>
      $.ajaxSetup({
        cache:false,
        dataType: "json",
        xhrFields: {
          withCredentials: true
        },
      });
    </script>
  </head>
  <body class="noscroll p-0">
    <?php if($_SERVER['SERVER_NAME'] !== 'chatelet.com.ar') :?>
      <div class="dev-note is-flex-center p-3 text-center bg-danger">
        <span class="corner-pin is-clickable" style="top: 0.5rem!important" onclick="$('.dev-note').remove()">
          <i class="ico-times"></i>
        </span>
        <span class="text-sm text-dark">Esta <b>no es la tienda oficial</b> de Châtelet</span>
      </div>
      <style>
        .dev-note {
          position: fixed;
          z-index: 10;
          left: 0;
          right: 0;
          bottom: 0;
        }
      </style>
    <?php endif ?>
    <?php if(!empty($banners) && empty($short_header)) :?>
      <?php echo $this->element('banners'); ?>
    <?php endif ?>
