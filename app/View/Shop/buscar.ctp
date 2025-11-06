
<section id="productOptions" class="animated fadeIn">
  <div class="wrapper">
    <form name="search">
      <div class="is-flex justify-content-center align-items-center gap-05 min-h-8">
        <div class="form-group">
          <input class="form-control m-0" type="text" name="q" placeholder="Buscar en Chatelet..." value="<?= $q ?>" autofocus required>
        </div>
        <div class="form-group">
          <input type="submit" class="btn" id="enviar" value="Buscar">
        </div>
      </div>
    </form>
    <div class="row">

      <div class="col-md-9 product-list posnum-<?=@$category['Category']['posnum'] ?>">
          <div class="row">
              <?php
              foreach($results as $product):
                  $product = $product['Product'];
                  $stock = (!empty($product['stock_total']))?(int)$product['stock_total']:0;
                  $product_name =$product['name'];

                  $url = $this->Html->url(array(
                          'controller' => 'shop',
                          'action' => 'detalle',
                          $product['id'],
                          $product['category_id'],
                          strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $product['name']))),

                      )
                  );

          $number_ribbon = 0;
	if (isset($product['discount_label_show'])){
		$number_ribbon = (int)@$product['discount_label_show'];
	}
          if (isset($product['mp_discount']) && $product['mp_discount'] > $number_ribbon){
            $number_ribbon = (int) @$product['mp_discount'];
          }
          if (isset($product['bank_discount']) && $product['bank_discount'] > $number_ribbon){
            $number_ribbon = (int) @$product['bank_discount'];
          }

	$discount_flag = (@$product['category_id']!='134' && !empty($number_ribbon))?'<div class="discount-flag">'.$number_ribbon.'% OFF</div>':'';
          $promo_ribbon = (!empty($item['promo']))?'<div class="ribbon"><span>'.$item['promo'].'</span></div>':'';


              if(!$stock){ ?>
               <div class="col-sm-6 col-md-4 col-lg-3 p-1">
                  <a href="<?php echo $url ?>" >
                      <?php if (!empty(intval($product['discount_label_show']))) :?>
                          <div class="ribbon bottom-left small"><span><?= $product['discount_label_show'] ?>% OFF</span></div>
                      <?php endif ?>
                      <?php if ($product['promo'] !== '') :?>
                          <div class="ribbon"><span><?= $product['promo'] ?></span></div>
                      <?php endif ?>
                      <img src="<?php echo Router::url('/').'images/agotado3.png' ?>" class="out_stock" />
                      <div class="product-image" style="background-image: url('<?php echo Configure::read('uploadUrl') . $product['img_url'] ?>')" alt=""></div>
                      <div class="product-info">
                          <!--h3 class="article-related-title"><?php echo $product['name'] ?></h3-->
                          <div class="name" origin="3"><?= $product_name ?></div>
                          <div class="price-list"><?= \price_format(ceil($product['price'])) ?></div>
                      </div>
                  </a>
              </div>
              <?php }else{ ?>

              <div data-id="<?=$product['id']?>" class="col-sm-12 col-md-4 col-lg-3 add-no-stock">
                <a href="<?php echo $url ?>">
                    <div class="ribbon-container">
<?php 
$number_ribbon = 0;

if (isset($product['discount_label_show'])){
$number_ribbon = (int) @$product['discount_label_show'];
}
if (isset($product['mp_discount']) && $product['mp_discount'] > $number_ribbon){
$number_ribbon = (int) @$product['mp_discount'];
}
if (isset($product['bank_discount']) && $product['bank_discount'] > $number_ribbon){
$number_ribbon = (int) @$product['bank_discount'];
}
?><?php 
                    if (!empty($number_ribbon)) :?>
                        <div class="ribbon top-left small sp1"><span><?= $number_ribbon ?>% OFF</span></div>
                    <?php endif ?>
                    <?php if ($product['promo'] !== '') :?>
                        <div class="ribbon"><span><?= $product['promo'] ?></span></div>
                    <?php endif ?>
                    <div class="product-image posnum-<?= $category['Category']['posnum'] ?>" style="background-image: url('<?php echo Configure::read('uploadUrl') . $product['img_url'] ?>')" alt=""></div>
                    </div>
                    <div class="product-info">
                        <!--h3 class="article-related-title"><?php echo $product['name'] ?></h3-->
                        <div class="name" origin="4"><?= $product_name ?></div>
                        <?= $this->App->show_prices_dues($legends, $product) ?>
                    </div>
                </a>
            </div>
           <?php }endforeach; ?>
        </div>
      </div>
      <div class="col-md-3">
      <?php
          $slug =  str_replace(' ','-',strtolower($category['Category']['name']));
            if (strpos($slug, 'trajes')!==false){
              $slug = 'trajes-de-bano';
            }

      ?>
          <a href="<?php echo router::url(array('controller' => 'tienda', 'action' => 'productos',
                           $slug)) ?>" class="btBig">
            volver <br>
             al  <span>SHOP</span>
          </a>
      </div>

    </div>
  </div>
</section>