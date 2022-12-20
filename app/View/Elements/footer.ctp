<?php echo $this->Html->css('font-awesome', array('inline' => false)); ?>
<?php if ($data['whatsapp_enabled']): ?>
    <a href="https://wa.me/<?= $data['whatsapp_phone'] ?>?text=" class="d-block whatsapp-block animated scaleIn delay3">
        <i class="fa fa-whatsapp"></i>
        <?php if(!empty($data['whatsapp_text'])): ?>
        <span class="whatsapp-text font-system">
            <?= $data['whatsapp_text'] ?>
        </span>
        <?php endif ?>
    </a>
<?php endif ?>
    <footer>
            <div class="wrapper">
                <div class="col-md-4 col-sm-6 col-xs-12">
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

                <?php
                if (!empty($lookBook)){ ?>

                <div class="col-md-4 col-sm-6 col-xs-12">
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

                <div class="col-md-4 col-sm-6 col-xs-12 clb">
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

                <div class="col-md-4 col-sm-6 col-xs-12">
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

                <p class="text-center text-muted"><span class="is-clickable" title="v<?= $version_text ?>">Châtelet</span> <?php echo date('Y'); ?>. Buenos Aires, Argentina. Todos los derechos reservados</p>
            </div>

            <div class="bottom">
                <a href="https://twitter.com/chateletmoda" target="_blank">
                    <i class="fa fa-twitter"></i>
                </a>
                <a href="https://www.facebook.com/pages/Ch%C3%A2telet/114842935213442" target="_blank">
                    <i class="fa fa-facebook"></i>
                </a>
                <a href="https://www.instagram.com/chateletmoda/" target="_blank">
                    <i class="fa fa-instagram"></i>
                </a>
            </div>
        </footer>

        <?php echo $this->Html->script('plugins', array('inline'=>false))?>
