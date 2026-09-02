<?php
    echo $this->Session->flash();
    $this->Html->css('sucursales', array('block' => 'css'));
    $this->Html->script('sucursales', array('block' => 'script'));
?>

  <section class="wrapper-fluid map animation-fadeIn animation-both delay">
    <div class="col-xs-12 col-md-3">
      <div class="animation-fadeIn slow">
        <h1>Nuestras<br>sucursales</h1>
      </div>
    </div>

    <div class="col-xs-12 col-md-9">
      <div id="map-canvas" class="sucursales"  data-url="<?php $this->Html->url(array( 'controller' => 'api' , 'action' => 'sucursales' )) ?>"></div>
    </div>
  </section>

  <section id="location" class="animation-fadeIn animation-both delay">
    <div class="col-md-12">
      <?php foreach($stores as $store) {
          $store = $store['Store'];
          $phones = explode('/', $store['phone']);
          $phone_arr = [];
          foreach($phones as $phone) {
            $phone_arr[]= $phone; 
          }
          echo '<h4 class="sucursal text-chatelet is-clickable" data-sucursal="'. $store['id'] .'" data-lat="'.$store['id'].'" data-lng="'.$store['lng'].'">'. $store['name'] .'</h4>';
          echo '<h3></h3>';  
          echo '<ul>';      
          echo '<li><a class="sucursal is-clickable text-nowrap" data-sucursal="'. $store['id'] .'" data-lat="'.$store['id'].'" data-lng="'.$store['lng'].'"><i class="fa fa-map-pin mr-2"></i>'. $store['address'] .'</a></li>';
          foreach($phone_arr as $phone_str){
            echo '<li><a href="tel:'.$phone_str.'"><i class="fa fa-lg fa-phone mr-2"></i>'.$phone_str.'</a></li>';
          }
          if($store['whatsapp']){
            echo '<li><a href="https://wa.me/'.$store['whatsapp'].'?text=Hola, tengo una consulta" target="_blank"><i class="fa fa-lg fa-whatsapp mr-2"></i>'. $store['whatsapp'].'</a></li>';
          }
          if($store['takeaway'] == '1'){
            echo '<li><span class="text-chatelet"><i class="fa fa-shopping-bag mr-2"></i> Takeaway</span></li>';
          }
          echo '</ul>';
      } ?>
    </div>
  </section>


<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA80jEAk4PzzCEBDXc8prj7LCB1Q3U3g_o&v=3.exp&language=es"></script>
<script type="text/javascript">
function initialize(address) {
  var geoCoder = new google.maps.Geocoder(address)
  var request = {address:address};
  geoCoder.geocode(request, function(result, status){
    var latlng = new google.maps.LatLng(result[0].geometry.location.lat(), result[0].geometry.location.lng());  
 
    var myOptions = {
      zoom: 15,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
 
    var map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);

    var marker = new google.maps.Marker({position:latlng,map:map,title:'title'});
 
  })
}
</script>

<style>
  #location { 
    overflow: hidden; 
  }
  #location .col-md-4 { 
  	background: url(../images/ico3.png) no-repeat center center #efb0d2; 
  	min-height: 260px; 
  }
  #location .col-md-12 { 
  	padding-left: 150px; 
  	padding-right: 150px; 
  	padding-top: 60px; 
  	padding-bottom: 60px; 
  }
  #location .col-md-12 h3 { 
  	border-bottom: 2px solid #d7d7d7; 
  	font-size: 18px; 
  	font-weight: 300; 
  	display: block;
  	width: 100%;
  }
  #location .col-md-12 ul {
  	display: block;
  	margin: 10px 0;
  	float: left;
  	width: 100%; 
  	height: 100%; 
  	padding-bottom: 45px;
  }
  #location .col-md-12 ul li { 
  	float: left; 
  	min-height: 63px; 
  	/*font-size: 18px;*/
  	font-weight: 300; 
  	min-width: 25%; 
  }
  #location .col-md-12 ul li a { padding-right:1rem }
  #location .col-md-4.search { background: #FFF; padding-top: 75px; }
  #location .col-md-4.search input { background: url(../images/lupa.png) 35px center no-repeat transparent; border: 2px solid #363633; font-size: 16px; font-weight: 500; margin-bottom: 30px; padding: 10px 20px 10px 70px; width: 100%; }
  #location .col-md-4.search p { font-size: 16px; font-weight: 500; line-height: 1.4; }
  #location .col-md-8 { padding-left: 150px; padding-right: 150px; padding-top: 60px; }
  #location .col-md-8 h3 { border-bottom: 2px solid #efb0d2; font-size: 18px; font-weight: 500; margin-bottom: 20px; padding-bottom: 20px; }
  #location .col-md-8 h4 { font-size: 20px; font-weight: 600; margin-bottom: 30px; }
  #location .col-md-8 ul li { float: left; font-size: 18px; font-weight: 500; width: 50%; }
    #location .col-md-8 { padding-left: 75px; padding-right: 75px; }
    #location .col-md-4.search p { font-size: 1rem; }
  @media (max-width: 767px) {

    #location { padding-bottom: 30px; }

    #location .col-md-8 { padding-left: 15px; padding-right: 15px; }
    #location .col-md-8 ul li { float: none; margin-bottom: 30px; width: 100%; font-size: 18px; }
    #location .col-md-8 h3, #location .col-md-8 h4 { font-size: 18px; }

      #location .col-md-12 {
          padding-left: 25px;
          padding-right: 25px;
      }
      #location .col-md-12 ul li {
          width: 100%;
      }

  }

</style>