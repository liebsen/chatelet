<div id="carousel-banners" class="carousel<?php echo in_array(Router::url(), array('/', '/home')) ? ' animated fadeIn delay' : '' ?>" data-interval="10000" data-ride="carousel">
  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
  <?php foreach ($banners as $key => $banner): ?>
    <div class="item <?php echo (!$key) ? 'active' : is_null('') ; ?>">
      <a href="<?php echo router::url($banner['Banner']['href']) ?>"<?= $banner['Banner']['target_blank'] === 'on' ? ' target="blank"' : '' ?>>
        <?php if($banner['Banner']['img_url']):?>
          <div class="slider" style="background-image:url(<?php echo $banner['Banner']['img_url']; ?>)"></div>
        <?php else: ?>
        <div class="banner-caption">
          <span><?php echo $banner['Banner']['text']; ?></span>
        </div>
        <?php endif ?>
      </a>
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

<style>
  #carousel-banners {
    background-color: black;
    color: white;
    min-height: 50px;
  }

  #carousel-banners .banner-caption {
    text-align: center;
    color: white;
    font-size: 0.9rem;
    position: inherit;
    display: flex;
    line-height: 1.25;
    justify-content: center;
    align-items: center;
    min-height: 50px;
    font-weight: 500;
  }

  #carousel-banners .item.active {
    animation: fadeIn 500ms ease-in;
  }

  @media screen and (max-width:500px){
    #carousel-banners .banner-caption {
      font-size: 0.9rem;
    }
  }

</style>