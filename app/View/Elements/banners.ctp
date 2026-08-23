<div id="carousel-banners" class="carousel<?php echo in_array(Router::url(), array('/', '/home')) ? ' animation-fadeIn delay' : '' ?>" data-interval="<?= $settings['banners_interval'] * 1000 ?? 5000?>" data-ride="carousel">
  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
  <?php foreach ($banners as $key => $banner): ?>
    <a href="<?php echo router::url($banner['Banner']['href']) ?>"<?= $banner['Banner']['target_blank'] === 'on' ? ' target="blank"' : '' ?> class="item <?php echo (!$key) ? 'active' : is_null('') ; ?>">
      <?php if($banner['Banner']['img_url']):?>
        <div class="slider" style="background-image:url(<?php echo $banner['Banner']['img_url']; ?>)"></div>
      <?php else: ?>
      <div class="banner-caption">
        <span><?php echo $banner['Banner']['text']; ?></span>
      </div>
      <?php endif ?>
    </a>
  <?php endforeach ?>
  </div>
  <!-- Controls -->
</div>

<style>
  #carousel-banners {
    background-color: black;
    color: white;
    min-height: 50px;
    z-index: 10;
  }

  #carousel-banners .banner-caption {
    text-align: center;
    position: inherit;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 3.5rem;
  }

  #carousel-banners .banner-caption span {
    color: white;
    font-size: 1rem;
    font-weight: 500;
    line-height: 1.25;
  }

  #carousel-banners .item.active {
    animation: fadeIn 500ms ease-in;
  }
</style>