<div class="navbar-container">
  <nav class="navbar navbar-chatelet animated">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <a class="navbar-brand"
           href="<?php echo router::url(array('controller' => 'Home', 'action' => 'index')) ?>" >
              Châtelet</a>
          <i class="fa fa-bars text-chatelet navbar-toggle float-none m-0 collapsed text-chatelet" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false"></i>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <?php foreach($menus as $menu): ?>
              <li>
                <a href="<?= !empty($menu['menus']['href']) && strlen($menu['menus']['href']) ? $menu['menus']['href'] : $this->Html->url(array(
                'controller' => 'tienda',
                'action' => 'productos',
                str_replace(array('ñ',' '),array('n','-'),strtolower($menu['categories']['category_name']))
              )); ?>" title="<?= $menu['menus']['text'] ?>"<?= $menu['menus']['target_blank'] === 'on' ? ' target="blank"' : '' ?>><?= $menu['menus']['title'] ?></a>
              </li>
            <?php endforeach ?>
            <?php if( !empty($lookBook) ): ?>
            <li>
              <?php
                  echo $this->Html->link('Lookbook', array('controller' => 'catalogo', 'action' => 'index'));
              ?>
            </li>
            <?php endif ?>
            <?php if( !empty($data['show_shop']) ): ?>
              <li>
                <a href="/Shop" data-toggle="mouseenter" data-show=".shop-options">Shop</a>
              </li>
            <?php endif ?>
            <!--li>
                <?php
                  echo $this->Html->link('WhatsApp', array('controller' => 'shop', 'action' => 'promos'));
                ?>
            </li-->
            <li>
                <?php
                  echo $this->Html->link('Sucursales', array('controller' => 'sucursales', 'action' => 'index'));
                ?>
            </li>
            <li>
                <?php
                  echo $this->Html->link('Ayuda', array('controller' => 'ayuda', 'action' => 'como_comprar'));
                ?>
            </li>
            <li>
              <?php
                echo $this->Html->link('Contacto', array('controller' => 'contacto', 'action' => 'index'));
              ?>
            </li>
          </ul>

          <ul class="nav navbar-nav navbar-right">
            <li>
              <a href="#" title="Buscar en la tienda">
                <i data-toggle="sidebar" data-target=".sidebar-search" data-focus=".search-input" class="fa text-chatelet fa-search text-light"></i>
              </a>
            </li>

           <!-- .Login -->
            <li class="dropdown">
              <?php if ($loggedIn) { ?>
              <a href="#" class="dropdown-toggle js-activated" data-toggle="dropdown" data-hover="dropdown" id="iniciar-sesion">
                <!--span class="count animated scaleIn speed delay1">
                  <i class="fa fa-check text-white fa-xs"></i>
                </span-->
                <i data-toggle="sidebar" data-target=".sidebar-account" class="fa text-green fa-user"></i>
              </a>
              <ul class="dropdown-menu">
                <li>
                 <div id="login-panel">
                    <div class="control-panel">
                      <p class="title">Panel de Usuario</p>
                      <div id="user-data">
                        <div id="user-name">
                          <?php echo $user['name'] . " " . $user['surname']; ?>
                          <a data-toggle="sidebar" data-target=".sidebar-account" class="pencil">
                            <span class="fa fa-pencil"></span>
                          </a>
                        </div>
                        <div id="user-email"><?php echo $user['email']; ?></div>
                      </div>
                      <!--ul id="control-sections" class="list-unstyled">
                        <li class="">
                          <span class="fa fa-tag"></span> <a href="#">Historial de Compras</a>
                        </li>
                        <li class="">
                          <span class="fa fa-heart"></span> <a href="#">Mis favoritos</a>
                        </li>
                        <li class="">
                          <span class="fa fa-comment"></span> <a href="#">Mis consultas</a>
                        </li>
                      </ul-->
                    </div>
                    <div id="control-footer">
                      <a href="/shop/mis_compras" class="btn btn-chatelet">Mis compras</a>
                      <a href="/users/logout" class="btn btn-chatelet">Cerrar sesión</a>
                    </div>
                  </div>
                </li>
              </ul>
              <?php } else { ?>
              <a href="/shop/cuenta" class="dropdown-toggle" title="Inicia sesión">
                <i class="fa text-chatelet fa-user"></i>
              </a>
              <?php } ?>
            </li><!-- /.Login -->
            <li class="dropdown is-clickable">
              <a href="#" data-toggle="sidebar" data-target=".sidebar-cart" class="dropdown-toggle js-activated<?=count($carro) ? ' text-theme':'' ?>" data-toggle="dropdown" data-hover="dropdown">
                <?php if(count($carro)):?>
                <span data-toggle="sidebar" data-target=".sidebar-cart" class="count animated scaleIn speed delay1"><?=count($carro)?></span>
                <?php endif ?>
                <span data-toggle="sidebar" data-target=".sidebar-cart" title="Mi carrito"><i data-toggle="sidebar" data-target=".sidebar-cart" class="fa fa-shopping-cart <?= count($carro) ? 'text-green' : 'text-chatelet' ?>"></i></span>
              </a>
              <ul class="dropdown-menu">
                <li>
                  <div class="control-panel">
                  <?php if ($this->Session->check('cart')): ?>
                    <p class="title">Tu pedido</p>
                  <?php else: ?>
                    <h3> <i class="fa fa-shopping-cart fa-x2"></i> Tu carrito está vacío.</h3>
                    <p class="notification text-muted">Obtén más información <a href="/ayuda/como_comprar" class="text-primary">acerca de como comprar</a></p>
                  <?php endif ?>
                    <ol id="items">
                      <?php
                        $total = 0;
                        if (!isset($carro)) $carro = array();
                        foreach($carro as $producto) {

                            /* if(!empty($producto['discount']) && (float)$producto['discount']>0){
                              $producto['price'] = $producto['discount'];
                            } */

                            $total += $producto['price'];
                            $color = empty($producto['price'])?'text-success':'text-dark';
                            echo '<li class="'.$color.'">';
                              echo '<span class="ellipsis">'. $producto['name'] .'</span> - <strong>'. str_replace(',00','',$this->Number->currency($producto['price'], 'ARS', array('places' => 2))) . '</strong>';
                            echo '</li>';
                          }
                      ?>
                    </ol>
                  <?php if ($this->Session->check('cart')): ?>
                    <p>
                      Total <span class="right"><?php echo str_replace(',00','',$this->Number->currency($total, 'ARS', array('places' => 2))); ?></span>
                    </p>
                    <p class="bottom" title="Ir al carrito">
                      <?php
                        echo $this->Html->link('<span class="fa fa-pencil"></span>', array(
                          'controller' => 'carrito',
                          'action' => 'index'
                          ),
                          array(
                            'class' => 'pencil',
                            'escape' => false
                          )
                        );
                      ?>
                      <span class="right">
                        <?php
                          echo $this->Html->link('Pagar', array(
                              'controller' => 'carrito',
                              'action' => 'index'
                            ), array(
                              'class' => 'right'
                            )
                          );
                        ?>
                      </span>
                    </p>
                    <?php endif ?>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
</div>

<div class="sidebar-backdrop"></div>

<nav class="sidebar sidebar-search">
  <button type="button" class="btn-close btn-close-sidebar">
    <i class="fa fa-times"></i>
  </button>
  <h6 class="text-bolder text-uppercase">Buscar</h6>
  <div class="content pt-4">  
    <form name="search" action="/shop/buscar">
      <input class="form-control search-input" name="q" placeholder="Buscar...">
      <button class="btn" type="submit">Buscar</button>
    </form>
  </div>
</nav>

<nav class="sidebar sidebar-account">
  <button type="button" class="btn-close btn-close-sidebar">
    <i class="fa fa-times"></i>
  </button>  
  <h6 class="text-bolder text-uppercase">Accediste como</h6>
  <div class="content pt-4">    
    <h6> ...</h6>
  </div>
</nav>

<nav class="sidebar sidebar-cart">
  <button type="button" class="btn-close btn-close-sidebar">
    <i class="fa fa-times"></i>
  </button>  
  <h6 class="text-bolder text-uppercase">Carrito</h6>
  <div class="d-flex flex-column justify-content-center align-items-center gap-05">
    <div class="content pt-4">
    <?php if (isset($carro) && !empty($carro)) :?>
    <?php foreach($carro as $i => $product) {
      echo "<div class='d-flex justify-content-start align-center gap-05 cart-row carrito-data' data-json='".json_encode($product)."'>";
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
    echo '<button class="btn close bg-transparent" onclick="askremoveCart(this)">
            <i class="fa fa-trash-o"></i>
          </button>';         
    echo '</div>';    
    } ?>
    </div>
    <div class="d-flex flex-column justify-content-center align-items-center gap-05 w-100">
      <a href="/checkout" class="btn btn-chatelet dark w-100">Comprar ahora</a>
      <a href="/carrito" class="btn btn-chatelet w-100">Ir al carrito</a>
      <a href="/tienda" class="btn keep-buying btn-chatelet w-100">Seguir comprando</a>
    </div>  
    <?php else: ?>
      <p>Tu carrito de compras está vacío</p>
      <div class="d-flex flex-column justify-content-center align-items-center gap-05 w-100">
        <a href="/tienda" class="btn keep-buying btn-chatelet w-100">Seguir comprando</a>
      </div>        
    <?php endif ?>
  </div>
</nav>

<div class="burst shop-options">
  <div class="wrapper" data-toggle="mouseleave" data-hide=".shop-options">
    <div class="row">
      <?php if(!empty($data['image_menushop'])): ?>
      <img class="pull-left" src="<?php echo Configure::read('uploadUrl').$data['image_menushop']?>">
      <?php endif ?>
      <div class="">
        <!--h3>Shop</h3-->
        <ul>
          <?php
          if (!empty($categories)){
            foreach ($categories as $category) {
              $category = $category['Category'];
              $slug =  str_replace(' ','-',strtolower($category['name']));
              if (strpos($slug, 'trajes')!==false){
                $slug = 'trajes-de-bano';
              }
              echo '<li>';
              echo $this->Html->link(
                  $category['name'],
                  array(
                      'controller' => 'tienda',
                      'action' => 'productos',
                     $slug
                  )
              );
              echo '</li>';
            }
            }
          ?>
        </ul>
      </div>
    </div>
  </div>
</div>