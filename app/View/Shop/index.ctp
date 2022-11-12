<?php echo $this->Session->flash(); ?>
<style type="text/css">
  .img-cover {
    object-fit: cover;
	object-position: top center;
    width:100%;
  }

</style>
<div id="headshop">
  <h1 class="name_shop">Shop</h1>
  <div class="img-resp" style="background-image:url(<?php echo Configure::read('imageUrlBase').$image_bannershop ?>)"></div>
</div>

<section id="filters">
    <div class="wrapper"></div>
</section>

<section id="listShop">
  <div class="wrapper">
    <div class="row">
      <div class="col-xs-12">
        <div class="row">
      <?php foreach($categories as $category): ?>
      <div class="col-xs-12 col-md-<?= !empty($category['Category']['colsize']) ? $category['Category']['colsize'] : 'auto' ?>">
        <a href="<?php echo $this->Html->url(array('controller' => 'tienda', 'action' => 'productos', str_replace(array('ñ',' '),array('n','-'),strtolower($category['Category']['name'])))); ?>" class="pd1">
          <img src="<?php echo Configure::read('imageUrlBase').$category['Category']['img_url']?>"" class="img-responsive img-cover">
          <span class="hover hidden-force">
             <?php echo $category['Category']['name']?><br>

          </span>
        </a>
      </div>
      <?php endforeach ?>
      </div></div>
    </div>
  </div>
</section>

<section id="infoShop">
  <div class="wrapper">
    <div class="row">
      <div class="col-md-4 bx1">
          Las prendas que estan en el Shop como principal en cada rubro, no estan a la venta.
      </div>
      <div class="col-md-4 bx2 blr">
          Los cambios se realizan dentro de los 30 días de efectuada la compra en cualquiera de las sucursales presentando el ticket correspondiente.
      </div>
      <div class="col-md-4 bx3">
          Las prendas deben estar sin uso y con la etiqueta de código de barras correspondiente adherida.
      </div>
    </div>
  </div>
</section>
