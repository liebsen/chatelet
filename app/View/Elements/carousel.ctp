  <!-- Wrapper for slides -->
  <div class="carousel-inner group-video" role="listbox">
  <?php foreach ($images as $key => $value): ?>
    <div class="item animated fadeIn <?php echo (!$key) ? 'active' : is_null('') ; ?>"  >
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

  <script>

    $(function () {
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