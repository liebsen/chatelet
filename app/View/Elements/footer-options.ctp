        <div class="options">
          <div class="p-1">
            <h5 class="text-uppercase">Colección</h5>
            <ul>
            <?php
            if (!empty($categories)){
              foreach ($categories as $category) {
                $category = $category['Category'];
                if(strlen($category['name']) > 3) {
                  echo '<li>';
                  echo $this->Html->link(
                      $category['name'],
                      array(
                          'controller' => 'shop',
                          'action' => 'product',
                          intval($category['id'])
                      )
                  );
                  echo '</li>';
                }
              }
            }
           ?>
            </ul>
          </div>

          <?php
          if (!empty($lookBook)){ ?>

          <div class="p-1">
            <h5 class="text-uppercase">LookBook</h5>
            <ul>
          <?php foreach ($lookBook as $item) {
              $item = $item['LookBook'];
              echo '<li>';
              echo $this->Html->link(
                  $item['name'],
                  array(
                      'controller' => 'catalogo',
                      'action' => 'index'/*,
                      intval($item['id'])*/
                  )
              );
              echo '</li>';
          }
          ?>
            </ul>
          </div>
              
          <?php } ?>

          <div class="p-1">
            <h5 class="text-uppercase">Información</h5>
            <ul>
              <li>
              <?php echo $this->Html->link('Sucursales', array('controller' => 'sucursales', 'action' => 'index'));?>
              </li>
              <li>
                <?php echo $this->Html->link('Ayuda', array('controller' => 'ayuda', 'action' => 'como_comprar')); ?>
              </li>
              <li><?php echo $this->Html->link('Contacto', array('controller' => 'contacto', 'action' => 'index')); ?></li>
            </ul>
          </div>

          <div class="p-1">
            <!--  <a href="mailto:sueldos@chatelet.com.ar"><h4>Trabaja con nosotros</h4></a>-->
              <h5 class="text-uppercase">Empresa</h5>
              <ul>
                  <li>
                      <a href="#" data-toggle="modal" data-target="#particular-email">
                          <span>Trabajá con nosotros</span>
                      </a>
                  </li>
                  <li>
                      <a href="javascript:$zopim.livechat.window.show();">
                          <span>Chateá con un asesor</span>
                      </a>
                  </li>
              </ul>
                  <!--<a href="#">
                  <span></span>
                  Chateá con un<br>asesor online
              </a>-->
          </div>
        </div>