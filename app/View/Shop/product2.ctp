<?php
	echo $this->Session->flash();
?>
<style>
.verifying-stock {
	position: absolute;
	text-align:center;
	width: 100%;
	z-index:1000;
	font-size: 13px;padding:8px;
	background: rgba(255,255,255,0.5);
	color: #999;
}
.price {
	text-align:center;
	font-size:32px;
	font-family: 'Poppins', Verdana, Arial, sans-serif;
	margin:0px auto 25px;
	color: #ff4665;
}
.antes-str {
	color: #999;
	font-size:24px;
}
.midscore{
	text-decoration:line-through;
}
</style>
        <div id="headabrigos" >
              <h1 class="name_shop"><?php echo $name_categories; ?></h1>
         <img class="img_resp"src="<?php echo Configure::read('imageUrlBase').$image_prodshop ?>"  img-responsive>
        </div>



        <section id="productOptions">
            <div class="wrapper">
                <div class="row">
                    <div class="hidden-xs hidden-sm col-sm-3">
                        <nav>
                            <ul>
                                <?php  
				                    foreach ($categories as $category) {
				                        $category = $category['Category'];
				                        echo '<li>';
				                        echo $this->Html->link(
				                            $category['name'], 
				                            array(
				                                'controller' => 'shop',
				                                'action' => 'product',
				                                intval($category['id'])
				                            )
				                        );
				                        echo '</li>';
				                    }
				                   ?>
                            </ul>
                        </nav>
                    </div>

                    <div class="col-sm-9">
                      
					<?php
						function createSection($item, $ctrl, $isProduct = false) {
							$stock = (!empty($item['stock']))?1:0;
							$content = '<img class="img-responsive"  src="'. Configure::read('imageUrlBase') . $item['img_url'] .'" />'.
								'<span class="hover">'.
									'<small>'. $item['name'] .'</small>'.
								'</span>';
							$url = array(
								'controller' => 'shop',
								intval($item['id'])
							);

							if (!empty($item['category_id'])) {
								$url[] = intval($item['category_id']);
							}

							if ($isProduct) {
								$url['action'] = 'detalle';
								$priceStr = '';
								if (!empty($item['price'])){
									$priceStr = '$ '.$ctrl->Number->currency($item['price'], 'USD', array('places' => 0));
									if (!empty((float)$item['discount']) && $item['discount']!=$item['price']){
										$priceStr = '$ '.$ctrl->Number->currency($item['discount'], 'USD', array('places' => 0)).' <span class="antes-str">Antes <span class="midscore">$ '.number_format($item['price'],2,".",",").'</span></span>';
									}
								}

							} else {
								$url['action'] = 'index';
							}

 							if(!$stock && $isProduct){
								echo '<div class="col-xs-6 col-md-4 col-sm-6" > '.
								     '<img src="'.Router::url('/').'images/agotado3.png" class="out_stock" />'.
								     $ctrl->Html->link(
									$content,
								    $url,
									array('escape' => false)
								). '<div class="price">'.$priceStr.'</div></div>';
                            }else{
								
		                        echo '<div data-id="'.$item["id"].'" class="col-xs-6 col-md-4 col-sm-6 add-no-stock"><div class="verifying-stock">Consultando stock...</div>'.
									 $ctrl->Html->link(
										$content,
										$url,
										array('escape' => false)
									). '<div class="price">'.$priceStr.'</div></div>';
							}
						}

						if (isset($products)) {
							foreach ($products as $product) {
								createSection($product['Product'], $this, true);
							}
						} else {
							foreach ($categories as $category) {
								createSection($category['Category'], $this);
							}
						}
					?>
       
		      
		
                    </div>
                    <div class="hidden-lg hidden-md visible-xs-* visible-sm-* col-sm-3" style="clear: both;">
                        <nav>
                            <ul>
                                <?php  
                                    foreach ($categories as $category) {
                                        $category = $category['Category'];
                                        echo '<li>';
                                        echo $this->Html->link(
                                            $category['name'], 
                                            array(
                                                'controller' => 'shop',
                                                'action' => 'product',
                                                intval($category['id'])
                                            )
                                        );
                                        echo '</li>';
                                    }
                                   ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <section id="infoShop">
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-4 bx1">
                        Las prendas que estan en el Shop como principal en cada rubro, no estan a la venta.
                    </div>
                    <div class="col-md-4 bx2 blr">
                        Los cambios se realizan dentro de los 30 días de efectuada la compra en cualquiera de las sucursales presentando el ticket correspondiente. 
                    </div>
                    <div class="col-md-4 bx3">
                        Las prendas deben estar sin uso y con la etiqueta de código de barras correspondiente adherida.
                    </div>
                </div>
            </div>
        </section>
<script>
window.baseUrl = "<?=Router::url('/',true)?>";
// check stock
function checkStock(i){
	var item = $(product_list[i]);
	var product_id = $(item).data('id') || $(item).attr('data-id');
	var $html = '<img src="' + baseUrl + 'images/agotado3.png" class="out_stock" />';

	 $.ajax({
        type: "GET",
        url: baseUrl + 'shop/check_stock/' + product_id, 
        processData: false,
        contentType: false,
        cache: false,
        success: function(stock){
        	if (stock=='empty'){
        		$(item).prepend($html);
        	}else{
        		console.log(product_id + ' in stock')
        	}
        	$(item).find('.verifying-stock').remove();
        },
        error: function (jqXHR, textStatus, errorThrown) {
        }
   });
}
window.product_list = new Array();
$(function(){
	$('.add-no-stock').each(function(i,item){
		product_list[i] = item;
		setTimeout(function(){
			checkStock(i);
		},500*i)
	})
})
</script>
<?php

if (!empty($category_id) && (int)$category_id == 57){
?>
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 853044157;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/853044157/?guid=ON&amp;script=0"/>
</div>
</noscript>

<?php
}

if (!empty($category_id) && (int)$category_id == 14){
?>
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 853044157;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/853044157/?guid=ON&amp;script=0"/>
</div>
</noscript>
<?php 
}
?>
