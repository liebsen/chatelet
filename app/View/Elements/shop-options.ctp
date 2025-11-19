<div class="animated shop-options">
  <div class="wrapper">
    <div class="row" data-toggle="mouseleave" data-target=".shop-options" data-animation="slideOutUp">
      <?php if(!empty($settings['image_menushop'])): ?>
      <img class="pull-left" src="<?php echo Configure::read('uploadUrl').$settings['image_menushop']?>">
      <?php endif ?>
      <div class="">
        <!--h3>Shop</h3-->
        <ul>
          <?php
          if (!empty($categories)){
            foreach ($categories as $category) {
              $category = $category['Category'];
              $slug =  str_replace(' ','-',strtolower($category['name']));
              if (strpos($slug, 'trajes')!==false){
                $slug = 'trajes-de-bano';
              }
              echo '<li>';
              echo $this->Html->link(
                  $category['name'],
                  array(
                      'controller' => 'tienda',
                      'action' => 'productos',
                     $slug
                  )
              );
              echo '</li>';
            }
            }
          ?>
        </ul>
      </div>
    </div>
  </div>
</div>