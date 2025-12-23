<?php echo $this->Session->flash(); ?>
<style type="text/css">
  .img-cover {
    object-fit: cover;
    object-position: top center;
    width:100%;
  }

</style>

<?php if(!empty($data['image_bannershop'])): ?>
<div id="headshop">
  <!--h1 class="name_shop">Shop</h1-->
  <div class="img-resp" style="background-image:url(<?php echo $settings['upload_url'].@$data['image_bannershop'] ?>)"></div>
</div>
<?php endif ?>

<section id="listShop">
  <?php echo $this->element('shop_list') ?>
</section>

<section id="infoShop">
  <div class="wrapper">
    <div class="row">
      <div class="col-md-4 bx1">
        <p>
          Los envíos por compra online tienen una demora de 7 a 10 días hábiles.
        </p>
      </div>
      <div class="col-md-4 bx2 blr">
        <p>
          Los cambios se realizan dentro de los 30 días de efectuada la compra en cualquiera de las sucursales presentando el ticket correspondiente.
        </p>
      </div>
      <div class="col-md-4 bx3">
        <p>
          Las prendas deben estar sin uso y con la etiqueta de código de barras correspondiente adherida.
        </p>
      </div>
    </div>
  </div>
</section>

<?php echo $this->element('subscribe-box') ?>
