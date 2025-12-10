<?php 

$images   = array();
$images_aux = explode(';', @$home['img_url']);
foreach ($images_aux as $key => $value) {
  if(!empty($value))
    $images[]   = $settings['upload_url'].$value;
}
$img_url_one = str_replace(';', '', @$home['img_url_one']);
$img_url_two = str_replace(';', '', @$home['img_url_two']);
$img_url_three = str_replace(';', '', @$home['img_url_three']);
$img_url_four = str_replace(';', '', @$home['img_url_four']);

?><!-- Wrapper for slides -->
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