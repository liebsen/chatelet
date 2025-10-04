<?php

	echo $this->Session->flash();
	$images 	= array();
	$images_aux = explode(';', @$home['img_url']);
	foreach ($images_aux as $key => $value) {
		if(!empty($value))
			$images[] 	= Configure::read('uploadUrl').$value;
	}
  $img_url_one = str_replace(';', '', @$home['img_url_one']);
  $img_url_two = str_replace(';', '', @$home['img_url_two']);
  $img_url_three = str_replace(';', '', @$home['img_url_three']);
  $img_url_four = str_replace(';', '', @$home['img_url_four']);
?>
<script>

  var images = ["<?= implode('","',$images)?>"]
  var assets = []

  //images = responsiveImages(images)

  async function preloadVideo(i, asset){
    var req = new XMLHttpRequest();
    req.open('GET', asset, true);
    req.responseType = 'blob';
    req.onload = function() {
      if (document.getElementById('video'+i) && this.status === 200) {
        var videoBlob = this.response;
        var vid = URL.createObjectURL(videoBlob); // IE10+
        document.getElementById('video'+i).src = vid
      }
    }
    req.onerror = function() {
      // Error
    }

    req.send();    
  }
    
  function responsiveImages(images){
    var orientation = document.documentElement.clientWidth > document.documentElement.clientHeight ? 
      'desktop' : 
      'mobile'
    var items = []
    for(var i in images){
      const asset = images[i]
      if(asset.includes(orientation)) {
        items.push(asset.replaceAll("mobile-", "").replaceAll("desktop-", ""))
      }
    }
    return items    
  } 

  async function preloadImages(assets){
    for(var i in assets){
      const asset = assets[i]
      if(asset.endsWith(".mp4")){
        preloadVideo(i,asset)
      } else {
        assets[i] = document.createElement("image");
        assets[i].src = asset;
      }
    }    
  }

  preloadImages(images)
</script>

  <div id="carousel" class="carousel slide" data-interval="10000" data-ride="carousel">
    <!-- Wrapper for slides -->
    <div class="carousel-inner group-video" role="listbox">
      <?php foreach ($images as $key => $value): ?>
          <div class="item animated <?php echo (!$key) ? 'active' : is_null('') ; ?>"  >
              <a href="<?php echo router::url(array('controller' => 'Shop', 'action' => 'index')) ?>">
                  <?php if (strpos($value, '.mp4') !== false):?>
                  <video id="video<?=$key?>" class="carousel-video slider-full" <?= (strpos( $_SERVER['HTTP_USER_AGENT'], 'Safari') !== false) ? ' controls="true" ' : '' ?> playsinline loop>
                  </video>
                  <?php else: ?>
                  <div class="slider-full" style="background-image:url(<?=$value ?>)"></div>
                  <?php endif; ?>
              </a>

              <div class="carousel-caption">
                  <h1> <?php echo $home['line_one']; ?></h1>
                 <?php if(!empty($home['line_two'])){
                  echo '<span>'.$home['line_two'].'</span>';
                  } ?>
                  <p><?php echo $home['line_three']; ?></p>

                  <a href="<?php echo router::url(array('controller' => 'Shop', 'action' => 'index')) ?>">Visitar</a>
              </div>
          </div>
      <?php endforeach ?>

    </div>

      <!-- Controls -->
      <a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
          <span class="arrow arrow-left" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#carousel" role="button" data-slide="next">
          <span class="arrow arrow-right" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
      </a>
  </div>

  <section id="listShop">
    <div class="wrapper-fluid">
      <div class="row m-0">
        <div class="col-xs-12">
          <div class="row">
            <?php foreach($categories as $category): ?>
            <div class="category-item p-0 col-xs-12 col-md-<?= !empty($category['Category']['colsize']) ? $category['Category']['colsize'] : 'auto' ?>">
              <a href="<?php echo $this->Html->url(array('controller' => 'tienda', 'action' => 'productos', str_replace(array('ñ',' '),array('n','-'),strtolower($category['Category']['name'])))); ?>" class="pd1 text-center">
                <div class="d-flex justify-content-start align-items-center cat-image p-3 w-100" style="background: #eaeaea url('<?php echo Configure::read('uploadUrl').$category['Category']['img_url']?>') center center/cover no-repeat;">  
                    <span class="p-1 text-catalog text-uppercase">
                      <?php echo 
                        $this->App->cat_title(
                          strlen($category['Category']['alternate_toggle']) ?  
                            $category['Category']['alternate_name'] : 
                            $category['Category']['name']
                          ) ?>
                    </span>
                  </div>
              </a>
            </div>
            <?php endforeach ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="suscribe">
    <div class="wrapper container is-flex-end">
      <div class="col-md-6">
        <h2 class="h4 mt-0 mb-4 text-uppercase">Newsletter - Estemos <strong>conectad@s</strong></h2>
        <p class="text-uppercase text-muted">Enterate de nuestras novedades, descuentos y beneficios exlusivos solo para clientas</p>
      </div>
        
      <div class="col-md-6 max-21">
        <?php echo $this->Form->create('Contact', array('class' => 'contacto')); ?>     
        <div class="row">
          <div class="col-md-6">
            <input class="p-1" type="email" name="data[Subscription][email]" placeholder="Ingresá tu email" required>
          </div>
          <div class="col-md-6 p-0 text-right">
            <input type="submit" id="enviar" value="confirmar">
          </div>
        </div>
        <?php echo $this->Form->end(); ?>
      </div>
    </div>
  </section>

  <?php $popupBG = array_filter(explode(';', @$home['img_popup_newsletter'])) ?>

  <div class="modal fade p-0" tabindex="-1" id="myModal" role="dialog" style="background-color: #262427;">
    <div class="content js-show-modal is-clickable" data-dismiss="modal" style="background-image: url(<?= Configure::read('uploadUrl').$popupBG[0] ?>);">
      <div class="tap-to-continue animated fadeIn delay2" title="Continuar a la tienda">
        <i class="fa fa-chevron-right mr-0"></i> 
        <span class="ml-2">Continuar<span class="d-none d-lg-block d-xl-block"> a la tienda</span></span>
      </div>
    </div>
  </div>

  <div class="social-bottom">
      <span class="text-uppercase"><p class="h4">Seguinos en nuestras redes</p></span>
      <!--a href="https://twitter.com/chateletmoda" target="_blank">
          <i class="fa fa-twitter-x"></i>
      </a-->
      <a href="https://www.facebook.com/pages/Ch%C3%A2telet/114842935213442" target="_blank">
          <i class="fa fa-facebook"></i>
      </a>
      <a href="https://www.instagram.com/chateletmoda/" target="_blank">
          <i class="fa fa-instagram"></i>
      </a>
  </div>

  <?php if(!empty($home['display_popup_form_in_last'])):?>
  <style type="text/css">

    .news-carousel .item:last-child .in_last form {
      position: absolute!important;
      top:0px;
    }

    .news-carousel .item:last-child .in_last form input[type="email"] {
      margin-top: 217px;
      margin-left: 36px;
      border: none!important;
    }

    .news-carousel .item:last-child .in_last form input[type="submit"] {
      margin-top: 30px;
      float: left!important;
      border: none!important;
      margin-left: 50px;
      clear: both;
      color: transparent!important;
    }

  </style>

  <?php endif; ?>

  <script>
  var focused = false
  window.onfocus = () => {
    focused = true;
    var video = $("#carousel .item.active").find("video")
    if(video.length){
      setTimeout(() => {
        $(video).get(0).play()
      }, 20)
    }
  };

  window.onblur = () => {
    focused = false;
    $("video").each((i,video) => {
      video.pause()
    });  
  };

  $(function () {
    $('#myModal').on('hidden.bs.modal', () => {
      $('body, html').removeClass('noscroll')
      focused = true
      var video = $("#carousel .item.active").find("video")
      if(video.length){
        video[0].play()
      }
    });

    $('#carousel').on('slide.bs.carousel', (a) => {
      if(focused) {
        $("video").each((i,video) => {
          video.pause()
        });
        var video = $(a.relatedTarget).find("video")
        if(video.length) {
          setTimeout(() => {
            $(video).get(0).play()
          }, 20)
        }
      }
    });
  })

</script>
