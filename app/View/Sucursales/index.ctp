<?php
	echo $this->Html->css('sucursales', array('inline' => false));
	echo $this->Html->script('sucursales', array('inline' => false));
	echo $this->Session->flash();
?>
<div id="main" class="container">
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