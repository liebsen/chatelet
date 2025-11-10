<nav class="sidebar sidebar-cart">
  <button type="button" class="corner-pin btn-close-sidebar">
    <i class="ico-times" role="img" aria-label="Cerrar"></i>
  </button>  
  <h5 class="text-uppercase">Carrito</h5>
  <div class="sidebar-top d-flex flex-column justify-content-start align-items-start gap-05 content pt-4">
  <?php if (isset($cart) && !empty($cart)) :?>
  <?php foreach($cart as $i => $product) {
    echo "<div class='d-flex justify-content-start align-center gap-1 cart-row carrito-data position-relative' data-json='".json_encode($product)."'>";
    echo "<div class='cart-img'>";
    if (!empty($product['number_ribbon'])) {
      echo '<div class="ribbon bottom-left small"><span>'.$product['number_ribbon'].'% OFF</span></div>';
    }
    if (empty($product['price'])) {
      $promosaved+= (float) $product['old_price'];
    }
    if ($product['promo'] !== '') {             
      $disable = !isset($product['promo_enabled']) ? ' disable' : '';
      echo "<div class='ribbon".$disable."'><span>" . $product['promo'] . "</span></div>";
    }
    echo '<a href="' . $item_url . '">';
    // echo '<img src="'.Configure::read('uploadUrl').($product['alias_image'] ?: $product['img_url'] ).'" class="thumb" style="display:block;" />';
    echo '<div class="ch-image" style="background-image: url('.Configure::read('uploadUrl').($product['alias_image'] ?: $product['img_url'] ).')"></div>';
    echo '</a>';
  echo '</div>';
  echo '<div class="d-flex justify-content-start align-center flex-column min-w-7">';
  echo '<h6 class="is-carrito mb-1">'. $product['name'] . '</h6>';
    if (!empty($product['color_code']) && $product['color_code'] != 'undefined'){
      echo '<span class="text-sm">Color: <span color-code="'.$product['color_code'].'">'. $product['alias'] .'</span></span>';
    }
    if (!empty($product['size']) && $product['size'] != 'undefined'){
      echo '<span class="text-sm">Talle: <span>'. $product['size'] .'</span></span>';
    }

  echo '<span class="text-nowrap mt-2">$ '. \price_format($product['price']) .'</span>';
  echo '</div>';
  echo '<button class="btn corner-pin bg-transparent" onclick="askremoveCart(this)">
          <i class="fa fa-trash-o"></i>
        </button>';         
  echo '</div>';    
  } ?>
  </div>
  <div class="sidebar-bottom">
    <div class="d-flex flex-column justify-content-center align-items-center gap-05 w-100">
      <a href="/checkout" class="btn btn-chatelet dark w-100">Comprar</a>
      <a href="/carrito" class="btn btn-chatelet w-100">Ir al carrito</a>
      <a href="/tienda" class="btn keep-buying w-100">Seguir comprando</a>
    </div>  
    <?php else: ?>
      <p>Tu carrito de compras está vacío</p>
      <div class="d-flex flex-column justify-content-center align-items-center gap-05 w-100">
        <a href="/tienda" class="btn keep-buying btn-chatelet w-100">Seguir comprando</a>
      </div>        
    <?php endif ?>
  </div>
</nav>

