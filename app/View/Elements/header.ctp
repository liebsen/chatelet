
   <nav class="navbar">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Chatelet</a>
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
                echo $this->Html->link('Shop', array('controller' => 'shop', 'action' => 'index'));
            ?>
          </li>
        <?php endif ?>
        <li>
            <?php 
              echo $this->Html->link('Promociones', array('controller' => 'shop', 'action' => 'promos')); 
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
          <a href="#" class="dropdown-toggle user" data-toggle="dropdown" id="iniciar-sesion">
            <span class="user"></span>
          </a>
          <ul class="dropdown-menu">
            <li>
              <div id="login-panel">
                <?php
                  if ($loggedIn) {
                ?>
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
                <?php
                  } else {
                ?>
                  <?php 
                    echo $this->Form->create(null, array('url' => array('controller' => 'users', 'action' => 'login'))); 
                  ?>
                    <p class="title">Iniciar Sesion</p>
                    <input type="email" id="login-email" name="data[User][email]" placeholder="Email" />
                    <input type="password" id="login-password" name="data[User][password]" placeholder="Password" />
                    <input type="submit" id="login" value="Ingresar" />
                    <a href="#" id="forgot-password">Olvide mi contraseña</a>
                  <?php echo $this->Form->end(); ?>
                  <p class="register-container">
                    <a href="#" id="register" data-toggle="modal" data-target="#particular-modal">Registrarse</a>
                  </p>
                <?php
                  }
                ?>
              </div>
            </li>
          </ul>
        </li><!-- /.Login -->
        <?php 
          if( $this->Session->check('Carro') && !empty($this->Session->read('Carro')) ){
            $display_dropdown = 'open';
          }else{
            $display_dropdown = '';
          }
        ?>
        <li class="dropdown <?php echo $display_dropdown ?>">
          <a href="#" class="dropdown-toggle shop" data-toggle="dropdown">
            <?php
              echo '<span id="product-count" class="badge">'. count($carro) .'</span>';
            ?>

          </a>
          <ul class="dropdown-menu">
            <li>
              <div>
                <p class="title">Mi Carrito</p>
                <ol id="items">
                  <?php
                    $total = 0;
                    if (!isset($carro)) $carro = array();
                    foreach($carro as $producto) {
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

      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>



<!--
        <nav class="navbar">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
 <!--               <div class="navbar-header">
                    <a class="navbar-brand" href="#">Chatelet</a>
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
 <!--               <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <ul class="nav navbar-nav">
                    <li><a href="lookbook.html">Lookbook</a></li>
                    <li><a href="shop.html">Shop</a></li>
                    <li><a href="#">Promociones</a></li>
                    <li><a href="sucursales.html">Sucursales</a></li>
                    <li><a href="ayuda_cc.html">Ayuda</a></li>
                    <li><a href="contacto.html">Contacto</a></li>
                  </ul>

                  <ul class="nav navbar-nav navbar-right">
                    <li><a href="#" class="user"></a></li>
                    <li><a href="#" class="shop"><span class="badge">2</span></a></li>
                  </ul>
                </div><!-- /.navbar-collapse -->
<!--            </div><!-- /.container-fluid -->
  <!--      </nav> -->