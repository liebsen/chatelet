<?php 

echo $this->Session->flash();


?>
<div class="wrapper content">

  <div id="carousel" class="carousel slide animated fadeIn delay" data-type="slider" data-interval="10000" data-ride="carousel">
    <?php echo $this->element('carousel') ?>
  </div>

  <section id="listShop">
    <?php echo $this->element('shop_list') ?>
  </section>

  <?php echo $this->element('subscribe-box') ?>
  <?php echo $this->element('img_popup_newsletter') ?>
  <?php echo $this->element('follow_us') ?>

</div>
<?php
if(!empty($home['display_popup_form_in_last'])):?>
<style type="text/css">

  .news-carousel .item:last-child .in_last form {
    position: absolute!important;
    top:0px;
  }

  .news-carousel .item:last-child .in_last form input[type="email"] {
    margin-top: 217px;
    margin-left: 36px;
    border: none!important;
  }

  .news-carousel .item:last-child .in_last form input[type="submit"] {
    margin-top: 30px;
    float: left!important;
    border: none!important;
    margin-left: 50px;
    clear: both;
    color: transparent!important;
  }

</style>

<?php endif; ?>



