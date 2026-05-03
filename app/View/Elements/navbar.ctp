  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <a class="navbar-brand"
     href="<?php echo router::url(array('controller' => 'Home', 'action' => 'index')) ?>" >
        Châtelet</a>
    <i class="fa fa-bars navbar-toggle float-none m-0 collapsed text-grey" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false"></i>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
      <?php 
      $custom_selected = false; 
      foreach($menus as $menu):

        $link = !empty($menu['menus']['href']) ?
          $menu['menus']['href'] :
          $link = $this->Html->url(
            array(
              'controller' => 'tienda',
              'action' => 'productos',
              str_replace(
                array('ñ',' '),
                array('n','-'),
                strtolower($menu['categories']['category_name'])
              )
            )
          );
          $custom_selected = ($link == Router::url(null, false)); 
        ?>
        <li>
          <a href="<?=$link?>" class="<?=$custom_selected ? 'active' : 'text-scheme'?>" title="<?= $menu['menus']['text'] ?>"<?= $menu['menus']['target_blank'] === '1' ? ' target="blank"' : '' ?>><?= $menu['menus']['title'] ?></a>
        </li>
      <?php endforeach ?>
      <?php if( !empty($lookBook) ): ?>
      <li>
        <?php
            echo $this->Html->link('Lookbook', array('controller' => 'catalogo', 'action' => 'index'));
        ?>
      </li>
      <?php endif ?>
      <?php if( !empty($settings['show_shop']) ): ?>
        <li>
<?php echo $this->Html->link('Shop', array(
              'controller' => 'shop', 
              'action' => 'index',
              ),
              array(
                'class' => !$custom_selected && in_array($this->request->params['controller'], array('shop', 'tienda')) ? 'active' : 'text-scheme',
                'data-toggle' => 'mouseenter',
                'data-target' => '.shop-options',
                'data-animation' => 'animation-pullDown animation-both'
              )
            );?>
        </li>
      <?php endif ?>
      <!--li>
          <?php
            echo $this->Html->link('WhatsApp', array('controller' => 'shop', 'action' => 'promos'));
          ?>
      </li-->
      <li>
          <?php
            echo $this->Html->link('Sucursales', array(
              'controller' => 'sucursales', 
              'action' => 'index'
            ),
            array(
              'class' => $this->request->params['controller'] == 'sucursales' ? 'active' : 'text-scheme'
            )
          );?>
      </li>
      <li>
          <?php
            echo $this->Html->link('Ayuda', array(
              'controller' => 'ayuda', 
              'action' => 'como_comprar'
            ),
            array(
              'class' => $this->request->params['controller'] == 'ayuda' ? 'active' : 'text-scheme'
            )
          );?>
      </li>
      <li>
        <?php
          echo $this->Html->link('Contacto', array(
            'controller' => 'contacto', 
            'action' => 'index'
          ),
          array(
            'class' => $this->request->params['controller'] == 'contacto' ? 'active' : 'text-scheme'
          )
        );?>
      </li>
    </ul>

    <ul class="nav navbar-nav navbar-right animation-pullDown animation-both delay2">
      <li>
        <a href="#" class="is-unlifted text-scheme" title="Buscar en la tienda">
          <i data-toggle="sidebar" data-target=".sidebar-search" data-focus=".search-input" class="gi gi-search text-lightgrey"></i>
        </a>
      </li>

     <!-- .Login -->
      <li class="dropdown">
        <?php if ($loggedIn) { ?>
        <a href="#" class="dropdown-toggle text-scheme js-activated is-unlifted" data-toggle="dropdown" data-hover="dropdown" id="iniciar-sesion">
          <!--span class="countscaleIn speed delay1">
            <i class="fa fa-check text-white fa-xs"></i>
          </span-->
          <i data-toggle="sidebar" data-target=".sidebar-account" class="gi gi-woman text-green"></i>
        </a>
        <ul class="dropdown-menu">
          <li>
           <div id="login-panel">
              <div class="control-panel">
                <p class="title">Panel de Clienta</p>
                <div id="user-data">
                  <div id="user-name">
                    <span data-toggle="sidebar" data-target=".sidebar-account"><?php echo $user['name'] . " " . $user['surname']; ?></span>
                    <a href="/shop/cuenta" class="pencil">
                      <span class="fa fa-pencil"></span>
                    </a>
                  </div>
                  <div id="user-email">
                    <span class="text-lowercase"><?php echo $user['email']; ?></span>
                  </div>
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
                <a href="/users/logout" class="btn btn-chatelet btn-logout">Cerrar sesión</a>
              </div>
            </div>
          </li>
        </ul>
        <?php } else { ?>
        <a href="#" class="dropdown-toggle text-scheme is-unlifted" title="Inicia sesión">
          <i data-toggle="sidebar" data-target=".sidebar-account" class="gi gi-woman text-lightgrey"></i>
        </a>
        <?php } ?>
      </li><!-- /.Login -->
      <li class="dropdown is-clickable">
        <a href="#" data-toggle="sidebar" data-target=".sidebar-cart" class="dropdown-toggle text-scheme  js-activated<?=is_array($cart) && count($cart) ? ' text-theme':'' ?>" data-toggle="dropdown" data-hover="dropdown">
          <span class="count-cont" data-toggle="sidebar" data-target=".sidebar-cart" title="Mi carrito">
            <?php if(is_array($cart) && count($cart)):?>
            <span class="count animation-pulse delay1" data-toggle="sidebar" data-target=".sidebar-cart"><?=count($cart)?></span>
            <?php endif ?>                
            <i data-toggle="sidebar" data-target=".sidebar-cart" class="gi gi-shopping_cart <?= is_array($cart) && count($cart) ? 'text-green' : 'text-lightgrey' ?>"></i>
          </span>
        </a>
        <ul class="dropdown-menu">
          <li>
            <div class="control-panel">
            <?php if ($this->Session->check('cart')): ?>
              <p class="title">Tu pedido</p>
              <ol id="items">
                <?php
                  $total = 0;
                  if (!isset($cart)) $cart = array();
                  foreach($cart as $producto) {

                      /* if(!empty($producto['discount']) && (float)$producto['discount']>0){
                        $producto['price'] = $producto['discount'];
                      } */

                      $total += $producto['price'];
                      $color = empty($producto['price'])?'text-success':'text-grey';
                      echo '<li class="'.$color.'">';
                        echo '<a href="/carrito"><span class="ellipsis">'. $producto['name'] .'</span> - <strong>'. \price_format($producto['price']) . '</strong></a>';
                      echo '</li>';
                    }
                ?>
              </ol>
              <p>
                <a class="text-theme" href="/carrito">Total <span class="right text-bold"><?php echo \price_format($total) ?></span></a>
              </p>
              <p class="bottom" title="Ir al carrito">
                <?php
                  echo $this->Html->link('<span class="gi gi-shopping_cart"></span>', array(
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
                    echo $this->Html->link('Carrito', array(
                        'controller' => 'carrito',
                        'action' => 'index'
                      ), array(
                        'class' => 'right'
                      )
                    );
                  ?>
                </span>
              </p>
            <?php else: ?>
              <h5 class="text-muted">Tu carrito está vacío.</h5>
              <p class="notification text-muted">Obtén más información <a href="/ayuda/como_comprar" class="text-primary">acerca de como comprar</a></p>
            <?php endif ?>
            </div>
          </li>
        </ul>
      </li>
    </ul>
  </div><!-- /.navbar-collapse -->
