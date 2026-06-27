<div class="animated shop-options">
  <div class="wrapper">
    <div class="row" data-toggle="mouseleave" data-target=".shop-options" data-animation="slideOutUp">
      <?php if(!empty($settings['image_menushop'])): ?>
      <img class="pull-left" src="<?php echo $settings['upload_url'].$settings['image_menushop']?>">
      <?php endif ?>
      <div class="">
        <!--h3>Shop</h3-->
        <ul>
          <?php
          if (!empty($categories)){
            foreach ($categories as $item) {
              $item = $item['Category'];
              $slug =  str_replace(' ','-',strtolower($item['name']));
              $current = '';

              if (@$category['id'] == $item['id']){
                $current = 'active';
              }

              if (strpos($slug, 'trajes')!==false){
                $slug = 'trajes-de-bano';
              }
              echo '<li>';
              echo $this->Html->link(
                  $item['name'],
                  array(
                    'controller' => 'tienda',
                    'action' => 'productos',
                    $slug
                  ),
                  array('class' => $current)
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