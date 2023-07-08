
<nav class="navbar navbar-chatelet top-fixable animated fadeIn">
  <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
          <a class="navbar-brand"
           href="<?php echo router::url(array('controller' => 'Home', 'action' => 'index')) ?>" >
              Châtelet</a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
          </button>
      </div>

       <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <?php if( !empty($lookBook) ): ?>
          <li>
            <?php
                echo $this->Html->link('Lookbook', array('controller' => 'catalogo', 'action' => 'index'));
            ?>
          </li>
          <?php endif ?>
          <?php foreach($menus as $menu): ?>
            <li>
              <a href="<?= !empty($menu['menus']['href']) && strlen($menu['menus']['href']) ? $menu['menus']['href'] : $this->Html->url(array(
              'controller' => 'tienda',
              'action' => 'productos',
              str_replace(array('ñ',' '),array('n','-'),strtolower($menu['categories']['category_name']))
            )); ?>" title="<?= $menu['menus']['text'] ?>"<?= $menu['menus']['target_blank'] === 'on' ? ' target="blank"' : '' ?>><?= $menu['menus']['title'] ?></a>
            </li>
          <?php endforeach ?>
          <?php if( !empty($show_shop) ): ?>
            <li>
              <a href="/Shop">Shop</a>
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
            <a href="#" class="action-search">Buscar</a>
          </li>

         <!-- .Login -->
          <li class="dropdown">
             <?php if ($loggedIn) { ?>
             <a href="#" class="dropdown-toggle user js-activated" data-toggle="dropdown" data-hover="dropdown" id="iniciar-sesion">
             Mi Perfil</a>
            <ul class="dropdown-menu">
               <li>
                 <div id="login-panel">
                  <div class="control-panel">
                    <p class="title">Panel de Usuario</p>
                    <div id="user-data">
                      <div id="user-name"><?php echo $user['name'] . " " . $user['surname']; ?></div>
                      <div id="user-email"><?php echo $user['email']; ?></div>
                    </div>
                    <ul id="control-sections" class="list-unstyled">
                      <li class="hide">
                        <span class="fa fa-tag"></span> <a href="#">Historial de Compras</a>
                      </li>
                      <li class="hide">
                        <span class="fa fa-heart"></span> <a href="#">Mis favoritos</a>
                      </li>
                      <li class="hide">
                        <span class="fa fa-comment"></span> <a href="#">Mis consultas</a>
                      </li>
                    </ul>
                  </div>
                  <div id="control-footer">
                    <?php
                      $modal = '#particular-modal';
                      echo '<a href="#" class="pencil" data-toggle="modal" data-target="'. $modal .'">';
                        echo '<span class="fa fa-pencil"></span>';
                      echo '</a>';
                      echo $this->Html->link('Cerrar esta sesión', array(
                          'controller' => 'users',
                          'action' => 'logout'
                        ),
                        array(
                          'class' => 'right'
                        )
                      );
                    ?>
                  </div>
                    </div>
                </li>
              </ul>
            <?php } else { ?>
             <a href="#" class="dropdown-toggle user" data-toggle="modal" data-target="#particular-login" data-toggle="dropdown" id="iniciar-sesion">Registrate</a>
            <?php } ?>
          </li><!-- /.Login -->
          <li class="dropdown is-clickable">
            <a href="#" class="dropdown-toggle gotocart shop js-activated" data-toggle="dropdown" data-hover="dropdown">
              <span class="count <?=count($carro)?'':'is-empty '?>animated scaleIn speed delay2"><?=count($carro)?></span>
              <span>Tu pedido</span>
            </a>
            <ul class="dropdown-menu">
              <li>
                <div class="control-panel">
                <?php if ($this->Session->check('Carro')): ?>
                  <p class="title">Tu pedido</p>
                <?php else: ?>
                  <p class="notification text-muted">Tu carrito de compras está vacío</p>
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
                <?php if ($this->Session->check('Carro')): ?>
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


<div id="menuSearch" class="menuLayer">
  <a class="close">
    <span></span>
    <span></span>
  </a>
  <div class="wrapper pt-2">
    <div class="row">
      <div class="col-sm-12 m-0 box-search-container">
        <!--h3>Buscar</h3-->
        <div class="box-search top-fixable animate">
          <input type="text" class="form-input input-search" placeholder="Buscar...">
          <svg class="spinner-search" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
            <rect class="spinner__rect" x="0" y="0" width="100" height="100" fill="none"></rect>
            <circle class="spinner__circle" cx="50" cy="50" r="40" stroke="#f41c80" fill="none" stroke-width="8" stroke-linecap="round">
            </circle>
          </svg>
          <div class="search-bar-container">
            <div class="search-bar"></div>
          </div>
        </div>
        <!--p class="search-info"></p-->
      </div>
    </div>
    <div class="row display-flex is-justify-center search-results">
      <div class="content p-4" id="headhelp">
        <h1>¿Qué estás buscando?</h1>
        <p class="results-text text-muted"> Podés buscar por tipo de prenda, color, material ej: "remera", "pantalón", "malla", "jersey", "lino", "algodón", ... ¡Usa tu creatividad!</p>
      </div>
    </div>
    <div class="row display-flex is-justify-center search-more"></div>
  </div>
</div>
