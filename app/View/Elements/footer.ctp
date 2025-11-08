<?php 
echo $this->Html->css('font-awesome', array('inline' => false)); 
echo $this->element('whatsapp');
?>
    <footer>
      <div class="wrapper">
        <div class="options">
          <div class="p-1">
            <h3>Colección</h3>
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
            <h3>LookBook</h3>
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
            <h3>Información</h3>
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
              <h3>Empresa</h3>
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
        <p class="text-center text-footer text-muted mb-4 text-uppercase"><span class="is-clickable" title="Châtelet v<?= $version_text ?>">Châtelet</span> <?php echo date('Y'); ?>. Buenos Aires, Argentina. Todos los derechos reservados</p>
      </div>
    </footer>
    <?php echo $this->Html->script('plugins', array('inline'=>false))?>
