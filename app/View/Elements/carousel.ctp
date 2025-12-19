<?php 

$images   = array();
$images_aux = explode(';', @$home['img_url']);
foreach ($images_aux as $key => $value) {
  if(!empty($value))
    $images[] = $value;
}

?>
  <div class="carousel-inner group-video" role="listbox">
  <?php foreach ($images as $key => $value): ?>
    <div class="item <?php echo (!$key) ? 'active' : is_null('') ; ?>">
    <a href="<?php echo router::url(array('controller' => 'Shop', 'action' => 'index')) ?>">
        <?php if (strpos($value, '.mp4') !== false):?>
        <video id="video<?=$key?>" class="carousel-video slider-full" <?= (strpos( $_SERVER['HTTP_USER_AGENT'], 'Safari') !== false) ? ' controls="true" ' : '' ?> playsinline loop>
        </video>
        <?php else: ?>
        <div class="slider-full" style="background-image:url(<?=$value ?>)"></div>
        <?php endif; ?>
      </a>
    </div>
  <?php endforeach ?>
  </div>
    <ol class="carousel-indicators">
      <?php foreach ($images as $key => $value): ?>
        <li data-target="#myCarousel" data-slide-to="<?= $key ?>" class="<?= $key == 0 ? 'active' : '' ?>"></li>
      <?php endforeach ?>
    </ol>
  <!-- Controls -->
  <a class="left carousel-control is-transparent" href="#carousel" role="button" data-slide="prev">
      <span class="arrow arrow-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control is-transparent" href="#carousel" role="button" data-slide="next">
      <span class="arrow arrow-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
  </a>


<script>

  var images = ["<?=@implode('","',$images)?>"]
  var assets = []

  //images = responsiveImages(images)

  async function preloadVideo(i, asset){
    var req = new XMLHttpRequest();
    console.log('loading:', asset)
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

  var focused = false
  window.onfocus = () => {
    focused = true;
    var video = $("#carousel .item.active").find("video")
    if(video.length){
      setTimeout(() => {
        $(video).get(0).play()
      }, 300)
    }
  };

  window.onblur = () => {
    focused = false;
    $("video").each((i,video) => {
      video.pause()
    });  
  };

  preloadImages(images)


  $(function () {
    $('#carousel').on('slide.bs.carousel', (a) => {
      if(focused) {
        /* $("video").each((i,video) => {
          video.pause()
        });*/
        var video = $(a.relatedTarget).find("video")
        if(video.length) {
          setTimeout(() => {
            $(video).get(0).play()
          }, 300)
        }
      }
    });
  })

</script>