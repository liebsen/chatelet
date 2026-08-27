    <div class="wrapper-fluid">
      <div class="row m-0">
        <div class="col-xs-12">
          <div class="row category-item-container">
          <?php foreach($categories as $category): ?>
            <div class="category-item p-1 col-xs-12 col-md-<?= !empty($category['Category']['colsize']) ? $category['Category']['colsize'] : 'auto' ?>">
              <div class="category-content posnum-<?= !empty($category['Category']['posnum']) ? $category['Category']['posnum'] : 'auto' ?>" style="background-image: url('<?php echo $settings['upload_url'].$category['Category']['img_url']?>')">
                <a href="<?php echo $this->Html->url(array('controller' => 'tienda', 'action' => 'productos', str_replace(array('ñ',' '),array('n','-'),strtolower($category['Category']['name'])))); ?>" class="pd1 text-center">
                  <div class="category-image ci-<?= !empty($category['Category']['alignnum']) ? $category['Category']['alignnum'] : '0' ?> p-3 w-100">  
                  	<?php if($category['Category']['alternate_toggle'] == '1'):?>
                    <span class="p-1 text-catalog" style="color: <?=$category['Category']['text_color'] ?? 'white'?>">
                      <span class="text-uppercase"><?=$category['Category']['name']?></span>
                      <span class="p-1 p-catalog" style="font-size: <?=$category['Category']['text_size'] ?? '12'?>px; font-weight: <?=$category['Category']['text_weight'] ?? '300'?>"><?=$category['Category']['text']?></span>
                    </span>
                  <?php endif ?>
                  </div>
                </a>
              </div>
            </div>
          <?php endforeach ?>
          </div>
        </div>
      </div>
    </div>