    <footer>
            <div class="wrapper">
                <div class="col-md-3 col-sm-6">
                    <h3>Shop online</h3>
                    <ul>
                        <li><a href="#">Chaquetas</a></li>
                        <li><a href="#">Remeras</a></li>
                        <li><a href="#">Pantalones</a></li>
                        <li><a href="#">Vestidos</a></li>
                        <li><a href="#">Blusas</a></li>
                        <li><a href="#">Sweaters</a></li>
                        <li><a href="#">Polleras</a></li>
                        <li><a href="#">Look Sport</a></li>
                    </ul>
                </div>

                <div class="col-md-3 col-sm-6">
                    <h3>Catálogo</h3>
                    <ul>
                        <li><a href="#">Primavera/Verano 2017</a></li>
                        <li><a href="#">Otoño/Invierno 2016</a></li>
                    </ul>
                </div>

                <div class="col-md-3 col-sm-6 clb">
                    <h3>Contacto</h3>
                    <ul>
                        <li> 
	                      <?php echo $this->Html->link('Sucursales', array('controller' => 'sucursales', 'action' => 'index')). ' | ';?>
	                    </li>
	                    <li> 
						  <?php echo $this->Html->link('Consultas/Sugerencias', array('controller' => 'contacto', 'action' => 'index')). ' | '; ?>
						</li>
                    </ul>
                </div>

                <div class="col-md-3 col-sm-6">
                    <h4>Trabaja con nosotros</h4>
                    <a href="#">
                        <span></span>
                        Chateá con un<br>asesor online
                    </a>
                </div>

                <p class="text-center">Chatelet <?php echo date('Y'); ?>. Buenos Aires, Argentina. Todos los derechos reservados</p>
            </div>

            <div class="bottom">
                <a href="#" class="fb" target="_blank"></a>
                <a href="#" class="tt" target="_blank"></a>
                <a href="#" class="ig" target="_blank"></a>
            </div>
        </footer>