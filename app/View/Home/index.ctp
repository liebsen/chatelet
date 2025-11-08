<?php

echo $this->Session->flash();

?>
<div class="wrapper content animated fadeIn2 delay">
  <div id="carousel" class="carousel slide" data-type="slider" data-interval="10000" data-ride="carousel">
    <?php echo $this->element('carousel') ?>
  </div>

  <section id="listShop">
    <?php echo $this->element('shop_list') ?>
  </section>

  <section id="suscribe" class="animated"> <!-- fadeIn slow delay2 -->
    <?php echo $this->element('subscribe-box') ?>
  </section>

  <?php echo $this->element('img_popup_newsletter') ?>

  <?php echo $this->element('follow_us') ?>

</div>
<?php
if(!empty($home['display_popup_form_in_last'])):?>
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

  preloadImages(images)
</script>


