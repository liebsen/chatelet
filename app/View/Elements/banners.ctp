<div id="carousel-banners" class="carousel slide animated fadeIn"data-interval="10000" data-ride="carousel">
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
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
      <span class="arrow arrow-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
      <span class="arrow arrow-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
  </a>
</div>

<style>
  #carousel-banners {
    font-family: -apple-system,system-ui,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',sans-serif;
    background-color: black;
    color: white;
    height: 64px;
  }

  #carousel-banners .banner-caption {
    text-align: center;
    font-size: 1rem;
    position: inherit;
    padding: 1rem;
    display: flex;
    height: 64px;
    line-height: 1;
    justify-content: center;
    align-items: center;
  }

  @media screen and (max-width:500px){
    #carousel-banners .banner-caption {
      font-size: 0.9rem;
    }
  }

</style>