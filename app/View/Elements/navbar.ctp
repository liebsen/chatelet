  <div class="container-fluid is-flex-between">
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
          <?php if( !empty($settings['show_shop']) ): ?>
            <li>
              <a href="/Shop" data-toggle="mouseenter" data-target=".shop-options" data-animation="animation-pullDown animation-both">Shop</a>
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
            <a href="#" class="is-unlifted" title="Buscar en la tienda">
              <i data-toggle="sidebar" data-target=".sidebar-search" data-focus=".search-input" class="gi gi-search text-lightgrey"></i>
            </a>
          </li>

         <!-- .Login -->
          <li class="dropdown">
            <?php if ($loggedIn) { ?>
            <a href="#" class="dropdown-toggle js-activated is-unlifted" data-toggle="dropdown" data-hover="dropdown" id="iniciar-sesion">
              <!--span class="countscaleIn speed delay1">
                <i class="fa fa-check text-white fa-xs"></i>
              </span-->
              <i data-toggle="sidebar" data-target=".sidebar-account" class="gi gi-user text-green"></i>
            </a>
            <ul class="dropdown-menu">
              <li>
               <div id="login-panel">
                  <div class="control-panel">
                    <p class="title">Panel de Usuario</p>
                    <div id="user-data">
                      <div id="user-name">
                        <?php echo $user['name'] . " " . $user['surname']; ?>
                        <a href="#" class="pencil">
                          <span data-toggle="sidebar" data-target=".sidebar-account" class="fa fa-pencil"></span>
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
                    <a href="/users/logout" class="btn btn-chatelet btn-logout">Cerrar sesión</a>
                  </div>
                </div>
              </li>
            </ul>
            <?php } else { ?>
            <a href="#" class="dropdown-toggle is-unlifted" title="Inicia sesión">
              <i data-toggle="sidebar" data-target=".sidebar-account" class="gi gi-woman text-lightgrey"></i>
            </a>
            <?php } ?>
          </li><!-- /.Login -->
          <li class="dropdown is-clickable">
            <a href="#" data-toggle="sidebar" data-target=".sidebar-cart" class="dropdown-toggle js-activated<?=is_array($cart) && count($cart) ? ' text-theme':'' ?>" data-toggle="dropdown" data-hover="dropdown">
              <span class="count-cont" data-toggle="sidebar" data-target=".sidebar-cart" title="Mi carrito">
                <?php if(is_array($cart) && count($cart)):?>
                <span class="count animation-pulse delay1" data-toggle="sidebar" data-target=".sidebar-cart"><?=is_array($cart) && count($cart)?></span>
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
                  <h3 class="text-muted">Tu carrito está vacío.</h3>
                  <p class="notification text-muted">Obtén más información <a href="/ayuda/como_comprar" class="text-primary">acerca de como comprar</a></p>
                <?php endif ?>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->