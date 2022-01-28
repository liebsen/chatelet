
<nav class="navbar animated fadeIn speed delay">
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

          <li>
            <?php
                echo $this->Html->link('Lookbook', array('controller' => 'catalogo', 'action' => 'index'));
            ?>
          </li>
          <?php if( !empty($show_shop) ): ?>
            <li>
              <?php
                  echo $this->Html->link('Shop', array('controller' => 'shop', 'action' => 'index'),array('class'=>'viewSubMenu'));
              ?>
            </li>
          <?php endif ?>
          <li>
              <?php
                echo $this->Html->link('Compra por WhatsApp', array('controller' => 'shop', 'action' => 'promos'));
              ?>
          </li>
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
         <!-- .Login -->
          <li class="dropdown">
             <?php if ($loggedIn) { ?>
             <a href="#" class="dropdown-toggle user js-activated" data-toggle="dropdown" data-hover="dropdown" id="iniciar-sesion">
             Perfíl</a>
            <ul class="dropdown-menu">
               <li>
                 <div id="login-panel">
                  <div id="control-panel">
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
                      echo $this->Html->link('Cerrar sesion', array(
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
             <a href="#" class="dropdown-toggle user" data-toggle="modal" data-target="#particular-login" data-toggle="dropdown" id="iniciar-sesion">Perfíl</a>
            <?php } ?>
          </li><!-- /.Login -->
          <li class="dropdown">
            <span class="count animated scaleIn speed delay2"><?=count($carro)?></span>
            <a href="#" class="dropdown-toggle shop js-activated" data-toggle="dropdown" data-hover="dropdown">Mi pedido</a>
            <ul class="dropdown-menu">
              <li>
                <div>
                  <p class="title">Mi Carrito</p>
                  <ol id="items">
                    <?php
                      $total = 0;
                      if (!isset($carro)) $carro = array();
                      foreach($carro as $producto) {

                          if(!empty($producto['discount']) && (float)$producto['discount']>0){
                            $producto['price'] = $producto['discount'];
                          }

                          $total += $producto['price'];
                          echo '<li>';
                            echo '<span class="ellipsis">'. $producto['name'] .'</span> - <strong>'. $this->Number->currency($producto['price'], 'USD', array('places' => 0)) . '</strong>';
                          echo '</li>';
                        }

                    ?>
                  </ol>
                  <p>
                    Total <span class="right"><?php echo $this->Number->currency($total, 'USD', array('places' => 0)); ?></span>
                  </p>
                  <p class="bottom">
                    <?php
                      if ($this->Session->check('Carro')) {
                        echo $this->Html->link('Modificar', array(
                          'controller' => 'carrito',
                          'action' => 'index'
                          )
                        );
                      } else {
                        echo 'Modificar';
                      }
                    ?>
                    <span class="right">
                      <?php
                        if ($this->Session->check('Carro')) {
                          echo $this->Html->link('Pagar', array(
                              'controller' => 'carrito',
                              'action' => 'index'
                            ), array(
                              'class' => 'pink pay',
                            )
                          );
                        } else {
                          echo 'Pagar';
                        }
                      ?>
                    </span>
                  </p>
                </div>
              </li>
            </ul>
          </li>
          <li>
            <a href="#" class="action-search"></a>
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
  <div class="wrapper">
    <div class="row">
      <div class="col-sm-12">
        <h3>Buscar</h3>    
        <div class="box-search">
          <input type="text" class="form-input input-search" placeholder="Buscar...">
          <svg class="spinner-search" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
            <rect class="spinner__rect" x="0" y="0" width="100" height="100" fill="none"></rect>
            <circle class="spinner__circle" cx="50" cy="50" r="40" stroke="#f41c80" fill="none" stroke-width="8" stroke-linecap="round">
            </circle>
          </svg>
        </div>
      </div>
    </div>
    <div class="row display-flex search-results"></div>
    <div class="row display-flex search-more"></div>
  </div>
</div>

<div id="menuShop" class="menuLayer">
    <a class="close">
        <span></span>
        <span></span>
    </a>
    <div class="wrapper">
        <div class="row">
            <img  class="pull-left" src="<?php echo Configure::read('imageUrlBase').$image_menushop?>" >
            <div class="col-sm-6">

                <h3>Shop</h3>
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
