          <li>
            <a href="#" title="Buscar en la tienda">
              <i data-toggle="sidebar" data-target=".sidebar-search" data-focus=".search-input" class="fa text-light fa-search is-unlifted"></i>
            </a>
          </li>

         <!-- .Login -->
          <li class="dropdown">
            <?php if ($loggedIn) { ?>
            <a href="#" class="dropdown-toggle js-activated" data-toggle="dropdown" data-hover="dropdown" id="iniciar-sesion">
              <!--span class="count animated scaleIn speed delay1">
                <i class="fa fa-check text-white fa-xs"></i>
              </span-->
              <i data-toggle="sidebar" data-target=".sidebar-account" class="fa text-green fa-user-o is-unlifted"></i>
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
            <a href="#" class="dropdown-toggle" title="Inicia sesión">
              <i data-toggle="sidebar" data-target=".sidebar-account" class="fa text-dark fa-user-o is-unlifted"></i>
            </a>
            <?php } ?>
          </li><!-- /.Login -->
          <li class="dropdown is-clickable">
            <a href="#" data-toggle="sidebar" data-target=".sidebar-cart" class="dropdown-toggle js-activated<?=count($cart) ? ' text-theme':'' ?>" data-toggle="dropdown" data-hover="dropdown">
              <?php if(count($cart)):?>
              <span data-toggle="sidebar" data-target=".sidebar-cart" class="count animated scaleIn speed delay1"><?=count($cart)?></span>
              <?php endif ?>
              <span data-toggle="sidebar" data-target=".sidebar-cart" title="Mi carrito"><i data-toggle="sidebar" data-target=".sidebar-cart" class="fa fa-shopping-bag <?= count($cart) ? 'text-green' : 'text-dark' ?>" style="font-size: 1.1rem;"></i></span>
            </a>
            <ul class="dropdown-menu">
              <li>
                <div class="control-panel">
                <?php if ($this->Session->check('cart')): ?>
                  <p class="title">Tu pedido</p>
                <?php else: ?>
                  <h3>Tu carrito está vacío.</h3>
                  <p class="notification text-muted">Obtén más información <a href="/ayuda/como_comprar" class="text-primary">acerca de como comprar</a></p>
                <?php endif ?>
                  <ol id="items">
                    <?php
                      $total = 0;
                      if (!isset($cart)) $cart = array();
                      foreach($cart as $producto) {

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