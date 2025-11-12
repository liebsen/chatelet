<nav class="sidebar sidebar-cart d-flex flex-column justify-content-center align-items-center gap-05">
  <button type="button" class="corner-pin btn-close-sidebar">
    <i class="ico-times" role="img" aria-label="Cerrar"></i>
  </button>  
  <div class="sidebar-top d-flex flex-column justify-content-<?php echo !empty($cart) ? 'start' : 'center' ?> align-items-start gap-05 content pt-4">
  <?php if (!empty($cart)) :?>
    <h5 class="text-bolder text-uppercase">Carrito</h5>
  <?php foreach($cart as $i => $product) :?>
    <div class='d-flex justify-content-start align-center gap-1 cart-row carrito-data position-relative w-100' data-json='<?php echo json_encode($product) ?>'>
      <div class='cart-img'>
      <?php if (!empty($product['number_ribbon'])) :?>
        <div class="ribbon bottom-left small">
          <span><?php echo $product['number_ribbon'] ?>% OFF</span>
        </div>
      <?php endif ?>

      <?php if (empty($product['price'])) :?>
        <?php $promosaved+= (float) $product['old_price']; ?>
      <?php endif ?>

      <?php if ($product['promo'] !== '') :?>
        <div class="ribbon<?php echo !isset($product['promo_enabled']) ? ' disable' : '' ?>">
          <span><?php echo $product['promo'] ?></span>
        </div>
      <?php endif ?>
        <a href="<?php echo $this->Html->url(array(
          'controller' => 'shop',
          'action' => 'detalle',
          $product['id'],
          $product['category_id'],
          strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $product['name'])))
        )) ?>">
          <div class="ch-image" style="background-image: url('<?php echo Configure::read('uploadUrl').($product['alias_image'] ?: $product['img_url']) ?>')"></div>
        </a>
      </div>
      <div class="d-flex justify-content-start align-center flex-column min-w-7">
        <h6 class="is-carrito mb-1" style="max-width: 6rem"><?php echo $product['name'] ?></h6>
      <?php if (!empty($product['color_code']) && $product['color_code'] != 'undefined') : ?>
        <span class="text-sm">Color: <span color-code="<?php echo $product['color_code'] ?>"><?php echo $product['alias'] ?></span>
        </span>
      <?php endif ?>
      <?php if (!empty($product['size']) && $product['size'] != 'undefined') : ?>
        <span class="text-sm">Talle: <span><?php echo $product['size'] ?></span></span>
      <?php endif ?>
        <span class="text-nowrap mt-2">$ <?php echo \price_format($product['price']) ?></span>
      </div>
      <button class="corner-pin bg-transparent" onclick="askremoveCart(this)">
        <i class="fa fa-trash-o"></i>
      </button>
    </div>   
  <?php endforeach ?>
  <?php else : ?>
    <h5 class="text-bolder text-uppercase text-muted">Tu carrito está vacío</h5>
  <?php endif ?>
  </div>
  <div class="sidebar-bottom">
    <?php if (isset($cart) && !empty($cart)) :?>    
    <div class="d-flex justify-content-between align-items-center gap-05">
      <span class="text-weight-bold">Total </span> 
      <span class="calc_total text-weight-bold">$ <?= \price_format($cart_totals['total_products'] - $cart_totals['coupon_benefits'] + $cart_totals['delivery_cost']) ?></span><!--span>.00</span-->
    </div>    
    <div class="d-flex flex-column justify-content-center align-items-center gap-05 w-100">
      <a href="/checkout" class="btn btn-chatelet dark w-100">Finalizar compra</a>
    <?php if (!in_array(Router::url(), array('/carrito'))) : ?>
      <a href="/carrito" class="btn btn-chatelet w-100">Ir al carrito</a>
    <?php endif ?>
      <a href="/tienda" class="btn btn-chatelet btn-continue-shopping w-100">Seguir comprando</a>
    </div>  
    <?php else: ?>
      <!--p>Tu carrito de compras está vacío</p-->
      <div class="d-flex flex-column justify-content-center align-items-center gap-05 w-100">
        <a href="/tienda" class="btn btn-chatelet btn-continue-shopping w-100">Seguir comprando</a>
      </div>        
    <?php endif ?>
  </div>
</nav>

