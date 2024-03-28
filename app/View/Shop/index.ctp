<?php echo $this->Session->flash(); ?>
<style type="text/css">
  .img-cover {
    object-fit: cover;
    object-position: top center;
    width:100%;
  }

</style>
<div id="headshop">
  <!--h1 class="name_shop">Shop</h1-->
  <div class="img-resp" style="background-image:url(<?php echo Configure::read('uploadUrl').$image_bannershop ?>)"></div>
</div>

<section id="listShop">
  <div class="wrapper-fluid">
    <div class="row m-0">
      <div class="col-xs-12">
        <div class="row">
          <?php foreach($categories as $category): ?>
          <div class="category-item p-0 col-xs-12 col-md-<?= !empty($category['Category']['colsize']) ? $category['Category']['colsize'] : 'auto' ?>">
            <a href="<?php echo $this->Html->url(array('controller' => 'tienda', 'action' => 'productos', str_replace(array('ñ',' '),array('n','-'),strtolower($category['Category']['name'])))); ?>" class="pd1 text-center">
              <div class="d-flex justify-content-start align-items-center cat-image p-3 w-100" style="background: #eaeaea url('<?php echo Configure::read('uploadUrl').$category['Category']['img_url']?>') center center/cover no-repeat;">          
                <?php if(strlen($category['Category']['name']) > 3): ?>
                <span class="p-1 text-catalog text-uppercase">
                  <?php echo $this->App->cat_title($category['Category']['name'])?>
                </span>
                <?php endif ?>
              </div>
            </a>
          </div>
          <?php endforeach ?>
        </div>
      </div>
    </div>
  </div>
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
