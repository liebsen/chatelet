<?php
    echo $this->Html->css('sucursales', array('inline' => false));

    echo $this->Html->script('sucursales', array('inline' => false));
    
    echo $this->Session->flash();
?>

  <section class="map">
            <div class="col-md-4">
                <h1>Nuestras<br>sucursales</h1>
            </div>

            <div class="col-md-8 p-0">

                <div id="map-canvas" class="sucursales sucursal"  data-url="<?php echo $this->Html->url(array( 'controller' => 'api' , 'action' => 'sucursales' )) ?>"></div>
            </div>
        </section>

        

        <section id="location">
                <div class="col-md-12">
                    
                
                <?php   foreach($stores as $store) {
                    $store = $store['Store'];

                        echo '<h4>'. $store['name'] .'</h4>';
                        echo '<h3></h3>';  
                            echo '<ul>';      
                                echo '<li> '. $store['address'] .'</li>';
                                echo '<li> Tel. '. $store['phone'].'</li>';
                            echo '</ul>';
                } ?> 
                

                </div>
         </section>
       
        <section id="suscribe">
            <div class="wrapper container is-flex-end">
                <div class="col-md-6">
                    <h2 class="h2 mt-0 mb-1">Estemos <strong>conectad@s</strong></h2>
                    <p>Enterate de nuestras novedades, descuentos y beneficios exlusivos solo para clientas</p>
                </div>
                <div class="col-md-6">
                    <?php echo $this->Form->create('Contact', array('class' => 'contacto')); ?>
                      <input class="p-1" type="text" name="data[Subscription][email]" placeholder="Ingresá tu email" required>
                      <input type="submit" id="enviar" value="ok">
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </section>


<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA80jEAk4PzzCEBDXc8prj7LCB1Q3U3g_o&v=3.exp&sensor=true&language=es"></script>
<script type="text/javascript">
function initialize(address) {
      // I create a new google maps object to handle the request and we pass the address to it
  var geoCoder = new google.maps.Geocoder(address)
      // a new object for the request I called "request" , you can put there other parameters to specify a better search (check google api doc for details) , 
      // on this example im going to add just the address  
  var request = {address:address};
       
      // I make the request 
  geoCoder.geocode(request, function(result, status){
              // as a result i get two parameters , result and status.
              // results is an  array tha contenis objects with the results founds for the search made it.
              // to simplify the example i take only the first result "result[0]" but you can use more that one if you want
 
              // So , using the first result I need to create a  latlng object to be pass later to the map
              var latlng = new google.maps.LatLng(result[0].geometry.location.lat(), result[0].geometry.location.lng());  
 
      // some initial values to the map   
      var myOptions = {
        zoom: 15,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      };
 
           // the map is created with all the information 
             var map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
 
           // an extra step is need it to add the mark pointing to the place selected.
          var marker = new google.maps.Marker({position:latlng,map:map,title:'title'});
 
  })
}
</script>