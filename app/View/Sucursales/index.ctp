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

                <div id="map-canvas" class="sucursales sucursal"  data-url="<?php echo $this->Html->url(array( 'controller' => 'api' , 'action' => 'sucursales' )) ?>"></div>
            </div>
        </section>

        <section id="location">
            <div class="col-md-4 search buscar" >
                <form  id="busqueda" action="#">
                   <input type="text" name="termino" class="termino" placeholder="Buscar" />
                  
                    <p>Ej. Av. Rivadavia 5700, Ciudad Autonoma de Buenos Aires.</p>
                </form>
            </div>
            <div class="col-md-8">
                    <ul id="sucursales" class="list-unstyled" data-url="<?php echo $this->Html->url(array( 'controller' => 'api' , 'action' => 'sucursales' )) ?>">
                    <?php   foreach($stores as $store) {
                        $store = $store['Store'];
                            echo '<h4>'. $store['name'] .'</h4>';
                                echo '<ul>';      
                                    echo '<li> '. $store['address'] .'</li>';
                                    echo '<li> Tel. '. $store['phone'].'</li>';
                                echo '</ul>';
                            echo '</div>';
                    } ?>
                    </ul>
            </div>
        </section>
       


        <section id="suscribe">
            <div class="wrapper">
                <div class="col-md-6">Suscribite y conocé las <strong>novedades</strong></div>
                <div class="col-md-6">
                    <?php echo $this->Form->create('Contact', array('class' => 'contacto')); ?>
                      <input type="text" name="data[Subscription][email]" placeholder="Ingresá tu email" required>
                      <input type="submit" id="enviar" value="ok">
                    <?php echo $this->Form->end(); ?>
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
</div>-->

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA80jEAk4PzzCEBDXc8prj7LCB1Q3U3g_o&v=3.exp&sensor=true&language=es"></script>
<script type="text/javascript"> 
  var geocoder;
  var map;
 
  
  function codeAddress() {
    var termino = document.getElementById("termino").value + ', Buenos Aires';
    geocoder.geocode( { 'termino': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: map, 
            position: results[0].geometry.location
        });
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
  }
</script> 
