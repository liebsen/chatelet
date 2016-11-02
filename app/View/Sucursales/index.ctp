<?php
	echo $this->Html->css('sucursales', array('inline' => false));
	echo $this->Html->script('sucursales', array('inline' => false));
	echo $this->Session->flash();
?>

  <section class="map">
            <div class="col-md-4">
                <h1>Nuestras<br>sucursales</h1>
            </div>

            <div class="col-md-8">
                <div id="map"></div>
            </div>
        </section>

        <section id="location">
            <div class="col-md-4 search">
                <form>
                    <input type="text" placeholder="Buscar">
                    <p>Ej. Av. Rivadavia 5700, Ciudad Autonoma de Buenos Aires.</p>
                </form>
            </div>
            <div class="col-md-8">
                <h3>Zona Oeste</h3>
                <h4>Ramos Mejía</h4>
                <ul>
                    <li>Av. de Mayo 6</li>
                    <li>Tel. 4654-0143</li>
                </ul>
            </div>
        </section>

        <section id="suscribe">
            <div class="wrapper">
                <div class="col-md-6">Suscribite y conocé las <strong>novedades</strong></div>
                <div class="col-md-6">
                    <form>
                        <input type="text" placeholder="Ingresá tu email">
                        <input type="submit" value="ok">
                    </form>
                </div>
            </div>
        </section>

<!--<div id="main" class="container">
	<div class="row">
		<div class="col-md-3">
			<h1 class="heading">Sucursales</h1>
			<ul id="sucursales" class="list-unstyled" data-url="<?php echo $this->Html->url(array( 'controller' => 'api' , 'action' => 'sucursales' )) ?>">
				<?php
					foreach($stores as $store) {
						$store = $store['Store'];
						echo '<li>';
							echo '<div class="sucursal" data-sucursal="'. $store['id'] .'">';
								echo '<h4 class="ciudad">'. $store['name'] .'</h4>';
								echo '<p class="detalle">';
									echo ($store['por_mayor']) ? 'Venta por mayor y menor<br />' : '';
									echo '<span class="fa fa-map-marker"></span> '. $store['address'] .'<br />';
									echo '<span class="fa fa-phone"></span> Tel. '. $store['phone'];
								echo '</p>';
							echo '</div>';
						echo '</li>';
					}
				?>
			</ul>
		</div>
		<div class="col-md-9">
			<div id="map-canvas"></div>
			<div class="buscar">
				<p class="instrucciones">Ej. Av. Rivadavia 5700, Ciudad Autonoma de Buenos Aires.</p>
				<form id="busqueda" action="#">
					<input type="text" name="termino" class="termino" />
				</form>
			</div>
		</div>
	</div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=es"></script>