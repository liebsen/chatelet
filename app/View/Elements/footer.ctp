<?php echo $this->Html->css('font-awesome', array('inline' => false)); ?>
    <footer>
            <div class="wrapper">
                <div class="col-md-3 col-sm-6">
                    <h3>Shop online</h3>
                    <ul>
                    <?php
                    if (!empty($categories)){
                    foreach ($categories as $category) {
                        $category = $category['Category'];
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
                   ?>
                    </ul>
                </div>

                <!--div class="col-md-3 col-sm-6">
                    <h3>LookBook</h3>
                    <ul>
                       <li>
                         <?php echo $this->Html->link($catalog_first_line,
                         array('controller' => 'catalogo', 'action' => 'index')); ?>
                       </li>

                    </ul>
                </div-->

                <div class="col-md-3 col-sm-6 clb">
                    <h3>Información</h3>
                    <ul>
                        <li>
	                      <?php echo $this->Html->link('Sucursales', array('controller' => 'sucursales', 'action' => 'index'));?>
	                    </li>
                        <li>
                          <?php echo $this->Html->link('Ayuda', array('controller' => 'ayuda', 'action' => 'como_comprar')); ?>
                        </li>
	                    <li>
						  <?php echo $this->Html->link('Contacto', array('controller' => 'contacto', 'action' => 'index')); ?>
						</li>
                    </ul>
                </div>

                <div class="col-md-3 col-sm-6">
                  <!--  <a href="mailto:sueldos@chatelet.com.ar"><h4>Trabaja con nosotros</h4></a>-->

                    <a href="#"  data-toggle="modal" data-target="#particular-email"><h4>Trabaja con nosotros</h4></a>

                        <!--<a href="#">
                        <span></span>
                        Chateá con un<br>asesor online
                    </a>-->
                </div>

                <p class="text-center">Châtelet <?php echo date('Y'); ?>. Buenos Aires, Argentina. Todos los derechos reservados</p>
            </div>

            <div class="bottom">
                <a href="https://twitter.com/chateletmoda" class="tt" target="_blank"></a>
                <a href="https://www.facebook.com/pages/Ch%C3%A2telet/114842935213442" class="fb" target="_blank"></a>
                <a href="https://www.instagram.com/chateletmoda/" class="ig" target="_blank"></a>
            </div>
        </footer>

        <?php echo $this->Html->script('plugins', array('inline'=>false))?>
